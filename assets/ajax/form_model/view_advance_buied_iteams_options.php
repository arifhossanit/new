<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['transaction_id'])){
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Item Name</th>
					<th>Purpose</th>
					<th>Price</th>
					<th>Item QTY</th>
					<th>Subtotal</th>
					<th>File</th>
				</tr>
			</thead>
			<tbody>
<?php 
$total = '0';
$sql = $mysqli->query("select * from advance_transaction_iteams where transaction_id = '".$_POST['transaction_id']."'"); // 
while($row = mysqli_fetch_assoc($sql)){
	
?>			
				<tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['item_name']; ?></td>
					<td>
					<?php
					$expense_type = mysqli_fetch_assoc($mysqli->query("SELECT head_name from expense_type where id = '".$row['purpose']."'"));
					if(!is_null($expense_type)){
						if($row['sub_purpose'] > 0){
							$expense_sub_type = mysqli_fetch_assoc($mysqli->query("SELECT head_name from expense_sub_type where id = ".$row['sub_purpose']));
							echo $expense_type['head_name'].' - '.$expense_sub_type['head_name'];
						}else{
							echo $expense_type['head_name'];
						}
					}else{
						echo $row['purpose'];
					}
					?></td>
					<td><?php echo money($row['item_price']); ?></td>
					<td><?php echo $row['ite_qty']; ?></td>
					<td><?php echo money($row['total']); ?></td>
					<td>
						<a href="<?php echo $home.$row['attachment']; ?>" target="_blank" title="View File">View File</a>						
					</td>
				</tr>
<?php 
} 
?>		
			</tbody>
		</table>
	</div>
</div>
<?php } ?>