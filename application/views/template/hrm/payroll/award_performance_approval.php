<style>
	.image-zoom {
		transition: transform .2s;
		/* Animation */
		width: 60px;
		height: 60px;
		margin: 0 auto;
		border-radius: 5px;
	}

	.image-zoom:hover {
		transform: scale(1.7);
		/* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
	}
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Performance Approval</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Employee Performance Approval</li>
					</ol>
				</div>
			</div>
		</div>
	</div>


	<div class="content">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-sm-11">
					<div class="card card-info">
						<div class="card-header">
							<i class="fas fa-sort-amount-up"></i> Employee Performance Logs
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-2 mb-3">
									<input id="month" class="form-control" type="month" value="<?= (!is_null($month_year)) ? date('Y-m', strtotime('01-' . $month_year)) :
																									date('Y-m'); ?>" onchange="change_month(this.value)">
								</div>
								<!-- <style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style> -->
								<div class="col-md-12">
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;">
										<thead>
											<tr>
												<th>#</th>
												<th>Photo</th>
												<th>Details</th>
												<th>Month</th>
												<th>Type</th>
												<th>Status</th>
												<th>Uploder</th>
												<th>Date</th>
												<th>Head:%</th>
												<th>H:Note</th>
												<th>A:%</th>
												<th>A:Note</th>
												<th>A:By</th>
												<th>Option</th>
												<th>name</th>
												<th>employee_id</th>
												<th>designation_name</th>
												<th>head_pay_cut</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
							<!-- <div align="left" style="position: absolute; margin-top: -32px;">
								<button type="button" id="select" class="btn btn-xs btn-warning"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
								<button type="button" id="unselect" class="btn btn-xs btn-success"><i class="fa fa-bars" aria-hidden="true"></i></button>
								&nbsp;|&nbsp;
								<button type="button" id="btn_delete_accept" class="btn btn-xs btn-success"><i class="fas fa-check-circle"></i></button>
								<button type="button" id="btn_delete_reject" class="btn btn-xs btn-danger"><i class="fas fa-times-circle"></i></button>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Accept Performance Bonus -->
	<div class="modal fade" id="accept_performance_bonus" tabindex="-1" role="dialog" aria-labelledby="change_passwordLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Performance Bonus</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="" method="post" enctype="multipart/form-data" id="update_manpower_office_form">
					<input type="hidden" id="manpower_id">
					<div class="modal-body">
						<div class="row justify-content-center">
							<div class="input-group col-md-8">
								<input class="form-control" type="number" id="final_percentage">
								<div class="input-group-append">
									<div class="input-group-text">%</div>
								</div>
							</div>
							<div class="col-md-11 mt-1">
								<p class="text-secondary" style="font-size: 18px;">Note:</p>
								<p class=" mt-0" id="approval_note" style="width: 100%;"></p>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button id="finally_approve" onclick="leave_accept_function(this.value)" type="submit" class="btn btn-primary btn-sm" id="update_button_manpower">Approve</button>
						<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	let show_more_note = (id) => {
		$('#note_field_' + id).html($('#full_text_' + id).html());
	}

	let bonus_accept_modal = (id, percentage, note) => {
		$('#approval_note').html(note);
		$('#final_percentage').val(percentage);
		$('#finally_approve').val(id);
	}

	$(document).ready(function() {
		$("#select").click(function() {
			$('input[id="leave_check"]').prop('checked', true);
		});
		$("#unselect").click(function() {
			$('input[id="leave_check"]').prop('checked', false);
		});

		let accept_reject = (id) => {
			$.ajax({
				url: "<?= base_url('assets/ajax/form_submit/hrm/leave/performance_approval_rejection_delete_ssubmit.php'); ?>",
				method: 'POST',
				data: {
					leave_rejects_ids: id
				},
				success: function() {
					$('#booking_data_table').DataTable().ajax.reload(null, false);
					alert(data);
				}
			});
		}

		$('#btn_delete_reject').click(function() {
			if (confirm("Are you sure you want to delete selected Iteam?")) {
				var id = [];
				$('input[id="leave_check"]:checked').each(function(i) {
					id[i] = $(this).val();
				});
				if (id.length === 0) {
					alert("Please Select atleast one checkbox");
				} else {
					$.ajax({
						url: "<?= base_url('assets/ajax/form_submit/hrm/leave/performance_approval_rejection_delete_ssubmit.php'); ?>",
						method: 'POST',
						data: {
							leave_rejects_ids: id
						},
						success: function() {
							$('#booking_data_table').DataTable().ajax.reload(null, false);
							alert(data);
						}
					});
				}
			} else {
				return false;
			}
		});
		$('#btn_delete_accept').click(function() {
			if (confirm("Are you sure you want to delete selected Iteam?")) {
				var id = [];
				$('input[id="leave_check"]:checked').each(function(i) {
					id[i] = $(this).val();
				});
				if (id.length === 0) {
					alert("Please Select atleast one checkbox");
				} else {
					$.ajax({
						url: "<?= base_url('assets/ajax/form_submit/hrm/leave/performance_approval_rejection_delete_ssubmit.php'); ?>",
						method: 'POST',
						data: {
							leave_aproved_ids: id
						},
						success: function() {
							$('#booking_data_table').DataTable().ajax.reload(null, false);
							alert(data);
						}
					});
				}
			} else {
				return false;
			}
		});
	});

	function leave_reject_function(id) {
		let approval_note = $('#approval_note_' + id).val();
		if (id != '') {
			if (confirm("Are you sure?")) {
				$.ajax({
					url: "<?= base_url('assets/ajax/form_submit/hrm/leave/performance_approval_rejection_delete_ssubmit.php'); ?>",
					method: "POST",
					data: {
						rejected_id: id,
						approval_note
					},
					beforeSend: function() {
						$('#data-loading').html(data_loading);
					},
					success: function(data) {
						$('#data-loading').html('');
						$('#booking_data_table').DataTable().ajax.reload(null, false);
						alert(data);
					}
				});
			}
		} else {
			alert('Something wrong! Please try again');
		}
	}

	function leave_accept_function(id) {
		let final_percentage = $('#final_percentage_' + id).val();
		let approval_note = $('#approval_note_' + id).val();

		if (id != '') {
			$.ajax({
				url: "<?= base_url('assets/ajax/form_submit/hrm/leave/performance_approval_rejection_delete_ssubmit.php'); ?>",
				method: "POST",
				data: {
					accept_id: id,
					final_percentage,
					approval_note
				},
				beforeSend: function() {
					$('#data-loading').html(data_loading);
				},
				success: function(data) {

					$('#data-loading').html('');
					$('#booking_data_table').DataTable().ajax.reload(null, false);
					trigger_alert();
				}
			});
		} else {
			alert('Something wrong! Please try again');
		}
	}

	let change_month = (selected_month) => {
		let ajax_data = "<?= base_url(); ?>assets/ajax/data_table/hrm/leave/employee_performance_approval_datatable.php?month=" + selected_month;
		$('#booking_data_table').DataTable().ajax.url(ajax_data).load();
	}

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
			"columnDefs": [{
					"targets": [10],
					"width": "8%",
				},
				{
					"targets": [9],
					"width": "25%",
				},
				{
					"targets": [0, 17],
					"visible": false,
					"searchable": false
				},
				{
					"targets": [14, 15, 16],
					"visible": false,
				}
			],
			"ajax": "<?= base_url(); ?>assets/ajax/data_table/hrm/leave/employee_performance_approval_datatable.php?month=" + $('#month').val() + <?= (!is_null($month_year)) ? '"&boss_selected=' . $month_year . '"' : '""'; ?>,
			dom: 'lBfrtip',
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
	})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>