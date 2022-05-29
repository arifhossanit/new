<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_widthdraw_request where id = '".$_POST['profile_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-bordered">
			<tr><td>Date:</td><td><?php echo $row['data']; ?></td></tr>
			<tr><td>Amount:</td><td><?php echo money($row['amount']); ?></td></tr>
			<tr><td>Receiver Info:</td>
				<td>
					<?php
						if($row['widthdraw_method'] == 'Mobile Banking'){
							echo '
								<b>Received By: </b>'.$row['payment_received_by'].'<br />
								<b>Widthdraw Method: </b>'.$row['widthdraw_method'].'<br />
								<b>Media: </b>'.$row['mobile_banking'].'<br />
								<b>Receiver Number: </b>'.$row['receiver_number'].'
							';
						}else if($row['widthdraw_method'] == 'Bank'){
							echo '
								<b>Received By: </b>'.$row['payment_received_by'].'<br />
								<b>Widthdraw Method: </b>'.$row['widthdraw_method'].'<br />
								<b>Bank Name: </b>'.$row['bank_name'].'<br />
								<b>Account holder Name: </b>'.$row['account_holder_name'].'<br />
								<b>Account Number: </b>'.$row['account_number'].'
							';
						}else if($row['widthdraw_method'] == 'Chequee'){
							echo '
								<b>Received By: </b>'.$row['payment_received_by'].'<br />
								<b>Widthdraw Method: </b>'.$row['widthdraw_method'].'<br />
								<b>Receiver Name: </b>'.$row['receiver_name'].'
							';
						}else{
							echo '
								<b>Received By: </b>'.$row['payment_received_by'].'<br />
								<b>Widthdraw Method: </b>'.$row['widthdraw_method'].'
							';
						}
					?>			
				</td>
			</tr>
		</table>
	</div>
</div>
<?php } ?>