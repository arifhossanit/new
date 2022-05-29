<?php
error_reporting(0);
//exit;
include("../../../application/config/ajax_config.php");
if(isset($_POST['get_details'])){
	
	if(!empty($_POST['date_filter'])){
		$d = explode("-",$_POST['date_filter']); //Y-m-d
		$date_s_one = $d[2].'/'.$d[1].'/'.$d[0]; //d/m/Y
		$date_s_two = $d[0].'/'.$d[1].'/'.$d[2]; //Y/m/d
		$date_s_three = $d[0].'-'.$d[1].'-'.$d[2]; //Y-m-d
		
		$min_date=date("d/m/Y",strtotime('-1 days',strtotime($date_s_two)));
		
		$startDate = date("Y/m/d",strtotime('last friday -6days',strtotime($date_s_two)));
		$endDate = date("Y/m/d",strtotime('last friday',strtotime($date_s_two)));
		
		$d = new DateTime($date_s_three, new DateTimeZone('UTC')); 
		$d->modify('first day of previous month'); 
		$last_month_my = $d->format('m/Y');
		
		$sgm = new DateTime($date_s_three, new DateTimeZone('UTC')); 
		$sgm->modify('first day of previous month'); 
		$month_start = $sgm->format('d/m/Y');
		
		$egm = new DateTime($date_s_three, new DateTimeZone('UTC')); 
		$egm->modify('last day of previous month'); 
		$month_end = $egm->format('d/m/Y');
		
		$date = explode("-",$_POST['date_filter']);
	}else{
		$min_date=date("d/m/Y",strtotime('-1 days',strtotime(date("Y/m/d"))));
		
		$startDate=date("Y/m/d",strtotime('last friday -6days',strtotime(date("Y/m/d"))));
		$endDate=date("Y/m/d",strtotime('last friday',strtotime(date("Y/m/d"))));
		
		$d = new DateTime(date('Y-m-d'), new DateTimeZone('UTC')); 
		$d->modify('first day of previous month'); 
		$last_month_my = $d->format('m/Y');
		
		$sgm = new DateTime(date('Y-m-d'), new DateTimeZone('UTC')); 
		$sgm->modify('first day of previous month'); 
		$month_start = $sgm->format('d/m/Y');
		
		$egm = new DateTime(date('Y-m-d'), new DateTimeZone('UTC')); 
		$egm->modify('last day of previous month'); 
		$month_end = $egm->format('d/m/Y');
		
		$date = explode("-",date('Y-m-d'));
	}
	
	$live_date = date('Ymd');
	$get_selected_date = $date[0].''.$date[1].''.$date[2];
	
	if($live_date == $get_selected_date){
		$p_hour = date('Hi');
		$P_ampm = date('A');
		if($p_hour >= '1000'){
			$publishing_time = 1;
		}else{
			$publishing_time = 0;
		}		
	}else{
		$publishing_time = 1;
	}

	if($publishing_time == 1){
	
	$total_value = 0;
	$total_value1 = 0;
	$total_value12 = 0;
	
	$total_booked = 0;
	$total_booked1 = 0;
	$total_booked12 = 0;
	
	$award = mysqli_fetch_assoc($mysqli->query("SELECT * FROM sales_award_price WHERE id = '1'"));
	$emp = $mysqli->query("SELECT * FROM employee WHERE role IN ('1179783255713532148') AND status = 1 ORDER BY id ASC");
	while($row = mysqli_fetch_assoc($emp)){
		$role = mysqli_fetch_assoc($mysqli->query("SELECT * FROM roles WHERE role_id = '".$row['role']."'"));
		$branch = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$row['branch']."'"));
		$uploader_info = $role['role_name'].'___'.$row['email'];		
		$total_value = 0;
		$total_booked = 0;
		$bkql = $mysqli->query("SELECT * FROM booking_info WHERE uploader_info LIKE '".$uploader_info."%' AND count_reword = '' AND card_no != 'Unauthorized' AND checkin_date = '".$min_date."'");
		while($booking = mysqli_fetch_assoc($bkql)){
			$package = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$booking['package']."'"));
			$get_value = mysqli_fetch_assoc($mysqli->query("SELECT * FROM sub_package_category WHERE id = '".$package['sub_category_id']."'"));
			$total_value = $total_value + $get_value['booking_value'];
			$total_booked = $total_booked + 1;
		}		
		if($total_booked > 0){
			$total_booked = $total_booked;
		}else{
			$total_booked = 0;
		}		
		if($total_value >= $award['last_day_point_limit'] AND $award['_1st_price'] == 1){
			$get_aray[] = array(
				'value' => $total_value,
				'booked' => $total_booked,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value >= $award['second_last_day_point_limit'] AND $award['_2nd_price'] == 1){
			$get_aray_second[] = array(
				'value' => $total_value,
				'booked' => $total_booked,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value >= $award['thired_last_day_point_limit'] AND $award['_3rd_price'] == 1){
			$get_aray_thired[] = array(
				'value' => $total_value,
				'booked' => $total_booked,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value >= $award['forth_last_day_point_limit'] AND $award['_4th_price'] == 1){
			$get_aray_forth[] = array(
				'value' => $total_value,
				'booked' => $total_booked,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value >= $award['fifth_last_day_point_limit'] AND $award['_5th_price'] == 1){
			$get_aray_fifth[] = array(
				'value' => $total_value,
				'booked' => $total_booked,
				'employee_id' => $row['employee_id']
			);
		}else{
			if($award['sales_looser'] == 1){
				$get_aray_looser[] = array(
					'value' => $total_value,
					'booked' => $total_booked,
					'employee_id' => $row['employee_id']
				);
			}
		}		
		$total_value1 = 0;
		$total_booked1 = 0;
		$bkql1 = $mysqli->query("SELECT * FROM booking_info WHERE uploader_info LIKE '".$uploader_info."%' AND count_reword = '' AND card_no != 'Unauthorized' AND STR_TO_DATE(checkin_date,'%d/%m/%Y') BETWEEN '$startDate' AND '$endDate'");
		while($booking1 = mysqli_fetch_assoc($bkql1)){
			$package1 = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$booking1['package']."'"));
			$get_value1 = mysqli_fetch_assoc($mysqli->query("SELECT * FROM sub_package_category WHERE id = '".$package1['sub_category_id']."'"));
			$total_value1 = $total_value1 + $get_value1['booking_value'];
			$total_booked1 = $total_booked1 + 1;
		}
		if($total_booked1 > 0){
			$total_booked1 = $total_booked1;
		}else{
			$total_booked1 = 0;
		}
		if($total_value1 >= $award['last_week_point_limit'] AND $award['_1st_price'] == 1){
			$get_aray1[] = array(
				'value' => $total_value1,
				'booked' => $total_booked1,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value1 >= $award['second_last_week_point_limit'] AND $award['_2nd_price'] == 1){
			$get_aray1_second[] = array(
				'value' => $total_value1,
				'booked' => $total_booked1,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value1 >= $award['thired_last_week_point_limit'] AND $award['_3rd_price'] == 1){
			$get_aray1_thired[] = array(
				'value' => $total_value1,
				'booked' => $total_booked1,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value1 >= $award['forth_last_week_point_limit'] AND $award['_4th_price'] == 1){
			$get_aray1_forth[] = array(
				'value' => $total_value1,
				'booked' => $total_booked1,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value1 >= $award['fifth_last_week_point_limit'] AND $award['_5th_price'] == 1){
			$get_aray1_fifth[] = array(
				'value' => $total_value1,
				'booked' => $total_booked1,
				'employee_id' => $row['employee_id']
			);
		}else{
			if($award['sales_looser'] == 1){
				$get_aray1_looser[] = array(
					'value' => $total_value1,
					'booked' => $total_booked1,
					'employee_id' => $row['employee_id']
				);
			}
		}		
		$total_value12 = 0;
		$total_booked12 = 0;		
		$bkql12 = $mysqli->query("SELECT * FROM booking_info WHERE uploader_info LIKE '".$uploader_info."%' AND count_reword = '' AND card_no != 'Unauthorized' AND checkin_date LIKE '%".$last_month_my."'");
		while($booking12 = mysqli_fetch_assoc($bkql12)){
			$package12 = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$booking12['package']."'"));
			$get_value12 = mysqli_fetch_assoc($mysqli->query("SELECT * FROM sub_package_category WHERE id = '".$package12['sub_category_id']."'"));
			$total_value12 = $total_value12 + $get_value12['booking_value'];
			$total_booked12 = $total_booked12 + 1;
		}		
		if($total_booked12 > 0){
			$total_booked12 = $total_booked12;
		}else{
			$total_booked12 = 0;
		}		
		if($total_value12 >= $award['last_month_point_limit'] AND $award['_1st_price'] == 1){
			$get_aray12[] = array(
				'value' => $total_value12,
				'booked' => $total_booked12,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value12 >= $award['second_last_month_point_limit'] AND $award['_2nd_price'] == 1){
			$get_aray12_second[] = array(
				'value' => $total_value12,
				'booked' => $total_booked12,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value12 >= $award['thired_last_month_point_limit'] AND $award['_3rd_price'] == 1){
			$get_aray12_thired[] = array(
				'value' => $total_value12,
				'booked' => $total_booked12,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value12 >= $award['forth_last_month_point_limit'] AND $award['_4th_price'] == 1){
			$get_aray12_forth[] = array(
				'value' => $total_value12,
				'booked' => $total_booked12,
				'employee_id' => $row['employee_id']
			);
		}else if($total_value12 >= $award['fifth_last_month_point_limit'] AND $award['_5th_price'] == 1){
			$get_aray12_fifth[] = array(
				'value' => $total_value12,
				'booked' => $total_booked12,
				'employee_id' => $row['employee_id']
			);
		}else{
			if($award['sales_looser'] == 1){
				$get_aray12_looser[] = array(
					'value' => $total_value12,
					'booked' => $total_booked12,
					'employee_id' => $row['employee_id']
				);
			}	
		}	
	}	
	$sD = explode("/",$startDate);
	$startWeek = $sD[2].'/'.$sD[1].'/'.$sD[0];
	$eD = explode("/",$endDate);
	$endWeek = $eD[2].'/'.$eD[1].'/'.$eD[0];	
	
	$check_award_data = mysqli_fetch_assoc($mysqli->query("SELECT * FROM home_award_data WHERE days = '".$date[2]."' AND months = '".$date[1]."' AND years = '".$date[0]."'"));
	if(!empty($check_award_data['id'])){
		$get_aray = json_decode($check_award_data['day_data'], true); $get_aray1 = json_decode($check_award_data['week_data'], true); $get_aray12 = json_decode($check_award_data['month_data'], true); $get_aray_second = json_decode($check_award_data['second_day_data'], true); $get_aray1_second = json_decode($check_award_data['second_week_data'], true); $get_aray12_second = json_decode($check_award_data['second_month_data'], true); $get_aray_thired = json_decode($check_award_data['thired_day_data'], true); $get_aray1_thired = json_decode($check_award_data['thired_week_data'], true); $get_aray12_thired = json_decode($check_award_data['thired_month_data'], true); $get_aray_forth = json_decode($check_award_data['forth_day_data'], true); $get_aray1_forth = json_decode($check_award_data['forth_week_data'], true); $get_aray12_forth = json_decode($check_award_data['forth_month_data'], true); $get_aray_fifth = json_decode($check_award_data['fifth_day_data'], true); $get_aray1_fifth = json_decode($check_award_data['fifth_week_data'], true); $get_aray12_fifth = json_decode($check_award_data['fifth_month_data'], true); $get_aray_looser = json_decode($check_award_data['looser_day_data'], true); $get_aray1_looser = json_decode($check_award_data['looser_week_data'], true); $get_aray12_looser = json_decode($check_award_data['looser_month_data'], true);		
		rsort($get_aray); rsort($get_aray1); rsort($get_aray12); rsort($get_aray_second); rsort($get_aray1_second); rsort($get_aray12_second); rsort($get_aray_thired); rsort($get_aray1_thired); rsort($get_aray12_thired); rsort($get_aray_forth); rsort($get_aray1_forth); rsort($get_aray12_forth); rsort($get_aray_fifth); rsort($get_aray1_fifth); rsort($get_aray12_fifth); rsort($get_aray_looser); rsort($get_aray1_looser); rsort($get_aray12_looser);
	}else{		
		if($mysqli->query("INSERT INTO home_award_data VALUES( '', '".$mysqli->real_escape_string(json_encode($get_aray))."', '".$mysqli->real_escape_string(json_encode($get_aray_second))."', '".$mysqli->real_escape_string(json_encode($get_aray_thired))."', '".$mysqli->real_escape_string(json_encode($get_aray_forth))."', '".$mysqli->real_escape_string(json_encode($get_aray_fifth))."', '".$mysqli->real_escape_string(json_encode($get_aray_looser))."', '".$mysqli->real_escape_string(json_encode($get_aray1))."', '".$mysqli->real_escape_string(json_encode($get_aray1_second))."', '".$mysqli->real_escape_string(json_encode($get_aray1_thired))."', '".$mysqli->real_escape_string(json_encode($get_aray1_forth))."', '".$mysqli->real_escape_string(json_encode($get_aray1_fifth))."', '".$mysqli->real_escape_string(json_encode($get_aray1_looser))."', '".$mysqli->real_escape_string(json_encode($get_aray12))."', '".$mysqli->real_escape_string(json_encode($get_aray12_second))."', '".$mysqli->real_escape_string(json_encode($get_aray12_thired))."', '".$mysqli->real_escape_string(json_encode($get_aray12_forth))."', '".$mysqli->real_escape_string(json_encode($get_aray12_fifth))."', '".$mysqli->real_escape_string(json_encode($get_aray12_looser))."', '".date('d/m/Y')."', '".$date[2]."', '".$date[1]."', '".$date[0]."', '".uploader_info()."' )")){			
			$get_data = mysqli_fetch_assoc($mysqli->query("SELECT * FROM home_award_data WHERE days = '".$date[2]."' AND months = '".$date[1]."' AND years = '".$date[0]."'"));
			$get_aray = json_decode($get_data['day_data'], true); $get_aray1 = json_decode($get_data['week_data'], true); $get_aray12 = json_decode($get_data['month_data'], true); $get_aray_second = json_decode($get_data['second_day_data'], true); $get_aray1_second = json_decode($get_data['second_week_data'], true); $get_aray12_second = json_decode($get_data['second_month_data'], true); $get_aray_thired = json_decode($get_data['thired_day_data'], true); $get_aray1_thired = json_decode($get_data['thired_week_data'], true); $get_aray12_thired = json_decode($get_data['thired_month_data'], true); $get_aray_forth = json_decode($get_data['forth_day_data'], true); $get_aray1_forth = json_decode($get_data['forth_week_data'], true); $get_aray12_forth = json_decode($get_data['forth_month_data'], true); $get_aray_fifth = json_decode($get_data['fifth_day_data'], true); $get_aray1_fifth = json_decode($get_data['fifth_week_data'], true); $get_aray12_fifth = json_decode($get_data['fifth_month_data'], true); $get_aray_looser = json_decode($get_data['looser_day_data'], true); $get_aray1_looser = json_decode($get_data['looser_week_data'], true); $get_aray12_looser = json_decode($get_data['looser_month_data'], true);			
			rsort($get_aray); rsort($get_aray1); rsort($get_aray12); rsort($get_aray_second); rsort($get_aray1_second); rsort($get_aray12_second); rsort($get_aray_thired); rsort($get_aray1_thired); rsort($get_aray12_thired); rsort($get_aray_forth); rsort($get_aray1_forth); rsort($get_aray12_forth); rsort($get_aray_fifth); rsort($get_aray1_fifth); rsort($get_aray12_fifth); rsort($get_aray_looser); rsort($get_aray1_looser); rsort($get_aray12_looser);
		}else{
			rsort($get_aray); rsort($get_aray1); rsort($get_aray12); rsort($get_aray_second); rsort($get_aray1_second); rsort($get_aray12_second); rsort($get_aray_thired); rsort($get_aray1_thired); rsort($get_aray12_thired); rsort($get_aray_forth); rsort($get_aray1_forth); rsort($get_aray12_forth); rsort($get_aray_fifth); rsort($get_aray1_fifth); rsort($get_aray12_fifth); rsort($get_aray_looser); rsort($get_aray1_looser); rsort($get_aray12_looser);
		}
	}
?>
<div class="row">	
	<div class="col-sm-12" style=""><!--min-height:900px;max-height:900px;overflow-y:scroll;-->	
    <?php if($award['_1st_price'] == 1){ ?>   
		<div class="row">
			<div class="col-sm-12" style="padding-bottom:29px;padding-top: 20px !important;">
				<center>
					<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">
						1st Sales Winner
					</span>
				</center>						
			</div>
		</div>
	    <div class="row">
			<?php
				if(!empty($get_aray)){
				foreach(array_slice($get_aray, 0, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['last_day_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'last_day_price' AND date_from = '".$min_date."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['last_day_price'];									
									if($mysqli->query("UPDATE employee_award_wallet SET
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['last_day_price']."',
											'last_day_price',
											'".$min_date."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}
								}
							}							
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['last_day_point_limit'];
						}					
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class="img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last day <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['last_day_price']); ?></b>
										<?php }else{ 
											if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php }} ?>
									</p>
									<?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['last_day_point_limit']; ?><br />
										Date: <?php echo $min_date; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } } else { echo '<div class="col-sm-4"></div>'; } ?>			
			<?php				
				if(!empty($get_aray1)){
				foreach(array_slice($get_aray1, 0, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['last_week_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'last_week_price' AND date_from = '".$startDate."' AND date_to = '".$endDate."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['last_week_price'];
									if($mysqli->query("UPDATE employee_award_wallet SET
										balance = '".$set_balance."',
										data = '".date('d/m/Y')."'
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['last_week_price']."',
											'last_week_price',
											'".$startDate."',
											'".$endDate."',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['last_week_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip">
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last week <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['last_week_price']); ?></b>
										<?php }else{ 
											if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php }} ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['last_week_price']; ?><br />
										Date: <?php echo $startWeek; ?> - <?php echo $endWeek; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php 
				if(!empty($get_aray12)){
				foreach(array_slice($get_aray12, 0, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['last_month_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'last_month_price' AND date_from = '".$last_month_my."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['last_month_price'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['last_month_price']."',
											'last_month_price',
											'".$last_month_my."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['last_month_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last month <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['last_month_price']); ?></b>
										<?php }else{ 
											if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php }}?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['last_month_point_limit']; ?><br />
										Date: <?php echo $month_start; ?> - <?php echo $month_end; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>
		</div>
	<?php } ?>
		
	<?php if($award['_2nd_price'] == 1){ ?>   	
		<div class="row">
			<div class="col-sm-12" style="padding-bottom:29px;">
				<center>
					<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">
						2nd Sales Winner
					</span>
				</center>						
			</div>
		</div>		
		<div class="row"> 
			<?php
				if(count($get_aray) > 1){
					$get_aray_second2 = $get_aray;
					$grose_value21 = 1;
				}else{
					$get_aray_second2 = $get_aray_second;
					$grose_value21 = 0;
				}
				if(!empty($get_aray_second2)){
				foreach(array_slice($get_aray_second2, $grose_value21, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['second_last_day_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'second_last_day' AND date_from = '".$min_date."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['second_last_day'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."',
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['second_last_day']."',
											'second_last_day',
											'".$min_date."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");										
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['second_last_day_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last day <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['second_last_day']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } }?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['second_last_day_point_limit']; ?><br />
										Date: <?php echo $min_date; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } } else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php
				if(count($get_aray1) > 1){
					$get_aray1_second2 = $get_aray1;
					$grose_value22 = 1;
				}else{
					$get_aray1_second2 = $get_aray1_second;
					$grose_value22 = 0;
				}
				if(!empty($get_aray1_second2)){
				foreach(array_slice($get_aray1_second2, $grose_value22, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['second_last_week_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'second_last_week' AND date_from = '".$startDate."' AND date_to = '".$endDate."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['second_last_week'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['second_last_week']."',
											'second_last_week',
											'".$startDate."',
											'".$endDate."',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");										
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['second_last_week_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last week <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['second_last_week']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } } ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="textalign:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['second_last_week_point_limit']; ?><br />
										Date: <?php echo $startWeek; ?> - <?php echo $endWeek; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php 
				if(count($get_aray12) > 1){
					$get_aray12_second2 = $get_aray12;
					$grose_value23 = 1;
				}else{
					$get_aray12_second2 = $get_aray12_second;
					$grose_value23 = 0;
				}
				if(!empty($get_aray12_second2)){
				foreach(array_slice($get_aray12_second2, $grose_value23, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['second_last_month_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'second_last_month' AND date_from = '".$last_month_my."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['second_last_month'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['second_last_month']."',
											'second_last_month',
											'".$last_month_my."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['second_last_month_point_limit']; 
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last month <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['second_last_month']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } } ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['second_last_month_point_limit']; ?><br />
										Date: <?php echo $month_start; ?> - <?php echo $month_end; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>
		</div>	
	<?php } ?>
	<?php if($award['_3rd_price'] == 1){ ?>  	
		<div class="row">
			<div class="col-sm-12" style="padding-bottom:29px;">
				<center>
					<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">
						3rd Sales Winner
					</span>
				</center>						
			</div>
		</div>		
		<div class="row"> 
			<?php
				if(count($get_aray) > 2){
					$get_aray_thired3 = $get_aray;
					$grose_value31 = 2;
				}else if(count($get_aray) == 2 AND count($get_aray_second) == 1){
					$get_aray_thired3 = $get_aray_second;
					$grose_value31 = 0;
				}else if(count($get_aray_second) > 1){
					$get_aray_thired3 = $get_aray_second;
					$grose_value31 = 1;
				}else{
					$get_aray_thired3 = $get_aray_thired;
					$grose_value31 = 0;
				}
				if(!empty($get_aray_thired3)){
				foreach(array_slice($get_aray_thired3, $grose_value31, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['thired_last_day_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'thired_last_day' AND date_from = '".$min_date."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['thired_last_day'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['thired_last_day']."',
											'thired_last_day',
											'".$min_date."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['thired_last_day_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last day <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['thired_last_day']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } }?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['thired_last_day_point_limit']; ?><br />
										Date: <?php echo $min_date; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } } else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php
				if(count($get_aray1) > 2){
					$get_aray1_thired3 = $get_aray1;
					$grose_value32 = 2;
				}else if(count($get_aray1_second) > 1){
					$get_aray1_thired3 = $get_aray1_second;
					$grose_value32 = 1;
				}else{
					$get_aray1_thired3 = $get_aray1_thired;
					$grose_value32 = 0;
				}
				if(!empty($get_aray1_thired3)){
				foreach(array_slice($get_aray1_thired3, $grose_value32, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['thired_last_week_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'thired_last_week' AND date_from = '".$startDate."' AND date_to = '".$endDate."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['thired_last_week'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['thired_last_week']."',
											'thired_last_week',
											'".$startDate."',
											'".$endDate."',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['thired_last_week_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last week <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['thired_last_week']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } } ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="textalign:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['thired_last_week_point_limit']; ?><br />
										Date: <?php echo $startWeek; ?> - <?php echo $endWeek; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php 
				if(count($get_aray12) > 2){
					$get_aray12_thired3 = $get_aray12;
					$grose_value33 = 2;
				}else if(count($get_aray12_second) > 1){
					$get_aray12_thired3 = $get_aray12_second;
					$grose_value33 = 1;
				}else{
					$get_aray12_thired3 = $get_aray12_thired;
					$grose_value33 = 0;
				}
				if(!empty($get_aray12_thired3)){
				foreach(array_slice($get_aray12_thired3, $grose_value33, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['thired_last_month_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'thired_last_month' AND date_from = '".$last_month_my."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['thired_last_month'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHEERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['thired_last_month']."',
											'thired_last_month',
											'".$last_month_my."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['thired_last_month_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last month <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['thired_last_month']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } } ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['thired_last_month_point_limit']; ?><br />
										Date: <?php echo $month_start; ?> - <?php echo $month_end; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>
		</div>
	<?php } ?>
		
	<?php if($award['_4th_price'] == 1){ ?> 	
		<div class="row">
			<div class="col-sm-12" style="padding-bottom:29px;">
				<center>
					<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">
						4th Sales Winner
					</span>
				</center>						
			</div>
		</div>		
		<div class="row"> 
			<?php
				if(count($get_aray) > 3){
					$get_aray_forth4 = $get_aray;
					$grose_value41 = 3;
				}else if(count($get_aray_second) > 2){
					$get_aray_forth4 = $get_aray_second;
					$grose_value41 = 2;
				}else if(count($get_aray_thired) > 1){
					$get_aray_forth4 = $get_aray_thired;
					$grose_value41 = 1;
				}else{
					$get_aray_forth4 = $get_aray_forth;
					$grose_value41 = 0;
				}
				if(!empty($get_aray_forth4)){
				foreach(array_slice($get_aray_forth4, $grose_value41, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['forth_last_day_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'forth_last_day' AND date_from = '".$min_date."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['forth_last_day'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['forth_last_day']."',
											'forth_last_day',
											'".$min_date."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['forth_last_day_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last day <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['forth_last_day']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } }?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['forth_last_day_point_limit']; ?><br />
										Date: <?php echo $min_date; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } } else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php
				if(count($get_aray1) > 3){
					$get_aray1_forth4 = $get_aray1;
					$grose_value42 = 3;
				}else if(count($get_aray1_second) > 2){
					$get_aray1_forth4 = $get_aray1_second;
					$grose_value42 = 2;
				}else if(count($get_aray1_thired) > 1){
					$get_aray1_forth4 = $get_aray1_thired;
					$grose_value42 = 1;
				}else{
					$get_aray1_forth4 = $get_aray1_forth;
					$grose_value42 = 0;
				}
				if(!empty($get_aray1_forth4)){
				foreach(array_slice($get_aray1_forth4, $grose_value42, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['forth_last_week_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'forth_last_week' AND date_from = '".$startDate."' AND date_to = '".$endDate."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['forth_last_week'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['forth_last_week']."',
											'forth_last_week',
											'".$startDate."',
											'".$endDate."',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['forth_last_week_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last week <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['forth_last_week']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } } ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="textalign:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['forth_last_week_point_limit']; ?><br />
										Date: <?php echo $startWeek; ?> - <?php echo $endWeek; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php 
				if(count($get_aray12) > 3){
					$get_aray12_forth4 = $get_aray12;
					$grose_value43 = 3;
				}else if(count($get_aray12_second) > 2){
					$get_aray12_forth4 = $get_aray12_second;
					$grose_value43 = 2;
				}else if(count($get_aray12_thired) > 1){
					$get_aray12_forth4 = $get_aray12_thired;
					$grose_value43 = 1;
				}else{
					$get_aray12_forth4 = $get_aray12_forth;
					$grose_value43 = 0;
				}
				if(!empty($get_aray12_forth4)){
				foreach(array_slice($get_aray12_forth4, $grose_value43, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['forth_last_month_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'forth_last_month' AND date_from = '".$last_month_my."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['forth_last_month'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."
									'")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['forth_last_month']."',
											'forth_last_month',
											'".$last_month_my."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['forth_last_month_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last month <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['forth_last_month']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } } ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['forth_last_month_point_limit']; ?><br />
										Date: <?php echo $month_start; ?> - <?php echo $month_end; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>
		</div>
	<?php } ?>
	<?php if($award['_5th_price'] == 1){ ?>	
		<div class="row">
			<div class="col-sm-12" style="padding-bottom:29px;">
				<center>
					<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">
						5th Sales Winner
					</span>
				</center>						
			</div>
		</div>		
		<div class="row"> 
			<?php
				if(count($get_aray) > 4){
					$get_aray_fifth5 = $get_aray;
					$grose_value51 = 4;
				}else if(count($get_aray_second) > 3){
					$get_aray_fifth5 = $get_aray_second;
					$grose_value51 = 3;
				}else if(count($get_aray_thired) > 2){
					$get_aray_fifth5 = $get_aray_thired;
					$grose_value51 = 2;
				}else if(count($get_aray_forth) > 1){
					$get_aray_fifth5 = $get_aray_forth;
					$grose_value51 = 1;
				}else{
					$get_aray_fifth5 = $get_aray_fifth;
					$grose_value51 = 0;
				}
				if(!empty($get_aray_fifth5)){
				foreach(array_slice($get_aray_fifth5, $grose_value51, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['fifth_last_day_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("SELECT * FROM award_insert_logs WHERE type = 'fifth_last_day' AND date_from = '".$min_date."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee_award_wallet WHERE employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['fifth_last_day'];
									if($mysqli->query("UPDATE employee_award_wallet SET 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."
									'")){
										$mysqli->query("INSERT INTO award_insert_logs VALUES(
											'',
											'".$emp['employee_id']."',
											'".$award['fifth_last_day']."',
											'fifth_last_day',
											'".$min_date."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['fifth_last_day_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last day <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['fifth_last_day']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } }?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['fifth_last_day_point_limit']; ?><br />
										Date: <?php echo $min_date; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } } else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php
				if(count($get_aray1) > 4){
					$get_aray1_fifth5 = $get_aray1;
					$grose_value52 = 4;
				}else if(count($get_aray1_second) > 3){
					$get_aray1_fifth5 = $get_aray1_second;
					$grose_value52 = 3;
				}else if(count($get_aray1_thired) > 2){
					$get_aray1_fifth5 = $get_aray1_thired;
					$grose_value52 = 2;
				}else if(count($get_aray1_forth) > 1){
					$get_aray1_fifth5 = $get_aray1_forth;
					$grose_value52 = 1;
				}else{
					$get_aray1_fifth5 = $get_aray1_fifth;
					$grose_value52 = 0;
				}
				if(!empty($get_aray1_fifth5)){
				foreach(array_slice($get_aray1_fifth5, $grose_value52, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['fifth_last_week_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where type = 'fifth_last_week' and date_from = '".$startDate."' and date_to = '".$endDate."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['fifth_last_week'];
									if($mysqli->query("update employee_award_wallet set 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										WHERE employee_id = '".$emp['employee_id']."
									'")){
										$mysqli->query("insert into award_insert_logs values(
											'',
											'".$emp['employee_id']."',
											'".$award['fifth_last_week']."',
											'fifth_last_week',
											'".$startDate."',
											'".$endDate."',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['fifth_last_week_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last week <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['fifth_last_week']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } } ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="textalign:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['fifth_last_week_point_limit']; ?><br />
										Date: <?php echo $startWeek; ?> - <?php echo $endWeek; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>			
			<?php 
				if(count($get_aray12) > 4){
					$get_aray12_fifth5 = $get_aray12;
					$grose_value53 = 4;
				}else if(count($get_aray12_second) > 3){
					$get_aray12_fifth5 = $get_aray12_second;
					$grose_value53 = 3;
				}else if(count($get_aray12_thired) > 2){
					$get_aray12_fifth5 = $get_aray12_thired;
					$grose_value53 = 2;
				}else if(count($get_aray12_forth) > 1){
					$get_aray12_fifth5 = $get_aray12_forth;
					$grose_value53 = 1;
				}else{
					$get_aray12_fifth5 = $get_aray12_fifth;
					$grose_value53 = 0;
				}
				if(!empty($get_aray12_fifth5)){
				foreach(array_slice($get_aray12_fifth5, $grose_value53, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['fifth_last_month_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where type = 'fifth_last_month' and date_from = '".$last_month_my."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210922' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$emp['employee_id']."'"));
									$set_balance = (float)$check_balance['balance'] + (float)$award['fifth_last_month'];
									if($mysqli->query("update employee_award_wallet set 
										balance = '".$set_balance."', 
										data = '".date('d/m/Y')."' 
										where employee_id = '".$emp['employee_id']."'
									")){
										$mysqli->query("insert into award_insert_logs values(
											'',
											'".$emp['employee_id']."',
											'".$award['fifth_last_month']."',
											'fifth_last_month',
											'".$last_month_my."',
											'',
											'".uploader_info()."',
											'".date('d/m/Y')."'
										)");
									}						
								}						
							}
							$show_award = 1;
						}else{
							$show_award = 0;
							$target = $award['fifth_last_month_point_limit'];
						}	
					}
			?>
            <div class="col-sm-4">
                <div class="image-flip" >
                    <div class="mainflip flip-0">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p><img class=" img-fluid" src="<?php echo $home.$emp['photo']; ?>" alt="card image"></p>
                                    <h4 style="text-align:center;height:28.8px;ovflow:hidden;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text">
										Last month <br />
										<?php if($show_award == 1){ ?>
										Award: <b><?php echo money($award['fifth_last_month']); ?></b>
										<?php }else{ 
										if($award['status'] == 1){
											$total_booking = (int)$result['value'];
											$target_booking = (int)$target;
											$target_result = $total_booking / ($target_booking / 100);
											$target_result_view = $total_booking / ($target_booking / 100);
											if($target_result > 100){
												$target_result = 100;
											}if(90 < $target_result){ // 80 - 100+
												$background = 'bg-success';
											} else if(80 < $target_result){ // 80 - 90
												$background = '';
											} else if(60 < $target_result){ // 60 - 80
												$background = 'bg-info';
											} else if(40 < $target_result){  // 40 - 60
												$background = 'bg-warning';
											} else if(20 < $target_result){  // 20 - 40+
												$background = 'bg-danger';
											} 
										?>
										<p style="width:100%;overflow:hidden;margin:0px;margin-top: -2px;">
											<span title="Target Booking">TP:</span> <b><?php echo (int)$target_booking; ?></b> | 
											<span title="Reached Booking">RP:</span> <b><?php echo (int)$total_booking; ?></b> | 
											<span title="Reached Percentage">RPP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
										</p>
										<div class="progress" style="margin-top:0px;">
											<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<?php } } ?>
									</p>
                                    <?php if($show_award == 1){ ?>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
									<?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="backside" style="width:100%;">
                            <div class="card">
                                <div class="card-body text-center mt-4">
                                    <h4 class="" style="text-align:center;"><?php echo $emp['full_name']; ?></h4>
                                    <p class="card-text" style="width:100%;">
										Total booked: <?php echo $result['booked']; ?><br />
										Total Point: <?php echo $result['value']; ?><br />
										Target Point: <?php echo $award['fifth_last_month_point_limit']; ?><br />
										Date: <?php echo $month_start; ?> - <?php echo $month_end; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				<?php }else{ echo '<div class="col-sm-4"></div>'; } } }else{ echo '<div class="col-sm-4"></div>'; } ?>
		</div>
	<?php } ?>



	<?php if($award['sales_looser'] == 1){ ?>	
		<!------------------------------------------------------------------->
		<div class="row">
			<div class="col-sm-12" style="padding-bottom:29px;">
				<center>
					<span style="font-size:28px;text-transform: uppercase;color:#f00;font-weight:bolder;box-shadow: 0px 0px 11px 0px rgba(255,0,0,1);padding-left:5px;padding-right:5px;border-radius:2px;background-color:rgba(255,255,255,0.4);">Sales Looser</span>
				</center>							
			</div>
		</div>		
		<div class="row">
			<div class="col-sm-4">
				<div class="col-sm-12"  style="background-color:#f00;color:#fff;border-radius: 5px;padding-top:1px;box-shadow: 0px 0px 11px 0px rgba(255,0,0,1);">
					<div class="row">
						<div class="col-sm-12">
							<p style="margin:0px;text-align: center; font-size: 24px;">Last Day</p>
						</div>						
					</div>
					<div class="row">
						<?php
							sort($get_aray_looser);
							$loser_count = 1;
							foreach(array_slice($get_aray_looser,0,4) as $row){
								//if($row['value'] < 6){
								$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$row['employee_id']."'"));
						?>
						<div class="col-sm-6" style="text-align:center;">
							<div style="padding-bottom: 2px; margin-bottom: 10px;border-radius:3px;">
								<img src="<?php echo $home.$emp['photo']; ?>" style="width:146px;height:146px;border-radius:50%;" class="image-responsive"/>
								<p style="margin:0px;line-height: 16px;">Point: <?php echo $row['value']; ?></p>
								<p style="height:20px;overflow:hidden;margin:0px;line-height: 20px;"><?php echo $emp['full_name']; ?></p>
							</div>
						</div>
						<?php 
								//}
							}
						?>
					</div>
				</div>
			</div>			
			<div class="col-sm-4">
				<div class="col-sm-12"  style="background-color:#f00;color:#fff;border-radius: 5px;padding-top:1px;box-shadow: 0px 0px 11px 0px rgba(255,0,0,1);">
					<div class="row">
						<div class="col-sm-12">
							<p style="margin:0px;text-align: center; font-size: 24px;">Last Week</p>
						</div>						
					</div>
					<div class="row">
						<?php
							sort($get_aray1_looser);
							$loser_count = 1;
							foreach(array_slice($get_aray1_looser,0,4) as $row){
								//if($row['value'] < 21){
								$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$row['employee_id']."'"));
						?>
						<div class="col-sm-6" style="text-align:center;">
							<div style="padding-bottom: 2px; margin-bottom: 10px;border-radius:3px;">
								<img src="<?php echo $home.$emp['photo']; ?>" style="width:146px;height:146px;border-radius:50%;" class="image-responsive"/>
								<p style="margin:0px;line-height: 16px;">Point: <?php echo $row['value']; ?></p>
								<p style="height:20px;overflow:hidden;margin:0px;line-height: 20px;"><?php echo $emp['full_name']; ?></p>
							</div>
						</div>
						<?php 
								//}
							}
						?>
					</div>
				</div>
			</div>			
			<div class="col-sm-4">
				<div class="col-sm-12" style="background-color:#f00;color:#fff;border-radius: 5px;padding-top:1px;box-shadow: 0px 0px 11px 0px rgba(255,0,0,1);">
					<div class="row">
						<div class="col-sm-12">
							<p style="margin:0px;text-align: center; font-size: 24px;">Last Month</p>
						</div>						
					</div>
					<div class="row">
						<?php
							sort($get_aray12_looser);
							$loser_count = 1;
							foreach(array_slice($get_aray12_looser,0,4) as $row){
								//if($row['value'] < 100){
								$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$row['employee_id']."'"));
						?>
						<div class="col-sm-6" style="text-align:center;">
							<div style="padding-bottom: 2px; margin-bottom: 10px;border-radius:3px;">
								<img src="<?php echo $home.$emp['photo']; ?>" style="width:146px;height:146px;border-radius:50%;" class="image-responsive"/>
								<p style="margin:0px;line-height: 16px;">Point: <?php echo $row['value']; ?></p>
								<p style="height:20px;overflow:hidden;margin:0px;line-height: 20px;"><?php echo $emp['full_name']; ?></p>
							</div>
						</div>
						<?php 
								//}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
    </div>
</div>
<style>
@import url('https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
.btn-primary:hover,
.btn-primary:focus {
    background-color: #108d6f;
    border-color: #108d6f;
    box-shadow: none;
    outline: none;
}
.btn-primary { color: #fff; background-color: #007b5e; border-color: #007b5e; } #team .card { border: none; background: #ffffff; } .image-flip:hover .backside, .image-flip.hover .backside { -webkit-transform: rotateY(0deg); -moz-transform: rotateY(0deg); -o-transform: rotateY(0deg); -ms-transform: rotateY(0deg); transform: rotateY(0deg); border-radius: .25rem; } .image-flip:hover .frontside, .image-flip.hover .frontside { -webkit-transform: rotateY(180deg); -moz-transform: rotateY(180deg); -o-transform: rotateY(180deg); transform: rotateY(180deg); } .mainflip { -webkit-transition: 1s; -webkit-transform-style: preserve-3d; -ms-transition: 1s; -moz-transition: 1s; -moz-transform: perspective(1000px); -moz-transform-style: preserve-3d; -ms-transform-style: preserve-3d; transition: 1s; transform-style: preserve-3d; position: relative; } .frontside { position: relative; -webkit-transform: rotateY(0deg); -ms-transform: rotateY(0deg); z-index: 2; margin-bottom: 30px; } .backside { position: absolute; top: 0; left: 0; background: white; -webkit-transform: rotateY(-180deg); -moz-transform: rotateY(-180deg); -o-transform: rotateY(-180deg); -ms-transform: rotateY(-180deg); transform: rotateY(-180deg); -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158); -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158); box-shadow: 5px 7px 9px -4px rgb(158, 158, 158); } .frontside, .backside { -webkit-backface-visibility: hidden; -moz-backface-visibility: hidden; -ms-backface-visibility: hidden; backface-visibility: hidden; -webkit-transition: 1s; -webkit-transform-style: preserve-3d; -moz-transition: 1s; -moz-transform-style: preserve-3d; -o-transition: 1s; -o-transform-style: preserve-3d; -ms-transition: 1s; -ms-transform-style: preserve-3d; transition: 1s; transform-style: preserve-3d; } .frontside .card, .backside .card { min-height: 312px; } .backside .card a { font-size: 18px; color: #007b5e !important; } .frontside .card .card-title, .backside .card .card-title { color: #007b5e !important; } .frontside .card .card-body img { width: 170px; height: 170px; border-radius: 50%; }
/*-----------------------------*/
</style>
	<?php } else { $_pr = rand() * time(); ?>
<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<div class="card" style="margin-top:150px;">
			<div class="card-body" style="height:250px;">
				<center style="margin-top:37px;">
					<span style="font-size: 28px; text-transform: uppercase;">
						Award Result Published After<br />
						<span id="p_count_time_<?php echo $_pr; ?>"></span>
					</span>
				</center>
			</div>
		</div>
	</div>
	<div class="col-sm-3"></div>
</div>
<script>
<?php
sscanf(preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", date("H:i:s", strtotime("10:00 AM"))), "%d:%d:%d", $hours, $minutes, $seconds);
$time_seconds = $hours * 3600 + $minutes * 60 + $seconds;

sscanf(preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", date("H:i:s", strtotime(date('h:i A')))), "%d:%d:%d", $hours2, $minutes2, $seconds2);
$time_seconds2 = $hours2 * 3600 + $minutes2 * 60 + $seconds2;
$actual_P_time = $time_seconds - $time_seconds2;
?>
function getTime(seconds) {
    var leftover = seconds;
    var days = Math.floor(leftover / 86400);
    leftover = leftover - (days * 86400);
    var hours = Math.floor(leftover / 3600);
    leftover = leftover - (hours * 3600);
    var minutes = Math.floor(leftover / 60);
    leftover = leftover - (minutes * 60);
    return days + ':' + hours + ':' + minutes + ':' + leftover;
}
$(document).ready( function() {    
    var time = '<?php echo $actual_P_time; ?>';  
    setInterval( function() {        
        time--;        
        $('#p_count_time_<?php echo $_pr; ?>').html('<span style="font-size: 70px; color: #f00;" id="time">'+getTime(time)+'</span>');        
        if (time === 0) {            
            windoww.open('<?php echo $home; ?>/admin','_top');
        }       
    }, 1000 );    
});
</script>
<?php } } ?>