<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['check_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from check_print_data where id = '".$_POST['check_id']."'"));
	if($mysqli->query("UPDATE check_print_data SET status = '2' WHERE id = '".$row['id']."'")){
		echo 'Your Submission Successfully Done!';
	}else{
		echo 'Something Wrong in database section! Please try again';
	}
} 

if(isset($_POST['disabled_check_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from check_print_data where id = '".$_POST['disabled_check_id']."'"));
	if($mysqli->query("UPDATE check_print_data SET status = '3' WHERE id = '".$row['id']."'")){
		if($mysqli->query("insert into check_print_disabled_data values(
			'',
			'".$row['id']."',
			'".$mysqli->real_escape_string($_POST['disabled_check_note'])."',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)")){
			echo 'Your Submission Successfully Done!';
		}else{
			echo 'Something Wrong in database note section! Please try again';
		}		
	}else{
		echo 'Something Wrong in database section! Please try again';
	}
} 
?>