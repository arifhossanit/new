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
		background-color: #e57373;
		transition: 500ms;
	}
</style>
<!-- Damaged Product History -->
<div class="modal fade" id="product_history">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="" id="damaged_product_form" method="post">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product History</h4>
				</div>
				<div class="ml-2" id="error_message" style="height: 20px;font-weight: bold;"></div>
				<div class="modal-body" id="damaged_product_history_div">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Damaged Product Details -->
<div class="modal fade" id="product_details">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="" id="damaged_product_form_individual" method="post">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product List</h4>
				</div>
				<div class="ml-2" id="error_message" style="height: 20px;font-weight: bold;"></div>
				<div class="modal-body" id="damaged_product_details_div">
				</div>
				<div class="modal-footer">
					<div id="damaged_product_details_button"></div>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Manage Damaged Product -->
<div class="modal fade" id="damaged_goods">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="" id="damaged_product_form_all" method="post">
                <input type="hidden" name="type_id" id="type_id">
                <input type="hidden" name="pk" id="pk">
                <input type="hidden" name="type" id="type">
                <input type="hidden" name="id" id="id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product List</h4>
				</div>
				<div class="ml-2" id="error_message" style="height: 20px;font-weight: bold;"></div>
				<div class="modal-body" id="damaged_product_div">
				</div>
				<div class="modal-footer">
					<div id="damage_button"></div>
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
					<h1 class="m-0 text-dark">Stolen Goods</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Stolen Goods</li>
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
                            Stolen Products
                        </div>
                        <div class="card-body">
							<table class="table table-sm text-center table-bordered table-hover" id="stolen_goods_datatable">
                                <thead>
									<tr>
										<th>id</th>
										<th>type_name</th>
										<th>Product</th>
										<th>Amount</th>
										<th>Vendor</th>
										<th>Warrenty</th>
										<th>scale_id</th>
										<th>type_id</th>
										<th>Receive Date</th>
										<th>Purchase Order</th>
										<th>Price</th>
										<th style="width: 75px;">Option</th>
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
$('#product_history').on('hidden.bs.modal', function () {
    $('#product_details').modal('toggle');
})

function out_of_order(id){
	$.ajax({
        type: 'post',
        data: {type: 'out_of_order', id},
        url: "<?=base_url()?>assets/ajax/scm/damaged_goods.php",
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
        success: function (data) {
			$('#data-loading').html('');
			let info = JSON.parse(data);
			$('#damaged_product_details_div').html(info.html);
			$('#damaged_product_details_button').html(info.button);
			$('#damaged_goods_datatable').DataTable().ajax.reload( null , false);
        }
    });
}

function show_product_details(name, id){
	$.ajax({
        type: 'post',
        data: {name, id},
        url: "<?=base_url()?>assets/ajax/scm/get_damaged_goods_product_details.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#damaged_product_details_div').html(info.html);
			$('#damaged_product_details_button').html(info.button);
			$('#product_details_datatable').DataTable({
				"lengthChange": false,
				"order": false,
			});
        }
    });
}
function show_history(tb, id){
	$('#product_details').modal('toggle');
	$.ajax({
        type: 'post',
        data: {tb, id},
        url: "<?=base_url()?>assets/ajax/scm/show_product_history.php",
        success: function (data) {
			$('#damaged_product_history_div').html(data);
			$('#product_history_datatable').DataTable({
				"lengthChange": false,
				"order": false,
			});
        }
    });
}
function damaged_product_modal(type, id, amount, pk, type_id){    
    $('#type_id').val(type_id);
    $('#type').val(type);
    $('#id').val(id);
    $('#pk').val(pk);
    $.ajax({
        type: 'post',
        data: {type, amount},
        url: "<?=base_url()?>assets/ajax/scm/damaged_goods_modal_all.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#damage_button').html(info.button);
			$('#damaged_product_div').html(info.html);
        }
    });
}
$('#damaged_product_form_all').on('submit', function () {
	event.preventDefault();
    var form = $('#damaged_product_form_all')[0];
    var data = new FormData(form);
    $.ajax({
        type: 'post',
        data: data,
        url: "<?=base_url()?>assets/ajax/scm/damaged_goods.php",
		processData: false,
		contentType: false,
        success: function (data) {
			// let info = JSON.parse(data);
			// $('#receive_button').html(info.button);
			// $('#product_receive_div').html(info.html);
        }
    });
});
// function receive_product(purchase_order, type) {
// 	$.ajax({
//         type: 'post',
//         data: {purchase_order, type, food: 'yes'},
//         url: "<?=base_url()?>assets/ajax/scm/receive_order.php",
//         success: function (data) {
// 			let info = JSON.parse(data);
// 			$('#receive_button').html(info.button);
// 			$('#product_receive_div').html(info.html);
//         }
//     });
// }
// function show_receipt(purchase_order) {
//     $.ajax({
//         type: 'post',
//         data: {purchase_order: purchase_order},
//         url: "<?=base_url()?>assets/ajax/scm/purchase_order_details.php",
//         success: function (data) {
// 			$('#show_purchase_order_products').html(data);
//         }
//     });
// }
$(document).ready(function () {
    var purchase_order = $('#stolen_goods_datatable').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/stolen_goods_datatable.php",
        columnDefs: [
			{ targets: [ 6,7 ], visible: false},
		]
    });
});
</script>