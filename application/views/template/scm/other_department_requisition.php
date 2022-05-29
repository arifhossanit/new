<style>
    .col-print-1 {width:8%;  float:left;}
    .col-print-2 {width:16%; float:left;}
    .col-print-3 {width:25%; float:left;}
    .col-print-4 {width:33%; float:left;}
    .col-print-5 {width:42%; float:left;}
    .col-print-6 {width:50%; float:left;}
    .col-print-7 {width:58%; float:left;}
    .col-print-8 {width:66%; float:left;}
    .col-print-9 {width:75%; float:left;}
    .col-print-10{width:83%; float:left;}
    .col-print-11{width:92%; float:left;}
    .col-print-12{width:100%; float:left;}
    .row{
        margin-right: 0px;
        margin-left: 0px;
    }
</style>
<!-- Show Product Stock and auto assign -->
<div class="modal fade" id="show_products">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="" id="auto_assign_product" method="post">
				<input type="hidden" id="requisition_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product List</h4>
				</div>
				<div class="modal-body" id="show_requisition_products">
					
				</div>
				<div class="modal-footer">
                    <input type="text" class="form-control mb-1" id="note" placeholder="Any Note">
				</div>
				<div class="modal-footer">
					<div id="requisition_button"></div>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Boss Approval Modal -->
<div class="modal fade" id="approve_products">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" id="boss_approval" method="post">
				<input type="hidden" id="requisition_id_approval" name="requisition_id_approval">              
				<input type="hidden" id="approval_type" name="approval_type">              
				<div class="modal-header btn-primary">
					<h4 class="modal-title" id="approval_title">Product List</h4>
				</div>
				<div class="modal-body" id="approve_requisition_products">
					
				</div>
				<div class="modal-footer">
                    <div id="stock_button"></div>
					<button type="submit" class="btn btn-secondary btn-sm">Submit</button>
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
					<h1 class="m-0 text-dark">Manage Requisitions</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Requisitions</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
		<div class="container-flud">
            <div class="row" style="width: 100%; overflow-x: scroll;">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            Requisition Lists
                        </div>
                        <div class="card-body">
							<table class="table table-sm text-center table-bordered table-hover" id="requisition_table" style="overflow: hidden !important;width: 100% !important">
                                <thead>
									<tr>
										<th>id</th>
										<th>Requisition Id</th>
										<th>Requested By</th>
										<th>Department</th>
										<th>Requested For</th>
										<th>Requisition Date</th>
										<th>Status</th>
										<th style="width: 75px;">Option</th>
									</tr>
								</thead>
                                <tbody>
                                </tbody>
                                <tfoot>
									<tr hidden>
										<th>id</th>
										<th>Requisition Id</th>
										<th>Requested By</th>
										<th>Department</th>
										<th>Requested For</th>
										<th>Requisition Date</th>
										<th>Status</th>
										<th style="width: 75px;">Option</th>
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

<script>
$("#boss_approval").on("submit", function(){
	event.preventDefault();
	var form = $('#boss_approval')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?=base_url('assets/ajax/scm/approve_requisition_product.php');?>",
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
			$('#toast').html(data);
			trigger_alert();				
			$('#approve_products').modal('toggle');
			$('#requisition_table').DataTable().ajax.reload( null , false);
		}
	});		
	return false;
})
// $('#').on('submit', function () {

// });
$('#auto_assign_product').on('submit', function () {
	event.preventDefault();
	let requisition_id = $('#requisition_id').val();
	let note = $('#note').val();
	$.ajax({
        type: 'post',
        data: {requisition_id, note},
        url: "<?=base_url()?>assets/ajax/scm/auto_assign_product_for_department.php",
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
        success: function (data) {
			$('#data-loading').html('');
			let info = JSON.parse(data);
			$('#toast').html(info.alert);
			$('#show_products').modal('toggle');
			$('#requisition_table').DataTable().ajax.reload( null , false);
			trigger_alert();
			// $('#warehouse_stock').html(data);
			// var purchase_order = $('#requisition_details_table').DataTable({
			// 	"paging": true,
			// 	"lengthChange": false,
			// 	"searching": true,
			// 	"order": [[ 0, "desc" ]],
			// 	"info": true,
			// 	"ScrollX": true
			// });
        }
    });
});

function show_products(requisition_id) {
	$('#show_requisition_products').html('');
    $.ajax({
        type: 'post',
        data: {requisition_id},
        url: "<?=base_url()?>assets/ajax/scm/requisition_products_other_department.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#requisition_id').val(requisition_id);
			$('#requisition_button').html(info.button);
			$('#show_requisition_products').html(info.html);
			var purchase_order = $('#requisition_details_table').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"order": [[ 0, "desc" ]],
				"info": true,
				"ScrollX": true
			});
        }
    });
}
function approve_products(requisition_id, title, type) {
    $('#approval_title').html(title);
    $('#approval_type').val(type);
    $.ajax({
        type: 'post',
        data: {requisition_id: requisition_id},
        url: "<?=base_url()?>assets/ajax/scm/approve_requisition_product_view.php",
        success: function (data) {
            let info = JSON.parse(data);
			$('#requisition_id_approval').val(requisition_id);
			$('#approve_requisition_products').html(info.html);
        }
    });
}
$(document).ready(function () {
    var purchase_order = $('#requisition_table').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/other_department_requisition_datatable.php",
		// rowGroup: {
		// 	dataSrc: 10,
		// 	startClassName: 'table-start-group'
		// },
		"columnDefs": [
						{
                            "targets": [ 0 ],
                            "visible": false,
                            "searchable": false
                        },
						{
                            "targets": [ 3 ],
                            "visible": false,
                            "searchable": false
                        },
		]
    });
});
</script>