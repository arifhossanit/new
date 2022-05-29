<style>
.row{
    margin-right: 0px;
    margin-left: 0px;
}
.card{
    box-shadow: 0;
    transition: 0.5s;
}
.card:hover{
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    cursor: pointer;
}
.card-anchor{
    text-decoration: none;
    color: black;
}
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"><?php echo (isset($purchase_order)) ? 'Product Order' : 'Product Requisition'; ?></h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active"><?php echo (!empty($purchase_order)) ? 'Product Order Type' : 'Product Requisition Type'; ?></li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <a class="card-anchor" href="<?php echo base_url(); ?>admin/scm/product-requisition/food<?php echo (empty($purchase_order)) ? '' : '/'.$purchase_order; ?>">
                    <div class="card" style="width: 300px;height: 200px;border-radius: 15px;">
                        <div class="row align-items-end" style="background-image: linear-gradient(to right, rgba(206, 147, 216, 1), rgba(142, 36, 170, 1));border-radius: 15px 15px 0px 0px;">
                            <div class="col-md-6">
                                <img class="" src="<?php echo base_url(); ?>assets/img/groceris.png" alt="Card image" width="140px" height="140px">
                            </div>
                            <div class="col-md-6 text-center">
                                <p style="font-size: 43px;font-weight: 600;color: white;">Food</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>Food and Grocery Items</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a class="card-anchor" href="<?php echo base_url(); ?>admin/scm/product-requisition/other<?php echo (empty($purchase_order)) ? '' : '/'.$purchase_order; ?>">
                    <div class="card" style="width: 300px;height: 200px;border-radius: 15px;">
                        <div class="row align-items-end" style="background-image: linear-gradient(to right, rgba(206, 147, 216, 1), rgba(142, 36, 170, 1));border-radius: 15px 15px 0px 0px;">
                            <div class="col-md-6">
                                <img class="" src="<?php echo base_url(); ?>assets/img/electronic.png" alt="Card image" width="140px" height="140px">
                            </div>
                            <div class="col-md-6 text-center">
                                <p style="font-size: 43px;font-weight: 600;color: white;">Others</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>Other Items</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>