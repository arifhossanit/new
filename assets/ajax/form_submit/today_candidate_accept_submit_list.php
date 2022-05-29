<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['hidden_id'])){
	$get_info = mysqli_fetch_assoc($mysqli->query("select * from visitor_book where id = '".$_POST['hidden_id']."'"));
	$mark = $_POST['star_mark'];
	$branch = $get_info['branch_id'];
	$name = $get_info['name'];
	$phone = $get_info['phone'];
	$department = $get_info['department'];
	$designation = $get_info['designation'];
	if(!empty($_POST['note'])){
		$note = $_POST['note'];
	}else{
		$note = '';
	}	
	if(!empty($_SESSION['super_admin']['email'])){
		$uploader_info = $_SESSION['super_admin']['email'];
	}else{
		$uploader_info = '';
	}
	$id = $get_info['id'];
	if($mysqli->query("INSERT INTO candidate_short_list VALUES(
		'',
		'".$branch."',
		'".$name."',
		'".$phone."',
		'".$department."',
		'".$designation."',
		'".$mark."',
		'".$note."',
		'1',
		'".$uploader_info."',
		'".date('d/m/Y')."'
	)")){
		if($mysqli->query("UPDATE visitor_book SET
			status = '2'
			WHERE id = '".$id."'
		")){
			echo '<p style="color:green;margin: 0px; position: absolute;">Successfully send to short list</p>';
		}else{
			echo '<p style="color:#f00;margin: 0px; position: absolute;">Something wrong In DATABASE 2 Please try again</p>';
		}
	}else{
		echo '<p style="color:#f00;margin: 0px; position: absolute;">Something wrong In DATABASE 1 Please try again</p>';
	}
}
?>