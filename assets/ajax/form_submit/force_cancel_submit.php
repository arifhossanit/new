<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));
	$new_card = time() * rand();
	$bed_id = $row['bed_id'];
	$get_bed_number = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM member_directory WHERE bed_id = '".$bed_id."'"));
	if($get_bed_number[0] > 1){
		$bed_update_query = "update beds set uses = '2' where id = '".$row['bed_id']."'";
	}else{
		$bed_update_query = "update beds set uses = '0' where id = '".$row['bed_id']."'";
	}	
	if($mysqli->query("UPDATE member_directory SET
		card_number = '".$new_card."',
		security_deposit = '0',
		check_out_date = '".date('d/m/Y')."',
		status = '3',
		bed_id = '0',
		note = 'Diposit money return'
		WHERE id = '".$row['id']."'
	") AND
	$mysqli->query("UPDATE booking_info SET
		card_no = '".$new_card."',
		security_deposit = '0',
		status = '2',
		checkout_date = '".date('d/m/Y')."'
		WHERE booking_id = '".$row['booking_id']."'
	") AND
	$mysqli->query("UPDATE rent_info SET
		card_no = '".$new_card."'
		WHERE booking_id = '".$row['booking_id']."'
	") AND
	$mysqli->query($bed_update_query) AND	
	$mysqli->query("INSERT INTO return_diposit_money VALUES(
		'',
		'".$row['branch_id']."',
		'".$row['booking_id']."',
		'0',
		'Auto Refund (Force Cancel)',
		'',
		'',
		'',
		'',
		'Auto Refunded for Force Cancel Issue (Money Refunded for force cancel)',
		'1',
		'',
		'".date('d/m/Y')."'
	)")){
		echo 'Member Forced cancel successfully';
	}else{
		echo 'Something wrong! Please try again';
	}
}
?>