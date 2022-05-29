<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['generate_id'])){
	if($_SESSION['pre_book_otp'] == $_POST['otp_confirm']){
		$c_p = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where phone = '".$_POST['phone']."'"));
		if(!empty($c_p['phone']) AND $c_p['phone'] == $_POST['phone']){
			echo 'Phone Number Already Exixt! Please try with new one!_______1_______1_______'.$_POST['phone'];
		}else{
			$c_m = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where email = '".$_POST['email']."'"));
			if(!empty($c_m['email']) AND $c_m['email'] == $_POST['email']){
				echo 'Email Address Already Exixt! Please try with new one!_______1_______2_______'.$_POST['email'];
			}else{
				if(!empty($_POST['passport_no'])){
					$passport_no = $_POST['passport_no'];
				}else{
					$passport_no = '';
				}
				
				if(!empty($_POST['old_home_owner_name'])){
					$old_home_owner_name = $_POST['old_home_owner_name'];
				}else{
					$old_home_owner_name = '';
				}
				
				if(!empty($_POST['old_home_owner_number'])){
					$old_home_owner_number = $_POST['old_home_owner_number'];
				}else{
					$old_home_owner_number = '';
				}
				
				if(!empty($_POST['date_of_birth'])){
					$doc = explode('-',$_POST['date_of_birth']);
					$date_of_birth = $doc[2].'/'.$doc[1].'/'.$doc[0];
				}else{
					$date_of_birth = '';
				}
				
				if(!empty($_POST['qualification'])){
					$qualification = implode(',',$_POST['qualification']);
				}else{
					$qualification = '';
				}
				if($_FILES['photo_avater']['name'] != ''){
					$photo_avater = image_upload_two_prebook('photo_avater');
				}else{
					$photo_avater = '';
				}
				if(isset($_POST['selected_pkg'])){
					$selected_pkg = $_POST['selected_pkg'];
				}else{
					$selected_pkg = '';
				}
				if(isset($_POST['checkin_date'])){
					$checkin_date = $_POST['checkin_date'];
				}else{
					$checkin_date = '';
				}
				if(isset($_POST['parking'])){
					$parking = $_POST['parking'];
				}else{
					$parking = '';
				}
				if(isset($_POST['locker'])){
					$locker = $_POST['locker'];
				}else{
					$locker = '';
				}
				if(isset($_POST['payment'])){
					$payment = $_POST['payment'];
				}else{
					$payment = '';
				}
				if(isset($_POST['member_type'])){
					$member_type = $_POST['member_type'];
				}else{
					$member_type = '';
				}

				if($mysqli->query("INSERT INTO pre_booking_directory VALUES(
					'',
					'".$mysqli->real_escape_string($_POST['generate_id'])."',
					'".$mysqli->real_escape_string($_POST['full_name'])."',
					'".$mysqli->real_escape_string($_POST['father_name'])."',
					'".$mysqli->real_escape_string($date_of_birth)."',
					'".$mysqli->real_escape_string($_POST['marital_status'])."',
					'".$mysqli->real_escape_string($_POST['blood_group'])."',
					'".$mysqli->real_escape_string($_POST['religion'])."',
					'".$mysqli->real_escape_string($_POST['occupation'])."',
					'".$mysqli->real_escape_string($photo_avater)."',
					'".$mysqli->real_escape_string($qualification)."',
					'".$mysqli->real_escape_string($_POST['phone'])."',
					'".$mysqli->real_escape_string($_POST['email'])."',
					'".$mysqli->real_escape_string($_POST['nid'])."',
					'".$mysqli->real_escape_string($passport_no)."',
					'".$mysqli->real_escape_string($_POST['h_t_f_u'])."',
					'".$mysqli->real_escape_string($_POST['branch_id'])."',
					'".$mysqli->real_escape_string($_POST['permament_address'])."',
					'".$mysqli->real_escape_string($_POST['present_addrress'])."',
					'',
					'',
					'".$mysqli->real_escape_string($_POST['emergency_contact_name'])."',
					'".$mysqli->real_escape_string($_POST['emergency_contact_number'])."',
					'".$mysqli->real_escape_string($_POST['emergency_relation'])."',
					'".$mysqli->real_escape_string($_POST['emergency_contact_address'])."',
					'".$mysqli->real_escape_string($old_home_owner_name)."',
					'".$mysqli->real_escape_string($old_home_owner_number)."',
					'1',
					'',
					'".$mysqli->real_escape_string(date('d/m/Y'))."',
					'".$mysqli->real_escape_string($selected_pkg)."',
					'".$mysqli->real_escape_string($checkin_date)."',
					'".$mysqli->real_escape_string($parking)."',
					'".$mysqli->real_escape_string($payment)."',
					'".$mysqli->real_escape_string($locker)."',
					'".$mysqli->real_escape_string($member_type)."',
					'".$_SESSION['pre_book_otp']."'
				)")){
					$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$mysqli->real_escape_string($_POST['branch_id'])."'"));
					if(!empty($branch['branch_phone_number'])){
						$phone_number = $branch['branch_phone_number'];
					}else{
						$phone_number = '+8809638666333';
					}				
					$message = 'Your Request Successfully Submitted! As soon as possiable we will cantact with you. If you have any query feel free to call us '.$phone_number.'';
					if(sendsms($_POST['phone'],$message)){
						echo 'Your Request Successfully Submitted! As soon as possiable we will cantact with you. If you have any query feel free to call us '.$phone_number.' !_______0';
					}else{
						echo 'Something wrong! in SMS section. Your Request Successfully Submitted! As soon as possiable we will cantact with you. If you have any query feel free to call us '.$phone_number.' !_______0';
					}
					$get_branch_sales_consultants = $mysqli->query("SELECT employee_id from employee where branch = '".$_POST['branch_id']."' AND role = '1179783255713532148' AND status = 1");
					$consultants = array();
					foreach($get_branch_sales_consultants as $consultant){
						$consultants[] = $consultant['employee_id'];
					}
					// notification('Pre Booking notification', $_POST['full_name'].' has completed pre-booking for your branch!',$home.'admin/pre-book-member-directory',null,$consultants, 1, 'Pre book by '.$_POST['full_name']);
					unset($_SESSION['pre_book_otp']);
				}else{
					echo 'Something Wrong! Please Try Again!'.mysqli_error($mysqli).'_______1';
				}
			}
		}
	}else{
		echo 'OTP did not match!_______1_______1_______null';
	}
}
?>