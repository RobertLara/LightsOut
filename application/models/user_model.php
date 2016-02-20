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
                //add all data to session
                $newdata = array(
                    'id_user' => $rows->id_user,
                    'username' => $rows->username,
                    'logged_in' => TRUE,
                    'role' => $rows->role
                );
            }
            $this->session->set_userdata($newdata);
            return true;
        }
        return false;
    }

    public function register()
    {
        $data = array(
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password')),
            'role' => 0
        );
        $this->db->insert('users', $data);
        $num_inserts = $this->db->affected_rows();
        return ($num_inserts == 1) ? true : false;
    }

    public function userExists($username)
    {
        $this->db->where("username", $username);
        $query = $this->db->get("users");

        return ($query->num_rows()==1)?true:false;

    }

    public function deleteUser($user)
    {

        $this->db->delete('users', array('id_user' => $user));
        return true;

    }

    public function getAllUser()
    {

        $this->db->select('id_user , username');
        $this->db->from('users');
        $this->db->where('role', 0);
        $response = $this->db->get()->result();

        return $response;

    }

}

?>