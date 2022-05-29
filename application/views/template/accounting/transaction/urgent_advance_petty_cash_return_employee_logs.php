<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Urgent Return Logs</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Profile</a></li>
				<li class="breadcrumb-item active">Urgent Return Logs</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	<div class="content">
		<div class="container-fluid">
			<div class="row">				
				<div class="col-sm-12">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title"><i class="far fa-bed"></i> Urgent Return Logs</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>
											Date range:&nbsp;&nbsp;&nbsp;
											<input type="checkbox" onchange="return filter_data_table()" name="date_range_active" id="date_range_active"/>											
										</label>
										<div class="input-group">
											<div class="input-group-prepend">
											<span class="input-group-text">
												<i class="far fa-calendar-alt"></i>
											</span>
											</div>
											<input onchange="return filter_data_table()" id="date_range" type="text" class="form-control float-right date_range">
										</div>
									</div>
								</div>
							</div>
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Id</th>
										<th>Employee</th>
										<th>Amount</th>
										<th>Note</th>
										<th>Added By</th>												
										<th>Date</th>
										<th style="width:250px;">Option</th>
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
<script>
function remove_return_request(id){
	if(confirm('Are you sure want to remove return request?')){
		$.ajax({  
			url:"<?php echo current_url(); ?>",  
			method:"POST",  
			data:{ removed_return_id:id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');
				alert(data);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
			}
		});
	}
	
}

function filter_data_table(){
	if($("#date_range_active").prop("checked") == true) {
		$("#date_range").prop('disabled', false);
		var date_range = $("#date_range").val();
	}else{
		$("#date_range").prop('disabled', true);
		var date_range = '';
	}
	var employee_id = "<?php echo $_SESSION['super_admin']['employee_id']; ?>";		 //$("#employee_id").val()
    var condition = '?employee_id='+employee_id+'&date_range='+date_range+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/my_urgent_expense_return_list_employee_profile.php"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
}

$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/my_urgent_expense_return_list_employee_profile.php",
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