<?php

class M_order extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	function get_order(){
		$sql="select * from tb_order";
		$query = $this->db->query($sql);
		return $query->result();    	
	}
}
	