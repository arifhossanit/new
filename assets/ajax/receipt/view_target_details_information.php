<?php 
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['target_id'])){
$data = mysqli_fetch_assoc($mysqli->query("select * from booking_target_adding_logs where id = '".$_POST['target_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-bordered">
			<thead>
				<tr>
					<th>Branch Info</th>
					<th>Target Month</th>
					<th>Note</th>
					<th>Target</th>
				</tr>
			</thead>
			<tbody>
<?php
$info = $mysqli->query("select * from booking_monthly_target where unique_id = '".$data['unique_id']."'");
while($row = mysqli_fetch_assoc($info)){
	$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch_id']."'"));
	$employee = mysqli_fetch_assoc($mysqli->query("select * from employee where status = '1' and branch = '".$row['branch_id']."' and role = '1892907820998244323' order by id desc limit 01"));
?>			
				<tr>
					<td><?php echo $branch['branch_name'].' - <b>'.$employee['full_name'].'('.$employee['employee_id'].')</b>'; ?></th>
					<td><?php echo $row['target_month']; ?></td>
					<td><?php echo $row['note']; ?></td>
					<td><?php echo $row['target']; ?></td>
				</tr>
<?php } ?>				
			</tbody>
		</table>
	</div>
</div>
<?php } ?>