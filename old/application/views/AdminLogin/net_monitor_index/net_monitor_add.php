<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div id="pad-wrapper" class="users-list">
    <div class="row-fluid header">
	<div name="log" class="form-horizontal" >
	<fieldset>

	<!-- Form Name -->
	<legend>添加网络监控任务</legend>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="task_name">任务名称</label>
	  <div class="controls">
	    <input id="task_name" name="task_name" placeholder="任务名称" class="input" type="text">
	  </div>
	</div>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="task_url">任务URL/IP地址</label>
	  <div class="controls">
	    <input id="task_url" name="task_url" placeholder="任务URL/IP地址"  class="input-large" type="text">
	  </div>
	</div>

	<!-- Select Basic -->
	<div class="control-group">
	  <label class="control-label" for="task_user_id">隶属客户</label>
	  <div class="controls">
	    <select id="task_user_id" name="task_user_id" style="height:26px" class="input-medium">
	      <?php foreach($net_user_id as $net_user_id_item):
	      	 echo '<option value="'.$net_user_id_item['id'].'">'.$net_user_id_item['name'].'</option>';
		 endforeach;
	       ?>
	    </select>
	  </div>
 	</div>
       <div class="control-group">
         <label class="control-label" for="task_service_type">任务类型</label>
         <div class="controls">
           <select id="task_service_type" name="task_service_type" style="height:28px" class="input-medium">
         <?php
            foreach($net_monitor_type as $net_monitor_type_item):
                echo '<option value="'.$net_monitor_type_item['id'].'">'.$net_monitor_type_item['monitor_name'].'</option>';
            endforeach;
          ?>
          </select>
         </div>
       </div>
	<!-- Button (Double) -->
	<div class="control-group">
	  <div class="controls">
	    <button id="button1id" name="button1id" class="btn btn-primary" onclick="postform();">提交</button>
	    <button id="button2id" name="button2id" class="btn btn-info" onclick="goToUrl('/net_monitor_index/net_monitor_list')">返回</button>
	  </div>
	</div>
	</fieldset>
	</div>
	</div>
        </div>
	<!-- scripts -->
    <script type="text/javascript">
     function postform(){
        var task_n=$('#task_name').val();
        var task_u=$('#task_url').val();
	var task_u_id=$('#task_user_id').val();
        var task_t=$('#task_service_type').val();
        if(checkFrom(task_u)){
                $.ajax({
                        type:'POST',
                        url:'<?=site_url().'/Admin/net_monitor_index/net_monitor_insert'?>',
                        data:{task_name:task_n,task_url:task_u,task_user_id:task_u_id,task_service_type:task_t},
                        dataType:'text',
                        timeout:15000,
                        success:function(){
                                goToUrl('/net_monitor_index/net_monitor_list');
                        },error:function(){
				alertWaring("任务添加失败","可能由于数据库连接失效，或填写有误导致无法更新信息，请检查数据库链接代码，以及提交的数据.");
                        }
                });  
        }

     }

	function checkFrom(url){
		if(IsURL(url)){
		   return true;
		}else{
		   alertWaring("输入有误!",'您的输入有误,请输入合法的URL/IP地址!');
		   return false;
		}
	}
	function IsURL(str_url){
  	var strRegex = "^((https|http)?://)" 
        + "(([0-9]{1,3}.){3}[0-9]{1,3}"  
        + "|" 
        + "([0-9a-z_!~*'()-]+.)*"  
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]." 
        + "[a-z]{2,6})" 
        + "(:[0-9]{1,4})?"  
        + "((/?)|"  
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$"; 
	var ipRegex =re=/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/;
        var re=new RegExp(strRegex); 
	var re2=new RegExp(ipRegex);
        if (re.test(str_url)){
            return true; 
        }else{
	    if(re2.test(str_url)){
		if( RegExp.$1<256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256){
			return true;
		}else{
			return false;
		}
	    }
        }
    }
    </script>
</body>
</html>
