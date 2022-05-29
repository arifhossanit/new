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
					<h1 class="m-0 text-dark">Add Service Product</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Add Service Products</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">        
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card" style="margin-bottom: 150px;">
                    <div class="card-header">Add Service Product</div>
                    <form action="<?=base_url()?>admin/scm/service-product/insert" method="post" id="add_product_form" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="text-danger" id="error_message"></div>
                            <div class="form-group">
                                <label for="product_type">Select Product <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                <select class="form-control select2" name="product_type" id="product_type" required>
                                    <option value="">  Select Product  </option>
                                    <?php foreach($service_products as $service_product){ ?>
                                        <option value="<?php echo $service_product->id;?>"><?php echo $service_product->name;?></option>
                                    <?php } ?>
                                </select>
                                <label class="mt-2" for="vendor">Select Vendor <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                <select class="form-control select2" name="vendor" id="vendor" required>
                                    <option value="">  Select Vendor  </option>
                                    <?php foreach($vendors as $vendor){ ?>
                                        <option value="<?php echo $vendor->id;?>"><?php echo $vendor->company_name;?></option>
                                    <?php } ?>
                                </select>
                                <label class="mt-2" for="assigned_to">Select Employee <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                <select class="form-control select2" name="assigned_to" id="assigned_to" required>
                                    <option value="">  Select Employee  </option>
                                    <?php foreach($employees as $employee){ ?>
                                        <option value="<?php echo $employee->id;?>"><?php echo $employee->full_name;?></option>
                                    <?php } ?>
                                </select>
                                <label class="mt-2" for="employee">Service start date: <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                <input name="start_date" type="text" class="form-control datepicker" placeholder="Starting From" required>
                                <label class="mt-2" for="agreement_type">Agreement Type <i class="fa fa-asterisk fa-xs" aria-hidden="true"></i></label>
                                <select class="form-control select2" name="agreement_type" id="agreement_type" required>
                                    <option value="">  Select Agreement Type</option>
                                    <option>Yearly</option>
                                    <option>Monthly</option>
                                </select>
                                <div class="form-check form-switch">
                                    <input class="form-check-input regular-checkbox" type="checkbox" id="service_type" name="service_type">
                                    <label for="service_type">Vehicle</label>
                                </div>
                                <textarea class="form-control mt-2" name="description" id="description" cols="30" rows="3" placeholder="Description" required></textarea>
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
    
</script>