<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!-- bootstrap -->
    <link href="<?=base_url().'/css/bootstrap/bootstrap.css'?>" rel="stylesheet" />
    <link href="<?=base_url().'/css/bootstrap/bootstrap-responsive.css'?>" rel="stylesheet" />
    <link href="<?=base_url().'/css/bootstrap/bootstrap-overrides.css'?>" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="<?=base_url().'/css/lib/jquery-ui-1.10.2.custom.css'?>" rel="stylesheet" type="text/css" />
    <link href="<?=base_url().'/css/lib/font-awesome.css'?>" type="text/css" rel="stylesheet" />
    <link href="<?=base_url().'/css/lib/morris.css'?>" type="text/css" rel="stylesheet" />

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
</head>

<body>


	<!-- main container -->
    <div class="content">
        
        <!-- settings changer -->
        
        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
<form class="form-horizontal" action="<?=base_url().'/index.php/Admin/user_index/user_insert'?>" method="POST">
<fieldset>

<!-- Form Name -->
<legend>添加用户</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="username">帐号名称</label>
  <div class="controls">
    <input id="username" name="username" placeholder="zhanghao" class="input" type="text">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="name">用户名称</label>
  <div class="controls">
    <input id="name" name="name" placeholder="name" class="input-large" type="text">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="password">登录密码</label>
  <div class="controls">
    <input id="password" name="password" placeholder="name" class="input-large" type="password">
  </div>
</div>


<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="mobile-phone">联系电话</label>
  <div class="controls">
    <input id="mobile-phone" name="mobile-phone" placeholder="phone" class="input-large" type="text">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">邮件地址</label>
  <div class="controls">
    <input id="email" name="email" placeholder="email" class="input-large" type="text">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="purview">用户级别</label>
  <div class="controls">
    <input id="purview" name="purview" placeholder="purview" class="input-medium" type="text">
  </div>
</div>

<!-- Button (Double) -->
<div class="control-group">
  <div class="controls">
    <button id="button1id" name="button1id" class="btn btn-primary">提交</button>
    <button id="button2id" name="button2id" class="btn btn-info">返回</button>
  </div>
</div>

</fieldset>
</form>

		</div>
                <!-- end users table -->
            </div>
        </div>
    </div>
    <!-- end main container -->


	<!-- scripts -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/theme.js"></script>
</body>

<!-- Mirrored from detail.herokuapp.com/user-list.html by HTTrack Website Copier/3.x [XR&CO'2013], Fri, 02 Aug 2013 06:32:21 GMT -->
</html>
