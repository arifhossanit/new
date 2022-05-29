<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['pc_ctg_id'])){
	$data = '';
	$data .= '<option>--select--</option>';
	$room_type = mysqli_fetch_assoc($mysqli->query("select * from room_type where package_category = '".$_POST['pc_ctg_id']."'"));
	
	$sql = $mysqli->query("select * from packages where package_category_id = '".$_POST['pc_ctg_id']."' and status = '1'");
	while($row = mysqli_fetch_assoc($sql)){
		$data .= '<option value="'.$row['id'].'">'.$row['package_name'].'</option>';
	}
	$data .= '____'.$room_type['room_type'];
	echo $data;
}
?>