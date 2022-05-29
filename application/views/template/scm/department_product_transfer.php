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
	.search {
        border-radius: 30px;
        border-color: #ffffff;
    }
	.button-counter.left{
        border-radius: 5px 0px 0px 5px;
    }
    .button-counter.right{
        border-radius: 0px 5px 5px 0px;
    }
	.input-counter{
        border-left: 0;
        border-right: 0;
        border-radius: 0;
    }
	.input-counter-cart{
        border-left: 0;
        border-radius: 0;
    }
	input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    @media only screen and (max-width: 600px) {
		.input-counter{
			width: 50px !important;
		}
	}
</style>
<!-- Show Product history -->
<div class="modal fade" id="product_history">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="" id="" method="post">
				<input type="hidden" id="requisition_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product History</h4>
				</div>
				<div class="modal-body" id="product_history_div">
					
				</div>
				<div class="modal-footer">
					<div class="row" style="width: 100%;">
						<div class="col-md-1 align-self-end">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Show Product Details For Storable products -->
<div class="modal fade" id="product_details">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="" id="department_product_add" method="post">
				<input type="hidden" id="requisition_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product Details</h4>
				</div>
				<div class="modal-body" id="show_product_details">
					
				</div>
				<div class="modal-footer">
					<div class="row" style="width: 100%;">
						<div class="col-md-10 align-self-start">
							<div class="text-danger" id="error_message"></div>
						</div>
						<div class="col-md-1 align-self-end">
							<div id="submit_button"></div>
						</div>
						<div class="col-md-1 align-self-end">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
						</div>
					</div>
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
					<h1 class="m-0 text-dark">Department Product Stock</h1>
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
			<div class="card">
				<div class="card-body">
					<div class="row" style="width: 100%;">
						<div class="col-md-7">
							<table class="table table-bordered" id="product_stock">
								<thead>
									<tr>
										<td style="width: 8%;">Id</td>
										<td style="width: 18%;">Name</td>
										<td>Receive Date</td>
										<td style="width: 18%;">Branch</td>
										<td style="width: 10%;">Amount</td>
										<td style="width: 18%;">Vendor</td>
										<td>Transfer</td>
										<td>Exit Amount</td>
										<td>Type</td>
										<td>scm_product_requisition_details_id</td>
										<td>scm_product_order_details</td>
										<td>unit_price</td>
										<td>requisition_received</td>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<div class="col-md-5" id="product_cart_div">
							<table class="table table-bordered" id="product_cart">
								<thead>
									<tr>
										<td>Id</td>
										<td>Name</td>
										<td>Amount</td>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
						<div class="col-md-12">
							<hr style="border: 1px solid white;">
						</div>
						<div class="col-md-12">
							<form action="<?=base_url('admin/scm/department-send-product')?>" id="send_department_product_form" method="POST">
								<h3>Send Product</h3>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<select class="form-control" name="recipient_type" id="recipient_type" onchange="get_recipient_type(this.value)">
												<option value="">Select Recipient Type</option>
												<option value="Branch">Send to Branch</option>
												<option value="Employee">Send to Employee</option>
												<option value="Damaged">Return Damaged Product</option>
												<option value="Stolen">Report Stolen Product</option>
												<option value="storage_branch">Change Storage Branch</option>
											</select>
										</div>
									</div>
									<div class="col-md-10" id="recipient_type_information">
										
									</div>
								</div>
							</form>					
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<script>
let product_cart;
$('#product_history').on('hidden.bs.modal', function () {
    $('#product_details').modal('toggle');
})
function show_history(tb, id) {
	$.ajax({
		type: 'post',
		data: {tb, id},
		url: "<?=base_url()?>assets/ajax/scm/show_product_history.php",
		success: function (data) {
    		$('#product_details').modal('toggle');
			$('#product_history_div').html(data);
			product_history = $('#product_history_datatable').DataTable({
					"paging": true,
					"lengthChange": false,
					"searching": true,
					"order": false,
					"info": true,
					"ScrollX": true,
					"columnDefs": [
						{ "width": "5%", "targets": 0 }
					]
				});
		}
	});
}
$('#department_product_add').on('submit', function () {
	event.preventDefault();
	let rqst_id = $('#rqst_id').val();
	let product_to_add_id = $('#product_to_add_id').val();
	let product_to_add_name = $('#product_to_add_name').val();
	let requisition_receive = $('#requisition_receive').val();
	let product_to_add = $("input[name='product_to_add[]']:checked")
							.map(function(){return $(this).val();}).get();
	console.log(product_to_add);	
	if(product_to_add.length === 0){
		$('#error_message').html("Select Product First!");
	}else{
		$.ajax({
			type: 'post',
			data: {requisition_receive, rqst_id, product_to_add, id: product_to_add_id, name: product_to_add_name, type: 3, amount: product_to_add.length},
			url: "<?=base_url()?>assets/ajax/scm/add_to_department_transfer_cart.php",
			success: function (data) {
				let info = JSON.parse(data);
				$('#product_details').modal('toggle');
				$('#product_cart_div').html(info.html);
				product_cart = $('#product_cart').DataTable({
					"paging": true,
					"lengthChange": false,
					"searching": true,
					"order": [[ 0, "desc" ]],
					"info": true,
					"ScrollX": true
				});
				if(info.error !== ''){
					$('#toast').html(info.alert);
					trigger_alert();
				}
			}
		});
	}
	
})
function show_department_product_details(id, name, rqst_id, pur_pk, receive_id) {
	alert('tst');
	$('#error_message').html("");
	$('#show_product_details').html('');
	$.ajax({
        type: 'post',
        data: {id, name, rqst_id, table: 'scm_department_stock', pur_pk, receive_id},
        url: "<?=base_url()?>assets/ajax/scm/get_product_details.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#show_product_details').html(info.html);
			$('#submit_button').html(info.button);
			var product_details_datatable = $('#product_details_datatable').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"order": [[ 0, "desc" ]],
				"info": true,
				"ScrollX": true,
				"columnDefs": [
					{ "width": "20%", "targets": 0 }
				]
			});
        }
    });
}
function get_employee(id) {
	$.ajax({
        type: 'post',
        data: {id},
        url: "<?=base_url()?>assets/ajax/scm/get_recipient_employee.php",
        success: function (data) {
			$('#employee_id').html(data);
			$('.select2').select2();
        }
    });
}
function get_recipient_type(type) {
	$.ajax({
        type: 'post',
        data: {type},
        url: "<?=base_url()?>assets/ajax/scm/get_recipient_type.php",
        success: function (data) {
			$('#recipient_type_information').html(data);
			$('.select2').select2();
        }
    });
}
function add_number(product_id) {
	$('#product_' + product_id).val(parseInt($('#product_' + product_id).val()) + 1 );
	$('#product_' + product_id).change();
}
function minus_number(product_id) {
	if($('#product_' + product_id).val() > 0){
		$('#product_' + product_id).val(parseInt($('#product_' + product_id).val()) - 1 );
		$('#product_' + product_id).change();
	}
}

function add_department_transfer_cart(id, name, type, rqst_id, pur_pk, requisition_receive) {
	let amount = $('#product_' + id).val();
    $.ajax({
        type: 'post',
        data: {id, amount, name, type, rqst_id, pur_pk, requisition_receive},
        url: "<?=base_url()?>assets/ajax/scm/add_to_department_transfer_cart.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#product_cart_div').html(info.html);
			product_cart = $('#product_cart').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"order": [[ 0, "desc" ]],
				"info": true,
				"ScrollX": true
			});
			if(info.error !== ''){
				$('#toast').html(info.alert);
				trigger_alert();
			}
        }
    });
}
$(document).ready(function () {
    var purchase_order = $('#product_stock').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"order": [[ 2, "asc" ]],
		"info": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/department_product_transfer_datatable.php",
		columnDefs: [
			{ targets: [ 2, 7, 8, 9, 10, 11, 12 ], visible: false},
		]
    });
	$.ajax({
        type: 'post',
        url: "<?=base_url()?>assets/ajax/scm/add_to_department_transfer_cart.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#product_cart_div').html(info.html);
			product_cart = $('#product_cart').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"order": [[ 0, "desc" ]],
				"info": true,
				"ScrollX": true
			});
        }
    });
});
function remove_item_from_cart(product_id) {
	$.ajax({
		type: 'post',
		data: {id: product_id, remove: 'yes'},
		url: "<?=base_url()?>assets/ajax/scm/update_cart_amount.php",
		success: function (data) {
			$('#product_cart_div').html(data);
			product_cart = $('#product_cart').DataTable({
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
function minus_number_cart(product_id) {
	if($('#product_cart_' + product_id).val() > 1){		
		$.ajax({
			type: 'post',
			data: {id: product_id},
			url: "<?=base_url()?>assets/ajax/scm/update_cart_amount.php",
			success: function (data) {
				$('#product_cart_' + product_id).val(parseInt($('#product_cart_' + product_id).val()) - 1 );
				$('#product_cart_' + product_id).change();
			}
		});
	}
}
</script>