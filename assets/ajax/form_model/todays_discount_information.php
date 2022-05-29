<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['today'])){
	$post = date('d/m/Y');
	$dt = explode("/",$post);
	$date = $dt[0];
	$month = $dt[1];
	$year = $dt[2];
	if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
		$branch = "";
	}else{
		$branch = " and branch_id = '".$_SESSION['super_admin']['branch']."'";
	}
	

?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Member Name</th>
					<th>Phone Number</th>
					<th>Package Category</th>
					<th>Package</th>
					<th>Discount</th>
					<th>Date</th>
					<th>Discount By</th>
				</tr>
			</thead>
			<tbody>
<?php 
$total = '0';
$sql = $mysqli->query("select * from discount_member where days = '".$date."' and month = '".$month."' and year = '".$year."' $branch"); // 
while($row = mysqli_fetch_assoc($sql)){
	$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."'"));
	$p_cat = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$row['package_category']."'"));
	$p_age = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));
	$emil = explode('___',$row['uploader_info']);
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$emil[1]."'"));
?>			
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $mem['full_name']; ?></td>
					<td><?php echo $mem['phone_number']; ?></td>
					<td><?php echo $p_cat['package_category_name']; ?></td>
					<td><?php echo $p_age['package_name']; ?></td>
					<td><?php echo money($row['amount']); ?></td>
					<td><?php echo $row['data']; ?></td>
					<td><?php echo $emp['full_name']; ?></td>
				</tr>
<?php 
	$total = $total + $row['amount'];
} 
?>		
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><b>Total:</b></td>
					<td><b><?php echo money($total); ?></b></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php } ?>