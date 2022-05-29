<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['group_id'])){ ?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-sm">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Card</th>
					<th>Branch</th>
					<th>Phone</th>
					<th>Bed</th>
					<th>Category</th>
					<th>Package</th>
					<th>Option</th>
				</tr>
			</thead>
			<tbody>
<?php
$group_sql = $mysqli->query("select * from group_member_directory where group_id = '".$_POST['group_id']."'");
while($row = mysqli_fetch_assoc($group_sql)){
	$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."'"));
	$pcg = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$mem['package_category']."'"));
?>			
				<tr>
					<td><?php echo $mem['id']; ?></td>
					<td><?php echo $mem['full_name']; ?></td>
					<td><?php echo $mem['card_number']; ?></td>
					<td><?php echo $mem['branch_name']; ?></td>
					<td><?php echo $mem['phone_number']; ?></td>
					<td><?php echo $mem['bed_name']; ?></td>
					<td><?php echo $pcg['package_category_name']; ?></td>
					<td><?php echo $mem['package_name']; ?></td>
					<td>
						<button onclick="return view_member_profile2(<?php echo $mem['id']; ?>)" type="button" class="btn btn-xs btn-warning" title="View member profile"><i class="fa fa-eye"></i></button>
					</td>
				</tr>
<?php } ?>
			</tbody>
		</table>
	</div>
</div>	
<?php } ?>