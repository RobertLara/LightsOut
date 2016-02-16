<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('errors/html/error_404');
    }

    public function e404()
    {
        $this->load->helper('url');
        $this->load->view('errors/html/error_404');
    }

    public function e403()
    {
        $this->load->helper('url');
        $this->load->view('errors/html/error_403');
    }

}
