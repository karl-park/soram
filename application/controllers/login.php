<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('m_session');
        $this->yield                    = FALSE;
    }

	public function index() {
		$this->load->view('test/test_signin');
	}
}
