<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
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
 </div>
</div>
</body>
</html>
