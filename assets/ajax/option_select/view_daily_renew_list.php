<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){ ?>
<div class="card card-warning">
	<div class="card-header">
		<b><i class="fas fa-chart-pie mr-1"></i> Daily Renew</b>
		<div id="export_buttons_renew" style="float: right;height: 23px;"></div>
	</div>									
	<div class="card-body">
		<style>#renew_data_table td{text-align:center;vertical-align: middle;}#renew_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
		<table id="renew_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
			<thead>
				<tr>
					<th>Name</th>
					<th>Renew_Date</th>
					<th>CheckIN_Date</th>
					<th>Service</th>												
					<th>Package</th>
					<th>Branch</th>
					<th>Source</th>
					<th>Occupation</th>
					<th><i class="fa fa-eye"></i></th>
				</tr>
			</thead>
			<tbody>	
			</tbody>
		</table>
	</div>
</div>
<script>
$(document).ready(function() {
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
	var table_booking = $('#renew_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25],
			[10, 25]
		],
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
		"serverSide": true,
		"ajax": "<?php echo $home; ?>assets/ajax/data_table/daily_renew_information_dashboard_datatable.php"+table_info,

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
	table_booking.buttons().container().appendTo($('#export_buttons_renew'));	
})
</script>
<?php } ?>