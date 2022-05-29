<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['employee_ids'])){
?>
<style>
@media print {
	.row{
		-webkit-column-break-inside: avoid;
		page-break-inside: avoid;
		break-inside: avoid;
	}
}
</style>
<div class="row justify-content-between page-break">
	<table  style="width: 1500px;">
<?php 
$i = 0;
foreach($_POST['employee_ids'] as $employee_id){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '$employee_id'"));
$department = mysqli_fetch_assoc($mysqli->query("select * from department where department_id = '".$row['department']."'"));
$designation = mysqli_fetch_assoc($mysqli->query("select * from designation where designation_id = '".$row['designation']."'"));
$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = 'BAR_011220_210463187872898170_1606780607'"));
include('../../../application/helpers/qrcode_helper.php');
$daaata = $home.'emp_info_from_card/'.rahat_encode($row['id']);
$file = '../../uploads/qrcode/employee_q_v_c_code_id_'.$row['id'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2); 
?>
<?php echo ($i % 2 == 0) ? '<tr style="margin-top: 5px">' : '' ?>
	<td>
		<div class="col-sm-6" id="print_area_visiting_card"> <!--id="download_id_card" -->
			<div style="width:242px;height:138px;">
				<div style="width:490px; height:265px; float:left;background:url(<?php echo $home; ?>assets/img/visiting-card.svg), url(<?php echo $home; ?>assets/img/separetor.svg) no-repeat; background-size: 552px, 311px;background-position: 0px -105px, 27px 137px;">
					<div style="width:370px; height:275px; float:left;">
						<span style="font-size: 19px; font-weight: 520; text-transform: uppercase; float: left; margin-top: 81px; margin-left: 46px;width: 100%;color: #363636;"><?php echo $row['full_name']; ?></span>
						<span style="font-size: 13px; font-weight: 420; float: left; margin-top: 0px; margin-left: 46px;color: #363636;width: 100%;">
							<?php echo $designation['designation_name']; ?> - <?php echo $department['department_name']; ?>
						</span>
						<div style="width: 100%; height: 112px; float: left; margin-top: 26px;margin-left: 26px;">
							<div style="width: 100%; height: 27px; float: left;">
								<div style="width:33px;height:33px;float:left;margin-left:22px;">
									<img style="width: 14px;" src="<?php echo $home; ?>assets/img/phone-logo.svg" alt="">
								</div>
								<div style="width:314px;height:22px;float:left;">
									<span style="font-size: 12px; font-weight: 420; float: left; margin-top: 0px;line-height: 15px;color: #363636; ">
										<?php echo $row['personal_Phone']; ?> <br /> 
										<?php echo $row['Company_phone']; ?>
									</span>
								</div>
							</div>
							
							<div style="width: 100%; height: 33px; float: left;">
								<div style="width:33px;height:33px;float:left;margin-left:22px;">
									<img style="width: 14px; margin-top: 7px" src="<?php echo $home; ?>assets/img/mail-logo.svg" alt="">
								</div>
								<div style="width:314px;height:33px;float:left;">
									<span style="font-size: 14px; font-weight: 420; float: left; margin-top: 0px;line-height: 33px; color: #363636;">
										<?php echo $row['company_email']; ?> 
									</span>
								</div>
							</div>
							
							<div style="width: 100%; height: 25px; float: left;">
								<div style="width:33px;height:33px;float:left;margin-left:22px;">
									<!-- <i class="fas fa-map-marker-alt" style="font-size: 15px; float: left; line-height: 33px;color: #363636;"></i> -->
									<img style="width: 14px; margin-top: 2px" src="<?php echo $home; ?>assets/img/location-logo.svg" alt="">
								</div>
								<div style="width:282px;height:33px;float:left;overflow:hidden;">
									<span style="font-size: 14px; font-weight: 420; float: left; margin-top: 0px;line-height: 17px;color: #363636; ">
										<?php echo $branch['branch_location']; ?> 
									</span>
								</div>
							</div>
							
						</div>
					</div>
					<div style="width:107px; height:551px; float:left;">
						<div style="width:98px; height:98px; float:left;margin-top: 110px; margin-left: 9px; ">
							<img src="<?php echo $home.'assets/uploads/qrcode/employee_q_v_c_code_id_'.$row['id'].'.png'; ?>" style="width: 90px;margin-left: 8px;">
						</div>
					</div>			
				</div>
			</div>	
		</div>
	</td>
<?php echo ($i % 2 != 0) ? '</tr>' : '' ?>
<?php $i++; } ?>
<tr style="margin-top: 5px">
	<td>
		<div class="col-sm-6" id="print_area_visiting_card"> <!--id="download_id_card" -->
			<div style="width:242px;height:138px;">
				<div style="width:500px; height:265px; float:left;background:url(<?php echo $home; ?>assets/img/visiting-card-back.svg) no-repeat; background-size: 552px;background-position: 0px -105px;">
					<div style="width:370px; height:275px; float:left;">
						<span style="font-size: 19px; font-weight: 520; text-transform: uppercase; float: left; margin-top: 81px; margin-left: 46px;width: 100%;color: #363636;"></span>
						<span style="font-size: 13px; font-weight: 420; float: left; margin-top: 0px; margin-left: 46px;color: #363636;width: 100%;">
						</span>
						<div style="width: 100%; height: 112px; float: left; margin-top: 37px;margin-left: 26px;">
							<div style="width: 100%; height: 33px; float: left;">
								<div style="width:33px;height:33px;float:left;margin-left:22px;">
								</div>
								<div style="width:314px;height:33px;float:left;">
									<span style="font-size: 12px; font-weight: 420; float: left; margin-top: 0px;line-height: 15px;color: #363636; ">
									</span>
								</div>
							</div>
							
							<div style="width: 100%; height: 33px; float: left;">
								<div style="width:33px;height:33px;float:left;margin-left:22px;">
								</div>
								<div style="width:314px;height:33px;float:left;">
									<span style="font-size: 14px; font-weight: 420; float: left; margin-top: 0px;line-height: 33px; color: #363636;">
									</span>
								</div>
							</div>
							
							<div style="width: 100%; height: 33px; float: left;">
								<div style="width:33px;height:33px;float:left;margin-left:22px;">
								</div>
								<div style="width:282px;height:33px;float:left;overflow:hidden;">
									<span style="font-size: 14px; font-weight: 420; float: left; margin-top: 0px;line-height: 33px;color: #363636; ">
									</span>
								</div>
							</div>
							
						</div>
					</div>
					<div style="width:107px; height:551px; float:left;">
						<div style="width:98px; height:98px; float:left;margin-top: 110px; margin-left: 9px; ">
						</div>
					</div>			
				</div>
			</div>	
		</div>
	</td>
</tr>
</table>
</div>
<?php }?>