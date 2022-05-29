<?php 
include("../../../application/config/ajax_config.php");
if(!isset($_POST['member_id'])){
	return;
}
$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));	
$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member_info['package']."' "));
if($package_info['try_us'] == 1 AND $package_info['package_days'] == '30' ){
	$check_rent = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$member_info['booking_id']."' order by id desc limit 01"));
	if(!empty($check_rent['id'])){
		if($check_rent['payment_pattern'] == 0){
			$note = 'Request For Cancel for rental payment issue (auto cancel from software)';
		}else{
			$note = $mysqli->real_escape_string($_POST['note']);
		}
	}else{
		$note = $mysqli->real_escape_string($_POST['note']);
	}
}else{
	$note = $mysqli->real_escape_string($_POST['note']);
}
$checj_ot = explode('-',$_POST['checkout_date']);
$dateiio = $checj_ot[2].'/'.$checj_ot[1].'/'.$checj_ot[0];
$cencel_info = "insert into cencel_request values(
	'',
	'".$mysqli->real_escape_string($member_info['booking_id'])."',
	'".$mysqli->real_escape_string($member_info['branch_id'])."',
	'".$mysqli->real_escape_string($member_info['id'])."',
	'".$mysqli->real_escape_string($member_info['bed_id'])."',
	'".$mysqli->real_escape_string($_POST['checkout_date'])."',
	'".$note."',
	'1',
	'".$mysqli->real_escape_string(rahat_decode($_POST['uploader_info']))."',
	'".$mysqli->real_escape_string(date('d/m/Y'))."' 
)";	
$bed_id = $member_info['bed_id'];
$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
if($get_bed_number[0] > 1){
	$bed_update_query = "update beds set uses = '2' where id = '".$member_info['bed_id']."'";
}else{
	$bed_update_query = "update beds set uses = '4' where id = '".$member_info['bed_id']."'";
}	
if(
	$mysqli->query("update member_directory set check_out_date = '".$dateiio."' where id = '".$member_info['id']."'")
	AND 
	$mysqli->query("update booking_info set status = '0', checkout_date = '".$dateiio."' where booking_id = '".$member_info['booking_id']."'")
	AND 
	$mysqli->query($bed_update_query)
	AND 
	$mysqli->query($cencel_info)
){
	if($package_info['try_us'] == 1){
		echo 'Cancel Request Submitted Successfully!____0';
	}else{
		$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$mysqli->real_escape_string($member_info['branch_id'])."'"));
		if(!empty($branch['branch_phone_number'])){
			$phone_number = $branch['branch_phone_number'];
		}else{
			$phone_number = '+8809638666333';
		}
		if(sendsms($member_info['phone_number'],'Mr. '.$member_info['full_name'].', Your Cancelation Request is Accepeted. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.' & For More Details Visit Here: https://www.superhomebd.com/')){
			$message = 'Dear. '.$member_info['full_name'].', Your Celcalation Request is Accepeted. Thank You For Stay With US. For any Query Feel free to call US '.$phone_number.' & For More Details Visit Here: https://www.superhomebd.com/';
			if(main_email('SUPER HOME MEMBER: REQUEST FOR CANCEL INFORMATION',$message,'','',$member_info['email'],$member_info['full_name'])){
				echo 'Cancel Request Submitted Successfully!____0';
			}else{
				echo 'Something Wrong In MAIL section! Cancel Request Submitted Successfully.____0';
			}				
		}else{
			echo 'Something Wrong In SMS section! Cancel Request Submitted Successfully.____0';
		}	
	}
}else{
	echo 'Something Wrong! Please Try Again____1';
}	
?>