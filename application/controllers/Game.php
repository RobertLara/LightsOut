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
            echo json_encode(array('level'=>$this->lightout_model->getGame($level)));
        }
    }

    public function saveRecord($level,$time,$moves){
        if($this->session->userdata('logged_in')){
            $id_user = $this->session->userdata['id_user'];
            $this->lightout_model->saveRecord($id_user,$level,$time,$moves);
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
	
}
