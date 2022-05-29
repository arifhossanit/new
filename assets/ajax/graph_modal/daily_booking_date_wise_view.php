<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['book_id_date'])){
	if(isset($_POST['book_id_date'])){
		$one = explode(' - ',$_POST['book_id_date']);	
		$one_ymd = explode('/',$one[0]);
		$two_ymd = explode('/',$one[1]);
		$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
		$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
		$date_filter1 = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
		$date_filter = "STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
	}else{
		$date_filter1 = "";
		$date_filter = "";
	}	
	
	$sql = $mysqli->query("SELECT COUNT(branch_id) as nmbr, branch_name, branch_id FROM booking_info WHERE $date_filter GROUP BY branch_id ORDER BY COUNT(branch_id) DESC");
	$grant_total_value = 0;	
	$grant_total_value_point = 0;	
	while($row = mysqli_fetch_assoc($sql)){
		$total_vdb = 0;
		$bql = $mysqli->query("select * from booking_info where branch_id = '".$row['branch_id']."' $date_filter1");
		while($booking = mysqli_fetch_assoc($bql)){
			$packagea = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
			$get_vdb = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$packagea['sub_category_id']."'"));
			$total_vdb = $total_vdb + $get_vdb['booking_value'];
		}
		$todays_booking[] = array( 'value' => $total_vdb, 'y' => $row['nmbr'], 'label' => $row['branch_name'], 'indexLabel' => 'B:'.$row['nmbr'].', P:'.$total_vdb );
		$grant_total_value = $grant_total_value + $row['nmbr'];	
		$grant_total_value_point = $grant_total_value_point + $total_vdb;	
	}
	if(count($todays_booking) > 0){ 
		sort($todays_booking);
		foreach($todays_booking as $row){
			$todays_bookinga[] = array( 'y' => $row['value'], 'label' => $row['label'], 'indexLabel' => $row['indexLabel'] );
		}
	}else{
		$todays_bookinga = '';
	}
?>
<div class="row">
	<div class="col-sm-12" style="text-align:right;">
		Total Booking: <b style="color:#f00;"><?php echo $grant_total_value; ?></b> | Total Booking Point: <b style="color:#f00;"><?php echo $grant_total_value_point; ?></b>
	</div>
	<div class="col-sm-12">
		<div id="chartContainer_todays_booking_modal" style="height: 570px; width: 100%;"></div>
	</div>
</div>
<script>
function chartContainer_todays_booking_modal(){
	var chart_todays_booking_modal = new CanvasJS.Chart("chartContainer_todays_booking_modal", {
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
			//indexLabel: "{y}",
			indexLabelPlacement: "inside",
			indexLabelFontWeight: "bolder",
			indexLabelFontColor: "#dcdcdc",
			dataPoints: <?php echo json_encode($todays_bookinga, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chart_todays_booking_modal.render();
}
$('document').ready(function(){	
	setTimeout(function(){ 
		chartContainer_todays_booking_modal();
	}, 200);	
})
</script>
<?php } ?>