<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['member_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['member_id']."'"));
?>
<input type="hidden" name="member_id" value="<?php echo $row['id']; ?>"/>
<input type="hidden" name="old_deposit" value="<?php echo $row['security_deposit']; ?>"/>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-6">
				<p style="text-decoration:underline;">Member information</p>
				<img src="<?php echo $home.$row['photo_avater']; ?>" style="width:150px;" /> <hr />
				Name: <?php echo $row['full_name']; ?> <br />
				Phone Number: <?php echo $row['phone_number']; ?> <br />
				Email: <?php echo $row['phone_number']; ?> <br />
				Address: <?php echo $row['address']; ?> <br />
				CheckInDate: <?php echo $row['check_in_date']; ?> <br />
				CheckOutDate: <?php echo $row['check_out_date']; ?> <br />
				BookingDate: <?php echo $row['booking_date']; ?> <br />
				Branch: <?php echo $row['branch_name']; ?> <br />
				Floor: <?php echo $row['floor_name']; ?> <br />
				Unit: <?php echo $row['unit_name']; ?> <br />
				Room: <?php echo $row['room_name']; ?> <br />
				Bed: <?php echo $row['bed_name']; ?> <br />
				PackageName: <?php echo $row['package_name']; ?> <br />
				SecurityDeposit: <?php echo money($row['security_deposit']); ?> <br />
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Check In Date</label>
					<input type="date" name="check_in_date" <?php if($_SESSION['super_admin']['user_type'] != 'Super Admin'){ ?>min="<?php echo date('Y-m-d'); ?>"<?php } ?> class="form-control" autocomplete="off" placeholder="Check In Date" required />
				</div>
				<div class="form-group">
					<label>Choose Bed</label>
					<input type="text" name="new_bed" id="new_bed_name" onclick="return get_avaible_bed_info()" onfocus="return get_avaible_bed_info()" value="" placeholder="Choose Bed" class="form-control" required style="font-weight:bolder;font-size:28px;color:green;cursor: pointer;" />
					<input type="hidden" name="new_bed_id" id="bed_id" value="" /> 
				</div>
				<div class="form-group">
					<label>Card Number</label>
					<input type="text" name="card_number" value="<?php if(!empty($row['card_number'])){ echo $row['card_number']; } ?>" class="form-control" autocomplete="off" placeholder="Card Number" required />
				</div>
				<div class="form-group">
					<button type="submit" id="form_submit_re_check" class="btn btn-warning" style="float:right;">Re-Check This Member</button>
				</div>
			</div>
		</div>
		
	</div>
</div>
<script>
function get_avaible_bed_info(){
	var bra_id_shif = "<?php echo $row['branch_id']?>";
	var bed_typ_sh = "<?php echo $row['bet_type']?>";
	$.ajax({  
		url:"<?php echo $home.'assets/ajax/select_beds_options.php'; ?>",  
		method:"POST",  
		data:{
			bed_type : bed_typ_sh,
			branch_id : bra_id_shif
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#bed_result').html(data); 
			$('#bed_info_header').html('<i class="fas fa-check"></i> Selected Bed Information. Bed Type: '+bed_typ_sh);
			$('#re_check_member_modal').modal('hide');
			$('#bed_selecting_model').modal('show');   
		}  
	});	
}
</script>
<?php } ?>