<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=base_url().'/css/prettify.css'?>" rel="stylesheet">
    <link href="<?=base_url().'/css/bootstrap-modal.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=base_url().'css/table.css'?>" rel='stylesheet' type='text/css'>
</head>
<body>
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
            <th>任务名称</th>
            <th><center>任务IP/URL地址</th>
	    <th><center>创建时间</th>
	    <th><center>高危(日)</th>
            <th><center>高危(月)</th>
            <th><center>高危(年)</th>
            <th><center>中危(日)</th>
            <th><center>中危(月)</th>
            <th><center>中危(年)</th>
            <th><center>低危(日)</th>
            <th><center>低危(月)</th>
            <th><center>低危(年)</th>
            <th><center>操作</th>
          </tr>
        </thead>
        <tbody>
        
       <?php
  	   foreach($log_monitor_report as $log_report_item):
	?>
          <tr id="mytable2">
            <td><? echo $log_report_item['task_name']; ?></td>
            <td><center><a class="urlcolor" href="<? echo $log_report_item['task_url'];?>" target="_blank"><? echo $log_report_item['task_url']?></a></td> 
            <td><center><? echo $log_report_item['task_create_date'];?></td>
	    <td><center><span class="label label-important"><strong><? echo $log_report_item['task_high']?></strong></span></td>
	    <td><center><span class="label label-important"><strong><? echo $log_report_item['task_high_month']; ?></strong></span></td>
            <td><center><span class="label label-important"><strong><? echo $log_report_item['task_high_year']; ?></strong></span></td>
	    <td><center><span class="label label-warning"><strong><? echo $log_report_item['task_warn'];?></strong></span></td>
            <td><center><span class="label label-warning"><strong><? echo $log_report_item['task_warn_month'];?></strong></span></td>
            <td><center><span class="label label-warning"><strong><? echo $log_report_item['task_warn_year'];?></strong></span></td>
	    <td><center><span class="label label-success"><strong><? echo $log_report_item['task_low']; ?></strong></span></td>
            <td><center><span class="label label-success"><strong><? echo $log_report_item['task_low_month']; ?></strong></span></td>
            <td><center><span class="label label-success"><strong><? echo $log_report_item['task_low_year']; ?></strong></span></td>
            <td>
		<center>
		  <div class="btn-group">
   			 <a class="btn btn-info btn-size dropdown-toggle btn-small" style="font-size:11px" data-toggle="dropdown" href="#"> 查看报告<span class="caret"></span></a>
    			 <ul class="dropdown-menu">
				<li><a href="javascript:remoteUrl('log_monitor_index/log_monitor_report_year/<? echo $log_report_item['id'];?>','查看报告');">查看年报</a></li>
                                <li><a href="javascript:remoteUrl('log_monitor_index/log_monitor_report_month/<? echo $log_report_item['id'];?>','查看报告');">查看月报</a></li>
                                <li><a href="javascript:remoteUrl('log_monitor_index/log_monitor_report_day/<? echo $log_report_item['id'];?>','查看报告');">查看日报</a></li>
    			</ul>
    		 </div>
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
</body>

<!-- Mirrored from detail.herokuapp.com/user-list.html by HTTrack Website Copier/3.x [XR&CO'2013], Fri, 02 Aug 2013 06:32:21 GMT -->
</html>
