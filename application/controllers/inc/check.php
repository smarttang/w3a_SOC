<?php

class Check extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('login');
		$this->load->helper('url');
		$this->load->library('session');
	}

	function login_in(){
		$result=$this->login->check_account($_POST['username'],$_POST['password']);
		if($result)
		{
			foreach($result as $row){
				if(isset($row['useranme']) && isset($row['password']))
				{
					//$data['username']=$row['useranme'];
					//$data['password']=$row['password'];
					//$this->load->view('',$data);
					$username=$row['useranme'];
					$this->session->set_userdata('username',$username);
					redirect('Admin/admin_index','refresh');
				}
			}
		}else{
			
			redirect('/login','location');
		}
	} 

}
