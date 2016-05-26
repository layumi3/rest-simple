<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Login extends REST_Controller {

	public function __construct() {
		parent::__construct();
	}

	function login_post()
	{
        $this->load->model('m_user');        

        $username = $this->post('username');
        $password = md5($this->post('password'));
        
	    $login_status = $this->m_user->get_validation($username,$password);
		if($login_status==false){
			$this->result->status = RESPONSE_STATUS_ERROR;
			$this->result->message = ERROR_CODE_DATA_NOT_FOUND;
			$this->response($this->result, 200);
		}

		$this->result->status = RESPONSE_STATUS_SUCCESS;
		$this->result->message = "Berhasil login";
		$this->result->data = $login_status;
		$this->response($this->result, 200);

	}

	function logout_get()
    {
        $this->result->status = RESPONSE_STATUS_SUCCESS;
        return $this->response($this->result, 200);
    }
}