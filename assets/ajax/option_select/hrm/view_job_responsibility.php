<?php
include("../../../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from employee_recruitment_request where id = '".$_POST['view_id']."'"));
	$aproval = mysqli_fetch_assoc($mysqli->query("select * from employee_recruitment_approval_logs where aproval_id = '".$row['id']."'"));
	if($_SESSION['super_admin']['role_id'] == '390647376434090456'){
		$mysqli->query("update employee_recruitment_request set hr_notify = '0' where id = '".$row['id']."'");
	}
?>
<div class="row">
	<div class="col-sm-12">
		<h5>Job Responsibility</h5>
		<?php echo $row['job_responsibility']; ?>
		<hr />
		<h5>Note</h5>
		<?php echo $row['note']; ?>
		<?php if(!empty($aproval['id'])){ ?>
		<hr />
		<h5>Boss Note</h5>
		<?php echo $aproval['note']; ?>
		<?php }?>		
	</div>
</div>
<?php } ?>