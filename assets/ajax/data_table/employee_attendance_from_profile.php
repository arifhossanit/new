<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['employee_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".rahat_decode($_POST['employee_id'])."'"));
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
}
.days_name{
	float:left;
	margin-left:10px;
	color:#b4a4a4;
}
.att_name{
	float:right;
	margin-right:10px;
}
.table-bordered td, .table-bordered th{
	border: 1px solid #000000;
}
</style>
<div class="row">
	<div class="col-sm-12">
		<div id="export_buttons_attendance" style="float: right;"></div>
	</div>
	<div class="col-sm-12">
		<style>
			#attendance_data_table tr td {padding:0px;text-align:center;}
		</style>
		<table id="attendance_data_table" class="table table-sm table-striped table-bordered table-hover attendance_cus">
			<thead>
				<tr role="row">
					<th rowspan="1" colspan="1" style="width: 0px;"> Date / Month | <span style="color:red;font-weight:bolder;">(<?php echo '20',$_POST['years']; ?>)</span></th>
					<th rowspan="1" colspan="1" style="width: 0px;">Jan</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Feb</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Mar</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Apr</th>
					<th rowspan="1" colspan="1" style="width: 0px;">May</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Jun</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Jul</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Aug</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Sep</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Oct</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Nov</th>
					<th rowspan="1" colspan="1" style="width: 0px;">Dec</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = '1';
				$year = $_POST['years'];
				for($i ; $i < 32; $i++ ){
				?>
				<tr role="row" class="odd">                                                
					<td style="font-weight:bolder;"><?php echo $i; ?></td>
					<?php for($j = 1; $j < 13; $j++ ){ ?>
					<td>
						<?php 
							if($year >= 21){
								$get_leave = mysqli_fetch_assoc($mysqli->query("SELECT employee_everyday_leave_logs.id, employee_everyday_leave_logs.h_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.e_db_id = '".$row['id']."' AND employee_everyday_leave_logs.days = '".sprintf("%02d", $i)."' AND employee_everyday_leave_logs.month = '".sprintf("%02d", $j)."' AND employee_everyday_leave_logs.year = '20".$year."' AND employee_everyday_leave_logs.status = 1 AND employee_leave_logs.aproval = 1 AND employee_leave_logs.h_aproval in (1,3) LIMIT 1"));
							}else if($i >= 1 AND $j >= 9){
								$get_leave = mysqli_fetch_assoc($mysqli->query("SELECT employee_everyday_leave_logs.id, employee_everyday_leave_logs.h_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.e_db_id = '".$row['id']."' AND employee_everyday_leave_logs.days = '".sprintf("%02d", $i)."' AND employee_everyday_leave_logs.month = '".sprintf("%02d", $j)."' AND employee_everyday_leave_logs.year = '20".$year."' AND employee_everyday_leave_logs.status = 1 AND employee_leave_logs.aproval = 1 AND employee_leave_logs.h_aproval in (1,3) LIMIT 1"));
							}else{
								$get_leave = null;
							}
							$get = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where e_db_id = '".$row['id']."' AND days = '".sprintf("%02d", $i)."' AND month = '".sprintf("%02d", $j)."' AND years = '".$year."' order by id asc"));
							echo '<small class="days_name">'.date('l', strtotime(sprintf("%02d", $i).'-'.sprintf("%02d", $j).'-20'.$year)).'</small>&nbsp;&nbsp;';
							if(!is_null($get_leave)){
								if($get_leave['h_days'] == '0.5'){
									echo '<span class="att_name" style="font-weight:bolder;color:#8500ff;">H</span>';
								}else{
									echo '<span class="att_name" style="font-weight:bolder;color:red;">L</span>';
								}
							}else{								
								if(!empty($get['id'])){
									if($get['attendance'] == '1'){
										if($get['note'] == 'half'){
											echo '<span class="att_name" style="font-weight:bolder;color:#8500ff;">H</span>';
										}else if($get['note'] == 'home'){
											echo '<span class="att_name" style="font-weight:bolder;color:blue;">W</span>';
										}else{
											echo '<span class="att_name" style="font-weight:bolder;color:green;">P</span>';
										}
									}else{
										echo '<span class="att_name" style="font-weight:bolder;color:red;">A</span>';
									}															
								}else{
									echo '<span class="att_name" style="color:#f00;">--</span>';
								}
								
							}
						?>
					</td>
					<?php } ?>												
				</tr>
				<?php
				}
				?>	
						
			</tbody>
		</table>
	</div>
</div>
<script>
$(document).ready(function() {
    var table_booking = $('#attendance_data_table').DataTable({
		"pageLength": 50,
		"paging": false,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": false,
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
	
<?php } ?>