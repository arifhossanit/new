<?php
include("../../application/config/ajax_config.php");
function month($num){
	if($num == '01'){
		return 'January';
	}else if($num == '02'){
		return 'February';
	}else if($num == '03'){
		return 'March';
	}else if($num == '04'){
		return 'April';
	}else if($num == '05'){
		return 'May';
	}else if($num == '06'){
		return 'Jun';
	}else if($num == '07'){
		return 'July';
	}else if($num == '08'){
		return 'August';
	}else if($num == '09'){
		return 'September';
	}else if($num == '10'){
		return 'Octaber';
	}else if($num == '11'){
		return 'November';
	}else{
		return 'December';
	}
}

if($mysqli->query("insert into corn_jobs_log values(
	'',
	'Member Available Date Manage & Rental Issue',
	'".date("l")."',
	'".date("h:i:sa")."',
	'".date("d/m/Y")."'
)")){
	$message = 'Message From Corn Jobs (HRM Sallary Auto generate). Job done at '. date("l, d-m-Y (h:i:sa)");
	sendsms($dev_number,$message);
}else{
	$message = 'Something wrong! Message From Corn Jobs (HRM Sallary Auto generate). Job done at '. date("l, d-m-Y (h:i:sa)");
	sendsms($dev_number,$message);
}
?>