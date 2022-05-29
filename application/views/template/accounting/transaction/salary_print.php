<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Employee Salary</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
				<li class="breadcrumb-item active">Employee Salary</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	<div class="content">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<div class="col-sm-10">
					<div class="card card-success">
						<div class="card-header">
							<form role="form" action="<?=base_url('admin/send_noty_emp'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
							<div class="row">
								<div class="col-sm-3">
									<h3 class="card-title"><i class="far fa-bed"></i> All Employee Salaries</h3>
								</div>
								
								<div class="col-sm-2">
									
										<div class="form-group">
											<input type="month" name="month" value="<?php echo date('Y-m'); ?>" id="date_filter" class="form-control" required/>
										</div>
                            	
								</div>

								<div class="col-sm-2">
									  <?php $today = date('Y-m-d'); $check = date('Y-m')."-"."10"; //echo $check; ?>
										<div class="form-group">
										 
										  <select name="old_new" class="form-control" id="emp_generate" required>			    
											  <option value="" selected disabled>Choose Option</option>
											  <?php if($today > $check): ?>
											  <option value="new" disabled>New</option>
											  <option value="old">Old</option>
											  <?php else: ?>
												<option value="new">New</option>
											  <option value="old" disabled>Old</option>
											  <?php endif; ?>									  
										  </select>
										</div>
                            	
								</div>

								<div class="col-sm-1">
									<button type="submit" class="btn btn-primary btn-sm" id="confirm_noty">Send notification</button>
								</div>
								
								<div class="col-sm-6">
									<div id="export_buttons" style="float: right;"></div>
								</div>
							</div>	
                         </form>					 
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
										<thead>
											<tr>
												<th>Id</th>
												<th>Name</th>
												<th>Employee ID:</th>
												<th>Designation</th>
												<th>Department</th>
												<th>Branch</th>
												<th>Amount</th>
												<th>Month-Year</th>
												<th>Generate Date</th>												
												<th>Payment Type</th>												
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

<div class="modal" id="salary_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm his/her Otp</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
		  <label for="otp">Otp</label>
		  <input type="number" id="otp" class="form-control otp" placeholder="Otp"> 
		</div>
		<input type="hidden" class="confirm_id" value="">
		<div class="form-group">
			<button type="button" class="btn btn-success confirm_otp">Confirm Otp</button>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!----vaiw model-->
	<div class="modal fade" id="check_print_model">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Check Print information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="check_print_result" style="height:1080px;overflow-y:scroll;">	
					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->


<!----vaiw model-->
<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Rental information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result"></div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->

<script>
function print_all_envlope(){
	var month = $("#date_filter").val();
	let employee_type = $('#employee_type').val();
	if(month != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/envelope_print_model.php');?>",  
			method:"POST",  
			data:{month:month, employee_type},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#check_print_result').html(data); 
				$("#check_print_model").modal('show');   
			}  
		});  
	}
}
function check_print_modal(id){
	var check_id = id;
	if(check_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/envelope_print_model.php');?>",  
			method:"POST",  
			data:{check_id:check_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#check_print_result').html(data); 
				$("#check_print_model").modal('show');   
			}  
		});  
	}	
}

$("#date_filter").on("change",function(){
	return booking_report_table();
})

function booking_report_table(){
	var condition = '?date_filter='+$("#date_filter").val() + '&employee_type=' + $('#employee_type').val();	
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/salary_print_datatable.php'+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data).load();	
}

function view_rental_recipt(id){
	$.ajax({  
		url:"<?=base_url('assets/ajax/salary_details_information.php');?>",  
		method:"POST",  
		data:{id},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#members_result').html(data); 
			$('#member_prifile_model').modal('show');
		}  
	});  
}

$(document).ready(function() {
	var condition = '?date_filter='+$("#date_filter").val() + '&employee_type=' + $('#employee_type').val();
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		scrollY: false,
		scrollX: true,
		
		/* columnDefs: [
		  { visible: false, targets: 1 }
		], */

		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/salary_print_datatable.php"+condition,
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
	$(document).on('click', '.confirm', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$('.confirm_id').val(id);
		$("#salary_modal").modal('show');
	});

	$(document).on('click', '.resend_again', function(){
		var employee_id = $(this).data('id');
		$.ajax({
                url: "<?=base_url('api/resend_otp_again'); ?>",  

				type:"GET",
				data:{'employee_id':employee_id},
				dataType:"html",
				success:function(data) {	
					//alert('Otp resend Successfully');
				   alert(data);
				},
								
			});
	});
    
	$(document).on('click', '#confirm_noty', function(){
		if(confirm('Are you sure want to send notification to all employee?'))
		{
			return true;
		}
		else
		{
			return false;
		}
	});
	$(document).on('click', '.confirm_otp', function(e){
		e.preventDefault();
		var otp = $('.otp').val();
		var id = $('.confirm_id').val();
		var month = $("#date_filter").val();
		if(otp == '')
		{
			alert('Otp field is required');
		}
		else
		{
			$.ajax({
                url: "<?=base_url('admin/confirm_salary'); ?>",  

				type:"POST",
				data:{'employee_id':id, 'otp':otp, 'month':month},
				dataType:"html",
				success:function(data) {	
					 if(data == 'invalid_otp')
					 {
						alert('Invalid Otp');
					 }
					 else
					 {
						$('#booking_data_table').DataTable().ajax.reload( null , false);

						$('.otp').val('');
						$('.confirm_id').val('');
						$("#salary_modal").modal('hide');
						//$("#source_price_"+id).html('<badge class="badge badge-primary badge-xs ml-1">Approved</badge>');
						alert('Successfully Otp matched and salary has beeen confirmed');
					 }
				
				
				},
								
			});
		}
		
		
	});
})
</script>