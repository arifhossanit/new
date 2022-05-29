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
		<div style="width:780px;height:602px;background:url(<?php echo $home; ?>assets/img/obscard.png) no-repeat; background-size: cover;">
			<div style="width: 307px; height: 489px; margin-left: 3px; margin-top: 3px; float: left;">
				
				
			</div>
			
			
		</div>	
		<div>
		
	</div>
	</td>
	
<?php echo ($i % 2 != 0) ? '</tr>' : '' ?>
<?php $i++; } ?>

</table>
</div>
<?php }?>