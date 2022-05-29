<?php
define('ENVIRONMENT', 'development');
$ds = DIRECTORY_SEPARATOR;
define('BASEPATH', dirname(dirname(dirname(__FILE__))));
define('APPPATH', BASEPATH . $ds . 'application' . $ds);
define('LIBBATH', BASEPATH . "{$ds}system{$ds}libraries{$ds}Session{$ds}");
require_once LIBBATH . 'Session_driver.php';
require_once LIBBATH . "drivers{$ds}Session_files_driver.php";
require_once BASEPATH . "{$ds}system{$ds}core{$ds}Common.php";
require BASEPATH . '/vendor/autoload.php';

// This will output the barcode as HTML output to display in the browser
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();

$config = get_config();
if (empty($config['sess_save_path'])) {  $config['sess_save_path'] = rtrim(ini_get('session.save_path'), '/\\'); }
$config = array( 'cookie_lifetime' => $config['sess_expiration'], 'cookie_name' => $config['sess_cookie_name'], 'cookie_path' => $config['cookie_path'], 'cookie_domain' => $config['cookie_domain'], 'cookie_secure' => $config['cookie_secure'], 'expiration' => $config['sess_expiration'], 'match_ip' => $config['sess_match_ip'], 'save_path' => $config['sess_save_path'],  '_sid_regexp' => '[0-9a-v]{32}', );
$class = new CI_Session_files_driver($config);
if (is_php('5.4')) {
    session_set_save_handler($class, TRUE);
} else {
    session_set_save_handler( array($class, 'open'), array($class, 'close'), array($class, 'read'), array($class, 'write'), array($class, 'destroy'), array($class, 'gc') ); register_shutdown_function('session_write_close');
}
session_name($config['cookie_name']);
session_start();
//var_dump($_SESSION);
date_default_timezone_set('Asia/Dhaka');

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'super_hostel';
$db_notification = 'super_hostel_notification';

$dev_number = '01979746680'; //01704123492

$req_urldd = explode("/",$_SERVER['REQUEST_URI']);
$auto_url_finder = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://" . $_SERVER['HTTP_HOST']."/".$req_urldd[1].'/';
$home = $auto_url_finder; 
$home_app = 'http://116.68.198.178/super_home/';
$application_fileurl = 'http://116.68.198.178/shapp/';
$demo_application_fileurl = 'http://116.68.198.178/shapp_demo/';

$mysqli = new mysqli($host,$user,$pass,$db);
$mysqli_notification = $mysqli;

function check_permission($menu_id){
	global $mysqli;
	$role_id = $_SESSION['super_admin']['role_id'];
	if($role_id == '2805597208697462328'){ //2805597208697462328
		return true;
	}else{
		if(!empty($role_id)){
			$get_id = mysqli_fetch_assoc($mysqli->query("select * from role_peermission where role_id = '".$role_id."' AND ".$menu_id." = '1'"));
			if(!empty($get_id[$menu_id]) AND $get_id[$menu_id] == '1'){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}				
	}
}

function sendsms($number, $message_body){ global $mysqli;
	$mysqli->query("INSERT INTO sms_logs VALUES('','".$mysqli->real_escape_string($number)."','".$mysqli->real_escape_string($message_body)."','".$mysqli->real_escape_string(date("l"))."','".$mysqli->real_escape_string(date("h:i:s"))."','".$mysqli->real_escape_string(date("a"))."','".$mysqli->real_escape_string(date("d/m/Y"))."')");
	return true;	
	$phnP_n = strlen($number);		
	if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
	$apikey = 'e61022bacbd3b3213716f2295b70de8e44992fb9';   //Bapbeta
	//$apikey = 'baee927bf84af59e7e4dacdf4a9ece0112b7b66c';  //SariIT
	$device = '19|0'; //'19|0';
	$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device;  
	//$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device.'&type=sms&prioritize=1';  //SariIT
	$smsGatewayUrl = "https://sms.bapbeta.com/services/send.php";  //Bapbeta
	//$smsGatewayUrl = "https://sms.sariit.com/services/send.php";  //SariIT
	$smsgatewaydata = $smsGatewayUrl.$api_params;
	$url = $smsgatewaydata;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);                         
	if(!empty($output)){
		$mysqli->query("INSERT INTO sms_logs VALUES('','".$mysqli->real_escape_string($number)."','".$mysqli->real_escape_string($message_body)."','".$mysqli->real_escape_string(date("l"))."','".$mysqli->real_escape_string(date("h:i:s"))."','".$mysqli->real_escape_string(date("a"))."','".$mysqli->real_escape_string(date("d/m/Y"))."')");
	   //echo $output =  file_get_contents($smsgatewaydata); 
	return true; }else{ return false; }
}

function otp_sendsms($number, $message_body){ global $mysqli;
	$mysqli->query("INSERT INTO sms_logs VALUES('','".$mysqli->real_escape_string($number)."','".$mysqli->real_escape_string($message_body)."','".$mysqli->real_escape_string(date("l"))."','".$mysqli->real_escape_string(date("h:i:s"))."','".$mysqli->real_escape_string(date("a"))."','".$mysqli->real_escape_string(date("d/m/Y"))."')");
	return true;	
	$phnP_n = strlen($number);		
	if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
	$apikey = 'e61022bacbd3b3213716f2295b70de8e44992fb9';  
	//$apikey = 'baee927bf84af59e7e4dacdf4a9ece0112b7b66c';  //SariIT
	$device = '19|0';//'16|1';
	$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device;  
	//$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device.'&type=sms&prioritize=1';  //SariIT
	$smsGatewayUrl = "https://sms.bapbeta.com/services/send.php"; 
	//$smsGatewayUrl = "https://sms.sariit.com/services/send.php";  //SariIT
	$smsgatewaydata = $smsGatewayUrl.$api_params;
	$url = $smsgatewaydata;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);                         
	if(!empty($output)){
		$mysqli->query("INSERT INTO sms_logs VALUES('','".$mysqli->real_escape_string($number)."','".$mysqli->real_escape_string($message_body)."','".$mysqli->real_escape_string(date("l"))."','".$mysqli->real_escape_string(date("h:i:s"))."','".$mysqli->real_escape_string(date("a"))."','".$mysqli->real_escape_string(date("d/m/Y"))."')");
	   //echo $output =  file_get_contents($smsgatewaydata); 
	return true; }else{ return false; }
}

function notification($n_header, $n_message, $n_links, $n_user_id = null, $n_user_id_multi = null, $n_user_type, $n_sender){ global $mysqli_notification;
	if(!empty($n_employee_id_multi)){
		$return = 1;
		foreach($n_employee_id_multi as $row){ if($mysqli_notification->query("INSERT INTO notification VALUES( '', '".$mysqli_notification->real_escape_string($row)."', '".$mysqli_notification->real_escape_string($n_user_type)."', '".$mysqli_notification->real_escape_string($n_header)."', '".$mysqli_notification->real_escape_string($n_message)."', '".$mysqli_notification->real_escape_string($n_links)."', '".$mysqli_notification->real_escape_string(date('h:i:s a'))."', '".$mysqli_notification->real_escape_string(date('d/m/Y'))."', '".$mysqli_notification->real_escape_string(time())."', '".$mysqli_notification->real_escape_string(1)."', '".$mysqli_notification->real_escape_string($n_sender)."' )")){ $return = 1; }else{ $return = 0; } } if($return == 1){ return true; }else{ return false; }
	}else{
		if($mysqli_notification->query("INSERT INTO notification VALUES( '', '".$mysqli_notification->real_escape_string($n_user_id)."', '".$mysqli_notification->real_escape_string($n_user_type)."', '".$mysqli_notification->real_escape_string($n_header)."', '".$mysqli_notification->real_escape_string($n_message)."', '".$mysqli_notification->real_escape_string($n_links)."', '".$mysqli_notification->real_escape_string(date('h:i:s a'))."', '".$mysqli_notification->real_escape_string(date('d/m/Y'))."', '".$mysqli_notification->real_escape_string(time())."', '".$mysqli_notification->real_escape_string(1)."', '".$mysqli_notification->real_escape_string($n_sender)."' )")){ return true; }else{ return false; }
	}
}

function alert_for_js($type, $message){
	$data = '
		<div class="alert toast bg-'.$type.' fade show alert-dismissible" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed;z-index: 99999;right: 5%;top: 5%;width: 332px;padding:0px;-webkit-box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);-moz-box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);">
			<div class="toast-header">
				<strong class="mr-auto"><b style="text-transform: capitalize;">'.$type.'!</b></strong>
				<small>System Message</small>
				<button data-dismiss="alert" type="button" class="ml-2 mb-1 close" aria-label="Close" style="padding: 0px;position: inherit;">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="toast-body">
				'.$message.'
			</div>
		</div>
	';
	return $data;
}
include('temp/qrcode/qrlib.php');
include('temp/StringToUrl/index.php');
include('temp/fpdf/fpdf.php');





























function image_upload_permission_file($file_name){
	$filename = $_FILES[$file_name]["name"];
	$file_tmp = $_FILES[$file_name]["tmp_name"];
	$file_ext = substr($filename, strripos($filename, '.'));
	$avater_name = 'IMAGE_PERMISSION_FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() ;
	$newfilenameup = '../../assets/uploads/other_document/permission_file/'.$avater_name. $file_ext;	
	$newfilename = 'assets/uploads/other_document/permission_file/'.$avater_name. $file_ext;	
	move_uploaded_file($file_tmp, $newfilenameup);
	return $newfilename;
}
function image_upload_two($file_name){
	$filename = $_FILES[$file_name]["name"];
	$file_tmp = $_FILES[$file_name]["tmp_name"];
	$file_ext = substr($filename, strripos($filename, '.'));
	$avater_name = 'FILES_IMAGE_MEMBER_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() ;
	$newfilenameup = '../../assets/uploads/member/member_image/'.$avater_name. $file_ext;	
	$newfilename = 'assets/uploads/member/member_image/'.$avater_name. $file_ext;	
	move_uploaded_file($file_tmp, $newfilenameup);
	return $newfilename;
}
function image_upload_two_prebook($file_name){
	$filename = $_FILES[$file_name]["name"];
	$file_tmp = $_FILES[$file_name]["tmp_name"];
	$file_ext = substr($filename, strripos($filename, '.'));
	$avater_name = 'FILES_IMAGE_MEMBER_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() ;
	$newfilenameup = '../../../assets/uploads/member/member_image/'.$avater_name. $file_ext;	
	$newfilename = 'assets/uploads/member/member_image/'.$avater_name. $file_ext;	
	move_uploaded_file($file_tmp, $newfilenameup);
	return $newfilename;
}
function file_upload_member($file_name,$tempname){
	$filename 		= $file_name;
	$file_tmp 		= $tempname;
	$file_ext 		= substr($filename, strripos($filename, '.'));
	$newfilename 	= $filename.'_FILES_DOCUMENT_MEMBER_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
	$newfile 		= 'assets/uploads/member/member_document/' . $newfilename;	
	$newfileup 		= '../../assets/uploads/member/member_document/' . $newfilename;	
	move_uploaded_file($file_tmp,$newfileup);
	return $newfile;
}
function file_upload_member_dir($file_name,$tempname,$dir){
	$filename 		= $file_name;
	$file_tmp 		= $tempname;
	$file_ext 		= substr($filename, strripos($filename, '.'));
	$newfilename 	= $filename.'_FILES_DOCUMENT_MEMBER_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
	$newfile 		= 'assets/uploads/member/member_document/' . $newfilename;	
	$newfileup 		= $dir . $newfilename;	
	move_uploaded_file($file_tmp,$newfileup);
	return $newfile;
}
function file_upload_service($file_name){
	$filename 		= $_FILES[$file_name]["name"];
	$file_tmp 		= $_FILES[$file_name]["tmp_name"];
	$file_ext 		= substr($filename, strripos($filename, '.'));
	$newfilename 	= 'SERVICE_FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;
	$prefix = '../../../';
	$newfile = 'assets/uploads/service_product/' . $newfilename;	
	move_uploaded_file($file_tmp,$prefix.$newfile);
	return $newfile;
}


function ipo_image_and_file_upload($file_name, $dir){
	$filename = $_FILES[$file_name]["name"];
	$file_tmp = $_FILES[$file_name]["tmp_name"];
	$file_ext = substr($filename, strripos($filename, '.'));
	$avater_name = 'IPO_FILES_DOCUMENT_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() ;
	$newfilenameup = '../../../assets/uploads/ipo/'.$dir.'/'.$avater_name. $file_ext;	
	$newfilename = 'assets/uploads/ipo/'.$dir.'/'.$avater_name.$file_ext;
	move_uploaded_file($file_tmp, $newfilenameup);
	return $newfilename;
}
function ipo_image_and_file_upload_multiple($filename,$file_tmp, $dir){
	$file_ext = substr($filename, strripos($filename, '.'));
	$avater_name = 'IPO_FILES_DOCUMENT_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() ;
	$newfilenameup = '../../../assets/uploads/ipo/'.$dir.'/'.$avater_name. $file_ext;	
	$newfilename = 'assets/uploads/ipo/'.$dir.'/'.$avater_name.$file_ext;
	move_uploaded_file($file_tmp, $newfilenameup);
	return $newfilename;
}






function spc_chr_mm($length) {
	$chars = "ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghjkmnopqrstuvwxyz234567890"; //!@#$%^&*+
	$clen   = strlen($chars) - 1;
	$id  = '';
	for ($i = 0; $i < $length; $i++) {
		$id .= $chars[mt_rand(0, $clen)];
	}
	return ($id);
}
function spc_chr_mm_v2($length) {
	$chars = "1234567890"; //!@#$%^&*+
	$clen   = strlen($chars) - 1;
	$id  = '';
	for ($i = 0; $i < $length; $i++) {
		$id .= $chars[mt_rand(0, $clen)];
	}
	return ($id);
}
// function main_email($subject,$message,$message_plane,$attachment,$send_to,$name){
// 	include("temp/PHPMailer/PHPMailerAutoload.php");
// 	$mail = new PHPMailer;
// 	$mail->isSMTP();
// 	$mail->Host = 'mail.superhomebd.com'; //mail.inv-bd.com
// 	$mail->SMTPAuth = true;
// 	$mail->Username = 'email@superhomebd.com'; //info@inv-bd.com //ibrahim@superhostelbd.com
// 	$mail->Password = '|#X7oNK,SqOA9'; //9HLpNSjcQfSO //2o(-e;ozqojV
// 	$mail->SMTPSecure = 'ssl';
// 	$mail->Port = 465;

// 	$mail->setFrom('info@superhome.com', 'SUPER HOME');
// 	$mail->addAddress($send_to, $name);
// 	$mail->addReplyTo('info@superhome.com', 'SUPER HOME');
// 	//$mail->addCC('cc@example.com');
// 	//$mail->addBCC('bcc@example.com');
// 	if(!empty($attachment)){
// 		$mail->addAttachment($attachment);         
// 	}
// 	$mail->isHTML(true);

// 	$mail->Subject = $subject;
// 	$mail->Body    = $message;
// 	$mail->AltBody = $message_plane;

// 	if($mail->send()) {
// 		return true;
// 	} else {
// 		return false;
// 	}
// }

function money($money, $curr = '1', $sym = 'BDT'){
	$money = (float)$money;
	if($money > 0){
		$money = number_format(($money / $curr), 0, '.', ',');
		$formetted = $sym.' '.$money;
		return $formetted;
	}else{
		$formetted = $sym.' 0.00';
		return $formetted;
	}	
}
function rahat_encode($data){
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function rahat_decode($data) {
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}
function rahat_url($string){
	$string=strip_tags($string);
	$string=preg_replace('/[^A-Za-z0-9-]+/', ' ', $string);
	$string=trim($string);
	$string=preg_replace('/[^A-Za-z0-9-]+/','-', $string);
	$slug=strtolower($string);
	return $slug;
}
function alert($type,$message){
		$_SESSION['message_time'] = time();
		$data = '
			<div class="alert toast bg-'.$type.' fade show alert-dismissible" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed;z-index: 99999;right: 41.7%;top: 43%;width: 332px;padding:0px;-webkit-box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);-moz-box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);">
				<div class="toast-header">
					<strong class="mr-auto"><b style="text-transform: capitalize;">'.$type.'!</b></strong>
					<small>System Message</small>
					<button data-dismiss="alert" type="button" class="ml-2 mb-1 close" aria-label="Close" style="padding: 0px;position: inherit;">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="toast-body">
					'.$message.'
				</div>
			</div>
			<script>
				window.setTimeout(function() {
					$(".alert").fadeTo(1500, 0).slideUp(1500, function(){
						$(this).remove(); 
					});
				}, 3000);
			</script>
		';
		$_SESSION['alert_message'] = $data;
	}
	
	function file_upload($file_name){
		$filename 		= $_FILES[$file_name]["name"];
		$file_tmp 		= $_FILES[$file_name]["tmp_name"];
		$file_ext 		= substr($filename, strripos($filename, '.'));
		$newfilename 	= $filename.'FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
		$newfile 		= 'assets/uploads/' . $newfilename;	
		move_uploaded_file($file_tmp,$newfile);
		return $newfile;
	}
	
	function file_upload_m($file_name,$tempname){
		$filename 		= $file_name;
		$file_tmp 		= $tempname;
		$file_ext 		= substr($filename, strripos($filename, '.'));
		$newfilename 	= $filename.'FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
		$newfile 		= 'assets/uploads/' . $newfilename;	
		move_uploaded_file($file_tmp,$newfile);
		return $newfile;
	}
	
	function image_upload($image_file, $image_width, $image_height, $image_quality){
		$image =$_FILES[$image_file]['name'];
		$image_tmp =$_FILES[$image_file]['tmp_name'];
		$ran = rand() * time() . '_' . time() * rand();
		if($image){
			$filename = stripslashes($image);
			$i = strrpos($filename,".");
			if(!$i){ 
				$filename = ''; 
			} 
			$l = strlen($filename) - $i;
			$filename = substr($filename,$i+1,$l);			
			$extension = strtolower($filename);
			if(($extension != 'jpg') && ($extension != 'jpeg') && ($extension != 'png') && ($extension != 'gif')){} else{
				$newname = 'IMAGE_'.date('d_m_Y').'_'.$ran.'.'.$extension;
				if($extension == 'jpg' || $extension == 'jpeg' ){
					$src = imagecreatefromjpeg($image_tmp);
				}else if($extension == 'png'){
					$src = imagecreatefrompng($image_tmp);
				}else{
					$src = imagecreatefromgif($image_tmp);
				}
				list($width, $height) = getimagesize($image_tmp);
				$newwidth = $image_width;
				$newheight = $image_height;
				$tmp = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				$post_file = 'assets/uploads/'.$newname;
				$image_file = 'assets/uploads/'.$newname;
				imagejpeg($tmp,$post_file, $image_quality);
				imagedestroy($src);
				imagedestroy($tmp);
			} 
		}
		return $image_file;
	}	
	
	//randon number generator function

	function spc_chr($length) {
		$chars = "!@#$%^&*+ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$clen   = strlen($chars) - 1;
		$id  = '';
		for ($i = 0; $i < $length; $i++) {
			$id .= $chars[mt_rand(0, $clen)];
		}
		return ($id);
	}
	function Numeric($length) {
		$chars = "1234567890";
		$clen   = strlen($chars) - 1;
		$id  = '';
		for ($i = 0; $i < $length; $i++) {
			$id .= $chars[mt_rand(0, $clen)];
		}
		return ($id);
	}
	function Alphabets($length) {
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$clen   = strlen($chars) - 1;
		$id  = '';
		for ($i = 0; $i < $length; $i++) {
			$id .= $chars[mt_rand(0, $clen)];
		}
		return ($id);
	}
	function AlphaNumeric($length) {
		$chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$clen   = strlen($chars) - 1;
		$id  = '';
		for ($i = 0; $i < $length; $i++) {
			$id .= $chars[mt_rand(0, $clen)];
		}
		return ($id);
	}
	function url_check($url) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_exec($ch);
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($code == 200) {
			$status = true;
		} else {
			$status = false;
		}
		curl_close($ch);
		return $status;
	}
//------------------------------------------------------------------------------------------
include('temp/datatable/index.php');
function current_url(){
	$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$validURL = str_replace("&","&amp","$url");
	return $validURL;
}
function date_converter($string){
	$date = explode('-',$string);
	return $date[2].'/'.$date[1].'/'.$date[0];
}
function uploader_info(){	
	return $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
}
function find_link($value, $protocols = array('http', 'mail'), array $attributes = array()) {
	$attr = '';
	foreach ($attributes as $key => $val) {
		$attr .= ' ' . $key . '="' . htmlentities($val) . '"';
	}        
	$links = array();
	$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
	foreach ((array)$protocols as $protocol) {
		switch ($protocol) {
			case 'http':
			case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\" target='_blank'>$link</a>") . '>'; }, $value); break;
			case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\" target='_blank'>{$match[1]}</a>") . '>'; }, $value); break;
			case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\" target='_blank'>{$match[0]}</a>") . '>'; }, $value); break;
			default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\" target='_blank'>{$match[1]}</a>") . '>'; }, $value); break;
		}
	}
	return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
}
function unique_array($my_array, $key) { 
    $result = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($my_array as $val){ 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $result[$i] = $val; 
        } 
        $i++;
    } 
    return $result;
}

function resize_image($file, $w, $h, $path, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
	// var_dump($width);
	// var_dump($height);
	$newwidth = 200;
    $ratio = 200 / imagesx($file);
	$newheight = imagesy($file) * $ratio;
    // if ($crop) {
    //     if ($width > $height) {
    //         $width = ceil($width-($width*abs($r-$w/$h)));
    //     } else {
    //         $height = ceil($height-($height*abs($r-$w/$h)));
    //     }
    //     $newwidth = $w;
    //     $newheight = $h;
    // } else {
    //     if ($w/$h > $r) {
    //         $newwidth = $h*$r;
    //         $newheight = $h;
    //     } else {
    //         $newheight = $w/$r;
    //         $newwidth = $w;
    //     }
    // }
    $src = imagecreatefrompng($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	imagepng($dst, $path);
	imagedestroy($dst);

    return $dst;
}

function time_full(){ return date("l, h:i:s A (d/m/Y)"); }
function data(){ return date("d/m/Y"); }
function ordinal($number) { $ends = array('th','st','nd','rd','th','th','th','th','th','th'); if ((($number % 100) >= 11) && (($number%100) <= 13)) { return $number. 'th'; } else { return $number. $ends[$number % 10]; } }
function get_client_ip() { $ipaddress = ''; if (isset($_SERVER['HTTP_CLIENT_IP'])){ $ipaddress = $_SERVER['HTTP_CLIENT_IP']; } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR']; } else if(isset($_SERVER['HTTP_X_FORWARDED'])) { $ipaddress = $_SERVER['HTTP_X_FORWARDED']; } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) { $ipaddress = $_SERVER['HTTP_FORWARDED_FOR']; } else if(isset($_SERVER['HTTP_FORWARDED'])) { $ipaddress = $_SERVER['HTTP_FORWARDED']; } else if(isset($_SERVER['REMOTE_ADDR'])) { $ipaddress = $_SERVER['REMOTE_ADDR']; } else { $ipaddress = 'UNKNOWN'; } return $ipaddress;  }
function getDeviceInfo() { $u_agent = $_SERVER['HTTP_USER_AGENT']; $bname = 'Unknown'; $platform = 'Unknown'; $version= ""; if (preg_match('/linux/i', $u_agent)) { $platform = 'linux'; } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac'; } elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows'; } if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { $bname = 'Internet Explorer'; $ub = "MSIE"; } elseif(preg_match('/Firefox/i',$u_agent)) { $bname = 'Mozilla Firefox'; $ub = "Firefox"; } elseif(preg_match('/Chrome/i',$u_agent)) { $bname = 'Google Chrome'; $ub = "Chrome"; } elseif(preg_match('/Safari/i',$u_agent)) { $bname = 'Apple Safari'; $ub = "Safari"; } elseif(preg_match('/Opera/i',$u_agent)) { $bname = 'Opera'; $ub = "Opera"; } elseif(preg_match('/Netscape/i',$u_agent)) { $bname = 'Netscape'; $ub = "Netscape"; } $known = array('Version', $ub, 'other'); $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#'; if (preg_match_all($pattern, $u_agent, $matches)) { } $i = count($matches['browser']); if ($i != 1) { if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){ $version= $matches['version'][0]; } else { $version= $matches['version'][1]; } } else { $version= $matches['version'][0]; } if ($version==null || $version=="") {$version="?";} return "Browser: " . $bname . " " . $version . ", Platform: " .$platform . ", Reports: " . $u_agent; }




