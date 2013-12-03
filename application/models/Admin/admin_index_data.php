<?php

class Admin_index_data extends CI_Model{
	function __construct()
	{
		$this->load->database();
	}

	//查询所有网络监控数据
	function select_json_dw()
	{
		$sql_count="select sum(count_result) count_result from (select web_status status,count(web_status) count_result from (select * from w3a_net_monitor_web_attack) t group by web_status union all select network_status,count(network_status) from (select * from w3a_net_monitor_network_attack) t group by network_status ) t";
		$query_sum=$this->db->query($sql_count);
		$rows=$query_sum->row();
		$sql="select web_status status,count(web_status) count_result from (select * from w3a_net_monitor_web_attack) t group by web_status union all select network_status,count(network_status) from (select * from w3a_net_monitor_network_attack) t group by network_status";
		$query=$this->db->query($sql);
		foreach($query->result_array() as $result_item){
			$dataset[]=array(
					 $result_item['status'],
					 intval(sprintf("%.2f",intval($result_item['count_result'])/intval($rows->count_result)*100))
					);
		}
		$json=json_encode($dataset);
		return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", $json);
		
	}

	//查询数量通用
	function select_row($obj)
	{
		$query=$this->db->get($obj);
		return $query->num_rows();
	}

	//查询总数
	function select_sum($obj){
		$query=$this->db->query($obj);
		$now=$query->result_array();
		return $now['0']['sum_result'];
	}
	
	//查询历史数据综合(按年)
	function select_json_year()
	{
		$date_y=date('Y');
		$year_data=array(
				"$date_y-1",
				"$date_y-2",
				"$date_y-3",
				"$date_y-4",
				"$date_y-5",
				"$date_y-6",
				"$date_y-7",
				"$date_y-8",
				"$date_y-9",
				"$date_y-10",
				"$date_y-11",
				"$date_y-12"
		);

		$sql_web_attack="SELECT CONCAT(YEAR(attack_date),'-',MONTH(attack_date)) month,count(*) count_all FROM w3a_log_monitor_attack GROUP BY CONCAT(YEAR(attack_date),'-',MONTH(attack_date)) order by month desc";

		$query=$this->db->query($sql_web_attack);
		$web_attack_results=$query->result_array();

		foreach($year_data as $year_item){
                        if(empty($data_web[$year_item])){
                                $data_web[$year_item]=0;
                        }

			foreach($web_attack_results as $w_item){
				if($year_item == $w_item['month']){
					$data_web[$year_item]=intval($w_item['count_all']);
				}
			}

		}

		$sql_net_attack="select month,sum(count_all) count_all from (SELECT CONCAT(YEAR(time_start),'-',MONTH(time_start)) month,count(*) count_all FROM w3a_net_monitor_web_attack GROUP BY CONCAT(YEAR(time_start),'-',MONTH(time_start)) union all SELECT CONCAT(YEAR(time_start),'-',MONTH(time_start)) month,count(*) count_all FROM w3a_net_monitor_network_attack GROUP BY CONCAT(YEAR(time_start),'-',MONTH(time_start))) t group by month desc";

		$query2=$this->db->query($sql_net_attack);
		$net_attack_results=$query2->result_array();

                foreach($year_data as $year_item){
                        if(empty($data_net[$year_item])){
                                $data_net[$year_item]=0;
                        }

                        foreach($net_attack_results as $n_item){
                                if($year_item == $n_item['month']){
                                        $data_net[$year_item]=intval($n_item['count_all']);
                                }
                        }

                }
		$k=0;
		for($i=1;$i<=12;$i++){
			$web_result[$i]=intval($data_web["$date_y-$i"]);
			$net_result[$i]=intval($data_net["$date_y-$i"]);
			$day_result[$i]=$year_data[$k];
			$k++;
		}
		$data['web_attack']=$web_result;
		$data['net_attack']=$net_result;
		$data['data_time']=$day_result;
		return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($data));
	}
	
        //查询历史数据综合(按月)
        function select_json_month()
	{
		$all_day=date('t');

		$sql_web_attack="SELECT CONCAT(YEAR(attack_date),'-',MONTH(attack_date),'-',DAY(attack_date)) day,count(*) count_all FROM w3a_log_monitor_attack GROUP BY CONCAT(YEAR(attack_date),'-',MONTH(attack_date),'-',DAY(attack_date)) order by day desc";
		$query=$this->db->query($sql_web_attack);

		for($i=1;$i<=$all_day;$i++)
		{
			$date_item=date('Y-m')."-$i";

			if(empty($web_data[$date_item]))
			{
				$web_data[$date_item]=0;
			}
			foreach($query->result_array() as $item)
			{
				if($date_item==$item['day'])
				{
					$web_data[$date_item]=$item['count_all'];
				}
			}
		}

		$sql_net_attack="select day, sum(count_all) count_all from (SELECT CONCAT(YEAR(time_start),'-',MONTH(time_start),'-',DAY(time_start)) day,count(*) count_all FROM w3a_net_monitor_web_attack GROUP BY CONCAT(YEAR(time_start),'-',MONTH(time_start),'-',DAY(time_start)) union all SELECT CONCAT(YEAR(time_start),'-',MONTH(time_start),'-',DAY(time_start)) day,count(*) count_all FROM w3a_net_monitor_network_attack GROUP BY CONCAT(YEAR(time_start),'-',MONTH(time_start),'-',DAY(time_start)) order by day desc) t group by day";

		$query_sec=$this->db->query($sql_net_attack);
		
		for($i=1;$i<=$all_day;$i++)
		{
			$date_item=date('Y-m')."-$i";

			if(empty($net_data[$date_item]))
			{
				$net_data[$date_item]=0;
			}
			foreach($query_sec->result_array() as $item)
			{
				if($date_item==$item['day']){
					$net_data[$date_item]=$item['count_all'];
				}
			}
		}
                for($i=1;$i<=$all_day;$i++){
                        $web_result[$i]=intval($web_data[date('Y-m')."-$i"]);
                        $net_result[$i]=intval($net_data[date('Y-m')."-$i"]);
                        $day_result[$i]=date('m')."-$i";
                }
                $data['web_attack']=$web_result;
                $data['net_attack']=$net_result;
                $data['data_time']=$day_result;
                return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($data));
		
	}

	//查询历史数据综合(按天)
	function select_json_day()
	{

                $sql_web_attack="SELECT HOUR(attack_date) hour,count(*) count_all FROM w3a_log_monitor_attack WHERE attack_date > DATE(NOW()) GROUP BY HOUR(attack_date)";
                $query=$this->db->query($sql_web_attack);

                for($i=0;$i<=24;$i++)
                {
                        if(empty($web_data[$i]))
                        {
                                $web_data[$i]=0;
                        }
                        foreach($query->result_array() as $item)
                        {
                                if($i==$item['hour'])
                                {
                                        $web_data[$i]=$item['count_all'];
                                }
                        }
                }

                $sql_net_attack="select hour,sum(count_all) count_all from (SELECT HOUR(time_start) hour,count(*) count_all FROM w3a_net_monitor_web_attack WHERE time_start > DATE(NOW()) GROUP BY HOUR(time_start) union all SELECT HOUR(time_start) hour,count(*) count_all FROM w3a_net_monitor_network_attack WHERE time_start > DATE(NOW()) GROUP BY HOUR(time_start)) t group by hour";

                $query_sec=$this->db->query($sql_net_attack);

                for($i=0;$i<=24;$i++)
                {
                        if(empty($net_data[$i]))
                        {
                                $net_data[$i]=0;
                        }
                        foreach($query_sec->result_array() as $item)
                        {
                                if($i==$item['hour']){
                                        $net_data[$i]=$item['count_all'];
                                }
                        }
                }
                for($i=0;$i<=24;$i++){
                        $web_result[$i]=intval($web_data[$i]);
                        $net_result[$i]=intval($net_data[$i]);
                        $day_result[$i]=$i."时";
                }
                $data['web_attack']=$web_result;
                $data['net_attack']=$net_result;
                $data['data_time']=$day_result;
                return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($data));


	}

	//web攻击统计
	function select_json_all(){
		$query=$this->db->query('select method_name,attack_sum from w3a_log_method order by attack_sum desc limit 10');
		$data_result=$query->result_array();
		foreach($query->result_array() as $item){
		  	$data[]=array('攻击类型'=>$item['method_name'],'触发量'=>$item['attack_sum']);
		}
		return preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\\1'))", json_encode($data));
	}

}
?>
