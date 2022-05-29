<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['employee_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".rahat_decode($_POST['employee_id'])."'"));
$department = mysqli_fetch_assoc($mysqli->query("select * from department where department_id = '".$row['department']."'"));
$designation = mysqli_fetch_assoc($mysqli->query("select * from designation where designation_id = '".$row['designation']."'"));
$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = 'BAR_011220_210463187872898170_1606780607'"));
include('../../../application/helpers/qrcode_helper.php');
$daaata = $home.'emp_info_from_card/'.rahat_encode($row['id']);
$file = '../../uploads/qrcode/employee_q_v_c_code_id_'.$row['id'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2); 
?>
<div class="row">
	<div id="print_area_visiting_card"> <!--id="download_id_card" -->
		<div style="width:1050px; height:603px; float:left;background:url(<?php echo $home; ?>assets/img/visiting-card.svg), url(<?php echo $home; ?>assets/img/separetor.svg) no-repeat; background-size: 1200px, 700px;background-position: -15px -230px, 45px 310px;">
			<div style="width:804px; height:600px; float:left;">
				<span style="font-size: 40px; font-weight: 520; text-transform: uppercase; float: left; margin-top: 170px; margin-left: 85px;width: 100%;color: #363636;"><?php echo $row['full_name']; ?></span>
				<span style="font-size: 28px; font-weight: 420; float: left; margin-top: 0px; margin-left: 85px;color: #363636;width: 100%;">
					<?php echo $designation['designation_name']; ?> - <?php echo $department['department_name']; ?>
				</span>
				<div style="width: 100%; height: 244px; float: left; margin-top: 80px;margin-left: 43px;">
					<div style="width: 100%; height: 70px; float: left;">
						<div style="width:70px;height:70px;float:left;margin-left:48px;">
							<img style="width: 30px;margin-top: 17px;" src="<?php echo $home; ?>assets/img/phone-logo.svg" alt="">
						</div>
						<div style="width:682px;height:70px;float:left;">
							<span style="font-size: 28px; font-weight: 420; float: left; margin-top: 0px;line-height: 35px;color: #363636; ">
								<?php echo $row['personal_Phone']; ?> <br /> 
								<?php echo $row['Company_phone']; ?>
							</span>
						</div>
					</div>
					
					<div style="width: 100%; height: 70px; float: left;">
						<div style="width:70px;height:70px;float:left;margin-left:48px;">
							<img style="width: 30px;margin-top: 25px;" src="<?php echo $home; ?>assets/img/mail-logo.svg" alt="">
						</div>
						<div style="width:682px;height:70px;float:left;">
							<span style="font-size: 28px; font-weight: 420; float: left; margin-top: 0px;line-height: 70px; color: #363636;">
								<?php echo $row['company_email']; ?> 
							</span>
						</div>
					</div>
					
					<div style="width: 100%; height: 70px; float: left;">
						<div style="width:70px;height:70px;float:left;margin-left:48px;">
							<img style="width: 30px;margin-top: 9px;" src="<?php echo $home; ?>assets/img/location-logo.svg" alt="">
						</div>
						<div style="width:588px;height:70px;float:left;overflow:hidden;">
							<span style="font-size: 28px; font-weight: 420; float: left; margin-top: 0px;line-height: 35px;color: #363636; ">
								<?php echo $branch['branch_location']; ?> 
							</span>
						</div>
					</div>
					
				</div>
			</div>
			<div style="width:245px; height:600px; float:left;">
				<div style="width:216px; height:216px; float:left;margin-top: 232px; margin-left: 11px; ">
					<img src="<?php echo $home.'assets/uploads/qrcode/employee_q_v_c_code_id_'.$row['id'].'.png'; ?>" style="width: 200px;height: 200px;margin-left: 13px;">
				</div>
			</div>
		
		</div>
		<!--
		<div style=" width: 706px; height: 403px; margin: 24px; margin-left: 27px; float: left;">
			<div style="width:306px;height:403px;float:left;">
				<div style="
					width:100px;
					height:100px;
					float:left;
					background-color:#fff;
					margin-top: 159px;
					margin-left: 71px; 
					border-top: solid 10px #f00;
					border-right: solid 10px #f00;
					border-left: solid 10px #334ea2;
					border-bottom: solid 10px #334ea2;
					border-radius:10px;
				">
					<img src="<?php echo $home.'assets/uploads/qrcode/employee_q_v_c_code_id_'.$row['id'].'.png'; ?>" style="width: 80px; height: 80px;">
				</div>
			</div>
			<div style="width:400px;height:403px;float:left;">
				<span style="font-size: 28px;margin-left: 86px;margin-top: 33px;float: left;color: #ed2024;font-family: cursive;"><b>Md. Ibrahim Khalil</b></span>
				<span style="font-size: 14px;margin-left: 134px;margin-top: 0px;float: left;color: #000000;font-family: cursive;">Deputy Manager - S &amp; IT </span>
				<span style="margin-left: 137px;margin-top: 90px;float: left;color: #000000;font-family: cursive;font-size: 10px;">Road : 12, House: 52 (6th floor), Merul badda DIT project, Dhaka-1212</span>
				<span style="margin-left: 137px;margin-top: 47px;float: left;color: #000000;font-family: cursive;font-size: 10px;">2010mdibrahim@gmail.com</span>
				<span style="margin-left: 137px;margin-top: 45px;float: left;color: #000000;font-family: cursive;font-size: 10px;">01704123492</span>
			</div>
		</div>-->
	</div>
	<div class="col-sm-12" style="margin-top:20px;">
		<button id="print_button_visiting_card" class="btn btn-sm btn-success"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;PRINT</button> <!-- onclick="return downloadSVG()"-->
	</div>
</div>
<script>/*
function downloadSVG() {
  const svg = document.getElementById('download_id_card').innerHTML;
  const blob = new Blob([svg.toString()]);
  const element = document.createElement("a");
  element.download = "w3c.svg";
  element.href = window.URL.createObjectURL(blob);
  element.click();
  element.remove();
}*/
</script>	
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>
<script>
    $('#print_button_visiting_card').on("click", function () {
      $('#print_area_visiting_card').printThis({
      });
    });
</script>
<?php } ?>