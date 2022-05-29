<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['ipo_shifting_change_token'])){
$mem_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where id = '".$_POST['member_id']."'"));
	if(empty($mem_info['card_number'])){
		echo 'Member Unathorized! Please Try again.____1';
	}else{
		$new_bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$_POST['new_bed_id']."'"));
		$old_bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$_POST['old_bed_id_agrement']."'"));
		$agr_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_agreement_information where id = '".$_POST['old_agrement_id']."'"));
		if($mysqli->query("update ipo_agreement_information set
			branch_id = '".$new_bed['branch_id']."',
			branch_name = '".$new_bed['branch_name']."',
			floor_id = '".$new_bed['floor_id']."',
			floor_name = '".$new_bed['floor_name']."',
			unit_id = '".$new_bed['unit_id']."',
			unit_name = '".$new_bed['unit_name']."',
			room_id = '".$new_bed['room_id']."',
			room_name = '".$new_bed['room_name']."',
			bet_id = '".$new_bed['bet_id']."',
			bed_name = '".$new_bed['bed_name']."'
			where id = '".$agr_info['id']."'
		")){
			if($mysqli->query("insert into ipo_bed_shift_logs values(
				'',
				'".$mem_info['ipo_id']."',
				'".$agr_info['purses_code']."',
				'".$old_bed['id']."',
				'".$new_bed['id']."',
				'1',
				'".$_POST['note']."',
				'".uploader_info()."',
				'".date('d/m/Y')."'
			)")){
				echo 'Successfeully bed Changed.____0';
			}else{
				echo 'Something Wrong! Please Try again.____1';
			}
		}else{
			echo 'Something Wrong! Please Try again.____1';
		}
		
	}
}
?>