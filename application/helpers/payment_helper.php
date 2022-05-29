<?php defined('BASEPATH') OR exit('No direct script access allowed.');
// include("../../../application/config/ajax_config.php");

function payment_varient($tnsid,$branch_id,$booking_id,$payment_method,$payment_details,$card_amount,$cash_amount,$mobile_amount,$check_amount,$uploader_info,$table){
	global $mysqli;
	global $db;
	// $invoice_id = mysqli_fetch_assoc($mysqli->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db."' AND TABLE_NAME = '".$table."'"));
	$ci =& get_instance();
	$ci->load->database();

	$ci->db->query("insert into payment_received_method values(
		'',
		'".$ci->db->escape_str($tnsid)."',
		'".$ci->db->escape_str($branch_id)."',
		'".$ci->db->escape_str($booking_id)."',
		'".$ci->db->escape_str($payment_method)."',
		'".$ci->db->escape_str($payment_details)."',
		'".$ci->db->escape_str($card_amount)."',
		'".$ci->db->escape_str($cash_amount)."',
		'".$ci->db->escape_str($mobile_amount)."',
		'".$ci->db->escape_str($check_amount)."',
		'',
		'',
		'1',
		'".$ci->db->escape_str($uploader_info)."',
		'".date('d/m/Y')."'
	)");	
}