<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <!-- bootstrap -->
    <link href="<?=base_url().'css/table.css'?>" rel='stylesheet' type='text/css'>
</head>

<body>


	<!-- main container -->

            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>监控规则列表</h3>
                    <div class="span10 pull-right">
                    <form class="form-search">
                        <button type="submit" class="btn pull-right">搜索</button>
                        <input type="text" class="span5 search input-medium search-query pull-right" placeholder="搜索监控任务..">
                    </form>
                    </div>
                </div>

       <table id="myTables" class="table table-striped table-bordered table-condensed no-margin">
          <thead>
          <tr id="mytable">
            <th><center>规则名称</center></th>
            <th><center>规则表达式</center></th>
	    <th><center>规则级别</center></th>
	    <th><center>触发量</center></th>
	    <th><center>规则创建时间</center></th>
	    <th><center>规则操作</center></th>
          </tr>
        </thead>
        <tbody>
        
       <?php
  	   foreach($log_monitor_method as $log_method_item):
	?>
          <tr id="mytables2">
            <td><center><? echo htmlspecialchars($log_method_item['method_name']);?></center></td>
            <td><center><? 
			   if(strlen($log_method_item['method_regex'])<90){
				echo htmlspecialchars($log_method_item['method_regex'],ENT_QUOTES);
			   }else{
				$split_result=str_split(htmlspecialchars($log_method_item['method_regex'],ENT_QUOTES),90);
				foreach($split_result as $split_item){
					print $split_item."<br />";
				}
		           }?></center></td>
	    <td><center name="level"><strong><? echo $log_method_item['method_level'];?></strong></center></td>
	    <td><center><? echo $log_method_item['attack_sum'];?></center></td>
	    <td><center><? echo $log_method_item['method_create_data'];?></center></td>
	    <td><center>
		<a id="switch" name="<? echo $log_method_item['id'];?>" onclick="exec_doing(this)" class="btn btn-info btn-size" value="<? echo $log_method_item['method_switch'];?>">
			<? if($log_method_item['method_switch']==0){
				echo "禁用规则";
			   }else{
				echo "启用规则";
			   }
			?>
		</a>
		<a class="btn btn-primary btn-size" href="javascript:goToUrl('log_monitor_index/log_method_change/<?echo $log_method_item['id'];?>');">修改规则</a>
		<a class="btn btn-success btn-size" href="javascript:goToUrl('log_monitor_index/log_method_del/<?echo $log_method_item['id'];?>');" onclick="javascript:return p_del()">删除规则</a>
		</center>
	    </td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
	<? if($page_list){
		echo $page_list;
	}?>

       </div>
     </div>


    <script type="text/javascript">
     $("center[name=level]").each(function(){
		var level=$(this).text();
		if(level=='高危'){
		    $(this).css('color','red');
		}else if(level=="中危"){
		    $(this).css('color','#FFCC00');
		}else if(level=="低危"){
		    $(this).css('color','green');
		}
     });
     function exec_doing(o){
	var select_id=o.getAttribute("name");
	var select_sw=o.getAttribute("value");
	  $.ajax({
		type:'POST',
		url:'<?=site_url('Admin/log_monitor_index/log_method_switch')?>',
		data:{sw:select_sw,id:select_id},
		dataType:'text',
		timeout:2000,
		success:function(msg){
			var swtext=o.getAttribute("switch");
			if(msg=='停用')
			{
				o.innerHTML='禁用规则';
				o.setAttribute('value',0);
			}else{
				o.innerHTML='启用规则';
				o.setAttribute('value',1);
			}
		},
		error:function(){
			o.innerHTML='失败了';
		}
	  });
     }
    </script>

</body>

<!-- Mirrored from detail.herokuapp.com/user-list.html by HTTrack Website Copier/3.x [XR&CO'2013], Fri, 02 Aug 2013 06:32:21 GMT -->
</html>
