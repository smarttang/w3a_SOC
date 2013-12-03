<?php

/************************
*
*	用户管理
*	2013/8/20
*
*************************/
class User_index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('page_smart');
		$this->load->model('Admin/user_index_data');
		$this->load->helper('url');
                $session=$this->session->userdata('username');
                //如果没有登录,则跳转退出
                if(!$session){
                        redirect('/login','location');
                }
	}
	/****************************
	*	查询类函数
	*
	****************************/	
	//用户列表
	function user_list($page="")
	{
                $config['page']=$page;
                $config['rows']=$this->user_index_data->select_user_sum();
		$config['base_url']=site_url('Admin/user_index/user_list');
                $page_rst=$this->page_smart->page_do($config);
                $data['user_list']=$this->user_index_data->select_user($page_rst['select_from'],$page_rst['select_limit']);
                $data['page_list']=$page_rst['pagenav'];
		$this->load->view('AdminLogin/user_index/user_list',$data);
	}

	//角色列表
	function role_list($page="")
	{
                $config['page']=$page;
                $config['rows']=$this->user_index_data->select_role_sum();
		$config['base_url']=site_url('Admin/user_index/role_list');
                $page_rst=$this->page_smart->page_do($config);
		$data['role_list']=$this->user_index_data->select_role($page_rst['select_from'],$page_rst['select_limit']);
		$data['page_list']=$page_rst['pagenav'];
		$this->load->view('AdminLogin/user_index/role_list',$data);
	}
	/****************************
	*	操作类函数
	*
	****************************/
	//用户添加页面访问
	function user_add()
	{
		$this->load->view('AdminLogin/user_index/user_add');
	}
	
	//新用户数据插入
	function user_insert()
	{
		$data=$this->user_index_data->user_add(
							$_POST['purview'],
							$_POST['username'],
							$_POST['password'],
							$_POST['name'],
							$_POST['email'],
							$_POST['mobile-phone']
						       );
		if($data){
			redirect('/Admin/user_index/user_list','location');
		}
	}

	//用户角色添加页面访问
	function role_add()
	{
		$this->load->view('AdminLogin/user_index/role_add');
	}

	//新角色数据插入
	function role_insert()
	{
		$data=$this->user_index_data->role_add($_POST['role_name']);
		if($data){
			redirect('/Admin/user_index/role_list','location');
		}
	}

	//删除用户数据
	function user_del($id){
		$result=$this->user_index_data->user_del($id);
		if($result){
			redirect('/Admin/user_index/user_list','location');
		}
	}

	//删除角色数据
	function role_del($id){
		$result=$this->user_index_data->role_del($id);
		if($result){
			redirect('Admin/user_index/role_list','localtion');
		}
	}

}

?>
