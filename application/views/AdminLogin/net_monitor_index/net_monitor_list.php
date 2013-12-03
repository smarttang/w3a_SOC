<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="<?=base_url().'/css/prettify.css'?>" rel="stylesheet">
    <link href="<?=base_url().'/css/bootstrap-modal.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url().'css/table.css'?>" rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
	<!-- main container -->
        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>监控网络列表</h3>
                    <div class="span10 pull-right">
                    <form class="form-search">
                        <button type="submit" class="btn pull-right">搜索</button>
                        <input type="text" class="span5 search input-medium search-query pull-right" placeholder="搜索监控任务..">
                    </form>
                    </div>
                </div>

       <table class="table table-striped table-bordered table-condensed table-hover no-margin">
          <thead>
          <tr id="mytable">
            <th>任务名称</th>
            <th><center>任务IP/URL地址</center></th>
	    <th><center>创建时间</center></th>
	    <th><center>最后检测时间</center></th>
            <th><center>服务类型</center></th>
	    <th><center>隶属客户</center></th>
            <th><center>任务状态</center></th>
            <th><center>操作</center></th>
          </tr>
        </thead>
        <tbody>
        
	<?php
	foreach($net_monitor_list as $net_monitor_item):
	?>
          <tr id="mytable2">
            <td><? echo $net_monitor_item['task_name']; ?></td>
            <td><center><a class="urlcolor" href="<? echo $net_monitor_item['task_url'];?>" target="_blank"><? echo $net_monitor_item['task_url']?></a></center></td> 
            <td><center><? echo $net_monitor_item['task_create_date'];?></center></td>
	    <td><center><? echo $net_monitor_item['task_last_date'];?></center></td>
	    <td><center><? echo $net_monitor_item['task_type']; ?></center></td>
	    <td><center><? echo $net_monitor_item['task_user_id']; ?></center></td>
	    <td name="status" value="<?=htmlspecialchars($net_monitor_item['task_mode']);?>">
		<center name="status_text_<?php echo $net_monitor_item['id'] ?>">
			<?
				$task_status=htmlspecialchars($net_monitor_item['task_mode']);
				if($task_status==0){
					echo "<div class='progress progress-striped active'><div class='bar' style='width: 100%;'>运行中</div></div>";
				}else{
					echo "<div class='progress progress-striped'><div class='bar bar-danger' style='width: 100%;'>已停止</div></div>";
				}
			?>
		</center>
	    </td>
            <td>
		<center>
<a class="btn btn-size" href="javascript:remoteUrl('<?=site_url().'/Admin/net_monitor_index/net_monitor_info/'.$net_monitor_item['id'];?>','查看任务');">查看任务</a>
                <a id="switch1" name="<? echo $net_monitor_item['id'];?>" onclick="exec_doing(this)" class="btn btn-info btn-size" value="<?=$net_monitor_item['task_mode'];?>">
                        <? if($net_monitor_item['task_mode']==0){
                                echo "停止服务";
                           }else{
                                echo "开启服务";
                           }
                        ?>
                </a>
		<a class="btn btn-primary btn-size" href="javascript:goToUrl('/net_monitor_index/net_monitor_change/<?=$net_monitor_item['id']?>');">修改任务</a>
		<a class="btn btn-success btn-size" href="javascript:goToUrl('/net_monitor_index/net_monitor_del/<?=$net_monitor_item['id'];?>');" onclick="javascript:return p_del()">删除任务</a>
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
    </div>
<script type="text/javascript">
     function exec_doing(o)
     {
        var select_id=o.getAttribute("name");
        var select_sw=o.getAttribute("value");
          $.ajax({
                type:'POST',
                url:'<?=site_url('Admin/net_monitor_index/net_monitor_switch')?>',
                data:{sw:select_sw,id:select_id},
                dataType:'text',
                timeout:2000,
                success:function(msg)
                {
                        var swtext=o.getAttribute("switch1");
                        if(msg=='on')
                        {
                                $('center[name=status_text_'+select_id+']').html("<div class='progress progress-striped active'><div class='bar' style='width: 100%;'>运行中</div></div>");
                                o.innerHTML='停止服务';
                                o.setAttribute('value',0);
                        }else if(msg=='off'){
                                $('center[name=status_text_'+select_id+']').html("<div class='progress progress-striped active'><div class='bar bar-danger' style='width: 100%;'>已停止</div></div>");
                                o.innerHTML='开启服务';
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
</html>
