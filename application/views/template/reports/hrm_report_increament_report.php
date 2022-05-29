<style>
	.not-seen {
		background-color: green;
		color: yellow;
	}
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Increament Report</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Report</a></li>
						<li class="breadcrumb-item active">Employee Increament Report</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-info">
						<div class="card-header">
							<i class="fas fa-sort-amount-up"></i> Increament Logs
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>
								#booking_data_table td {
									text-align: center;
									vertical-align: middle;
								}

								#booking_data_table th {
									text-align: center;
									vertical-align: middle;
								}

								#booking_data_table td:last-child {
									text-align: left;
								}
							</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table " style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>Image</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Designation From</th>
										<th>Designation To</th>
										<th>Joining salary</th>
										<th>Total Increament</th>
										<th>Total Decreament</th>
										<th>Increament Amount</th>
										<th>Request Date</th>
										<th>Start Date</th>
										<th>Uploder</th>
										<th>Status</th>
										<th>notification</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<form id="removeStatusChangeForm">
		<input id="make_status_zero" name="make_status_zero" type="hidden" value="<?= $increament_color ?>">
	</form>

</div>
<script>
	$(document).ready(function() {
		var table_booking = $('#booking_data_table').DataTable({
			"paging": true,
			"lengthChange": true,
			"lengthMenu": [
				[10, 25, 50, 100, 500],
				[10, 25, 50, 100, 500]
			],
			"searching": true,
			"ordering": true,
			"order": [
				[0, "desc"]
			],
			"info": true,
			"autoWidth": false,
			"responsive": false,
			"ScrollX": true,
			"processing": true,
			"serverSide": true,
			"ajax": "<?= base_url('assets/ajax/data_table/hrm/pay_roll/employee_increament_hrm_report_datatable.php')  ?>",
			dom: 'lBfrtip',
			columnDefs: [{
				targets: [13],
				visible: false
			}, ],
			createdRow: function(row, data, index) {
				//
				// if the second column cell is blank apply special formatting
				//
				if (data[13] == "1") {
					$(row).addClass("not-seen");
				}
			},
			buttons: [{
				extend: 'copy',
				text: '<i class="fas fa-copy"></i> Copy',
				titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
			}, {
				extend: 'excel',
				text: '<i class="fas fa-file-excel"></i> Excel',
				titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
			}, {
				extend: 'csv',
				text: '<i class="fas fa-file-csv"></i> CSV',
				titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
			}, {
				extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
				text: '<i class="fas fa-file-pdf"></i> PDF',
				titleAttr: 'PDF'
			}, {
				extend: 'print',
				text: '<i class="fas fa-print"></i> Print',
				titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
			}, {
				extend: 'colvis',
				text: '<i class="fas fa-list"></i> Column Visibility',
				titleAttr: 'Column Visibility'
			}]

		});
		table_booking.buttons().container().appendTo($('#export_buttons'));

		<?php if (!empty($increament_color)) { ?>
			setTimeout(() => {
				var formData = {
					make_status_zero: $("#make_status_zero").val(),
				};

				$.ajax({
					type: "POST",
					url: "<?= base_url('assets/ajax/data_table/hrm/pay_roll/employee_increament_hrm_report_datatable.php')  ?>",
					data: formData,
					dataType: "json",
					encode: true,
				}).done(function(data) {
					alert(data);
				});
			}, 1000);
		<?php } ?>

	})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>