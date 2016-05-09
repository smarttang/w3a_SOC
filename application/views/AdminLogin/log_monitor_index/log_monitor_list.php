<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="<?=base_url().'/css/prettify.css'?>" rel="stylesheet">
    <link href="<?=base_url().'/css/bootstrap-modal.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url().'/css/table.css'?>" rel='stylesheet' type='text/css'>
</head>
<body>
             <div id="pad-wrapper">
                <div class="row-fluid header">
                    <h3>监控日志列表</h3>
                    <div class="span10 pull-right">
                    <div class="form-search">
                        <button type="submit" class="btn pull-right" onclick="doSearch();">搜索</button>
                        <input id="search" name="search" type="text" class="span5 search input-medium search-query pull-right" placeholder="搜索监控任务..">
                    </div>
                    </div>
                </div>

       <table id="myTables" class="table table-striped table-bordered table-condensed table-hover no-margin">
          <thead>
          <tr id="mytable">
            <th>
		任务名称
	    </th>
            <th>
		<center>
			任务IP/URL地址
		</center>
	    </th>
	    <th>
		<center>
			创建时间
		</center>
	    </th>
	    <th>
		<center>
			最后接收时间
		</center>
	    </th>
	    <th>
		<center>
			日志类型
		</center>
	    </th>
            <th>
		<center>
			任务状态
		</center>
	    </th>
	    <th>
		<center>
			隶属客户
		</center>
	    </th>
            <th>
		<center>
			任务操作
		</center>
	    </th>
          </tr>
        </thead>
        <tbody>
        
       <?php
  	   foreach($log_monitor_list as $log_monitor_item):
	?>
          <tr id="mytable2">
	    <td id="monitor_id" style="display:none;">
		<?=$log_monitor_item['id'];?>
	    </td>
            <td><?=htmlspecialchars($log_monitor_item['task_name']); ?></td>
            <td>
		<center>
			<a class="urlcolor" href="<?=htmlspecialchars($log_monitor_item['task_url']);?>" target="_blank">
				<?=$log_monitor_item['task_url']?>
			</a>
		</center>
	    </td> 
            <td>
		<center>
			<?=$log_monitor_item['task_create_date'];?>
		</center>
	    </td>
	    <td name="data_time">
		<center>
			<?=$log_monitor_item['task_last_date'];?>
		</center>
	    </td>
	    <td>
		<center>
			<?=htmlspecialchars($log_monitor_item['task_service_type']); ?>
		</center>
	    </td>
	    <td name="status" value="<?=htmlspecialchars($log_monitor_item['task_status']);?>">
		<center name="status_text_<?php echo $log_monitor_item['id'] ?>">
			<?
				$task_status=htmlspecialchars($log_monitor_item['task_status_text']);
				if($task_status== "监控中"){
					echo "<i class='alert-success icon-ok-sign'></i>";
				}else{
					echo "<i class='alert-danger icon-remove-sign'></i>";
				}
			?>
		</center>
	    </td>
	    <td>
		<center>
			<?=$log_monitor_item['task_user_id'];?>
		</center>
	    </td>
            <td>
		<center>
		<a class="btn btn-size" href="javascript:remoteUrl('<?=site_url().'/Admin/log_monitor_index/log_monitor_info/'.$log_monitor_item['id'];?>','查看任务');">查看任务</a>
		<a id="switch" name="<? echo $log_monitor_item['id'];?>" onclick="exec_doing(this)" class="btn btn-info btn-size" value="<?=$log_monitor_item['task_switch'];?>">
                        <? if($log_monitor_item['task_switch']==0){
                                echo "开启监控";
                           }else{
                                echo "暂停监控";
                           }
                        ?>
                </a>
		<a class="btn btn-primary btn-size"  href="javascript:goToUrl('/log_monitor_index/log_monitor_change/<?=$log_monitor_item['id'];?>');">修改任务</a>
		<a class="btn btn-success btn-size" href="javascript:goToUrl('/log_monitor_index/log_monitor_del/<?=$log_monitor_item['id'];?>');" onclick="javascript:return p_del()">删除任务</a>
		</center>
	    </td>
          </tr>
          <tr>
        <?php endforeach;?>
        </tbody>
      </table>
	<? if($page_list){
		echo $page_list;
	  }?>
       </div>
     </div>
    <script type="text/javascript">
     //setInterval("getData()",60000);
     function doSearch()
     {
	var search_val=$('#search').val();
	if(search_val !=null){
		$.ajax({
			type:'POST',
			url:'<?=site_url('Admin/log_monitor_index/log_monitor_seach')?>',
			data:{task_name:search_val},
			dataType:'text',
			timeout:2000,
			success:function(msg)
			{
				if(msg!=''){
					$('tbody').html(msg);
				}else{
					alertWaring('查询结果','没有该数据，请重新查询!');	
				}
			},
			error:function()
			{
				alertWaring('警告','查询的结果有异常,请仔细检查输入,以及接口.');
			}
		});
	}
     }
     function getData()
     {
		$.ajax({
			type:'GET',
			url:'<?=site_url('Admin/log_monitor_index/log_data_list')?>',
			dataType:'text',
			timeout:2000,
			success:function(msg)
			{
				var result=msg.split('|');
	 			$("td[name=data_time]").each(function(i)
				 {
					$(this).html('<center>'+result[i]+'</center>');
				 });
			},
			error:function()
			{
                                 $("td[name=data_time]").each(function()
				 {
                                        $(this).html('error');
                                 });

			}
		});
		$.ajax({
			type:'GET',
			url:'<?=site_url('Admin/log_monitor_index/log_status_list')?>',
			dataType:'text',
			timeout:10000,
			success:function(msg)
			{
				var result=msg.split('|');
				$('td[name=status]').each(function(i)
				{
					$(this).html('<center>'+result[i]+'</center>');
				});
			},
			error:function()
			{
                                $('td[name=status]').each(function()
				{
                                        $(this).html('error');
                                });

			}
		});
     }
     function exec_doing(o)
     {
	var select_id=o.getAttribute("name");
	var select_sw=o.getAttribute("value");
	  $.ajax({
		type:'POST',
		url:'<?=site_url('Admin/log_monitor_index/log_monitor_switch')?>',
		data:{sw:select_sw,id:select_id},
		dataType:'text',
		timeout:2000,
		success:function(msg)
		{
			var swtext=o.getAttribute("switch");
			if(msg=='关闭')
			{
				$('center[name=status_text_'+select_id+']').html("<i class='alert-danger icon-remove-sign'></i>");
				o.innerHTML='开启监控';
				o.setAttribute('value',0);
			}else{
				$('center[name=status_text_'+select_id+']').html("<i class='alert-success icon-ok-sign'></i>");
				o.innerHTML='暂停监控';
				o.setAttribute('value',1);
			}
		},
		error:function()
		{
			o.innerHTML='失败了';
		}
	  });
    }
    </script>

</body>

<!-- Mirrored from detail.herokuapp.com/user-list.html by HTTrack Website Copier/3.x [XR&CO'2013], Fri, 02 Aug 2013 06:32:21 GMT -->
</html>
