<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['pkg_id'])){
	if(!empty($_POST['phone'])){
		$phnP_n = strlen($_POST['phone']);		
		if($phnP_n == '14'){
			$phn = substr($_POST['phone'],'4');
		}else if($phnP_n == '11'){
			$phn = substr($_POST['phone'],'1');
		}else{
			$phn = $_POST['phone'];
		}		
		$email_c = "where phone_number like '%$phn'";
		$email_o = "where phone_number like '%$phn'";
	}else{
		$email_c = "where phone_number = '000000000'";
		$email_o = "where phone_number = '000000000'";
	}
	
	$nid_filter = '';
	if(!empty($_POST['nid'])){
		$nid_filter = " OR mother_name LIKE '{$_POST['nid']}' ";
	}

	$email_filter = '';
	if(!empty($_POST['email'])){
		$email_filter = " OR email LIKE '{$_POST['email']}' ";
	}

	$member1 = mysqli_fetch_assoc($mysqli->query("select * from old_members ".$email_o.""));
	$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory ".$email_c." $nid_filter $email_filter "));
	$pkg_id = $_POST['pkg_id'];
	if(!empty($_POST['pkg_id'])){
		$checkInDate = $_POST['checkInDate'];
	}else{
		$checkInDate = date('m/d/Y');
	}		
	$row = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$pkg_id."'"));
	$chk_date = date('Y-m-d',strtotime('+'.$row['package_days'].' days',strtotime(str_replace('/', '-', $checkInDate)))) . PHP_EOL;
	$chk_date1 = date('Y-m-d',strtotime('+'.$row['package_days'].' days',strtotime(str_replace('/', '-', $checkInDate)))) . PHP_EOL;
	if($row['try_us'] == 1 ){
		$time_and_date = $chk_date1;
		$time = '02.00 PM';
	}else{
		/* $time_and_date = $chk_date; */
		$time_and_date = 'Not Confirm Yet';
		$time = '';
	}
	if(empty($member['phone_number'])){
		if(empty($member1['phone_number'])){
			if(!empty($row['discount_amount'])){
				if(!empty($_POST['member_type']) AND $_POST['member_type'] == 'GROUP'){
					$discount = $row['group_discount_amount'];
				}else{
					$discount = $row['discount_amount'];
				}				
			}else{
				$discount = '0';
			}
		}else{
			$discount = '0';
		}
	}else{
		$discount = '0';
	}
	echo $row['package_price'].'_'.$row['monthly_rent'].'_'.$chk_date.'_'.$time_and_date.'_'.$row['package_days'].'_'.$row['parking_amount'].'_'.$row['try_us'].'_'.$time.'_'.$discount;
}
?>