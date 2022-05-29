<?php 
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['profile_id']."'"));
$details = mysqli_fetch_assoc($mysqli->query("select * from return_diposit_money where booking_id = '".$row['booking_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-bordered">
			<tr><td>Date:</td><td><?php echo $details['data']; ?></td></tr>
			<tr><td>Amount:</td><td><?php echo money($details['amount']); ?></td></tr>
			<tr><td>Payment Method:</td>
				<td>
					<?php echo $details['payment_method']; ?>			
				</td>
			</tr>
		</table>
	</div>
	<div class="col-sm-12">
		<b style="color:#f00;font-weight:bolder;">Note: <?php if(!empty($details['note'])){ echo $details['note']; }else{ echo 'General Cancel'; } ?></b>
	</div>
</div>
<?php } ?>