<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Petty Cash Request</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Profile</a></li>
						<li class="breadcrumb-item active">Petty Cash Request</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
<?php
	$branch_id = $_SESSION['super_admin']['branch'];
	$_GET_BRANCH_INFO = $this->Dashboard_model->mysqlii("SELECT * FROM branches WHERE branch_id = '".$branch_id."'");
	$_GET_P_CASH = $this->Dashboard_model->mysqlii("SELECT * FROM branch_petty_cash WHERE branch_id = '".$branch_id."'");
	$max_limit_request = $_GET_BRANCH_INFO[0]->petty_cash_limit - $_GET_P_CASH[0]->amount;
	
?>	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Petty Cash Request</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="branch_id" value="<?php echo $_SESSION['super_admin']['branch']; ?>"/>
							<div class="row">
								<div class="col-sm-4">
								
								</div>
								<div class="col-sm-4">
									<!--<div class="row">
										<div class="col-sm-12">
											<div class="form-group">-->
												<input type="hidden" name="amount" id="amount" value="<?php if(!empty($max_limit_request)){ echo $max_limit_request; } ?>" class="form-control number_int" placeholder="Amount(BDT)" autocomplete="off" readonly />
											<!--</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">-->
												<textarea name="note" id="note" class="form-control" style="height:120px;" placeholder="Required Purpose" hidden ></textarea>
											<!--</div>
										</div>
									</div>-->
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<button name="send_request" type="submit" class="btn btn-success" style="float:right;width:100%;"><i class="fas fa-coins"></i> &nbsp;&nbsp;&nbsp;Send Request</button>
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
												<!--<th>Amount</th>-->
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
	var branch_id = '<?php echo $branch_id; ?>';
	var condition = '?branch_id='+branch_id;
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/petty_cash_request_datatable_data.php"+condition,
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