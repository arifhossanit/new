<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['group_value'])){
	$utime = sprintf('%.4f', microtime(TRUE)); 
	$raw_time = DateTime::createFromFormat('U.u', $utime);  
	$raw_time->setTimezone(new DateTimeZone('Asia/Dhaka')); 
	$today = $raw_time->format('dmy-his-u');
	$bc = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$_SESSION['super_admin']['branch']."'"));
	$branch_id = $bc['branch_id'];
	$group_id = 'GROUP-'.$bc['branch_code'].'-'.$today;
	$uploader_info = rahat_decode($_POST['uploader_info']);
	$booking_idi = '';
	$group_sql = $mysqli->query("select * from group_member_directory");
	while($group = mysqli_fetch_assoc($group_sql)){
		$booking_idi .= "'".$group['booking_id']."',";
	}
	$s_booking_idi = rtrim($booking_idi,',');
	$select_member = $mysqli->query("select * from member_directory where member_type = 'GROUP' and branch_id = '".$branch_id."' AND uploader_info = '".$uploader_info."' AND booking_id NOT IN ($s_booking_idi) and status = '1' order by id desc");
?>
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<div class="row">
	<div class="col-sm-12">
		<input type="hidden" name="uploader_info" id="uploader_info" value="<?php echo $uploader_info; ?>"/>
		<input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id; ?>"/>
		<input type="hidden" name="branch_id" id="branch_id" value="<?php echo $bc['branch_id']; ?>"/>
		<input type="hidden" name="create_group_submit" id="create_group_submit" value="1"/>
		<center>
			<span>
				GroupID:
			</span>
			<br />
			<span style="font-size:30px;">
				<?php echo $group_id; ?>
			</span>
		</center>
	</div>
	<div class="col-sm-12" style="margin-top:30px;">
		<div class="form-group">
			<select name="group_members[]" id="group_members" class="form-control js-example-basic-multiple" multiple="multiple" data-placeholder="Select Group Members" style="width: 100%;" required >
			<?php
			while($row = mysqli_fetch_assoc($select_member)){
			?>	
				<option value="<?php echo $row['booking_id']; ?>"><?php echo $row['full_name']; ?> - <?php echo $row['phone_number']; ?></option>
			<?php } ?>
			</select>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="form-group">
			<textarea name="note" style="height:120px;" placeholder="Note" class="form-control"></textarea>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="form-group">
			<button type="submit" name="create_group" id="create_group" class="btn btn-success" style="float:right">
				<i class="fas fa-users"></i> &nbsp;&nbsp;
				Create Group
			</button>
		</div>
	</div>
	<!--group_member_directory-->
</div>
<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>
<?php } 
if(isset($_POST['create_group_submit'])){
	$branch_id = $_POST['branch_id']; 
	$group_id = $_POST['group_id']; 
	$group_members = $_POST['group_members'];
	$note = $_POST['note'];
	$uploader_info = $_POST['uploader_info'];
	$inserts = array();
	foreach($group_members as $row){
		$inserts[] = "(
			'',
			'".$group_id."',
			'".$branch_id."',
			'".$row."',
			'".$note."',
			'1',
			'".$uploader_info."',
			'".date('d/m/Y')."'
		)";
	}
	$sql = "INSERT INTO group_member_directory VALUES ". implode(", ", $inserts);
	if ($mysqli->query($sql)){
		echo "Group created successfully";
	}else{
		echo "Something Wrong! Please Try again";
	}
}
?>