<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	if(!empty($_POST['selected_package_category_id'])){
		$selected_package_category_id = $_POST['selected_package_category_id'];
	}else{
		$selected_package_category_id = '';
	}
	$branch_id = $_POST['view_id'];
	echo '<option value="">select</option>';
	if(isset($_POST['selected_package_days'])){
		$sql = $mysqli->query("SELECT packages_category.* from packages_category INNER JOIN packages on packages.package_category_id = packages_category.id where packages_category.branch_id = '".$branch_id."' AND packages.package_days >= ".$_POST['selected_package_days']." and packages_category.status='1' GROUP BY packages_category.id");
	}else{
		$sql = $mysqli->query("SELECT packages_category.* from packages_category where branch_id = '".$branch_id."' and status='1'");
	}
	
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			if($row['id'] == $selected_package_category_id){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			echo '<option value="'.$row['id'].'" '.$selected.'>'.$row['package_category_name'].'</option>';
		}
	}
}
?>