<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['branch_id'])){ 
	if($mysqli->query("update pre_booking_directory set
		branch_id = '".$_POST['branch_id']."'
		where id = '".$_POST['update_id']."'
	")){
		echo 'Data Update Successfully!';
	}else{
		echo 'Something Wrong! Please Try Again';
	}
}
?>