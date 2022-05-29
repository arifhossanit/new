<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Envelope Print</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
				<li class="breadcrumb-item active">Envelope Print</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	<div class="content">
		<div class="container-fluid">
			<div class="row">

				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="card card-success">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-3">
									<h3 class="card-title"><i class="far fa-bed"></i> Printed Check Logs</h3>
								</div>
								<div class="col-sm-2">
									<form>
										<div class="form-group">
											<input type="month" value="<?php echo date('Y-m'); ?>" id="date_filter" class="form-control"/>
										</div>
									</form>
								</div>
								<div class="col-sm-1">
									<button onclick="return print_all_envlope();" type="button" class="btn btn-warning">Print All</button>
								</div>
								<div class="col-sm-6">
									<div id="export_buttons" style="float: right;"></div>
								</div>
							</div>						
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-2 mb-3">
									<select class="form-control" id="employee_type" onchange="booking_report_table()">
										<option>New</option>
										<option>Old</option>
									</select>
								</div>
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
	var ajax_data = '<?=base_url(); ?>assets/ajax/data_table/print_envelope_datatable.php'+condition;
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/print_envelope_datatable.php"+condition,
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
</script>