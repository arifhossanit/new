<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['employee_id'])){
	unset($_SESSION['super_admin']);
	unset($_SESSION['user_info']);
	unset($_SESSION['dingtalk_video_tutorials']);
	unset($_SESSION['software_video_tutorials']);
	unset($_SESSION['set_employee_id']);
	$_SESSION['employee_lock_screen_id'] = $_POST['employee_id'];
} ?>

<?php
if(isset($_POST['employee_id_login_to_another_account'])){
	unset($_SESSION['employee_lock_screen_id']);
}
?>