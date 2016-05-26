<?php

class M_user extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	function get_validation($username, $password){
		$sql="select * from tb_user where username='$username' and password = '$password'" ;
		$query = $this->db->query($sql);
		return $query->row();
		/*if($ketemu>0){
			return 1;
		}
		else{
			return 0;
		}*/
		/*
		if ($query->row()===false) {
			log_message('error', $this->db->_error_message());
			return false;
		}
		log_message('debug', $this->db->last_query());
		return $query->row();   
*/
	}
}