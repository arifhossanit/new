<?php
include("../../../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from employee_everyday_withdraw_logs where id = '".$_POST['view_id']."'"));

?>
<div class="row">
	<div class="col-sm-12">
		<b>Requested Withdraw leave Info</b><br />
		<span><?php echo $row['leave_info']; ?></span>
		<hr />
		<b>Requested Withdraw dates:</b><br />
		<ul>
		<?php
			$dats = explode(',',$row['withdraw_dates']);
			foreach($dats as $date){
				echo '<li>'.$date.'</li>';
			}
		?>
		</ul>
		<hr />
		<b>Requested date:</b><br />
		<?php echo $row['data']; ?>
		<hr />
		<b>Requested By:</b><br />
		<?php 
			$email = explode('___',$row['uploader_info']);
			$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$email[1]."'"));
			echo $emp['full_name'].' - '.$emp['employee_id'];
		?>
	</div>
</div>
<?php } ?>