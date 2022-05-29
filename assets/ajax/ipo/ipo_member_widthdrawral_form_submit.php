<?php 
	include("../../../application/config/ajax_config.php");
	if(isset($_POST['ipo_id'])){
		$get_data = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$_POST['ipo_id']."' and status = '1'"));
		$check_balance = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_balance where ipo_id = '".$get_data['ipo_id']."'"));
		if(!empty($get_data['ipo_id'])){
			if($check_balance['balance'] >= $_POST['amount']){
				if( 1000 <= $_POST['amount'] ){
					if($get_data['password'] == $_POST['password']){
						$check_pending = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_widthdraw_request where ipo_id = '".$get_data['ipo_id']."' and status = '1'"));
						if(!empty($check_pending['ipo_id'])){
							echo 'Sorry! you can`t send any request before your pending request are not aproved. Please try it later';
						}else{
							if($mysqli->query("insert into ipo_member_widthdraw_request values(
								'',
								'".$get_data['ipo_id']."',
								'".$_POST['amount']."',
								'".$_POST['payment_received_by']."',
								'".$_POST['widthdraw_method']."',
								'".$_POST['mobile_media']."',
								'".$_POST['receiver_number']."',
								'".$_POST['bank_name']."',
								'".$_POST['account_holder_name']."',
								'".$_POST['account_number']."',
								'".$_POST['receiver_name']."',
								'".$_POST['note']."',
								'1',
								'".$get_data['personal_email']."',
								'".date('d/m/Y')."'
							)")){
								echo 'Request Successfully Sended.';
							}else{
								echo 'Something Wrong! Please try again.';
							}
						}						
					}else{
						echo 'Your user password is wrong! Please try again.';
					}
				}else{
					echo 'You Can`t widthdraw under BDT 9026! Please try again.';
				}
			}else{
				echo 'You Don`t have enough balance! Please try again.';
			}
		}else{
			echo 'Your IPO ID not found! Please try again.';
		}
	}
?>