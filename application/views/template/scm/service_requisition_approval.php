<!-- Service Request Approval -->
<div class="modal fade" id="service_approval">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="" id="service_approval_form" method="post">
                <input type="hidden" name="approval_of" id="approval_of">
                <input type="hidden" name="approval_type" id="approval_type">
				<div class="modal-header" id="modal_header">
					<h4 class="modal-title" id="modal_title">Approve</h4>
				</div>
				<div class="ml-3 text-danger" id="error_message"></div>
				<div class="modal-body" id="service_approval_div">
                    <textarea class="form-control" name="note" id="note" cols="30" rows="2" placeholder="Note"></textarea>                    
				</div>
				<div class="modal-footer">
					<button id="submit_button" type="submit" class="btn btn-sm"></button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Service Requisition</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
		<div class="container-flud">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h4>Service Products</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm text-center table-bordered table-hover mt-4" id="service_requisition_approval_table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Photo</th>
                                        <th>Requisition For</th>
                                        <th>Time from</th>
                                        <th>Time to</th>
                                        <th>Total duration</th>
                                        <th>Destination from</th>
                                        <th>Destination to</th>
                                        <th>Note</th>
                                        <th>Requested By</th>
                                        <th>Requested Submitted At</th>
                                        <th>Option</th>
                                        <th>description</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                    
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
$('#service_approval_form').on('submit', () => {
    event.preventDefault();        
    var form = $('#service_approval_form')[0];
    var data = new FormData(form);
    $.ajax({  
        type: 'POST',
        enctype: 'multipart/form-data',
        url:"<?=base_url('assets/ajax/scm/service_approval.php')?>",  
        data: data,
        processData: false,
        contentType: false,
        beforeSend:function(){
            $('#submit_button').html('<i class="fas fa-spinner fa-spin"></i>');
            $('#submit_button').prop('disabled', true);
        },
        success:function(data){
            let info = JSON.parse(data);
            if(info.error){
                $('#error_message').html(info.message);
                $('#submit_button').prop('disabled', false);
                $('#submit_button').html($('#modal_title').html());
            }else{
                $('#service_approval').modal('hide');
                $('#error_message').html('');
                $('#service_requisition_approval_table').DataTable().ajax.reload( null , false);									
            }
            // $('#product_bill_div').html(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('#error_message').html(thrownError);
            $('#submit_button').prop('disabled', false);
            $('#submit_button').html('Submit');
        }
    });
});

let service_product_approval = (approval_type, approval_of) => {
    if(approval_type == 'approve'){
        $('#modal_title').html('Approve');
        $('#submit_button').html('Approve');
        $('#modal_header').removeClass('btn-danger');
        $('#submit_button').removeClass('btn-danger');        
        $('#modal_header').addClass('btn-primary');
        $('#submit_button').addClass('btn-primary');
    }else{
        $('#modal_title').html('Reject');
        $('#submit_button').html('Reject');               
        $('#modal_header').removeClass('btn-primary');
        $('#submit_button').removeClass('btn-primary');
        $('#modal_header').addClass('btn-danger');
        $('#submit_button').addClass('btn-danger');        
    }
    $('#approval_of').val(approval_of);
    $('#approval_type').val(approval_type);    
}

$(document).ready(function () {
    var table_booking = $('#service_requisition_approval_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [
            [10, 25, 50, 100, 500],
            [10, 25, 50, 100, 500]
        ],
        "searching": true,
        "ordering": true,
        "order": [[ 0, "desc" ]],
        "ScrollX": true,
        "serverSide": true,
        "processing": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/service_requisition_approval_datatable.php",
        "columnDefs": [
            { targets: [ 12 ], visible: false},
            { "width": "8%", "targets": 11 }
        ]
    });
});
</script>