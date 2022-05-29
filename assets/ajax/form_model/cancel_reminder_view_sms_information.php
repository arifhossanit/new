<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['sms_id'])){ 
	$sms = mysqli_fetch_assoc($mysqli->query("select * from cancel_reminder where id = '".$_POST['sms_id']."'"));
	$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$sms['booking_id']."'"));

?>
<div class="row">
	<div class="col-sm-12">
		<div style="text-align:left;padding:15px;">	
			Time: <b> <?php echo $sms['message_time']; ?></b><br />
			TO: <b><?php echo $sms['number']; ?></b> <br />
			Name: <b><?php if(!empty($member['full_name'])){ echo $member['full_name']; } else{ echo 'Not found!';} ?></b> <br />		
			Branch: <b><?php if(!empty($member['branch_name'])){ echo $member['branch_name']; } else{ echo 'Not found!';} ?></b> <br />		
			Card: <b><?php if(!empty($member['card_number'])){ echo $member['card_number']; } else{ echo 'Not found!';} ?></b> <br />		
		</div>
	</div>
	<hr style="margin:0px;padding:0px;border:solid 0.5px #eee;width:100%;"/>
	<div class="col-sm-12">			
		<blockquote>
			<?php
				echo find_link($sms['message']);
			?>
		</blockquote>
	</div>
</div>
<?php } ?>