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
	.error{
		background-color: #ef5350;
	}
	.regular-checkbox {
        -webkit-appearance: none;
        background-color: #fafafa;
        border: 1px solid #cacece;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
        padding: 9px !important;
        border-radius: 3px;
        display: inline-block;
        position: relative;
    }
    .regular-checkbox:active, .regular-checkbox:checked:active {
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
    }

    .regular-checkbox:checked {
        background-color: #a5d6a7;
        border: 1px solid #adb8c0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
        color: #99a1a7;
    }
    .regular-checkbox:checked:after {
        content: '\2714';
        font-size: 14px;
        position: absolute;
        top: -1px;
        left: 0px;
        color: #a5d6a7;
    }
</style>
<!-- Show Product damaged -->
<div class="modal fade" id="damaged_product">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="" id="damaged_product_form" method="post">
				<input type="hidden" id="requisition_id">
				<div class="modal-header btn-primary">
					<h6 class="modal-title">Select Damaged Product</h6>
				</div>
				<div class="modal-body" id="show_damaged_product"></div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm">Update</button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Show Product Stolen -->
<div class="modal fade" id="stolen_product">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="" id="stolen_product_form" method="post">
				<input type="hidden" id="requisition_id">
				<div class="modal-header btn-primary">
					<h6 class="modal-title">Select Stolen Product</h6>
				</div>
				<div class="modal-body" id="show_stolen_product"></div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm">Update</button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Department head approval -->
<div class="modal fade" id="d_head_approval">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="" id="d_head_approval_form" method="post">
				<input type="hidden" name="approval_type" value="d_head_approve">
				<input type="hidden" id="requisition_id_approval" name="requisition_id_approval">
				<div class="modal-header btn-primary">
					<h6 class="modal-title">Select Stolen Product</h6>
				</div>
				<div class="modal-body" id="approve_requisition_products"></div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm">Approve</button>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Show Product Stock and auto assign -->
<div class="modal fade" id="receive_products">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="" id="receive_product_form" method="post">
				<input type="hidden" id="requisition_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product List</h4>
				</div>
				<div class="modal-body" id="show_requisition_products"></div>
				<div class="modal-footer">
					<div id="requisition_button"></div>
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
					<h1 class="m-0 text-dark">Department Requisitions</h1>
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
										<th>Requisition Status</th>
										<th style="width: 75px;">Option</th>
										<th>department_requested_by</th>
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


$('#stolen_product').on('hidden.bs.modal', function () {
	$('#receive_products').modal('show');
	$('#show_stolen_product').html('');
});
$('#damaged_product').on('hidden.bs.modal', function () {
	$('#receive_products').modal('show');
	$('#show_damaged_product').html('');
});
function get_damaged_amount(id, type) {
	$.ajax({
		type: "POST",
		url:"<?=base_url('assets/ajax/scm/get_damaged_product.php');?>",
		data: {id, type},
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#receive_products').modal('hide');
			$('#show_damaged_product').html(data);
			$('#damaged_product').modal('show');
		}
	});
}

function approve_products(requisition_id) {
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

$("#d_head_approval_form").on("submit", function(){
	event.preventDefault();
	var form = $('#d_head_approval_form')[0];
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
			$('#d_head_approval').modal('toggle');
			$('#requisition_table').DataTable().ajax.reload( null , false);
		}
	});		
	return false;
})

function get_stolen_amount(id, type) {
	$.ajax({
		type: "POST",
		url:"<?=base_url('assets/ajax/scm/get_stolen_product.php');?>",
		data: {id, type},
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#receive_products').modal('hide');
			$('#show_stolen_product').html(data);
			$('#stolen_product').modal('show');
		}
	});
}

$('#damaged_product_form').on('submit', function () {
	event.preventDefault();
	
	let product_type = $('#product_type').val();
	let requisition_id = $('#requisition_id').val();
	let product_id = $('#product_id_damaged').val();
	let damaged_product;
	if(product_type === 'consumable'){
		damaged_product = $("input[name='damaged_product[]']")
				.map(function(){return $(this).val();}).get();
	}else{
		damaged_product = $("input[name='damaged_product[]']:checked")
				.map(function(){return $(this).val();}).get();
	}	
	let receive_id = $("input[name='receive_id[]']")
				.map(function(){return $(this).val();}).get();
	$.ajax({
		type: "POST",
		url:"<?=base_url('assets/ajax/scm/add_damaged_product.php');?>",
		data: {product_id, product_type, damaged_product, receive_id},
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			receive_products(requisition_id);
			$('#receive_products').modal('show');
			$('#damaged_product').modal('hide');
		}
	});
	return false;	
});

$('#stolen_product_form').on('submit', function () {
	event.preventDefault();	
	let product_type = $('#product_type').val();
	let requisition_id = $('#requisition_id').val();
	let product_id = $('#product_id_stolen').val();
	let stolen_product;
	console.log(product_type);
	if(product_type === 'consumable'){
		stolen_product = $("input[name='stolen_product[]']")
				.map(function(){return $(this).val();}).get();
	}else{
		stolen_product = $("input[name='stolen_product[]']:checked")
				.map(function(){return $(this).val();}).get();
	}
	let receive_id = $("input[name='receive_id[]']")
				.map(function(){return $(this).val();}).get();
	$.ajax({
		type: "POST",
		url:"<?=base_url('assets/ajax/scm/add_stolen_product.php');?>",
		data: {product_id, stolen_product, receive_id, product_type},
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			receive_products(requisition_id);
			$('#receive_products').modal('show');
			$('#stolen_product').modal('hide');
		}
	});
	console.log(stolen_product);	
	return false;	
});

$('#receive_product_form').on('submit', function () {
	event.preventDefault();
	let requisition_id = $('#requisition_id').val();
	let received_amount = $("input[name='received_amount[]']")
				.map(function(){return $(this).val();}).get();
	let stolen_amount = $("input[name='stolen_amount[]']")
				.map(function(){return $(this).val();}).get();
	let damaged_amount = $("input[name='damaged_amount[]']")
				.map(function(){return $(this).val();}).get();
	let rqst_id = $("input[name='rqst_id[]']")
				.map(function(){return $(this).val();}).get();
	$('tr').removeClass('error');
	$('#error_message').html('');
	// console.log(requisition_id);
	$.ajax({
		type: "POST",
		url:"<?=base_url('assets/ajax/scm/receive_department_product.php');?>",
		data: {received_amount, stolen_amount, damaged_amount, rqst_id, requisition_id},
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			let info = JSON.parse(data);
			if(info.error){
				$('#error_message').html(info.message);
				if(info.idx != undefined){
					$('#row_' + info.idx).addClass('error');
				}
			}else{
				$('#requisition_table').DataTable().ajax.reload( null , false);
				$('#receive_products').modal('toggle');
				$('#toast').html(info.alert);
				trigger_alert();
			}
			// $('#toast').html(data);
			// trigger_alert();				
			// $('#approve_products').modal('toggle');
			// $('#requisition_table').DataTable().ajax.reload( null , false);
		}
	});
	return false;	
});
function show_products(requisition_id) {
    $.ajax({
        type: 'post',
        data: {requisition_id},
        url: "<?=base_url()?>assets/ajax/scm/department_product_requisition_show.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#requisition_id').val(requisition_id);
			$('#requisition_button').html(info.button);
			$('#show_requisition_products').html(info.html);
			var purchase_order = $('#requisition_details_table').DataTable({
				"paging": false,
				"lengthChange": false,
				"searching": true,
				"order": [[ 0, "desc" ]],
				"info": true,
				"ScrollX": true
			});
        }
    });
}
function receive_products(requisition_id) {
    $.ajax({
        type: 'post',
        data: {requisition_id: requisition_id},
        url: "<?=base_url()?>assets/ajax/scm/department_product_requisition.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#requisition_id').val(requisition_id);
			$('#requisition_button').html(info.button);
			$('#show_requisition_products').html(info.html);
			var purchase_order = $('#requisition_details_table').DataTable({
				"paging": false,
				"lengthChange": false,
				"searching": true,
				"order": [[ 0, "desc" ]],
				"info": true,
				"ScrollX": true
			});
        }
    });
}
// "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/department_requisition_datatable.php",
$(document).ready(function () {
    var purchase_order = $('#requisition_table').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": true,
		"processing": true,
		"serverSide": true,
		"ajax" : {
			"url" : "<?=base_url(); ?>assets/ajax/data_table/scm/department_requisition_datatable.php",
			"type" : "POST"
		},
		"columnDefs": [
			{
				"targets": [ 0,3,8 ],
				"visible": false,
				"searchable": false
			},
		]
    });
	console.log(purchase_order);
});
</script>