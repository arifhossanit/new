<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Live Request For Calcel List Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">Live Request For Calcel List Report</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">					
					<div class="row">
						<div class="col-sm-12">
							<span id="data_send_success_message"></span>
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title"><i class="far fa-bed"></i>Live Request For Calcel List Report</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<!--<div class="row">								
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-4"></div>
												<div class="col-sm-4">
													<div style="border: solid 1px #bfbebe;border-radius:5px;padding:5px;">
														<label>Short By Date(mm/dd/yyyy)</label><button onclick="return booking_reset()" type="button" class="btn btn-xs btn-success" style="float:right;"><i class="fas fa-retweet"></i> Reset</button>
														<div class="row">
															<div class="col-sm-1">
																<label>From</label>
															</div>
															<div class="col-sm-5">
																<div class="form-group">
																	<input type="date" id="short_from" class="form-control"/>
																</div>
															</div>
															<div class="col-sm-1">
																<label>To</label>
															</div>
															<div class="col-sm-5">
																<div class="form-group">
																	<input type="date" id="short_to" class="form-control"/>
																</div>
															</div>
														</div>
													</div>
												</div>			
												
											</div>										
							
										</div>
									</div>-->
									<input type="hidden" id="short_from" class="form-control"/>
									<input type="hidden" id="short_to" class="form-control"/>
								
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>id</th>
												<th>Image</th>												
												<th>Card_No</th>
												<th>Branch</th>
												<th>Name</th>												
												<th>Phone_Number</th>
												<th>Email</th>
												<th>Bed</th>
												<th>Package_Category</th>
												<th>Membership</th>
												<th>CheckIn_date</th>
												<th>CheckOut_date</th>
												<th>Note</th>
												<th>Cancel_By</th>
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
		</div>
	</div>
</div>




<!----vaiw model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Member information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">	
					
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->





<!----vaiw model-->
	<div class="modal fade" id="member_prifile_model_details">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Member Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result_details" style="max-height:780px;overflow-y:scroll;">	

						
					</div>
					<div class="modal-footer justify-content-between">

					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->


<!----Final Checkout model-->
	<div class="modal fade" id="final_checkout_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Finally Check Out</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="final_checkOut_result" style="max-height:780px;min-height:510px;overflow-y:scroll;">	
					
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End Final Checkout model-->


<script>
var uploader_info = "<?php echo base64_encode($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']); ?>";



//-----------------rental work java script-------------------------
function view_member_profile(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/member_profile_information.php');?>",  
			method:"POST",  
			data:{profile_id:profile_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result_details').html(data);   
				$('#member_prifile_model_details').modal('show');   
			}  
		});  
	}
}
function member_withdraw_modal(id){
	if(confirm('Are You Confirm to withdraw this member?')){
		var book_id = id;
		if(book_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/form_submit/request_for_withdraw_submit.php');?>",  
				method:"POST",  
				data:{ member_id:book_id },
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					$('#data-loading').html('');
					$('#data_send_success_message').html(data); 
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}  
			});
		}
	}
}
function member_final_checkout_modal(id){
	var book_id = id;
	var branch_id = "<?php echo $_SESSION['super_admin']['branch']; ?>";
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/member_final_checkout_form.php');?>",  
			method:"POST",  
			data:{
				book_id:book_id,
				uploader_info:uploader_info,
				branch_id:branch_id
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#final_checkOut_result').html(data); 
				$('#final_checkout_model').modal('show');
			}  
		});
	}
}




$("#short_from").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
$("#short_to").on("focus focusout change keyup keyown",function(){
	return booking_report_table();
})
function booking_reset(){
	$("#short_from").val('');
	$("#short_to").val('');
	return booking_report_table();
}
$('document').ready(function(){	
	//return booking_report_table();
})
function booking_report_table(){
	var report_info = '&booking_from='+$("#short_from").val()+'&booking_to='+$("#short_to").val()+'';
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/report/live_request_for_cancel_member_list.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}
$('document').ready(function(){	
	var report_info = '&booking_from='+$("#short_from").val()+'&booking_to='+$("#short_to").val()+'';
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var condition = table_info+report_info;	
	var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
		"scrollX": true,
		columnDefs: [
			{ type: 'percent', targets: 0 }
		],
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/live_request_for_cancel_member_list.php"+condition,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            }
        ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));
})

jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "percent-pre": function ( a ) {
        var x = (a == "-") ? 0 : a.replace( /%/, "" );
        return parseFloat( x );
    },
 
    "percent-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
 
    "percent-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>