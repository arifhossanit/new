<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['booking_id'])){
	$count_checkin = mysqli_fetch_array($mysqli->query("select count(*) from in_cin_cng_log where booking_id = '".$_POST['booking_id']."'"));
	if($count_checkin[0] < 3){
		$booking_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM booking_info WHERE id = '".$_POST['booking_id']."'"));
		$package_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$booking_info['package']."'"));
		$package_days = $package_info['package_days'];
		
		$date = date_create($_POST['chckin']);
		$new_date = date_format($date,"d/m/Y");
		$set_checkOut = date('d/m/Y', strtotime($_POST['chckin']. ' + '.(int)$package_days.' days'));
		$up_booking_info = "UPDATE booking_info SET
			checkin_date = '".$new_date."',
			checkout_date = '".$set_checkOut."'
			WHERE booking_id = '".$booking_info['booking_id']."'
		";
		$up_member_info = "UPDATE member_directory SET
			check_in_date = '".$new_date."',
			check_out_date = '".$set_checkOut."'
			WHERE booking_id = '".$booking_info['booking_id']."'
		";
		$up_rent_info = "UPDATE rent_info SET
			checkin_date = '".$new_date."',
			checkout_date = '".$set_checkOut."'
			WHERE booking_id = '".$booking_info['booking_id']."'
		";
		$in_cin_cng_log = "INSERT INTO in_cin_cng_log VALUES(
			'',
			'".$booking_info['booking_id']."',
			'".$_POST['chckoldin']."',
			'".$new_date."',
			'".$_POST['cin_note']."',
			'1',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)";
		if(
			$mysqli->query($in_cin_cng_log) AND
			$mysqli->query($up_booking_info) AND
			$mysqli->query($up_member_info) AND
			$mysqli->query($up_rent_info)
		){
			echo 'CheckIn Date Changed Successfully!';
		}else{
			echo 'Something Wrong! Please Try Again';
		}
	}else{
		echo 'Sorry! You can change checkin date maximum 2 time.';
	}
}
?>