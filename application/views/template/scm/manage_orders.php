<style>
.list-group-item{
	padding-top: 0px !important;
	padding-bottom: 0px !important;
}
</style>
<!---- Adding vendor modal-->
<div class="modal fade" id="add_vendor">
	<div class="modal-dialog modal-xl" style="max-width: 75% !important;">
		<div class="modal-content">
			<form action="" method="post" id="add_vendor_form">                
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Add Vendor</h4>
				</div>
				<div class="modal-body" id="print_applicant_account_Details_result">
					<div class="row mb-2">
						<div class="col-md-4">
							<label for="purchase_order">Vendor For: </label>
							<input class="form-control mb-2" type="text" name="purchase_order" id="purchase_order" value="" readonly>
						</div>
					</div>                    
                    <div id="vendor_select">
                        
                    </div>
				</div>                
                <div class="modal-footer">
					<div id="purchase_button"></div>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<!-- Product List modal -->
<div class="modal fade" id="show_products">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" id="boss_approval" method="post">
				<input type="hidden" id="purchase_code">              
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product List</h4>
				</div>
				<div class="modal-body" id="show_purchase_order_products">
				</div>
				<div class="modal-footer">
					<div id="show_button"></div>
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
					<h1 class="m-0 text-dark">Manage Pre-Orders</h1>
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
                            Pre Purchase Order List
                        </div>
                        <div class="card-body">
							<table class="table table-sm text-center table-bordered table-hover" id="pre_purchase_order_table">
                                <thead>
									<tr>
										<th>id</th>
										<th>Pre Purchase Order Id</th>
										<th>Order Date</th>
										<th>Order Type</th>
										<th>Approval</th>
										<th>Vendor</th>
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
function get_warrenty(status, i){
	if(status == 'No'){
		$('#warrenty_div_' + i).hide();
	}else if(status == 'Yes'){
		$('#warrenty_div_' + i).show();
	}
}

$('#boss_approval').on('submit', function () {
	event.preventDefault();
	console.log('submitting');
	let purchase_order = $('#purchase_code').val();
	let approved_amount = $("input[name='approved_amount[]']")
				.map(function(){return $(this).val();}).get();
	let product_id = $("input[name='product_id[]']")
				.map(function(){return $(this).val();}).get();
	console.log(product_id);
	$.ajax({
        type: 'post',
        data: {purchase_order: purchase_order, approved_amounts: approved_amount, product_ids: product_id},
        url: "<?=base_url()?>assets/ajax/scm/boss_approval.php",
        success: function (data) {
			$('#show_products').modal('toggle');
			$('#pre_purchase_order_table').DataTable().ajax.reload( null , false);
        }
    });
})

function show_products(purchase_order, type) {
    $.ajax({
        type: 'post',
        data: {purchase_order: purchase_order, approved: 'no', type: type},
        url:"<?=base_url()?>assets/ajax/scm/pre_purchase_order_details.php",
        success: function (data) {
            $('#purchase_code').val(purchase_order);
			let info = JSON.parse(data);
            $('#show_purchase_order_products').html(info.html);
            $('#show_button').html(info.button);
        }
    });
}
function show_approved_products(purchase_order, type) {
    $.ajax({
        type: 'post',
        data: {purchase_order: purchase_order, approved: 'yes', type: type},
        url:"<?=base_url()?>assets/ajax/scm/pre_purchase_order_details.php",
        success: function (data) {
            $('#purchase_code').val(purchase_order);
			let info = JSON.parse(data);
            $('#show_purchase_order_products').html(info.html);
            $('#show_button').html(info.button);
        }
    });
}
function add_vendor(purchase_order, type) {
    $.ajax({
        type: 'post',
        data: {purchase_order: purchase_order, type: type},
        url:"<?=base_url()?>assets/ajax/scm/fetch_vendor.php",
        success: function (data) {
			let info = JSON.parse(data);
            $('#purchase_order').val(purchase_order);
            $('#vendor_select').html(info.html);
            $('#purchase_button').html(info.button);
            $('#add_vendor_form').attr('action', info.action);
            $('.select2').select2();
			$('.datepicker').datepicker({
				format: 'yyyy/mm/dd',
				todayHighlight:'TRUE',
				autoclose: true,
			});
        }
    });
}
$(document).ready(function () {
    var purchase_order = $('#pre_purchase_order_table').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/pre_purchase_order_datatable.php"
    });
});
</script>