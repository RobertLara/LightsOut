<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function login($username, $password)
    {
        $this->db->where("username", $username);
        $this->db->where("password", $password);

        $query = $this->db->get("users");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                //dades de la sessio
                $newdata = array(
                    'id_user' => $rows->id_user,
                    'username' => $rows->username,
                    'logged_in' => TRUE,
                    'role' => $rows->role
                );
            }
            $this->session->set_userdata($newdata); //Indiquem les dades a la sessio
            return true;    //En cas de login correcte
        }
        return false;   //En cas de login incorrecte
    }

    public function register()
    {
        $data = array(  //Dades a insertar
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),  //contrasenya en MD5
            'role' => 0
        );
        $this->db->insert('users', $data);  //Inserta l'usuari
        $num_inserts = $this->db->affected_rows();
        return ($num_inserts == 1) ? true : false;  //Retorna true si l'usuari s'aha afegit correctament
    }

    public function userExists($username)   //Comproba si existeix l'usuari
    {
        $this->db->where("username", $username);
        $query = $this->db->get("users");

        return ($query->num_rows()==1)?true:false;  //Retorna true si l'usuari existeix

    }

    public function deleteUser($user)   //Elimina el usuari
    {
        $this->db->delete('users', array('id_user' => $user));
        return true;

    }

    public function getAllUser()    //Retorna la llista d'usuari
    {

        //Consulta. Obte els usuaris no administradors
        $this->db->select('id_user , username');
        $this->db->from('users');
        $this->db->where('role', 0);
        $response = $this->db->get()->result();

        return $response;

    }

}

?>