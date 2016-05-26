<?php

class M_driver extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	function get_driver(){
		$sql="select * from tb_driver";
		$query = $this->db->query($sql);
		// log_message('debug', $this->db->last_query());
		return $query->result();    	
	}

	function get_driver_detail($id_driver){
		$sql="select * from tb_driver where id_driver= '$id_driver'";
		$query = $this->db->query($sql);
		log_message('debug', $this->db->last_query());
		return $query->row();    		
	}

	function update($id_driver,$driver_params){
		$this->db->where('id_driver', $id_driver);
        $this->db->update('tb_driver', $driver_params);
        if (false) {
        	log_message('debug', $this->db->last_query());
        	return false;
        }
		log_message('debug', $this->db->last_query());
        return TRUE;
	}

	function delete($id_driver){
		$this->db->where('id_driver', $id_driver);
		$this->db->delete('tb_driver');
		if (false) {
        	log_message('debug', $this->db->last_query());
        	return false;
        }
		log_message('debug', $this->db->last_query());
        return TRUE;	
	}
}
	