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
            <div class="col-md-12">
                <div class="card" style="margin-bottom: 150px;">
                    <div class="card-header"><h4>Active Service Lists</h4></div>
                    <div class="card-body">
                        <table id="product_list_datatable" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">id</th>
                                    <th style="width: 100px;">Service Name</th>
                                    <th>Vendor</th>
                                    <th>Assigned To</th>
                                    <th>Active From</th>												
                                    <th>Agreement type</th>
                                    <th>Description</th>
                                    <th>Creation Employee</th>
                                    <th>Creation Info</th>
                                    <th>Option</th>
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
<script>
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
</script>