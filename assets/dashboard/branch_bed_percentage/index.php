<?php
	include("../../../application/config/ajax_config.php");
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Clock</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <script
    type="text/javascript"
    src="/js/lib/dummy.js"
    
  ></script>

    <link rel="stylesheet" type="text/css" href="/css/result-light.css">


  <style id="compiled-css" type="text/css">
.highcharts-figure, .highcharts-data-table table {
  min-width: 310px; 
  max-width: 800px;
  margin: 1em auto;
}

#container {
  height: 400px;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
  </style>



  
</head>
<body style="margin:0px;margin-top: -13px;">
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/pareto.js"></script>



<figure class="highcharts-figure">
  <div id="container"></div>
</figure>

<?php
$sql = $mysqli->query("select * from branches order by id asc limit 1,6");
$branch_name = '';
$Available_Bed = '';
$Occupide_Bed = '';
$Booked_Bed = '';
$RFC_Bed = '';
$Available_Bedp = '';
$Occupide_Bedp = '';
$Booked_Bedp = '';
$RFC_Bedp = '';
$ablll = 0;
$ocppp = 0;
$bookk = 0;
$recff = 0;

while($row = mysqli_fetch_assoc($sql)){
	$branch_name .= "'".$row['branch_name']."',";
	$total = mysqli_fetch_array($mysqli->query("select count(*) from beds where branch_id = '".$row['branch_id']."' and status = '1'"));
	$abaible = mysqli_fetch_array($mysqli->query("select count(*) from beds where branch_id = '".$row['branch_id']."' and status = '1' and uses = '0'"));
	$booked = mysqli_fetch_array($mysqli->query("select count(*) from beds where branch_id = '".$row['branch_id']."' and status = '1' and uses = '2'"));
	$occupide = mysqli_fetch_array($mysqli->query("select count(*) from beds where branch_id = '".$row['branch_id']."' and status = '1' and uses = '3'"));
	$resqestfc = mysqli_fetch_array($mysqli->query("select count(*) from beds where branch_id = '".$row['branch_id']."' and status = '1' and uses = '4'"));
	
	if($total > 0 AND $abaible[0] > 0){
		$ablll = round(100 / (float)$total[0] * (float)$abaible[0],0);
	}else{
		$ablll = 0;
	}
	if($total > 0 AND $occupide[0] > 0){
		$ocppp = round(100 / (float)$total[0] * (float)$occupide[0],0);
	}else{
		$ocppp = 0;
	}
	if($total > 0 AND $booked[0] > 0){
		$bookk = round(100 / (float)$total[0] * (float)$booked[0],0);
	}else{
		$bookk = 0;
	}
	if($total > 0 AND $resqestfc[0] > 0){
		$recff = round(100 / (float)$total[0] * (float)$resqestfc[0],0);
	}else{
		$recff = 0;
	}
	$Available_Bed .= $abaible[0].",";
	$Occupide_Bed .= $occupide[0].",";
	$Booked_Bed .= $booked[0].",";
	$RFC_Bed .= $resqestfc[0].",";
	
	
	$Available_Bedp .= "".$ablll.",";
	$Occupide_Bedp .= "".$ocppp.",";
	$Booked_Bedp .= "".$bookk.",";
	$RFC_Bedp .= "".$recff.",";
}
$bn = rtrim($branch_name,',');

$abl = rtrim($Available_Bed,',');
$ocp = rtrim($Occupide_Bed,',');
$bkb = rtrim($Booked_Bed,',');
$rfc = rtrim($RFC_Bed,',');

$ablp = rtrim($Available_Bedp,',');
$ocpp = rtrim($Occupide_Bedp,',');
$bkbp = rtrim($Booked_Bedp,',');
$rfcp = rtrim($RFC_Bedp,',');
?>
<script type="text/javascript">
	Highcharts.chart('container', {
		title: {
			text: ''
		},
		
		xAxis: {
			categories: [<?php echo $bn; ?>], //'Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'
			crosshair: true
		},
		yAxis: [{
			title: {
				text: ''
			}
		}, {
			title: {
			  text: ''
			},
			minPadding: 0,
			maxPadding: 0,
			max: 100,
			min: 0,
			opposite: true,
			labels: {
			  format: "{value}%"
			}
		  }
		 ],
		labels: {
			items: [{
				html: '',
					style: {
						left: '50px',
						top: '18px',
						color: ( // theme
							Highcharts.defaultOptions.title.style &&
							Highcharts.defaultOptions.title.style.color
						) || 'black'
					}
			}]
		},
	
		  plotOptions: {
			column: {
			  stacking: 'percent'
			}
		  },
		series: [
		/*{
			type: 'pareto',
			name: 'Available Bed',
			data: [<?php echo $ablp; ?>],
			color: '#28a700',
			tooltip: {
				valueDecimals: 2,
				valueSuffix: '%'
			}
		},{
			type: 'pareto',
			name: 'Occupide',
			data: [<?php echo $ocpp; ?>],
			color: '#ffc100',
			tooltip: {
				valueDecimals: 2,
				valueSuffix: '%'
			}
		},{
			type: 'pareto',
			name: 'Booked',
			data: [<?php echo $bkbp; ?>],
			color: '#007bff',
			tooltip: {
				valueDecimals: 2,
				valueSuffix: '%'
			}
		},{
			type: 'pareto',
			name: 'Request For Cancel',
			data: [<?php echo $rfcp; ?>],
			color: '#dc3545',
			tooltip: {
				valueDecimals: 2,
				valueSuffix: '%'
			}
		},*/
		
		
		{
			type: 'column',
			name: 'Available Bed',
			data: [<?php echo $abl; ?>],
			color: '#28a745'
		}, {
			type: 'column',
			name: 'Occupide',
			data: [<?php echo $ocp; ?>],
			color: '#ffc107'
		}, {
			type: 'column',
			name: 'Booked',
			data: [<?php echo $bkb; ?>],
			color: '#007bff'
		}, {
			type: 'column',
			name: 'Request For Cancel',
			data: [<?php echo $rfc; ?>],
			color: '#dc3545'
		},	
<?php
	$abaible = mysqli_fetch_array($mysqli->query("select count(*) from beds where status = '1' and uses = '0'"));
	$booked = mysqli_fetch_array($mysqli->query("select count(*) from beds where status = '1' and uses = '2'"));
	$occupide = mysqli_fetch_array($mysqli->query("select count(*) from beds where status = '1' and uses = '3'"));
	$resqestfc = mysqli_fetch_array($mysqli->query("select count(*) from beds where status = '1' and uses = '4'"));
?>
		/* {
			type: 'pie',
			name: 'Total consumption',
			data: [{
				name: 'Available Bed',
				y: <?php echo $abaible[0]; ?>,
				color: '#28a745',
			}, {
				name: 'Occupide',
				y: <?php echo $occupide[0]; ?>,
				color: '#ffc107'
			}, {
				name: 'Booked',
				y: <?php echo $booked[0]; ?>,
				color: '#007bff'
			}, {
				name: 'Request For Cancel',
				y: <?php echo $resqestfc[0]; ?>,
				color: '#dc3545'
			}],
			center: [100, 80],
			size: 100,
			showInLegend: false,
			dataLabels: {
				enabled: false
			}
		}, */
		
		]
});


</script>




</body>
</html>
