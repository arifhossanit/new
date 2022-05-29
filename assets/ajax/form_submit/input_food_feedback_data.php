<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['card_number'])){
	$check_member_status = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$_POST['card_number']."' and status = '1'"));
	if(!empty($check_member_status['id'])){
		$booking_check = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$check_member_status['booking_id']."' and status = '1'"));
		if(!empty($booking_check['id'])){
			$dining_id_test = mysqli_fetch_assoc($mysqli->query("select * from member_meal where booking_id = '".$check_member_status['booking_id']."' and data = '".date('d/m/Y')."'"));
			if(!empty($dining_id_test['id'])){
				$booking_id = $check_member_status['booking_id'];
				$branch_id = $check_member_status['branch_id'];
				$time = date('hi');
				$am_pm = date('a');
				$days = date('d');
				$month = date('m');
				$year = date('Y');
				$feed_back_value = $_POST['value'];
				$feed_back_note = $_POST['value'];
				$full_name = $check_member_status['full_name'];
				$test_branch_food_data = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."'"));
				if(!empty($test_branch_food_data['id'])){
					if($time >= '0600' AND $time <= '1159' AND $am_pm == 'am'){
						$get_food_data = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."' and meal_type = 'Breakfast' and data = '".date('d/m/Y')."' order by id desc"));
						if(!empty($get_food_data['id'])){
							$food_code = $get_food_data['food_code'];					
						}else{
							$get_food_data1 = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."' and meal_type = 'Breakfast' order by id desc"));
							$food_code = $get_food_data1['food_codefood_code'];
						}
					}else if($time >= '1201' AND $time <= '0759' AND $am_pm == 'pm'){
						$get_food_data = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."' and meal_type = 'Lunch' and data = '".date('d/m/Y')."' order by id desc"));
						if(!empty($get_food_data['id'])){
							$food_code = $get_food_data['food_code'];					
						}else{
							$get_food_data1 = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."' and meal_type = 'Lunch' order by id desc"));
							$food_code = $get_food_data1['food_codefood_code'];
						}
					}else if($time >= '0800' AND $time <= '1159' AND $am_pm == 'pm'){
						$get_food_data = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."' and meal_type = 'Dinner' and data = '".date('d/m/Y')."' order by id desc"));
						if(!empty($get_food_data['id'])){
							$food_code = $get_food_data['food_code'];					
						}else{
							$get_food_data1 = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."' and meal_type = 'Dinner' order by id desc"));
							$food_code = $get_food_data1['food_codefood_code'];
						}
					}else{
						$get_food_data = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."' and data = '".date('d/m/Y')."' order by id desc"));
						if(!empty($get_food_data['id'])){
							$food_code = $get_food_data['food_code'];					
						}else{
							$get_food_data1 = mysqli_fetch_assoc($mysqli->query("select * from food_menu where branch_id = '".$branch_id."' order by id desc"));
							$food_code = $get_food_data1['food_codefood_code'];
						}
					}				
					if($mysqli->query("insert into member_food_feedback values(
						'',
						'".$booking_id."',
						'".$branch_id."',
						'".$food_code."',
						'".$feed_back_value."',
						'".$time."',
						'".$am_pm."',
						'".$days."',
						'".$month."',
						'".$year."',
						'".$feed_back_note."',
						'1',
						'".$full_name."',
						'".date('d/m/Y')."'
					)")){
						echo 'Thank you for the feedback!_____1';
					}else{
						echo 'Something Wrong! Please Try again_____0';
					}
				}else{
					echo 'Sorry! Food Menu Not Added Yet!_____2';
				}
			}else{
				echo 'Sorry! You haven not tested the food yet today!_____2';
			}			
		}else{
			echo 'Sorry! You may be on the cancellation list_____0';
		}
	}else{
		echo 'Card Number Dose not Exixt!_____0';
	}	
}
?>