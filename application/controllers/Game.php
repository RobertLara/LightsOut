<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('lightout_model');
    }

	public function index()
	{
        if($this->session->userdata('logged_in')==false){
            header('Location: ./error/e403');
            exit();
        }
        $id_user = $this->session->userdata['id_user'];
        $data['js_to_load']='game.js';
        $data['getGames'] = $this->lightout_model->getGames();
        $data['getUserRankingTime'] = $this->lightout_model->getUserRankingTime($id_user);
        $data['getUserRankingMoves'] = $this->lightout_model->getUserRankingMoves($id_user);

        $this->load->helper('url');
        $this->load->view('tpl/header');
        $this->load->view('tpl/headerNavbar');
        $this->load->view('tpl/modalGame');
        $this->load->view('game/index',$data);
        $this->load->view('tpl/footer');
	}
	
	public function getGame($level = null){

        if($level==null){
            echo json_encode(array('error'=>"level not set",'level'=>null));
        }else{
            if($this->session->userdata('logged_in')){
                $id_user = $this->session->userdata['id_user'];
                $tmp = $this->lightout_model->getGameTmp($id_user,$level);

                if($tmp==false){
                    echo json_encode(array('id'=>$level,'level'=>$this->lightout_model->getGame($level)));
                }else{
                    echo json_encode(array('save'=>$tmp,'level'=>$this->lightout_model->getGame($level)));
                }


            }else{
                echo json_encode(array('id'=>$level,'level'=>$this->lightout_model->getGame($level)));
            }


        }
    }

    public function saveRecord($level,$time,$moves){
        if($this->session->userdata('logged_in')){
            $time = "00:".$time;
            $id_user = $this->session->userdata['id_user'];
            if($this->lightout_model->saveRecord($id_user,$level,$time,$moves)){
                echo json_encode(array('response'=>"Enhorabona!! Has fet un nou record!!"));
            }else{
                echo json_encode(array('response'=>"No has fet record."));
            }

        }else{
            echo json_encode(array('response'=>"No t'has regsitrat. El record no sera guardat"));
        }
    }

    public function saveLevel($structure){
        if ($this->session->userdata('role') != 1) {
            header('Location: ../error/e403');
            exit();
        }

        if($this->session->userdata('role')==1){
            if($this->lightout_model->saveLevel($structure)){
                echo json_encode(array('response'=>"Nivell desat amb exit"));
            }else{
                echo json_encode(array('response'=>"Nivell no deat"));
            }

        }else{
            echo json_encode(array('response'=>"No tens permisos. Com has arribat aqui?"));
        }
    }

    public function makeGame($board){
        if($this->session->userdata('logged_in')){
            if($this->session->userdata('role')==1){
                if($this->lightout_model->makeGame($board)){
                    echo json_encode(array('response'=>"OK"));
                    return true;
                }
            }
        }
        echo json_encode(array('response'=>"KO"));
    }

    public function getRankings(){
        $data['getGames'] = $this->lightout_model->getGames();
        $data['getRankingMoves'] = $this->lightout_model->getRankingMoves();
        $data['getRankingTime'] = $this->lightout_model->getRankingTime();
        echo json_encode($data);
    }

    public function getUserRankings(){
        if($this->session->userdata('logged_in')){
            $id_user = $this->session->userdata['id_user'];
            $data['getUserRankingTime'] = $this->lightout_model->getUserRankingTime($id_user);
            $data['getUserRankingMoves'] = $this->lightout_model->getUserRankingMoves($id_user);
            echo json_encode($data);
        }else{
            echo json_encode(array('response'=>"KO"));
        }

    }

    function getGameTmp($level){
        if($this->session->userdata('logged_in')){
            $id_user = $this->session->userdata['id_user'];
            $response = $this->lightout_model->getGameTmp($id_user,$level);
            if($response!==false){
                echo json_encode($response);
                $this->lightout_model->deleteGameTmp($id_user,$level);
            }else{
                echo json_encode(array('response'=>"No s'ha trobat la partida"));
            }
        }else{
            echo json_encode(array('response'=>"No t'has regsitrat. No s'ha pogut desar la partida"));
        }
    }

    function saveGameTmp($level,$structure,$time,$clicks){
        if($this->session->userdata('logged_in')){
            $id_user = $this->session->userdata['id_user'];
            $time = "00:".$time;
            if($this->lightout_model->saveGameTmp($id_user,$level,$structure,$time,$clicks)){
                echo json_encode(array('response'=>"Partida desada"));
            }else{
                echo json_encode(array('response'=>"No s'ha desat la partida"));
            }
        }else{
            echo json_encode(array('response'=>"No t'has regsitrat. No s'ha pogut desar la partida"));
        }


    }
	
}
