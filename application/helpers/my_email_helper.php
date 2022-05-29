<?php defined('BASEPATH') OR exit('No direct script access allowed.');
include('email_template/emp_login.php');
include('email_template/bk_details.php');
include('email_template/booking_details_template.php');
function main_email($subject,$message,$message_plane,$attachment,$send_to,$name){
	return true;
	include_once APPPATH . 'third_party/PHPMailer/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'mail.superhomebd.com'; //mail.inv-bd.com
	$mail->SMTPAuth = true;
	$mail->Username = 'email@superhomebd.com'; //info@inv-bd.com
	$mail->Password = '|#X7oNK,SqOA9'; //9HLpNSjcQfSO
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	$mail->setFrom('info@superhomebd.com', 'SUPER HOME');
	$mail->addAddress($send_to, $name);
	$mail->addReplyTo('info@superhomebd.com', 'SUPER HOME');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');
	if(!empty($attachment)){
		$mail->addAttachment($attachment);         
	}
	$mail->isHTML(true);

	$mail->Subject = $subject;
	$mail->Body    = $message;
	$mail->AltBody = $message_plane;

	if($mail->send()) {
		return true;
	} else {
		return false;
	}
}