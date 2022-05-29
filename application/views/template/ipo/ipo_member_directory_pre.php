<!-- Authorize -->
<div class="modal fade exchange inner_modal" tabindex="-1" role="dialog" id="authorize_ipo">
	<div class="modal-dialog modal-dialog-report" role="document">
		<form action="<?=base_url();?>ipo-member/authorize-pre-ipo-member" method="post" enctype="multipart/form-data" id="cancel_form">
			<input type="hidden" name="cancel_aggrement_id" id="cancel_aggrement_id">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Authorize Investment Member</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="exchange_close()">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="showAgentReportDiv">
					<input type="hidden" name="authorize_id" id="authorize_id">
					<label for="name">Card Number</label>
					<input class="form-control" name="card_number" id="card_number" type="text" placeholder="Enter Card Number" required>
				</div>
				<div class="modal-footer">
					<button class="btn btn-warning" style="color: #000">Authorize</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="exchange_close()">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Pre-registered Investment Member Directory</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Pre-registered Investment Member Directory</li>
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
						<div class="col-sm-12" style="margin-bottom:20px;">							
							<button type="button" onclick="window.open('<?php echo base_url('admin/ipo'); ?>','_self')" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="fas fa-fast-backward"></i> &nbsp;&nbsp;Back</button>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="card card-dark">
								<div class="card-header">
									<h3 class="card-title">Pre-registered Investment Member Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
										<thead>
											<tr>
												<th>id</th>
												<th>Image</th>
												<th>Card:No</th>
												<th>Name</th>
												<th>Phone</th>
												<th>Email</th>
												<th>NID</th>
												<th>Bank</th>												
												<th>Account Number</th>
												<th style="width:170px;">Option</th>
											</tr>
										</thead>
										<tbody>	
										</tbody>
										<tfoot>
											<tr>
												<th>id</th>
												<th>Image</th>
												<th>Card:No</th>
												<th>Name</th>
												<th>Phone</th>
												<th>Email</th>
												<th>NID</th>
												<th>Bank</th>												
												<th>Account Number</th>
												<th style="width:170px;">Option</th>
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
function authorize(id){
	$('#authorize_id').val(id);
}
$(document).ready(function(){
    var table = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, -1],
			[10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, "All Data"]
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_member_directory_datatable_pre.php",
		initComplete: function() {
            var api = this.api();
            api.columns().every(function() {
                var that = this;
 
                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        },
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
	$('#booking_data_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input style="border:none;" type="text" class="form-control" title="Search By ' + title + '" placeholder="Search ' + title + '" />');
    });
})
</script>