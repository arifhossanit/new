<?php
include("../../../../../application/config/ajax_config.php");
if(isset($_POST['employee_id'])){ 
	$sql = $mysqli->query("select * from exit_employee_chain_aproval where exit_emp_id = '".$_POST['employee_id']."'");
?>
<div class="row">
	<div class="col-sm-12">
		<ul class="pending_status_list">
<?php
while($row = mysqli_fetch_assoc($sql)){
	$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$row['e_db_id']."'"));
?>		
			<li>
				<b><?php echo $emp['full_name']; ?></b><br />
				ID: <b><?php echo $emp['employee_id']; ?></b><br />
				Designation: <b><?php echo $emp['designation_name']; ?></b><br />
				Department: <b><?php echo $emp['department_name']; ?></b><br />
				Status: &nbsp;
				<?php 
					if($row['aproval'] == 1){
						echo '<button type="button" class="btn btn-xs btn-success">Approved!</button>';
					}else if($row['aproval'] == 2){
						echo '<button type="button" class="btn btn-xs btn-danger">Rejected!</button>';
					}else{
						echo '<button type="button" class="btn btn-xs btn-info">Pending!</button>';
					}
				?>
				<?php
					if(!empty($row['note'])){
						echo '<br />Note: <span style="text-decoration:underline;">'.$row['note'].'</span>';
					}
				?>
			</li>
<?php } ?>
		</ul>
	</div>
</div>
<style>
	.pending_status_list{
		
	}
	.pending_status_list li{
		border-bottom:solid 1px #eee;
		padding-bottom:7px;
		padding-top:10px;
	}
</style>
<?php } ?>