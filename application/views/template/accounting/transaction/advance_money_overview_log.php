<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Advance Money Approval Logs</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Transaction</a></li>
				<li class="breadcrumb-item active">Advance Money Approval Logs</li>
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
							<h3 class="card-title"><i class="far fa-bed"></i> Advance Money Approval Logs</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Short Employee</label><small class="req"> *</small>
										<select id="employee_id" class="form-control select2" onchange="return filter_data_table()">
											<option value="x">All</option>
											<?php
												if(!empty($employee)){
													foreach($employee as $row){
														echo '<option value="'.$row->employee_id.'">'.$row->full_name.' - '.$row->employee_id.'</option>';																										
													}
												}
											?>	
										</select>
										
									</div>
								</div>
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
										<th>Transaction ID</th>
                                        <th>Employee ID</th>
										<th>Credit</th>
										<th>Debit</th>
										<th>Balance</th>											
										<th>Date</th>
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
<!----vaiw model-->
	<div class="modal fade" id="view_buied_iteams">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title" style="font-size:23px;">Transaction Item</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="view_buied_iteams_result" style=""></div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<script>


function filter_data_table(){
	if($("#date_range_active").prop("checked") == true) {
		$("#date_range").prop('disabled', false);
		var date_range = $("#date_range").val();
	}else{
		$("#date_range").prop('disabled', true);
		var date_range = '';
	}
	var employee_id = $("#employee_id").val();		
    var condition = '?employee_id='+employee_id+'&date_range='+date_range+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/advance_money_overview_log_datatable.php"+condition;
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
        "ajax": "<?=base_url(); ?>assets/ajax/advance_money_overview_log_datatable.php",
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