<?php
if(date('Ymd') > 20210730 ){
// error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['get_details'])){ 
	if(!empty($_POST['date_filter'])){
		$d = explode("-",$_POST['date_filter']); //Y-m-d
		$date_s_three = $d[0].'-'.$d[1].'-'.$d[2]; //Y-m-d		
		$d = new DateTime($date_s_three, new DateTimeZone('UTC')); 
		$d->modify('first day of previous month'); 
		$last_month_my = $d->format('m/Y');	
		$date = explode("-",$_POST['date_filter']);
		$md = explode('/',$last_month_my);
		$month_t = $md[0];
		$year_t = $md[1];
	}else{		
		$d = new DateTime(date('Y-m-d'), new DateTimeZone('UTC')); 
		$d->modify('first day of previous month'); 
		$last_month_my = $d->format('m/Y');
		$date = explode("-",date('Y-m-d'));
		$md = explode('/',$last_month_my);
		$month_t = $md[0];
		$year_t = $md[1];
	}
	$number_of_days = cal_days_in_month(CAL_GREGORIAN,$month_t,$year_t);
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
	
	
	$employee = $mysqli->query("select * from employee where role = '1892907820998244323' and status = '1'");
	$total_value = 0;
	$total_booking = 0;
	$house_keep_value = 0;
	$final_total = 0;
	while($row = mysqli_fetch_assoc($employee)){
		$branch_id = $row['branch'];		
		$branch_n = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$branch_id."'"));
		$branch_name = $branch_n['branch_name'];
		$get_target = mysqli_fetch_assoc($mysqli->query("select * from booking_monthly_target where branch_id = '".$branch_id."' and status = '1' and month like '%".$month_t."%' and year like '%".$year_t."%'"));
		if(!empty($get_target['target'])){
			$target_number = (int)$get_target['target'];
		}else{
			$get_target = mysqli_fetch_assoc($mysqli->query("select * from booking_monthly_target where branch_id = '".$branch_id."' and status = '1' order by id desc"));
			$target_number = (int)$get_target['target'];
		}
		
		$booking_info = $mysqli->query("select * from booking_info where branch_id = '".$branch_id."' and count_reword = '' and data like '%".$last_month_my."'");
		$oppupency_avg = mysqli_fetch_assoc($mysqli->query("select AVG(occupency_number) as occupency_value from daily_ocupide_number where branch_id = '".$branch_id."' and data like '%".$last_month_my."'"));
		$oppupency_avg_number = $oppupency_avg['occupency_value'];
		$total_value = 0;
		$total_booking = 0;
		$house_keep_value = 0;
		while($booked = mysqli_fetch_assoc($booking_info)){
			$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booked['package']."'"));
			$get_value = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package['sub_category_id']."'"));
			$total_value = $total_value + $get_value['booking_value'];
			$total_booking = $total_booking + 1;
		}
		$bed_number = mysqli_fetch_array($mysqli->query("select  count(*) from beds where branch_id = '".$branch_id."'")); // status = '1' and uses not in ('5','6') and
		$bed_number_w_o_e = mysqli_fetch_array($mysqli->query("select count(*) from beds where branch_id = '".$branch_id."'")); // status = '1' and uses not in ('5','6') and
		$occupide_number = mysqli_fetch_array($mysqli->query("select count(*) from beds where uses in ('3','4') and branch_id = '".$branch_id."'"));
		$bed_math = (float)$bed_number[0];
		$occupice_math = (float)$occupide_number[0];
		
		$occupide_percentage = round(($occupice_math * 100) / $bed_math, 2);
		
		$f_f_value = mysqli_fetch_assoc($mysqli->query("select AVG(feedback_value) as food_value from member_food_feedback where branch_id = '".$branch_id."' and data like '%".$last_month_my."'"));
		$service_value = mysqli_fetch_assoc($mysqli->query("select AVG(rating_value) as service_value from whole_service_rating where branch_id = '".$branch_id."' and data like '%".$last_month_my."'"));
		$gt_house_k = $mysqli->query("select * from employee where role = '407277242147262618' and branch = '".$branch_id."'");
		while($hkeep = mysqli_fetch_assoc($gt_house_k)){
			$rating_value = mysqli_fetch_assoc($mysqli->query("select AVG(value) as total_rating , count(*) as total_keeps from employee_rating where receiver_id = '".$hkeep['id']."' and data like '%".$last_month_my."'"));
			if((float)$rating_value['total_keeps'] == 0){
				$house_keep_value = 0;
			}else{
				$house_keep_value = $house_keep_value + ((float)$rating_value['total_rating'] / (float)$rating_value['total_keeps']);
			}
		}
		if($f_f_value['food_value'] > 0){
			$f_f_value = round($f_f_value['food_value'],3);
		}else{
			$f_f_value = 0;
		}
		if($service_value['service_value'] > 0){
			$service_value = round($service_value['service_value'],3);
		}else{
			$service_value = 0;
		}
		if($house_keep_value > 0){
			$house_keep_value = round($house_keep_value,3);
		}else{
			$house_keep_value = 0;
		}
		
		if(!empty($target_number)){
			$total_booking = (float)$oppupency_avg_number;
			$target_booking = (float)$target_number;
			$target_result = $total_booking / ($target_booking / 100);
			if($target_result > 100){
				$target_result = 100;
			}
		}else{
			$target_result = 0;
		}
		$avarage_occupency_value = (float)$oppupency_avg_number;
		$final_total = 0 + round((float)$target_result,2) + (float)$f_f_value + (float)$service_value + (float)$house_keep_value;		
		//1. (float)$total_value
		//2. (float)$occupide_percentage
		
		$incharge_loop[] = array(
			'avarage_occupency_value' => $final_total,
			'total_value' => $final_total,
			'booking_value' => 0, //$total_value
			'branch_occupency_rate' => $occupide_percentage, //$total_value
			'occupide_value' => round($target_result,2), //$occupide_percentage,
			'food_value' => $f_f_value,
			'service_value' => $service_value,
			'keeper_value' => $house_keep_value,
			'employee_id' => $row['employee_id'],
			'branch_name' => $branch_name,
			'total_booking' => $total_booking,
			'reached_occupency' => $oppupency_avg_number,
			'target_occupency' => $target_number,
			'number_of_bed' => $bed_number_w_o_e[0]
		);		
	}
	
	
	
	$check_award_data = mysqli_fetch_assoc($mysqli->query("select * from incharge_award_data where type = 'month' and months = '".$date[1]."' and years = '".$date[0]."'")); //and days = '".$date[2]."'
	if(!empty($check_award_data['id'])){
		$incharge_loop = json_decode($check_award_data['list_data'], true);
		rsort($incharge_loop);
		$count = count($incharge_loop);
	}else{
		if($mysqli->query("insert into incharge_award_data values(
			'',
			'".$mysqli->real_escape_string(json_encode($incharge_loop))."',
			'month',
			'".date('d/m/Y')."',
			'".$date[2]."',
			'".$date[1]."',
			'".$date[0]."',
			'".uploader_info()."'
		)")){
			$get_data = mysqli_fetch_assoc($mysqli->query("select * from incharge_award_data where type = 'month' and days = '".$date[2]."' and months = '".$date[1]."' and years = '".$date[0]."'"));
			$incharge_loop = json_decode($get_data['list_data'], true);
			rsort($incharge_loop);
			$count = count($incharge_loop);
		}else{
			rsort($incharge_loop);
			$count = count($incharge_loop);
		}
	}
?>
<div>
	<div class="row">
		<div class="col-sm-12" style="padding-bottom:29px;padding-top: 20px !important;">
			<center>
				<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">Last Month Best Branch</span>
			</center>							
		</div>
		<div class="col-sm-12" style=""><!--min-height:900px;max-height:900px;overflow-y:scroll;-->
			<div class="row">
			<?php
				$in = 1;
				foreach($incharge_loop as $row){
					$number_count = $in++;
					$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$row['employee_id']."'"));
			?>				
				<div class="col-sm-12">
					<div class="our-team-main">	
						<?php
						if($number_count == $count){
							$style_variable = "background:#f00;color:#fff;";
						}else{
							$style_variable = "";
						}
						?>
						
						
						<div class="team-front" id="box1" style="float:left;<?php echo $style_variable; ?>">
							<span class="numbering1"><?php echo $number_count; ?></span>
							<div style="width:50%;float:left;padding-top: 20px;">
								<h3 style="width:100%;overflow:hidden;"><?php echo $emp['full_name']; ?></h3>
								<p style="width:100%;overflow:hidden;"><?php echo $row['branch_name']; ?></p>
								<p style="width:100%;overflow:hidden;"><?php echo $emp['designation_name']; ?></p>								
								<?php if(!empty($row['target_occupency']) AND !empty($row['reached_occupency'])){ 
									$total_booking = (int)$row['reached_occupency'];
									$target_booking = (int)$row['target_occupency'];
									$target_result = $total_booking / ($target_booking / 100);
									if($target_result > 100){
										$target_result = 100;
									}
								?>
								<p style="width:100%;overflow:hidden;">
									<span title="Target Booking">TO:</span> <b><?php echo (int)$target_booking; ?></b> | 
									<span title="Reached Booking">RO:</span> <b><?php echo (int)$total_booking; ?></b> | 
									<span title="Reached Percentage">ROP:</span> <b><?php echo round($target_result,2); ?>%</b>
								</p>
								<?php									
									if(80 < $target_result AND $target_result < 90 ){ // 80 - 90
										$background = '';
									} else if(60 < $target_result AND $target_result < 80 ){ // 60 - 80
										$background = 'bg-info';
									} else if(40 < $target_result AND $target_result < 60){  // 40 - 60
										$background = 'bg-warning';
									} else if(20 < $target_result AND $target_result < 40){  // 20 - 40+
										$background = 'bg-danger';
									} else { // 80 - 100+
										$background = 'bg-success';
									}
								?>
								<?php //echo $target_result; ?>
								<div class="progress" style="margin-top:15px;">
									<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<?php } ?>
							</div>
							<div style="width:50%;float:left;">
								<img src="<?php echo $home.$emp['photo']; ?>" style="width: 150px; height: 150px;" class="img-fluid" />							
							</div>
						</div>
						
						<div class="team-back" id="box12">
							<span class="numbering23" style="bottom: 127px;">
								<span style=" font-size: 11px; ">Branch Occupency Rate</span><br />
								<span style="font-size: 24px; float: left;  line-height: 46px; "><?php echo $row['branch_occupency_rate']; ?><small>%</small></span>
							</span>
							<span style="padding:20px;">
								<?php /* ?><p>Booking Point: <b><?php echo $row['booking_value'];?></b></p><?php */ ?>
								<p style="text-align:right;">Reached Occupancy Rate: <b><?php echo $row['occupide_value'];?> %</b></p>
								<p style="text-align:right;">Food Feedback: <b><?php echo $row['food_value'];?></b> Out of <b>5</b></p>
								<p style="text-align:right;">House Keeper Rating: <b><?php echo $row['keeper_value'];?></b> Out of <b>5</b></p>
								<p style="text-align:right;">Member Service Rating: <b><?php echo $row['service_value'];?></b> Out of <b>5</b></p>
								<p style="text-align:right;">Total Point: <b><?php echo $row['total_value'];?></b></p>
								<p style="color:green;text-align:right;"><b> Total Number of Bed: <?php echo $row['number_of_bed'];?></b></p>
							</span>
						</div>
		
					</div>
				</div>
			<?php } ?>		
			</div>		
		</div>
	</div>
</div>



<style>
.numbering1{
	position: absolute;
    right: 20px;
    top: 129px;
    z-index: 99;
    color: #fff;
    font-size: 50px;
    font-weight: bolder;
}

.numbering23{
	position: absolute;
    left: 10px;
    bottom: 100px;
    color: #fff;
    font-weight: bolder;
	z-index:1;
}

#box1 {
    position: relative;
}

#box1::before,
#box1::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    border-color: transparent;
    border-style: solid;
}

#box1::before {
    border-width: 2.5em;
    border-right-color: #ccc;
    border-bottom-color: #ccc;
}

#box1::after {
    border-radius: 0.4em;
    border-width: 3.35em;
    border-right-color: #0c0;
    border-bottom-color: #0c0;
}



#box12::before,
#box12::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    border-color: transparent;
    border-style: solid;
}


#box12::after {
    border-radius: 0.4em;
    border-width: 5.35em;
    border-left-color: #ffc107;
    border-top-color: #ffc107;
}





.our-team-main
{
	width:100%;
	height:auto;
	border-bottom:5px #323233 solid;
	background:#fff;
	text-align:center;
	border-radius:10px;
	overflow:hidden;
	position:relative;
	transition:0.5s;
	margin-bottom:28px;
}


.our-team-main img
{
	border-radius:50%;
	margin-bottom:20px;
	width: 90px;
}

.our-team-main h3
{
	font-size:20px;
	font-weight:700;
}

.our-team-main p
{
	margin-bottom:0;
}

.team-back
{
	width:100%;
	height:auto;
	position:absolute;
	top:0;
	left:0;
	padding:5px 15px 0 15px;
	text-align:left;
	background:#fff;
	
}

.team-front
{
	width:100%;
	height:auto;
	position:relative;
	z-index:10;
	background:#fff;
	padding:15px;
	bottom:0px;
	transition: all 0.5s ease;
}

.our-team-main:hover .team-front
{
	bottom:-200px;
	transition: all 0.5s ease;
}

.our-team-main:hover
{
	border-color:#777;
	transition:0.5s;
}

/*our-team-main*/


</style>
<?php } } }else{ ?>
	<center>
		<h4>Published Next Month!</h4>
	</center>
<?php } ?>