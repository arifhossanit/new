<?php
include('config/routeros_api.class.php');
include("../../application/config/ajax_config.php");
$get_info = mysqli_fetch_assoc($mysqli->query("select * from graph_config where id = '1'"));

$ip = $get_info['ip_address'];
$username = $get_info['username'];
$password = $get_info['password'];

$home = $home.'assets/graph/';
$height = '400';
$api = new routeros_api();
$api->connect($ip,$username,$password);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Graph</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>
		var chart;
		function requestDatta(interface) {
			var ip_address = '<?php echo rahat_encode($ip); ?>';
			var username = '<?php echo rahat_encode($username); ?>';
			var password = '<?php echo rahat_encode($password); ?>';
			$.ajax({
				url: '<?php echo $home; ?>ajax/live.php?interface='+interface+'&ip_address='+atob(ip_address)+'&username='+atob(username)+'&password='+atob(password),
				datatype: "json",
				success: function(data) {
					var midata = JSON.parse(data);
					if( midata.length > 0 ) {
						var total = "<?php echo $get_info['max_speed']; ?>"; //Mbps
						var TX=parseInt(midata[0].data);
						var RX=parseInt(midata[1].data) + 200;						
						var total_r = total / 100;
						var data_u = RX / total_r;						
						var x = (new Date()).getTime();						
						shift=chart.series[0].data.length > 19;						
						$("#upload").html(TX + ' Mbps');
						$("#download").html(RX +' Mbps / '+parseInt(data_u)+'%');
						var dt = new Date();
						var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
						$("#time").html(time);
						chart.series[0].addPoint([x, TX], true, shift);
						chart.series[1].addPoint([x, RX], true, shift);						
						document.getElementById("trafico").innerHTML=TX + " / " + RX;						
					}else{
						document.getElementById("trafico").innerHTML="- / -";
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
				}       
			});
		}
		$(document).ready(function() {
			Highcharts.setOptions({
				global: {
					useUTC: false
				}
			});
			chart = new Highcharts.Chart({
			chart: {				
				renderTo: 'containere',
				animation: Highcharts.svg,
				type: 'areaspline',
				events: {
					load: function () {
						setInterval(function () {
							requestDatta(document.getElementById("interface").value);
						}, 1000);
					}				
				},				
			},
			title: { text: 'All Branch Internet usage graph (Neways IT Department)' },			 
			xAxis: { type: 'datetime', tickPixelInterval: 150, maxZoom: 20 * 1000 },
			yAxis: { minPadding: 0.2, maxPadding: 0.2, title: { text: 'Neways IT Department', margin: 8 } },
			tooltip: {
				shared: true,
				valueSuffix: ' Mbps'
			},
			 plotOptions: {
				areaspline: {
					fillOpacity: 0.2
				}
			},
				series: [{
					name: 'UPLOAD',
					data: [],
				}, {
					name: 'DOWNLOAD',
					data: []
				}]
								
		  });
		});
		</script>
		<script type="text/javascript" >
			function date_time(id) {
				date = new Date;
				year = date.getFullYear();
				month = date.getMonth();
				months = new Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dev');
				d = date.getDate();
				day = date.getDay();
				days = new Array('sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
				h = date.getHours();
				if (h < 10) { h = "0" + h; }
				m = date.getMinutes();
				if (m < 10) { m = "0" + m; }
				s = date.getSeconds();
				if (s < 10) { s = "0" + s; }
				result = '' + days[day] + ' ' + d + ' ' + months[month] + ' ' + year + ' ' + h + ':' + m + ':' + s;
				document.getElementById(id).innerHTML = result;
				setTimeout('date_time("' + id + '");', '1000');
				return true;
			}      
		</script>
		<style> .banner{ width: 370px; height: auto; background-color: #ffffffa6; position: absolute; z-index: 9; top: 11%; left: 11%; border: solid 1px #2f7ed8; color: #000; padding: 5px; border-radius: 5px; line-height: 14px; } .time{ font-size:10px; } #upload{ font-size:30px !important; font-weight:bolder; color:#000; } #download{ font-size:30px !important; font-weight:bolder; color:#000; } </style>
	</head>	
<?php
$array = $api->comm("/system/resource/print");
?>	
	<body>
	<div class="banner">
		<span class="time">Time: <span id="time"></span></span><br />
		<!--<span class="data_meter" style="color:#dddf0d;font-size:20px;font-weight:300;">UPLOAD: <span id="upload"></span></span><br />-->
		<span class="data_meter"style="color:#50b432;font-size:20px;font-weight:300;">DOWNLOAD: <span id="download"></span></span>
	</div>
	<div id="containere" style="height: 370px; width: 100%;"></div>
	<input type="hidden" name="interface" id="interface" value="ether6-UPLINK"/>
	<?php /* ?><select name="interface" id="interface" class="form-control">
		<?php
			$array = $api->comm("/interface/print");
			$num = count($array);
			for($i = 0 ; $i < $num ; $i++){							
				echo '<option value="'.$array[$i]['name'].'">'.$array[$i]['name'].'</option> ';
			}
		?>
	</select><?php */ ?>
	

	</body>
	<script type="text/javascript" src="<?php echo $home; ?>js/highchart/js/highcharts.js"></script>
	<script type="text/javascript" src="<?php echo $home; ?>js/highchart/js/themes/grid.js"></script>
	<script type="text/javascript" src="<?php echo $home; ?>js/highchart/js/highcharts-more.js"></script>
	<script type="text/javascript" src="<?php echo $home; ?>js/highchart/js/modules/exporting.js"></script>

</html>