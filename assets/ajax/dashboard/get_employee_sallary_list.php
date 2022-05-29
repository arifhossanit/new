<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['unique_id'])){
	$info = mysqli_fetch_assoc($mysqli->query("select * from employee_sallary_generate_logs where unique_id = '".$_POST['unique_id']."'"));
	$total_amount = mysqli_fetch_assoc($mysqli->query("select sum(total_sallary) as total from employee_monthly_sallary where unique_id = '".$info['unique_id']."'"));
?>
<input type="hidden" id="sallary_unique_id" value="<?php echo $info['unique_id']; ?>"/>
<div class="row">
	<div class="col-sm-12" style="margin-bottom:20px;">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<select onchange="return sallary_payment_type_function()" id="sallary_payment_type" class="form-control select2">
								<option value="">--select payment type--</option>
								<option value="bank">Bank Payment</option>
								<option value="cash">Cash Payment</option>
							</select>
						</div>
					</div>
					<div class="col-sm-4">
						<center style="color:#f00;font-size:25px;">Total Sallary: <b><?php echo money($total_amount['total']); ?></b></center>
					</div>
					<div class="col-sm-4"></div>
				</div>
			</div>
			<div class="col-sm-6">
				<div style="float:right;" id="sallary_list_export_buttons"></div>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<style>#sallary_list_data_table td{text-align:center;vertical-align: middle;}#sallary_list_data_table th{text-align:center;vertical-align: middle;}#sallary_list_data_table td:last-child{text-align:left;}</style>
		<div class="table-responsive">
		<table id="sallary_list_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
			<thead>
				<tr>
					<th>#</th>
					<th>Employee</th>
					<th><abbr title="Department-Designation">Dept-Deg</abbr></th>
					<th>Joining Date</th>
					<th style="color: #f00;"><abbr title="Full Day Leave">FDL</abbr></th>
					<th style="color: #f00;"><abbr title="Half Day Leave">HDL</abbr></th>
					<th style="color: green;">Total Att:</th>
					<th style="color: #f00;">Total Abs:</th>
					<th><abbr title="Total Attendance Amount">T:Att: Amount</abbr></th>
					<th><abbr title="Over Deauty Bonus">OD:Bonus</abbr></th>
					<th><abbr title="Attendance Bonus">Att: Bonus</abbr></th>
					<th><abbr title="Performance Bonus">Prf:Bon<small>%</small></abbr></th>
					<th>Perday</th>					
					<th><abbr title="Salary Deduction">SD</abbr></th>
					<th><abbr title="Attendance Missing Deduction">AMD</abbr></th>
					<th><abbr title="Extra Salary">ES</abbr></th>
					<th><abbr title="Advance Loan Salary">ALS</abbr></th>
					<th>Total Sallary</th>
					<th><abbr title="Payment Type">PT</abbr></th>
					<th>Month</th>
					<th>Year</th>
					<th>Account Title</th>
					<th>Account Number</th>
					<th>Account Type</th>
				</tr>
			</thead>
			<tbody>	
			</tbody>								
		</table>
		</div>
	</div>
</div>
<script>
function sallary_payment_type_function(){
	var unique_id = $("#sallary_unique_id").val();
	var payment_type = $("#sallary_payment_type").val();
	var condition = '?unique_id='+unique_id+'&payment_type='+payment_type+'';
	var ajax_data = "<?php echo $home; ?>assets/ajax/data_table/hrm/pay_roll/employee_generate_sallary_list_datatable.php"+condition;
	$('#sallary_list_data_table').DataTable().ajax.url(ajax_data).load();
}
$('document').ready(function(){
	var unique_id = $("#sallary_unique_id").val();
	var payment_type = $("#sallary_payment_type").val();
	var condition = '?unique_id='+unique_id+'&payment_type='+payment_type+'';
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
        "serverSide": true,
		"fnRowCallback" : function(nRow, aData, iDisplayIndex){
			$("td:first", nRow).html(iDisplayIndex +1);
			return nRow;
		},
		"columnDefs": [
            {
                "targets": [ 19,20,21,22,23 ],
                "visible": false,
                "searchable": false
            },
        ],
        "ajax": "<?php echo $home; ?>assets/ajax/data_table/hrm/pay_roll/employee_generate_sallary_list_datatable.php"+condition,
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,21,22,23] } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#sallary_list_export_buttons'));
})
</script>	
<?php } ?>