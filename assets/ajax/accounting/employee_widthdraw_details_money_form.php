<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from employee_aproved_widthdraw_money_logs where request_id = '".$_POST['profile_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-bordered">
			<tr><td>Date:</td><td><?php echo $row['data']; ?></td></tr>
			<tr><td>Amount:</td><td><?php echo money($row['amount']); ?></td></tr>
			<tr><td>Receiver Info:</td>
				<td>
					<?php
						echo $row['payment_method']; 
					?>			
				</td>
			</tr>
		</table>
	</div>
</div>
<?php } ?>