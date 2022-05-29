<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['post'])){ ?>
<div class="row">
	<div class="col-sm-12">
		<div id="package_wise_booking_history" style="height: 640px; width: 100%;"></div>
	</div>
</div>
<script>
function package_wise_booking_history_function(){
	var package_wise_booking_history = new CanvasJS.Chart("package_wise_booking_history", {
	animationEnabled: true,
	exportFileName: "Package wise booking history",
	exportEnabled: true,
	zoomEnabled:true,
	axisY: {
		prefix: ""
	},
	legend:{
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	toolTip: {
		shared: true
	},
	data: [
	<?php
		$s_sql = $mysqli->query("select * from sub_package_category");
		while($s_row = mysqli_fetch_assoc($s_sql)){
			$p_sql = $mysqli->query("select * from packages where sub_category_id = '".$s_row['id']."'");
			$package_ids = '';
			while($p_row = mysqli_fetch_assoc($p_sql)){
				$package_ids .= "'".$p_row['id']."',";
			}
			$final_pk_ids = rtrim($package_ids,',');
			$data_list = '13';
			$year = date('Y');
			$i = 1;
			for($i ; $i < $data_list; $i++ ){
				$date_y = sprintf("%02d", $i).'/'.$year;
				$booking = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM booking_info where package IN ($final_pk_ids) AND data LIKE '%".$date_y."%'"));
				if(!empty($booking['nmbr']) AND $booking['nmbr'] > 0){
					$countr = $booking['nmbr'];
				}else{
					$countr = '0';
				}
				$date_1[$s_row['id']][] = array( 
					"x" => strtotime('01-'.sprintf("%02d", $i).'-'.$year ).'000', 
					"y" => $countr
				);												
			}
	?>
			{
				type: "area",
				//color: "#<?php echo rand(123456,456789); ?>",
				fillOpacity: .05,
				name: "<?php echo $s_row['sub_package_name']; ?>",
				showInLegend: "true",
				xValueType: "dateTime",
				xValueFormatString: "MMM YYYY",
				yValueFormatString: "#,##0.##",
				dataPoints: <?php echo json_encode($date_1[$s_row['id']],JSON_NUMERIC_CHECK); ?>
			},
	<?php			
		}
	?>	
		]	
	});							 
	package_wise_booking_history.render();							 
	function toggleDataSeries(e){
		if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		}
		else{
			e.dataSeries.visible = true;
		}
		package_wise_booking_history.render();
	}
}
</script>
<script src="<?php echo $home.'assets/js/cart/canvasjs.min.js'; ?>"></script>
<?php } ?>