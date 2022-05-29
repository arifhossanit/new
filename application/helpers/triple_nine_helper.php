<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function isJson($string) {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}

function helper_check(){
	if(1==1){
		return true;
	}else{
		return false;
	}
}

function curl_request($method,$url,$fields=NULL,$api_key=NULL)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 
		'Authorization: Basic ' . $key));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	if ($method=='post') {
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	}else{
		curl_setopt($ch, CURLOPT_POST, FALSE);
	}
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

	$response = curl_exec($ch);
	curl_close($ch);
	// echo "notification helper";
};