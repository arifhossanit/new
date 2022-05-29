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
		$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
	}else{
		$date_filter = "";
	}
	$sql = $mysqli->query("select * from member_directory where status = '1'");
	$book_id = '';
	while($row = mysqli_fetch_assoc($sql)){
		$rent_info = mysqli_fetch_array($mysqli->query("select count(*) from rent_info where booking_id = '".$row['booking_id']."' and status = '1'"));
		if($rent_info[0] > 1){
			$book_id .= "'".$row['booking_id']."',";
		}
	}
	$booking_id_i = rtrim($book_id,',');
	$grant_total_value = 0;	
	$grant_total_value_point = 0;	
	$dql = $mysqli->query("SELECT COUNT(branch_id) as nmbr, branch_name, branch_id FROM rent_info WHERE booking_id IN (".$booking_id_i.") AND rent_status = 'Paid' $date_filter AND data_three = 'renew' AND status = '1' GROUP BY branch_id ORDER BY COUNT(branch_id) DESC");
	while($dow = mysqli_fetch_assoc($dql)){
		$total_vdb1 = 0;
		$bql = $mysqli->query("select * from rent_info where branch_id = '".$dow['branch_id']."' AND rent_status = 'Paid' $date_filter AND data_three = 'renew' AND status = '1'");
		while($booking = mysqli_fetch_assoc($bql)){
			$packagea = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
			$get_vdb1 = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$packagea['sub_category_id']."'"));
			$total_vdb1 = $total_vdb1 + $get_vdb1['booking_value'];	
		}
		$daily_renew[] = array( 'value' => $total_vdb1, 'label' => $dow['branch_name'], 'indexLabel' => 'B:'.$dow['nmbr'].', P:'.$total_vdb1 );
		$grant_total_value = $grant_total_value + $dow['nmbr'];	
		$grant_total_value_point = $grant_total_value_point + $total_vdb1;	
	}
	sort($daily_renew);
	foreach($daily_renew as $row){
		$daily_renewa[] = array( 'y' => $row['value'], 'label' => $row['label'], 'indexLabel' => $row['indexLabel'] );
	}
	
	
?>
<div class="row">
	<div class="col-sm-12" style="text-align:right;">
		Total Renew: <b style="color:#f00;"><?php echo $grant_total_value; ?></b> | Total Renew Point: <b style="color:#f00;"><?php echo $grant_total_value_point; ?></b>
	</div>
	<div class="col-sm-12">
		<div id="chartContainer_daily_renew_modal" style="height: 570px; width: 100%;"></div>
	</div>
</div>
<script>
function chartContainer_daily_renew_modal(){
	var chartContainer_daily_renew_modal = new CanvasJS.Chart("chartContainer_daily_renew_modal", {
		exportFileName: "Top 5 Branch Wise Renew Graph",
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
			dataPoints: <?php echo json_encode($daily_renewa, JSON_NUMERIC_CHECK); ?>
		}]
	});
	chartContainer_daily_renew_modal.render();
}
$('document').ready(function(){
	setTimeout(function(){ 
		chartContainer_daily_renew_modal();
	}, 200);	
})
</script>
<?php } ?>