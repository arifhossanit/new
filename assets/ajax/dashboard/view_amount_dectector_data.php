<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){
?>
<div class="row">
	<div class="col-sm-12">
		<div id="sallary_list_export_buttons" style="float:right;"></div>
	</div>
	<div class="col-sm-12">
		<style>#sallary_list_data_table td{text-align:center;vertical-align: middle;}#sallary_list_data_table th{text-align:center;vertical-align: middle;}#sallary_list_data_table td:last-child{text-align:left;}</style>
		<table id="sallary_list_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
			<thead>
				<tr>
					<th>Work Date</th>
					<th>Branch</th>
					<th>Amount</th>
					<th>Head</th>
					<th>Type</th>
					<th>Note</th>
					<th>Uploader</th>
					<th>Date</th>					
				</tr>
			</thead>
			<tbody>	
<?php
$sql = $mysqli->query("SELECT * FROM details_report_deduction_logs WHERE work_date = '".$_POST['profile_id']."'");
while($row = mysqli_fetch_assoc($sql)){
	$branch = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$row['branch_id']."'"));
	$u = explode('___',$row['uploader_info']);
	$employee = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE email = '".$u[1]."'"));
?>			
				<tr>				
					<td><?php echo $row['work_date']; ?></td>
					<td><?php echo $branch['branch_name']; ?></td>
					<td><?php echo $row['amount']; ?></td>
					<td><?php echo $row['head_type']; ?></td>
					<td>
						<?php
							if($row['adj_type'] == 1){
								echo 'ADD MONEY';
							}else if($row['adj_type'] == 2){
								echo 'DEDUCT MONEY';
							}
						?>
					</td>
					<td><?php echo $row['note']; ?></td>
					<td><?php echo /* $employee['full_name'] .'-'. */ $employee['employee_id']; ?></td>
					<td><?php echo $row['data']; ?></td>				
				</tr>
<?php } ?>					
			</tbody>								
		</table>
	</div>
</div>
<script>
$('document').ready(function(){
	var table_booking = $('#sallary_list_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [ [500,550,1000], [500,550,1000] ],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": false,        
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#sallary_list_export_buttons'));
})
</script>	
<?php } ?>