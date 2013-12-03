<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="<?=base_url().'/css/prettify.css'?>" rel="stylesheet">
    <link href="<?=base_url().'/css/bootstrap-modal.css'?>" rel="stylesheet" type="text/css">

</head>
<body>
  <div class="container-fluid">
   <center><h3>日志监控报告（<?=$title;?>）</h3></center><br>
<br />
<h4 style="margin-left:8px;">漏洞触发统计图</h4><br />
      <div id="hero-tongji" style="height: 230px; width:100%"></div>
<br />
 <h4 style="margin-left:8px;">漏洞等级触发统计</h4><br />
 <legend></legend>
<table class="table table-striped table-bordered table-condensed table-hover no-margin">
    <thead>
      <tr id="mytable">
        <th>漏洞级别</th>
        <th>触发数量</th>
        <th>概述</th>
      </tr>
    </thead>
    <tbody>
      <tr id="mytable2">
        <td><span class="badge badge-success">低危</span></td>
        <td><? echo $log_report['low_count'];?></td>
        <td>
	  风险定义为低危，该类漏洞对系统存在一定的风险。
	</td>
      </tr>
      <tr>
        <td><span class="badge badge-warning" >中危</span></td>
        <td><? echo $log_report['warn_count'];?></td>
        <td>
	  风险定义为中危，该漏洞漏洞对系统存在较严重的威胁，攻击者利用该漏洞可能导致系统瘫痪或获得部分权限。
	</td>
      </tr>
      <tr>
        <td><span class="badge badge-important">高危</span></td>
        <td><? echo $log_report['high_count'];?></td>
        <td>
	  风险定义为高危，该漏洞一旦被攻击者利用，将会获得网站最高权限，甚至导致系统瘫痪。
	</td>
      </tr>
    </tbody>
  </table>
<br />
<br />
 <h4 style="margin-left:8px;">漏洞触发类型统计 Top 10</h4><br />
 <legend></legend>
<table id="myTables" class="table table-striped table-bordered table-condensed table-hover no-margin">
    <thead>
      <tr>
        <th>漏洞级别</th>
        <th>漏洞名称</th>
        <th>触发次数</th>
	<th>漏洞介绍</th>
      </tr>
    </thead>
    <tbody>
      <?php
         foreach($log_attack_top as $attack_item):
      ?>
      <tr>
	<? 
	 if(isset($attack_item['method_level'])){
	  if($attack_item['method_level']=='高危'){
		echo "<td><span class='label label-important'>".$attack_item['method_level']."</span></td>";
	  }else if($attack_item['method_level']=='中危'){
		echo "<td><span class='label label-warning'>".$attack_item['method_level']."</span></td>";
	  }else if($attack_item['method_level']=='低危'){
		echo "<td><span class='label label-success'>".$attack_item['method_level']."</span></td>";
	  }
	  echo "<td>".$attack_item['method_name']."</td>";
	  echo "<td>".$attack_item['count_method']."</td>";
	  echo "<td>".$attack_item['method_text']."</td>";
	}
	?>
      </tr>
	<? endforeach;?>
    </tbody>
  </table><br />
<br />
 <h4 style="margin-left:8px;">攻击源统计 Top 10</h4><br />
 <legend></legend>
<table id="myTables" class="table table-striped table-bordered table-condensed table-hover no-margin">
    <thead>
      <tr>
	<th>攻击源IP</th>
        <th>攻击数量</th>
        <th>开始时间</th>
        <th>结束时间</th>
	<th>潜伏天数</th>
	<th>潜伏时常</th>
      </tr>
    </thead>
    <tbody>
      <?php
         foreach($log_attack_source as $attack_source_item):
      ?>
      <tr>
	<?
          echo "<td>".$attack_source_item['attack_source']."</td>";
          echo "<td>".$attack_source_item['count_attack']."</td>";
          echo "<td>".$attack_source_item['start']."</td>";
          echo "<td>".$attack_source_item['end']."</td>";
          echo "<td>".$attack_source_item['days']."</td>";
          echo "<td>".$attack_source_item['times']."</td>";
        ?>
      </tr>
	<? endforeach;?>
    </tbody>
  </table><br />
<br />
<h4 style="margin-left:8px;">攻击行为分析</h4><br />
 <legend></legend>
<div style="font-size:14px;letter-spacing:1px;line-height:24pt">
<? echo $log_attack_behavior;?>
</div>
</div>

<script type="text/javascript">
   var ac=<?php echo $data_qx;?>;
   var time_arr=[];
   var data_arr=[];
   for(var i=0;i<ac.length;i++){
	time_arr.push(ac[i].time);
	data_arr.push(eval(ac[i].value));
   }
  
   $(function(){
        $('#hero-tongji').highcharts({
            exporting:{
                enabled:false
            },
            title: {
                text: '',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: time_arr
            },
            yAxis: {
                title: {
                    text: ''
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '次数'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: '触发量',
                data: data_arr
            }]
        });
    });
  
</script>

</body>
</html>
