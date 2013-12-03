<!DOCTYPE html>
<html>

<!-- Mirrored from detail.herokuapp.com/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Fri, 02 Aug 2013 06:26:50 GMT -->
<head>
        <title>W3a-Log 个人登录</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!-- bootstrap -->
    <link href="<?=base_url().'css/bootstrap/bootstrap.css'?>" rel="stylesheet" />
    <link href="<?=base_url().'css/bootstrap/bootstrap-responsive.css'?>" rel="stylesheet" />
    <link href="<?=base_url().'css/bootstrap/bootstrap-overrides.css'?>" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="<?=base_url().'css/lib/jquery-ui-1.10.2.custom.css'?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url().'css/lib/font-awesome.css'?>" type="text/css" rel="stylesheet" />
    <link href="<?=base_url().'css/lib/morris.css'?>" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="<?=base_url().'css/layout.css'?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url().'css/elements.css'?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url().'css/icons.css'?>">

    <!-- this page specific styles -->
    <link rel="stylesheet" href="<?=base_url().'css/compiled/index.css'?>" type="text/css" media="screen" />    

    <!-- open sans font -->
    <link href="<?=base_url().'css/google-font.css'?>" rel='stylesheet' type='text/css'>

    <!-- lato font -->
    <link href="<?=base_url().'css/google-font2.css'?>" rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <style>
	body.modal-open,
	.modal-open .navbar-fixed-top,
	.modal-open .navbar-fixed-bottom {
	  margin-right: 0;
	}

	.modal {
	  left: 50%;
	  bottom: auto;
	  right: auto;
	  padding: 0;
	  width: 500px;
	  margin-left: -150px;
	  background-color: #ffffff;
	  border: 1px solid #999999;
	  border: 1px solid rgba(0, 0, 0, 0.2);
	  border-radius: 6px;
	  -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
	  box-shadow: 0 3px 9px rgba(0, 0, 0, 0.5);
	  background-clip: padding-box;
	}
	.modal.container {
	  max-width: none;
	}
    </style>
</head>

<body>
   <div id="full-width" class="modal container hide fade" style="top:100px;" tabindex="-1">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Full Width</h3>
    </div>
    <div class="modal-body">
	<form name="log" class="form-horizontal" action="<?=site_url('Admin/log_monitor_index/log_monitor_update')?>" method="POST" onSubmit="return checkFrom();">
    </div>
    <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
    </div>
    </div>

    <!-- navbar -->
    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <button type="button" class="btn btn-navbar visible-phone" id="menu-toggler">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
            <a class="brand" href="main.html"><img src="img/logo.png"></a>

            <ul class="nav pull-right">                
                <li class="notification-dropdown hidden-phone">
                    <a href="#" class="trigger">
                        <i class="icon-envelope-alt"></i>
                        <span class="count">3</span>
                    </a>
                    <div class="pop-dialog">
                        <div class="pointer right">
                            <div class="arrow"></div>
                            <div class="arrow_border"></div>
                        </div>
                        <div class="body">
                            <a href="#" class="close-icon"><i class="icon-remove-sign"></i></a>
                            <div class="notifications">
                                <h3>你有3个需要处理的消息</h3>
                                <a href="#" class="item">
                                    <i class="icon-signin"></i>测试消息 
                                    <span class="time"><i class="icon-time"></i> 18 min.</span>
                                </a>
                                <a href="#" class="item">
                                    <i class="icon-envelope-alt"></i>系统无法登录
                                    <span class="time"><i class="icon-time"></i> 28 min.</span>
                                </a>
                                <div class="footer">
                                    <a href="#" class="logout">查看全部消息</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle hidden-phone" data-toggle="dropdown">
                        管理员:<?=$username;?>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">修改密码</a></li>
                        <li><a href="#">修改个人信息</a></li>
                    </ul>
                </li>

                <li class="settings hidden-phone">
                    <a href="<?=base_url().'index.php/Admin/admin_index/logout'?>" role="button">
                        <i class="icon-share-alt"></i>
                    </a>
                </li>
            </ul>            
        </div>
    </div>
    <!-- end navbar -->
    <div id="sidebar-nav">
        <ul id="dashboard-menu">
            <li>
                <div id="pointer" class="pointer"> 
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
                    <a href="javascript:goToUrl('admin_index/default_body');" >
                    <i class="icon-home"></i>
                    <span>首页</span>
                </a>
            </li>
            <li>
                 <a class="dropdown-toggle">
                    <i class="icon-th-list"></i>
                    <span>日志监控</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul id="submenu" class="submenu">
                    <li><a href="javascript:goToUrl('log_monitor_index/log_monitor_list');">监控列表</a></li>
                    <li><a href="javascript:goToUrl('log_monitor_index/log_monitor_report');">报告列表</a></li>
                    <li><a href="javascript:goToUrl('log_monitor_index/log_monitor_add');">添加任务</a></li>
                    <li><a href="javascript:goToUrl('log_monitor_index/log_monitor_method_list');">规则列表</a></li>
		    <li><a href="javascript:goToUrl('log_monitor_index/log_monitor_method_add');">规则添加</a></li>
                </ul>
	    </li>
            <li>
                 <a class="dropdown-toggle">
                    <i class="icon-signal"></i>
                    <span>网络监控</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul id="submenu" class="submenu">
                    <li><a href="javascript:goToUrl('net_monitor_index/net_monitor_list');">监控列表</a></li>
		    <li><a href="javascript:goToUrl('net_monitor_index/net_monitor_report')">报告列表</a></li>
                    <li><a href="javascript:goToUrl('net_monitor_index/net_monitor_add');">添加任务</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle">
                    <i class="icon-group"></i>
                    <span>用户管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul id="submenu" class="submenu">
                    <li><a href="javascript:goToUrl('user_index/user_list');">用户列表</a></li>
                    <li><a href="javascript:goToUrl('user_index/role_list');">角色列表</a></li>
                    <li><a href="javascript:goToUrl('user_index/user_add');">添加用户</a></li>
                    <li><a href="javascript:goToUrl('user_index/role_add');">添加角色</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle">
                    <i class="icon-edit"></i>
                    <span>预警管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul id="submenu" class="submenu">
                    <li><a href="javascript:goToUrl('warning_index/warning_list');">预警模板列表</a></li>
                    <li><a href="javascript:goToUrl('warning_index/warning_add');">预警模板添加</a></li>
                    <li><a href="javascript:goToUrl('warning_index/warning_email_interface');">邮件接口设置</a></li>
                    <li><a href="javascript:goToUrl('warning_index/warning_message_interface');">短信接口设置</a></li>
                </ul>
            </li>
            <li>
                <a class="dropdown-toggle">
                    <i class="icon-envelope"></i>
                    <span>消息管理</span>
                    <i class="icon-chevron-down"></i>
                </a>
                <ul id="submenu" class="submenu">
                    <li><a href="message_index/message_opinion_list" target="right_frame">意见列表</a></li>
                    <li><a href="message_index/message_help_list" target="right_frame">协助列表</a></li>
                    <li><a href="message_index/message_question_list" target="right_frame">问题列表</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- end sidebar -->


	<!-- main container -->
<div class="content" id="container-fluid"></div>
	<!-- scripts -->
    <script src="<?=base_url().'/js/jquery-latest.js'?>"></script>
    <script src="<?=base_url().'/js/highcharts.src.js'?>"></script>
    <script src="<?=base_url().'/js/exporting.js'?>"></script>
    <script src="<?=base_url().'/js/bootstrap.min.js'?>"></script>
    <script src="<?=base_url().'/js/jquery-ui-1.10.2.custom.min.js'?>"></script>
    <script src="<?=base_url().'/js/bootstrap.datepicker.js'?>"></script>
    <!-- knob -->
    <script src="<?=base_url().'/js/jquery.knob.js'?>"></script>
    <!-- flot charts -->
    <script src="<?=base_url().'/js/jquery.flot.js'?>"></script>
    <script src="<?=base_url().'/js/jquery.flot.stack.js'?>"></script>
    <script src="<?=base_url().'/js/jquery.flot.resize.js'?>"></script>
    <script src="<?=base_url().'/js/theme.js'?>"></script>
    <!-- morrisjs -->
    <script type="text/javascript">
     function p_del() { 
	var msg = "您真的确定要删除吗?"; 
	if (confirm(msg)==true){ 
		return true; 
	}else{ 
		return false; 
	}
     } 
     $(document).ready(function(){
          $("#container-fluid").load("admin_index/default_body");
     });

     function goToUrl(url){

        $('#container-fluid').load('<?=site_url().'/Admin/'?>'+url);
     }

     function goToPage(url){
	$('#container-fluid').load(url);
     }
    function remoteUrl(url,name)
    {
        $.ajax({
                type:'GET',
                url:url,
                dataType:'html',
                timeout:2000,
                success:function(msg)
                {
                        if(name=="查看任务" || name=="查看报告")
                        {
                                $('#full-width h3').html(name);
                                $('#full-width .modal-body').html(msg);
                                $('#full-width .modal-footer').html("<button type='button' data-dismiss='modal' class='btn'>返回</button>");
                        }
                },error:function()
                {
                        $('#full-width h3').html(name+'读取异常');
                        $('#full-width .modal-body').html("读取失败,该地址无效！");
                        $('#full-width .modal-footer').html("<button type='button' data-dismiss='modal' class='btn'>返回</button>");
                }
        });
        $('#full-width').modal({show:true,backdrop:true});
    }
    function alertWaring(title,body){
	$('#full-width h3').html(title);
	$('#full-width .modal-body').html(body);
	$('#full-width .modal-footer').html("<button type='button' data-dismiss='modal' class='btn'>返回</button>");
	$('#full-width').modal({show:true,backdrop:true});
    }

    </script>

</body>

<!-- Mirrored from detail.herokuapp.com/index.html by HTTrack Website Copier/3.x [XR&CO'2013], Fri, 02 Aug 2013 06:26:50 GMT -->
</html>
