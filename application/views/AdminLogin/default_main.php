<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?=base_url().'js/raphael-min.js'?>"></script>
    <script src="<?=base_url().'js/morris.min.js'?>"></script>
</head>
<body>

    <!-- main container -->
        <div class="container-fluid">

            <!-- upper main stats -->
            <div id="main-stats">
                <div class="row-fluid stats-row">
                    <div class="span3 stat">
                        <div class="data">
                            捕获攻击
                            <span class="number"><?=$web_attack_num;?></span>
                        </div>
                        <span class="date">至今天</span>
                    </div>
                    <div class="span3 stat">
                        <div class="data">
                            捕获异常
                            <span class="number"><?=$net_attack_num;?></span>
                        </div>
                        <span class="date">至今天</span>
                    </div>
                    <div class="span3 stat">
                        <div class="data">
                            用户数量
                            <span class="number"><?=$user_num;?></span>
                        </div>
                        <span class="date">至今天</span>
                    </div>
                </div>
            </div>
            <!-- end upper main stats -->

            <div id="pad-wrapper">

                <!-- statistics chart built with jQuery Flot -->
                <div class="row-fluid chart">
                    <h4>
                        历史波动
			<div class="btn-group pull-right">
				<button id="day" class="glow left" onclick="javascript:histroy_do('day')">当天</button>
				<button id="month" class="glow middle" onclick="javascript:histroy_do('month')">当月</button>
				<button id="year" class="glow right active" onclick="javascript:histroy_do('year')">当年</button>
			</div>
                    </h4>
                    <div class="span12">
                        <div id="statsChart"></div>
                    </div>
                </div>
                <!-- end statistics chart -->
                <!-- 两个新的图表 -->
                  <div class="row-fluid">
                    <div class="span6">
                     <!-- morris graph chart -->
                      <div class="row-fluid section">
                         <h4 class="title">断网类型统计</h4>
                         <div class="span12 chart">
                            <div id="hero-graph" style="height: 230px;width:80%"></div>
                         </div>
                      </div>
                    </div>
                    <div class="span6">
                     <div class="row-fluid section">
                     <div class="span6 chart">
                         <h4 class="title">Web攻击类型统计</h4>
                         <div id="hero-bar" style="height: 260px;width: 220%; marge-right: 10px;"></div>
                       </div>
                     </div>
                    </div>
                  </div>
                <!-- 图表结束-->
            </div>
        </div>
        <!-- scripts -->
    <script type="text/javascript">
    histroy_do('year');
    $.ajax({
	type:'GET',
	url:'<?=site_url('Admin/admin_index/select_web_attack')?>',
	dataType:'json',
	timeout:2000,
	success:function(msg)
	{
	  var attack_name=new Array();
	  var attack_sum=new Array();
	  for(var i=0;i<msg.length;i++){
		attack_name.push(msg[i].攻击类型);
		var num=eval(msg[i].触发量);
		if(!isNaN(num) && num>=0)
		{
			attack_sum.push(num);
		}else{
			attack_sum.push(0);
		}
	  }
        $('#hero-bar').highcharts({
            exporting:{
                enabled:false
            },
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: ''
            },
            xAxis: {
                categories:attack_name,
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '触发量: <b>{point.y:.1f} 次</b>',
            },
            series: [{
                name: '触发量',
                data: attack_sum,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '10px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });
	},
	error:function()
	{
		alert('没有数据，或数据异常，请检查数据。');
		//goToUrl('/log_monitor_index/log_monitor_list');
	}
    });
        $.ajax({
		type:'GET',
		url:'<?=site_url('Admin/admin_index/select_dw_json')?>',
		dataType:'json',
		timeout:2000,
		success:function(msg){
		    $('#hero-graph').highcharts({
		        exporting:{
		                enabled:false
		        },
		        chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,
		            plotShadow: false
		        },
		        title: {
		            text: ''
		        },
		        tooltip: {
		    	    pointFormat: '{series.name}: <b style="font-size:12px">{point.percentage:.1f}%</b>'
		        },
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                dataLabels: {
	        	            enabled: true,
		                    color: '#000000',
		                    connectorColor: '#000000',
		                    format: '<b style="font-size:14px">{point.name}</b>: {point.percentage:.1f} %'
		                }
		            }
		        },
		        series: [{
		            type: 'pie',
		            name: '占有比例',
		            data:msg
		        }]
		    });
		},
		error:function()
		{
			//goToUrl('/net_monitor_index/net_monitor_list');
		}
	});

	function histroy_do(item){
	  $('#day').removeClass("active");
	  $('#month').removeClass("active");
	  $('#year').removeClass("active");
        //  jQuery Flot Chart
	  if(item=='year'){
		  $('#year').addClass('active');
		  var task_url='<?=site_url('Admin/admin_index/select_history_any_year')?>';
	  }else if(item=='month'){
		  $('#month').addClass('active');
		  var task_url='<?=site_url('Admin/admin_index/select_history_any_month')?>';
	  }else if(item=='day'){
		  $('#day').addClass('active');
		  var task_url='<?=site_url('Admin/admin_index/select_history_any_day')?>';
	  }
          $.ajax({
               type:'GET',
               url:task_url,
               dataType:'json',
               timeout:2000,
               success:function(msg)
               {
		  var web_attack=new Array();
		  var net_attack=new Array();
		  var data_time=new Array();
	           $(function () {
            	   $(".knob").knob();
            	   $(".slider-sample1").slider({
              		  value: 100,
	                  min: 1,
	                  max: 500
		   });
            	   $(".slider-sample2").slider({
                	  range: "min",
                	  value: 130,
	                  min: 1,
	                  max: 500
	            });
        	    $(".slider-sample3").slider({
            		    range: true,
		            min: 0,
              		    max: 500,
               		    values: [ 40, 170 ],
      	            });
		  if(item=='year'){
		  var k=1;
		    for(var i=0;i<=11;i++){
			web_attack.push([i,msg.web_attack[k]]);
			net_attack.push([i,msg.net_attack[k]]);
			data_time.push([i,msg.data_time[k]]);
			k++;
		    }
		 }else if(item=='month'){
		    for(var i=0;i<=12;i++){
                        web_attack.push([i,msg.web_attack[i]]);
                        net_attack.push([i,msg.net_attack[i]]);
                        data_time.push([i,msg.data_time[i]]);
		    }	
		 }else if(item=='day'){
                    for(var i=0;i<=24;i++){
                        web_attack.push([i,msg.web_attack[i]]);
                        net_attack.push([i,msg.net_attack[i]]);
                        data_time.push([i,msg.data_time[i]]);
                    }   

		}
		 
       		   var visits = web_attack;
		   var visitors=net_attack;
	            var plot = $.plot($("#statsChart"),
        	        [ { data: visits, label: "Web攻击捕获"},
	                 { data: visitors, label: "断网异常捕获" }], {
        	            series: {
         	               lines: { show: true,
                                lineWidth: 1,
                                fill: true,
                                fillColor: { colors: [ { opacity: 0.1 }, { opacity: 0.13 } ] }
                             },
                        points: { show: true,
                                 lineWidth: 2,
                                 radius: 3
                             },
                        shadowSize: 0,
                        stack: true
                    },
                    grid: { hoverable: true,
                           clickable: true,
                           tickColor: "#f9f9f9",
                           borderWidth: 0
                        },
                    legend: {
                            // show: false
                            labelBoxBorderColor: "#fff"
                        },
                    colors: ["#a7b5c5", "#30a0eb"],
                    xaxis: {
                        ticks:data_time,
                        font: {
                            size: 12,
                            family: "Open Sans, Arial",
                            variant: "small-caps",
                            color: "#697695"
                        }
                    },
                    yaxis: {
                        ticks:3,
                        tickDecimals: 0,
                        font: {size:12, color: "#9da3a9"}
                    }
                 });
            function showTooltip(x, y, contents) {
                $('<div id="tooltip">' + contents + '</div>').css( {
                    position: 'absolute',
                    display: 'none',
                    top: y - 30,
                    left: x - 50,
                    color: "#fff",
                    padding: '2px 5px',
                    'border-radius': '6px',
                    'background-color': '#000',
                    opacity: 0.80
                }).appendTo("body").fadeIn(200);
            }

       	     var previousPoint = null;
        	    $("#statsChart").bind("plothover", function (event, pos, item) {
           	     if (item) {
               		     if (previousPoint != item.dataIndex) {
                  		      previousPoint = item.dataIndex;
                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(0),
                            y = item.datapoint[1].toFixed(0);

                        var month = item.series.xaxis.ticks[item.dataIndex].label;

                        showTooltip(item.pageX, item.pageY,
                                    month + " "+item.series.label + y + "次");
                     }
                }
                else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        });
                        },
                        error:function()
                        {
                                result="data Error";
                        }
                  });
}
    </script>
    <!-- 波动图结束 -->
</body>
</html>
