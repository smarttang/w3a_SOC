<?php

class Net_monitor_index_data extends CI_Model{
	function __construct()
	{
		$this->load->helper('date');
		$this->load->database();
	}

	//查询一条记录的最新10条数据
	function select_monitor_info($id)
	{
		$sql="select task_type,task_url,task_user_id from w3a_net_monitor where id=$id";
		$query=$this->db->query($sql);
		$row=$query->row();
		//2013-11-25 10:19
		//判断服务的类型，对此选择对应的数据
		//这里使用双判断是为了以后扩展使用
		//后续可能会扩展别的服务
		if($row->task_type==1){
			$sql2="select * from w3a_net_monitor_network_attack where ip_address='$row->task_url' and user_id=$row->task_user_id limit 10";
		}else if($row->task_type==2){
			$sql2="select * from w3a_net_monitor_web_attack where ip_address='$row->task_url' and user_id=$row->task_user_id limit 10";
		}
		$query_results=$this->db->query($sql2);
		if($query_results){
			return $query_results->result_array();
		}else{
			return false;
		}
		
	}

	//查询返回数据类型
	function select_monitor_callback_type($id)
	{
		$sql="select task_type from w3a_net_monitor where id=$id";
		$query=$this->db->query($sql);
		$row=$query->row();
		return $row->task_type;
	}

	//查询所有网络监控数据
	function select_net_monitor($total,$offset){
                $sql="select (select monitor_name from w3a_net_monitor_type where id=task_type) task_type,
                            (select useranme from w3a_user where id=task_user_id) task_user_id,
                              task_name,task_url,task_create_date,id,task_mode
                            	from w3a_net_monitor limit ?,?"; 
		$query=$this->db->query($sql,array($total,$offset));
		foreach($query->result_array() as $item)
		{
			if($item['task_type']=='主机设备监控')
			{
				$sql2="select max(time_start) task_last_date from w3a_net_monitor_network_attack where ip_address='".$item['task_url']."'";
			}
			else if($item['task_type']=='web应用监控')
			{
				$sql2="select max(time_start) task_last_date from w3a_net_monitor_web_attack where ip_address='".$item['task_url']."'";
			}
			$query=$this->db->query($sql2);
			$row=$query->row();
			if($row->task_last_date == null){
				$tasK_last_date=$item['task_create_date'];
			}else{
				$task_last_date=$row->task_last_date;
			}
			$results[]=array(
				'task_type' => $item['task_type'],
				'task_user_id' => $item['task_user_id'],
				'task_name' => $item['task_name'],
				'task_url' => $item['task_url'],
				'task_create_date' => $item['task_create_date'],
				'id' => $item['id'],
				'task_mode' => $item['task_mode'],
				'task_last_date' => $task_last_date);
		}
		return $results;
	}
	
	//查询监控类型
	function select_net_type(){
		$query=$this->db->get('w3a_net_monitor_type');
		return $query->result_array();
	}
	
	//查询所有监控报告数据
	function select_net_report($total,$offset)
	{
		$sql="select * from w3a_net_report limit ?,?";
		$query=$this->db->query($sql,array($total,$offset));
		return $query->result_array();
	}
	
	//查询单条记录
	function select_net_monitor_task($id)
	{
		$query=$this->db->query("select 
                                                (select monitor_name from w3a_net_monitor_type where id=task_type) task_type,
                                                (select useranme from w3a_user where id=task_user_id) task_user_id,
                                                task_mode task_status,
                                                        task_name,task_url,task_create_date,task_last_date,id
                                         from w3a_net_monitor where id=$id");
		return $query->result_array();
	}
	
	//查询监控的记录数量
	function select_net_sum()
	{
		$query=$this->db->get('w3a_net_monitor');
		return $query->num_rows();
	}
	
	//查询所有网络监控报告
	function select_net_monitor_report($total,$offset)
	{
                $date_y=date('Y');
                $date_m=date('m');
                $date_d=date('d');
		$all_year=0;
		$all_month=0;
		$all_day=0;
                $query=$this->db->query("select 
                                                id,
                                                task_name,
                                                task_url,
                                                task_create_date,
						task_type
                                        from 
                                                w3a_net_monitor 
                                                        limit $total,$offset");
		foreach($query->result_array() as $item)
		{
			if($item['task_type']==1)
			{
				$query_n_y=$this->db->query("select count(*) count_sum from w3a_net_monitor_network_attack where ip_address='".$item['task_url']."' and time_start like '%$date_y%'");
				$query_result_y=$query_n_y->row();
				if($query_result_y->count_sum != "null")
				{
					$all_year=$query_result_y->count_sum;
				}
				$query_n_m=$this->db->query("select count(*) count_sum from w3a_net_monitor_network_attack where ip_address='".$item['task_url']."' and time_start like '%$date_y-$date_m%'");
				$query_result_m=$query_n_m->row();
				if($query_result_m->count_sum != "null")
				{
					$all_month=$query_result_m->count_sum;
				}
				$query_n_d=$this->db->query("select count(*) count_sum from w3a_net_monitor_network_attack where ip_address='".$item['task_url']."' and time_start like '%$date_y-$date_m-$date_d%'");
				$query_result_d=$query_n_d->row();
				if($query_result_d->count_sum != "null")
				{
					$all_day=$query_result_d->count_sum;
				}
			}
			else if($item['task_type']==2)
			{
                                $query_w_y=$this->db->query("select count(*) count_sum from w3a_net_monitor_web_attack where ip_address='".$item['task_url']."' and time_start like '%$date_y%'");
                                $query_result_y=$query_w_y->row();
                                if($query_result_y->count_sum != "null")
				{
                                        $all_year=$query_result_y->count_sum;
                                }
                                $query_w_m=$this->db->query("select count(*) count_sum from w3a_net_monitor_web_attack where ip_address='".$item['task_url']."' and time_start like '%$date_y-$date_m%'");
                                $query_result_m=$query_w_m->row();
                                if($query_result_m->count_sum != "null")
				{
                                        $all_month=$query_result_m->count_sum;
                                }
                                $query_w_d=$this->db->query("select count(*) count_sum from w3a_net_monitor_web_attack where ip_address='".$item['task_url']."' and time_start like '%$date_y-$date_m-$date_d%'");
                                $query_result_d=$query_w_d->row();
                                if($query_result_d->count_sum != "null")
				{
                                        $all_day=$query_result_d->count_sum;
                                }
			}
			$results[]=array(
					'id' => $item['id'],
					'task_name' => $item['task_name'],
					'task_url' => $item['task_url'],
					'task_create_date' => $item['task_create_date'],
					'result_year' => $all_year,
					'result_month' => $all_month,
					'result_day' => $all_day);
		}
		return $results;
	}

        //添加监控任务
        function net_monitor_add($task_name,$task_url,$task_type,$task_user_id)
        {
		//设置日期格式
		$date_type="%Y-%m-%d %h:%i:%a";
		//设置日期
		$date_set=mdate($date_type,time());
                $data_net=array( 
                         'task_name' => $task_name, 
                         'task_url' => $task_url,
                         'task_create_date' => $date_set,
                         'task_last_date' => $date_set,
                         'task_mode' => 0,
                         'task_type' => $task_type,
			 'task_user_id' => $task_user_id);
                $data_net_result=$this->db->insert('w3a_net_monitor', $data_net);
		if($data_net_result){
			return true;
		}else{
			return false;
		}
        }       

	//删除一条数据
	function net_monitor_del($id)
	{
		$this->db->where('id',$id);
		if($this->db->delete('w3a_net_monitor'))
		{
			return true;
		}else{
			return false;
		}
	}

	//更新一条记录
	function net_monitor_update($id,$task_name,$task_url,$task_service_type)
	{
		$this->db->where('id',$id);
		$data_net=array(
			 'task_name' => $task_name,
			 'task_url' => $task_url,
			 'task_type' => $task_service_type);
		if($this->db->update('w3a_net_monitor',$data_net))
		{
			return true;
		}else{
			return false;
		}
	}
	
        //监控开关数据更新
        function net_monitor_switch($data)
        {
                if($data['switch']==0){
                        $this->task_mode=1;
                        $result_text='off';
                }else{
                        $this->task_mode=0;
                        $result_text='on';
                }
                $result=$this->db->update('w3a_net_monitor',$this,array('id' => $data['id']));
                if($result){
                        return $result_text;
                }else{
                        return false;
                }
        }

}

?>
