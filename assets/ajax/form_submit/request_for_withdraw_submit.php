<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){
	$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory WHERE id = '".$_POST['member_id']."'"));		
	$package = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$member_info['package']."'"));
	if($package['try_us'] == 0){
		$mysqli->query("update member_directory set check_out_date = 'Not Confirm Yet' where id = '".$member_info['id']."'");
		$update_booking = "UPDATE booking_info SET checkout_date = 'Not Confirm Yet', status = '1' WHERE booking_id = '".$member_info['booking_id']."'";
	}else{
		$update_booking = "UPDATE booking_info SET status = '1' WHERE booking_id = '".$member_info['booking_id']."'";
	}
	if(
		$mysqli->query($update_booking)
		AND 
		$mysqli->query("UPDATE beds SET uses = '3' WHERE id = '".$member_info['bed_id']."'")
		AND 
		$mysqli->query("DELETE FROM cencel_request WHERE member_id = '".$member_info['id']."'")
	){
		if(sendsms($member_info['phone_number'],'Mr. '.$member_info['full_name'].', Thank You For Stay With US. For any Query Feel free to call US +8809638666333')){
			$message = 'Mr. '.$member_info['full_name'].', Thank You For Stay With US. For any Query Feel free to call US +8809638666333';
			if(main_email('SUPER HOME MEMBER: REQUEST FOR CENCEL INFORMATION',$message,'','',$member_info['email'],$member_info['full_name'])){
				echo 'Withdraw Submitted Successfully!';
			}else{
				echo 'Something Wrong In MAIL section! Withdraw Submitted Successfully!';
			}				
		}else{
			echo 'Something Wrong In SMS section! Withdraw Submitted Successfully!';
		}		
	}else{
		echo 'Something Wrong! Please Try Again';
	}
}
?>