<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['get_details'])){ 
	if(isset($_POST['date_filter'])){
		$date = new DateTime($_POST['date_filter']);
		$target_check = mysqli_fetch_assoc($mysqli->query("select * from booking_target_adding_logs where target_month = '".$date->format('m/Y')."'"));
	}else{
		$target_check = mysqli_fetch_assoc($mysqli->query("select * from booking_target_adding_logs where target_month = '".date('m/Y')."'"));
	}
	if(!empty($_POST['date_filter'])){
		$d = explode("-",$_POST['date_filter']); //Y-m-d
		$date_s_two = $d[0].'/'.$d[1].'/'.$d[2]; //Y/m/d		
		$min_date = date("d/m/Y",strtotime('-1 days',strtotime($date_s_two)));
		$date = explode("-",$_POST['date_filter']);
	}else{
		$min_date = date("d/m/Y",strtotime('-1 days',strtotime(date("Y/m/d"))));
		$date = explode("-",date('Y-m-d'));
	}
	
	$live_date = date('Ymd');
	$get_selected_date = $date[0].''.$date[1].''.$date[2];
	
	$app_s_date = $date[2].'/'.$date[1].'/'.$date[0];
	
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
	$house_keep_value = 0;
	$final_total = 0;
	while($row = mysqli_fetch_assoc($employee)){
		$branch_id = $row['branch'];
		$get_target = mysqli_fetch_assoc($mysqli->query("select * from booking_monthly_target where branch_id = '".$branch_id."' and status = '1' order by id desc"));
		if(!empty($get_target)){
			$target_number = (int)$get_target['target'];
		}
		$branch_n = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$branch_id."'"));
		$branch_name = $branch_n['branch_name'];
		$booking_info = $mysqli->query("select * from booking_info where branch_id = '".$branch_id."' and count_reword = '' and data like '%".$min_date."%'");
		$total_value = 0;
		$house_keep_value = 0;
		while($booked = mysqli_fetch_assoc($booking_info)){
			$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booked['package']."'"));
			$get_value = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package['sub_category_id']."'"));
			$total_value = $total_value + $get_value['booking_value'];
		}		
		$bed_number = mysqli_fetch_array($mysqli->query("select count(*) from beds where branch_id = '".$branch_id."'")); // status = '1' and uses not in ('5','6') and
		$bed_number_w_o_e = mysqli_fetch_array($mysqli->query("select count(*) from beds where branch_id = '".$branch_id."'")); // status = '1' and uses not in ('5','6') and
		$occupide_number = mysqli_fetch_array($mysqli->query("select count(*) from beds where uses in ('3','4') and branch_id = '".$branch_id."'"));
		$bed_math = (float)$bed_number[0];
		if(!empty($bed_math)){
			$occupice_math = (float)$occupide_number[0];
			$occupide_percentage = round(($occupice_math * 100) / $bed_math, 2);
		}else{
			$occupice_math = 0;
			$occupide_percentage = 0;
		}
		$f_f_value = mysqli_fetch_assoc($mysqli->query("select AVG(feedback_value) as food_value from member_food_feedback where branch_id = '".$branch_id."' and data = '".$min_date."'"));
		$service_value = mysqli_fetch_assoc($mysqli->query("select AVG(rating_value) as service_value from whole_service_rating where branch_id = '".$branch_id."' and data = '".$min_date."'"));
		$gt_house_k = $mysqli->query("select * from employee where role = '407277242147262618' and branch = '".$branch_id."'");
		while($hkeep = mysqli_fetch_assoc($gt_house_k)){
			$rating_value = mysqli_fetch_assoc($mysqli->query("select AVG(value) as total_rating , count(*) as total_keeps from employee_rating where receiver_id = '".$hkeep['id']."' and data = '".$min_date."'"));
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
			$total_booking = (int)$occupice_math;
			$target_booking = (int)$target_number;
			$target_result = $total_booking / ($target_booking / 100);
			//if($target_result > 100){
			//	$target_result = 100;
			//}
		}else{
			$target_result = 0;
		}
		$final_total = 0 + round((float)$target_result,2) + (float)$f_f_value + (float)$service_value + (float)$house_keep_value;
		//1. (float)$total_value
		//2. (float)$occupide_percentage
		
		
		
		$incharge_loop[] = array(
			'total_value' => $final_total,
			'booking_value' => '0', //$total_value
			'branch_occupency_rate' => $occupide_percentage, //$total_value
			'occupide_value' => round($target_result,2),
			'food_value' => (float)$f_f_value,
			'service_value' => (float)$service_value,
			'keeper_value' => (float)$house_keep_value,
			'employee_id' => $row['employee_id'],
			'branch_name' => $branch_name,
			'occupide_number' => $occupice_math,
			'target_number' => $target_number,
			'number_of_bed' => $bed_number_w_o_e[0]
		);
		$check_daily = mysqli_fetch_assoc($mysqli->query("select * from daily_ocupide_number where branch_id = '".$branch_id."' and data = '".$app_s_date."'"));
		if(empty($check_daily['id'])){
			$mysqli->query("insert into daily_ocupide_number values(
				'',
				'".$branch_id."',
				'".$occupice_math."',
				'".uploader_info()."',
				'".$app_s_date."'
			)");
		}		
	}	
	$check_award_data = mysqli_fetch_assoc($mysqli->query("select * from incharge_award_data where type = 'days' and days = '".$date[2]."' and months = '".$date[1]."' and years = '".$date[0]."'"));
	if(!empty($check_award_data['id'])){
		$incharge_loop = json_decode($check_award_data['list_data'], true);
		rsort($incharge_loop);
		$count = count($incharge_loop);
	}else{		
		if($mysqli->query("insert into incharge_award_data values(
			'',
			'".$mysqli->real_escape_string(json_encode($incharge_loop))."',
			'days',
			'".date('d/m/Y')."',
			'".$date[2]."',
			'".$date[1]."',
			'".$date[0]."',
			'".uploader_info()."'
		)")){			
			$get_data = mysqli_fetch_assoc($mysqli->query("select * from incharge_award_data where type = 'days' and days = '".$date[2]."' and months = '".$date[1]."' and years = '".$date[0]."'"));
			$incharge_loop = json_decode($get_data['list_data'], true);
			rsort($incharge_loop);
			$count = count($incharge_loop);
		}else{
			rsort($incharge_loop);
			$count = count($incharge_loop);
		}
	}
if(!empty($target_check['id'])){
?>
<div>
	<div class="row">
		<div class="col-sm-12" style="padding-bottom:29px;padding-top: 20px !important;">
			<center>
				<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">Last Day Best Branch </span>
				
			</center>							
		</div>
		<div class="col-sm-12" style=""><!--min-height:900px;max-height:900px;overflow-y:scroll;--->
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
						<div class="team-front" id="box" style="float:left;<?php echo $style_variable; ?>">
							<span class="numbering"><?php echo $number_count; ?></span>
							<div style="width:50%;float:left;">
								<img src="<?php echo $home.$emp['photo']; ?>" style="width: 150px; height: 150px;" class="img-fluid" />							
							</div>	
							<div style="width:50%;float:left;padding-top: 20px;">
								<h3 style="width:100%;overflow:hidden;"><?php echo $emp['full_name']; ?></h3>
								<p style="width:100%;overflow:hidden;"><?php echo $row['branch_name']; ?></p>
								<p style="width:100%;overflow:hidden;"><?php echo $emp['designation_name']; ?></p>
								<?php if(!empty($row['target_number'])){ 
									$total_booking = (int)$row['occupide_number'];
									$target_booking = (int)$row['target_number'];
									$target_result = $total_booking / ($target_booking / 100);
									$target_result_view = $total_booking / ($target_booking / 100);
									if($target_result > 100){
										$target_result = 100;
									}
								?>
								<p style="width:100%;overflow:hidden;">
									<span title="Target Booking">OT:</span> <b><?php echo (int)$row['target_number']; ?></b> | 
									<span title="Reached Booking">RO:</span> <b><?php echo (int)$row['occupide_number']; ?></b> | 
									<span title="Reached Percentage">ROP:</span> <b><?php echo round($target_result_view,2); ?>%</b>
								</p>
								<?php									
									if(90 < $target_result){ // 80 - 100+
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
								<div class="progress" style="margin-top:15px;">
									<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<?php } ?>
							</div>
						</div>
						
						
						<div class="team-back" id="box11">
							<span class="numbering22" style="bottom:127px;">
								<span style=" font-size: 11px;">Branch Occupency Rate</span><br />
								<span style="font-size: 24px; float: right;  line-height: 42px; "><?php echo $row['branch_occupency_rate']; ?><small>%</small></span>
							</span>
							<span style="padding:20px;">
								<?php /* ?><p>Booking Point: <b><?php echo $row['booking_value'];?></b></p><?php */ ?>
								<p>Reached Occupancy Rate: <b><?php echo $row['occupide_value'];?> %</b></p>
								<p>Food Feedback: <b><?php echo $row['food_value'];?></b> Out of <b>5</b></p>
								<p>House Keeper Rating: <b><?php echo $row['keeper_value'];?></b> Out of <b>5</b></p>
								<p>Member Service Rating: <b><?php echo $row['service_value'];?></b> Out of <b>5</b></p>
								<p>Total Point: <b><?php echo $row['total_value'];?></b></p>
								<p style="color:green;"><b> Total Number of Bed: <?php echo $row['number_of_bed'];?> </b></p>
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
.numbering{
	position: absolute;
    left: 20px;
    top: 129px;
    z-index: 99;
    color: #fff;
    font-size: 50px;
    font-weight: bolder;
}
.numbering22{
	position: absolute;
    right: 10px;
    bottom: 100px;
    color: #fff;
    font-weight: bolder;
	z-index:1;
}
#box {
    position: relative;
}

#box::before,
#box::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    border-color: transparent;
    border-style: solid;
}

#box::before {
    border-width: 2.5em;
    border-left-color: #ccc;
    border-bottom-color: #ccc;
}

#box::after {
    border-radius: 0.4em;
    border-width: 3.35em;
    border-left-color: #0c0;
    border-bottom-color: #0c0;
}




#box11::before,
#box11::after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    border-color: transparent;
    border-style: solid;
}


#box11::after {
    border-radius: 0.4em;
    border-width: 5.35em;
    border-right-color: #ffc107;
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
<?php } else { ?>
<center>
	<h4 style="color: #ffffff; text-shadow: 0px 0 5px white; box-shadow: 0px 0 12px 9px #ff0000;">
		This Month Target Not Set Yet!
		<?php if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
		<br /> 		
		<a href="javascript:void(0);" onclick="window.open('<?php echo $home.'admin/booking/booking-target-setup'; ?>','_self')">Goto configuration page!</a>
		<?php } ?>
	</h4>
</center>
<?php } ?>
<?php }?>
<?php } ?>