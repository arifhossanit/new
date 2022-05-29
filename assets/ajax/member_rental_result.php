<?php 
include("../../application/config/ajax_config.php");
if(isset($_POST['get_value'])){ $data = '';
	if(strlen($_POST['get_value']) > 7 ){
		$check_data = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number LIKE '".$_POST['get_value']."%' order by id desc limit 01"));
		if(!empty($check_data['id'])){
			$sql = $mysqli->query("select * from member_directory where card_number LIKE '".$_POST['get_value']."%' order by id desc limit 01");
			echo '<ul class="list-group">';
			while($row = mysqli_fetch_assoc($sql)){ 
				$data .= '<a onclick="return set_member_profile('.$row['id'].','.$row['card_number'].')" href="javascript:void(0)"><li class="list-group-item"><p style="width:80px;margin:0px;font-weight:bolder;color:#8a6363;float:left">'.$row['card_number'].'</p> - '.$row['full_name'].'</li></a>';
			} 
			$data .= '</ul>';
			$member_id = $check_data['id'];
			$image_vatar = $home.$check_data['photo_avater'];
			$card_number = $check_data['card_number'];
		} else { 
			$data .= '
				<center style="Font-weight:bolder;color:red;">
					No Match Found!
				<center>
			';
			$member_id = '0';
			$image_vatar = '0';
			$card_number = '';
		} 
	} else{
		$data .= '
			<center style="Font-weight:bolder;color:red;">
				8 Character Required! For Result
			<center>
		';
		$member_id = '0';
		$image_vatar = '0';
		$card_number = '';
	}
	echo $data.'***'.$member_id.'***'.$image_vatar.'***'.$card_number;
}	
?>