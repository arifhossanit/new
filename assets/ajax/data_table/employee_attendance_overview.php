<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['years'])){ 

$year = '20'.$_POST['years'];
$month = sprintf("%02d", $_POST['month']);



?>
<style>
.attendance_cus tr td{
	text-align:center;
}
#export_buttons_attendance button{
	display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	background-color: #f2f2f2;
	margin-bottom:15px;
}
</style>
<div class="row">
	<div class="col-sm-12">
		<div id="export_buttons_attendance" style="float: right;"></div>
	</div>
	<div class="col-sm-12">
		<table id="attendance_data_table" class="table table-sm table-striped table-bordered table-hover attendance_cus">
			<thead>
				<tr role="row">
					<th rowspan="1" colspan="1" style="width: 0px;">E:ID</th>
					<th rowspan="1" colspan="1" style="width: 0px;"> Employee | Days <span style="color:red;font-weight:bolder;">(<?php echo '20',$_POST['years']; ?> - <?php echo $month; ?>)</span></th>					
<?php 
$number_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
for($b = '01'; $b <= $number_of_month; $b++){
					echo '<th rowspan="1" colspan="1" style="width: 0px;">'.sprintf("%02d", $b).'</th>';
}
?>					
					<th style="color:green;">Present</th>
					<th style="color:red;">Absent</th>
				</tr>
			</thead>
			<tbody>
<?php
if(!empty($_POST['emp_type'])){
	if($_POST['emp_type'] == 1){
		$status = "where status = '1'";
	}else if($_POST['emp_type'] == 2){
		$status = "where status = '0'";
	}
}else{
	$status = "";
}
$sql = $mysqli->query("select id, employee_id, full_name, status from employee ".$status." order by id asc"); //where status = '1'
while($row = mysqli_fetch_assoc($sql)){
?>
				<tr>
					<td style="text-align:left;"> <?php echo $row['employee_id']; ?> <?php if($row['status'] == 1 ){}else{ ?><span style="background-color:#f00;border-radius:10px;color: #fff;">.</span><?php } ?></td>
					<td style="text-align:left;"> <?php echo $row['full_name']; ?> </td>					
<?php 
$present = '0';
$number_of_month = cal_days_in_month(CAL_GREGORIAN,$month,$year);
for($m = '1'; $m <= $number_of_month; $m++){
	$att = mysqli_fetch_assoc($mysqli->query("select id, attendance from employee_attendence where e_db_id = '".$row['id']."' and days = '".sprintf("%02d", $m)."' and month = '".sprintf("%02d", $_POST['month'])."' and years = '".$_POST['years']."'"));
?>
					<td>
						<?php
							if(!empty($att['id'])){
								if($att['attendance'] == '1'){
									echo '<span style="font-weight:400;color:green;">P</span>';
									$present = $present + 1;
								}else{
									echo '<span style="font-weight:400;color:red;">A</span>';
								}															
							}else{
								echo '<span style="color:red;">--</span>';
							}
						?>
					</td>
<?php } ?>
					<td style="font-weight:bolder;color:green;"><?php echo $present; ?></td>
					<td style="font-weight:bolder;color:red;">
						<?php 
							$absent = $number_of_month - $present;
							if($absent > 0){
								echo $absent;
							}else{
								echo '0';
							}
							
						?>
					</td>
				</tr>
<?php } ?>				
			</tbody>
		</table>
	</div>
</div>
<script>
$(document).ready(function() {
    var table_booking = $('#attendance_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"info": true,
		"scrollX": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": false,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            }
        ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons_attendance'));	
})
</script>	
<?php  } ?>