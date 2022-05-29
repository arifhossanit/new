<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['print_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where id = '".$_POST['print_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
	</div>
	<div class="col-sm-12">
		<div id="print_area" style="width:100%;height:1470px;background:url(<?php echo $home; ?>assets/img/tenant.png);background-repeat: no-repeat; background-size: cover;color:#4b4b4b;">
			<div style="width: 161px; float: left; height: 186px; margin-top: 102px; margin-left: 97px; border-radius: 20px;">
				<img src="<?php echo $home.$row['photo_avater']; ?>" style="width:100%;height: 186px; border-radius: 20px;"/>
			</div>
			<span style="margin-top: 298px; margin-left: 92px; float: left; font-size: 23px; font-weight: 600;width: 661px; height: 34px; overflow: hidden;">
				<?php echo $row['full_name']; ?>
			</span>
			
			<span style="margin-top: 4px; margin-left: 243px; float: left; font-size: 23px; font-weight: 600;width: 770px; height: 34px; overflow: hidden;">
				<?php echo $row['father_name']; ?>
			</span>
			
			<span style="margin-top: 36px; margin-left: -771px; float: left; font-size: 23px; font-weight: 600;height: 34px; width: 327px; overflow: hidden;">
				<?php echo $row['date_of_birth']; ?>
			</span>
			
			<span style="margin-top: -35px; margin-left: 710px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 300px;overflow: hidden;">
				<?php echo $row['marital_status']; ?>
			</span>
			
			<span style="margin-top: -5px; margin-left: 255px; float: left; font-size: 23px; font-weight: 600; height: 68px; width: 756px;overflow: hidden;">
				<?php echo $row['permament_address']; ?>
			</span>
			
			<span style="argin-top: -2px; margin-left: 406px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 604px; overflow: hidden;">
				<?php echo $row['occupation']; ?>
			</span>
			
			<span style="margin-top: 0px; margin-left: 190px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 381px;overflow: hidden;">
				<?php echo $row['religion']; ?>
			</span>
			
			<span style="margin-top: -34px; margin-left: 735px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 276px; overflow: hidden;">
				<?php echo $row['qualification']; ?>
			</span>
			
			<span style="margin-top: 0px; margin-left: 248px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 310px; overflow: hidden;">
				<?php echo $row['phone']; ?>
			</span>
			
			<span style="margin-top: -34px; margin-left: 701px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 310px; overflow: hidden;">
				<?php echo $row['email']; ?>
			</span>
			
			<span style="margin-top: 0px; margin-left: 333px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 675px; overflow: hidden;">
				<?php echo $row['nid']; ?>
			</span>
			
			<span style="margin-top: 0px; margin-left: 355px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 654px; overflow: hidden;">
				<?php echo $row['passport_no']; ?>
			</span>
			
			<span style="margin-top: 30px; margin-left: 220px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 345px; overflow: hidden;">
				<?php echo $row['emergency_contact_name']; ?>
			</span>
			
			<span style="margin-top: -34px; margin-left: 685px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 324px; overflow: hidden;">
				<?php echo $row['emergency_relation']; ?>
			</span>
			
			<span style="margin-top: 1px; margin-left: 245px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 324px; overflow: hidden;">
				<?php echo $row['emergency_contact_address']; ?>
			</span>
			
			<span style="margin-top: -32px; margin-left: 742px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 266px; overflow: hidden;">
				<?php echo $row['emergency_contact_number']; ?>
			</span>
			
			<span style="margin-top: 368px; margin-left: 324px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 248px; overflow: hidden;">
				<?php echo $row['old_home_owner_name']; ?>
			</span>
			
			<span style="margin-top: -34px; margin-left: 707px; float: left; font-size: 23px; font-weight: 600; height: 34px; width: 302px; overflow: hidden;">
				<?php echo $row['old_home_owner_number']; ?>
			</span>

		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>
<script>
    $('#print_button').on("click", function () {
      $('#print_area').printThis({
      });
    });
</script>
<?php } ?>