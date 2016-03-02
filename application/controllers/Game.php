<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Game extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('lightout_model');   //Pre-carrega del model
    }

	public function index()
	{
        if($this->session->userdata('logged_in')==false){   //Si l'usuari no esta logat no pot accedir
            header('Location: ./error/e403');   //Missatge d'error
            exit();
        }
        $id_user = $this->session->userdata['id_user']; //Obtenció id usuari
        $data['js_to_load']='game.js';  //Llibreria JS necessaria
        //Obtenció de dades
        $data['getGames'] = $this->lightout_model->getGames();
        $data['getUserRankingTime'] = $this->lightout_model->getUserRankingTime($id_user);
        $data['getUserRankingMoves'] = $this->lightout_model->getUserRankingMoves($id_user);

        //Carrega de les vistes
        $this->load->helper('url');
        $this->load->view('tpl/header');
        $this->load->view('tpl/headerNavbar');
        $this->load->view('tpl/modalGame');
        $this->load->view('game/index',$data);
        $this->load->view('tpl/footer');
	}
	
	public function getGame($level = null){

        if($level==null){   //Si el nivell no esta indicat retorna error
            echo json_encode(array('error'=>"level not set",'level'=>null));
        }else{
            if($this->session->userdata('logged_in')){  //Per als usuaris regsitrats
                $id_user = $this->session->userdata['id_user'];
                $tmp = $this->lightout_model->getGameTmp($id_user,$level);  //Comprova si hi ha alguna partida desada

                if($tmp==false){
                    echo json_encode(array('id'=>$level,'level'=>$this->lightout_model->getGame($level)));
                }else{
                    echo json_encode(array('save'=>$tmp,'level'=>$this->lightout_model->getGame($level)));
                }

            }else{  //En cas de no estar registrat
                echo json_encode(array('id'=>$level,'level'=>$this->lightout_model->getGame($level)));
            }

        }
    }

    public function saveRecord($level,$time,$moves){    //Guarda el record d'una aprtida
        if($this->session->userdata('logged_in')){  //En cas d'usuaris registrats
            $time = "00:".$time;    //Estructura del temps
            $id_user = $this->session->userdata['id_user'];
            if($this->lightout_model->saveRecord($id_user,$level,$time,$moves)){
                echo json_encode(array('response'=>"Enhorabona!! Has fet un nou record!!"));    //En cas de nou record
            }else{
                echo json_encode(array('response'=>"No has fet record."));  //En cas de no haver fet record
            }

        }else{  //En cas de no estar registras
            echo json_encode(array('response'=>"No t'has regsitrat. El record no sera guardat"));
        }
    }

    public function saveLevel($structure){
        if ($this->session->userdata('role') != 1) {    //En cas de no ser administrador
            header('Location: ../error/e403');  //Error 403
            exit();
        }

        if($this->session->userdata('role')==1){
            if($this->lightout_model->saveLevel($structure)){
                echo json_encode(array('response'=>"Nivell desat amb exit"));   //En cas d'exit
            }else{
                echo json_encode(array('response'=>"Nivell no desat")); //En cas d'error
            }

        }else{
            echo json_encode(array('response'=>"No tens permisos. Com has arribat aqui?"));
        }
    }

    public function getRankings(){  //Obté tots els rankins  globals
        $data['getGames'] = $this->lightout_model->getGames();
        $data['getRankingMoves'] = $this->lightout_model->getRankingMoves();
        $data['getRankingTime'] = $this->lightout_model->getRankingTime();
        echo json_encode($data);
    }

    public function getUserRankings(){  //Obté els rankings del usuari
        if($this->session->userdata('logged_in')){  //Comprovem que estigui logat
            $id_user = $this->session->userdata['id_user']; //Obtenim l'id de l'usuari
            $data['getUserRankingTime'] = $this->lightout_model->getUserRankingTime($id_user);
            $data['getUserRankingMoves'] = $this->lightout_model->getUserRankingMoves($id_user);
            echo json_encode($data);
        }else{
            echo json_encode(array('response'=>"KO"));  //En de no estar logat
        }

    }

    function getGameTmp($level){
        if($this->session->userdata('logged_in')){  //En cas de estar logat
            $id_user = $this->session->userdata['id_user']; //Obté l'id de l'usuari
            $response = $this->lightout_model->getGameTmp($id_user,$level); //Comproven si existeix una partida desada
            if($response!==false){
                echo json_encode($response);    //Retorna la partida desada
                $this->lightout_model->deleteGameTmp($id_user,$level);  //Elimina la partida temporal
            }else{
                echo json_encode(array('response'=>"No s'ha trobat la partida"));   //En cas de no trobar la partida
            }
        }else{  //En cas de usuaris no registrats
            echo json_encode(array('response'=>"No t'has regsitrat. No s'ha pogut trobar la partida"));
        }
    }

    function saveGameTmp($level,$structure,$time,$clicks){  //Desa una partida temporal
        if($this->session->userdata('logged_in')){  //En cas d'usuaris logat
            $id_user = $this->session->userdata['id_user']; //Obté l'id de l'usuari
            $time = "00:".$time;    //Format de temps
            if($this->lightout_model->saveGameTmp($id_user,$level,$structure,$time,$clicks)){
                echo json_encode(array('response'=>"Partida desada"));  //En cas de partida desada
            }else{
                echo json_encode(array('response'=>"No s'ha desat la partida"));    //En cas d'error
            }
        }else{  //En cas de usuaris no registras
            echo json_encode(array('response'=>"No t'has regsitrat. No s'ha pogut desar la partida"));
        }


    }
	
}
