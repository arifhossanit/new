<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	if(isset($_POST['selected_package_id'])){
		$selected_package_id = $_POST['selected_package_id'];
	}else{
		$selected_package_id = '';
	}
	$id = $_POST['view_id'];
		echo '<option value="">select</option>';
	$sql = $mysqli->query("select * from packages where package_category_id = '".$id."'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			if($selected_package_id == $row['id']){
				echo '<option value="'.$row['id'].'" selected>'.$row['package_name'].'</option>';
			}else{
				echo '<option value="'.$row['id'].'">'.$row['package_name'].'</option>';				
			}
		}
	}
}

if(isset($_POST['category_by_id'])){
	if($_POST['category_by_id'] == '1'){
		$where = " where status = '1'";		
	}else{
		$where = " where branch_id = '".rahat_decode($_POST['category_by_id'])."' and  status = '1'";
	}
	echo '<option value="">All</option>';
	$sql = $mysqli->query("select * from packages_category $where");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['id'].'">'.$row['package_category_name'].'</option>';
		}
	}
}
?>