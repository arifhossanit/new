<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){ 
	$row = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where id = '".$_POST['member_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<input type="hidden" id="member_id" value="<?php echo $row['id']; ?>"/>
		<input type="hidden" id="ipo_shifting_change_token" value="<?php echo md5(time()); ?>"/>
		<input type="hidden" id="branch_id_agrement" value=""/>
		<input type="hidden" id="bed_type_agrement" value=""/>
		<input type="hidden" id="old_bed_id_agrement" value=""/>
		<input type="hidden" id="old_agrement_id" value=""/>
		<h3><u>From,</u></h3>
		<div class="form-group">
			<label>Select Exixting Bed</label>
			<select name="old_bed_id" onchange="return get_old_bed_info()" class="form-control select2" required>
				<option value="">--select--</option>
<?php
$sql = $mysqli->query("select * from ipo_agreement_information where ipo_id = '".$row['ipo_id']."'");
while($agr = mysqli_fetch_assoc($sql)){
?>
				<option value="<?php echo $agr['bet_id']; ?>____<?php echo $agr['branch_id']; ?>____<?php echo $agr['bet_type']; ?>____<?php echo $agr['id']; ?>">
					<?php echo $agr['branch_name']; ?> - <?php echo $agr['floor_name']; ?> - <?php echo $agr['unit_name']; ?> - <?php echo $agr['room_name']; ?> (<?php echo $agr['bed_name']; ?>)
				</option>
<?php } ?>
			</select>
		</div>
		<h3><u>To,</u></h3>
		<div class="form-group">
			<label>Select new Bed</label>
			<input type="text" name="new_bed" id="new_bed_name" onclick="return get_avaible_bed_info()" class="form-control" placeholder="New Bed" disabled />
			<input type="hidden" name="new_bed_id" id="bed_id" value="" /> 
		</div>
	</div>
	<div class="col-sm-12">
		<div class="form-group">
			<label>Note</label>
			<textarea name="note" placeholder="Note" class="form-control"></textarea>
		</div>
	</div>
</div>
<script>

</script>
<?php } ?>