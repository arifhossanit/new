<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['package_info'])){ ?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-bordered table-sm">
			<thead>
				<tr>
					<th>Package</th>
					<th>Value</th>
					<th>Exmple(Sales x value)</th>
				</tr>
			</thead>
			<tbody>
<?php
$sql = $mysqli->query("select * from sub_package_category");
while($row = mysqli_fetch_assoc($sql)){
	$get_val = rand(1,9);
?>			
				<tr>
					<td><?php echo $row['sub_package_name']; ?></td>
					<td><?php echo $row['booking_value']; ?></td>
					<td><?php echo $get_val; ?> * <?php echo $row['sub_package_name']; ?> <span style="color:red;">x</span> <?php echo $row['booking_value']; ?> = <?php echo $row['booking_value'] * $get_val; ?></td>
				</tr>
<?php } ?>				
			</tbody>
		</table>
	</div>
	<?php /* ?>
	<div class="col-sm-12">
		<center>
			Save from looser list need minimum Points
		</center>
		<ol type="1">
			<li>Last day: 5</li>
			<li>Last week: 20</li>
			<li>Last month: 100</li>
		</ol>
	</div>
	<?php */ ?>
	
	<div class="col-sm-12">
		<center>
			<u>Short Form</u>
		</center>
		<ol type="1">
			<li><b>OT:</b> Occupency Target</li>
			<li><b>RO:</b> Reached Occupency Number</li>
			<li><b>ROP:</b> Reached Occupency Percentage</li>
			<li><b>TP:</b> Target Point</li>
			<li><b>RP:</b> Reached Point</li>
			<li><b>RPP:</b> Reached Point Percentage</li>
		</ol>
	</div>
	<div class="col-sm-12">
	
	</div>
</div>	

<?php }
?>