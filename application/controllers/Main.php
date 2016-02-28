<?php

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('lightout_model');
    }

    public function index()
    {
        $data['js_to_load'] = array('home.js', 'game.js');
        $data['getGames'] = $this->lightout_model->getGames();
        $data['getRankingMoves'] = $this->lightout_model->getRankingMoves();
        $data['getRankingTime'] = $this->lightout_model->getRankingTime();

        if ($this->session->userdata('logged_in')) {
            $id_user = $this->session->userdata['id_user'];
            $data['getUserRankingTime'] = $this->lightout_model->getUserRankingTime($id_user);
            $data['getUserRankingMoves'] = $this->lightout_model->getUserRankingMoves($id_user);
        }

        $this->load->helper('url');
        $this->load->view('tpl/header');
        $this->load->view('tpl/headerNavbar');
        $this->load->view('tpl/modalGame');
        $this->load->view('home/index', $data);
        $this->load->view('tpl/footer');

    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $result = $this->user_model->login($username, $password);
        if ($result)
            $this->index();
        else {
            $data['msg'] = 'Error de credencials';
            $this->index();
        }
    }

    public function register()
    {
        $this->load->helper('url');
        $this->load->view('tpl/header');

        $this->load->view('register/index');
        $this->load->view('tpl/footer');
    }

    public function registration()
    {
        if (strlen($this->input->post('username')) < 3 || strlen($this->input->post('password')) < 4) {
            $this->register();
        } else {
            if ($this->user_model->userExists($this->input->post('username')) == 0) {

                if ($this->session->userdata('logged_in') && $this->session->userdata('role') == 1) {

                    $this->user_model->register();
                    $this->dashboard();

                } else {

                    if ($this->user_model->register()) {
                        $this->index();
                    } else {
                        $this->register();
                    }

                }
            } else {
                $this->register();
            }

        }

    }

    public function logout()
    {
        $newdata = array(
            'user_id' => '',
            'username' => '',
            'logged_in' => FALSE,
        );
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function dashboard()
    {

        if ($this->session->userdata('role') != 1) {
            header('Location: ../error/e403');
            exit();
        }
        $data['users'] = $this->user_model->getAllUser();

        $data['js_to_load'] = 'dashboard.js';
        $this->load->helper('url');
        $this->load->view('tpl/header');
        $this->load->view('tpl/headerNavbar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('tpl/footer');

    }

    public function deleteUser()
    {

        if ($this->session->userdata('role') != 1) {
            header('Location: ../error/e403');
            exit();
        }

        if (isset($_POST['id_user'])) {
            $this->user_model->deleteUser($_POST['id_user']);
        }

        header('Location: ../main/dashboard');

    }


    public function deleteMyAccount()
    {
        if ($this->session->userdata('logged_in')) {
            if ($this->session->userdata('role') != 1) {
                $id_user = $this->session->userdata['id_user'];
                $this->user_model->deleteUser($id_user);
                $this->session->sess_destroy();
                echo json_encode(array('response' => "Compte eliminat"));
            } else {
                echo json_encode(array('response' => "Ets l'administrador"));
            }
        } else {
            echo json_encode(array('response' => "No esta registrat"));
        }
    }

}

?>
