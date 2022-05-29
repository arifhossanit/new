<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['month'])){
	$number_of_days = cal_days_in_month(CAL_GREGORIAN,$_POST['month'],$_POST['year']);
	for($i = 1; $i <= $number_of_days; $i++){
		echo '<option>'.sprintf("%02d",$i).'/'.sprintf("%02d",$_POST['month']).'/'.$_POST['year'].'</option>';
	}
}
?>