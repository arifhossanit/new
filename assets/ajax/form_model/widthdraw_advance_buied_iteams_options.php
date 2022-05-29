<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['transaction_id'])){
	$logs = mysqli_fetch_assoc($mysqli->query("select * from advance_transaction_logs where transaction_id = '".$_POST['transaction_id']."'"));
	if(!empty($_SESSION['super_admin']['email'])){
		if($logs['approval'] == 2){
			echo 'Sorry! Transaction already Approved. Now You Can not widthdraw It.';
		}else{
			if( $mysqli->query("delete from advance_transaction_logs where id = '".$logs['id']."' ")){
				echo 'Transaction Widthdraw Successfully!';
			}else{
				echo 'Something Wrong! Please Tray again';
			}
		}
	}else{
		echo 'Your Session is expired! Please Refresh your page';
	}
} ?>