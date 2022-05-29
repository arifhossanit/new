<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['enquary_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from booking_enquery where id = '".$_POST['enquary_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-bordered">
			<thead>
				<tr>
					<td>#</td>
					<td>Information</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>ID</td>
					<td><?php echo $row['id']; ?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo $row['name']; ?></td>
				</tr>
				<tr>
					<td>Phone</td>
					<td><a href="tel:<?php echo $row['phone']; ?>"><?php echo $row['phone']; ?></a></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $row['email']; ?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><?php echo $row['address']; ?></td>
				</tr>
				<tr>
					<td>0. Description</td>
					<td><?php echo $row['description']; ?> - <b style="color:#f00;"><?php echo $row['n_date']; ?></b></td>
				</tr>
<?php 
$i = 1;
$swert = $mysqli->query("select * from followup_from_visitor_logs where enquiry_id = '".$row['id']."'");
while($rqw = mysqli_fetch_assoc($swert)){
?>	
				<tr>
					<td><?php echo $i++; ?>. Description</td>
					<td><?php echo $rqw['previus_discription']; ?> - <b style="color:#f00;"><?php echo $rqw['p_date']; ?></b></td>
				</tr>

<?php } ?>			
				<tr>
					<td>Note</td>
					<td><?php echo $row['note']; ?></td>
				</tr>
				<tr>
					<td>Entry Date</td>
					<td><?php echo $row['date']; ?></td>
				</tr>
				<tr>
					<td>Follow Up date</td>
					<td><?php echo $row['n_date']; ?></td>
				</tr>
				<tr>
					<td>Referance Id</td>
					<td><?php echo $row['referance_id']; ?></td>
				</tr>
				<tr>
					<td>HTFU</td>
					<td><?php echo $row['h_t_f_u']; ?></td>
				</tr>
			</tbody>
		</table>
		<button onclick="return add_information('<?php echo $row['id']; ?>','<?php echo $row['n_date']; ?>','<?php echo rahat_encode($row['branch_id']); ?>')" type="button" class="btn btn-info btn-xs" style="float:right;">Add Info</button>
	</div>
</div>
<?php } ?>

<?php
if(isset($_POST['post_id'])){
	$check_information = mysqli_fetch_assoc($mysqli->query("select * from booking_enquery where id = '".$_POST['post_id']."'"));
	if($mysqli->query("insert into followup_from_visitor_logs values(
		'',
		'".$mysqli->real_escape_string($check_information['id'])."',
		'".$mysqli->real_escape_string($check_information['description'])."',
		'".$mysqli->real_escape_string($_POST['description'])."',
		'".$mysqli->real_escape_string($_POST['note'])."',
		'".$mysqli->real_escape_string($_POST['previous_date'])."',
		'".$mysqli->real_escape_string($_POST['next_date'])."',
		'1',
		'".$mysqli->real_escape_string(uploader_info())."',
		'".date('d-m-Y')."'
	)")){
		if($mysqli->query("update booking_enquery set
			branch_id = '".rahat_decode($_POST['updated_branch'])."',
			description = '".$mysqli->real_escape_string($_POST['description'])."',
			n_date = '".$mysqli->real_escape_string($_POST['next_date'])."'
			where id = '".$check_information['id']."'			
		")){
			echo 'Data Save Successfully!';
		}else{
			echo 'Something wrong! Please Try Again';
		}
	}else{
		echo 'Something wrong! Please Try Again';
	}
}
?>