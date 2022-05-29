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
			<form action="" id="warehouse_product_add" method="post">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            Requisition Lists
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <p>Product List</p>
                                    <table class="table table-sm text-center table-bordered table-hover" id="requisition_details_table" style="overflow: scroll !important;width: 100% !important">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Product Name</th>
                                                <th>Product Specification</th>
                                                <th>Requested Amount</th>
                                                <th style="width: 75px;">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($products as $product){
                                                $product_name = $product->category_name.': '.( (is_null($product->brand_name)) ? '' : $product->brand_name.' - ' ).$product->product_name;
                                                $number_of_specification = 0;
                                            ?>
                                                <tr>
                                                    <td><?php echo $product->id; ?></td>
                                                    <td><?php echo $product_name; ?></td>
                                                    <td><small><?php 
                                                        if($product->specification != ''){
                                                            echo '<p class="mb-0">';
                                                            foreach($product->specification as $idx=>$specification){
                                                                if($idx == 0){
                                                                    echo $specification->specification_type.' - '.$specification->specification_name;
                                                                }else{
                                                                    echo ', '.$specification->specification_type.' - '.$specification->specification_name;
                                                                }
                                                            }
                                                            echo '</p>';
                                                        }
                                                        if(!is_null($product->width)){
                                                            if($product->height != ''){
                                                                echo '<p class="mb-0">Size: '.$product->width.' x '.$product->height.' '.$product->unit.'</p>';
                                                            }else{
                                                                echo '<p class="mb-0">Size: '.$product->width.' '.$product->unit.'</p>';
                                                            }
                                                        }
                                                    ?></small></td>
                                                    <td><?php echo $product->requested_amount.' '.$product->scale_name; ?></td>
                                                    <td><button type="button" class="btn btn-info btn-xs mr-1" onclick="show_product_stocks('<?php echo $product->product_id; ?>', '<?php echo $product->product_types_id; ?>', '<?php echo $product->scale_name; ?>', '<?php echo $number_of_specification; ?>', '<?php echo $product->id; ?>', <?= $product->requested_amount ?>, <?= $product->product_size?>)"><i class="fas fa-arrow-right"></i></i></button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr hidden>
                                                <th>id</th>
                                                <th>Product Name</th>
                                                <th>Product Specification</th>
                                                <th>Requested Amount</th>
                                                <th style="width: 75px;">Option</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-7">
                                    <p>Warehouse Stocks</p>
                                    <div id="warehouse_stock"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Cart</p>
                                </div>
                                <div class="col-md-6" id="warehouse_cart_div">
                                </div>
								<div class="col-md-6">
									<a href="<?= base_url()?>admin/scm/warehouse-manual-assign"><button class="btn btn-info btn-sm">Send</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<script>
let product_cart;
$('#warehouse_product_add').on('submit', function () {
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
			url: "<?=base_url()?>assets/ajax/scm/add_to_warehouse_transfer_cart.php",
			success: function (data) {
				let info = JSON.parse(data);
				$('#product_details').modal('toggle');
				$('#product_cart_div').html(info.html);
                $('#warehouse_cart_div').html(info.html);
				// product_cart = $('#product_cart').DataTable({
                //     "paging": true,
                //     "lengthChange": false,
                //     "searching": true,
                //     "order": [[ 0, "desc" ]],
                //     "info": true,
                //     "ScrollX": true
                // });
				if(info.error !== ''){
					$('#toast').html(info.alert);
					trigger_alert();
				}
			}
		});
	}	
})
function show_department_product_details(id, name, rqst_id, pur_pk, receive_id) {
	$('#error_message').html("");
	$('#show_product_details').html('');
	$.ajax({
        type: 'post',
        data: {id, name, rqst_id, table: 'scm_department_stock', pur_pk, receive_id},
        url: "<?=base_url()?>assets/ajax/scm/get_product_details_for_warehouse.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#show_product_details').html(info.html);
			$('#submit_button').html(info.button);
			var product_details_datatable = $('#product_details_datatable').DataTable({
				"paging": false,
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
function add_warehouse_cart(id, name, type) {
	let amount = $('#product_' + id).val();
	let rqst_id = $('#rqusition').val();
    if(amount != '0'){
        $.ajax({
            type: 'post',
            data: {id, amount, name, type, rqst_id},
            url: "<?=base_url()?>assets/ajax/scm/add_to_warehouse_transfer_cart.php",
            success: function (data) {
				let info = JSON.parse(data);
                $('#warehouse_cart_div').html(info.html);
					// var purchase_order = $('#warehouse_stock_table').DataTable({
					// 	"paging": true,
					// 	"lengthChange": false,
					// 	"searching": true,
					// 	"order": [],
					// 	"info": true,
					// 	"bSort": true,
					// 	"ScrollX": true
					// });
				if(info.error !== ''){
					$('#toast').html(info.alert);
					trigger_alert();
				}
            }
        });
    }
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
function show_product_stocks(id, product_types_id, scale, number_of_specification, rqusition, amount, size_id) {
	$.ajax({
        type: 'post',
        data: {product_id: id, product_types_id, scale, number_of_specification, rqusition, amount, size_id},
        url: "<?=base_url()?>assets/ajax/scm/requisition_product_stock.php",
        beforeSend:function(){
            $('#data-loading').html(data_loading);
        },
        success: function (data) {
            $('#data-loading').html('');
			// $('#show_products').modal('toggle');
			$('#warehouse_stock').html(data);
			var purchase_order = $('#warehouse_stock_table').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"order": [],
				"info": true,
				"bSort": true,
				"ScrollX": true
			});
        }
    });
}
function show_products(requisition_id) {
    $.ajax({
        type: 'post',
        data: {requisition_id: requisition_id},
        url: "<?=base_url()?>assets/ajax/scm/requisition_products.php",
        success: function (data) {
            let info = JSON.parse(data);
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
$(document).ready(function () {
    var purchase_order = $('#requisition_details_table').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": true,
    });
    $.ajax({
        type: 'post',
        url: "<?=base_url()?>assets/ajax/scm/add_to_warehouse_transfer_cart.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#warehouse_cart_div').html(info.html);
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
		url: "<?=base_url()?>assets/ajax/scm/update_cart_amount_warehouse.php",
		success: function (data) {
			$('#warehouse_cart_div').html(data);
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
			url: "<?=base_url()?>assets/ajax/scm/update_cart_amount_warehouse.php",
			success: function (data) {
				$('#product_cart_' + product_id).val(parseInt($('#product_cart_' + product_id).val()) - 1 );
				$('#product_cart_' + product_id).change();
			}
		});
	}
}
</script>