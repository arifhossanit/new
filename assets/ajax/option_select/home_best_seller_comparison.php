<?php
error_reporting(0);
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

	$emp = $mysqli->query("select * from employee where role in ('1179783255713532148') and status = 1 order by id asc");
	while($row = mysqli_fetch_assoc($emp)){
		$role = mysqli_fetch_assoc($mysqli->query("select * from roles where role_id = '".$row['role']."'"));
		$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch']."'"));
		$uploader_info = $role['role_name'].'___'.$row['email'];
		
		$total_value = 0;
		$total_booked = 0;
		$bkql = $mysqli->query("select * from booking_info where uploader_info like '".$uploader_info."%' and count_reword = '' and card_no != 'Unauthorized' and checkin_date = '".$min_date."'");
		while($booking = mysqli_fetch_assoc($bkql)){
			$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking['package']."'"));
			$get_value = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package['sub_category_id']."'"));
			$total_value = $total_value + $get_value['booking_value'];
			$total_booked = $total_booked + 1;
		}
		$get_aray[] = array(
			'value' => $total_value,
			'booked' => $total_booked,
			'employee_id' => $row['employee_id']
		);
		
		$total_value1 = 0;
		$total_booked1 = 0;
		$bkql1 = $mysqli->query("select * from booking_info where uploader_info like '".$uploader_info."%' and count_reword = '' and card_no != 'Unauthorized' and STR_TO_DATE(checkin_date,'%d/%m/%Y') BETWEEN '$startDate' AND '$endDate'");
		while($booking1 = mysqli_fetch_assoc($bkql1)){
			$package1 = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking1['package']."'"));
			$get_value1 = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package1['sub_category_id']."'"));
			$total_value1 = $total_value1 + $get_value1['booking_value'];
			$total_booked1 = $total_booked1 + 1;
		}
		$get_aray1[] = array(
			'value' => $total_value1,
			'booked' => $total_booked1,
			'employee_id' => $row['employee_id']
		);
		
		$total_value12 = 0;
		$total_booked12 = 0;
		
		$bkql12 = $mysqli->query("select * from booking_info where uploader_info like '".$uploader_info."%' and count_reword = '' and card_no != 'Unauthorized' and checkin_date like '%".$last_month_my."'");
		while($booking12 = mysqli_fetch_assoc($bkql12)){
			$package12 = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booking12['package']."'"));
			$get_value12 = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package12['sub_category_id']."'"));
			$total_value12 = $total_value12 + $get_value12['booking_value'];
			$total_booked12 = $total_booked12 + 1;
		}		
		$get_aray12[] = array(
			'value' => $total_value12,
			'booked' => $total_booked12,
			'employee_id' => $row['employee_id']
		);
	}
	
	$sD = explode("/",$startDate);
	$startWeek = $sD[2].'/'.$sD[1].'/'.$sD[0];
	$eD = explode("/",$endDate);
	$endWeek = $eD[2].'/'.$eD[1].'/'.$eD[0];
	
	$award = mysqli_fetch_assoc($mysqli->query("select * from sales_award_price where id = '1'"));
	
	//$get_aray = unique_array($get_aray , "value");
	//$get_aray1 = unique_array($get_aray1 , "value");
	//$get_aray12 = unique_array($get_aray12 , "value");
	
	
	$check_award_data = mysqli_fetch_assoc($mysqli->query("select * from home_award_data_compare where days = '".$date[2]."' and months = '".$date[1]."' and years = '".$date[0]."'"));
	if(!empty($check_award_data['id'])){
		$get_aray = json_decode($check_award_data['day_data'], true);
		$get_aray1 = json_decode($check_award_data['week_data'], true);
		$get_aray12 = json_decode($check_award_data['month_data'], true);
		rsort($get_aray);
		rsort($get_aray1);
		rsort($get_aray12);
	}else{		
		if($mysqli->query("insert into home_award_data_compare values(
			'',
			'".$mysqli->real_escape_string(json_encode($get_aray))."',
			'".$mysqli->real_escape_string(json_encode($get_aray1))."',
			'".$mysqli->real_escape_string(json_encode($get_aray12))."',
			'".date('d/m/Y')."',
			'".$date[2]."',
			'".$date[1]."',
			'".$date[0]."',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."'
		)")){			
			$get_data = mysqli_fetch_assoc($mysqli->query("select * from home_award_data_compare where days = '".$date[2]."' and months = '".$date[1]."' and years = '".$date[0]."'"));
			$get_aray = json_decode($get_data['day_data'], true);
			$get_aray1 = json_decode($get_data['week_data'], true);
			$get_aray12 = json_decode($get_data['month_data'], true);
			rsort($get_aray);
			rsort($get_aray1);
			rsort($get_aray12);
		}else{
			rsort($get_aray);
			rsort($get_aray1);
			rsort($get_aray12);
		}
	}
?>
<div class="row">
	<div class="col-sm-12" style="padding-bottom:29px;padding-top: 20px !important;">
		<center>
			<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">
				Best Sales Winner
			</span>
		</center>						
	</div>
	<div class="col-sm-12" style=""><!--min-height:900px;max-height:900px;overflow-y:scroll;-->	
        <div class="row">
			<?php 
				foreach(array_slice($get_aray, 0, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['last_day_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where type = 'last_day_price' and date_from = '".$min_date."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210615' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$emp['employee_id']."'"));
									$set_balance = $check_balance['balance'] + $award['last_day_price'];
									if($mysqli->query("insert into award_insert_logs values(
										'',
										'".$emp['employee_id']."',
										'".$award['last_day_price']."',
										'last_day_price',
										'".$min_date."',
										'',
										'".uploader_info()."',
										'".date('d/m/Y')."'
									)")){
										//$mysqli->query("update employee_award_wallet set balance = '".$set_balance."' where employee_id = '".$emp['employee_id']."'");
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
										<!--Award: <b><?php echo money($award['last_day_price']); ?></b>-->
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
										Date: <?php echo $min_date; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php }else{ echo '<div class="col-sm-4"></div>'; } } ?>			
			<?php 
				foreach(array_slice($get_aray1, 0, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['last_week_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where type = 'last_week_price' and date_from = '".$startDate."' and date_to = '".$endDate."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210615' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$emp['employee_id']."'"));
									$set_balance = $check_balance['balance'] + $award['last_week_price'];
									if($mysqli->query("insert into award_insert_logs values(
										'',
										'".$emp['employee_id']."',
										'".$award['last_week_price']."',
										'last_week_price',
										'".$startDate."',
										'".$endDate."',
										'".uploader_info()."',
										'".date('d/m/Y')."'
									)")){
										//$mysqli->query("update employee_award_wallet set balance = '".$set_balance."' where employee_id = '".$emp['employee_id']."'");
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
										<!--Award: <b><?php echo money($award['last_week_price']); ?></b>-->
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
										Date: <?php echo $startWeek; ?> - <?php echo $endWeek; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php }else{ echo '<div class="col-sm-4"></div>'; } } ?>			
			<?php 
				foreach(array_slice($get_aray12, 0, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['last_month_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where type = 'last_month_price' and date_from = '".$last_month_my."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210615' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$emp['employee_id']."'"));
									$set_balance = $check_balance['balance'] + $award['last_month_price'];
									if($mysqli->query("insert into award_insert_logs values(
										'',
										'".$emp['employee_id']."',
										'".$award['last_month_price']."',
										'last_month_price',
										'".$last_month_my."',
										'',
										'".uploader_info()."',
										'".date('d/m/Y')."'
									)")){
										//$mysqli->query("update employee_award_wallet set balance = '".$set_balance."' where employee_id = '".$emp['employee_id']."'");
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
										<!--Award: <b><?php echo money($award['last_month_price']); ?></b>-->
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
										Date: <?php echo $month_start; ?> - <?php echo $month_end; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php }else{ echo '<div class="col-sm-4"></div>'; } } ?>
		</div>		
		<div class="row">
			<div class="col-sm-12" style="padding-bottom:29px;">
				<center>
					<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">Second Best Sales Winner</span>
				</center>						
			</div>
		</div>		
		<div class="row"> 
			<?php 
				foreach(array_slice($get_aray, 1, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['second_last_day_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where type = 'second_last_day' and date_from = '".$min_date."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210615' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$emp['employee_id']."'"));
									$set_balance = $check_balance['balance'] + $award['second_last_day'];
									if($mysqli->query("insert into award_insert_logs values(
										'',
										'".$emp['employee_id']."',
										'".$award['second_last_day']."',
										'second_last_day',
										'".$min_date."',
										'',
										'".uploader_info()."',
										'".date('d/m/Y')."'
									)")){
										//$mysqli->query("update employee_award_wallet set balance = '".$set_balance."' where employee_id = '".$emp['employee_id']."'");
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
										<!--Award: <b><?php echo money($award['second_last_day']); ?></b>-->
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
										Date: <?php echo $min_date; ?>
									</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php }else{ echo '<div class="col-sm-4"></div>'; } } ?>			
			<?php 
				foreach(array_slice($get_aray1, 1, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['second_last_week_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where type = 'second_last_week' and date_from = '".$startDate."' and date_to = '".$endDate."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210615' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$emp['employee_id']."'"));
									$set_balance = $check_balance['balance'] + $award['second_last_week'];
									if($mysqli->query("insert into award_insert_logs values(
										'',
										'".$emp['employee_id']."',
										'".$award['second_last_week']."',
										'second_last_week',
										'".$startDate."',
										'".$endDate."',
										'".uploader_info()."',
										'".date('d/m/Y')."'
									)")){
										//$mysqli->query("update employee_award_wallet set balance = '".$set_balance."' where employee_id = '".$emp['employee_id']."'");
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
										<!--Award: <b><?php echo money($award['second_last_week']); ?></b>-->
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
										Date: <?php echo $startWeek; ?> - <?php echo $endWeek; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php }else{ echo '<div class="col-sm-4"></div>'; } } ?>			
			<?php 
				foreach(array_slice($get_aray12, 1, 1) as $result){
					if($result['booked'] > 0){
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$result['employee_id']."'"));
					if($award['status'] == 1){
						if($result['value'] >= $award['second_last_month_point_limit']){
							$acheck_award_insert_logs = mysqli_fetch_assoc($mysqli->query("select * from award_insert_logs where type = 'second_last_month' and date_from = '".$last_month_my."'"));
							if(!empty($acheck_award_insert_logs['id'])){ }else{
								if($get_selected_date > '20210615' ){
									$check_balance = mysqli_fetch_assoc($mysqli->query("select * from employee_award_wallet where employee_id = '".$emp['employee_id']."'"));
									$set_balance = $check_balance['balance'] + $award['second_last_month'];
									if($mysqli->query("insert into award_insert_logs values(
										'',
										'".$emp['employee_id']."',
										'".$award['second_last_month']."',
										'second_last_month',
										'".$last_month_my."',
										'',
										'".uploader_info()."',
										'".date('d/m/Y')."'
									)")){
										//$mysqli->query("update employee_award_wallet set balance = '".$set_balance."' where employee_id = '".$emp['employee_id']."'");
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
										<!--Award: <b><?php echo money($award['second_last_month']); ?></b>-->
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
										Date: <?php echo $month_start; ?> - <?php echo $month_end; ?>
									</p>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php }else{ echo '<div class="col-sm-4"></div>'; } } ?>
		</div>		
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
							sort($get_aray);
							$loser_count = 1;
							foreach(array_slice($get_aray,0,4) as $row){
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
							sort($get_aray1);
							$loser_count = 1;
							foreach(array_slice($get_aray1,0,4) as $row){
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
							sort($get_aray12);
							$loser_count = 1;
							foreach(array_slice($get_aray12,0,4) as $row){
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
.btn-primary {
    color: #fff;
    background-color: #007b5e;
    border-color: #007b5e;
}
#team .card {
    border: none;
    background: #ffffff;
}
.image-flip:hover .backside,
.image-flip.hover .backside {
    -webkit-transform: rotateY(0deg);
    -moz-transform: rotateY(0deg);
    -o-transform: rotateY(0deg);
    -ms-transform: rotateY(0deg);
    transform: rotateY(0deg);
    border-radius: .25rem;
}

.image-flip:hover .frontside,
.image-flip.hover .frontside {
    -webkit-transform: rotateY(180deg);
    -moz-transform: rotateY(180deg);
    -o-transform: rotateY(180deg);
    transform: rotateY(180deg);
}
.mainflip {
    -webkit-transition: 1s;
    -webkit-transform-style: preserve-3d;
    -ms-transition: 1s;
    -moz-transition: 1s;
    -moz-transform: perspective(1000px);
    -moz-transform-style: preserve-3d;
    -ms-transform-style: preserve-3d;
    transition: 1s;
    transform-style: preserve-3d;
    position: relative;
}
.frontside {
    position: relative;
    -webkit-transform: rotateY(0deg);
    -ms-transform: rotateY(0deg);
    z-index: 2;
    margin-bottom: 30px;
}
.backside {
    position: absolute;
    top: 0;
    left: 0;
    background: white;
    -webkit-transform: rotateY(-180deg);
    -moz-transform: rotateY(-180deg);
    -o-transform: rotateY(-180deg);
    -ms-transform: rotateY(-180deg);
    transform: rotateY(-180deg);
    -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
    -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
    box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
}
.frontside,
.backside {
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -ms-backface-visibility: hidden;
    backface-visibility: hidden;
    -webkit-transition: 1s;
    -webkit-transform-style: preserve-3d;
    -moz-transition: 1s;
    -moz-transform-style: preserve-3d;
    -o-transition: 1s;
    -o-transform-style: preserve-3d;
    -ms-transition: 1s;
    -ms-transform-style: preserve-3d;
    transition: 1s;
    transform-style: preserve-3d;
}
.frontside .card,
.backside .card {
    min-height: 312px;
}
.backside .card a {
    font-size: 18px;
    color: #007b5e !important;
}
.frontside .card .card-title,
.backside .card .card-title {
    color: #007b5e !important;
}
.frontside .card .card-body img {
    width: 170px;
    height: 170px;
    border-radius: 50%;
}
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