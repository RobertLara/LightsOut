<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LightOut_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRankingTime()    //Obtencio del ranking per temps
    {
        $return = array();
        $nGames = $this->getGames();

        for ($i = 0; $i < $nGames; $i++) {

            //Obtencio del valor minim de temps
            $this->db->select('min(time) as time');
            $this->db->from('ranking');
            $this->db->where('id_level', ($i + 1));
            $this->db->limit(1);
            $response = $this->db->get()->result();
            if($response == array()){
                $time = -1;
            }else{
                $time = $response[0]->time;
            }

            //Consulta SQL
            $this->db->select('username , ranking.id_level, min(time) as time');
            $this->db->from('ranking');
            $this->db->join('levels', 'levels.id_level=ranking.id_level');
            $this->db->join('users', 'ranking.id_user=users.id_user');
            $this->db->where('ranking.id_level', ($i + 1));
            $this->db->where('ranking.time', $time);
            $response = $this->db->get()->result();

            if ($response == array()) { //En cas de no haver records
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

            //Obtencio del valor minim de moviments
            $this->db->select('min(clicks) as moves');
            $this->db->from('ranking');
            $this->db->where('id_level', ($i + 1));
            $this->db->limit(1);
            $response = $this->db->get()->result();
            if($response == array()){
                $clicks = -1;
            }else{
                $clicks = $response[0]->moves;
            }

            //Consulta SQL
            $this->db->select('username , ranking.id_level, min(clicks) as moves');
            $this->db->from('ranking');
            $this->db->join('levels', 'levels.id_level=ranking.id_level');
            $this->db->join('users', 'ranking.id_user=users.id_user');
            $this->db->where('ranking.id_level', ($i + 1));
            $this->db->where('ranking.clicks', $clicks);
            $response = $this->db->get()->result();

            if ($response == array()) { //En cas de no haver records
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

    public function getUserRankingTime($id_user)    //Retorn el record de temps del usuari
    {
        $return = array();
        $nGames = $this->getGames();

        for ($i = 0; $i < $nGames; $i++) {

            //Consulta SQL
            $this->db->select('username , ranking.id_level, min(time) as time');
            $this->db->from('ranking');
            $this->db->join('levels', 'levels.id_level=ranking.id_level');
            $this->db->join('users', 'ranking.id_user=users.id_user');
            $this->db->where('ranking.id_user', $id_user);
            $this->db->where('ranking.id_level', ($i + 1));
            $this->db->group_by("ranking.id_level");
            $response = $this->db->get()->result();

            if ($response == array()) { //En cas de no haver-hi record
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

            //Consulta SQL
            $this->db->select('username , ranking.id_level, min(clicks) as moves');
            $this->db->from('ranking');
            $this->db->join('levels', 'levels.id_level=ranking.id_level');
            $this->db->join('users', 'ranking.id_user=users.id_user');
            $this->db->where('ranking.id_user', $id_user);
            $this->db->where('ranking.id_level', ($i + 1));
            $this->db->group_by("ranking.id_level");
            $response = $this->db->get()->result();

            if ($response == array()) { //En cas de no haver-hi record
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

    public function getGames()  //Retorna el nombre totals de jocs registrats a la base de dades
    {
        return $this->db->count_all('levels');
    }

    public function getGame($level) //Retorna el nivell
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

    public function saveRecord($id_user, $level, $time, $clicks)    //Guarda el record d'una partida
    {
        if($this->getGameTmp($id_user,$level)!==false){ //Comprova si existeix un temporal
            $this->deleteGameTmp($id_user,$level);  //Elimina el temporal
        }

        //Consulta que comprova si hi ha nou record
        $this->db->select('min(time) as time, min(clicks) as moves');
        $this->db->from('ranking');
        $this->db->where('id_user', $id_user);
        $this->db->where('id_level', $level);
        $response = $this->db->get()->result();
        if (isset($response[0])) {
            if ($response[0]->moves <= $clicks && $response[0]->time <= $time && $response[0]->time != null && $response[0]->moves != null) {
                return false;   //En cas de no haver-hi record
            }
        }

        $data = array(  //Dades que s'insertaran
            'id_user' => $id_user,
            'id_level' => $level,
            'time' => $time,
            'clicks' => $clicks
        );

        $this->db->insert('ranking', $data);    //Inserta les dades
        $num_inserts = $this->db->affected_rows();

        return ($num_inserts == 1) ? true : false;  //Retorna true si s'ha inserta una fila

    }


    public function saveLevel($structure)   //Guarda un nou nivell a la base de dades
    {
        $data = array(
            'level' => $structure
        );

        $this->db->insert('levels', $data); //Inserta el nivell
        $affected = $this->db->affected_rows();

        return ($affected == 1) ? true : false; //Retorna true si s'ha inserta una fila

    }

    public function saveGameTmp($id_user, $level,$structure,$time,$clicks){ //Guarda una partida temporal

        $this->deleteGameTmp($id_user,$level);

        $data = array(  //Dades que s'insertaran
            'id_level' => $level,
            'id_user' => $id_user,
            'status' => $structure,
            'time' => $time,
            'clicks' => $clicks
        );

        $this->db->insert('tmp_level', $data);  //Inserta la partida temporal
        $affected = $this->db->affected_rows();

        return ($affected == 1) ? true : false; //Retorna true si s'ha inserta una fila

    }

    public function deleteGameTmp($id_user,$level){ //Elimnia una partida temporal
        $this->db->delete('tmp_level', array('id_user' => $id_user,'id_level'=>$level));
        $affected = $this->db->affected_rows();

        return ($affected == 1) ? true : false;

    }

    public function getGameTmp($id_user,$level){    //Retorna una partida temporal guardada

        //Consulta que obté la partida
        $this->db->select('status, time, clicks');
        $this->db->from('tmp_level');
        $this->db->where('id_level', $level);
        $this->db->where('id_user', $id_user);
        $response = $this->db->get()->result();

        if (isset($response[0]->time)) {
            return array('id'=>$level ,'status'=>$response[0]->status,'time'=>$response[0]->time,'clicks'=>$response[0]->clicks);
        } else {
            return false;   //En cas de no tindre cap partida
        }
    }

}
