
<style>
	.product-image{
		width: 80px;
		border-radius: 5px;
		transition: 80ms;
	}
	
</style>
<!---- Barcodes -->
<div class="modal fade" id="barcode_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=base_url()?>admin/scm/product-type/scale-update" method="post">
                <input type="hidden" name="scale_id" id="scale_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Barcodes</h4>
				</div>
				<div class="modal-body" id="barcode_modal_body">
				</div>                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<!---- Show Product History -->
<div class="modal fade" id="product_details">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=base_url()?>admin/scm/product-type/scale-update" method="post">
                <input type="hidden" name="scale_id" id="scale_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Barcodes</h4>
				</div>
				<div class="modal-body" id="product_history_div">
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
					<h1 class="m-0 text-dark">Warehouse Stock</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Warehouse Stock</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
		<div class="container-flud">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header">
							<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">Warehouse Stock</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Department Stock</a>
								</li>
							</ul>
                        </div>
						<div class="tab-content" id="custom-tabs-four-tabContent">
							<div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
								<div class="card-body">
									<table class="table table-sm text-center table-bordered table-hover" id="warehouse_stock">
										<thead>
											<tr>
												<th>ID</th>
												<th>Image</th>
												<th>Name</th>
												<th>Product Name</th>
												<th>Amount</th>
												<th style="width: 75px;">Option</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
								<div class="card-body">
									<div class="row">
										<div class="col-md-3">
											<select class="form-control select2" id="department" onchange="get_department_wise_stock()">
												<option value="">All Department</option>
												<?php
													foreach($departments as $row){
														echo '<option value="'.rahat_encode($row->department_id).'">'.$row->department_name.'</option>';
													}
												?>
											</select>
										</div>
										<div class="col-md-3">
											<select class="form-control select2" id="branch" onchange="get_department_wise_stock()">
												<option value="">All Branch</option>
												<?php
													foreach($branches as $row){
														echo '<option value="'.rahat_encode($row->branch_id).'">'.$row->branch_name.'</option>';
													}
												?>
											</select>
										</div>
									</div>
									<table style="width: 100%;" class="table table-bordered" id="department_stock">
										<thead>
											<tr>
												<td style="width: 8%;">Image</td>
												<td style="width: 18%;">Name</td>
												<td>Receive Date</td>
												<td style="width: 18%;">Branch</td>
												<td style="width: 10%;">Amount</td>
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
    </div>
</div>
<script>

let consumeable_food_details = (id, name, size) => {
	$.ajax({
		type: 'post',
		data: {id, name, size},
		url: "<?=base_url()?>assets/ajax/scm/show_warehouse_details_stock.php",
		success: function (data) {
			$('#product_history_div').html(data);
    		$('#product_details').modal('show');
			$('#warehouse_stock_details').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"order": false,
				"info": true,
				"ScrollX": true
			});
		}
	});
}

$('#product_history').on('hidden.bs.modal', function () {
    $('#barcode_modal').modal('toggle');
})
function show_history(tb, id) {
    $('#barcode_modal').modal('toggle');
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
					"ScrollX": true
				});
		}
	});
}
function show_barcode(id, name, pur_pk){
	$.ajax({
		type: 'post',
		data: {id, name, pur_pk},
		url: "<?=base_url()?>assets/ajax/scm/show_warehouse_barcode.php",
		success: function (data) {
    		let info = JSON.parse(data);
			$('#barcode_modal_body').html(info.html);
		}
	});
}
function edit_type(info) {
    info = info.split('~');
    $('#type_id').val(info[0]);
    $('#product_type').val(info[1]);
    if(info[2] === '1'){
        $('#type_status').attr('checked', 'checked');
    }else{
        $('#type_status').attr('unchecked', 'unchecked');
    }
}
function edit_scale(info) {
    info = info.split('~');
    $('#scale_id').val(info[0]);
    $('#product_scale').val(info[1]);
    if(info[2] === '1'){
        $('#scale_status').attr('checked', 'checked');
    }else{
        $('#scale_status').attr('unchecked', 'unchecked');
    }
}

let get_department_wise_stock = () => {
	var ajax_data3 = "<?=base_url(); ?>assets/ajax/data_table/scm/department_product_stock_datatable.php?department=" + $('#department').val() + "&branch=" + $('#branch').val();
	$('#department_stock').DataTable().ajax.url(ajax_data3).load();
}

$(document).ready(function () {
    var table = $('#warehouse_stock').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"ScrollX": false,
		"serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/warehouse_stock_datatable.php",
        columnDefs: [
			{ targets: [ 2 ], visible: false},
		]
    });
	var purchase_order = $('#department_stock').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"order": [[ 2, "asc" ]],
		"info": true,
		"ScrollX": true,
		"processing": true,
		"serverSide": true,
		"ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/department_product_stock_datatable.php",
		columnDefs: [
			{ targets: [ 2 ], visible: false},
		]
	});
	 var state = true; 
	$(document).on('click', '.product-image', function(e){
          e.preventDefault();
		  e.stopPropagation();
		  if(state){
			  $(this).css({"position": "absolute", "width": "70%","height":"480px","z-index":"999999999", "margin": "auto", "top":"30px"});
		  }else{
			 $(this).css({"position": "", "width": "", "height": "","z-index":"", "margin": ""}); 
		  }
		  state = !state;
		  
      });
	 $(window).click(function() {
	  $('.product-image').css({"position": "", "width": "80px", "height": "", "z-index":"", "margin": ""}); 
	   state = !state;
	});
	  
	  /* max-width: 100%;
	max-height: 100vh;
	margin: auto;
	"transform": "scale(10)",  */
	  
	  
});
</script>