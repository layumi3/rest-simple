<?php

class M_peminjam extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}

	function get_borrower(){
		$sql="select * from tb_peminjam";
		$query = $this->db->query($sql);
		return $query->result();    	
	}
}
	