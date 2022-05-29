<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['award_submit_token'])){
	$year = $_POST['year'];
	$month = $_POST['month'];
	$reliagion = $_POST['reliagion'];
	$percentage = $_POST['percentage'];
	$note = $_POST['note'];
	foreach($_POST['dates'] as $dates){
		$dt = explode("/",$dates);
		$mysqli->query("insert into employee_festiavle_awards value(
			'',
			'".$year."',
			'".sprintf('%02d',$month)."',
			'".$dt[0]."',
			'".$dates."',
			'".$reliagion."',
			'".$percentage."',
			'".$note."',
			'1',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)");
	}
	echo 'Data Saved Successfully!';
}
?>