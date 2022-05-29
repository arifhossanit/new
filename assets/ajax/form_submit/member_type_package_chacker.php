<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['card_number'])){
	$mem_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM member_directory WHERE card_number = '".$_POST['card_number']."' AND status = '1'"));
	if(!empty($mem_info['package'])){
		//----
		
		$package_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$mem_info['package']."'"));
		if($package_info['package_price'] > '1000'){
			$cen_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM cencel_request WHERE booking_id = '".$mem_info['booking_id']."'"));
			if(!empty($cen_info['booking_id'])){
				echo '1';
			}else{
				$widt_check = mysqli_fetch_assoc($mysqli->query("SELECT * FROM withdraw_checkout WHERE booking_id = '".$mem_info['booking_id']."'"));
				if(!empty($widt_check['booking_id'])){
					echo '1';
				}else{
					$retn_deip = mysqli_fetch_assoc($mysqli->query("SELECT * FROM return_diposit_money WHERE booking_id = '".$mem_info['booking_id']."'"));
					if(!empty($retn_deip['booking_id'])){
						echo '1';
					}else{
						
						echo '0';
					}										
				}				
			}
		}else{
			echo '1';
		}
		
		//----
	}else{
		
		echo '1';
	}
}
?>