<style>
.btn-sm{
    padding: .15rem .3rem;
    font-size: .675rem;
}
.fa-xs{
    font-size: .5em !important;
    color: red;
}
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Product</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Edit Products</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="margin-bottom: 150px;">
                    <div class="card-header">Edit Product</div>
                    <form action="<?=base_url()?>admin/scm/add-product/insert" method="post" id="add_product_form" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="text-danger" id="error_message"></div>
                            <div class="row justify-content-between">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="product_type">Select Product Type <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                        <select class="form-control select2" name="product_type" id="product_type" required onchange="get_product_categories(this.value)">
                                            <option value="">Select Type</option>
                                            <?php foreach($types as $type){ ?>
                                                <?php if($type->id == $product->product_type_id) { ?>
                                                    <option value="<?php echo $type->id;?>" selected><?php echo $type->name;?></option>
                                                <?php }else{ ?>
                                                    <option value="<?php echo $type->id;?>"><?php echo $type->name;?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <fieldset style="border: 1px solid gray; border-radius: 5px;padding-left: 20px;padding-bottom: 20px;padding-right: 20px;">
                                            <legend style="width:auto; margin-bottom: 0px; margin-left: 5px; padding-left: 5px; padding-right: 5px; font-size: 15px; font-weight: bold; color: #1f497d;">Details</legend>
                                            <label for="product_category">Select Product Name <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                            <select class="form-control select2" name="product_category" id="product_category" onchange="get_product_specification(this.value)" required>
                                                <?php foreach($product_categories as $product_category){ ?>
                                                    <?php if($product_category->id == $product->product_category_id) { ?>
                                                        <option value="<?php echo $product_category->id;?>" selected><?php echo $product_category->name;?></option>
                                                    <?php }else{ ?>
                                                        <option value="<?php echo $product_category->id;?>"><?php echo $product_category->name;?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <label for="product_category">Select Brand</label>
                                            <select class="form-control select2" name="product_brand" id="product_brand">
                                                <option value="">Select Brand</option>
                                                <?php foreach($brands as $brand){ ?>
                                                    <?php if($brand->id == $product->brand_id) { ?>
                                                        <option value="<?php echo $brand->id;?>" selected><?php echo $brand->name;?></option>
                                                    <?php }else{ ?>
                                                        <option value="<?php echo $brand->id;?>"><?php echo $brand->name;?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <label for="product_name">Product Model</label>
                                            <input class="form-control" type="text" name="product_name" id="product_name" value="<?= $product ?>">
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">Product Image <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                        <input class="form-control-file" type="file" name="product_image" id="product_image" accept="image/*" required>
                                    </div>
                                    <div class="form-group">                                        
                                        <div id="other_product_color"></div>
                                        <label for="product_scale">Select Product Scale <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                        <select class="form-control select2" name="product_scale" id="product_scale" required>
                                            <option value="">Select Type</option>
                                            <?php foreach($scales as $scale){ ?>
                                                <option value="<?php echo $scale->id;?>"><?php echo $scale->name;?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="product_scale">Select Department <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                        <select class="form-control select2" name="departments_id[]" id="departments_id" required>
                                            <option value="">Select Type</option>
                                            <?php foreach($departments as $department){ ?>
                                                <option value="<?php echo $department->department_id;?>"><?php echo $department->department_name;?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="">Select Product Sizes</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="form-control select2" id="product_specification" name="product_specification" onchange="get_product_measurements(this.value, 'no')">
                                                    <option value="none" selected>Choose...</option>
                                                    <option value="square">Square</option>
                                                    <option value="rectangle">Rectangle</option>
                                                    <option value="round">Round</option>
                                                    <option value="liquid">Liquid</option>
                                                    <option value="mass">Mass</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12" id="measurement_div">
                                                
                                            </div>
                                        </div>
                                        <label for="product_color">Select Product Color</label>
                                        <select class="form-control select2" name="product_color[]" id="product_color" onchange="get_other_field('product_color')" multiple>
                                            <option>Gray</option>
                                            <option>White</option>
                                            <option>Orange</option>
                                            <option>Yellow</option>
                                            <option>Green</option>
                                            <option>Blue</option>
                                            <option>Cyan</option>
                                            <option>Purple</option>
                                            <option>Red</option>
                                            <option>Black</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-md-12">
                                    <div class="row" id="specification"></div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="product_description">Product Description</label>
                                        <textarea class="form-control" name="product_description" id="product_description" cols="30" rows="2" placeholder="Enter Product Details"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <input style="float: right;" class="btn btn-primary" type="submit" name="submit" id="submit" value="Add Product">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let extra_specification_count = 0;
    function add_specification(id) {
        let input = document.createElement("INPUT");
        input.setAttribute('class', 'form-control mt-1');
        input.setAttribute('name', id + '[]');
        $('#' + id ).append(input);
    }
    function remove_specification(id) {
        $('#' + id).children().last().remove();
    }
    let get_product_specification = (product) => {
        $.ajax({  
            url:"<?=base_url()?>assets/ajax/scm/get_product_specification_to_add.php",
            method:"POST",
            data:{ product },
            success:function(data){
                $('#specification').html(data);
            }  
        });
    }
    
    function remove_extra_product_measurements() {
        $('.extra-extra-measurement').last().remove();
    }
    function get_product_measurements(product_type, append, extra = 'no', extra_specification = 'null') {
        $.ajax({  
            url:"<?=base_url()?>assets/ajax/scm/get_product_measurements.php",
            method:"POST",
            data:{ product_type, append, extra_specification},
            success:function(data){
                if(append == 'no'){
                    $('#measurement_div').html(data);
                }else if(extra === 'extra'){
                    $('#extra_measurement_div_' + extra_specification_count).html(data);
                    extra_specification_count++;
                }else if(extra === 'extra_extra'){
                    $('#extra_measurement_div_extra').append(data);
                }else{
                    $('#measurement_div_extra').append(data);
                }
	            $('.select2').select2();
            }  
        });
    }
    function get_product_categories(product_type) {
        $.ajax({  
            url:"<?=base_url()?>assets/ajax/scm/get_product_categories.php",
            method:"POST",
            data:{ product_type:product_type },
            success:function(data){
                $('#product_category').html(data);
            }  
        });
    }
    $('#add_product_form').on('submit', function () {
        if( $('#product_image').val() == '' ){
            $('#error_message').html('Enter Product Image');
            return false;
        }
    });
    function get_other_field(div_id) {
        if(div_id === 'product_color' && $('#product_color').val() === 'Other'){
            $('#other_' + div_id).html('<input class="form-control mt-2" type="text" name="color_other" placeholder="Specify Color">');
        }else{
            $('#other_' + div_id).html('');
        }
    }
</script>