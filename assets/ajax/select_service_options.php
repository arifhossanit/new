<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$branch_id = $_POST['view_id'];
	$sql = $mysqli->query("select * from services where branch_id = '".$branch_id."'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['service_name'].'">'.$row['service_name'].'</option>';
		}
	}
}
?>