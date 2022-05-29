<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Demo Investor Corn Job Logs</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Report</a></li>
						<li class="breadcrumb-item"><a href="#">Communucation</a></li>
						<li class="breadcrumb-item active">Demo Investor Corn Job Logs</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	<div class="content">
		<div class="container">
			<div class="row">	
				<div class="col-sm-12">
					<?php 
					$today = date('d/m/Y', strtotime(date('Y/m/d'). ' - 1 days'));
					$check_data = $this->Dashboard_model->mysqlii("select  * from corn_jobs_log where reason = 'Demo Investor wallet reacharge & finished agreement corn job' and data = '".$today."' order by id desc");
					if(empty($check_data[0]->id)){
					?>
					<button onclick="window.open('<?php echo base_url('assets/corn_jobs/demo_ipo_member_wallet_recharge_monthly.php'); ?>','_blank')"  style="float:right;margin-bottom:15px;" class="btn btn-success" type="button">Run Corn job for - <?php echo $today; ?> Demo Investor Wallet</button>
					<?php } ?>
				</div>
				<div class="col-sm-12">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Demo Investor Corn Job Logs</h3>
							<div id="export_buttons_due" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#candidate_list td{text-align:center;vertical-align: middle;}#candidate_list th{text-align:center;vertical-align: middle;}</style>
							<table id="candidate_list" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
								<thead>
									<tr>
										<th>ID</th>
										<th>Reason</th>
										<th>Day</th>
										<th>Time</th>
										<th>Date</th>
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
<!----vaiw model-->
	<div class="modal fade" id="sms_model_details">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">View SMS</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="sms_result_details">					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/communication/demo_investor_corn_job_logs_report_datatable_data.php",
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