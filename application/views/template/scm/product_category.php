<style>
    .card-header{
        font-weight: 500;
        color: white;
    }
</style>

<!---- edit product category modal-->
<div class="modal fade" id="edit_product">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=base_url()?>admin/scm/product-category/update" method="post">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Update Product Category</h4>
				</div>
				<div class="modal-body" id="category_update">
                    
				</div>                
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<!---- edit product brand modal-->
<div class="modal fade" id="edit_brand">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=base_url()?>admin/scm/product-category/brand-update" method="post">
                <input type="hidden" name="brand_id" id="brand_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product Brand Name</h4>
				</div>
				<div class="modal-body" id="brand_update">
				</div>                
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<!---- add product configuration -->
<div class="modal fade" id="add_configuration">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=base_url()?>admin/scm/product-category/add-configuration" method="post">
                <input type="hidden" name="product_category_id_modal" id="product_category_id_modal">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product Configuration</h4>
				</div>
				<div class="modal-body" id="configuration_select">
				</div>                
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm">Add Configuration</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>

<!--        End Modal         -->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Product Categories</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Product Category</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
		<div class="container-flud">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header" style="background-color: #4db6ac;">
                            Add Product Name
                        </div>
                        <form action="<?=base_url()?>admin/scm/product-category/insert" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="product_type">Select Product Type</label>
                                    <select class="form-control select2" name="product_type" id="product_type" required>
                                        <option value="">Select Type</option>
                                        <?php foreach($types as $type){ ?>
                                            <option value="<?php echo $type->id;?>"><?php echo $type->name;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="product_category">Product Name</label>
                                        <textarea class="form-control" type="text" name="product_category" placeholder="Enter Product Category"></textarea>
                                    </div>
                                    <!-- <div class="col-sm-8">
                                        <label for="product_category">Product Brands</label>
                                        <input class="form-control" type="text" name="product_brands" placeholder="Enter Product Brands">
                                    </div> -->
                                </div>
                                                               
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="background-color: #4db6ac;">
                            Products Name List
                        </div>
                        <div class="card-body">
							<table class="table table-sm text-center" id="product_category_table">
                                <thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Type</th>
										<th>Specifications</th>
										<th>Status</th>
										<th style="width: 75px;">Option</th>
									</tr>
								</thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
									<tr hidden>
										<th>ID</th>
										<th>Name</th>
										<th>Type</th>
										<th>Specifications</th>
										<th>Status</th>
										<th >Option</th>
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
function add_configuration_ajax(product_category_id) {
    $.ajax({  
        url:"<?=base_url()?>assets/ajax/scm/get_product_specification.php",
        method:"POST",
        data: {product_category_id: product_category_id},
        success:function(data){            
            $('#product_category_id_modal').val(product_category_id);
            $('#configuration_select').html(data);
	        $('.select2').select2();
        }  
    });
}
function edit_brand(info) {
    info = info.split('~');
    $('#brand_id').val(info[0]);
    $('#product_brand').val(info[1]);
    if(info[2] === '1'){
        $('#brand_status').attr('checked', 'checked');
    }else{
        $('#brand_status').attr('unchecked', 'unchecked');
    }
    $.ajax({  
        url:"<?=base_url()?>assets/ajax/scm/edit_product_brand.php",
        method:"POST",
        data:{ brand_id:info[0], product_brand_name:info[1], brand_status:info[2], category_id:info[3]},
        success:function(data){
            $('#brand_update').html(data);
            $('#edit_brand').modal('toggle');
        }  
    });
}
function edit_product(info) {
    info = info.split('~');
        $.ajax({  
            url:"<?=base_url()?>assets/ajax/scm/edit_product_category.php",
            method:"POST",
            data:{ product_category_id:info[0], product_category_name:info[1], product_category_status:info[2], product_type_id:info[3]},
            success:function(data){
                $('#category_update').html(data);
                $('#edit_product').modal('toggle');
            }  
        });
}
$(document).ready(function () {
    var table_booking = $('#product_category_table').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"ScrollX": false,
        "processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/product_category_datatable.php"
    });
});
</script>