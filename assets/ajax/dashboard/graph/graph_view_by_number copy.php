<?php 
include("../../../../application/config/ajax_config.php");
function month_name($num){ if($num == '1'){ return 'January'; }else if($num == '2'){ return 'February'; }else if($num == '3'){ return 'March'; }else if($num == '4'){ return 'April'; }else if($num == '5'){ return 'May'; }else if($num == '6'){ return 'Jun'; }else if($num == '7'){ return 'July'; }else if($num == '8'){ return 'August'; }else if($num == '9'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$award = mysqli_fetch_assoc($mysqli->query("select * from sales_award_price where id = '1'"));
if(isset($_POST['graph_number'])){ $graph = $_POST['graph_number']; ?>
	<?php if($graph == 1){ ?>
		<div id="sels_winneer_today" style="height: 370px; width: 100%;"></div>
		<?php			
			$sql = $mysqli->query("select * from employee where role in ('1179783255713532148') and status = '1' order by id asc");
			while($row = mysqli_fetch_assoc($sql)){
				$role = mysqli_fetch_assoc($mysqli->query("select * from roles where role_id = '".$row['role']."'"));
				$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch']."'"));
				$uploader_info = $role['role_name'].'___'.$row['email'];
				$total_value1 = 0;	
				$sql2 = $mysqli->query("select * from booking_info where uploader_info like '".$uploader_info."%' and count_reword = '' and card_no != 'Unauthorized' and checkin_date = '".date('d/m/Y')."' order by id asc");
				while($booking = mysqli_fetch_assoc($sql2)){
					$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
					$get_value1 = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package['sub_category_id']."'"));
					$total_value1 = $total_value1 + $get_value1['booking_value'];	
				}
				if($total_value1 > 0){											
					$get_aray1[] = array('y' => $total_value1, 'label' => $row['full_name']);
				}
			}
			if(!empty($get_aray1) AND count($get_aray1) > 0){
				//$get_aray1 = unique_array($get_aray1 , "y");
				sort($get_aray1);
				$get_serial = count($get_aray1);
				$rewad = 0;
				foreach($get_aray1 as $emp){
					$arrray_counter = $get_serial--;
					if($arrray_counter == 1){
						if($award['status'] == 1 ){
							if($emp['y'] >= $award['last_day_point_limit'] ){
								$rewad = 'P:'.$emp['y'].'-'.money($award['last_day_price']);
							}else{ $rewad = 'P:'.$emp['y']; }
						}else{ $rewad = 'P:'.$emp['y']; }												
					}else if($arrray_counter == 2){
						if($award['status'] == 1){
							if($emp['y'] >= $award['second_last_day_point_limit'] ){
								$rewad = 'P:'.$emp['y'].'-'.money($award['second_last_day']);
							}else{ $rewad = 'P:'.$emp['y']; }
						}else{ $rewad = 'P:'.$emp['y']; }
					}else{ $rewad = 'P:'.$emp['y']; }
					$get_aray6[] = array('y' => $emp['y'], 'label' => $emp['label'], 'indexLabel' => $rewad);
				}
			}
			if(empty($get_aray6)){ $get_aray6 = ''; }
		?>
		<script>
		$('document').ready(function(){
			var sels_winneer_today = new CanvasJS.Chart("sels_winneer_today", {
				exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
				axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
				axisX: { title: "Branch" },
				data: [
					{
						type: "bar", yValueFormatString: "#,##0",
						//indexLabel: "{y}",
						indexLabelFontColor: "#fff", indexLabelFontSize: 16, indexLabelPlacement: "inside",
						dataPoints: <?php echo json_encode($get_aray6, JSON_NUMERIC_CHECK); ?>
					}
				]
			}); sels_winneer_today.render(); })
		</script>
	<?php }else if($graph == 2){ ?>
		<div id="sels_winneer_week" style="height: 370px; width: 100%;"></div>
		<?php
			$startDate=date("Y/m/d",strtotime('friday -6days',strtotime(date("Y/m/d"))));
			$endDate=date("Y/m/d",strtotime('friday',strtotime(date("Y/m/d"))));
			$get_money2 = 0;
			$sql = $mysqli->query("select * from employee where role in ('1179783255713532148') and status = '1' order by id asc");
			while($row = mysqli_fetch_assoc($sql)){
				$role = mysqli_fetch_assoc($mysqli->query("select * from roles where role_id = '".$row['role']."'"));
				$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch']."'"));
				$uploader_info = $role['role_name'].'___'.$row['email'];
				$total_value12 = 0;
				$sql2 = $mysqli->query("select * from booking_info where uploader_info like '".$uploader_info."%' and count_reword = '' and card_no != 'Unauthorized' and STR_TO_DATE(checkin_date,'%d/%m/%Y') BETWEEN '$startDate' AND '$endDate'");
				while($booking = mysqli_fetch_assoc($sql2)){
					$package2 = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
					$get_value12 = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package2['sub_category_id']."'"));
					$total_value12 = $total_value12 + $get_value12['booking_value'];
				}
				if($total_value12 > 0){ $get_aray12[] = array('y' => $total_value12, 'label' => $row['full_name']); }
			}
			if(!empty($get_aray12) AND count($get_aray12) > 0){
				//$get_aray12 = unique_array($get_aray12 , "y");
				sort($get_aray12);
				$get_serial = count($get_aray12);
				$rewad = 0;
				foreach($get_aray12 as $emp){
					$arrray_counter = $get_serial--;
					if($arrray_counter == 1){
						if($award['status'] == 1){
							if($emp['y'] >= $award['last_week_point_limit'] ){
								$rewad = money($award['last_week_price']);
							}else{ $rewad = ''; }
						}else{ $rewad = ''; }												
					}
					if($arrray_counter == 2){
						if($award['status'] == 1){
							if($emp['y'] >= $award['second_last_week_point_limit'] ){
								$rewad = money($award['second_last_week']);
							}else{ $rewad = ''; }
						}else{ $rewad = ''; }
					}
					$get_aray62[] = array('y' => $emp['y'], 'label' => $emp['label'], 'indexLabel' => $rewad);
				}
			}
			if(empty($get_aray62)){ $get_aray62 = ''; }
		?>
		<script>
		$('document').ready(function(){
			var sels_winneer_week = new CanvasJS.Chart("sels_winneer_week", {
				exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
				axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
				axisX: { title: "Branch" },
				data: [
					{
						type: "bar", yValueFormatString: "#,##0",
						//indexLabel: "{y}",
						indexLabelFontColor: "#fff", indexLabelFontSize: 16, indexLabelPlacement: "inside",
						dataPoints: <?php echo json_encode($get_aray62, JSON_NUMERIC_CHECK); ?>
					}
				]
			}); sels_winneer_week.render();							
		})
		</script>
	<?php }else if($graph == 3){ ?>
		<div id="sels_winneer_month" style="height: 370px; width: 100%;"></div>
		<?php
			$get_money3 = 0;
			$sql = $mysqli->query("select * from employee where role in ('1179783255713532148') and status = '1' order by id asc");
			while($row = mysqli_fetch_assoc($sql)){
				$role = mysqli_fetch_assoc($mysqli->query("select * from roles where role_id = '".$row['role']."'"));
				$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch']."'"));
				$uploader_info = $role['role_name'].'___'.$row['email'];
				$total_value13 = 0;
				$sql2 = $mysqli->query("select * from booking_info where uploader_info like '".$uploader_info."%' and count_reword = '' and card_no != 'Unauthorized' and checkin_date like '%".date('m/Y')."'");
				while($booking = mysqli_fetch_assoc($sql2)){
					$package3 = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
					$get_value13 = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package3['sub_category_id']."'"));
					$total_value13 = $total_value13 + $get_value13['booking_value'];
				}
				if($total_value13 > 0){ $get_aray13[] = array('y' => $total_value13, 'label' => $row['full_name']); }
			}
			if(!empty($get_aray13) AND count($get_aray13) > 0){
				//$get_aray13 = unique_array($get_aray13 , "y");
				sort($get_aray13);
				$get_serial = count($get_aray13);
				$rewad = 0;
				foreach($get_aray13 as $emp){
					$arrray_counter = $get_serial--;
					if($arrray_counter == 1){
						if($award['status'] == 1){
							if($emp['y'] >= $award['last_month_point_limit'] ){
								$rewad = money($award['last_month_price']);
							}else{ $rewad = ''; }
						}else{ $rewad = ''; }
					}
					if($arrray_counter == 2){
						if($award['status'] == 1){
							if($emp['y'] >= $award['second_last_month_point_limit'] ){
								$rewad = money($award['second_last_month']);
							}else{ $rewad = ''; }
						}else{ $rewad = ''; }
					}
					$get_aray63[] = array('y' => $emp['y'], 'label' => $emp['label'], 'indexLabel' => $rewad);
				}
			}
			if(empty($get_aray63)){ $get_aray63 = ''; }
		?>
		<script>
		$('document').ready(function(){
			var sels_winneer_month = new CanvasJS.Chart("sels_winneer_month", {
				exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
				axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
				axisX: { title: "Branch" },
				data: [
					{
						type: "bar", yValueFormatString: "#,##0",
						//indexLabel: "{y}",
						indexLabelFontColor: "#fff", indexLabelFontSize: 16, indexLabelPlacement: "inside",
						dataPoints: <?php echo json_encode($get_aray63, JSON_NUMERIC_CHECK); ?>
					}
				]
			}); sels_winneer_month.render();
		})
		</script>
	<?php }else if($graph == 4){ ?>
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>		
		<?php
			if(!empty($_POST['branch_id'])){ $pck_branches = "where branch_id = '".$_POST['branch_id']."'"; }else{ $pck_branches = ""; }
			$sql = $mysqli->query("SELECT COUNT(branch_id) as nmbr, branch_name FROM booking_info $pck_branches GROUP BY branch_id ORDER BY COUNT(branch_id) ASC");
			while($row = mysqli_fetch_assoc($sql)){
				$data[] = array( 'y' => $row['nmbr'], 'label' => $row['branch_name'] ); 
			}
			if(empty($data)){ $data = ''; }
		?>
		<script>
			$('document').ready(function(){
				var chart = new CanvasJS.Chart("chartContainer", {
					exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
					axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
					axisX: { title: "Branch" },
					data: [
						{
							type: "bar", yValueFormatString: "#,##0", indexLabel: "{y}", indexLabelPlacement: "inside", indexLabelFontWeight: "bolder", indexLabelFontColor: "white",
							dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
						}
					]
				}); chart.render();
			})
		</script>
	<?php }else if($graph == 5){ ?>
		<div id="chartContainer_package" style="height: 370px; width: 100%;"></div>
		<?php
			if(!empty($_POST['branch_id'])){ $pck_branches = "where branch_id = '".$_POST['branch_id']."'"; }else{ $pck_branches = ""; }
			$sql = $mysqli->query("SELECT COUNT(package_category) as nmbr, package_category_name FROM booking_info $pck_branches GROUP BY package_category_name ORDER BY COUNT(package_category) DESC");
			while($row = mysqli_fetch_assoc($sql)){
				$data_0[] = array( 'label' => $row['package_category_name'], 'y' => $row['nmbr'] );
			} sort($data_0); if(empty($data_0)){ $data_0 = ''; }
		?>
		<script>
		$('document').ready(function(){
			var chart_0 = new CanvasJS.Chart("chartContainer_package", {
			exportFileName: "Package Wise Booking Graph",
			exportEnabled: true, animationEnabled: true, theme: "light2",
			axisY: { title: "Members" },
			axisX: { title: "Package Category" },
			data: [{
				type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",										
				dataPoints: <?php echo json_encode($data_0, JSON_NUMERIC_CHECK); ?>
			}]
		}); chart_0.render();
		})
		</script>
	<?php }else if($graph == 6){ ?>
		<div id="chartContainer_1" style="height: 370px; width: 100%;"></div>
		<?php
			if(!empty($_POST['branch_id'])){ $branches = "and branch_id = '".$_POST['branch_id']."'"; }else{ $branches = ""; }
			$data_list = '13';
			$year = date('Y');
			$i = 1;
			for($i ; $i < $data_list; $i++ ){
				$date_y = sprintf("%02d", $i).'/'.$year;					
				$booking = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM booking_info where data LIKE '%".$date_y."%' $branches"));
				if(!empty($booking['nmbr']) AND $booking['nmbr'] > 0){ $countr = $booking['nmbr']; }else{ $countr = '0'; }
				$booking_date_1[] =array( "x" => strtotime('01-'.sprintf("%02d", $i).'-'.$year ).'000', "y" => $countr );
				$cancel = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM cencel_request where data LIKE '%".$date_y."%' $branches"));
				if(!empty($cancel['nmbr']) AND $cancel['nmbr'] > 0){ $countc = $cancel['nmbr']; }else{ $countc = '0'; }
				$cancel_date_1[] =array(  "x" => strtotime('01-'.sprintf("%02d", $i).'-'.$year ).'000', "y" => $countc );
			}
		?>
		<script>
		$('document').ready(function(){
			var chart_1 = new CanvasJS.Chart("chartContainer_1", {
			animationEnabled: true, exportFileName: "Booking & Cancel Graph", exportEnabled: true, zoomEnabled:true,
			axisY: { prefix: "" },
			legend:{ cursor: "pointer", itemclick: toggleDataSeries },
			toolTip: { shared: true },
			data: [ {
				type: "area", color: "green", fillOpacity: .3, name: "Booking", showInLegend: "true", xValueType: "dateTime", xValueFormatString: "MMM YYYY", yValueFormatString: "#,##0.##",
				dataPoints: <?php echo json_encode($booking_date_1,JSON_NUMERIC_CHECK); ?>
			}, {
				type: "area", color: "red", fillOpacity: .3, name: "Cancel", showInLegend: "true", xValueType: "dateTime", xValueFormatString: "MMM YYYY", yValueFormatString: "#,##0.##", 
				dataPoints: <?php echo json_encode($cancel_date_1,JSON_NUMERIC_CHECK); ?> }
			] }); chart_1.render();							 
			function toggleDataSeries(e){ if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) { e.dataSeries.visible = false; } else{ e.dataSeries.visible = true; } chart_1.render(); } })
		</script>
	<?php }else if($graph == 7){ ?>
		<div id="chartContainer_1_check_in_checkout" style="height: 370px; width: 100%;"></div>
		<?php 
			if(!empty($_POST['branch_id'])){ $branches = "and branch_id = '".$_POST['branch_id']."'"; }else{ $branches = ""; }
			$data_list = '13';
			$year = date('Y');
			$i = 1;
			for($i ; $i < $data_list; $i++ ){
				$date_y = sprintf("%02d", $i).'/'.$year;					
				$check_in = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM booking_info where card_no != 'Unauthorized' and checkin_date LIKE '%".$date_y."%' $branches"));
				if(!empty($check_in['nmbr']) AND $check_in['nmbr'] > 0){ $count_in = $check_in['nmbr']; }else{ $count_in = '0'; }
				$check_in_1[] =array( "x" => strtotime('01-'.sprintf("%02d", $i).'-'.$year ).'000', "y" => $count_in );
				$check_out = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM booking_info where card_no != 'Unauthorized' and checkout_date LIKE '%".$date_y."%' $branches"));
				if(!empty($check_out['nmbr']) AND $check_out['nmbr'] > 0){ $count_out = $check_out['nmbr']; }else{ $count_out = '0'; }
				$check_out_1[] =array(  "x" => strtotime('01-'.sprintf("%02d", $i).'-'.$year ).'000', "y" => $count_out );
			}
		?>
		<script>
			$('document').ready(function(){
				var chartContainer_1_check_in_checkout = new CanvasJS.Chart("chartContainer_1_check_in_checkout", {
				animationEnabled: true, exportFileName: "Booking & Cancel Graph", exportEnabled: true, zoomEnabled:true,
				axisY: { prefix: "" },
				legend:{ cursor: "pointer", itemclick: toggleDataSeries },
				toolTip: { shared: true },
				data: [ {
					type: "area", color: "blue", fillOpacity: .3, name: "CheckIn", showInLegend: "true", xValueType: "dateTime", xValueFormatString: "MMM YYYY", yValueFormatString: "#,##0.##",
					dataPoints: <?php echo json_encode($check_in_1,JSON_NUMERIC_CHECK); ?>
				}, {
					type: "area", color: "orange", fillOpacity: .3, name: "CheckOut", showInLegend: "true", xValueType: "dateTime", xValueFormatString: "MMM YYYY", yValueFormatString: "#,##0.##",
					dataPoints: <?php echo json_encode($check_out_1,JSON_NUMERIC_CHECK); ?> }
				] }); chartContainer_1_check_in_checkout.render();							 
				function toggleDataSeries(e){ if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) { e.dataSeries.visible = false; } else{ e.dataSeries.visible = true; } chartContainer_1_check_in_checkout.render(); } })
			</script>
	<?php }else if($graph == 8){ ?>
		<div id="chartContainer_2" style="height: 370px; width: 100%;"></div>
		<?php
			if(!empty($_POST['branch_id'])){ $branches = "and branch_id = '".$_POST['branch_id']."'"; }else{ $branches = ""; }
			$data_list = '13';
			$year = date('Y');
			$i = 1;
			for($i ; $i < $data_list; $i++ ){
				$date_y = sprintf("%02d", $i).'/'.$year;					
				$date_yh = $year;					
				$date_mf = month_name(sprintf("%02d", $i));
				
				$due = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM rent_info where month_name = '".$date_mf."' and data LIKE '%".$date_yh."' and rent_status = 'Due' $branches"));
				if(!empty($due['nmbr']) AND $due['nmbr'] > 0){ $count_d = $due['nmbr']; }else{ $count_d = '0'; }
				$due_graph_1[] =array( "label" => month_name(sprintf("%02d", $i)), "y" => $count_d );
				$paid = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) as nmbr FROM rent_info where month_name = '".$date_mf."' and data LIKE '%".$date_yh."' and rent_status = 'Paid' $branches"));
				if(!empty($paid['nmbr']) AND $paid['nmbr'] > 0){ $count_p = $paid['nmbr']; }else{ $count_p = '0'; }
				$paid_graph_1[] =array( "label" => month_name(sprintf("%02d", $i)), "y" => $count_p );
			}
			
		?>
		<script>
			$('document').ready(function(){
				var chart_2 = new CanvasJS.Chart("chartContainer_2", {
				animationEnabled: true, exportFileName: "Paid & Due Member Graph", exportEnabled: true, theme: "light2",
				axisY:{ includeZero: true },
				legend:{ cursor: "pointer", verticalAlign: "center", horizontalAlign: "right", itemclick: toggleDataSeries },
				data: [{
					type: "column", color: "#dc3545", name: "Due", indexLabel: "{y}", yValueFormatString: "#0.##", showInLegend: true,
					dataPoints: <?php echo json_encode($due_graph_1, JSON_NUMERIC_CHECK); ?>
				},{
					type: "column", name: "Paid", color: "#20c997", indexLabel: "{y}", yValueFormatString: "#0.##", showInLegend: true,
					dataPoints: <?php echo json_encode($paid_graph_1, JSON_NUMERIC_CHECK); ?>
				}]
			}); chart_2.render();		 
			function toggleDataSeries(e){ if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) { e.dataSeries.visible = false; } else{ e.dataSeries.visible = true; } chart_2.render(); } })
		</script>
	<?php }else if($graph == 9){ ?>
		<div id="daily_discoint_history" style="height: 370px; width: 100%;"></div>
		<?php
			if(!empty($_POST['branch_id'])){ $pck_branches_monthly = "WHERE branch_id = '".$_POST['branch_id']."' AND data LIKE '%".date('m/Y')."%'"; }else{ $pck_branches_monthly = "WHERE data LIKE '%".date('m/Y')."%'"; }
			$sql = $mysqli->query("SELECT sum(amount) as nmbr, branch_id FROM discount_member $pck_branches_monthly GROUP BY branch_id ORDER BY sum(amount) ASC");
			while($row = mysqli_fetch_assoc($sql)){
				$branches = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch_id']."'"));
				$data_discointi[] = array( 'y' => $row['nmbr'], 'label' => $branches['branch_name'] );
			} if(empty($data_discointi)){ $data_discointi = ''; }
		?>
		<script>
		$('document').ready(function(){
			var daily_discoint_history = new CanvasJS.Chart("daily_discoint_history", {
				exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
				axisY: { title: "Discount Money (BDT ৳)", includeZero: true, prefix: "", suffix:  "" },
				axisX: { title: "Branch" },
				data: [{
					type: "bar", yValueFormatString: "#,##0", indexLabel: "{y}", indexLabelPlacement: "inside", indexLabelFontWeight: "bolder", indexLabelFontColor: "white",
					dataPoints: <?php echo json_encode($data_discointi, JSON_NUMERIC_CHECK); ?>
				}]
			}); daily_discoint_history.render();
		})
		</script>
	<?php }else if($graph == 10){ ?>
		<div id="chartContainer_monthly_history" style="height: 370px; width: 100%;"></div>
		<?php
			if(!empty($_POST['branch_id'])){ $pck_branches_monthly = "WHERE branch_id = '".$_POST['branch_id']."' AND data LIKE '%".date('m/Y')."%'"; }else{ $pck_branches_monthly = "WHERE data LIKE '%".date('m/Y')."%'"; }
			$sql = $mysqli->query("SELECT COUNT(branch_id) as nmbr, branch_name, branch_id FROM booking_info $pck_branches_monthly GROUP BY branch_id ORDER BY COUNT(branch_id) ASC");
			while($row = mysqli_fetch_assoc($sql)){
				$get_target = mysqli_fetch_assoc($mysqli->query("select * from booking_monthly_target where branch_id  = '".$row['branch_id']."' and target_month = '".date('m/Y')."'"));
				if(!empty($get_target['target_month'])){ $target_value = $get_target['target']; }else{ $target_value = 'Not Set Yet!'; }
				$data_monthlya[] = array( 'y' => $row['nmbr'], 'label' => $row['branch_name'], 'target' => $target_value );				
			}
			foreach($data_monthlya as $row){
				$data_monthly[] = array( 'y' => $row['y'], 'label' => $row['label'], 'indexLabel' => 'Target: '.$row['target'].'| Total: '.$row['y'].'' );
			}
			if(empty($data_monthly)){ $data_monthly = ''; }
		?>
		<script>
			$('document').ready(function(){				
				var chart_monthly_history = new CanvasJS.Chart("chartContainer_monthly_history", {
					exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
					axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
					axisX: { title: "Branch" },
					data: [{
						type: "bar", yValueFormatString: "#,##0", indexLabelPlacement: "inside", indexLabelFontWeight: "bolder", indexLabelFontColor: "#dcdcdc",
						dataPoints: <?php echo json_encode($data_monthly, JSON_NUMERIC_CHECK); ?>
					}]
				});
				chart_monthly_history.render(); 
			})
		</script>
	<?php }else if($graph == 11){ ?>
		<div id="chartContainer_todays_booking" style="height: 370px; width: 100%;"></div>
		<?php
			$sql = $mysqli->query("SELECT COUNT(branch_id) as nmbr, branch_name, branch_id FROM booking_info WHERE data = '".date('d/m/Y')."' GROUP BY branch_id ORDER BY COUNT(branch_id) DESC");
			while($row = mysqli_fetch_assoc($sql)){ $total_vdb = 0; $sql_2 = $mysqli->query("select * from booking_info where branch_id = '".$row['branch_id']."' and data = '".date('d/m/Y')."'");
				while($booking = mysqli_fetch_assoc($sql_2)){
					$packagea = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
					$get_vdb = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$packagea['sub_category_id']."'"));
					$total_vdb = $total_vdb + $get_vdb['booking_value'];
				} $todays_booking[] = array( 'value' => $total_vdb, 'y' => $row['nmbr'], 'label' => $row['branch_name'], 'indexLabel' => 'B:'.$row['nmbr'].', P:'.$total_vdb );	
			} 
			if(!empty($todays_booking)){
				sort($todays_booking); foreach($todays_booking as $row){
					$todays_bookinga[] = array( 'y' => $row['value'], 'label' => $row['label'], 'indexLabel' => $row['indexLabel'] );
				} 
			}			
			if(empty($todays_bookinga)){ $todays_bookinga = ''; }
		?>
		<script>
			$('document').ready(function(){	
				var chart_todays_booking = new CanvasJS.Chart("chartContainer_todays_booking", {
					exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
					axisY: { title: "Members", includeZero: true, prefix: "", suffix: "" },
					axisX: { title: "Branch" },
					data: [{
						type: "bar", yValueFormatString: "#,##0", indexLabelPlacement: "inside", indexLabelFontWeight: "bolder", indexLabelFontColor: "#dcdcdc",
						dataPoints: <?php echo json_encode($todays_bookinga, JSON_NUMERIC_CHECK); ?>
					}]
				}); chart_todays_booking.render();
			})
		</script>
	<?php }else if($graph == 12){ ?>
		<div id="chartContainer_daily_renew" style="height: 370px; width: 100%;"></div>
		<?php
			$book_id = '';
			$sql = $mysqli->query("select * from member_directory where status = '1'");
			while($member = mysqli_fetch_assoc($sql)){
				$rent_count = mysqli_fetch_array($mysqli->query("select count(*) from rent_info where booking_id = '".$member['booking_id']."' and status = '1'"));
				if($rent_count[0] > 0){ $book_id .= "'".$member['booking_id']."',"; }
			}
			$booking_id_i = rtrim($book_id,','); $sql = $mysqli->query("SELECT COUNT(branch_id) as nmbr, branch_name, branch_id FROM rent_info WHERE booking_id IN (".$booking_id_i.") AND rent_status = 'Paid' AND data = '".date('d/m/Y')."' AND data_three = 'renew' AND status = '1' GROUP BY branch_id ORDER BY COUNT(branch_id) DESC");
			while($row = mysqli_fetch_assoc($sql)){ $total_vdb1 = 0; $sql_2 = $mysqli->query("select * from rent_info where branch_id = '".$row['branch_id']."' AND rent_status = 'Paid' AND data = '".date('d/m/Y')."' AND data_three = 'renew' AND status = '1'");
				while($booking = mysqli_fetch_assoc($sql_2)){ $packagea = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'")); $get_vdb1 = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$packagea['sub_category_id']."'"));
					$total_vdb1 = $total_vdb1 + $get_vdb1['booking_value'];
				} $daily_renew[] = array( 'value' => $total_vdb1, 'label' => $row['branch_name'], 'indexLabel' => 'RN:'.$row['nmbr'].', P:'.$total_vdb1 );
			} 
			if(!empty($daily_renew)){
				sort($daily_renew); foreach($daily_renew as $row){
					$daily_renewa[] = array( 'y' => $row['value'], 'label' => $row['label'], 'indexLabel' => $row['indexLabel'] );
				}
			}
			if(empty($daily_renewa)){ $daily_renewa = ''; }
		?>
		<script>
		$('document').ready(function(){	
			var chart_daily_renew = new CanvasJS.Chart("chartContainer_daily_renew", {
				exportFileName: "Top 5 Branch Wise Renew Graph", exportEnabled: true, animationEnabled: true,
				axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
				axisX: { title: "Branch" },
				data: [{
					type: "bar", yValueFormatString: "#,##0", indexLabelPlacement: "inside", indexLabelFontWeight: "bolder", indexLabelFontColor: "#dcdcdc",										
					dataPoints: <?php echo json_encode($daily_renewa, JSON_NUMERIC_CHECK); ?>
				}]
			}); chart_daily_renew.render();
		})
		</script>
	<?php }else if($graph == 13){ ?>
		<div id="branch_seat_data_1" style="height: 370px; width: 100%;"></div>
		<?php
			if(!empty($_POST['branch_id'])){ $branches = "and branch_id = '".$_POST['branch_id']."'"; }else{ $branches = ""; }			
			$booked_number = mysqli_fetch_array($mysqli->query("select count(*) as total from beds where status = '1' and uses = '2' $branches"));
			$abail_number = mysqli_fetch_array($mysqli->query("select count(*) as total from beds where status = '1' and uses = '0' $branches"));
			$rfc_number = mysqli_fetch_array($mysqli->query("select count(*) as total from beds where status = '1' and uses = '4' $branches"));
			$ocp_number = mysqli_fetch_array($mysqli->query("select count(*) as total from beds where status = '1' and uses = '3' $branches"));
			$employee_number = mysqli_fetch_array($mysqli->query("select count(*) as total from beds where status = '1' and uses = '5' $branches"));
			$outofserveoce = mysqli_fetch_array($mysqli->query("select count(*) as total from beds where status = '1' and uses = '6' $branches"));
			$disable = mysqli_fetch_array($mysqli->query("select count(*) as total from beds where status = '0' $branches"));		
			if(!empty($booked_number['total'])){ $Booked = sprintf("%02d", $booked_number['total']); } else{ $Booked = '00';}
			if(!empty($abail_number['total'])){ $Available_Beds = sprintf("%02d", $abail_number['total']); } else{ $Available_Beds = '00';}
			if(!empty($rfc_number['total'])){ $Request_For_Cancel = sprintf("%02d", $rfc_number['total']); } else{ $Request_For_Cancel = '00';}
			if(!empty($ocp_number['total'])){ $Occupied = sprintf("%02d", $ocp_number['total']); } else{ $Occupied = '00';}
			if(!empty($employee_number['total'])){ $Employee = sprintf("%02d", $employee_number['total']); } else{ $Employee = '00';}
			if(!empty($outofserveoce['total'])){ $OutOfService = sprintf("%02d", $outofserveoce['total']); } else{ $OutOfService = '00';}
			if(!empty($disable['total'])){ $Disable = sprintf("%02d", $disable['total']); } else{ $Disable = '00';}
			$occupide_req_for_cancel = $Request_For_Cancel + $Occupied;
			$branch_seat_data_1 = array(
				array("label"=> "Booked", "y"=> $Booked, "color"=>"#007bff"),
				array("label"=> "Employee ", "y"=> $Employee, "color"=>"#17cae7"),
				array("label"=> "Out Of Service ", "y"=> $OutOfService, "color"=>"#b5b5b5"),
				array("label"=> "Disable ", "y"=> $Disable, "color"=>"#000000"),
				array("label"=> "Available Beds", "y"=> $Available_Beds, "color"=>"#28a745"),
				//array("label"=> "Request For Cancel", "y"=> $Request_For_Cancel, "color"=>"#f00000"),
				//array("label"=> "Occupied ", "y"=> $Occupied, "color"=>"#ffc107"),								
				array("label"=> "Occupied + Request For Cancel", "y"=> $occupide_req_for_cancel, "color"=>"#ffc107")
			);
		?>
		<script>
		$('document').ready(function(){
			var branch_seat_data_1 = new CanvasJS.Chart("branch_seat_data_1", {
				animationEnabled: true, exportEnabled: true,
				data: [{
					type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
					dataPoints: <?php echo json_encode($branch_seat_data_1, JSON_NUMERIC_CHECK); ?>
				}]
			}); branch_seat_data_1.render();
		})
		</script>
	<?php }else if($graph == 14){ ?>
		<div id="branch_wise_occupide_percentage" style="height: 370px; width: 100%;"></div>
		<?php error_reporting(0); 
			if(!empty($_POST['branch_id'])){ 
				$branches = "where branch_id = '".$_POST['branch_id']."' and status = '1'"; 
				$branchewos = "WHERE branch_id = '".$_POST['branch_id']."'";
			}else{ 
				$branches = "where status = '1'";
				$branchewos = "";
			}		
			$tota1 = 0; $total2 = 0; $totar1 = 0; $totjr1 = 0; $rocp = 0; $rcnmbr = 0; $abnmbr = 0; $bknmbr = 0; $y1_val = 0; $y2_val = 0; $y3_val = 0; $y4_val = 0;
			$sql = $mysqli->query("select * from branches $branches");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['id'] != '1'){
					if(!empty($row['branch_id'])){
						$ibok = 1; $bknmbr = 0; $total1 = 1; $total2 = 0;
						$spl = $mysqli->query("select * from beds $branchewos");
						while($oc = mysqli_fetch_assoc($spl)){
							if($oc['branch_id'] == $row['branch_id']){
								$total2 = $total1++;
							}
							if($oc['branch_id'] == $row['branch_id'] AND $oc['uses'] == 2 AND $oc['status'] == 1){
								$bknmbr = $ibok++;
							}						
						}
						$array_br_val1[] = array("y" => $bknmbr, "label" => $row['branch_code'] .'('.$total2.')', "color" => "#007bff");
						$iabl = 1; $abnmbr = 0; $tota = 1; $tota1 = 0;
						$spl2 = $mysqli->query("select * from beds $branchewos");
						while($oc = mysqli_fetch_assoc($spl2)){
							if($oc['branch_id'] == $row['branch_id']){
								$tota1 = $tota++;
							}
							if($oc['branch_id'] == $row['branch_id'] AND $oc['uses'] == 0 AND $oc['status'] == 1){
								$abnmbr = $iabl++;
							}					
						}
						$array_br_val2[] = array("y"=> $abnmbr, "label" => $row['branch_code'] .'('.$tota1.')', "color" => "#28a745");
						$irfc = 1; $rcnmbr = 0; $totar = 1; $totar1 = 0;
						$spl3 = $mysqli->query("select * from beds $branchewos");
						while($oc = mysqli_fetch_assoc($spl3)){
							if($oc['branch_id'] == $row['branch_id']){
								$totar1 = $totar++;
							}
							if($oc['branch_id'] == $row['branch_id'] AND $oc['uses'] == 4 AND $oc['status'] == 1){
								$rcnmbr = $irfc++;
							}					
						}
						$array_br_val3[] = array("y"=> $rcnmbr, "label" => $row['branch_code'] .'('.$totar1.')', "color" => "#f00000");
						$iocp1 = 1; $rocp1 = 0; $totjr1 = 1; $totjr11 = 0;
						$spl4 = $mysqli->query("select * from beds $branchewos");
						while($oc = mysqli_fetch_assoc($spl4)){
							if($oc['branch_id'] == $row['branch_id']){
								$totjr11 = $totjr1++;
							}
							if($oc['branch_id'] == $row['branch_id'] AND $oc['uses'] == 3 AND $oc['status'] == 1){
								$rocp1 = $iocp1++;
							}
						}
						$array_br_val4[] = array("y"=> $rocp1 + $rcnmbr, "label" => $row['branch_code'] .'('.$totjr11.')', "color" => "#ffc107");
						$iocp2 = 1; $rocp2 = 0; $totjr2 = 1; $totjr12 = 0;	
						$spl5 = $mysqli->query("select * from beds $branchewos");
						while($oc = mysqli_fetch_assoc($spl5)){
							if($oc['branch_id'] == $row['branch_id']){
								$totjr12 = $totjr2++;
							}
							if($oc['branch_id'] == $row['branch_id'] AND $oc['uses'] == 5 AND $oc['status'] == 1){
								$rocp2 = $iocp2++;
							}
						}
						$array_br_val5[] = array("y"=> $rocp2, "label" => $row['branch_code'] .'('.$totjr12.')', "color" => "#17cae7");	
						$iocp3 = 1; $rocp3 = 0; $totjr3 = 1; $totjr13 = 0;
						$spl6 = $mysqli->query("select * from beds $branchewos");
						while($oc = mysqli_fetch_assoc($spl6)){
							if($oc['branch_id'] == $row['branch_id']){
								$totjr13 = $totjr3++;
							}
							if($oc['branch_id'] == $row['branch_id'] AND $oc['uses'] == 6 AND $oc['status'] == 1){
								$rocp3 = $iocp3++;
							}
						}	
						$array_br_val6[] = array("y"=> $rocp3, "label" => $row['branch_code'] .'('.$totjr13.')', "color" => "#b5b5b5");	
						$iocp4 = 1; $rocp4 = 0; $totjr4 = 1; $totjr14 = 0;
						$spl7 = $mysqli->query("select * from beds $branchewos");
						while($oc = mysqli_fetch_assoc($spl7)){
							if($oc['branch_id'] == $row['branch_id']){
								$totjr14 = $totjr4++;
							}
							if($oc['branch_id'] == $row['branch_id'] AND $oc['status'] == 0){
								$rocp4 = $iocp4++;
							}
						}					
						$array_br_val7[] = array("y"=> $rocp4, "label" => $row['branch_code'] .'('.$totjr14.')', "color" => "#333333");
					}
				}
				$dataPoints1 = $array_br_val1;
				$dataPoints2 = $array_br_val2;
				$dataPoints3 = $array_br_val3;
				$dataPoints4 = $array_br_val4;
				$dataPoints5 = $array_br_val5;
				$dataPoints6 = $array_br_val6;
				$dataPoints7 = $array_br_val7;
			}
							
		?>
		<script>
		$('document').ready(function(){
			var branch_wise_occupide_percentage = new CanvasJS.Chart("branch_wise_occupide_percentage", {
				theme: "light1", //"light1", "dark1", "dark2"
				exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true, zoomEnabled: true, zoomType: "xy",
				axisY:{ suffix: "" },
				toolTip:{ shared: true, },
				data:[
					/* {
						type: "stackedBar", toolTipContent: "{label} Total Bed: 100% <br><b style = '\"'color:#f00000;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Request For Cancel", color: "#f00000",
						dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
					},
					*/
					
					{										
						type: "stackedBar", toolTipContent: "<b style = '\"'color:#007bff;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true, name: "Booked", color: "#007bff",
						dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
					},{
						type: "stackedBar", toolTipContent: "<b style = '\"'color:#ffc107;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Occupide", color: "#ffc107",
						dataPoints: <?php echo json_encode($dataPoints4, JSON_NUMERIC_CHECK); ?>
					},{
						type: "stackedBar", toolTipContent: "<b style = '\"'color:#17cae7;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Employee", color: "#17cae7",
						dataPoints: <?php echo json_encode($dataPoints5, JSON_NUMERIC_CHECK); ?>
					},{
						type: "stackedBar", toolTipContent: "<b style = '\"'color:#b5b5b5;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Out Of Service", color: "#b5b5b5",
						dataPoints: <?php echo json_encode($dataPoints6, JSON_NUMERIC_CHECK); ?>
					},{
						type: "stackedBar", toolTipContent: "<b style = '\"'color:#333333;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Disable", color: "#333333",
						dataPoints: <?php echo json_encode($dataPoints7, JSON_NUMERIC_CHECK); ?>
					},{
						type: "stackedBar", toolTipContent: "<b style = '\"'color:#28a745;'\"'>{name}:</b> {y} (#percent%)", showInLegend: true,  name: "Avaiable", color: "#28a745",											
						dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
					}										
				]
			});
			branch_wise_occupide_percentage.render();
		})
		</script>
	<?php }else if($graph == 15){ ?>
		<div id="monthly_package_booking" style="height: 370px; width: 100%;"></div>
	<?php
		if(isset($_POST['branch_id'])){
			if(!empty($_POST['branch_id'])){
				$sub_package_branch_id = " AND branch_id = '".$_POST['branch_id']."'";
			}else{
				$sub_package_branch_id = "";
			}								
		}else{
			if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
				$sub_package_branch_id = "";
			}else{
				$sub_package_branch_id = " AND branch_id = '".$_SESSION['super_admin']['branch']."'";	
			} 
		} $sql = $mysqli->query("SELECT * FROM sub_package_category ORDER BY id DESC");
		while($sub = mysqli_fetch_assoc($sql)){
			$package_ids = '';
			$packages_count = $mysqli->query("SELECT * FROM packages WHERE sub_category_id = '".$sub['id']."'");
			while($packw = mysqli_fetch_assoc($packages_count)){
				$package_ids .= "'".$packw['id']."',";
			} $final_pk_ids = rtrim($package_ids,',');
			$booking_count = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) AS total_booking FROM booking_info WHERE package IN ($final_pk_ids) AND data like '%".date('m/Y')."' $sub_package_branch_id"));
			$count_sub[] = array( 'y' => $booking_count['total_booking'], 'label' => $sub['sub_package_name'] );		
		} if(!empty($count_sub)){
			$package_data = $count_sub;
		}else{
			$package_data = '';
		}
	?>
	<script>		
		$('document').ready(function(){
			var monthly_package_booking = new CanvasJS.Chart("monthly_package_booking", {
				exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
				axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
				axisX: { title: "Branch" },
				data: [
					{
						type: "bar", yValueFormatString: "#,##0", indexLabel: "{y}", indexLabelPlacement: "inside", indexLabelFontWeight: "bolder", indexLabelFontColor: "white",
						dataPoints: <?php echo json_encode($package_data, JSON_NUMERIC_CHECK); ?>
					}
				]
			});
			monthly_package_booking.render();
		})
	</script>
	<?php }else if($graph == 16){ ?>
		<div id="package_wise_exixting_member" style="height: 370px; width: 100%;"></div>
	<?php
		if(isset($_POST['branch_id'])){
			if(!empty($_POST['branch_id'])){
				$sub_package_branch_id = " AND branch_id = '".$_POST['branch_id']."'";
			}else{
				$sub_package_branch_id = "";
			}								
		}else{
			if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
				$sub_package_branch_id = "";
			}else{
				$sub_package_branch_id = " AND branch_id = '".$_SESSION['super_admin']['branch']."'";	
			} 
		} $sql = $mysqli->query("SELECT * FROM sub_package_category ORDER BY id DESC");
		while($sub = mysqli_fetch_assoc($sql)){
			$package_ids = '';
			$packages_count = $mysqli->query("SELECT * FROM packages WHERE sub_category_id = '".$sub['id']."'");
			while($packw = mysqli_fetch_assoc($packages_count)){
				$package_ids .= "'".$packw['id']."',";
			} $final_pk_ids = rtrim($package_ids,',');
			$booking_count = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) AS total_member FROM member_directory WHERE package IN ($final_pk_ids) AND status = '1' $sub_package_branch_id"));
			$e_count_sub[] = array( 'y' => $booking_count['total_member'], 'label' => $sub['sub_package_name'] );		
		} if(!empty($e_count_sub)){
			$e_package_data = $e_count_sub;
		}else{
			$e_package_data = '';
		}
	?>

	<script>									
		$('document').ready(function(){
			var package_wise_exixting_member = new CanvasJS.Chart("package_wise_exixting_member", {
				exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
				axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
				axisX: { title: "Branch" },
				data: [
					{
						type: "bar", yValueFormatString: "#,##0", indexLabel: "{y}", indexLabelPlacement: "inside", indexLabelFontWeight: "bolder", indexLabelFontColor: "white",
						dataPoints: <?php echo json_encode($e_package_data, JSON_NUMERIC_CHECK); ?>
					}
				]
			});
			package_wise_exixting_member.render();
		})
	</script>
	<?php }else if($graph == 17){ ?>
		<iframe src="http://erp.superhostelbd.com/super_home/assets/graph/" style="height: 364px; width: 100%;border:none;" scrolling="no"></iframe>
	<?php }else if($graph == 18){ ?>
		<div id="sels_winneer" style="height: 370px; width: 100%;"></div>
		<?php
			$sql = $mysqli->query("select * from employee where role in ('1179783255713532148') and status = 1");
			while($row = mysqli_fetch_assoc($sql)){
				$role = mysqli_fetch_assoc($mysqli->query("select * from roles where role_id = '".$row['role']."'"));
				$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch']."'"));
				$uploader_info = $role['role_name'].'___'.$row['email'].'___'.$branch['branch_id'];
				$total_value = 0;
				$sql_2 = $mysqli->query("select * from booking_info where uploader_info = '".$uploader_info."'");
				while($booking = mysqli_fetch_assoc($sql_2)){
					$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
					$get_value = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package['sub_category_id']."'"));
					$total_value = $total_value + $get_value['booking_value'];
				}
				if($total_value > 0){
					$get_aray[] = array('y' => $total_value, 'label' => $row['full_name']);
				}
			}
			sort($get_aray);
		?>
		<script>
		$('document').ready(function(){
			var sels_winneer = new CanvasJS.Chart("sels_winneer", {
				exportFileName: "Top 5 Branch Wise Booking Graph", exportEnabled: true, animationEnabled: true,
				axisY: { title: "Members", includeZero: true, prefix: "", suffix:  "" },
				axisX: { title: "Branch" },
				data: [
					{
						type: "bar", yValueFormatString: "#,##0", indexLabel: "{y}", indexLabelPlacement: "inside", indexLabelFontWeight: "bolder", indexLabelFontColor: "white",
						dataPoints: <?php echo json_encode($get_aray, JSON_NUMERIC_CHECK); ?>
					}
				]
			});
			sels_winneer.render();
		})
		</script>
	<?php }else if($graph == 19){ ?>
		<div id="booking_religion_percentage_oco" style="height: 370px; width: 100%;"></div>
		<?php
			$Islam = 0; $Hindu = 0; $Christian = 0; $Buddhist = 0; $riligioiin_Other = 0;
			$sql = $mysqli->query("select * from member_directory where status = '1'");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['religion'] == 'Islam' ){ $Islam = $Islam + 1; }
				if($row['religion'] == 'Hindu' ){ $Hindu = $Hindu + 1; }
				if($row['religion'] == 'Christian' ){ $Christian = $Christian + 1; }
				if($row['religion'] == 'Buddhist' ){ $Buddhist = $Buddhist + 1; }
				if($row['religion'] == 'Other' ){ $riligioiin_Other = $riligioiin_Other + 1; }
			}
			$member_riligion_number_oco = array(
				array("label"=> "Islam", "y"=> $Islam),
				array("label"=> "Hindu", "y"=> $Hindu),
				array("label"=> "Christian", "y"=> $Christian),
				array("label"=> "Buddhist", "y"=> $Buddhist),
				array("label"=> "Other", "y"=> $riligioiin_Other)
			);	
		?>
		<script>
			$('document').ready(function(){
				var booking_religion_percentage_oco = new CanvasJS.Chart("booking_religion_percentage_oco", {
					animationEnabled: true, exportEnabled: true,
					data: [{
						type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
						dataPoints: <?php echo json_encode($member_riligion_number_oco, JSON_NUMERIC_CHECK); ?>
					}]
				});				
				booking_religion_percentage_oco.render();
			})
		</script>
	<?php }else if($graph == 20){ ?>
		<div id="booking_occupation_percentage_oco" style="height: 370px; width: 100%;"></div>
		<?php
			$Student = 0; $Job_Holder = 0; $Business_Man = 0; $Teacher = 0; $Doctor = 0; $Driver = 0; $Housewife = 0; $occupation_Other = 0;
			$sql = $mysqli->query("select * from member_directory where status = '1'");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['occupation'] == 'Student' ){ $Student = $Student + 1; }
				if($row['occupation'] == 'Job Holder' ){ $Job_Holder = $Job_Holder + 1; }
				if($row['occupation'] == 'Business Man' ){ $Business_Man = $Business_Man + 1; }
				if($row['occupation'] == 'Teacher' ){ $Teacher = $Teacher + 1; }
				if($row['occupation'] == 'Doctor' ){ $Doctor = $Doctor + 1; }
				if($row['occupation'] == 'Driver' ){ $Driver = $Driver + 1; }
				if($row['occupation'] == 'Housewife' ){ $Housewife = $Housewife + 1; }
				if($row['occupation'] == 'Other' ){ $occupation_Other = $occupation_Other + 1; }
			}
			$member_occupation_number_oco = array(
				array("label"=> "Student", "y"=> $Student),
				array("label"=> "Job Holder", "y"=> $Job_Holder),
				array("label"=> "Business Man", "y"=> $Business_Man),
				array("label"=> "Teacher", "y"=> $Teacher),
				array("label"=> "Doctor", "y"=> $Doctor),
				array("label"=> "Driver", "y"=> $Driver),
				array("label"=> "Housewife", "y"=> $Housewife),
				array("label"=> "Other", "y"=> $occupation_Other)
			);	
		?>
		<script>
			$('document').ready(function(){								
				var booking_occupation_percentage_oco = new CanvasJS.Chart("booking_occupation_percentage_oco", {
					animationEnabled: true,
					exportEnabled: true,
					data: [{
						type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
						dataPoints: <?php echo json_encode($member_occupation_number_oco, JSON_NUMERIC_CHECK); ?>
					}]
				});
				booking_occupation_percentage_oco.render();
			})
		</script>
	<?php }else if($graph == 21){ ?>
		<div id="booking_how_to_find_us_percentage_oco" style="height: 370px; width: 100%;"></div>
		<?php
			$SH_Member = 0; $SH_Share_Holder = 0; $News_Paper = 0; $Google = 0; $Facebook = 0; $SMS = 0; $Youtube = 0; $Parents = 0; $TVC = 0; $Friends = 0; $Colleague = 0; $I_dont_Know = 0; $howtofindus_Other = 0;
			$sql = $mysqli->query("select * from member_directory where status = '1'");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['h_t_f_u'] == 'SH Member' ){ $SH_Member = $SH_Member + 1; }else
				if($row['h_t_f_u'] == 'SH Share Holder' ){ $SH_Share_Holder = $SH_Share_Holder + 1; }else
				if($row['h_t_f_u'] == 'News Paper' ){ $News_Paper = $News_Paper + 1; }else
				if($row['h_t_f_u'] == 'Google' ){ $Google = $Google + 1; }else
				if($row['h_t_f_u'] == 'Facebook' ){ $Facebook = $Facebook + 1; }else
				if($row['h_t_f_u'] == 'SMS' ){ $SMS = $SMS + 1; }else
				if($row['h_t_f_u'] == 'Youtube' ){ $Youtube = $Youtube + 1; }else
				if($row['h_t_f_u'] == 'Parents' ){ $Parents = $Parents + 1; }else
				if($row['h_t_f_u'] == 'TVC' ){ $TVC = $TVC + 1; }else
				if($row['h_t_f_u'] == 'Friends' ){ $Friends = $Friends + 1; }else
				if($row['h_t_f_u'] == 'Colleague' ){ $Colleague = $Colleague + 1; }else
				if($row['h_t_f_u'] == 'I dont Know' ){ $I_dont_Know = $I_dont_Know + 1; }else{
					$howtofindus_Other = $howtofindus_Other + 1;
				}
			}
			$member_howtofindus_number_oco = array(
				array("label"=> "SH Member", "y"=> $SH_Member),
				array("label"=> "SH Share Holder", "y"=> $SH_Share_Holder),
				array("label"=> "News Paper", "y"=> $News_Paper),
				array("label"=> "Google", "y"=> $Google),
				array("label"=> "Facebook", "y"=> $Facebook),
				array("label"=> "SMS", "y"=> $SMS),
				array("label"=> "Youtube", "y"=> $Youtube),
				array("label"=> "Parents", "y"=> $Parents),
				array("label"=> "TVC", "y"=> $TVC),
				array("label"=> "Friends", "y"=> $Friends),
				array("label"=> "Colleague", "y"=> $Colleague),
				array("label"=> "I dont Know", "y"=> $I_dont_Know),
				array("label"=> "Other", "y"=> $howtofindus_Other)
			);	
		?>
		<script>
			$(document).ready(function(){
			var booking_how_to_find_us_percentage_oco = new CanvasJS.Chart("booking_how_to_find_us_percentage_oco", {
					animationEnabled: true,
					exportEnabled: true,
					data: [{
						type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
						dataPoints: <?php echo json_encode($member_howtofindus_number_oco, JSON_NUMERIC_CHECK); ?>
					}]
				});
				booking_how_to_find_us_percentage_oco.render();
			})
		</script>
	<?php }else if($graph == 22){ ?>
		<div id="booking_religion_percentage" style="height: 370px; width: 100%;"></div>
		<?php
			$Islam = 0; $Hindu = 0; $Christian = 0; $Buddhist = 0; $riligioiin_Other = 0;
			$sql = $mysqli->query("select * from member_directory");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['religion'] == 'Islam' ){ $Islam = $Islam + 1; }
				if($row['religion'] == 'Hindu' ){ $Hindu = $Hindu + 1; }
				if($row['religion'] == 'Christian' ){ $Christian = $Christian + 1; }
				if($row['religion'] == 'Buddhist' ){ $Buddhist = $Buddhist + 1; }
				if($row['religion'] == 'Other' ){ $riligioiin_Other = $riligioiin_Other + 1; }
			}
			$member_riligion_number_oco = array(
				array("label"=> "Islam", "y"=> $Islam),
				array("label"=> "Hindu", "y"=> $Hindu),
				array("label"=> "Christian", "y"=> $Christian),
				array("label"=> "Buddhist", "y"=> $Buddhist),
				array("label"=> "Other", "y"=> $riligioiin_Other)
			);	
		?>
		<script>
			$('document').ready(function(){
				var booking_religion_percentage = new CanvasJS.Chart("booking_religion_percentage", {
					animationEnabled: true, exportEnabled: true,
					data: [{
						type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
						dataPoints: <?php echo json_encode($member_riligion_number_oco, JSON_NUMERIC_CHECK); ?>
					}]
				});				
				booking_religion_percentage.render();
			})
		</script>
	<?php }else if($graph == 23){ ?>
		<div id="booking_occupation_percentage" style="height: 370px; width: 100%;"></div>
		<?php
			$Student = 0; $Job_Holder = 0; $Business_Man = 0; $Teacher = 0; $Doctor = 0; $Driver = 0; $Housewife = 0; $occupation_Other = 0;
			$sql = $mysqli->query("select * from member_directory");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['occupation'] == 'Student' ){ $Student = $Student + 1; }
				if($row['occupation'] == 'Job Holder' ){ $Job_Holder = $Job_Holder + 1; }
				if($row['occupation'] == 'Business Man' ){ $Business_Man = $Business_Man + 1; }
				if($row['occupation'] == 'Teacher' ){ $Teacher = $Teacher + 1; }
				if($row['occupation'] == 'Doctor' ){ $Doctor = $Doctor + 1; }
				if($row['occupation'] == 'Driver' ){ $Driver = $Driver + 1; }
				if($row['occupation'] == 'Housewife' ){ $Housewife = $Housewife + 1; }
				if($row['occupation'] == 'Other' ){ $occupation_Other = $occupation_Other + 1; }
			}
			$member_occupation_number_oco = array(
				array("label"=> "Student", "y"=> $Student),
				array("label"=> "Job Holder", "y"=> $Job_Holder),
				array("label"=> "Business Man", "y"=> $Business_Man),
				array("label"=> "Teacher", "y"=> $Teacher),
				array("label"=> "Doctor", "y"=> $Doctor),
				array("label"=> "Driver", "y"=> $Driver),
				array("label"=> "Housewife", "y"=> $Housewife),
				array("label"=> "Other", "y"=> $occupation_Other)
			);	
		?>
		<script>
			$('document').ready(function(){								
				var booking_occupation_percentage = new CanvasJS.Chart("booking_occupation_percentage", {
					animationEnabled: true,
					exportEnabled: true,
					data: [{
						type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
						dataPoints: <?php echo json_encode($member_occupation_number_oco, JSON_NUMERIC_CHECK); ?>
					}]
				});
				booking_occupation_percentage.render();
			})
		</script>
	<?php }else if($graph == 24){ ?>
		<div id="booking_how_to_find_us_percentage" style="height: 370px; width: 100%;"></div>
		<?php
			$SH_Member = 0; $SH_Share_Holder = 0; $News_Paper = 0; $Google = 0; $Facebook = 0; $SMS = 0; $Youtube = 0; $Parents = 0; $TVC = 0; $Friends = 0; $Colleague = 0; $I_dont_Know = 0; $howtofindus_Other = 0;
			$sql = $mysqli->query("select * from member_directory");
			while($row = mysqli_fetch_assoc($sql)){
				if($row['h_t_f_u'] == 'SH Member' ){ $SH_Member = $SH_Member + 1; }else
				if($row['h_t_f_u'] == 'SH Share Holder' ){ $SH_Share_Holder = $SH_Share_Holder + 1; }else
				if($row['h_t_f_u'] == 'News Paper' ){ $News_Paper = $News_Paper + 1; }else
				if($row['h_t_f_u'] == 'Google' ){ $Google = $Google + 1; }else
				if($row['h_t_f_u'] == 'Facebook' ){ $Facebook = $Facebook + 1; }else
				if($row['h_t_f_u'] == 'SMS' ){ $SMS = $SMS + 1; }else
				if($row['h_t_f_u'] == 'Youtube' ){ $Youtube = $Youtube + 1; }else
				if($row['h_t_f_u'] == 'Parents' ){ $Parents = $Parents + 1; }else
				if($row['h_t_f_u'] == 'TVC' ){ $TVC = $TVC + 1; }else
				if($row['h_t_f_u'] == 'Friends' ){ $Friends = $Friends + 1; }else
				if($row['h_t_f_u'] == 'Colleague' ){ $Colleague = $Colleague + 1; }else
				if($row['h_t_f_u'] == 'I dont Know' ){ $I_dont_Know = $I_dont_Know + 1; }else{
					$howtofindus_Other = $howtofindus_Other + 1;
				}
			}
			$member_howtofindus_number_oco = array(
				array("label"=> "SH Member", "y"=> $SH_Member),
				array("label"=> "SH Share Holder", "y"=> $SH_Share_Holder),
				array("label"=> "News Paper", "y"=> $News_Paper),
				array("label"=> "Google", "y"=> $Google),
				array("label"=> "Facebook", "y"=> $Facebook),
				array("label"=> "SMS", "y"=> $SMS),
				array("label"=> "Youtube", "y"=> $Youtube),
				array("label"=> "Parents", "y"=> $Parents),
				array("label"=> "TVC", "y"=> $TVC),
				array("label"=> "Friends", "y"=> $Friends),
				array("label"=> "Colleague", "y"=> $Colleague),
				array("label"=> "I dont Know", "y"=> $I_dont_Know),
				array("label"=> "Other", "y"=> $howtofindus_Other)
			);	
		?>
		<script>
			$(document).ready(function(){
			var booking_how_to_find_us_percentage = new CanvasJS.Chart("booking_how_to_find_us_percentage", {
					animationEnabled: true,
					exportEnabled: true,
					data: [{
						type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
						dataPoints: <?php echo json_encode($member_howtofindus_number_oco, JSON_NUMERIC_CHECK); ?>
					}]
				});
				booking_how_to_find_us_percentage.render();
			})
		</script>
	<?php }else if($graph == 25){ ?>
		<center>			
			<div id="daily_renew_percentage_chart" style="height: 400px; width: 100%;"></div>
		</center>
		<?php
			if(isset($_POST['date_range'])){
				$one = explode(' - ',$_POST['date_range']);	
				$one_ymd = explode('/',$one[0]);
				$two_ymd = explode('/',$one[1]);
				$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
				$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
				$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
			}else{
				$date_filter = " AND data = '".date('d/m/Y')."'";
			}
			$one_day = 0; $three_day = 0; $seven_day = 0; $fifteen_day = 0; $thirty_day = 0;			
			$sql = $mysqli->query("select * from rent_info where rent_status = 'Paid' $date_filter AND data_three = 'renew' AND status = '1'"); //booking_id IN (select booking_id from member_directory where status = '1') and
			while($row = mysqli_fetch_assoc($sql)){
				$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));				
				if($package['package_days'] == '1' ){ $one_day = $one_day + 1; }
				if($package['package_days'] == '3' ){ $three_day = $three_day + 1; }
				if($package['package_days'] == '7' ){ $seven_day = $seven_day + 1; }
				if($package['package_days'] == '15' ){ $fifteen_day = $fifteen_day + 1; }
				if($package['package_days'] == '30' ){ $thirty_day = $thirty_day + 1; }				
			}		
			$daily_renew_percentage_chart = array(
				array("label"=> "1 Day", "y"=> $one_day),
				array("label"=> "3 Day", "y"=> $three_day),
				array("label"=> "7 Day", "y"=> $seven_day),
				array("label"=> "15 Day", "y"=> $fifteen_day),
				array("label"=> "30 Day", "y"=> $thirty_day)
			);
		?>
		<script>
			$('document').ready(function(){
				setTimeout(function(){ 
					var daily_renew_percentage_chart = new CanvasJS.Chart("daily_renew_percentage_chart", {
						animationEnabled: true, exportEnabled: true,
						data: [{
							type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
							dataPoints: <?php echo json_encode($daily_renew_percentage_chart, JSON_NUMERIC_CHECK); ?>
						}]
					});				
					daily_renew_percentage_chart.render();
				}, 1000);			
			})
		</script>
	<?php }else if($graph == 26){ ?>
		<center>			
			<div id="daily_booking_percentage_chart" style="height: 400px; width: 100%;"></div>
		</center>
		<?php
			if(isset($_POST['date_range'])){
				$one = explode(' - ',$_POST['date_range']);	
				$one_ymd = explode('/',$one[0]);
				$two_ymd = explode('/',$one[1]);
				$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
				$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
				$date_filter = " STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
			}else{
				$date_filter = " data = '".date('d/m/Y')."'";
			}
			$one_day = 0; $three_day = 0; $seven_day = 0; $fifteen_day = 0; $thirty_day = 0;			
			$sql = $mysqli->query("SELECT * FROM booking_info WHERE $date_filter"); 
			while($row = mysqli_fetch_assoc($sql)){
				$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));				
				if($package['package_days'] == '1' ){ $one_day = $one_day + 1; }
				if($package['package_days'] == '3' ){ $three_day = $three_day + 1; }
				if($package['package_days'] == '7' ){ $seven_day = $seven_day + 1; }
				if($package['package_days'] == '15' ){ $fifteen_day = $fifteen_day + 1; }
				if($package['package_days'] == '30' ){ $thirty_day = $thirty_day + 1; }				
			}		
			$daily_booking_percentage_chart = array(
				array("label"=> "1 Day", "y"=> $one_day),
				array("label"=> "3 Day", "y"=> $three_day),
				array("label"=> "7 Day", "y"=> $seven_day),
				array("label"=> "15 Day", "y"=> $fifteen_day),
				array("label"=> "30 Day", "y"=> $thirty_day)
			);
		?>
		<script>
			$('document').ready(function(){
				setTimeout(function(){ 
					var daily_booking_percentage_chart = new CanvasJS.Chart("daily_booking_percentage_chart", {
						animationEnabled: true, exportEnabled: true,
						data: [{
							type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
							dataPoints: <?php echo json_encode($daily_booking_percentage_chart, JSON_NUMERIC_CHECK); ?>
						}]
					});				
					daily_booking_percentage_chart.render();
				}, 1000);			
			})
		</script>
	<?php }else if($graph == 27){ ?>
		<center>			
			<div id="monthly_booking_percentage_chart" style="height: 400px; width: 100%;"></div>
		</center>
		<?php
			error_reporting(0);
			$d = date_create($_POST['date_range']);
			$date = date_format($d,'m/Y');
			$one_day = 0; $three_day = 0; $seven_day = 0; $fifteen_day = 0; $thirty_day = 0;			
			$sql = $mysqli->query("SELECT * FROM booking_info WHERE data LIKE '%".$date."%'"); 
			while($row = mysqli_fetch_assoc($sql)){
				$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));				
				if($package['package_days'] == '1' ){ $one_day = $one_day + 1; }
				if($package['package_days'] == '3' ){ $three_day = $three_day + 1; }
				if($package['package_days'] == '7' ){ $seven_day = $seven_day + 1; }
				if($package['package_days'] == '15' ){ $fifteen_day = $fifteen_day + 1; }
				if($package['package_days'] == '30' ){ $thirty_day = $thirty_day + 1; }				
			}		
			$monthly_booking_percentage_chart = array(
				array("label"=> "1 Day", "y"=> $one_day),
				array("label"=> "3 Day", "y"=> $three_day),
				array("label"=> "7 Day", "y"=> $seven_day),
				array("label"=> "15 Day", "y"=> $fifteen_day),
				array("label"=> "30 Day (Including Package)", "y"=> $thirty_day)
			);
		?>
		<script>
			$('document').ready(function(){
				setTimeout(function(){ 
					var monthly_booking_percentage_chart = new CanvasJS.Chart("monthly_booking_percentage_chart", {
						animationEnabled: true, exportEnabled: true,
						data: [{
							type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
							dataPoints: <?php echo json_encode($monthly_booking_percentage_chart, JSON_NUMERIC_CHECK); ?>
						}]
					});				
					monthly_booking_percentage_chart.render();
				}, 1000);			
			})
		</script>
	<?php }else if($graph == 28){ ?>
		<center>			
			<div id="live_booking_percentage" style="height: 400px; width: 100%;"></div>
		</center>
		<?php
			$one_day = 0; $three_day = 0; $seven_day = 0; $fifteen_day = 0; $thirty_day = 0; $thirty_day_mem = 0;		
			$sql = $mysqli->query("SELECT * FROM member_directory WHERE status = '1' and card_number = 'Unauthorized'"); 
			while($row = mysqli_fetch_assoc($sql)){
				$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));				
				if($package['package_days'] == '1' ){ $one_day = $one_day + 1; }
				if($package['package_days'] == '3' ){ $three_day = $three_day + 1; }
				if($package['package_days'] == '7' ){ $seven_day = $seven_day + 1; }
				if($package['package_days'] == '15' ){ $fifteen_day = $fifteen_day + 1; }
				if($package['try_us'] == 1){
					if($package['package_days'] == '30' ){ $thirty_day = $thirty_day + 1; }	
				}else{
					if($package['package_days'] == '30' ){ $thirty_day_mem = $thirty_day_mem + 1; }	
				}				
			}		
			$live_booking_percentage = array(
				array("label"=> "1 Day", "y"=> $one_day),
				array("label"=> "3 Day", "y"=> $three_day),
				array("label"=> "7 Day", "y"=> $seven_day),
				array("label"=> "15 Day", "y"=> $fifteen_day),
				array("label"=> "30 Day (Try Us)", "y"=> $thirty_day),
				array("label"=> "30 Day (Membership)", "y"=> $thirty_day_mem)
			);
		?>
		<script>
			$('document').ready(function(){
				setTimeout(function(){ 
					var live_booking_percentage = new CanvasJS.Chart("live_booking_percentage", {
						animationEnabled: true, exportEnabled: true,
						data: [{
							type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
							dataPoints: <?php echo json_encode($live_booking_percentage, JSON_NUMERIC_CHECK); ?>
						}]
					});				
					live_booking_percentage.render();
				}, 1000);			
			})
		</script>
	<?php }else if($graph == 29){ ?>		
		<?php
			if(isset($_POST['branch_id'])){
				if(!empty($_POST['branch_id'])){
					$sub_package_branch_id = " AND branch_id = '".$_POST['branch_id']."'";
				}else{
					$sub_package_branch_id = "";
				}								
			}else{
				if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
					$sub_package_branch_id = "";
				}else{
					$sub_package_branch_id = " AND branch_id = '".$_SESSION['super_admin']['branch']."'";	
				} 
			} 
			if(isset($_POST['date_range'])){
				$one = explode(' - ',$_POST['date_range']);	
				$one_ymd = explode('/',$one[0]);
				$two_ymd = explode('/',$one[1]);
				$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
				$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
				$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
			}else{
				$date_filter = " AND data like '%".date('m/Y')."'";
			}
			$total_count = 0;
			$sql = $mysqli->query("SELECT * FROM sub_package_category ORDER BY id DESC");
			while($sub = mysqli_fetch_assoc($sql)){
				$package_ids = '';
				$packages_count = $mysqli->query("SELECT * FROM packages WHERE sub_category_id = '".$sub['id']."'");
				while($packw = mysqli_fetch_assoc($packages_count)){
					$package_ids .= "'".$packw['id']."',";
				}			
				$final_pk_ids = rtrim($package_ids,',');				
				$booking_count = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) AS total_booking FROM booking_info WHERE package IN ($final_pk_ids) AND data like '%".date('m/Y')."' $sub_package_branch_id"));
				$count_sub[] = array('label' => $sub['sub_package_name'], 'y' => $booking_count['total_booking'] );		
				$total_count = $total_count + $booking_count['total_booking'];
			}			
			if(!empty($count_sub)){
				$package_data = $count_sub;
			}else{
				$package_data = '';
			}					
			$live_monthly_package_wise_booking_percentage = $package_data;
		?>
		<div class="col-sm-12" style="text-align:right;">
			Total: <b style="color:#f00;"><?php echo $total_count; ?></b>
		</div>
		<center>			
			<div id="live_monthly_package_wise_booking_percentage" style="height: 400px; width: 100%;"></div>
		</center>
		<script>
			$('document').ready(function(){
				setTimeout(function(){ 
					var live_monthly_package_wise_booking_percentage = new CanvasJS.Chart("live_monthly_package_wise_booking_percentage", {
						animationEnabled: true, exportEnabled: true,
						data: [{
							type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
							dataPoints: <?php echo json_encode($live_monthly_package_wise_booking_percentage, JSON_NUMERIC_CHECK); ?>
						}]
					});				
					live_monthly_package_wise_booking_percentage.render();
				}, 1000);			
			})
		</script>
	<?php }else if($graph == 30){ ?>		
		<?php
			if(isset($_POST['branch_id'])){
				if(!empty($_POST['branch_id'])){
					$sub_package_branch_id = " AND branch_id = '".$_POST['branch_id']."'";
				}else{
					$sub_package_branch_id = "";
				}								
			}else{
				if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
					$sub_package_branch_id = "";
				}else{
					$sub_package_branch_id = " AND branch_id = '".$_SESSION['super_admin']['branch']."'";	
				} 
			} 
			if(isset($_POST['date_range'])){
				$one = explode(' - ',$_POST['date_range']);	
				$one_ymd = explode('/',$one[0]);
				$two_ymd = explode('/',$one[1]);
				$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
				$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
				$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
			}else{
				$date_filter = " AND data like '%".date('m/Y')."'";
			}	
			$total_count = 0;
			$sql = $mysqli->query("SELECT * FROM sub_package_category ORDER BY id DESC");
			while($sub = mysqli_fetch_assoc($sql)){
				$package_ids = '';
				$packages_count = $mysqli->query("SELECT * FROM packages WHERE sub_category_id = '".$sub['id']."'");
				while($packw = mysqli_fetch_assoc($packages_count)){
					$package_ids .= "'".$packw['id']."',";
				} $final_pk_ids = rtrim($package_ids,',');
				$booking_count = mysqli_fetch_assoc($mysqli->query("SELECT COUNT(id) AS total_member FROM member_directory WHERE package IN ($final_pk_ids) AND status = '1' $sub_package_branch_id"));
				$e_count_sub[] = array( 'label' => $sub['sub_package_name'], 'y' => $booking_count['total_member']);		
				$total_count = $total_count + $booking_count['total_member'];
			} 
			if(!empty($e_count_sub)){
				$e_package_data = $e_count_sub;
			}else{
				$e_package_data = '';
			}	
			$package_wise_exixting_member_chart = $e_package_data;
		?>
		<div class="col-sm-12" style="text-align:right;">
			Total: <b style="color:#f00;"><?php echo $total_count; ?></b>
		</div>
		<center>			
			<div id="package_wise_exixting_member_chart2" style="height: 400px; width: 100%;"></div>
		</center>
		<script>
			$('document').ready(function(){
				setTimeout(function(){ 
					var package_wise_exixting_member_chart2 = new CanvasJS.Chart("package_wise_exixting_member_chart2", {
						animationEnabled: true, exportEnabled: true,
						data: [{
							type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
							dataPoints: <?php echo json_encode($package_wise_exixting_member_chart, JSON_NUMERIC_CHECK); ?>
						}]
					});				
					package_wise_exixting_member_chart2.render();
				}, 1000);			
			})
		</script>
	<?php }else if($graph == 31){ ?>		
		<?php
			if(isset($_POST['date_range'])){
				$one = explode(' - ',$_POST['date_range']);	
				$one_ymd = explode('/',$one[0]);
				$two_ymd = explode('/',$one[1]);
				$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
				$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
				$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
			}else{
				$date_filter = "";
			}
			$total_count = 0;
			$sql = $mysqli->query("select * from employee where role in ('1179783255713532148') and status = 1");
			while($row = mysqli_fetch_assoc($sql)){
				$role = mysqli_fetch_assoc($mysqli->query("select * from roles where role_id = '".$row['role']."'"));
				$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch']."'"));
				$uploader_info = $role['role_name'].'___'.$row['email'].'___'.$branch['branch_id'];
				$total_value = 0;
				$sql_2 = $mysqli->query("select * from booking_info where uploader_info = '".$uploader_info."' ");
				while($booking = mysqli_fetch_assoc($sql_2)){
					$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
					$get_value = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package['sub_category_id']."'"));
					$total_value = $total_value + $get_value['booking_value'];
				}
				if($total_value > 0){
					$get_aray[] = array('label' => $row['full_name'], 'y' => $total_value);
					$total_count = $total_count + $total_value;
				}
			}
			sort($get_aray);
			if(!empty($get_aray)){
				$e_package_data1 = $get_aray;
			}else{
				$e_package_data1 = '';
			}	
			$employee_live_booking_value_chart = $e_package_data1;
			
		?>
		<div class="col-sm-12" style="text-align:right;">
			Total: <b style="color:#f00;"><?php echo $total_count; ?></b>
		</div>
		<center>			
			<div id="employee_live_booking_value_chart" style="height: 400px; width: 100%;"></div>
		</center>
		<script>
			$('document').ready(function(){
				setTimeout(function(){ 
					var employee_live_booking_value_chart = new CanvasJS.Chart("employee_live_booking_value_chart", {
						animationEnabled: true, exportEnabled: true,
						data: [{
							type: "pie", showInLegend: "true", legendText: "{label}", indexLabelFontSize: 16, indexLabel: "{label} - #percent%", yValueFormatString: "#,##0",
							dataPoints: <?php echo json_encode($employee_live_booking_value_chart, JSON_NUMERIC_CHECK); ?>
						}]
					});				
					employee_live_booking_value_chart.render();
				}, 1000);			
			})
		</script>
	<?php }else if($graph == 32){ ?>		
		<?php
			$total_amount_collection = 0;
			$sql = $mysqli->query("select * from collection_money_from_dropbox");
			while($row = mysqli_fetch_assoc($sql)){
				$cl_amount = 0;
				$ids = explode(",",$row['transaction_ids']);
				foreach($ids as $iow){
					$dow = mysqli_fetch_assoc($mysqli->query("select * from drop_box_data where status = '1' and id = '".$iow."'"));
					$cl_amount = (float)$cl_amount + (float)$dow['amount'];
				}
				$total_amount_collection = (float)$total_amount_collection + (float)$cl_amount;
			}
			$drop_collected_money = $total_amount_collection;
		?>
		<span style="color:#333;">Collected:</span> <?php if(!empty($drop_collected_money)){ echo '<b style="color:#f00;">'.money($drop_collected_money).'</b>'; } else{ echo money(0); } ?>
	
	<?php }else if($graph == 33){ ?>		
		<?php
			$total_amount_collection = 0;
			$sql = $mysqli->query("select * from collection_money_from_dropbox where data like '%".date('m/Y')."'");
			while($row = mysqli_fetch_assoc($sql)){
				$cl_amount = 0;
				$ids = explode(",",$row['transaction_ids']);
				foreach($ids as $iow){
					$dow = mysqli_fetch_assoc($mysqli->query("select * from drop_box_data where status = '1' and id = '".$iow."'"));
					$cl_amount = (float)$cl_amount + (float)$dow['amount'];
				}
				$total_amount_collection = (float)$total_amount_collection + (float)$cl_amount;
			}
			$drop_collected_money = $total_amount_collection;
		?>
		<span style="color:#333;"><?=date('F'); ?> Collected:</span> <?php if(!empty($drop_collected_money)){ echo '<b style="color:#f00;">'.money($drop_collected_money).'</b>'; } else{ echo money(0); } ?>
	<?php }else if($graph == 34){ ?>		
		<?php
			if(isset($_POST['branch_id'])){
				$form_branch_id = $_POST['branch_id'];
			}else{
				$form_branch_id = '';
			}	
			$drop_amount = 0;
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				if(!empty($form_branch_id)){
					$branches = "and branch_id = '".$form_branch_id."'";
				}else{
					$branches = "";
				}
				$sql = $mysqli->query("select * from drop_box_data where status = '1' AND note != 'money_collected' $branches");
				while($dow = mysqli_fetch_assoc($sql)){
					$drop_amount = (float)$drop_amount + (float)$dow['amount'];
				}
				$bql = $mysqli->query("select * from branches where status = '1' $branches");
			}else{				
				$role_id = $_SESSION['super_admin']['role_id'];
				$branch_per = mysqli_fetch_assoc($mysqli->query("select * from branch_permission where role_id = '".$role_id."'"));
				$branchids = explode(",",$branch_per['permission']);
				$branches = ''; $get_branch = ''; $ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}				
				if($ides_branch == '1'){			
					if(!empty($form_branch_id)){
						$get_branch = "'".$form_branch_id."'";						
					}else{
						$get_branch = rtrim($branches,",");
					}
						
					$sql = $mysqli->query("select * from drop_box_data where status = '1' AND note != 'money_collected' and branch_id in (".$get_branch.")");
					while($dow = mysqli_fetch_assoc($sql)){
						$drop_amount = (float)$drop_amount + (float)$dow['amount'];
					}
					$bql = $mysqli->query("select * from branches where branch_id in (".$get_branch.") and status = '1'");
				}else{
					if(!empty($form_branch_id)){
						$branch_id = $form_branch_id;
					}else{
						$branch_id = $_SESSION['super_admin']['branch'];
					}					
					$sql = $mysqli->query("select * from drop_box_data where status = '1' AND note != 'money_collected' and branch_id = '".$branch_id."'");
					while($dow = mysqli_fetch_assoc($sql)){
						$drop_amount = (float)$drop_amount + (float)$dow['amount'];
					}
					$bql = $mysqli->query("select * from branches where branch_id = '".$branch_id."' and status = '1'");
				}
			}
		?>
		<div class="btn-group" style="width:100%;">
			<button class="btn btn-outline-dark dropdown-toggle" style="width:100%;"  data-toggle="dropdown">
				In DropBox: <?php if(!empty($drop_amount)){ echo '<b style="color:#f00;">'.money($drop_amount).'</b>'; } else{ echo money(0); } ?>
			</button>
			<div class="dropdown-menu" style="width:100%;">
				<?php					
					$i = 1;
					while($row = mysqli_fetch_assoc($bql)){
						$drop_branch_amount = 0;
						$dropbox = $mysqli->query("select * from drop_box_data where status = '1' AND note != 'money_collected' and branch_id = '".$row['branch_id']."'");
						while($dxw = mysqli_fetch_assoc($dropbox)){
							$drop_branch_amount = (int)$drop_branch_amount + (int)$dxw['amount'];
						}
				?>
				<a class="dropdown-item" style="font-size: 13px;">
					<div class="row">
						<?php if($i++ == 1){ ?>
							<div class="col-md-4">
								<span>Location</span>
							</div>
							<div class="col-md-4">
								<span style="float:right;color:green;font-weight:bolder;">Outside Dropbox</span>
							</div>
							<div class="col-md-4">
								<span style="float:right;color:red;font-weight:bolder;">In Dropbox</span>
							</div>
						<?php } ?>
						<div class="col-md-4">
							<span><?php echo $row['branch_name']; ?></span>
						</div>
						<div class="col-md-4">
							<span style="float:right;color:green;font-weight:bolder;">
							<?php 
							//$this->Dashboard_model->mysqlii("SELECT payment_received_method.branch_id, SUM(payment_received_method.cash_amount + payment_received_method.check_amount) as sum_amount FROM payment_received_method INNER JOIN transaction on transaction.transaction_id = payment_received_method.transaction_id where payment_received_method.note != 'drop_box_checked' AND ( payment_received_method.cash_amount > 0 OR payment_received_method.check_amount > 0 ) AND payment_received_method.status = 1 AND STR_TO_DATE(payment_received_method.data,'%d/%m/%Y') between '2021/04/01' and '".date('Y/m/d')."' AND transaction.transaction_type = 'Credit' GROUP BY payment_received_method.branch_id");
							$total_out = 0;
							$prm = $mysqli->query("select * from payment_received_method where branch_id = '".$row['branch_id']."' and note not in ('drop_box_checked') AND ( cash_amount > 0 OR check_amount > 0 ) and transaction_id in (select transaction_id from transaction where transaction_type = 'Credit') AND STR_TO_DATE(data,'%d/%m/%Y') between '2021/04/01' and '".date('Y/m/d')."'");
							while($out_side = mysqli_fetch_assoc($prm)){
								if(!empty($out_side['cash_amount']) and (float)$out_side['cash_amount'] > 0){
									$cash_amount = (float)$out_side['cash_amount'];
								}else{
									$cash_amount = 0;
								}
								if(!empty($out_side['check_amount']) and (float)$out_side['check_amount'] > 0){
									$check_amount = (float)$out_side['check_amount'];
								}else{
									$check_amount = 0;
								}
								$key = $cash_amount + $check_amount;
								$total_out = $total_out + $key;
							}
							echo money($total_out); 
							?>
							</span>
						</div>
						<div class="col-md-4">
							<span style="float:right;color:red;font-weight:bolder;"><?php echo money($drop_branch_amount); ?></span>
						</div>
					</div>
				</a>
				<?php  }  ?>
			</div>
		</div>
	<?php }else if($graph ==35){ ?>		
		<?php
			if(isset($_POST['branch_id'])){
				$form_branch_id = $_POST['branch_id'];
			}else{
				$form_branch_id = '';
			}	
			$petty_amount = 0;
			$branch_data_petty[] = '';
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				if(!empty($form_branch_id)){
					$branches = "and branch_id = '".$form_branch_id."'";
				}else{
					$branches = "";
				}
				$sql = $mysqli->query("select * from branches where status = 1 $branches");
				while($row = mysqli_fetch_assoc($sql)){
					$pow = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branch_petty_cash where branch_id = '".$row['branch_id']."'"));
					$petty_amount = $petty_amount + (float)$pow['amount'];
					$branch_data_petty[] = array($row['branch_name'], $pow['amount'], $row['petty_cash_limit']);
				}
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$branch_per = mysqli_fetch_assoc($mysqli->query("select * from branch_permission where role_id = '".$role_id."'"));
				$branchids = explode(",",$branch_per['permission']);
				$branches = ''; $get_branch = ''; $ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){			
					if(!empty($form_branch_id)){
						$get_branch = "'".$form_branch_id."'";						
					}else{
						$get_branch = rtrim($branches,",");
					}					
					$sql = $mysqli->query("select * from branches where status = 1 and branch_id in (".$get_branch.")");
					while($row = mysqli_fetch_assoc($sql)){
						$pow = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branch_petty_cash where branch_id = '".$row['branch_id']."'"));
						$petty_amount = $petty_amount + (float)$pow['amount'];
						$branch_data_petty[] = array($row['branch_name'], $pow['amount'], $row['petty_cash_limit']);
					}
				}else{
					if(!empty($form_branch_id)){
						$branch_id = $form_branch_id;
					}else{
						$branch_id = $_SESSION['super_admin']['branch'];
					}	
					$sql = $mysqli->query("select * from branches where status = 1 and branch_id = '".$branch_id."'");
					while($row = mysqli_fetch_assoc($sql)){
						$pow = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branch_petty_cash where branch_id = '".$row['branch_id']."'"));
						$petty_amount = $petty_amount + (float)$pow['amount'];
						$branch_data_petty[] = array($row['branch_name'], $pow['amount'], $row['petty_cash_limit']);
					}
				}
			}
		?>
		<div class="btn-group" style="width:100%;">
			<button class="btn btn-outline-dark dropdown-toggle" style="width:100%;"  data-toggle="dropdown">
				Petty Cash: <?php if(!empty($petty_amount)){ echo '<b style="color:#f00;">'.money($petty_amount).'</b>'; } else{ echo money(0); } ?>
			</button>
			<div class="dropdown-menu" style="width:100%;">
				<?php
					if(!empty($branch_data_petty)){
						foreach($branch_data_petty as $idx=>$key){
				?>
				<a class="dropdown-item">
					<div class="row justify-content-between text-center">
						<?php if($idx == 0){ ?>
							<div class="col-sm-4">
								<span>Location</span>
							</div>
							<div class="col-sm-4 align-self-center">
								<span>Cash Limit</span>
							</div>
							<div class="col-sm-4 align-self-center">
								<span>In Hand</span>
							</div>
						<?php } ?>
						<div class="col-sm-4">
							<span><?php if(!empty($key[0])){ echo $key[0]; } ?></span>
						</div>
						<div class="col-sm-4 align-self-center">
							<span style="color:#4caf50;font-weight:bolder;font-size: 14px;"><?php if(!empty($key[2])){ echo $key[2]; } ?></span>
						</div>
						<div class="col-sm-4 align-self-center">
							<span style="color:red;font-weight:bolder;font-size: 14px;"><?php if(!empty($key[1])){ echo $key[1]; }else if($idx != 0){ echo 0; } ?></span>
						</div>
					</div>
				</a>
				<?php } }?>
			</div>
		</div>
	<?php }else if($graph ==36){ ?>		
		<?php
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				$total_ipo_sum = mysqli_fetch_assoc($mysqli->query("SELECT SUM(cash_amount) + SUM(check_amount) as sum_cash FROM ipo_payment_received_method where note != 'cash_received'"));
				$sql = $mysqli->query("SELECT SUM(cash_amount) + SUM(check_amount) as sum_cash, employee.f_Name, employee.l_Name FROM ipo_payment_received_method INNER JOIN employee on employee.employee_id = ipo_payment_received_method.uploader_employee_id where ipo_payment_received_method.note != 'cash_received' GROUP BY ipo_payment_received_method.uploader_employee_id");
				$link = 'href="'.$home.'admin/report/ipo-payment-report'.'"';
			}else{
				$link = 'href="javascript:void(0);"';
				$total_ipo_sum = mysqli_fetch_assoc($mysqli->query("SELECT SUM(cash_amount) + SUM(check_amount) as sum_cash FROM ipo_payment_received_method where note != 'cash_received' AND uploader_employee_id = '".$_SESSION['super_admin']['employee_ids']."'"));
				$sql = $mysqli->query("SELECT SUM(cash_amount) + SUM(check_amount) as sum_cash, employee.f_Name, employee.l_Name FROM ipo_payment_received_method INNER JOIN employee on employee.employee_id = ipo_payment_received_method.uploader_employee_id where ipo_payment_received_method.note != 'cash_received' AND ipo_payment_received_method.uploader_employee_id = '".$_SESSION['super_admin']['employee_ids']."'");
			}
		?>
		<div class="btn-group" style="width:100%;">
			<button class="btn btn-outline-dark dropdown-toggle" style="width:100%;"  data-toggle="dropdown">
				Local Investment : <?php if(!empty($total_ipo_sum)){ echo '<b style="color:#f00;">'.money($total_ipo_sum['sum_cash']).'</b>'; } else{ echo money(0); } ?>
			</button>
			<div class="dropdown-menu" style="width:100%;">
				<?php
					while($ipo_sum = mysqli_fetch_assoc($sql)){
				?>
					<a <?php echo $link; ?> class="dropdown-item">
						<span><?php echo $ipo_sum['f_Name'].' '.$ipo_sum['l_Name'] ;?></span>
						<span style="float:right;color:red;font-weight:bolder;"><?php echo money($ipo_sum['sum_cash']);?></span>
					</a>
				<?php } ?>
			</div>
		</div>
	<?php }else if($graph ==37){ ?>		
		<?php
			if(isset($_POST['branch_id'])){
				$form_branch_id = $_POST['branch_id'];
			}else{
				$form_branch_id = '';
			}
			if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
				if(!empty($form_branch_id)){
					$branches = "and branch_id = '".$form_branch_id."'";
				}else{
					$branches = "";
				}
				$sql = $mysqli->query("SELECT * FROM packages_category where status = '1' $branches");
				$ttl_pcg_c = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as total FROM packages_category where status = '1' $branches"));
			}else{
				$role_id = $_SESSION['super_admin']['role_id'];
				$branch_per = mysqli_fetch_assoc($mysqli->query("select * from branch_permission where role_id = '".$role_id."'"));
				$branchids = explode(",",$branch_per['permission']);
				$branches = ''; $get_branch = ''; $ides_branch = '0';
				foreach($branchids as $row){
					if($row != '0'){
						$branches .= "'".$row."',";
						$ides_branch = '1';
					}
				}
				if($ides_branch == '1'){			
					if(!empty($form_branch_id)){
						$get_branch = "'".$form_branch_id."'";						
					}else{
						$get_branch = rtrim($branches,",");
					}					
					$sql = $mysqli->query("SELECT * FROM packages_category where status = '1' and branch_id in (".$get_branch.")");
					$ttl_pcg_c = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as total FROM packages_category where status = '1' and branch_id in (".$get_branch.")"));
				}else{
					if(!empty($form_branch_id)){
						$branch_id = $form_branch_id;
					}else{
						$branch_id = $_SESSION['super_admin']['branch'];
					}	
					$sql = $mysqli->query("SELECT * FROM packages_category where status = '1' and branch_id = '".$branch_id."'");
					$ttl_pcg_c = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as total FROM packages_category where status = '1' and branch_id = '".$branch_id."'"));
				}
			}
		?>
		<div class="row">
			<?php
				$nun = 0;
				$numb = $ttl_pcg_c['total'];
				while($row = mysqli_fetch_assoc($sql)){
					$relt = 100 / $numb;
					$mou = mysqli_fetch_assoc($mysqli->query("select count(*) as total_member from member_directory where package_category = '".$row['id']."'"));
					$nun = $mou['total_member'];
			?>
			<div class="col-sm-2 nmbr_cls_dash" style="min-width: <?php echo $relt; ?>% !important;">
				<span style="position: absolute; z-index: 995; color: #fff; font-size: 9px; width: 86%; text-align: right;"><?php echo $row['branch_name']; ?></span>
				<div class="small-box bg-dark" style="margin-bottom:0px;">
					<div class="inner" style="padding-bottom:0px;">
						<h5 style="margin-bottom:0px;"><?php echo $row['package_category_name']; ?> <sup style="font-size: 12px"><?php echo $nun; ?></sup></h5>
						<p style="margin-bottom:0px;">
							<marquee>
								<?php 
									$result = '';
									$pql = $mysqli->query("SELECT * FROM packages where status = '1' and package_category_id = '".$row['id']."' and branch_id = '".$row['branch_id']."'");
									while($pow = mysqli_fetch_assoc($pql)){
											$mow = mysqli_fetch_assoc($mysqli->query("select count(*) as total_member from member_directory where package = '".$pow['id']."'"));
											$num = $mow['total_member'];																						
										$result .= '<span>'.$pow['package_name'].': <span style="color:orange;font-weight:bolder;">'.$num.'</span></span>&nbsp;|&nbsp;';												
										
									}
									echo rtrim($result,"&nbsp;|&nbsp;");
								 ?>
							</marquee>
						</p>
					</div>
					
				</div>
			</div>					
			<?php			
				}				
			?>
		</div>
	<?php }else{ ?>
		
<?php } ?>
<?php } ?>