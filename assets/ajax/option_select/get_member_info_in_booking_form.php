<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['send_value'])){
	$value = explode('__',$_POST['send_value']);
	$phone_number = $value[0];
	$email_value = $value[1];
	$nid_value = $value[2];
	$mp = mysqli_fetch_assoc($mysqli->query("select * from member_directory where phone_number = '".$phone_number."' order by id asc"));
	$me = mysqli_fetch_assoc($mysqli->query("select * from member_directory where email = '".$email_value."' order by id asc"));
	$mn = mysqli_fetch_assoc($mysqli->query("select * from member_directory where mother_name = '".$nid_value."' order by id asc"));
	if(!empty($mp['id'])){
		$ccn_force = mysqli_fetch_assoc($mysqli->query("select * from return_diposit_money where booking_id = '".$mp['booking_id']."' AND note = 'Auto Refunded for Force Cancel Issue (Money Refunded for force cancel)'"));
		if(!empty($ccn_force['id'])){
			echo '0___phone___Force Cancel Member by Phone number!';
		}else{
			if($mp['status'] == '3'){
				echo '1___phone___Number Matched___'.$mp['email'].'___'.$mp['mother_name'].'___'.$mp['full_name'].'___'.$mp['religion'].'___'.$mp['h_t_f_u'].'___'.$mp['referance_id'].'___'.$mp['photo_avater'].'___'.$mp['father_name'].'___'.$mp['emergency_number_1'].'___'.$mp['emergency_number_2'].'___'.$mp['occupation'].'___'.$mp['member_type'].'___'.$mp['address'].'___'.$mp['remarks'].'___'.$mp['document_type'].'|||'.$mp['document_upload'];
			}else{
				echo '0___phone___Member Allready Exist by Phone number!';
			}
		}				
	}else if(!empty($me['id'])){
		$ccn_force = mysqli_fetch_assoc($mysqli->query("select * from return_diposit_money where booking_id = '".$me['booking_id']."' AND note = 'Auto Refunded for Force Cancel Issue (Money Refunded for force cancel)'"));
		if(!empty($ccn_force['id'])){
			echo '0___email___Force Cancel Member by Email!';
		}else{
			if($me['status'] == '3'){
				echo '1___email___Email Matched___'.$me['phone_number'].'___'.$me['mother_name'].'___'.$me['full_name'].'___'.$me['religion'].'___'.$me['h_t_f_u'].'___'.$me['referance_id'].'___'.$me['photo_avater'].'___'.$me['father_name'].'___'.$me['emergency_number_1'].'___'.$me['emergency_number_2'].'___'.$me['occupation'].'___'.$me['member_type'].'___'.$me['address'].'___'.$me['remarks'].'___'.$me['document_type'].'|||'.$me['document_upload'];
			}else{
				echo '0___email___Member Allready Exist by Email!';
			}
		}				
	}else if(!empty($mn['id'])){
		$ccn_force = mysqli_fetch_assoc($mysqli->query("select * from return_diposit_money where booking_id = '".$mn['booking_id']."' AND note = 'Auto Refunded for Force Cancel Issue (Money Refunded for force cancel)'"));
		if(!empty($ccn_force['id'])){
			echo '0___nid___Force Cancel Member by NID!';
		}else{
			if($mn['status'] == '3'){
				echo '1___nid___NID Matched___'.$mn['phone_number'].'___'.$mn['email'].'___'.$mn['full_name'].'___'.$mn['religion'].'___'.$mn['h_t_f_u'].'___'.$mn['referance_id'].'___'.$mn['photo_avater'].'___'.$mn['father_name'].'___'.$mn['emergency_number_1'].'___'.$mn['emergency_number_2'].'___'.$mn['occupation'].'___'.$mn['member_type'].'___'.$mn['address'].'___'.$mn['remarks'].'___'.$mn['document_type'].'|||'.$mn['document_upload'];
			}else{
				echo '0___nid___Member Allready Exist by NID!';
			}		
		}
	}else{
		echo '0___nothing___Not found any member information';
	}	
} 
?>