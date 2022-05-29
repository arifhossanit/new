<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['check_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from check_print_data where id = '".$_POST['check_id']."'"));
?>
<div class="row">
	<div class="col-sm-12" style="margin-bottom:30px;">
		<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
	</div>
	<div class="col-sm-12" style="padding:50px;padding-top:20px;">
		<div id="print_area" style="width:700px; height:326px;float:left;background-color:#eee;margin-top:189px;margin-left: -183px;transform: rotate(-90deg);"> <!---->
			<div style="height:28.8px;width:100%;margin-top: 50px;">
				<div style="width:215.04px;height:28.8px;float:left;margin-left:503px;"> <!--490-->
					<span id="date_preview" style="margin-left:-13px;margin-top:7px;font-size: 22px; line-height: 3																																				5px; letter-spacing: 13px;">
						<?php $dat = explode("/",$row['check_date']); echo $dat[0].$dat[1].$dat[2]; ?>
					</span>
				</div>
			</div>
			
			<div style="height:24.96px;width:100%;margin-top: 30px;">
				<div style="width:555px;height:24.96px;float:left;margin-left:71px;"><!--58-->
					<span align="center" id="name_preview" style="font-size: 17px; margin-left: 30px; color: #000; font-weight: 500;">
						<?php echo $row['check_name']; ?>
					</span>
				</div>
			</div>
			
			<div style="height:52.8px;width:100%;margin-top: 5px;">
				<div style="width:345.8px;height:52.8px;float:left;margin-left:119px;">
					<span align="center" id="description_preview" style="margin-left:18px;font-size: 16px; font-weight: 500;line-height: 29px;">
						<?php echo $row['check_description']; ?>
					</span>
				</div>
				
				<div style="width:182.4px;height:30.72px;float:left;margin-left:50px;margin-top: 7px;">
					<span id="amount_preview" style="font-size: 27px; font-weight: 600; letter-spacing: 3px; margin-left: 3px; line-height: 38px;">
						=<?php echo $row['check_amount']; ?>/=
					</span>
				</div>
			</div>											
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