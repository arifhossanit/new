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
<!-- Transfer Product Modal -->
<div class="modal fade" id="transfer_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?=base_url('admin/scm/department-transfer-product')?>" id="transfer_product_form" method="post">
				<input type="hidden" id="amount_limit">
				<input type="hidden" name="use_id" id="use_id">
				<input type="hidden" name="pur_pk" id="purchase_pk">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Transfer Product</h4>
				</div>
				<div class="modal-body" id="">
					<div class="row">
						<input type="hidden" name="product_type_id" id="product_type_id">
						<div class="col-md-4">							
							<div class="form-group">
								<select class="form-control" name="transfer_type" id="transfer_type" onchange="get_transfer_type(this.value)">
									<option value="">Select Transfer Type</option>
									<option value="to_branch">Tranfer To Branch</option>
									<option value="to_employee">Tranfer To Employee</option>
									<option value="to_warehouse">Return To Warehouse</option>
									<option value="to_department">Return To Department</option>
									<option value="to_damaged">Return Damaged Product</option>
								</select>
							</div>
						</div>
						<div class="col-md-12" id="transfer_type_div">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div id="transfer_type_button"></div>
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
					<h1 class="m-0 text-dark">Department Product Use Status</h1>
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
						<div class="col-md-12">
							<table class="table table-bordered" id="product_status">
								<thead>
									<tr>
										<td>Id</td>
										<td>Name</td>
										<td>Amount</td>
										<td>Sent Date</td>
										<td>branch_id</td>
										<td>employee_id</td>
										<td>unit_name</td>
										<td>room_name</td>
										<td>Using By</td>
										<td>Option</td>
										<td>scm_product_types_id</td>
										<td>unit_price</td>
										<td>purchase_order_pk</td>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>            
        </div>
    </div>
</div>

<script>
function get_transfer_type(type) {
	let use_id = $('#use_id').val();
	let amount = $('#amount_limit').val();
	let type_id = $('#product_type_id').val();
	$.ajax({
        type: 'post',
        data: {type, amount, type_id, use_id},
        url: "<?=base_url()?>assets/ajax/scm/get_transfer_type.php",
        success: function (data) {
			let info = JSON.parse(data);
			$('#transfer_type_div').html(info.html);
			$('#transfer_type_button').html(info.button);
			$('.select2').select2();
        }
    });
}
function set_amount(amount, id, type_id, pur_pk) {
	$("#transfer_type").val("");
	$('#transfer_type_div').html('');
	$('#transfer_type_button').html('');
	$('#product_type_id').val(type_id);
	$('#amount_limit').val(amount);
	$('#use_id').val(id);
	$('#purchase_pk').val(pur_pk);
}
function get_employee(id) {
	if(id === ''){
		$('#employee_id').html('<option>Select Department First</option>');
	}else{
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
}
$(document).ready(function () {
    var purchase_order = $('#product_status').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/department_product_status_datatable.php",
		columnDefs: [
			{ targets: [ 4, 5, 6, 7, 10, 11, 12 ], visible: false},
		]
    });
});
</script>