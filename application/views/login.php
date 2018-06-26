<html class="login-bg">
<head>
	<title>W3A 应用系统</title>
         <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="<?=base_url().'css/bootstrap/bootstrap.css'?>" rel="stylesheet">
    <link href="<?=base_url().'css/bootstrap/bootstrap-responsive.css'?>" rel="stylesheet">
    <link href="<?=base_url().'css/bootstrap/bootstrap-overrides.css'?>" type="text/css" rel="stylesheet">

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="<?=base_url().'css/layout.css'?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url().'css/elements.css'?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url().'css/icons.css'?>">

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="<?=base_url().'css/lib/font-awesome.css'?>">
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="<?=base_url().'css/compiled/signin.css'?>" type="text/css" media="screen" />
  <style type="text/css">a:active, a:focus {-moz-outline:none;outline:none;ie-dummy:expression(this.hideFocus=true);}</style>
  <style type="text/css">a:link,a:visited{text-decoration:none;  /*超链接无下划线*/} img {margin-top:-20px;}</style>

    <!-- open sans font -->

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
    <div class="row-fluid login-wrapper">
  <form  name="user_login" class="form-horizontal" action="<?=base_url().'index.php/inc/check/login_in'?>" method="POST" onSubmit="return doCheck();" >
        <a></a>

        <div class="span4 box">
            <div class="content-wrap">
                <h6><?=$header?></h6>
                <input class="span12" name="username" type="text" placeholder="用户名">
                <input class="span12" name="password" type="password" placeholder="密  码">
                <a href="#" class="forgot">忘记密码?</a>
                <button id="buttion1id" class="btn-glow primary login" name="buttion1id">登录</a>
            </div>
        </div>
</form>
        <div class="span4 no-account">
            <p>注册一个新用户?</p>
            <a href="signup.html">用户注册</a>
            <p> 默认账号密码: admin/admin</p>
        </div>
    </div>

	<!-- scripts -->
    <script src="<?=base_url().'js/jquery-latest.js'?>"></script>
    <script src="<?=base_url().'js/bootstrap.min.js'?>"></script>
    <script src="<?=base_url().'js/theme.js'?>"></script>

</body>

</html>

