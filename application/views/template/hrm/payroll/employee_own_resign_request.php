<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Resign Application</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item"><a href="#">Request</a></li>
						<li class="breadcrumb-item active">Employee Resign Application</li>
					</ol>
				</div>
			</div>
		</div>
	</div>


	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="card card-info">
						<div class="card-header">
							<i class="fas fa-sort-amount-up"></i> Write Information
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<?php if(!is_null($petty_balance) AND $petty_balance->amount > 0) { ?>
										<p class="text-danger text-center text-bold" style="font-size: 25px;">You sould clear your accounts first!</p>
									<?php }else {?>
										<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
											<input type="hidden" name="employee_id" value="<?php echo $_SESSION['user_info']['employee_id']; ?>" />
											<div class="form-group">
												<label>Write Application</label>
												<textarea name="application" id="editor1" style="height:400px;" placeholder="Wrirte Application" class="form-control" required="required"></textarea>
											</div>
											<div class="form-group" style="margin-top: 20px;">
												<label>Resign Date : </label>
												<input type="date" name="resign_date" required>
											</div>
											<div class="form-group">
												<button name="apply" type="submit" class="btn btn-warning" style="float:right;">Apply</button>
											</div>
										</form>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$("#select").click(function() {
			$('input[id="leave_check"]').prop('checked', true);
		});
		$("#unselect").click(function() {
			$('input[id="leave_check"]').prop('checked', false);
		});

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
		if (id != '') {
			if (confirm("Are you sure?")) {
				$.ajax({
					url: "<?= base_url('assets/ajax/form_submit/hrm/leave/performance_approval_rejection_delete_ssubmit.php'); ?>",
					method: "POST",
					data: {
						rejected_id: id
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
		if (id != '') {
			if (confirm("Are you sure?")) {
				$.ajax({
					url: "<?= base_url('assets/ajax/form_submit/hrm/leave/performance_approval_rejection_delete_ssubmit.php'); ?>",
					method: "POST",
					data: {
						accept_id: id
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
			"ajax": "<?= base_url(); ?>assets/ajax/data_table/hrm/leave/employee_performance_approval_datatable.php",
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
<script>
	CKEDITOR.replace('editor1', {});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>