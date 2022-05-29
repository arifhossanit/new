<?php
	include("../../application/config/ajax_config.php");
	if(isset($_GET['user_id'])){
		$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$_GET['user_id']."'"));
		header('Content-Type: text/x-vcard');  
		header('Content-Disposition: inline; filename= "'.rahat_url($emp['full_name']).'.vcf"');  
		$image = $home.$emp['photo'];
		if($image != "" ){ 
			$getPhoto               = file_get_contents($image);
			$b64vcard               = base64_encode($getPhoto);
			$b64mline               = chunk_split($b64vcard,74,"\n");
			$b64final               = preg_replace('/(.+)/', ' $1', $b64mline);
			$photo                  = $b64final;
		}
		$vCard = "BEGIN:VCARD\r\n";
		$vCard .= "VERSION:3.0\r\n";
		$vCard .= "FN:" . $emp['full_name'] . "\r\n";
		$vCard .= "TITLE: Neways International\r\n";
		if($emp['email']){
			$vCard .= "EMAIL;TYPE=internet,pref:" . $emp['email'] . "\r\n";
		}
		if($getPhoto){
			$vCard .= "PHOTO;ENCODING=b;TYPE=JPEG:";
			$vCard .= $photo . "\r\n";
		}
		if($emp['personal_Phone']){
			$vCard .= "TEL;TYPE=work,voice:" . $emp['personal_Phone'] . "\r\n"; 
		}
		$vCard .= "END:VCARD\r\n";
		echo $vCard;
	}
?>