<?php

class User_index_data extends CI_Model{
	function __construct()
	{
		//装载日期辅助函数
		$this->load->helper('date');
		//装载数据库函数
		$this->load->database();
	}

	/*********************
		查询数据部分

	**********************/

	//查询所有用户数据
	function select_user($total,$offset){
		$sql="select id,useranme,password,name,email,mobile_phone,(select role_name from w3a_role where role_id=purview) purview from w3a_user limit $total,$offset";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	//查询所有的角色数据
	function select_role($total,$offset){
		$sql="select * from w3a_role limit $total,$offset";
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	
	function select_role_sum(){
		$query=$this->db->get('w3a_role');
		return $query->num_rows();
	}

	function select_user_sum(){
		$query=$this->db->get('w3a_user');
		return $query->num_rows();
	}
	/***********************
		插入数据部分

	************************/

        //新建用户
        function user_add($purview,$username,$password,$name,$email,$mobile_phone)
        {
                $data=array( 
                         'purview' => $purview, 
                         'useranme' => $username,
                         'password' => $password,
                         'name' => $name,
                         'email' => $email,
                         'mobile_phone' => $mobile_phone);
                 return $this->db->insert('w3a_user', $data);
        }

	//新建角色
	function role_add($role_name)
	{
		//先查询出总数
		$role_number=$this->db->count_all_results('w3a_role');
		//总的数量+1
		$role_id=$role_number;
		//设置日期格式
		$date_type="%Y-%m-%d %h:%i:%a";
		//设置日期
		$date_set=mdate($date_type,time());
		$data=array(
			 'role_name' => $role_name,
			 'role_id' => $role_id,
			 'role_date' => $date_set);
		return $this->db->insert('w3a_role',$data);
	}

	/***********************
		删除数据部分

	***********************/

	function user_del($id)
	{
		$this->db->where('id',$id);
		if($this->db->delete('w3a_user')){
			return true;
		}else{
			return false;
		}
	}

	function role_del($id)
	{
		$this->db->where('id',$id);
		if($this->db->delete('w3a_role')){
			return true;
		}else{
			return false;
		}
	}

}

?>
