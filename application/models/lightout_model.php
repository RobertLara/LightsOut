<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LightOut_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRankingTime()
    {
        $return = array();
        $nGames = $this->getGames();

        for ($i = 0; $i < $nGames; $i++) {
            $this->db->select('username , ranking.id_level, min(time) as time');
            $this->db->from('ranking');
            $this->db->join('levels', 'levels.id_level=ranking.id_level');
            $this->db->join('users', 'ranking.id_user=users.id_user');
            $this->db->where('ranking.id_level', ($i + 1));
            $this->db->group_by("ranking.id_level");
            $response = $this->db->get()->result();

            if ($response == array()) {
                $record = new stdClass;
                $record->username = null;
                $record->id_level = strval($i + 1);
                $record->time = null;
                array_push($return, $record);
            } else {
                array_push($return, $response[0]);
            }
        }
        return $return;

    }

    public function getRankingMoves()
    {
        $return = array();
        $nGames = $this->getGames();

        for ($i = 0; $i < $nGames; $i++) {
            $this->db->select('username , ranking.id_level, min(clicks) as moves');
            $this->db->from('ranking');
            $this->db->join('levels', 'levels.id_level=ranking.id_level');
            $this->db->join('users', 'ranking.id_user=users.id_user');
            $this->db->where('ranking.id_level', ($i + 1));
            $this->db->group_by("ranking.id_level");
            $response = $this->db->get()->result();

            if ($response == array()) {
                $record = new stdClass;
                $record->username = null;
                $record->id_level = strval($i + 1);
                $record->moves = 0;
                array_push($return, $record);
            } else {
                array_push($return, $response[0]);
            }
        }

        return $return;
    }

    public function getUserRankingTime($id_user)
    {
        $return = array();
        $nGames = $this->getGames();

        for ($i = 0; $i < $nGames; $i++) {
            $this->db->select('username , ranking.id_level, min(time) as time');
            $this->db->from('ranking');
            $this->db->join('levels', 'levels.id_level=ranking.id_level');
            $this->db->join('users', 'ranking.id_user=users.id_user');
            $this->db->where('ranking.id_user', $id_user);
            $this->db->where('ranking.id_level', ($i + 1));
            $this->db->group_by("ranking.id_level");
            $response = $this->db->get()->result();

            if ($response == array()) {
                $record = new stdClass;
                $record->username = null;
                $record->id_level = strval($i + 1);
                $record->time = null;
                array_push($return, $record);
            } else {
                array_push($return, $response[0]);
            }
        }
        return $return;

    }

    public function getUserRankingMoves($id_user)
    {
        $return = array();
        $nGames = $this->getGames();

        for ($i = 0; $i < $nGames; $i++) {
            $this->db->select('username , ranking.id_level, min(clicks) as moves');
            $this->db->from('ranking');
            $this->db->join('levels', 'levels.id_level=ranking.id_level');
            $this->db->join('users', 'ranking.id_user=users.id_user');
            $this->db->where('ranking.id_user', $id_user);
            $this->db->where('ranking.id_level', ($i + 1));
            $this->db->group_by("ranking.id_level");
            $response = $this->db->get()->result();

            if ($response == array()) {
                $record = new stdClass;
                $record->username = null;
                $record->id_level = strval($i + 1);
                $record->moves = null;
                array_push($return, $record);
            } else {
                array_push($return, $response[0]);
            }
        }
        return $return;

    }

    public function getGames()
    {
        return $this->db->count_all('levels');
    }

    public function getGame($level)
    {
        $this->db->select('level');
        $this->db->from('levels');
        $this->db->where('id_level', $level);
        $response = $this->db->get()->result();
        if (isset($response[0]->level)) {
            return $response[0]->level;
        } else {
            return false;
        }

    }

    public function saveRecord($id_user, $level, $time, $clicks)
    {
        if($this->getGameTmp($id_user,$level)!==false){
            $this->deleteGameTmp($id_user,$level);
        }

        $this->db->select('min(time) as time, min(clicks) as moves');
        $this->db->from('ranking');
        $this->db->where('id_user', $id_user);
        $this->db->where('id_level', $level);
        $response = $this->db->get()->result();
        if (isset($response[0])) {
            if ($response[0]->moves <= $clicks && $response[0]->time <= $time && $response[0]->time != null && $response[0]->moves != null) {
                return false;
            }
        }

        $data = array(
            'id_user' => $id_user,
            'id_level' => $level,
            'time' => $time,
            'clicks' => $clicks
        );

        $this->db->insert('ranking', $data);
        $num_inserts = $this->db->affected_rows();

        return ($num_inserts == 1) ? true : false;

    }

    public function makeGame($board)
    {
        $data = array(
            'level' => $board,
        );

        $this->db->insert('levels', $data);
        $num_inserts = $this->db->affected_rows();

        return ($num_inserts == 1) ? true : false;

    }


    public function saveLevel($structure)
    {
        $data = array(
            'level' => $structure
        );

        $this->db->insert('levels', $data);
        $affected = $this->db->affected_rows();

        return ($affected == 1) ? true : false;

    }

    public function saveGameTmp($id_user, $level,$structure,$time,$clicks){

        $data = array(
            'id_level' => $level,
            'id_user' => $id_user,
            'status' => $structure,
            'time' => $time,
            'clicks' => $clicks
        );

        $this->db->insert('tmp_level', $data);
        $affected = $this->db->affected_rows();

        return ($affected == 1) ? true : false;

    }

    public function deleteGameTmp($id_user,$level){
        $this->db->delete('tmp_level', array('id_user' => $id_user,'id_level'=>$level));
        $affected = $this->db->affected_rows();

        return ($affected == 1) ? true : false;

    }

    public function getGameTmp($id_user,$level){
        $this->db->select('status, time, clicks');
        $this->db->from('tmp_level');
        $this->db->where('id_level', $level);
        $this->db->where('id_user', $id_user);
        $response = $this->db->get()->result();
        var_dump($response);

        if (isset($response[0])) {
            return $response[0];
        } else {
            return false;
        }
    }

}
