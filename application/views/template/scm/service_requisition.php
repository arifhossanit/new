<!-- Service Request -->
<div class="modal fade" id="request_service">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="" id="service_request_form" method="post">
                <input type="hidden" name="requesting_product" id="requesting_product">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Requisition Details</h4>
				</div>
				<div class="ml-3 text-danger" id="error_message"></div>
				<div class="modal-body" id="request_service_div">
                    <!-- <div class="row justify-content-between"> -->
                    
				</div>
				<div class="modal-footer">
					<button id="submit_button" type="submit" class="btn btn-primary btn-sm">Submit</button>
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
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Service Requisition</li>
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
                            <h4>Service Products</h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="service_product" value="122">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="requisition_date">Select date</label>
                                    <input type="date" name="requisition_date" id="requisition_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" onchange="get_service_requisition_history(this.value)">
                                </div>
                                <div class="col-md-2 align-self-end" id="service_request_div">
                                    <p class="font-weight-bold">Request for selected date</p>
                                    <button type="button" class="btn btn-primary btn-sm" data-target="#request_service" data-toggle="modal" onclick="get_requisition_services()">Request!</button>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <table class="table table-sm text-center table-bordered table-hover mt-4" id="service_requisition_table">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Photo</th>
                                                <th>Requisition For</th>
                                                <th>Time from</th>
                                                <th>Time to</th>
                                                <th>Requested duration</th>
                                                <th>Travel History</th>
                                                <th>Destination from</th>
                                                <th>Destination to</th>
                                                <th>Note</th>
                                                <th>Requested By</th>
                                                <th>Requested Submitted At</th>
                                                <th style="width: 75px;">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_body">
                                        </tbody>
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
    let get_requisition_services = () => {
        $('#submit_button').html('Submit');
        let requisition_for = $('#service_product').val();
        $.ajax({  
            type: "POST",
            url:"<?=base_url('assets/ajax/scm/get_requisition_services.php')?>",  
            data: { requisition_for },
            success:function(data){
                $('#request_service_div').html(data);
                $('#requesting_product').val(requisition_for);
            }  
        });
    }
    let get_service_request_form = (form_for) => {
        console.log('test');
        $('#submit_button').html('Submit');
        let form_type = $(form_for).find(':selected').data('formtype');
        console.log(form_type);
        if(form_type === ''){
            $('#requisition_form').html('');
        }else{
            $.ajax({  
                type: "POST",
                url:"<?=base_url('assets/ajax/scm/get_service_request_form.php')?>",  
                data: { form_type },
                success:function(data){
                    $('#requisition_form').html(data);
                }  
            });
        }        
    }
    $('#service_request_form').on('submit', () => {        
        event.preventDefault();        
        var form = $('#service_request_form')[0];
        var data = new FormData(form);
        let requisition_date = $('#requisition_date').val();
        data.append('requisition_date', requisition_date);
        $.ajax({  
            type: "POST",
            enctype: 'multipart/form-data',
            url:"<?=base_url('admin/scm/service-requeset')?>",  
            data: data,
            processData: false,
            contentType: false,
            beforeSend:function(){
                // $('#submit_button').html('<i class="fas fa-spinner fa-spin"></i>');
                // $('#submit_button').prop('disabled', true);
            },
            success:function(data){
                let info = JSON.parse(data);
                console.log(info);
                if(info.error){
                    $('#error_message').html(info.message);
                    $('#submit_button').prop('disabled', false);
                    $('#submit_button').html('Submit');
                }else{
                    $('#request_service').modal('hide');
                    $('#error_message').html('');
                    get_service_requisition_history(requisition_date);
                    $('#submit_button').prop('disabled', false);
                }
                // $('#product_bill_div').html(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $('#error_message').html(thrownError);
                $('#submit_button').prop('disabled', false);
                $('#submit_button').html('Submit');
            }
        });
    })
    let from_other_function = (value) => {
        if(value == 'other'){
            $('#other_from').show();
            $('#from_other').prop('required', true);
        }else{
            $('#other_from').hide()
            $('#from_other').prop('required', false);
        }
    };
    let to_other_function = (value) => {
        if(value == 'other'){
            $('#other_to').show();
            $('#to_other').prop('required', true);
        }else{
            $('#other_to').hide()
            $('#to_other').prop('required', false);
        }
    };
    let remove_service_requisition = (requisition_for) => {
        let requisition_date = $('#requisition_date').val();
        $.ajax({  
            url:"<?=base_url('admin/scm/service-requeset/remove')?>",
            method:"POST",
            data:{ requisition_for },
            success:function(data){
                let info = JSON.parse(data);
                // if(info.error){
                //     $('#error_message').html(info.message);
                //     $('#submit_button').prop('disabled', false);
                //     $('#submit_button').html('Submit');
                // }else{
                    get_service_requisition_history(requisition_date);
                // }
            }  
        });
    }

    
    let get_service_requisition_history = (date) => {
        let today = new Date();
        let selected_date = new Date(date);
        today.setHours(0,0,0,0);
        selected_date.setHours(0,0,0,0);
        if(today <= selected_date){
            $('#service_request_div').show();
        }else{
            $('#service_request_div').hide();
        }
        let requisition_for = $('#service_product').val();
        $.ajax({  
            url:"<?=base_url()?>assets/ajax/scm/get_service_requisition_history.php",
            method:"POST",
            data:{ date, requisition_for },
            success:function(data){
                $('#service_requisition_table').DataTable().clear().destroy();
                $('#table_body').html(data);
                var table_booking = $('#service_requisition_table').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "lengthMenu": [
                        [10, 25, 50, 100, 500],
                        [10, 25, 50, 100, 500]
                    ],
                    "searching": true,
                    "ordering": true,
                    "order": [[ 0, "desc" ]],
                    //"info": true,
                    //"autoWidth": true,
                    //"responsive": true,
                    "ScrollX": true,
                    "serverSide": false,
                    "processing": true,
                    "columnDefs": [
                        { "width": "12%", "targets": 8 }
                        // { targets: [ 6 ], visible: false}
                    ]
                });
            }  
        });
    }
    $(document).ready(() => {
        get_service_requisition_history($('#requisition_date').val());
    });    
    setInterval(function(){ get_service_requisition_history($('#requisition_date').val()); }, 3000);
</script>