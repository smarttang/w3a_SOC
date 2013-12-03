<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div id="pad-wrapper" class="users-list">
  <div class="row-fluid header">
<div name="log" class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>修改日志监控规则</legend>

<input id="id" name="id" value="<? echo $log_method_result[0]['id']?>" class="input" type="text" style="display: none">
<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="method_name">规则名称</label>
  <div class="controls">
    <input id="method_name" name="method_name" value="<?=$log_method_result[0]['method_name'];?>" class="input" type="text">
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="method_regex">规则表达式</label>
  <div class="controls">
    <input id="method_regex" name="method_regex" value="<?=htmlspecialchars($log_method_result[0]['method_regex']);?>" class="input-large" type="text">
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="method_level">规则级别</label>
  <div class="controls">
    <select id="method_level" name="method_level" style="height:28px" class="input-medium">
     <?php foreach($log_method_level as $method_level_item):
      	 echo '<option value="'.$method_level_item['id'].'">'.$method_level_item['method_name'].'</option>';
	 endforeach;
       ?> 
    </select>
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="method_switch">规则状态</label>
  <div class="controls">
    <select id="method_switch" name="method_switch" style="height:26px" class="input-medium">
	<? if($log_method_result[0]['method_switch']==0){
        	echo '<option value="0">关闭规则</option>';
        	echo '<option value="1">启用规则</option>';
	   }else{
                echo '<option value="1">启用规则</option>';
                echo '<option value="0">关闭规则</option>';
	   }
	?>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="method_text">规则说明</label>
  <div class="controls">                     
    <textarea id="method_text" name="method_text" style="height:240px;width:500px;"><?=$log_method_result[0]['method_text'];?></textarea>
  </div>
</div>


<!-- Button (Double) -->
<div class="control-group">
  <div class="controls">
    <button id="button1id" name="button1id" class="btn btn-primary" onclick="postform();">提交</button>
    <button id="button2id" name="button2id" class="btn btn-info" onclick="goToUrl('/log_monitor_index/log_monitor_method_list')">返回</button>
  </div>
</div>
</fieldset>
</div>
</div>
</div>
<script type="text/javascript">
function postform(){
	var m_id=$('#id').val();
	var m_name=$('#method_name').val();
	var m_regex=$('#method_regex').val();
	var m_level=$('#method_level').val();
	var m_switch=$('#method_switch').val();
	var m_text=$('#method_text').val();
	if(check(m_id) && check(m_name) && check(m_regex) && check(m_level) && check(m_switch) && check(m_text)){
		$.ajax({
			type:'POST',
			url:'<?=site_url().'/Admin/log_monitor_index/log_method_update'?>',
			data:{id:m_id,method_name:m_name,method_regex:m_regex,method_level:m_level,method_switch:m_switch,method_text:m_text},
			dataType:'text',
			timeout:15000,
			success:function(){
				goToUrl('/log_monitor_index/log_monitor_method_list');
			},error:function(){
				$('#full-width h3').html("更新信息失败");
                                $('#full-width .modal-body').html('可能由于数据库连接失效，或填写有误导致无法更新信息，请检查>数据库链接代码，以及提交的数据.');
                                $('#full-width .modal-footer').html("<button type='button' data-dismiss='modal' class='btn'>返回</button>");

			}
		});
	}else{
              $('#full-width h3').html("输入有误");
              $('#full-width .modal-body').html('请检查你的输入是否有误，切勿使用过于敏感的字符。');
              $('#full-width .modal-footer').html("<button type='button' data-dismiss='modal' class='btn'>返回</button>");
	}
}
function check(obj){
	if(obj==""){
		return false;
	}else{
		return obj;
	}
}
</script>
</body>
</html>
