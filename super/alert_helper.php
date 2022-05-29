<?php
	
	
	
	function alert($type,$message){
		$_SESSION['message_time'] = time();
		$data = '
			<div class="alert toast bg-'.$type.' fade show alert-dismissible" role="alert" aria-live="assertive" aria-atomic="true" style="position: fixed;z-index: 99999;right: 0.7%;top: 1%;width: 332px;padding:0px;-webkit-box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);-moz-box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);box-shadow: 0px 0px 7px 1px rgba(0,0,0,0.75);">
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
				}, 4000);
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
	
	function file_upload_ta_da($file_name){
		$filename 		= $_FILES[$file_name]["name"];
		$file_tmp 		= $_FILES[$file_name]["tmp_name"];
		$file_ext 		= substr($filename, strripos($filename, '.'));
		$newfilename 	= md5($filename).'_FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
		$newfile 		= 'assets/uploads/ta_da_attachment/' . $newfilename;	
		move_uploaded_file($file_tmp,$newfile);
		return $newfile;
	}
	
	function file_upload_food_menue($file_name){
		$filename 		= $_FILES[$file_name]["name"];
		$file_tmp 		= $_FILES[$file_name]["tmp_name"];
		$file_ext 		= substr($filename, strripos($filename, '.'));
		$newfilename 	= $filename.'FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
		$newfile 		= 'assets/uploads/food_menue/' . $newfilename;	
		move_uploaded_file($file_tmp,$newfile);
		return $newfile;
	}
	
	function file_upload_m($file_name,$tempname){
		$filename 		= $file_name;
		$file_tmp 		= $tempname;
		$file_ext 		= substr($filename, strripos($filename, '.'));
		$newfilename 	= $filename.'FILES_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
		$newfile 		= 'assets/uploads/other_document/petty_cash/' . $newfilename;	
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
		
	function image_upload_dir($image_file, $image_width, $image_height, $image_quality, $image_directory){
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
				$post_file = 'assets/uploads/'.$image_directory.$newname;
				$image_file = 'assets/uploads/'.$image_directory.$newname;
				imagejpeg($tmp,$post_file, $image_quality);
				imagedestroy($src);
				imagedestroy($tmp);
			} 
		}
		return $image_file;
	}
	
	//randon number generator function

	function spc_chr($length) {
		$chars = "!@#$%^&*+ABCDEFGHJKMNOPQRSTUVWXYZabcdefghjkmnopqrstuvwxyz1234567890";
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
	function sendsms_multitle($numbers, $message_body){   //&number=%2B88'.$number.'	 
		return true;	
		$apikey = 'e61022bacbd3b3213716f2295b70de8e44992fb9';
		//$apikey = 'baee927bf84af59e7e4dacdf4a9ece0112b7b66c';  //SariIT
		$device = '19|0'; // 13|1 //10|1  //1  //867|0
		$api_params = '?key='.$apikey.$numbers.'&message='.urlencode($message_body).'&devices='.$device;  
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
		   //echo $output =  file_get_contents($smsgatewaydata); 
			return true;
		}else{
			return false;
		}
	}

	
	function sendsms($number, $message_body){ 
		$mysqli->query("INSERT INTO sms_logs VALUES('','".$mysqli->real_escape_string($number)."','".$mysqli->real_escape_string($message_body)."','".$mysqli->real_escape_string(date("l"))."','".$mysqli->real_escape_string(date("h:i:s"))."','".$mysqli->real_escape_string(date("a"))."','".$mysqli->real_escape_string(date("d/m/Y"))."')");
		return true;
		$phnP_n = strlen($number);		
		if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
		$apikey = 'e61022bacbd3b3213716f2295b70de8e44992fb9';  
		//$apikey = 'baee927bf84af59e7e4dacdf4a9ece0112b7b66c';  //SariIT
		$device = '18|0';
		//$device = '19|0'; 
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
			/* CONFIGURATION */
			$CI =& get_instance(); $CI->load->database(); $mysqli = new mysqli($CI->db->hostname, $CI->db->username, $CI->db->password, $CI->db->database);
			$mysqli->query("INSERT INTO sms_logs VALUES('','".$mysqli->real_escape_string($number)."','".$mysqli->real_escape_string($message_body)."','".$mysqli->real_escape_string(date("l"))."','".$mysqli->real_escape_string(date("h:i:s"))."','".$mysqli->real_escape_string(date("a"))."','".$mysqli->real_escape_string(date("d/m/Y"))."')");
		    /* =============== */
		   //echo $output =  file_get_contents($smsgatewaydata); 
			return true; }else{ return false; }
	}
	
	function otp_sendsms($number, $message_body){
		return true;	
		$phnP_n = strlen($number);		
		if($phnP_n == '14'){ $number = substr($number,'4'); }else if($phnP_n == '11'){ $number = substr($number,'1'); }else{ $number = $number; }	
		$apikey = 'e61022bacbd3b3213716f2295b70de8e44992fb9';   
		$device = '19|0'; //'16|1';
		$api_params = '?key='.$apikey.'&number=%2B880'.$number.'&message='.urlencode($message_body).'&devices='.$device;  
		$smsGatewayUrl = "https://sms.bapbeta.com/services/send.php";  
		$smsgatewaydata = $smsGatewayUrl.$api_params;
		$url = $smsgatewaydata;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);                         
		if(!empty($output)){
			/* CONFIGURATION */
			$CI =& get_instance(); $CI->load->database(); $mysqli = new mysqli($CI->db->hostname, $CI->db->username, $CI->db->password, $CI->db->database);
			$mysqli->query("INSERT INTO sms_logs VALUES('','".$mysqli->real_escape_string($number)."','".$mysqli->real_escape_string($message_body)."','".$mysqli->real_escape_string(date("l"))."','".$mysqli->real_escape_string(date("h:i:s"))."','".$mysqli->real_escape_string(date("a"))."','".$mysqli->real_escape_string(date("d/m/Y"))."')");
		    /* =============== */
		   //echo $output =  file_get_contents($smsgatewaydata); 
			return true; }else{ return false; }
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
	
	function file_upload_member_edit($file_name,$tempname){
		$filename 		= $file_name;
		$file_tmp 		= $tempname;
		$file_ext 		= substr($filename, strripos($filename, '.'));
		$newfilename 	= 'EDIT_FILES_DOCUMENT_MEMBER_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() . $file_ext;	
		$newfile 		= 'assets/uploads/member/member_document/' . $newfilename;	
		$newfileup 		= '../../assets/uploads/member/member_document/' . $newfilename;	
		move_uploaded_file($file_tmp,$newfileup);
		return $newfile;
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
	function unique_array($my_array, $key) { 
		$result = array(); 
		$i = 0; 
		$key_array = array(); 
		
		foreach($my_array as $val) { 
			if (!in_array($val[$key], $key_array)) { 
				$key_array[$i] = $val[$key]; 
				$result[$i] = $val; 
			} 
			$i++; 
		} 
		return $result; 
	}
	function uploader_info(){	
		return $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch'];
	}
	
	function notification($n_header, $n_message, $n_links, $n_user_type, $n_sender, $n_user_id = '', $n_user_id_multi = ''){
		$CI =& get_instance(); 
		$CI->load->database(); 
		$mysqli = new mysqli($CI->db->hostname, $CI->db->username, $CI->db->password, $CI->db->database);
		
		if(!empty($n_user_id_multi)){
			$return = 1;
			foreach($n_user_id_multi as $row){ 
				if($mysqli->query("INSERT INTO notification VALUES( 
					'', 
					'".$mysqli->real_escape_string($row)."', 
					'".$mysqli->real_escape_string($n_user_type)."', 
					'".$mysqli->real_escape_string($n_header)."', 
					'".$mysqli->real_escape_string($n_message)."', 
					'".$mysqli->real_escape_string($n_links)."', 
					'".$mysqli->real_escape_string(date('h:i:s a'))."', 
					'".$mysqli->real_escape_string(date('d/m/Y'))."', 
					'".$mysqli->real_escape_string(time())."', 
					'".$mysqli->real_escape_string(1)."', 
					'".$mysqli->real_escape_string($n_sender)."' 
				)")){ 
					$return = 1; 
				}else{ 
					$return = 0; 
				} 
			} 
			if($return == 1){ 
				return true; 
			}else{ 
				return false; 
			}
		}else{
			if($mysqli->query("INSERT INTO notification VALUES( 
				'', 
				'".$mysqli->real_escape_string($n_user_id)."', 
				'".$mysqli->real_escape_string($n_user_type)."', 
				'".$mysqli->real_escape_string($n_header)."', 
				'".$mysqli->real_escape_string($n_message)."', 
				'".$mysqli->real_escape_string($n_links)."', 
				'".$mysqli->real_escape_string(date('h:i:s a'))."', 
				'".$mysqli->real_escape_string(date('d/m/Y'))."', 
				'".$mysqli->real_escape_string(time())."', 
				'".$mysqli->real_escape_string(1)."', 
				'".$mysqli->real_escape_string($n_sender)."' 
			)")){ 
				return true; 
			}else{ 
				return false; 
			}
		}
	}
	function data(){ return date("d/m/Y"); }
	function time_full() { return date("l, h:i:s A (d/m/Y)"); }	
	function get_client_ip() { $ipaddress = ''; if (isset($_SERVER['HTTP_CLIENT_IP'])){ $ipaddress = $_SERVER['HTTP_CLIENT_IP']; } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR']; } else if(isset($_SERVER['HTTP_X_FORWARDED'])) { $ipaddress = $_SERVER['HTTP_X_FORWARDED']; } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) { $ipaddress = $_SERVER['HTTP_FORWARDED_FOR']; } else if(isset($_SERVER['HTTP_FORWARDED'])) { $ipaddress = $_SERVER['HTTP_FORWARDED']; } else if(isset($_SERVER['REMOTE_ADDR'])) { $ipaddress = $_SERVER['REMOTE_ADDR']; } else { $ipaddress = 'UNKNOWN'; } return $ipaddress;  }
	function getDeviceInfo() { $u_agent = $_SERVER['HTTP_USER_AGENT']; $bname = 'Unknown'; $platform = 'Unknown'; $version= ""; if (preg_match('/linux/i', $u_agent)) { $platform = 'linux'; } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac'; } elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows'; } if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { $bname = 'Internet Explorer'; $ub = "MSIE"; } elseif(preg_match('/Firefox/i',$u_agent)) { $bname = 'Mozilla Firefox'; $ub = "Firefox"; } elseif(preg_match('/Chrome/i',$u_agent)) { $bname = 'Google Chrome'; $ub = "Chrome"; } elseif(preg_match('/Safari/i',$u_agent)) { $bname = 'Apple Safari'; $ub = "Safari"; } elseif(preg_match('/Opera/i',$u_agent)) { $bname = 'Opera'; $ub = "Opera"; } elseif(preg_match('/Netscape/i',$u_agent)) { $bname = 'Netscape'; $ub = "Netscape"; } $known = array('Version', $ub, 'other'); $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#'; if (preg_match_all($pattern, $u_agent, $matches)) { } $i = count($matches['browser']); if ($i != 1) { if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){ $version= $matches['version'][0]; } else { $version= $matches['version'][1]; } } else { $version= $matches['version'][0]; } if ($version==null || $version=="") {$version="?";} return "Browser: " . $bname . " " . $version . ", Platform: " .$platform . ", Reports: " . $u_agent; }
	function date_converter($string){
		$date = explode('-',$string);
		return $date[2].'/'.$date[1].'/'.$date[0];
	}


	
?>