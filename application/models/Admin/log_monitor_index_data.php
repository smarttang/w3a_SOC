<?php

class log_monitor_index_data extends CI_Model{

	function __construct()
	{
		$this->load->helper('date');
		$this->load->database();
		$this->load->library('scan_address_smart');
	}
	
	//监控日志任务模糊查询
	function select_monitor_search($task_name)
	{
                $sql="select 
                        id,
                        task_name,
                        task_url,
                        task_create_date,
                        task_last_date,
                        task_switch,
                        task_status,
                        (select status_name from w3a_log_monitor_status where id=task_status) task_status_text,
                        (select name from w3a_user where id=task_user_id) task_user_id,
                        (select log_type_name from w3a_log_monitor_type where id=task_service_type) task_service_type
                     from 
                        w3a_log_monitor 
                     where
			task_name
		     like
			?";
		$task_name="%$task_name%";
		$query=$this->db->query($sql,array($task_name));
		return $query->result_array();
	}

	//查询单用户最新10条状态
	function select_monitor_info($id)
	{
		$sql="select 
			(select 
				w3a_log_method.method_name 
			from 
				w3a_log_method 
			where 
				id=w3a_log_monitor_attack.method_name) method_name,
				method_url,
				attack_source,
				attack_user,
				attack_option,
				attack_offer,
				attack_date,
					(select 
						log_type_name 
					from 
						w3a_log_monitor_type 
					where 
						id=log_type) log_type 
					from 
						w3a_log_monitor_attack 
					where 
						attack_user=(
							select 
								task_url 
							from 
								w3a_log_monitor 
							where 
								id=$id) 
							order by 
								id 
							desc limit 
								10";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

	//查询所有日志监控数据
	function select_log_monitor($total,$offset){
		$sql="select 
			id,
			task_name,
			task_url,
			task_create_date,
			task_last_date,
			task_switch,
			task_status,
			(select status_name from w3a_log_monitor_status where id=task_status) task_status_text,
			(select name from w3a_user where id=task_user_id) task_user_id,
			(select log_type_name from w3a_log_monitor_type where id=task_service_type) task_service_type
	             from 
			w3a_log_monitor 
				limit ?,?";
		$query=$this->db->query($sql,array($total,$offset));
		return $query->result_array();
	}
	
	//查询所有日志监控报告
	function select_log_monitor_report($total,$offset)
	{
		$date_y=date('Y');
                $date_m=date('m');
                $date_d=date('d');
                $query=$this->db->query("select 
						id,
						task_name,
						task_url,
						task_create_date 
					from 
						w3a_log_monitor 
							limit $total,$offset");

		foreach( $query->result_array() as $item)
		{
	                $high_year=0;
	                $warn_year=0;
         	        $low_year=0;
	                $high_month=0;
	                $warn_month=0;
	                $low_month=0;
	                $high_day=0;
	                $warn_day=0;
	                $low_day=0;

			//年的查询
			$query_year=$this->db->query("
						select 
							method_name,
							count(method_name) count_method 
						from 
							(select 
								(select 
									method_level 
								from 
									w3a_log_method 
								where 
									id=w3a_log_monitor_attack.method_name) method_name 
								from 
									w3a_log_monitor_attack 
								where 
									attack_user='".$item['task_url']."' 
								and 
									attack_date 
								like 
									'%$date_y%') t 
								group by 
									method_name");

			foreach($query_year->result_array() as $item_year)
			{
				if($item_year['method_name']==1)
				{
					$high_year=$item_year['count_method'];
				}
				else if($item_year['method_name']==2)
				{
					$warn_year=$item_year['count_method'];
				}
				else if($item_year['method_name']==3)
				{
					$low_year=$item_year['count_method'];
				}
			}

			//月的查询
			$query_month=$this->db->query("
						select 
							method_name,
							count(method_name) count_method 
						from 
							(select 
								(select 
									method_level 
								 from 
									w3a_log_method 
								where 
									id=w3a_log_monitor_attack.method_name) method_name 
								from 
									w3a_log_monitor_attack 
								where 
									attack_user='".$item['task_url']."' 
								and 
									attack_date 
								like 
									'%$date_y-$date_m%') t 
								group by 
									method_name");

			foreach($query_month->result_array() as $item_month)
			{
                                if($item_month['method_name']==1)
				{
                                        $high_month=$item_month['count_method'];
                                }
				else if($item_month['method_name']==2)
				{
                                        $warn_month=$item_month['count_method'];
                                }
				else if($item_month['method_name']==3)
				{
                                        $low_month=$item_month['count_method'];
                                }
			}

			//日的查询
			$query_day=$this->db->query("
						select 
							method_name,
							count(method_name) count_method 
						from 
							(select 
								(select 
									method_level 
								from 
									w3a_log_method 
								where 
									id=w3a_log_monitor_attack.method_name) method_name 
								from 
									w3a_log_monitor_attack 
								where 
									attack_user='".$item['task_url']."' 
								and 
									attack_date 
								like 
									'%$date_y-$date_m-$date_d%') t 
								group by 
									method_name");

			foreach($query_day->result_array() as $item_day)
			{
                                if($item_day['method_name']==1)
				{
                                        $high_day=$item_day['count_method'];
                                }
				else if($item_day['method_name']==2)
				{
                                        $warn_day=$item_day['count_method'];
                                }
				else if($item_day['method_name']==3)
				{
                                        $low_day=$item_day['count_method'];
                                }
			}

	                $result[]=array(
				'id'=>$item['id'],
		                'task_name'=>$item['task_name'],
                                'task_url'=>$item['task_url'],
                	        'task_create_date'=>$item['task_create_date'],
				'task_high'=>$high_day,
				'task_warn'=>$warn_day,
				'task_low'=>$low_day,
				'task_high_month'=>$high_month,
				'task_warn_month'=>$warn_month,
				'task_low_month'=>$low_month,
				'task_high_year'=>$high_year,
				'task_warn_year'=>$warn_year,
				'task_low_year'=>$low_year
                       );

		}
		return $result;
	}

	//查询所有的风险级别名称
	function log_method_list()
	{
		$query=$this->db->get('w3a_log_method_level');

		return $query->result_array();
	}
	
	//查询单条日志监控数据
	function log_monitor_change($id)
	{
		$query=$this->db->query("
					select 
						* 
					from 
						w3a_log_monitor 
					where 
						id=$id");

		return $query->result_array();
	}

	//查询所有日志规则
	function select_log_monitor_method($total,$offset){

		$sql="select
			id, 
			method_name,
			method_regex,
			(select method_name from w3a_log_method_level where id=method_level) method_level,
			method_switch,
			method_create_data,
			attack_sum 
		     from 
			w3a_log_method order by w3a_log_method.method_level desc 
				limit ?,?";

		$query=$this->db->query($sql,array($total,$offset));

		return $query->result_array();
	}

	//监控日志规则单条读取
	function log_method_read($id)
	{
		$sql="select * from w3a_log_method where id=$id";

		$query=$this->db->query($sql);

		return $query->result_array();
	}
	
	//返回数据总数
	function select_log_monitor_sum($task)
	{
		$query=$this->db->get($task);

		return $query->num_rows();
	}

	//添加监控任务页面数据读取(user_id)
	function log_user_id()
	{
		$query=$this->db->query("select name,id from w3a_user");

		return $query->result_array();
	}

	//添加监控任务页面数据读取(log_status)
	function log_status()
	{
		$query=$this->db->query("select * from w3a_log_monitor_status");

		return $query->result_array();
	}

	//添加监控任务页面数据读取(log_type)
	function log_type()
	{
		$query=$this->db->query("select * from w3a_log_monitor_type");

		return $query->result_array();
	}

        //添加监控任务
        function log_monitor_add(
				$task_name,
				$task_url,
				$task_user_id,
				$task_switch,
				$task_service_type
				)
        {
		// 1是开启 0是关闭
		if($task_switch==0)
		{
			$task_status=1;
		}
		else if($task_switch==1)
		{
			$task_status=2;
		}

		$date_type="%Y-%m-%d %h:%i:%a";

		$date_set=mdate($date_type,time());

                $data_log=array
		( 
                         'task_name' => $task_name, 
                         'task_url' => $task_url,
			 'task_create_date' => $date_set,
			 'task_last_date' => $date_set,
			 'task_status' => $task_status,
                         'task_switch' => $task_switch,
                         'task_user_id' => $task_user_id,
			 'task_service_type' => $task_service_type
		);

                $log_result=$this->db->insert('w3a_log_monitor', $data_log);

		if($log_result)
		{
			return true;
		}else{
			return false;
		}
        }

	//添加日志规则
	function log_monitor_method_add(
					$method_name,
					$method_regex,
					$method_level,
					$method_switch,
					$method_text
					)
	{

                $date_type="%Y-%m-%d %h:%i:%a";

                $date_set=mdate($date_type,time());

		$data_regex=array
		(
			 'method_name' => $method_name,
			 'method_regex' => $method_regex,
			 'method_level' => $method_level,
			 'method_switch' => $method_switch,
			 'method_text' => $method_text,
			 'attack_sum'=>0,
			 'method_create_data' => $date_set
		);

		$log_result=$this->db->insert('w3a_log_method',$data_regex);

		if($log_result)
		{
			return true;
		}else{
			return false;
		}
	}
	
	//删除监控数据以及报告数据
	function log_monitor_del($id)
	{
		//这里缺一个功能，批量删除Log.回头需要加上
		//一个新的需求。new question. date:2013-11-25
		$this->db->where('id',$id);

		if($this->db->delete('w3a_log_monitor'))
		{
			return true;
		}else{
			return false;
		}
		
	}

	//删除日志规则列表
	function log_method_del($id)
	{
		$this->db->where('id',$id);

		if($this->db->delete('w3a_log_method'))
		{
			return true;
		}else{
			return false;
		}
	}

	//更新监控日志数据
	function log_monitor_update(
					$id,
					$task_name,
					$task_url,
					$task_service_type)
	{

		$this->db->where('id',$id);

		$data_list=array
		(
			 'task_name' => $task_name,
			 'task_url' => $task_url,
			 'task_service_type' => $task_service_type
		);

		if($this->db->update('w3a_log_monitor',$data_list))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	//更新监控规则数据
	function log_method_update(
					$id,
					$method_name,
					$method_regex,
					$method_level,
					$method_switch,
					$method_text)
	{

		$this->db->where('id',$id);

		$data_method=array
		(
			 'method_name' => $method_name,
			 'method_regex' => $method_regex,
			 'method_level' => $method_level,
			 'method_switch' => $method_switch,
			 'method_text' => $method_text
		);

		if($this->db->update('w3a_log_method',$data_method))
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	//监控开关数据更新
	function log_monitor_switch($data)
	{
		if($data['switch']==1){
			$this->task_switch=0;
			$this->task_status=1;
			$result_text='关闭';
		}else{
			$this->task_switch=1;
			$this->task_status=2;
			$result_text='开启';
		}
		$result=$this->db->update('w3a_log_monitor',$this,array('id' => $data['id']));
		if($result){
			return $result_text;
		}else{
			return false;
		}
	}

	//规则开关数据更新
	function log_method_switch($data)
	{
		if($data['switch']==1){
			$this->method_switch=0;
			$result_text='停用';
		}else{
			$this->method_switch=1;
			$result_text='启用';
		}
		$result=$this->db->update('w3a_log_method',$this,array('id' => $data['id']));
		if($result){
			return $result_text;
		}else{
			return false;
		}
	}
	
	//最后一次检测读取
	function log_data_list()
	{
		$query=$this->db->query("
					select 
						task_last_date 
					from 
						w3a_log_monitor");
		return $query->result_array();
	}

	//检测状态读取
	function log_status_list()
	{
		$query=$this->db->query("
					select 
						(select 
							status_name 
						from 
							w3a_log_monitor_status 
						where 
							id=task_status) 
							task_status 
						from 
							w3a_log_monitor");
		return $query->result_array();
	}
	
	//JSon图表信息返回
	function monitor_morris_json()
	{
		$query=$this->db->get("w3a_netoff_type");
		return json_encode($query->result_array());
	}
	
	//查询监控用户的身份识别(task_url)
	function back_for_user($id)
	{
		$query=$this->db->query("
					select 
						task_url 
					from 
						w3a_log_monitor 
					where 
						id=$id");
		if($query)
		{
			$user_result=$query->row();
			return $user_result->task_url;
		}
		else
		{
			return false;
		}
	}

	##############################
	#
	#	报告模块
	#
	##############################
	
	//漏洞触发统计曲线图
	function log_report_method($user_id,$date)
	{
		$date_y=date('y');
		$all_day=date('t');
		if($date=="y")
		{
			$sql="SELECT CONCAT(YEAR(now()),'-',MONTH(attack_date)) month,count(*) count_all FROM w3a_log_monitor_attack where attack_user='$user_id' GROUP BY CONCAT(YEAR(now()),'-',MONTH(attack_date)) order by month desc";

			$query=$this->db->query($sql);
			if($query)
			{
				for($i=1;$i<=12;$i++)
				{
					$date_item=date('Y')."-$i";
					if(empty($base_data[$date_item]))
					{
						$base_data[$date_item]=0;
					}
					foreach($query->result_array() as $item)
					{
						if($date_item==$item['month'])
						{
							$base_data[$date_item]=$item['count_all'];
						}
					}
				}
			}
		}
		else if($date=="m")
		{
			$sql="SELECT CONCAT(YEAR(now()),'-',MONTH(now()),'-',DAY(attack_date)) day,count(*) count_all FROM w3a_log_monitor_attack where attack_user='$user_id' GROUP BY CONCAT(YEAR(now()),'-',MONTH(now()),'-',DAY(attack_date)) order by day desc";
			$query=$this->db->query($sql);

			if($query)
			{
				for($i=1;$i<=$all_day;$i++)
				{
					$date_item=date('Y-m')."-$i";

					if(empty($base_data[$date_item]))
					{
						$base_data[date('m')."-$i"]=0;
					}
					foreach($query->result_array() as $item)
					{
						if($date_item==$item['day'])
						{
							$base_data[date('m')."-$i"]=$item['count_all'];
						}
					}
				}
			}
		}
		else if($date=="d")
		{
			$sql="SELECT HOUR(attack_date) hour,count(*) count_all FROM w3a_log_monitor_attack WHERE attack_user='$user_id' and attack_date > DATE(NOW()) GROUP BY HOUR(attack_date)";

			$query=$this->db->query($sql);

			if($query)
			{
				for($i=0;$i<=24;$i++)
				{
					$date_item=date('Y-m-d')." $i";

					if(empty($base_data[$i]))
					{
						$base_data[$i."时"]=0;
					}
					foreach($query->result_array() as $item)
					{
						if($i==$item['hour'])
						{
							$base_data[$i."时"]=$item['count_all'];
						}
					}
				}
			}
		}
		while(list($key,$val)=each($base_data)){
				$results[]=array(
					'time' => $key,
					'value' => $val
				);
		}

                $json=json_encode($results);
		return $json;
	}

	//查询攻击的高中低数量(method_level:count_level)
	function log_report_count_attack($user_id,$date_method)
	{
		$high=0;
		$warn=0;
		$low=0;
		if($date_method == "y")
		{
			$date_item=date('Y');
		}
		else if($date_method == "m")
		{
			$date_item=date('Y')."-".date('m');
		}
		else if($date_method == "d")
		{
			$date_item=date('Y')."-".date('m')."-".date('d');
		}
                        $query=$this->db->query("
                                        select 
                                                method_level,
                                                count(method_level) count_level 
                                        from 
                                                (select 
                                                        (select 
                                                                method_level 
                                                        from 
                                                                w3a_log_method 
                                                        where 
                                                                id=w3a_log_monitor_attack.method_name) method_level 
                                                        from 
                                                                w3a_log_monitor_attack 
                                                        where 
                                                                attack_user='$user_id'
                                                        and 
                                                                attack_date like '%$date_item%') t 
                                                        group by 
                                                                method_level");

		if($query)
		{
                        foreach($query->result_array() as $item)
                        {
                                if($item['method_level']==1)
                                {
                                        $high=$item['count_level'];
                                }
                                else if($item['method_level']==2)
                                {
                                        $warn=$item['count_level'];
                                }
                                else if($item['method_level']==3)
                                {
                                        $low=$item['count_level'];
                                }
                        }
			
			 $result=array(
				'high_count' => $high,
				'warn_count' => $warn,
				'low_count' => $low
			 );
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	//漏洞触发统计(method_name:count_method)
	function log_report_attack_trigger($user_id,$date_method)
	{
                if($date_method == "y")
                {
                        $date_item=date('Y');
                }
                else if($date_method == "m")
                {
                        $date_item=date('Y')."-".date('m');
                }
                else if($date_method == "d")
                {
                        $date_item=date('Y')."-".date('m')."-".date('d');
                }
		$query=$this->db->query("
					select 
						method_name,
						count(method_name) count_method 
					from 
						(select 
							method_name 
						from 
							w3a_log_monitor_attack 
						where 
							attack_user='$user_id' 
						and 
							attack_date 
						like 
							'%$date_item%') t 
					group by 
						method_name 
					order by 
						count_method 
					desc limit 
						0,10");
		if($query)
		{
                        foreach($query->result_array() as $item)
                        {
				$method_id=$item['method_name'];
				$count_method=$item['count_method'];
				$query_text=$this->db->query("
								select 
									method_name,
										(select 
											w3a_log_method_level.method_name 
										from 
											w3a_log_method_level 
										where 
											id=method_level ) method_level,
										method_text 
								from 
									w3a_log_method 
								where 
									id=$method_id");
				if($query_text)
				{
					foreach($query_text->result() as $query_items)
					{
						$result_text[]=array
						(
								'method_name' => $query_items->method_name,
								'method_level' => $query_items->method_level,
								'method_text' => $query_items->method_text,
								'count_method' => $count_method
						);
					}
				}
                        }
			return $result_text;
		}
		else
		{
			return false;
		}
	}

	//攻击源统计
	function log_report_source($user_id,$date_method)
	{
                if($date_method == "y")
                {
                        $date_item=date('Y');
                }
                else if($date_method == "m")
                {
                        $date_item=date('Y')."-".date('m');
                }
                else if($date_method == "d")
                {
                        $date_item=date('Y')."-".date('m')."-".date('d');
                }

		$query=$this->db->query("
					select 
						attack_source,
						count_attack,
						start,end,to_days(start)-to_days(end) days,
						timediff(end,start) times 
					from 
						(select 
							attack_source,
							count(attack_source) count_attack,
							min(attack_date) start,
							max(attack_date) end 
						from 
							(select 
								attack_source,
								attack_date 
							from 
								w3a_log_monitor_attack 
							where 
								attack_user='$user_id' 
							and 
								attack_date like '%$date_item%') t 
					group by 
						attack_source
					order by 
						count_attack 
					desc) tt");
		if($query)
		{
			foreach($query->result_array() as $item)
			{
				$result[]=array(
					'attack_source' => $item['attack_source'],
					'count_attack' => $item['count_attack'],
					'start' => $item['start'],
					'end' => $item['end'],
					'days' => $item['days'],
					'times' => $item['times']
				);
			}
			return $result;
		}
		else
		{
			return false;
		}
	}
	
	//攻击行为分析
	function log_report_behavior($user_id,$date_method)
	{
                if($date_method == "y")
                {
                        $date_item=date('Y');
                }
                else if($date_method == "m")
                {
                        $date_item=date('Y-m');
                }
                else if($date_method == "d")
                {
                        $date_item=date('Y-m-d');
                }

		$query_attack=$this->db->query("
					select 
						count(*) all_count 
					from 
						w3a_log_monitor_attack 
					where 
						attack_user='$user_id'
					and 
						attack_date 
					like 
						'%$date_item%'");
		$attack_all=$query_attack->row();
                $query_offer=$this->db->query("
                                        select 
                                                count(*) count_offer
                                        from 
                                                w3a_log_monitor_attack 
                                        where 
                                                attack_user='$user_id'
                                        and 
                                                attack_date 
                                        like 
                                                '%$date_item%'
					and 
						attack_offer='200'");
                $offer_all=$query_offer->row();
                $high=0;
                $warn=0;
                $low=0;
                $query_attack_sum=$this->db->query("
                                        select 
                                                method_level,
                                                count(method_level) count_level 
                                        from 
                                                (select 
                                                        (select 
                                                                method_level 
                                                        from 
                                                                w3a_log_method 
                                                        where 
                                                                id=w3a_log_monitor_attack.method_name) method_level 
                                                        from 
                                                                w3a_log_monitor_attack 
                                                        where 
                                                                attack_user='$user_id'
                                                        and 
                                                                attack_date like '%$date_item%') t 
                                                        group by 
                                                                method_level");
                        foreach($query_attack_sum->result_array() as $item)
                        {
                                if($item['method_level']==1)
                                {
                                        $high=$item['count_level'];
                                }
                                else if($item['method_level']==2)
                                {
                                        $warn=$item['count_level'];
                                }
                                else if($item['method_level']==3)
                                {
                                        $low=$item['count_level'];
                                }
                        }

                         $attack_sum=array(
                                'high_count' => $high,
                                'warn_count' => $warn,
                                'low_count' => $low
                         );
                $query_people=$this->db->query("
						select 
							count(*) count_p
						from 
							(select 
								attack_source,
								count(attack_source) count_attack,
								min(attack_date) start,
								max(attack_date) end 
							from 
								(select 
									attack_source,
									attack_date 
								from 
									w3a_log_monitor_attack 
								where 
									attack_user='$user_id' 
								and 
									attack_date 
								like 
									'%$date_item%')t 
						group by 
								attack_source) t");
		$people_result=$query_people->row();
		$query_rule=$this->db->query("
						select 
							count(*) count_rule
						from 
							w3a_log_method");
		$rule_result=$query_rule->row();

		$result="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;根据捕获的数据进行分析,地址: $user_id 在 2013总共捕获 $attack_all->all_count 次攻击,成功响应的有 $offer_all->count_offer 次。其中高危漏洞触发次数:".$attack_sum['high_count']."次,中危漏洞触发次数:".$attack_sum['warn_count']."次,低危漏洞触发次数:".$attack_sum['low_count']."次。根据历史数据进行深入的分析后，我们发现目前潜伏的攻击者一共有: $people_result->count_p 人，具体情况请查看上述报表数据。<br /><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目前平台已有规则: $rule_result->count_rule 条,从技术的层面上，我们涵盖了大多数的攻击规则，但是无法确保这些规则能完全发现所有的风险，为了确保目标系统的安全，我们建议您根据历史捕获的攻击日志进行安全上的检查或整改，来提高您整体的安全性。";
		return $result;
	}

	//报告判断是否有数据
	function report_bool($user_id,$date)
	{
                if($date=="y"){
			$date_item=date('Y');
		}else if($date=="m"){
			$date_item=date('Y-m');
		}else if($date=="d"){
			$date_item=date('Y-m-d');
		}
                $query_bool=$this->db->query("
                                        select 
                                                count(*) count_result 
                                        from 
                                                w3a_log_monitor_attack 
                                        where 
                                                attack_user='$user_id' 
                                        and 
                                                attack_date like '%$date_item%'");
		$result_bool=$query_bool->row();
		if($result_bool->count_result <= 0){
			return false;
		}else{
			return true;
		}

	}
}

?>
