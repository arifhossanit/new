<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['book_id'])){ 
	if($_POST['book_id'] == 12){
		$laset_days = ((int)$_POST['book_id'] * 30) + 5;
	}else{
		$laset_days = (int)$_POST['book_id'] * 30;
	}	
	$today = date('Y-m-d');
	$_days_before = date('Y-m-d', strtotime(date('Y/m/d'). ' - '.$laset_days.' days'));
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-sm">
			<thead>
				<tr>
					<th>Branch Name</th>
					<th>Investigation Days</th>
					<th>Checkin</th>
					<th>Checkout</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sql = $mysqli->query("select * from branches where status = '1'");
	while($row = mysqli_fetch_assoc($sql)){
		$today_booking = mysqli_fetch_assoc($mysqli->query("select count(*) as total_checkin from booking_info where branch_id = '".$row['branch_id']."' and STR_TO_DATE(checkin_date,'%d/%m/%Y') BETWEEN '$_days_before' AND '$today'"));
		$today_checkout = mysqli_fetch_assoc($mysqli->query("select count(*) as total_checkout from booking_info where branch_id = '".$row['branch_id']."' and STR_TO_DATE(checkout_date,'%d/%m/%Y') BETWEEN '$_days_before' AND '$today'"));
		$comming = $today_booking['total_checkin'];
		$going = $today_checkout['total_checkout'];
		
		$try_us_in = 0;
		$member_us_in = 0;
		$check_in = $mysqli->query("select * from booking_info where branch_id = '".$row['branch_id']."' and STR_TO_DATE(checkin_date,'%d/%m/%Y') BETWEEN '$_days_before' AND '$today'");
		while($in_row = mysqli_fetch_assoc($check_in)){
			$check_package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$in_row['package']."'"));
			if($check_package['try_us'] == 1){
				$try_us_in = $try_us_in + 1;
			}else{
				$member_us_in = $member_us_in + 1;
			}
		}
		
		$try_us_out = 0;
		$member_us_out = 0;
		$check_out = $mysqli->query("select * from booking_info where branch_id = '".$row['branch_id']."' and STR_TO_DATE(checkout_date,'%d/%m/%Y') BETWEEN '$_days_before' AND '$today'");
		while($out_row = mysqli_fetch_assoc($check_out)){
			$check_packagy = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$out_row['package']."'"));
			if($check_packagy['try_us'] == 1){
				$try_us_out = $try_us_out + 1;
			}else{
				$member_us_out = $member_us_out + 1;
			}
		}
		
		
		
		if($comming > $going){
			$dell__plus = $comming - $going;
			$sell_info = '<div style=" color: #28a745; text-shadow: 0 0 black; font-size: 25px;"> SALE: <i class="fas fa-long-arrow-alt-up"></i> + '.$dell__plus.'</div>';
		}else if($comming < $going){
			$dell__plus = $going - $comming;
			$sell_info = '<div style=" color: #dc3545; text-shadow: 0 0 black; font-size: 25px;"> SALE: <i class="fas fa-long-arrow-alt-down"></i> - '.$dell__plus.'</div>';
		}else if($comming == $going){
			$dell__plus = 0;
			$sell_info = '<div style=" color: #fd7e14; text-shadow: 0 0 black; font-size: 25px;"> SALE: <i class="fas fa-arrows-alt-v"></i> '.$dell__plus.'</div>';
		}
?>
				<tr>
					<td><?php echo $row['branch_name']; ?></td>
					<td>Last <?php echo $laset_days; ?> Days</td>
					<td>
						<?php echo $comming; ?><hr style="margin:0px;"/>
						<small style="color:green;">
							Member: <b><?php echo $member_us_in; ?></b>&nbsp;|&nbsp;
							Try Us: <b><?php echo $try_us_in; ?></b>
						<small>
					</td>
					<td>
						<?php echo $going; ?><hr style="margin:0px;"/>
						<small style="color:red;">
							Member: <b><?php echo $member_us_out; ?></b>&nbsp;|&nbsp;
							Try Us: <b><?php echo $try_us_out; ?></b>
						<small>
					</td>
					<td><?php echo $sell_info; ?></td>
				</tr>
<?php } ?>
				
			</tbody>
		</table>
	</div>
</div>
<?php } ?>