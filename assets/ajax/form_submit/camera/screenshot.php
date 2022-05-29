<?php
include("../../../../application/config/ajax_config.php");
class TrackUser{
	function SaveScreenshot(){
		global $mysqli;
		if(!empty($_SESSION['super_admin']['branch'])){
			$branch_id = $_SESSION['super_admin']['branch'];
		}else{
			$branch_id = 'Session_Was_Expired';
		}
		if(!empty($_SESSION['super_admin']['email'])){
			$email = $_SESSION['super_admin']['email'];
		}else{
			$email = 'Session_Was_Expired';
		}
		$event_log_array = array(
			'click'=>'User has clicked on the Web Page',
			'form-submit'=>'User has submitted Form Submit.',
			'form-clear'=>'User has reset the form data.',
			'link-click'=>'User has clicked the link.',
			'right-click'=>'User has clicked Right Button of the Mouse.',
			'copy'=>'User has copied web page content.',
		);			
		$filteredData = substr($_POST['image_code'], strpos($_POST['image_code'], ",")+1);
		$unencodedData = base64_decode($filteredData);
		if(!file_exists("../../../../assets/uploads/screenshot/")) {
			mkdir("../../../../assets/uploads/screenshot/");
		}
		$file_path="../../../../assets/uploads/screenshot/";
		$file_user="assets/uploads/screenshot/";
		$filename = 'USER_ACTIVITY_'.date('d_m_Y').'_'.date('h_i_s_a').'_'.time().'_'.$email.'_'.$branch_id.'.png';
		file_put_contents($file_path."/".$filename, $unencodedData);
		$file_content = @file_get_contents("../../../../assets/uploads/screenshot/event-log.log");
		$file_content.="\n ".$event_log_array[$_POST['event_name']].". Image : ".$filename.". Time : ".date("Y-m-d-H-i-s").". IP Address : ".$_SERVER['REMOTE_ADDR'];
		file_put_contents("../../../../assets/uploads/screenshot/event-log.log", $file_content);
		$screenshot_data = $file_user.$filename;
		$mysqli->query("INSERT INTO screen_shot_logs VALUES(
			'',
			'".$mysqli->real_escape_string($branch_id)."',
			'".$mysqli->real_escape_string($email)."',
			'".$mysqli->real_escape_string($screenshot_data)."',
			'".$mysqli->real_escape_string($event_log_array[$_POST['event_name']])."',
			'1',
			'".$mysqli->real_escape_string(date('h:i:sa'))."',
			'".$mysqli->real_escape_string(date('d'))."',
			'".$mysqli->real_escape_string(date('m'))."',
			'".$mysqli->real_escape_string(date('Y'))."',
			'".$mysqli->real_escape_string(date('d/m/Y'))."'
		)");
	}
}
$TrackUser  = new TrackUser();
if(isset($_REQUEST['image_code']) && $_REQUEST['image_code'] != "") {
	$TrackUser->SaveScreenshot();
}
?>
