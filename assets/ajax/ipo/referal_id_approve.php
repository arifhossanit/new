<?php 
	include("../../../application/config/ajax_config.php");
	if(isset($_POST['aproval_id'])){
		$get_data = mysqli_fetch_assoc($mysqli->query("select * from ipo_referal_approval where id = '".$_POST['aproval_id']."'"));
		if(!empty($get_data)){
			if($mysqli->query("update member_directory set
				ipo_discount = 'A'
				where booking_id = '".$get_data['booking_id']."'
			")){
				if($mysqli->query("update ipo_referal_approval set
					aproval = '1'
					where id = '".$get_data['id']."'
				")){
					echo 'Aproved Successffully.';
				}else{
					echo 'Something wrong! Please try again';
				}
			}else{
				echo 'Something wrong! Please try again';
			}
		}else{
			echo 'Something wrong! Please try again';
		}
	}
?>