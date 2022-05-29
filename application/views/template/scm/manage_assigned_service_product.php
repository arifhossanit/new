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
<!---- Product bill / History -->
<div class="modal fade" id="add_bill">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="" id="bill_submit_form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="bill_of" id="bill_of">
				<div class="modal-header btn-primary">
					<h4 class="modal-title" id="modal_title"></h4>
				</div>
				<div class="modal-body" id="product_bill_div">
                    
                </div>                
                <div class="modal-footer">
                    <div id="modal_button"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<!---- Driver history -->
<div class="modal fade" id="driver_history">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="" id="driver_history_form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="driver_of" id="driver_of">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Driver History</h4>
				</div>
				<div class="modal-body" id="driver_history_div">
                    
                </div>                
                <div class="modal-footer">
                    <button id="submit_button" type="submit" class="btn btn-info">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Manage Service Products</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">        
        <div class="row justify-content-center">
            <?php foreach($assigned_services as $assigned_service){ ?>
                <div class="col-md-2">
                    <button id="<?php echo $assigned_service->id; ?>" class="btn btn-default" style="font-size: 25px;" onclick="get_service_products(<?php echo $assigned_service->id; ?>)"><?php echo $assigned_service->name; ?> <span> - #<?php echo $assigned_service->number_of_service; ?></span> </button>
                </div>
            <?php } ?>
        </div>
        <div id="service_product_div">
            <table id="assigned_service_product" class="display table table-sm table-bordered table table-striped table-hover" style="width:100%;font-size: 16px;white-space: nowrap;">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Vendor</th>
                        <th>Agreement Type</th>
                        <th>Start Date</th>
                        <th>History</th>
                        <th>Option</th>
                        <th>id</th>
                        <th>driver</th>
                        <th>vehicle</th>
                        <th>description</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $('#bill_submit_form').on('submit', function(){
        event.preventDefault();
        var form = $('#bill_submit_form')[0];
        var data = new FormData(form);
        // console.log(data);
        // var document = $('#document').val();
        // data.append('document', document);
        $.ajax({  
            type: "POST",
            enctype: 'multipart/form-data',
            url:"<?=base_url()?>assets/ajax/scm/service_bill_submit.php",  
            data: data,
            processData: false,
            contentType: false,
            beforeSend:function(){
                $('#submit_button').prop('disabled', true);
            },
            success:function(data){
                let info = JSON.parse(data);
                if(info.error){
                    $('#error_text').html(info.message);
                    $('#submit_button').prop('disabled', false);
                }else{
                    $('#add_bill').modal('hide');
					$('#assigned_service_product').DataTable().ajax.reload( null , false);									
                }
                // $('#product_bill_div').html(data);
            }  
        });
    })
    $('#driver_history_form').on('submit', function(){
        event.preventDefault();
        var form = $('#driver_history_form')[0];
        var data = new FormData(form);
        // console.log(data);
        // var document = $('#document').val();
        // data.append('document', document);
        $.ajax({  
            type: "POST",
            enctype: 'multipart/form-data',
            url:"<?=base_url()?>assets/ajax/scm/update_driver.php",  
            data: data,
            processData: false,
            contentType: false,
            beforeSend:function(){
                $('#submit_button').prop('disabled', true);
            },
            success:function(data){
                $('#driver_history').modal('hide');
                $('#submit_button').prop('disabled', false);
            }  
        });
    })
    let get_driver_history = (driver_of) => {
        $.ajax({  
            url:"<?=base_url('assets/ajax/scm/add_driver.php')?>",
            method:"POST",
            data:{ driver_of },
            success:function(data){                
                $('#driver_history_div').html(data);
                $('#driver_of').val(driver_of);
                $('.datepicker').datepicker({
                    format: 'yyyy/mm/dd',
                    todayHighlight:'TRUE',
                    autoclose: true,
                });
            }  
        });
    }

    function get_history(name, company, history_of){
        $.ajax({  
            url:"<?=base_url()?>assets/ajax/scm/service_billing_history.php",
            method:"POST",
            data:{ name, company, history_of },
            success:function(data){
                let info = JSON.parse(data);
                $('#product_bill_div').html(info.html);
                $('#modal_title').html('Billing History');
                var table_booking = $('#billing_history_table').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "lengthMenu": [
                        [10, 25, 50, 100, 500],
                        [10, 25, 50, 100, 500]
                    ],
                    "searching": true,
                    "ordering": true,
                    "order": [[ 1, "desc" ]],
                    "ScrollX": true,
                    "serverSide": true,
                    "processing": true,
                    "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/assigned_service_product_history_datatable.php" + info.data,
                    "columnDefs": [
                        { targets: [ 1 ], visible: false}
                    ]
                });
            }  
        });
    }

    function add_bill_service(type, bill_of){
        $('#bill_of').val(bill_of);
        $.ajax({  
            url:"<?=base_url()?>assets/ajax/scm/add_bill_for_service.php",
            method:"POST",
            data:{ type },
            success:function(data){
                let info = JSON.parse(data);
                $('#product_bill_div').html(info.html);
                $('#modal_button').html(info.button);
                $('#modal_title').html('Billing Details');                
            }  
        });
    }
    function get_service_products(product){
        $.ajax({  
            url:"<?=base_url()?>assets/ajax/scm/get_assigned_service_product.php",
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
    $(document).ready(function () {
        var table_booking = $('#assigned_service_product').DataTable({
            "paging": true,
            "lengthChange": true,
            "lengthMenu": [
                [10, 25, 50, 100, 500],
                [10, 25, 50, 100, 500]
            ],
            "searching": true,
            "ordering": true,
            "order": [[ 1, "desc" ]],
            //"info": true,
            //"autoWidth": true,
            //"responsive": true,
            "ScrollX": true,
            "serverSide": true,
            "processing": true,
            "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/assigned_service_product_list_datatable.php",
            "columnDefs": [
                { targets: [ 6, 7, 8, 9 ], visible: false}
            ]
        });
    });
</script>