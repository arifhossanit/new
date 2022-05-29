<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){ 
	$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));
	$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$member_info['bed_id']."'"));
	//$rooms_info = mysqli_fetch_assoc($mysqli->query("select * from rooms where id = '".$bed_info['room_id']."'"));
	//$package_cat_info = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$member_info['package_category']."'")); 
	//$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member_info['package']."'"));
?>
<input type="hidden" name="accept_booking_id" value="<?php echo $member_info['booking_id']; ?>"/>
<input type="hidden" name="accept_branch_id" class="accept_branch_id" value="<?php echo $member_info['branch_id']; ?>"/>
<div class="row">
	<div class="col-sm-12">
		<div class="col-sm-12">
			<div class="form-group">
				<label>Package category</label>
				<select name="package_category" onchange="return get_package_pc()" id="package_category" class="form-control select2">										
					<option value="">--select--</option>
					<?php
						$sql = $mysqli->query("select * from packages_category where branch_id = '".$member_info['branch_id']."'");
						while($row = mysqli_fetch_assoc($sql)){
							echo '<option value="'.$row['id'].'">'.$row['package_category_name'].'</option>';
						}
					?>
				</select>
				<input type="hidden" name="psh_room_type" id="psh_room_type" value=""/>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label>Package</label>
				<select name="package_id" id="package_id" class="form-control select2" style="color:green;">					
				</select>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label>Accepting Date (mm/dd/yyyy)</label>
				<?php
					$current_month = date('Y-m').'-01';
					$next_month = date_add(date_create($current_month), date_interval_create_from_date_string('1 month'));
					$next_month = date_format($next_month, 'Y-m-d')
				?>
				<input type="date" name="shifting_date" id="" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $next_month; ?>" class="form-control" required /> <!-- min="<?php echo $next_month; ?>" max="<?php echo $next_month; ?>"-->
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label>New Card Number</label>
				<input type="number" name="card_number" value="<?php //echo $member_info['card_number']; ?>" placeholder="Card Number" required class="form-control"/>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label>Choose New Bed</label>
				<input type="text" name="pack_new_bed" id="pack_new_bed_name" onclick="return get_avaible_bed_info_package_shifting_accept_branch()" value="" placeholder="Choose Bed" class="form-control" readonly style="font-weight:bolder;font-size:28px;color:green;cursor: pointer;" />
				<input type="hidden" name="pack_new_bed_id" id="pack_bed_id" value="" /> 
			</div>
		</div>
	</div>
</div>

<?php } ?>