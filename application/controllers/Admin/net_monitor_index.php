<?php

/**********************************
*	网络监控模块
*	2013/08/15
*
**********************************/

class Net_monitor_index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('page_smart');
		$this->load->model('Admin/net_monitor_index_data');
		$this->load->model('Admin/log_monitor_index_data');
		$this->load->helper('url');
                $session=$this->session->userdata('username');
                //如果没有登录,则跳转退出
                if(!$session){
                        redirect('/login','location');
                }

	}
	
	/**********************
	*	数据查询
	**********************/

	//监控任务列表
	function net_monitor_list($page="")
	{	
		$config['page']=$page;
		$config['rows']=$this->net_monitor_index_data->select_net_sum(); 
		if($config['rows']){
			$config['base_url']=site_url('Admin/net_monitor_index/net_monitor_list');
			$page_rst=$this->page_smart->page_do($config);
			$data['net_monitor_list']=$this->net_monitor_index_data->select_net_monitor($page_rst['select_from'],$page_rst['select_limit']);
			if($config['rows'] >10)
			{
				$data['page_list']=$page_rst['pagenav'];
			}else{
				$data['page_list']=null;
			}
			$this->load->view('AdminLogin/net_monitor_index/net_monitor_list',$data);
		}else{
			$data['task_text']="目前没有网络监控任务,请去添加任务!";
			$data['task_name']="添加任务";
			$data['task_url']="net_monitor_index/net_monitor_add";
			$this->load->view('AdminLogin/error/error',$data);
		}
	}
	
	//监控任务开关
	function net_monitor_switch()
	{
                $data['switch']=$this->input->post('sw');
                $data['id']=$this->input->post('id');
                $result=$this->net_monitor_index_data->net_monitor_switch($data);
                if($result!=false){
                        echo $result;
                }
	}
	
	//查询单条任务信息
        function net_monitor_info($id)
        {
                $data=$this->net_monitor_index_data->select_monitor_info($id);
                if($data){
			$type=$this->net_monitor_index_data->select_monitor_callback_type($id);
			if($type==1)
			{
                       		 echo '<table id="myTables" class="table table-striped table-bordered table-condensed table-hover no-margin"><thead><tr id="mytable"><th><center>网络状态</center></th><th><center>具体时间</center></th><th><center>目标地址</center></th><th><center>最后节点</center></th></thead><tbody>';
                       		 foreach($data as $data_item)
                       		 {
                               		  echo "<tr id='mytable2'><td><center>".$data_item['network_status']."</center></td>";
                                	  echo "<td><center>".$data_item['time_start']."</center></td>";
                                  	  echo "<td><center>".$data_item['ip_address']."</center></td>";
                        	     	  echo "<td><center>".$data_item['last_node']."</center></td>";
                        	 }
                        	 echo "</tbody></table>";
			}
			else if($type==2)
			{
				echo '<table id="myTables" class="table table-striped table-bordered table-condensed table-hover no-margin"><thead><tr id="mytable"><th><center>网站状态</center></th><th><center>开始时间</center></th><th><center>目标地址</center></th><th><center>响应状态</center></th></thead><tbody>';
				foreach($data as $data_item)
				{
					echo "<tr id='mytable2'><td><center>".$data_item['web_status']."</center></td>";
					echo "<td><center>".$data_item['time_start']."</center></td>";
					echo "<td><center>".$data_item['ip_address']."</center></td>";
					if($data_item['offer_status']==1){
						echo "<td><center>无返回状态</center></td>";
					}else{
						echo "<td><center>".$data_item['offer_status']."</center></td>";
					}
				}
				echo "</thody></table>";
			}
                }else{
                        $data['error']="目前没有异常数据";
                        $this->load->view('AdminLogin/error/error_text',$data);
                }
        }

	//监控报告列表
	function net_monitor_report($page="")
	{
		$config['page']=$page;
		$config['rows']=$this->net_monitor_index_data->select_net_sum();
		if($config['rows']){
			$config['base_url']=site_url('Admin/net_monitor_index/net_monitor_report');
			$page_rst=$this->page_smart->page_do($config);
			$data['net_monitor_report']=$this->net_monitor_index_data->select_net_monitor_report($page_rst['select_from'],$page_rst['select_limit']);
			if($config['rows'] > 10)
			{
				$data['page_list']=$page_rst['pagenav'];
			}else{
				$data['page_list']=null;
			}
			$this->load->view('AdminLogin/net_monitor_index/net_monitor_report',$data);
		}else{
                        $data['task_text']="目前没有网络监控报告,只有添加任务后才能生成出报告模板,请去添加任务!";
                        $data['task_name']="添加任务";
                        $data['task_url']="net_monitor_index/net_monitor_add";
                        $this->load->view('AdminLogin/error/error',$data);
		}
	}

	/***********************
	*	页面浏览
	***********************/

	//添加监控页面
	function net_monitor_add()
	{
		$data['net_monitor_type']=$this->net_monitor_index_data->select_net_type();
		$data['net_user_id']=$this->log_monitor_index_data->log_user_id();
		$this->load->view('AdminLogin/net_monitor_index/net_monitor_add',$data);
	}

	//参数设置页面
	function net_monitor_option()
	{
		$this->load->view('AdminLogin/net_monitor_index/net_monitor_option');
	}

        //更新指定单条任务
        function net_monitor_change($id)
        {
                $data['net_monitor_task']=$this->net_monitor_index_data->select_net_monitor_task($id);
		$data['net_monitor_type']=$this->net_monitor_index_data->select_net_type();
                $this->load->view('AdminLogin/net_monitor_index/net_monitor_change',$data);
        }

	
	/***********************
	*	插入/修改/删除
	***********************/

	//添加监控任务
	function net_monitor_insert()
	{
		$data=$this->net_monitor_index_data->net_monitor_add(
							$this->security->xss_clean($this->input->post('task_name')),
							$this->security->xss_clean($this->input->post('task_url')),
							$this->security->xss_clean($this->input->post('task_service_type')),
							$this->security->xss_clean($this->input->post('task_user_id'))
						       );
		if($data){
			redirect('/Admin/net_monitor_index/net_monitor_list');
		}else{
                        $data['error']="添加监控任务失败.";
                        $this->load->view('AdminLogin/error/error',$data);
                }

	}
	

	//删除指定的监控任务
	function net_monitor_del($id)
	{
		$result=$this->net_monitor_index_data->net_monitor_del($id);
		if($result){
			redirect('/Admin/net_monitor_index/net_monitor_list','location');
		}else{
                        $data['error']="删除监控任务失败。";
                        $this->load->view('AdminLogin/error/error',$data);
                }
	}

	//更新任务信息
	function net_monitor_update(){
		$result=$this->net_monitor_index_data->net_monitor_update(
							 $this->security->xss_clean($this->input->post('task_id')),
							 $this->security->xss_clean($this->input->post('task_name')),
							 $this->security->xss_clean($this->input->post('task_url')),
							 $this->security->xss_clean($this->input->post('task_service_type'))
							);
		if($result){
			redirect('/Admin/net_monitor_index/net_monitor_list');
		}else{
			$data['error']="网络监控信息更新失败！";
			$this->load->view('AdminLogin/error/error',$data);
		}
	}

	/******************
	*     报告模块	  *
	******************/

        //查看单条监控报告(年报)
        function net_monitor_report_year($id)
        {
                $user_id=$this->net_monitor_index_data->back_for_user($id);
                if($this->net_monitor_index_data->report_bool($user_id['task_url'],'y'))
                {
                        if($user_id){
                                $task_url=$user_id['task_url'];
                                $data['title']='年报';
                                //漏洞等级数量统计
                                $data['log_report']=$this->net_monitor_index_data->net_report_count_attack($task_url,'y');
                                //规则触发统计
                                $data['log_attack_top']=$this->net_monitor_index_data->net_report_attack_trigger($task_url,'y');
                                //攻击源统计
                                $data['log_attack_source']=$this->net_monitor_index_data->net_report_source($task_url,'y');
                                //攻击行为分析
                                $data['log_attack_behavior']=$this->log_monitor_index_data->net_report_behavior($task_url,'y');
                                $this->load->view('AdminLogin/net_monitor_index/net_monitor_report_read',$data);
                        }
                }else{
                        $date['task_text']='目前没有捕获到数据.';
                        $this->load->view('AdminLogin/error/error2',$date);
                }

        }

        //查看单条监控报告(月报)
        function net_monitor_report_month($id)
        {
                $user_id=$this->net_monitor_index_data->back_for_user($id);
                if($this->net_monitor_index_data->report_bool($user_id['task_url'],'m'))
                {
                        if($user_id){
                                $task_url=$user_id['task_url'];
                                $data['title']='月报';
                                //漏洞等级数量统计
                                $data['net_report']=$this->net_monitor_index_data->net_report_count_attack($task_url,'m');
                                //规则触发统计
                                $data['net_attack_top']=$this->net_monitor_index_data->net_report_attack_trigger($task_url,'m');
                                //攻击源统计
                                $data['net_attack_source']=$this->net_monitor_index_data->net_report_source($task_url,'m');
                                //攻击行为分析
                                $data['net_attack_behavior']=$this->net_monitor_index_data->net_report_behavior($task_url,'m');
                                $this->load->view('AdminLogin/net_monitor_index/net_monitor_report_read',$data);
                        }
                }else{
                        $date['task_text']='目前没有捕获到数据.';
                        $this->load->view('AdminLogin/error/error2',$date);
                }

        }

        //查看单条监控报告(日报)
        function log_monitor_report_day($id)
        {
                $user_id=$this->log_monitor_index_data->back_for_user($id);
                if($this->log_monitor_index_data->report_bool($user_id['task_url'],'d'))
                {
                        if($user_id){
                                $task_url=$user_id['task_url'];
                                $data['title']='日报';
                                //漏洞等级数量统计
                                $data['log_report']=$this->log_monitor_index_data->log_report_count_attack($task_url,'d');
                                //规则触发统计
                                $data['log_attack_top']=$this->log_monitor_index_data->log_report_attack_trigger($task_url,'d');
                                //攻击源统计
                                $data['log_attack_source']=$this->log_monitor_index_data->log_report_source($task_url,'d');
                                //攻击行为分析
                                $data['log_attack_behavior']=$this->log_monitor_index_data->log_report_behavior($task_url,'d');
                                $this->load->view('AdminLogin/log_monitor_index/log_monitor_report_read',$data);
                        }
                }else{
                        $date['task_text']='目前没有捕获到数据.';
                        $this->load->view('AdminLogin/error/error2',$date);
                }

        }

}

?>
