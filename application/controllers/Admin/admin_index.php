<?php

class Admin_index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Admin/admin_index_data');
		$this->load->helper('url');
		//检测SESSION
		$session=$this->session->userdata('username');
		//如果没有登录,则跳转退出
		if(!$session){
			redirect('/login','location');
		}
	}

	function index()
	{
		$data['username']=$this->session->userdata('username');
	        $this->load->view('AdminLogin/index',$data);
	}

	//右主体
	function default_body()
	{
		$web_attack_num=$this->admin_index_data->select_sum('select count(*) sum_result from w3a_log_monitor_attack');
		$net_attack_num=$this->admin_index_data->select_sum('select sum(cc) sum_result from (select count(*) cc from w3a_net_monitor_network_attack union all select count(*) from w3a_net_monitor_web_attack) t');
		if($web_attack_num==null || $net_attack_num==null){

			$data['error']="目前没有办法生成图表，请建立任务并开始监控!当有数据的情况下才会有图表.";
			$this->load->view('AdminLogin/error/error_text',$data);
		}else{

	                $data['web_attack_num']=$web_attack_num;
        	        $data['net_attack_num']=$net_attack_num;
               		$data['user_num']=$this->admin_index_data->select_row('w3a_user');
	  		$this->load->view('AdminLogin/default_main',$data);
		}
	}

	//历史数据查询(按年)	
	function select_history_any_year()
	{
		$data_year=$this->admin_index_data->select_json_year();
		echo $data_year;
	}
	
	//历史数据查询(按月)
	function select_history_any_month()
	{
		$data_month=$this->admin_index_data->select_json_month();
		echo $data_month;
	}

	//历史数据查询(按天)	
	function select_history_any_day()
	{
		$data_day=$this->admin_index_data->select_json_day();
		echo $data_day;
	}
	
	//查询Web攻击统计
	function select_web_attack(){
		$web_attack=$this->admin_index_data->select_json_all();
		echo $web_attack;
	}

	//查询断网攻击统计
	function select_dw_json()
	{
		 $data=$this->admin_index_data->select_json_dw();
		 echo $data;
	}
	function logout(){
		$this->session->unset_userdata('username');
		redirect('/login','location');
	}

}

?>
