<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Admin extends REST_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index_get()
	{
		$this->load->view('welcome_message');
	}

	/*TODO: error on lib rest_controller*/
	function driver_get(){
		$this->load->model('m_driver');
		$model=$this->m_driver;
		$result = $model->get_driver();
		$this->result->status = RESPONSE_STATUS_SUCCESS;
		$this->result->data = $result;
		$this->response($this->result, 200);
	}

	function findDriver_post(){
		$this->load->model('m_driver');
		$model=$this->m_driver;
		$id_driver=1;
		$driver_params = array(
                'nama_driver' => $this->post('nama_driver'),
                'no_sim' => $this->post('no_sim'),
                'alamat' => $this->post('alamat'),
                'handphone' => $this->post('handphone')
            );
		$model->update($id_driver,$driver_params);
		$this->db->trans_complete();
		$result = $model->get_driver_detail($id_driver);
		$this->result->status = RESPONSE_STATUS_SUCCESS;
		$this->result->data = $result;
		$this->response($this->result, 200);
	}


	function detailDriver_get(){
		$this->load->model('m_driver');
		$model=$this->m_driver;
		$id_driver=$this->get('id_driver');
		$result = $model->get_driver_detail($id_driver);

		$this->result->status = RESPONSE_STATUS_SUCCESS;
		$this->result->data = $result;
		$this->response($this->result, 200);
	}


	function deleteDriver_get(){
		$this->load->model('m_driver');
		$id_driver=$this->post('id_driver');

		$this->m_driver->delete($id_driver);

		$this->db->trans_complete();
		$this->result->status = RESPONSE_STATUS_SUCCESS;
		$this->response($this->result, 200);	

	}

	function posisi_get(){
		$this->load->model('m_posisi');
		$model=$this->m_posisi;
		$result = $model->get_position();
		$this->result->status = RESPONSE_STATUS_SUCCESS;
		$this->result->data = $result;
		$this->response($this->result, 200);
	}

	function peminjam_get(){
		$this->load->model('m_peminjam');
		$model=$this->m_peminjam;
		$result = $model->get_borrower();
		$this->result->status = RESPONSE_STATUS_SUCCESS;
		$this->result->data = $result;
		$this->response($this->result, 200);
	}

	function order_get(){
		$this->load->model('m_order');
		$model=$this->m_order;
		$result = $model->get_order();
		$this->result->status = RESPONSE_STATUS_SUCCESS;
		$this->result->data = $result;
		$this->response($this->result, 200);
	}


}
