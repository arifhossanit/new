<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Joining Request</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Employee Directory</a></li>
						<li class="breadcrumb-item active">Employee Joining Request</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	<div class="content">
		<div class="container-fluid">
			<div class="row">			
				<div class="col-sm-12">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Employee Joining Request</h3>
							<div id="export_buttons_due" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#due_data_table td{text-align:center;vertical-align: middle;}#due_data_table th{text-align:center;vertical-align: middle;}</style>
							<table id="candidate_list" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
								<thead>
									<tr>
										<th>ID</th>
										<th>Image</th>
										<th>Employee_Id</th>
										<th>Name</th>
										<th>Phone</th>
										<th>Email</th>
										<th>NID</th>
										<th>Attachment</th>
										<th>Date</th>
										<th>Option</th>
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
</div>

<script>
$('document').ready(function(){
	var table = $('#candidate_list').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[25, 50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/recruitment/employee_prebook_request_datatable_data.php",
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