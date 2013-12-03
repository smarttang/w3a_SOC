<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="<?=base_url().'css/table.css'?>" rel='stylesheet' type='text/css'>
</head>

<body>


	<!-- main container -->

        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>监控报告列表</h3>
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
            <th>网站名称</th>
            <th><center>网站IP/URL地址</th>
            <th><center>创建日期</th>
            <th><center>异常数据(年)</th>
            <th><center>异常数据(月)</th>
            <th><center>异常数据(日)</th>
	    <th><center>操作</th>
          </tr>
        </thead>
        <tbody>
        
	<?php
	foreach($net_monitor_report as $net_report_item):
	?>
          <tr id="mytable2">
            <td><? echo $net_report_item['task_name']; ?></td>
            <td><center><a class="urlcolor" href="<? echo $net_report_item['task_url'];?>" target="_blank"><? echo $net_report_item['task_url']?></a></td> 
            <td><center><? echo $net_report_item['task_create_date'];?></center></td>
	    <td style="color:blue;font-weight:bold;"><center><? echo $net_report_item['result_year']; ?></td>
	    <td style="color:red;font-weight:bold;"><center><? echo $net_report_item['result_month']; ?></td>
            <td style="color:green;font-weight:bold;"><center><? echo $net_report_item['result_day']; ?></td>
            <td>
		<center>
		  <div class="btn-group">
   			 <a class="btn btn-info btn-size dropdown-toggle btn-small" style="font-size:11px" data-toggle="dropdown" href="#">查看报告<span class="caret"></span></a>
    			 <ul class="dropdown-menu">
				<li><a href="javascript:remoteUrl('net_monitor_index/net_monitor_report_year/<? echo $net_report_item['id'];?>','查看报告');">查看年报</a></li>
                                <li><a href="javascript:remoteUrl('net_monitor_index/net_monitor_report_month/<? echo $net_report_item['id'];?>','查看报告');">查看月报</a></li>
                                <li><a href="javascript:remoteUrl('net_monitor_index/net_monitor_report_day/<? echo $net_report_item['id'];?>','查看报告');">查看日报</a></li>
    			</ul>
    		 </div>
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
</body>
</html>
