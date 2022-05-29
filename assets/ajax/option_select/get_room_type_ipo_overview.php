<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['branch_id'])){	
	$id = $_POST['branch_id'];
		echo '<option value="1">All</option>';	
	$sql = $mysqli->query("select * from ipo_category where branch_id = '".$id."' and status = '1'");
	while($row = mysqli_fetch_assoc($sql)){
		if(!empty($row['id'])){
			echo '<option value="'.$row['category_name'].'">'.$row['category_name'].'</option>';
		}
	}
}
?>