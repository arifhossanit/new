<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Purses Money Request</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Profile</a></li>
						<li class="breadcrumb-item active">Purses Money Request</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Purses Money Request</h3>
					</div>
					<div class="card-body">
						<form id="purses_money_request_form" action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="employee_id" value="<?php echo $_SESSION['super_admin']['employee_id']; ?>"/>
							<div class="row">
								<div class="col-sm-4"></div>
								<div class="col-sm-4">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<input type="text" name="amount" id="amount" class="form-control number_int" placeholder="Amount(BDT)" autocomplete="off" required />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<textarea name="note" id="note" class="form-control" style="height:120px;" placeholder="Required Purpose" required ></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<button name="send_request" type="submit" class="btn btn-success" style="float:right;">Send Request</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4"></div>
							</div>
							<div class="row">
								<div class="col-sm-12" style="padding-top:20px;padding-bottom:10px;">
									<div id="export_buttons_due"></div>
								</div>
								<div class="col-sm-12">
									<style>#due_data_table td{text-align:center;vertical-align: middle;}#due_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="candidate_list" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
										<thead>
											<tr>
												<th>ID</th>
												<th>Amount</th>
												<th>Note</th>
												<th>Date</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>									
										</tbody>
									</table>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	$('#purses_money_request_form').on("submit",function(){
		$('button[name="send_request"]').prop('disabled', true);
		return true;
	})
	
	
	
	
	var employee_id = <?php echo $_SESSION['user_info']['employee_id']; ?>;
	var condition = '?employee_id='+employee_id;
	var table = $('#candidate_list').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[25, 50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		"searching": true,
		"ordering": true,
		"scrollX": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/advance_money_request_datatable_data.php"+condition,
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
	table.buttons().container().appendTo($('#export_buttons_due'));
})
</script>