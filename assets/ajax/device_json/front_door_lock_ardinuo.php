<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['door_open'])){
	$ip_address = $_POST['ip_address'];
	$ch = curl_init(); 
	$ret = curl_setopt($ch, CURLOPT_URL,            "http://".$ip_address);
	$ret = curl_setopt($ch, CURLOPT_HEADER,         1);
	$ret = curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ret = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
	$ret = curl_setopt($ch, CURLOPT_TIMEOUT,        30);
	$ret = curl_exec($ch);
	if (empty($ret)) {
		echo 'code____false____0';
		curl_close($ch);
	} else {
		$info = curl_getinfo($ch);
		curl_close($ch);
		if (empty($info['http_code'])) {
			echo 'code____false____0';
		} else {
			$link = 'http://'.$ip_address.'?door_open';
			$url = $link;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, false);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$output = curl_exec($ch);
			curl_close($ch);
			if(!empty($ch)){
				echo 'code____success____'.$_POST['door_open'];
			}else{
				echo 'code____false____0';
			}
		}
	}	
}
?>