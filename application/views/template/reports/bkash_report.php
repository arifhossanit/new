<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">bKash Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">bKash Report</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">					
					<div class="row">
						<div class="col-sm-12">
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title"><i class="far fa-bed"></i> bKash Report</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<div class="row mb-2">								
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-2">
                                                    <select name="branch" id="branch" class="form-control select2" onchange="booking_report_table()">
                                                        <?php if($_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
                                                            <option value="all">All Branches</option>
                                                        <?php } ?>
                                                        <?php foreach($banches as $branch){ ?>
                                                            <option value="<?php echo $branch->branch_code; ?>"><?php echo $branch->branch_name; ?></option>
                                                        <?php } ?>
                                                    </select>
												</div>
												<div class="col-sm-2">
													<input onchange="return booking_report_table()" id="date_range" type="text" class="form-control float-right date_range">
												</div>
												<div class="col-sm-2">
													<select name="transaction_type" id="transaction_type" class="form-control select2" onchange="booking_report_table()">
														<option value="all">All Type</option>
														<option>Credit</option>
														<option>Debit</option>
                                                    </select>
												</div>
											</div>											
										</div>
									</div>
								
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>Id</th>
												<th>Branch</th>
												<th>Member Name</th>
												<th>Care Of</th>
												<th>TXN Id</th>
												<th>bKsah TXN Id</th>
												<th>Credit Amount</th>
												<th>Debit Amount</th>
												<th>Date</th>
												<th>TXN:Type</th>
											</tr>
										</thead>
										<tbody>	
										</tbody>
                                        <tfoot>
                                            <tr>
												<th>Id</th>
												<th>Branch</th>
												<th>Member Name</th>
												<th>Care Of</th>
												<th>TXN Id</th>
												<th>bKsah TXN Id</th>												
												<th>Credit Amount</th>
												<th>Debit Amount</th>
												<th>Date</th>
												<th>TXN:Type</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>		
					
				</div>
			</div>
		</div>
	</div>
</div>



<script>
function booking_report_table(){
	let transaction_type = $('#transaction_type').val();
	let branch = $('#branch').val();
	let date_range = $("#date_range").val();	
    let condition = '?branch_id=' + branch + '&date_range=' + date_range + '&transaction_type=' + transaction_type;
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/bkash_report_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}
$('document').ready(function(){
    let branch = '?branch_id=' + $('#branch').val() + '&transaction_type=' + $('#transaction_type').val();
	// var other = 'booking_from='+$("#short_from").val()+'&booking_to='+$("#short_to").val()+'';
	// var report_info = '&'+other;
	// var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    // var condition = table_info+report_info;	
	var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": false,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/bkash_report_datatable.php"+branch,
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
        ],
		"columnDefs": [
            {
                "targets": [ 9 ],
                "visible": false,
                "searchable": false
            }
        ],
        "footerCallback": function(row, data, start, end, display) {
			var api = this.api();
			let total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
					var y = parseFloat(b) || 0;
					return x + y;
                }, 0 );
			let total_debit = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    var x = parseFloat(a) || 0;
					var y = parseFloat(b) || 0;
					return x + y;
                }, 0 );
			// $('#sum').html(total);
			var formatter = new Intl.NumberFormat('en-US', {
				style: 'currency',
				currency: 'BDT',

				// These options are needed to round to whole numbers if that's what you want.
				minimumFractionDigits: 2, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
				//maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
			});
			$( api.column( 6 ).footer() ).html(
                formatter.format(total)
            );
			$( api.column( 7 ).footer() ).html(
                formatter.format(total_debit)
            );
		}
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>