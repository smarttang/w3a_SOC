<?php

class Login extends CI_Model{
	function __construct()
	{
		$this->load->database();
		$this->load->helper('url');
	}

	function check_account($username,$password)
	{
		$sql="select * from w3a_user where useranme=? and password=?";
		$query=$this->db->query($sql,array($username,$password));
		return $query->result_array();
	}
}
?>
