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
<!-- Receive Products -->
<div class="modal fade" id="product_receive">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" id="receive_product_form" method="post">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product List</h4>
				</div>
				<div class="ml-2" id="error_message" style="height: 20px;font-weight: bold;"></div>
				<div class="modal-body" id="product_receive_div">
				</div>
				<div class="modal-footer">
					<div id="receive_button"></div>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- PO Modal -->
<div class="modal fade" id="show_receipt">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" id="boss_approval" method="post">
				<input type="hidden" id="purchase_code">              
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product List</h4>
				</div>
				<div class="modal-body" id="show_purchase_order_products" style="padding: 70px">
                    
				</div>
				<div class="modal-footer">
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
					<h1 class="m-0 text-dark">Manage Orders</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Orders</li>
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
                            Purchase Order List
                        </div>
                        <div class="card-body">
							<table class="table table-sm text-center table-bordered table-hover" id="purchase_order_table">
                                <thead>
									<tr>
										<th>id</th>
										<th>Purchase Order Id</th>
										<th>Order Date</th>
										<th>Vendor</th>
										<th>Total Price</th>
										<th>Status</th>
										<th style="width: 75px;">Option</th>
									</tr>
								</thead>
                                <tbody>
                                </tbody>
                                <tfoot>
									<tr hidden>
										<th>id</th>
                                        <th>Purchase Order Id</th>
										<th>Order Date</th>
										<th>Vendor</th>
										<th>Total Price</th>
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
$('#receive_product_form').on('submit', function () {
	event.preventDefault();
	let purchase_order = $("input[name='purchase_order']").val();
	console.log(purchase_order);
	let product_id = $("input[name='product_id[]']")
				.map(function(){return $(this).val();}).get();
	let damaged_amount = $("input[name='damaged_amount[]']")
				.map(function(){return $(this).val();}).get();
	let stolen_amount = $("input[name='stolen_amount[]']")
				.map(function(){return $(this).val();}).get();
	let received_amount = $("input[name='received_amount[]']")
				.map(function(){return $(this).val();}).get();
	let product_type = $("input[name='product_type[]']")
				.map(function(){return $(this).val();}).get();
	$.ajax({
        type: 'post',
        data: {purchase_order, product_id,damaged_amount,stolen_amount,received_amount, product_type},
        url: "<?=base_url()?>assets/ajax/scm/product_receive.php",		
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
        success: function (data) {
			$('#data-loading').html('');
			let info = JSON.parse(data);
			$('tr').removeClass('error');
			if(info.message === 'mismatch'){
				$('#error_message').html('Order Mismatch');
				$('#error_message').addClass('text-danger');
				$('#receive_order_' + info.serial).addClass('error');
			}else if(info.message === 'done'){
				$('#purchase_order_table').DataTable().ajax.reload( null , false);
				$('#product_receive').modal('toggle');
				$('#toast').html(info.alert);
				trigger_alert();
				// $('#error_message').addClass('text-success');
				// window.setTimeout(function() {
				// 	location.reload();
				// }, 1000);
			}
        }
    });
});
function receive_product(purchase_order, type) {
	$('#error_message').html('');
	$.ajax({
        type: 'post',
        data: {purchase_order, type},
        url: "<?=base_url()?>assets/ajax/scm/receive_order.php",		
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
        success: function (data) {
			$('#data-loading').html('');
			let info = JSON.parse(data);
			$('#receive_button').html(info.button);
			$('#product_receive_div').html(info.html);
        }
    });
}
function show_receipt(purchase_order) {
    $.ajax({
        type: 'post',
        data: {purchase_order: purchase_order},
        url: "<?=base_url()?>assets/ajax/scm/purchase_order_details.php",
        success: function (data) {
			$('#show_purchase_order_products').html(data);
        }
    });
}
$(document).ready(function () {
    var purchase_order = $('#purchase_order_table').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/purchase_order_datatable.php"
    });
});
</script>