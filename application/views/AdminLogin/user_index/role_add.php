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
<form class="form-horizontal" action="<?=base_url().'/index.php/Admin/user_index/role_insert'?>" method="POST">
<fieldset>

<!-- Form Name -->
<legend>添加角色</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="username">角色名称</label>
  <div class="controls">
    <input id="username" name="role_name" placeholder="zhanghao" class="input" type="text">
  </div>
</div>
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
