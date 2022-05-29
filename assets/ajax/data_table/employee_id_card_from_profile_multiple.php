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
		<div class="col-sm-12" id="print_area"> <!--id="download_id_card" -->
		<div style="width:650px;height:602px;background:url(<?php echo $home; ?>assets/img/id_cardnew.png) no-repeat; background-size: cover;">
			<div style="width: 307px; height: 489px; margin-left: 3px; margin-top: 3px; float: left;">
				<?php if(!empty($row['photo'])){ ?>
				<img src="<?php echo $home.$row['photo']; ?>" style="width: 133px; height: 133px; margin-top: 143px; margin-left: 87px; border-radius: 200px;"/>
				<?php } else { ?>
				<img src="<?php echo $home; ?>assets/img/photo_avatar.png" style="width: 133px; height: 133px; margin-top: 143px; margin-left: 87px; border-radius: 200px;"/>
				<?php } ?>
				<br />
				<center style="margin-top:24px;color:#000;"> <!--#2380ae-->
					<span><b><?php echo $row['full_name']; ?></b></span><br />
					<span><?php echo $row['designation_name']; ?> - <?php echo $row['department_name']; ?></span><br />
					<?php /* ?><span><?php echo $row['job_responsibilities']; ?></span><br /><?php */ ?>
					<span>Employee ID Number: <?php echo $row['employee_id']; ?></span>
				</center>
			</div>
			<div style="width: 307px; height: 489px; margin-left: 29px; margin-top: 3px; float: left;">
				<center style="color:#fff;">
					<p style="margin: 0px; margin-top: 10px; font-size: 14px; "><b>Issue Date:</b> <?php $dt = explode("/",$row['date_of_joining']); $date = $dt[2].'-'.$dt[1].'-'.$dt[0]; echo date_format(date_create($date),"d M Y"); ?></p>
					<p style="margin: 0px; margin-top: -6px; font-size: 14px;"><b>Expire Date:</b> <?php echo date('d M Y', strtotime('+2 years', strtotime($date))); ?></p>
				</center>
				<img src="<?php echo $home.'assets/uploads/qrcode/employee_q_code_id_'.$row['id'].'.png'; ?>" style="width: 121px; height: 121px; margin-top: 21px; margin-left: 93px;">
				<center style="color:#2380ae;">
					<p style="margin: 0px; margin-top: 21px;  "><b>Blood Group:</b> <?php echo $row['blood_group']; ?></p>
				</center>
			</div>
			
		</div>	
		<div>
		<div style="width: 375px; height: 58px; margin-left: 86px; margin-top: -59px; float: left;">
				<div style="width: 45px; height: 58px; margin-left: 36px; margin-top: 3px; float: left;">
					<?php if(!empty($row['photo'])){ ?>
					<img src="<?php echo $home.$row['photo']; ?>" style="width: 39px; height: 39px; margin-top: 7px; margin-left: 2px; border-radius: 200px;"/>
					<?php } else { ?>
					<img src="<?php echo $home; ?>assets/img/photo_avatar.png" style="width: 39px; height: 39px; margin-top: 7px; margin-left: 2px; border-radius: 200px;"/>
					<?php } ?>
				</div>
				<div style="width: 278px; height: 58px; margin-left: 10px; margin-top: 3px; float: left;color: #2380ae;">
					<p style="margin:0px; margin-top: 3px;text-align:center;"><b><?php echo $row['full_name']; ?></b></p>
					<p style="margin:0px;margin-top: -3px; font-size: 13px;text-align:center;"><?php echo $row['designation_name']; ?> - <?php echo $row['department_name']; ?> (<?php echo $row['employee_id']; ?>)</p>
				</div>
			</div>
		</div>
	</div>
	</td>
	
<?php echo ($i % 2 != 0) ? '</tr>' : '' ?>
<?php $i++; } ?>

</table>
</div>
<?php }?>