<?php

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	function index()
	{
		$this->load->helper('captcha');
		$vals = array(
    			'word' => rand(1000, 10000),
			'img_path' => 'captcha/',//必须是存在的目录，用于保持验证码图片
			'img_url' =>base_url().'/captcha/',
    			'img_width' => '120',
    			'img_height' => 35,
    			'expiration' => 7200//指定了验证码图片的超时删除时间. 默认是2小时.
    		);
		$cap = create_captcha($vals);//返回格式如下
		$data['cap']=$cap;
		$data['header']='W3A 应用系统';
		$this->load->view('login',$data);
	}
}
?>
