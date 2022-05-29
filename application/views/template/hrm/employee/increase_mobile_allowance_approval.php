<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Moblice Allowance Approval </h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Moblice Allowance Approval </li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			
			<div class="row justify-content-center">
				<div class="col-sm-10">				
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">All requests </h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<style>.employee .form-group{margin-right:10px;}</style>
						<div class="card-body" style="overflow-x:scroll;">						
							<style>#employee_data_table td{text-align:center;vertical-align: middle;}#employee_data_table th{text-align:center;vertical-align: middle;}</style>
							<table id="employee_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
							   <thead>
								  <tr>
									 <th>Id</th>
									 <th>Photo</th>
									 <th>Requested By</th>
									 <th>Requested Amount</th>
									 <th>Approved Amount</th>
									 <th>Requested At</th>
									 <th>Status</th>
									 <th>Note</th>
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
<!----Approval Modal-->
<div class="modal fade" id="approval_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" id="approval_form">
                <div class="modal-header btn-primary">
                    <h4 class="modal-title" id="approval_modal_title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
						<input type="hidden" name="approval_id" id="approval_id">
						<input type="hidden" name="approval_type" id="approval_type">
						<input type="hidden" name="approving_by" id="approving_by">
						<label for="approved_amount">Approve Amount</label>
						<input class="form-control" type="number" name="approved_amount" id="approved_amount" >
						<textarea class="form-control mt-4" name="note" id="note" cols="30" rows="5" placeholder="Add Note"></textarea>
                    </div>
                </div>
                <div class="modal-footer text-end">
                    <button type="submit" id="approval_button" class="btn"></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!----End Approval Modal-->


<script>
$('#approval_form').on('submit', (e) => {
	e.preventDefault();
	var form = $('#approval_form')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?=base_url('admin/profile/increase-mobile-allowence-approval-submit');?>",  
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#approval_modal').modal('toggle');
			$('#employee_data_table').DataTable().ajax.reload( null , false);
		}
	});
})

let approval_modal = (id, approving_by, approval_type, approved_amount) => {
	$('#approval_modal').find('.modal-header').removeClass('btn-success');
	$('#approval_button').removeClass('btn-success');
	$('#approval_modal').find('.modal-header').removeClass('btn-danger');
	$('#approval_button').removeClass('btn-danger');
    if(approval_type == 'accept'){
        $('#approval_modal_title').html('Allowance Increase Accept');
        $('#approval_button').html('Accept');
        $('#approval_modal').find('.modal-header').addClass('btn-success');
        $('#approval_button').addClass('btn-success');
    }else{
        $('#approval_modal_title').html('Allowance Increase Reject');
		$('#approval_button').html('Reject');
        $('#approval_modal').find('.modal-header').addClass('btn-danger');
        $('#approval_button').addClass('btn-danger');
    }

	$('#approved_amount').val(approved_amount);
	$('#approval_id').val(id);
	$('#approval_type').val(approval_type);
	$('#approving_by').val(approving_by);
	$('#approval_modal').modal('toggle');
}
$(document).ready(function() {
    var table = $('#employee_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/mobile_allowance_approval_datatable.php",
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
});
</script>
