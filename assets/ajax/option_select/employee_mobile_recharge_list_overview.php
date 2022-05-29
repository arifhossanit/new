<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['post_id'])){ ?>
<div class="row">	
	<div class="col-sm-12">
		<style>#employee_data_table td{text-align:center;vertical-align: middle;padding:0px;}#employee_data_table th{text-align:center;vertical-align: middle;}.image_employee:hover{transform:scale(1.5);}</style>
		<div id="export_buttons_mobile_recharge" class="btn-group" role="group" aria-label="Basic example"></div>
		<table id="recharge_employee_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
			<thead>
				<tr>
					<th>Employee Info</th>
					<th>Department</th>
					<th>Designation</th>
					<th>Number</th>
					<th>Amount</th>				 
				</tr>
			</thead>
			<tbody>
<?php
$sql = $mysqli->query("SELECT * FROM employee WHERE status = '1' ORDER BY employee_id ASC");
$total_result = 0;
while($row = mysqli_fetch_assoc($sql)){
	if(!empty($row['mobile_allowance']) AND !empty($row['Company_phone'])){
?>			
				<tr>
					<td><?php echo $row['full_name'].'-'.$row['employee_id']; ?></td>
					<td><?php echo $row['department_name']; ?></td>
					<td><?php echo $row['designation_name']; ?></td>
					<td style="text-align:center;">
						<?php
							if(!empty($row['Company_phone'])){
								echo substr($row['Company_phone'], -10);
							}else{
								echo '<span style="color:#f00;">Empty!</span>';
							}
						?>
					</td>				
					<td style="text-align:center;">
						<?php
							if(!empty($row['mobile_allowance'])){
								echo $row['mobile_allowance'];
								if((int)$row['mobile_allowance'] < 500){
									$mobile_allowance = 0;
								}else{
									$mobile_allowance = (int)$row['mobile_allowance'];
								}								
							}else{
								echo '<span style="color:#f00;">Empty!</span>';
								$mobile_allowance = 0;
							}							
						?>
					</td>
				</tr>
<?php 
	$total_result = $total_result + $mobile_allowance;
	}
} 
?>
<?php
$total_result2 = 0;
$e_sql = $mysqli->query("select * from add_extrarecharge_number where status = '1' order by employee_id asc");
while($e_row = mysqli_fetch_assoc($e_sql)){
	$emp_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE employee_id = '".$e_row['employee_id']."'"));
?>
				<tr>
					<td>
						<?php echo $emp_info['full_name']; ?> - <?php echo $emp_info['employee_id']; ?>
						<br />
						(<?php echo $e_row['purpose']; ?>)
						<div title="Extra Mobile Recharge List" style="height:6px;width:6px;border-radius:10px;background-color:#f00;float: right;"></div>
					</td>
					<td><?php echo $emp_info['department_name']; ?></td>
					<td><?php echo $emp_info['designation_name']; ?></td>
					<td style="text-align:center;"><?php echo substr($e_row['phone_number'], -10); ?></td>
					<td style="text-align:center;"><?php echo $e_row['amount']; ?></td>
				</tr>
<?php 
	$total_result2 = $total_result2 + $e_row['amount'];
} 
?>
			</tbody>
		</table>
	</div>
	<div class="col-sm-12">
		<abbr title="Employee are not visiable whois Official phone number & Recharge amount is empty!!" style="color:#f00;"><i class="fas fa-question-circle"></i></abbr>
		Total: <span style="color:#f00;float:right;font-weight:bolder;"><?php echo money($total_result + $total_result2); ?></span>
	</div>
</div>
<script>
$(document).ready(function() {
    var table = $('#recharge_employee_data_table').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": false,
		"order": [[ 0, "asc" ]],
		"info": false,
		"autoWidth": false,
		"responsive": false,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table.buttons().container().appendTo($('#export_buttons_mobile_recharge'));
});
</script>
<?php } ?>