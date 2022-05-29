<?php 
include("../../../../application/config/ajax_config.php");
if(isset($_POST['get_date'])){
	if(!empty($_POST['get_date'])){
		if($mysqli->query("INSERT INTO details_report_deduction_logs VALUES(
			'',
			'".$_POST['get_date']."',
			'".$_POST['branch_id']."',
			'".$_POST['amount']."',
			'".$_POST['adj_type']."',
			'".$_POST['head_type']."',
			'".$_POST['note']."',
			'1',
			'".uploader_info()."',
			'".date('d/m/Y')."'
		)")){
			echo 'Information Saved Sucessfully!';
		}else{
			echo 'Something Wrong! Please Try again.';
		}
	}else{
		echo 'Monthly Date Not found! Please Try again.';
	}	
}
?>