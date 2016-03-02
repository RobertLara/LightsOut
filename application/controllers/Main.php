<?php

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');   //Pre-carrega dels models
        $this->load->model('lightout_model');
    }

    public function index()
    {
        $data['js_to_load'] = array('home.js', 'game.js');  //Llibreries JS a utilitzar

        //Obtenció de les dades
        $data['getGames'] = $this->lightout_model->getGames();
        $data['getRankingMoves'] = $this->lightout_model->getRankingMoves();
        $data['getRankingTime'] = $this->lightout_model->getRankingTime();

        //En cas d'estar logat obté les dades personals
        if ($this->session->userdata('logged_in')) {
            $id_user = $this->session->userdata['id_user'];
            $data['getUserRankingTime'] = $this->lightout_model->getUserRankingTime($id_user);
            $data['getUserRankingMoves'] = $this->lightout_model->getUserRankingMoves($id_user);
        }

        //Carrga la vista
        $this->load->helper('url');
        $this->load->view('tpl/header');
        $this->load->view('tpl/headerNavbar');
        $this->load->view('tpl/modalGame');
        $this->load->view('home/index', $data);
        $this->load->view('tpl/footer');

    }

    public function login()
    {
        $username = $this->input->post('username'); //Obté les dades del formulari
        $password = md5($this->input->post('password'));    //Obté les dades del formulari

        $result = $this->user_model->login($username, $password);   //Comprova si el login es correcte
        if ($result)
            $this->index();
        else {
            $data['msg'] = 'Error de credencials';
            $this->index();
        }
    }

    public function register()
    {
        //Carrega les vista del registre
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
        $newdata = array(   //Noves dades per a la sessio
            'user_id' => '',
            'username' => '',
            'logged_in' => FALSE,
        );

        $this->session->unset_userdata($newdata);   //Afegim les noves dades
        $this->session->sess_destroy(); //Eliminem la sessió (Asegurem el procés)
        redirect(base_url());   //Torna a inici
    }

    public function dashboard()
    {

        //Accés només per a usuaris administradors
        if ($this->session->userdata('role') != 1) {
            header('Location: ../error/e403');  //En cas d'error pagina 403
            exit();
        }
        //Obté tots els usuaris no administradors
        $data['users'] = $this->user_model->getAllUser();

        $data['js_to_load'] = 'dashboard.js';   //Llibreria JS

        //Carrega la vista
        $this->load->helper('url');
        $this->load->view('tpl/header');
        $this->load->view('tpl/headerNavbar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('tpl/footer');

    }

    public function deleteUser()
    {

        //Accés només per administradors
        if ($this->session->userdata('role') != 1) {
            header('Location: ../error/e403'); //Pagina d'error 403
            exit();
        }

        //En cas d'estar indicar el id d'usuari es pot borrar
        if (isset($_POST['id_user'])) {
            $this->user_model->deleteUser($this->input->post('id_user'));
        }

        header('Location: ../main/dashboard');  //Retorna al Dashboard

    }

    public function deleteMyAccount()   //Elimina el compte del propi usuari
    {
        if ($this->session->userdata('logged_in')) {    //Només usuaris logats

            if ($this->session->userdata('role') != 1) {    //Els comptes administradors no es poden esborrar

                $id_user = $this->session->userdata['id_user']; //Obtenció de l'id d'usuari
                $this->user_model->deleteUser($id_user);    //Elimina el compte
                $this->session->sess_destroy(); //Elimina les dades de sessió
                echo json_encode(array('response' => "Compte eliminat"));   //Missatge en cas d'exit
            } else {
                echo json_encode(array('response' => "Ets l'administrador"));   //Missatge en cas de ser administrador
            }
        } else {    //En cas de no estar registrat
            echo json_encode(array('response' => "No esta registrat")); //Missatge en cas de no estar logat
        }
    }

}

?>
