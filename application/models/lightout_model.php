<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LightOut_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRankingTime()
    {
        $nGames = $this->getGames();
        //SELECT username, ranking.id_level, min(time) FROM `ranking`, levels, users WHERE ranking.id_level=levels.id_level and ranking.id_user=users.id_user GROUP by ranking.id_level
        $this->db->select('username , ranking.id_level, min(time) as time');
        $this->db->from('ranking');
        $this->db->join('levels', 'levels.id_level=ranking.id_level');
        $this->db->join('users', 'ranking.id_user=users.id_user');
        $this->db->group_by("ranking.id_level");
        $response = $this->db->get()->result();

        while($nGames>sizeof($response)){   //En cas de no tindre resultats en tots els nivells
            $record = new stdClass;
            $record->username = null;
            $record->id_level = sizeof($response)+1;
            $record->time = null;
            array_push($response,$record);
        }

        return  $response;

    }

    public function getRankingMoves()
    {

        $nGames = $this->getGames();

        //SELECT username, ranking.id_level, min(clicks) FROM `ranking`, levels, users WHERE ranking.id_level=levels.id_level and ranking.id_user=users.id_user GROUP by ranking.id_level
        $this->db->select('username , ranking.id_level, min(clicks) as moves');
        $this->db->from('ranking');
        $this->db->join('levels', 'levels.id_level=ranking.id_level');
        $this->db->join('users', 'ranking.id_user=users.id_user');
        $this->db->group_by("ranking.id_level");
        $response = $this->db->get()->result();

        while($nGames>sizeof($response)){   //En cas de no tindre resultats en tots els nivells
            $record = new stdClass;
            $record->username = null;
            $record->id_level = sizeof($response)+1;
            $record->moves = 0;
            array_push($response,$record);
        }

        return  $response;
    }

    public function getUserRankingTime($id_user)
    {
        $nGames = $this->getGames();

        $this->db->select('username , ranking.id_level, min(time) as time');
        $this->db->from('ranking');
        $this->db->join('levels', 'levels.id_level=ranking.id_level');
        $this->db->join('users', 'ranking.id_user=users.id_user');
        $this->db->where('ranking.id_user', $id_user);
        $this->db->group_by("ranking.id_level");
        $response = $this->db->get()->result();

        while($nGames>sizeof($response)){   //En cas de no tindre resultats en tots els nivells
            $record = new stdClass;
            $record->username = null;
            $record->id_level = sizeof($response)+1;
            $record->time = null;
            array_push($response,$record);
        }

        return  $response;

    }

    public function getUserRankingMoves($id_user)
    {

        $nGames = $this->getGames();

        $this->db->select('username , ranking.id_level, min(clicks) as moves');
        $this->db->from('ranking');
        $this->db->join('levels', 'levels.id_level=ranking.id_level');
        $this->db->join('users', 'ranking.id_user=users.id_user');
        $this->db->where('ranking.id_user', $id_user);
        $this->db->group_by("ranking.id_level");
        $response = $this->db->get()->result();

        while($nGames>sizeof($response)){   //En cas de no tindre resultats en tots els nivells
            $record = new stdClass;
            $record->username = null;
            $record->id_level = sizeof($response)+1;
            $record->moves = 0;
            array_push($response,$record);
        }

        return  $response;

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
        $this->db->select('min(time) as time, min(clicks) as moves');
        $this->db->from('ranking');
        $this->db->where('id_user', $id_user);
        $this->db->where('id_level', $level);
        $response = $this->db->get()->result();
        if(isset($response[0])){
            if($response[0]->moves <= $clicks && $response[0]->time <= $time && $response[0]->time!=null && $response[0]->moves!=null){
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

        return ($num_inserts==1)?true:false;

    }

    public function makeGame($board){
        $data = array(
            'level' => $board,
        );

        $this->db->insert('levels', $data);
        $num_inserts = $this->db->affected_rows();

        return ($num_inserts==1)?true:false;

    }
}
