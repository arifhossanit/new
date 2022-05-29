<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['card_number'])){
	$branch_id = $_POST['branch_id'];
	$r_date = date('d');
	$r_month = date('m');
	$r_year = date('Y');
	$r_minute = date('i');
	$r_hour = date('h');
	$r_apm = date('a');
	$hm = $r_hour.$r_minute;
	$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$_POST['card_number']."' AND status = '1' AND branch_id = '".$branch_id."'"));	
	$package = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as total from packages where package_category_name LIKE '%vip%' AND id = ".$mem_info['package']));
	$auto_cancel_check = mysqli_fetch_assoc($mysqli->query("SELECT * FROM cencel_request where booking_id = '".$mem_info['booking_id']."' AND note LIKE '%Request For Cancel for rental payment issue (auto cancel from software)%'"));
	if(!empty($mem_info['id'])){
		if(empty($auto_cancel_check['id'])){	
		$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$mem_info['branch_id']."'"));
		$check_meal_data = mysqli_fetch_assoc($mysqli->query("select * from member_meal where booking_id = '".$mem_info['booking_id']."' AND dats = '".$r_date."' AND month = '".$r_month."' AND year = '".$r_year."'"));
		$time_over  = '0';
		$already_patch_breakfast  = '0';
		$already_patch_lunch  = '0';
		$already_patch_dinner  = '0';
		if($hm >= '0230' AND $hm <= '1030' AND $r_apm == 'am'){
			$check_meal_data_breakfast = mysqli_fetch_assoc($mysqli->query("select * from member_meal where booking_id = '".$mem_info['booking_id']."' AND breakfast = '1' AND dats = '".$r_date."' AND month = '".$r_month."' AND year = '".$r_year."'"));
			if(!empty($check_meal_data_breakfast['id'])){
				$mysqli->query("update member_meal set
					breakfast = '1',
					hour = '".date('h')."',
					am_pm = '".date('a')."',
					time = '".date('h:i:s')."'
					where id = '".$check_meal_data_breakfast['id']."'
				");
				$already_patch_breakfast  = '1';
			}else{
				$mysqli->query("insert into member_meal values(
					'',
					'".$mem_info['branch_id']."',
					'".$mem_info['booking_id']."',
					'".$mem_info['card_number']."',
					'".date('l')."',
					'".date('d')."',
					'".date('m')."',
					'".date('Y')."',
					'".date('i')."',
					'".date('h')."',
					'".date('a')."',
					'".date('h:i:s')."',
					'".date('d/m/Y')."',
					'1',
					'0',
					'0',
					'0',
					'0',
					'1',
					'1'
				)");
			}
			$time_over = '1';
		}else if ($hm >= '0100' AND $hm <= '0700' AND $r_apm == 'pm'){
			$check_meal_data_lunch = mysqli_fetch_assoc($mysqli->query("select * from member_meal where booking_id = '".$mem_info['booking_id']."' AND lunch = '1' AND dats = '".$r_date."' AND month = '".$r_month."' AND year = '".$r_year."'"));
			if(!empty($check_meal_data_lunch['id'])){
				$mysqli->query("update member_meal set
					lunch = '1',
					hour = '".date('h')."',
					am_pm = '".date('a')."',
					time = '".date('h:i:s')."'
					where id = '".$check_meal_data_lunch['id']."'
				");
				$already_patch_lunch  = '1';
			}else{
				$mysqli->query("insert into member_meal values(
					'',
					'".$mem_info['branch_id']."',
					'".$mem_info['booking_id']."',
					'".$mem_info['card_number']."',
					'".date('l')."',
					'".date('d')."',
					'".date('m')."',
					'".date('Y')."',
					'".date('i')."',
					'".date('h')."',
					'".date('a')."',
					'".date('h:i:s')."',
					'".date('d/m/Y')."',
					'0',
					'1',
					'0',
					'0',
					'0',
					'1',
					'1'
				)");
			}
			$time_over = '1';
		}else if ($hm >= '0800' AND $hm <= '1100' AND $r_apm == 'pm'){
			$check_meal_data_dinner = mysqli_fetch_assoc($mysqli->query("select * from member_meal where booking_id = '".$mem_info['booking_id']."' AND dinner = '1' AND dats = '".$r_date."' AND month = '".$r_month."' AND year = '".$r_year."'"));
			if(!empty($check_meal_data_dinner['id'])){				
				$mysqli->query("update member_meal set
					dinner = '1',					
					hour = '".date('h')."',
					am_pm = '".date('a')."',
					time = '".date('h:i:s')."'
					where id = '".$check_meal_data_dinner['id']."'
				");
				$already_patch_dinner  = '1';
			}else{
				$mysqli->query("insert into member_meal values(
					'',
					'".$mem_info['branch_id']."',
					'".$mem_info['booking_id']."',
					'".$mem_info['card_number']."',
					'".date('l')."',
					'".date('d')."',
					'".date('m')."',
					'".date('Y')."',
					'".date('i')."',
					'".date('h')."',
					'".date('a')."',
					'".date('h:i:s')."',
					'".date('d/m/Y')."',
					'0',
					'0',
					'1',
					'0',
					'0',
					'1',
					'1'
				)");
			}
			$time_over = '1';
		}else{
			$time_over = '0';
		}
	if($time_over == '1'){
if($already_patch_breakfast == 1){ ?>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h1 style="color:#f00;font-weight:bolder;">Sorry! You Already Take Your Breakfast</h1>
		</center>
	</div>
</div>
__________4
<?php }else if($already_patch_lunch == 1){ ?>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h1 style="color:#f00;font-weight:bolder;">Sorry! You Already Take Your Lunch</h1>
		</center>
	</div>
</div>
__________4	
<?php }else if($already_patch_dinner == 1){ ?>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h1 style="color:#f00;font-weight:bolder;">Sorry! You Already Take Your Dinner</h1>
		</center>
	</div>
</div>
__________4
<?php }else{ ?>
	<div class="row">
		<div class="col-sm-12"></div>
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-6">
					<center>
					<?php if(!empty($mem_info['photo_avater'])){ ?>
						<?php if(url_check($home.$mem_info['photo_avater'])){ ?>
						<img src="<?php echo $home.$mem_info['photo_avater']; ?>" style="width:100%;padding:100px;" class="image-responsive"/>
						<?php }else{ ?>
						<img src="<?php echo $home.'assets/img/empty-user-xl.png'; ?>" style="width:100%;padding:100px;" class="image-responsive"/>
					<?php } }else{ ?>
						<img src="<?php echo $home.'assets/img/empty-user-xl.png'; ?>" style="width:100%;padding:100px;" class="image-responsive"/>
					<?php } ?>
					<center>
				</div>
				<div class="col-sm-6">
					<center>
						<h1>
							Name: <?php echo $mem_info['full_name']; ?><hr />
							Branch: <?php echo $branch['branch_name']; ?>
						</h1>
						<?php if($package['total'] > 0){ ?>
							<img src="<?php echo $home; ?>assets/img/vip_food.jpg" style="width:100%;padding:170px;padding-top:0px;"/>
						<?php }else{ ?>
							<img src="<?php echo $home; ?>assets/img/food.png" style="width:100%;padding:170px;padding-top:0px;"/>
						<?php } ?>
					</center>				
				</div>
			</div>
		</div>
	</div>
__________3
<?php } }else{ ?>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h1 style="color:#f00;font-weight:bolder;">Sorry!! Time Over</h1>
		</center>
	</div>
</div>
__________2
<?php } }else{ ?>
<div class="row">
	<div class="col-sm-12">
		<center>
			<h1 style="color:#f00;font-weight:bolder;">Sorry! You ar in Auto Cancel List, Please Contact with lobby</h1>
		</center>
	</div>
</div>
__________1
<?php } }else{ ?>	
<div class="row">
	<div class="col-sm-12">
		<center>
			<h1 style="color:#f00;font-weight:bolder;">No Result Found!</h1>
		</center>
	</div>
</div>
__________0
<?php } } ?>