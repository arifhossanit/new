<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['employee_id'])){ 
	//$position_array = '';
	//$sallay_array = '';
	$employee_info = mysqli_fetch_assoc($mysqli->query("SELECT  * FROM employee WHERE id = '".$_POST['employee_id']."'"));
	$date_of_birth = explode('/',$employee_info['date_of_birth']);
	$birth_year = (int)$date_of_birth['2'];
	$years_after_80 = $birth_year + 70;
	$years_runing_80 = date('Y') - $birth_year;
	$color = 1;
	
	
	

	
	//echo $date_to;
	//exit;
	
	
	
	$date_from = $birth_year.'-01-01';
	for($i = $birth_year; $i <= $years_after_80; $i++){		
		$date_to = $i.'-01-01';
		$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
		$check_increament = mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS total FROM employee_increament_logs WHERE employee_id = '".$employee_info['employee_id']."' $date_filter"));
		$check_decreament = mysqli_fetch_assoc($mysqli->query("SELECT SUM(amount) AS total FROM employee_decreament_logs WHERE employee_id = '".$employee_info['employee_id']."' $date_filter"));
		
		$increament_amount = $check_increament['total'];
		$decreament_amount = $check_decreament['total'];
		
		$mysalary = $employee_info['basic_salary'] + $increament_amount - $decreament_amount;
		if($color++ > 60){
			$get_color = '#f00';
		}else{
			$get_color = 'green';
		}
		
		$basic_salary = $mysalary * 30 ;
		
		$position_array[] = array("x" => $i, "y" => 50, "color" => $get_color);
		$sallay_array[] = array("x" => $i, "y" => $basic_salary, "color" => $get_color);
				
	}
	
	
	
?>
<div class="row">
	<div class="col-sm-12" style="padding-bottom:40px;">
		<div id="chartContainer_header" style="min-width:100%;height:600px;"></div>
	</div>
</div>
<script>






function render_chart_history(){
 
	var chartContainer_header = new CanvasJS.Chart("chartContainer_header", {
		animationEnabled: true,
		zoomEnabled: true,
		zoomType: "xy",
		exportEnabled: true,
		theme: "light2",
		title:{
			text: "Exponential Growth"
		},
		axisY:{
			title: "Position",
			logarithmic: true,
			titleFontColor: "#6D78AD",
			gridColor: "#6D78AD",
			includeZero: true,
			labelFormatter: addSymbols
		},
		axisY2:{
			title: "Sallary",
			titleFontColor: "#51CDA0",
			tickLength: 0,
			labelFormatter: addSymbols
		},
		axisX: {
			logarithmic: true,
			title: "Years",
			minimum: <?php echo $birth_year; ?>,
			labelFormatter: function (e) {
				return CanvasJS.formatNumber(e.value, "##00");
			},
			stripLines: [{
				value: <?php echo date('Y') ?>,
				label: "NOW",
				labelFontColor: "#808080",
				labelAlign: "near",
			}]
		},
		toolTip: {
			shared: true
		},
		legend: {
			cursor: "pointer",
			verticalAlign: "top",
			itemclick: toggleDataSeries
		},
		data: [
			{
				type: "area",
				markerSize: 0,
				showInLegend: true,
				name: "Position",
				yValueFormatString: "#,##0 Grade",
				xValueFormatString: "Year: ####",
				dataPoints: <?php echo json_encode($position_array, JSON_NUMERIC_CHECK); ?>
			},
			{
				type: "area",
				markerSize: 0,
				axisYType: "secondary",
				showInLegend: true,
				name: "Sallay",
				yValueFormatString: "#,##0 BDT",
				xValueFormatString: "Year: ####",
				dataPoints: <?php echo json_encode($sallay_array, JSON_NUMERIC_CHECK); ?>
			}
		]
	});
	chartContainer_header.render();
 
	function addSymbols(e){
		var suffixes = ["", "K", "M", "B"];
	 
		var order = Math.max(Math.floor(Math.log(e.value) / Math.log(1000)), 0);
		if(order > suffixes.length - 1)
			order = suffixes.length - 1;
	 
		var suffix = suffixes[order];
		return CanvasJS.formatNumber(e.value / Math.pow(1000, order)) + suffix;
	}
 
	function toggleDataSeries(e){
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else{
			e.dataSeries.visible = true;
		}
		chartContainer_header.render();
	}
}
</script>
<script src="<?php echo $home.'assets/js/cart/canvasjs.min.js'; ?>"></script>
<?php } ?>