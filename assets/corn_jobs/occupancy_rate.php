<?php
// include("../../application/config/ajax_config.php");
date_default_timezone_set('Asia/Dhaka');
function sendsms($number, $message_body){
	$phnP_n = strlen($number);		
	if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
	$apikey = 'e61022bacbd3b3213716f2295b70de8e44992fb9';   //Bapbeta
	//$apikey = 'baee927bf84af59e7e4dacdf4a9ece0112b7b66c';  //SariIT
	$device = '19|1'; //'19|0';
	$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device;  
	//$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device.'&type=sms&prioritize=1';  //SariIT
	$smsGatewayUrl = "https://sms.superhostelbd.com/services/send.php";  //Bapbeta
	//$smsGatewayUrl = "https://sms.sariit.com/services/send.php";  //SariIT
	$smsgatewaydata = $smsGatewayUrl.$api_params;
	$url = $smsgatewaydata;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);
}
$host = 'localhost';
$user = 'root';
$pass = '!@#$%databaseserveradmin2020';
$db = 'super_hostel';
$mysqli = new mysqli($host,$user,$pass,$db);

$branches = $mysqli->query("SELECT * from branches where status  = '1'");
while($branch = mysqli_fetch_assoc($branches)){
    $date = new DateTime();
    // $date->modify("+1 day");
    $occupide_number = mysqli_fetch_assoc($mysqli->query("select count(*) as occupied_rate from beds where uses in ('3','4') and branch_id = '".$branch['branch_id']."'"));
    $validate = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as validate from daily_ocupide_number where `data` = '".$date->format('d/m/Y')."' AND `branch_id` = '".$branch['branch_id']."'"));
    if(($validate['validate'] == '0' AND (int)$occupide_number['occupied_rate'] > 0)){
        $mysqli->query("insert into daily_ocupide_number (branch_id, occupency_number, uploader_info, data) values(
            '".$branch['branch_id']."',
            '".$occupide_number['occupied_rate']."',
            'Server',
            '".$date->format('d/m/Y')."'
        )");
    }
}
$mysqli->query("INSERT INTO corn_jobs_log VALUES(
	'',
	'Branch Occupency Rate',
	'".date("l")."',
	'".date("h:i:sa")."',
	'".date("d/m/Y")."'
)");
// sendsms('01731509208', 'Occupancy Scheduler');
// sendsms('01738184845', 'Occupancy Scheduler');

