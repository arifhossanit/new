<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['bed_id'])){
	$bed_id = $_POST['bed_id'];
	$row = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$bed_id."'"));
	$rrow = mysqli_fetch_assoc($mysqli->query("select * from rooms where id = '".$row['room_id']."'"));
	$category = $mysqli->query("select * from room_type where branch_id = '".$rrow['branch_id']."'");
	$categ = '';
	while($wert = mysqli_fetch_assoc($category)){
		$categ .= "'".$wert['id']."',";
	}
	$fin_ctg = rtrim($categ, ",");
	$check_room_type = mysqli_fetch_assoc($mysqli->query("select * from room_type where package_category IN(".$fin_ctg.") AND status = '1'"));
	if(!empty($check_room_type)){
		$rt_data = '<option value="">select</option>';
		$room_type = $mysqli->query("select * from room_type where package_category IN(".$fin_ctg.") AND status = '1'");
		while($rtype = mysqli_fetch_assoc($room_type)){
			if($rrow['room_type'] == $rtype['room_type'] ){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$rt_data .= '<option value="'.$rtype['room_type'].'" '.$selected.'>'.$rtype['room_type'].'</option>';
		}
	}else{
		$rt_data = '<option value="">select</option>';
	}	
	echo $row['id'].'_'.$row['bed_name'].'_'.$rt_data;
}
?>