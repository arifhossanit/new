<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$id = $_POST['view_id'];
	$o_id = $_POST['old_package'];
	$old_pack = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$o_id."'"));
		echo '<option value="">select</option>';
	$sql = $mysqli->query("select * from packages where package_category_id = '".$id."' AND package_days >= ".$old_pack['package_days']);
	// $sql = $mysqli->query("select * from packages where package_category_id = '".$id."'");
	$optionss = '';
	
	while($row = mysqli_fetch_assoc($sql)){
		$price = $row['package_price'] - $old_pack['package_price'];
		$option = 'style="font-weight:bolder;"';
		if($old_pack['package_price'] <= $row['package_price']){				
			$gd_test = '0';
		}else{
			$option = ''; //disabled
			//$price = '0';
			$gd_test = '1';
		}
		$optionss .= '<option value="'.$row['id'].'____'.$price.'____'.$gd_test.'" '.$option.'>'.$row['package_name'].'</option>';
	}
	echo $optionss;
}
?>