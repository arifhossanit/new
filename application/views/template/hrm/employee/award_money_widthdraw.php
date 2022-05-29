<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Widthdraw Money</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item active">Widthdraw Money</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">							
				<div class="col-sm-3" style="padding-top:20px;">				
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Write Your Self</h3>
						</div>
						<div class="card-body">	
							<form action="<?php echo current_url(); ?>" method="post">
								<input type="hidden" name="employee_id" value="<?php if(!empty($_SESSION['super_admin']['employee_ids'])){ echo $_SESSION['super_admin']['employee_ids'];} ?>"/>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>Amount</label>
											<input type="text" name="amount" class="number_int form-control" placeholder="Amount" autocomplete="off" required />
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Password</label>
											<input type="password" name="password" class="form-control" placeholder="User Password" autocomplete="off" required />
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Note</label>
											<textarea name="note" class="form-control" placeholder="note"></textarea>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<button name="send_request" type="submit" class="btn btn-success" style="float:right;">Send Request</button>
										</div>
									</div>
								</div>
							</form>		
						</div>
					</div>			
				</div>
				<div class="col-sm-9" style="padding-top:20px;">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">My Widthdrawral List</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
								<thead>
									<tr>
										<th>id</th>
										<th>Amount</th>
										<th>Note</th>
										<th>Request Date</th>
										<th>Aproval</th>
										<th style="width:170px;">Option</th>
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
$(document).ready(function(){
    var table = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500, -1],
			[10, 25, 50, 100, 500, "All Data"]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/employee_wallet_money_widthdraw_request_list.php",
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
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
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table.buttons().container().appendTo($('#export_buttons'));
})
</script>