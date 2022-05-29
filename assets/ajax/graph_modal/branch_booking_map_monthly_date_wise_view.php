<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['book_id_date'])){
	$d = date_create($_POST['book_id_date']);
	$date = date_format($d,'m/Y');
	$grant_total_value = 0;
	$sql = $mysqli->query("SELECT COUNT(branch_id) as nmbr, branch_name FROM booking_info WHERE data LIKE '%".$date."%' GROUP BY branch_id ORDER BY COUNT(branch_id) ASC");
	while($row = mysqli_fetch_assoc($sql)){
		$data_monthly[] = array(
			'y' => $row['nmbr'],
			'label' => $row['branch_name']
		);
		$grant_total_value = $grant_total_value + $row['nmbr'];	
	}
	if(empty($data_monthly)){ $data_monthly = ''; }
	
	
	$l_d = explode('-',$_POST['book_id_date']);
	$l_month = $l_d[1]; 
	$l_Year = $l_d[0]; 
	
	$data_list = cal_days_in_month(CAL_GREGORIAN,$l_month,$l_Year) + 1;
	$data_list_year = 12 + 1;
	$year = $l_Year;
	$i = 1;
	for($i ; $i < $data_list; $i++ ){
		$date_y = sprintf("%02d", $i).'/'.$l_month.'/'.$year;					
		$booking = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM booking_info where data LIKE '%".$date_y."%'"));
		if(!empty($booking['nmbr']) AND $booking['nmbr'] > 0){ 
			$countr = $booking['nmbr']; 
		}else{ 
			$countr = '0'; 
		}
		$booking_date_1[] = array( 
			"x" => strtotime(sprintf("%02d", $i).'-'.$l_month.'-'.$year ).'000',  
			"y" => $countr 
		);
		
		
		$cancel = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM cencel_request where data LIKE '%".$date_y."%'"));
		if(!empty($cancel['nmbr']) AND $cancel['nmbr'] > 0){ 
			$countc = $cancel['nmbr']; 
		}else{ 
			$countc = '0'; 
		}
		$cancel_date_1[] = array(
			"x" => strtotime(sprintf("%02d", $i).'-'.$l_month.'-'.$year ).'000', 
			"y" => $countc 
		);
		
		
		
	}
	$j = 1;
	for($j ; $j < $data_list_year; $j++ ){
		$k = 1;
		$data_list_month = cal_days_in_month(CAL_GREGORIAN,sprintf("%02d", $j),$l_Year) + 1;
		for($k ; $k < $data_list_month; $k++ ){
			$date_y = sprintf("%02d", $k).'/'.sprintf("%02d", $j).'/'.$year;					
			$booking = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM booking_info where data LIKE '%".$date_y."%'"));
			if(!empty($booking['nmbr']) AND $booking['nmbr'] > 0){ 
				$countr = $booking['nmbr']; 
			}else{ 
				$countr = '0'; 
			}
			$booking_date_Y[] = array( 
				"x" => strtotime(sprintf("%02d", $k).'-'.sprintf("%02d", $j).'-'.$year ).'000',  
				"y" => $countr 
			);			
			$cancel = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM cencel_request where data LIKE '%".$date_y."%'"));
			if(!empty($cancel['nmbr']) AND $cancel['nmbr'] > 0){ 
				$countc = $cancel['nmbr']; 
			}else{ 
				$countc = '0'; 
			}
			$cancel_date_Y[] = array(
				"x" => strtotime(sprintf("%02d", $k).'-'.sprintf("%02d", $j).'-'.$year ).'000', 
				"y" => $countc 
			);
		}
	}
	
?>
<div class="row">
	<div class="col-sm-12" style="text-align:right;">
		Total Booking: <b style="color:#f00;"><?php echo $grant_total_value; ?></b>
	</div>
	<div class="col-sm-12">
		<div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
					<li class="pt-2 px-3"><h3 class="card-title">Monthly Booking</h3></li>
					<li class="nav-item">
						<a class="nav-link active" onclick="onclick_view()" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">Bar Chart</a>
					</li>
					<li class="nav-item">
						<a class="nav-link " onclick="onclick_view()" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="true">Line Chart</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" onclick="onclick_view()" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Line Chart This Year</a>
					</li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
					<div class="tab-pane fade active show" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
						<div class="row">
							<div class="col-sm-12">
								<div id="chartContainer_monthly_history_modal" style="height: 570px; width: 100%;"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
						<div class="row">
							<div class="col-sm-12">
								<div id="monthly_monthly_date_wise_line_chart" style="height: 570px; width: 100%;"></div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
						<div class="row">
							<div class="col-sm-12">
								<div id="monthly_yearly_date_wise_line_chart" style="height: 570px; width: 100%;"></div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
	</div>
	
</div>
<script>
function chartContainer_monthly_history_modal_function(){
	var chart_monthly_history_modal = new CanvasJS.Chart("chartContainer_monthly_history_modal", {
		exportFileName: "Top 5 Branch Wise Booking Graph",
		exportEnabled: true,
		animationEnabled: true,
		axisY: {
			title: "Members",
			includeZero: true,
			prefix: "",
			suffix:  ""
		},
		axisX: {
			title: "Branch"
		},
		data: [{
			type: "bar",
			yValueFormatString: "#,##0",
			indexLabel: "{y}",
			indexLabelPlacement: "inside",
			indexLabelFontWeight: "bolder",
			indexLabelFontColor: "white",
			dataPoints: <?php echo json_encode($data_monthly, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart_monthly_history_modal.render();
	//===========================================
	var monthly_monthly_date_wise_line_chart = new CanvasJS.Chart("monthly_monthly_date_wise_line_chart", {
		animationEnabled: true, exportFileName: "Booking & Cancel Graph", exportEnabled: true, zoomEnabled:true,
		axisY: { prefix: "" },
		legend:{ cursor: "pointer", itemclick: toggleDataSeries },
		toolTip: { shared: true },
		data: [ {
			type: "area", color: "green", fillOpacity: .3, name: "Booking", showInLegend: "true", xValueType: "dateTime", xValueFormatString: "DD MMM YYYY", yValueFormatString: "#,##0.##",
			dataPoints: <?php echo json_encode($booking_date_1,JSON_NUMERIC_CHECK); ?>
		}, {
			type: "area", color: "red", fillOpacity: .3, name: "Cancel", showInLegend: "true", xValueType: "dateTime", xValueFormatString: "DD MMM YYYY", yValueFormatString: "#,##0.##", 
			dataPoints: <?php echo json_encode($cancel_date_1,JSON_NUMERIC_CHECK); ?> }
		] 
	}); 
	monthly_monthly_date_wise_line_chart.render();							 
	function toggleDataSeries(e){ 
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) { 
			e.dataSeries.visible = false; } else{ e.dataSeries.visible = true; 
		} 
		monthly_monthly_date_wise_line_chart.render(); 
	} 
	
	//===========================================
	var monthly_yearly_date_wise_line_chart = new CanvasJS.Chart("monthly_yearly_date_wise_line_chart", {
		animationEnabled: true, exportFileName: "Booking & Cancel Graph", exportEnabled: true, zoomEnabled:true,
		axisY: { prefix: "" },
		legend:{ cursor: "pointer", itemclick: toggleDataSeries_Y },
		toolTip: { shared: true },
		data: [ {
			type: "area", color: "green", fillOpacity: .3, name: "Booking", showInLegend: "true", xValueType: "dateTime", xValueFormatString: "DD MMM YYYY", yValueFormatString: "#,##0.##",
			dataPoints: <?php echo json_encode($booking_date_Y,JSON_NUMERIC_CHECK); ?>
		}, {
			type: "area", color: "red", fillOpacity: .3, name: "Cancel", showInLegend: "true", xValueType: "dateTime", xValueFormatString: "DD MMM YYYY", yValueFormatString: "#,##0.##", 
			dataPoints: <?php echo json_encode($cancel_date_Y,JSON_NUMERIC_CHECK); ?> }
		] 
	}); 
	monthly_yearly_date_wise_line_chart.render();							 
	function toggleDataSeries_Y(e){ 
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) { 
			e.dataSeries.visible = false; } else{ e.dataSeries.visible = true; 
		} 
		monthly_yearly_date_wise_line_chart.render(); 
	} 
}
function onclick_view(){
	setTimeout(function(){ 
		chartContainer_monthly_history_modal_function();
	}, 200);	
}
$('document').ready(function(){
	setTimeout(function(){ 
		chartContainer_monthly_history_modal_function();
	}, 200);	
})
</script>
<?php } ?>