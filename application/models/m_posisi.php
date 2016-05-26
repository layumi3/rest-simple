<?php

class M_posisi extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	function get_position(){
		$sql="select * from tb_posisi";
		$query = $this->db->query($sql);
		// log_message('debug', $this->db->last_query());
		return $query->result();    	
	}
}
	