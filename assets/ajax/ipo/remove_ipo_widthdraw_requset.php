<?php 
	include("../../../application/config/ajax_config.php");
	if(isset($_POST['ipo_request_id'])){
		$check_data = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_widthdraw_request where id = '".$_POST['ipo_request_id']."' and status = '1'"));
		if(!empty($check_data)){
			if($mysqli->query("delete from ipo_member_widthdraw_request where id = '".$check_data['id']."'")){
				echo 'Your Widthdraw Request Remove successfully.';
			}else{
				echo 'Something wrong! Please Try again.';
			}
		}else{
			echo 'Sorry! It is too late to remove widthdraw Request!';
		}
	}
?>