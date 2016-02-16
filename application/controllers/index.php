<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function inicio()
	{
		$this->load->view('index');
	}
	
	public function login(){
		$this->load->view('login');
	}
	
}
