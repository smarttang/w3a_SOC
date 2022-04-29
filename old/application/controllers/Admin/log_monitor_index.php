<?php

/**********************************
*	日志监控模块
*	2013/08/14
*
**********************************/

class Log_monitor_index extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('page_smart');
		$this->load->library('xss_smart');
		$this->load->library('pdf_smart');
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

	//任务搜索查询功能
	function log_monitor_seach()
	{
		$data=$this->log_monitor_index_data->select_monitor_search($this->security->xss_clean($this->input->post('task_name')));
		if($data){
			foreach($data as $data_item){
				echo "<tr id='mytable2'><td id='monitor_id' style='display:none'>".$data_item['id']."</td>";
				echo "<td>".htmlspecialchars($data_item['task_name'])."</td>";
				echo "<td><center><a class='urlcolor' href='".htmlspecialchars($data_item['task_url'])."' target='_blank'>".$data_item['task_url']."</a></center></td>";
				echo "<td><center>".$data_item['task_create_date']."</center></td>";
				echo "<td><center>".$data_item['task_last_date']."</center></td>";
				echo "<td><center>".htmlspecialchars($data_item['task_service_type'])."</center></td>";
				echo "<td name='status' value='".htmlspecialchars($data_item['task_status'])."'><center name='status_text_".$data_item['id']."'>".htmlspecialchars($data_item['task_status_text'])."</center></td>";
				echo "<td><center>".$data_item['task_user_id']."</center></td>";
				$do_look="'".site_url()."/Admin/log_monitor_index/log_monitor_info/".$data_item['id']."','查看任务'";
				echo "<td><center><a class='btn btn-size' href="."javascript:remoteUrl(".$do_look.");>查看任务</a>&nbsp;";
				echo "<a id='switch' name='".$data_item['id']."' onclick='exec_doing(this)' class='btn btn-info btn-size' value='".$data_item['task_switch']."'>";
				if($data_item['task_switch']==0){
					echo "开启监控";
				}else{
					echo "关闭监控";
				}
				$change_url="'/log_monitor_index/log_monitor_change/".$data_item['id']."'";
				echo "</a>&nbsp;<a class='btn btn-primary btn-size'  href="."javascript:goToUrl(".$change_url.");>修改任务</a>&nbsp;";
				$del_url="'/log_monitor_index/log_monitor_del/".$data_item['id']."'";
				echo "<a class='btn btn-success btn-size' href="."javascript:goToUrl(".$del_url.");'>删除任务</a>&nbsp;</center></td></tr>";
			
			}
		}
	}

	//查询单任务的监控信息
	function log_monitor_info($id)
	{
		$data=$this->log_monitor_index_data->select_monitor_info($id);
		if($data){
			echo '<table id="myTables" class="table table-striped table-bordered table-condensed table-hover no-margin"><thead><tr id="mytable"><th><center>漏洞名称</center></th><th><center>攻击时间</center></th><th><center>源日志</center></th><th><center>攻击源</center></th><th><center>提交方式</center></th><th><center>返回状态</center></th><th><center>日志类型</center></th></tr></thead><tbody>';
			foreach($data as $data_item)
			{
				 echo "<tr id='mytable2'><td><center>".$data_item['method_name']."</center></td>";
				 echo "<td><center>".$data_item['attack_date']."</center></td>";
				 echo "<td><center>".htmlspecialchars($data_item['method_url'])."</center></td>";
				 echo "<td><center>".$data_item['attack_source']."</center></td>";
				 if($data_item['attack_option']=='GET'){
				 	echo "<td><center style='color:blue'><strong>".$data_item['attack_option']."</strong></center></td>";
				 }else{
					echo "<td><center style='color:red'><strong>".$data_item['attack_option']."</strong></center></td>";
				 }
				 echo "<td><center><span class='label label-success'><strong>".$data_item['attack_offer']."</strong></span></center></td>";
				 echo "<td><center>".$data_item['log_type']."</center></td>";
			}
			echo "</tbody></table>";
		}else{
			$data['error']="目前没有攻击日志数据";
			$this->load->view('AdminLogin/error/error_text',$data);
		}
	}	

	//监控任务列表
	function log_monitor_list($page="")
	{
		$config['page']=$page;
		$config['rows']=$this->log_monitor_index_data->select_log_monitor_sum('w3a_log_monitor');
		if($config['rows']!=0){
			$config['base_url']=site_url('Admin/log_monitor_index/log_monitor_list');
			$page_rst=$this->page_smart->page_do($config);
			$data['log_monitor_list']=$this->log_monitor_index_data->select_log_monitor($page_rst['select_from'],$page_rst['select_limit']);
			if($config['rows'] > 10){
	       	        	$data['page_list']=$page_rst['pagenav'];
			}else{
				$data['page_list']=null;
			}
			$this->load->view('AdminLogin/log_monitor_index/log_monitor_list',$data);
		}else{
			$data['task_text']="目前没有监控任务,请去添加任务!点击:";
			$data['task_name']="添加任务";
			$data['task_url']="log_monitor_index/log_monitor_add";
			$this->load->view('AdminLogin/error/error',$data);
		}

	}

	//监控报告列表
	function log_monitor_report($page="")
	{
		$config['page']=$page;
		$config['rows']=$this->log_monitor_index_data->select_log_monitor_sum('w3a_log_monitor');
		if($config['rows'] !=0 ){
			$config['base_url']=site_url('Admin/log_monitor_index/log_monitor_report');
			$page_rst=$this->page_smart->page_do($config);
			$data['log_monitor_report']=$this->log_monitor_index_data->select_log_monitor_report($page_rst['select_from'],$page_rst['select_limit']);
                        if($config['rows'] > 10){
                                $data['page_list']=$page_rst['pagenav'];
                        }else{
                                $data['page_list']=null;
                        }
			$this->load->view('AdminLogin/log_monitor_index/log_monitor_report',$data);
		}else{
			$data['task_text']="目前没有报告,请去添加任务,并执行监控后,才会有监控报告输出!点击:";
			$data['task_name']="添加任务";
			$data['task_url']="log_monitor_index/log_monitor_add";
			$this->load->view('AdminLogin/error/error',$data);
		}
	}

	//监控日志规则列表
	function log_monitor_method_list($page="")
	{
		$config['page']=$page;
		$config['rows']=$this->log_monitor_index_data->select_log_monitor_sum('w3a_log_method');
		if($config['rows'] !=0 ){
			$config['base_url']=site_url('Admin/log_monitor_index/log_monitor_method_list');
			$page_rst=$this->page_smart->page_do($config);
			$data['log_monitor_method']=$this->log_monitor_index_data->select_log_monitor_method($page_rst['select_from'],$page_rst['select_limit']);
                        if($config['rows'] > 10){
                                $data['page_list']=$page_rst['pagenav'];
                        }else{
                                $data['page_list']=null;
                        }
			$this->load->view('AdminLogin/log_monitor_index/log_monitor_method_list',$data);
		}else{
                        $data['task_text']="目前没有监控规则,请去添加规则!点击:";
                        $data['task_name']="添加规则";
                        $data['task_url']="log_monitor_index/log_monitor_method_add";
			$this->load->view('AdminLogin/error/error',$data);
		}
	}

	//日期列表读取
	function log_data_list()
	{
		$result=$this->log_monitor_index_data->log_data_list();
		foreach($result as $result_item){
			foreach($result_item as $item){
				print $item."|";
			}
		}
	}
	
	//监控执行状态读取
	function log_status_list()
	{
		$result=$this->log_monitor_index_data->log_status_list();
		foreach($result as $result_item){
			foreach($result_item as $item){
				print $item."|";
			}
		}
	}

	/***********************
	*	页面浏览
	***********************/

	//添加监控页面
	function log_monitor_add()
	{
		$data['user_id']=$this->log_monitor_index_data->log_user_id();
		$data['task_status']=$this->log_monitor_index_data->log_status();
		$data['log_type']=$this->log_monitor_index_data->log_type();
		$this->load->view('AdminLogin/log_monitor_index/log_monitor_add',$data);
	}

	//规则添加页面
	function log_monitor_method_add()
	{
		$data['method_level_list']=$this->log_monitor_index_data->log_method_list();
		$this->load->view('AdminLogin/log_monitor_index/log_monitor_method_add',$data);
	}

        //监控日志数据单条修改
        function log_monitor_change($id)
        {
		$data['log_type_result']=$this->log_monitor_index_data->log_type();
                $data['log_monitor_result']=$this->log_monitor_index_data->log_monitor_change($id);
                $this->load->view('AdminLogin/log_monitor_index/log_monitor_read',$data);
        }

        //监控日志规则单条内容读取
        function log_method_change($id)
        {
                $data['log_method_result']=$this->log_monitor_index_data->log_method_read($id);
		$data['log_method_level']=$this->log_monitor_index_data->log_method_list();
                $this->load->view('AdminLogin/log_monitor_index/log_method_change',$data);
        }

	//PDF导出功能
	function log_monitor_output($source_name,$task_name)
	{
		$config['source_name']=$source_name;
		$config['task_name']=$task_name;
		$this->pdf_smart->pdf_do($config);
		
	}
	
	//查看单条监控报告(年报)
	function log_monitor_report_year($id)
	{
		$user_id=$this->log_monitor_index_data->back_for_user($id);
		if($this->log_monitor_index_data->report_bool($user_id,'y'))
		{
			if($user_id){
				$data['title']='年报';
				//曲线图数据
				$data['data_qx']=$this->log_monitor_index_data->log_report_method($user_id,'y');
				//漏洞等级数量统计
				$data['log_report']=$this->log_monitor_index_data->log_report_count_attack($user_id,'y');
				//规则触发统计
				$data['log_attack_top']=$this->log_monitor_index_data->log_report_attack_trigger($user_id,'y');
				//攻击源统计
				$data['log_attack_source']=$this->log_monitor_index_data->log_report_source($user_id,'y');
				//攻击行为分析
				$data['log_attack_behavior']=$this->log_monitor_index_data->log_report_behavior($user_id,'y');
				$this->load->view('AdminLogin/log_monitor_index/log_monitor_report_read',$data);
			}
		}else{
			$date['task_text']='目前没有捕获到数据.';
			$this->load->view('AdminLogin/error/error2',$date);
		}

	}

        //查看单条监控报告(月报)
        function log_monitor_report_month($id)
        {
                $user_id=$this->log_monitor_index_data->back_for_user($id);
                if($this->log_monitor_index_data->report_bool($user_id,'m'))
                {
                        if($user_id){
                                $data['title']='月报';
				//曲线图数据
				$data['data_qx']=$this->log_monitor_index_data->log_report_method($user_id,'m');
                                //漏洞等级数量统计
                                $data['log_report']=$this->log_monitor_index_data->log_report_count_attack($user_id,'m');
                                //规则触发统计
	                        $data['log_attack_top']=$this->log_monitor_index_data->log_report_attack_trigger($user_id,'m');
                                //攻击源统计
                        	$data['log_attack_source']=$this->log_monitor_index_data->log_report_source($user_id,'m');
                                //攻击行为分析
                                $data['log_attack_behavior']=$this->log_monitor_index_data->log_report_behavior($user_id,'m');
                                $this->load->view('AdminLogin/log_monitor_index/log_monitor_report_read',$data);
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
                if($this->log_monitor_index_data->report_bool($user_id,'d'))
                {
                        if($user_id){
                                $data['title']='日报';
				//曲线图数据
				$data['data_qx']=$this->log_monitor_index_data->log_report_method($user_id,'d');
                                //漏洞等级数量统计
                                $data['log_report']=$this->log_monitor_index_data->log_report_count_attack($user_id,'d');
                                //规则触发统计
                                $data['log_attack_top']=$this->log_monitor_index_data->log_report_attack_trigger($user_id,'d');
                                //攻击源统计
                                $data['log_attack_source']=$this->log_monitor_index_data->log_report_source($user_id,'d');
                                //攻击行为分析
                                $data['log_attack_behavior']=$this->log_monitor_index_data->log_report_behavior($user_id,'d');
                                $this->load->view('AdminLogin/log_monitor_index/log_monitor_report_read',$data);
                        }
                }else{
                        $date['task_text']='目前没有捕获到数据.';
                        $this->load->view('AdminLogin/error/error2',$date);
                }

        }

	/***********************
	*	插入/修改/更新
	***********************/

	//添加监控任务
	function log_monitor_insert()
	{
		$data=$this->log_monitor_index_data->log_monitor_add(
							$this->security->xss_clean($this->input->post('task_name')),
							$this->security->xss_clean($this->input->post('task_url')),
							$this->security->xss_clean($this->input->post('task_user_id')),
							$this->security->xss_clean($this->input->post('task_switch')),
							$this->security->xss_clean($this->input->post('task_service_type'))
						       );
	
		if($data){
			redirect('Admin/log_monitor_index/log_monitor_list');
		}else{
                        $data['error']="添加监控任务失败,请检查输入是否有误。";
                        $this->load->view('AdminLogin/error/error_text',$data);
                }
	}
	
	//添加日志规则
	function log_monitor_method_insert()
	{

		$data=$this->log_monitor_index_data->log_monitor_method_add(
							 $this->security->xss_clean($this->input->post('method_name')),
							 $this->input->post('method_regex'),
							 $this->security->xss_clean($this->input->post('method_level')),
							 $this->security->xss_clean($this->input->post('method_switch')),
							 $this->security->xss_clean($this->input->post('method_text'))
							);
		if($data)
		{
			redirect('Admin/log_monitor_index/log_monitor_method_list');
		}else{
			$data['error']="添加规则失败,请检查输入是否有误。";
			$this->load->view('AdminLogin/error/error_text',$data);
		}
	
	}

	//删除指定的日志监控以及报告
	function log_monitor_del($id)
	{
		$result=$this->log_monitor_index_data->log_monitor_del($id);
		if($result){
			redirect('/Admin/log_monitor_index/log_monitor_list');
		}else{
			$data['error']="删除日志监控数据失败!";
			$this->load->view('AdminLogin/error/error_text',$data);
		}
	}

	//删除指定的日志监控规则
	function log_method_del($id)
	{
		$result=$this->log_monitor_index_data->log_method_del($id);
		if($result){
			redirect('/Admin/log_monitor_index/log_monitor_method_list');
		}else{
                        $data['error']="删除日志规则数据失败!";
                        $this->load->view('AdminLogin/error/error_text',$data);
		}
	}
	
	//更新日志监控数据
	function log_monitor_update()
	{
		$result=$this->log_monitor_index_data->log_monitor_update(
							$this->security->xss_clean($this->input->post('id')),
							$this->security->xss_clean($this->input->post('task_name')),
							$this->security->xss_clean($this->input->post('task_url')),
							$this->security->xss_clean($this->input->post('task_service_type'))
							);
		if($result){
			redirect('/Admin/log_monitor_index/log_monitor_list');
		}else{
			$data['error']="日志监控数据更新失败!";
			$this->load->view('AdminLogin/error/error_text',$data);
		}
	}

	//更新规则数据
	 function log_method_update()
	{
		$result=$this->log_monitor_index_data->log_method_update(
							$this->security->xss_clean($this->input->post('id')),
							$this->security->xss_clean($this->input->post('method_name')),
							$this->input->post('method_regex'),
							$this->security->xss_clean($this->input->post('method_level')),
							$this->security->xss_clean($this->input->post('method_switch')),
							$this->security->xss_clean($this->input->post('method_text'))
									);
		if($result){
			redirect('/Admin/log_monitor_index/log_monitor_method_list');
		}else{
			$data['error']="日志规则更新失败!";
			$this->load->view('AdminLogin/error/error_text',$data);
		}
	}
	
	//日志监控开关
	function log_monitor_switch()
	{
		$data['switch']=$this->input->post('sw');
		$data['id']=$this->input->post('id');
		$result=$this->log_monitor_index_data->log_monitor_switch($data);
		if($result!=false){
			echo $result;
		}
	}

	//日志规则开关
	function log_method_switch()
	{
		$data['switch']=$this->input->post('sw');
		$data['id']=$this->input->post('id');
		$result=$this->log_monitor_index_data->log_method_switch($data);
		if($result!=false){
			echo $result;
		}
	}


	/*********************
		JSON数据报告
	**********************/
	function monitor_morris_json()
	{
		$result=$this->log_monitor_index_data->monitor_morris_json();
		if($result!=false){
			echo $result;
		}
	}
}
?>
