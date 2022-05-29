<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Occupide Target Setup</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Occupide Target Setup</li>
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
						<div class="col-sm-3">
							<div class="row">
								<div class="col-sm-12">
									<div class="card card-success">
										<div class="card-header">
											<h4>Occupide Target Setup</h4>
										</div>
										<div class="card-body">
											<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
												<div class="form-group">
													<?php
														$get_branch = $this->Dashboard_model->mysqlii("select * from branches where status = '1'");
														if(!empty($get_branch)){
															foreach($get_branch as $row){
																if($row->id == '1'){}else{
																	$get_employee = $this->Dashboard_model->mysqlii("select * from employee where status = '1' and branch = '".$row->branch_id."' and role = '1892907820998244323' order by id desc limit 01");
																	if(!empty($get_employee[0]->id)){
													?>
													<label><?php echo $row->branch_name.' - ( '.$get_employee[0]->full_name.' | '.$get_employee[0]->employee_id.' )'; ?></label>
													<input type="hidden" name="branch_id[]" value="<?php echo $row->branch_id; ?>"/>
													<input type="text" name="booking_target[]" class="number_int form-control" autocomplete="off" placeholder="Occupide Target" required />
													<?php
																	}
																}
															}
														}
													?>
													</div>												
												<div class="form-group">
													<label>Select Month</label>
													<input type="month" name="target_month" class="form-control" value="<?php echo date('Y-m'); ?>" autocomplete="off" placeholder="Target_month" required />
												</div>
												<div class="form-group">
													<label>Note</label>
													<textarea name="note" placeholder="Note" class="form-control"></textarea>
												</div>
												<div class="form-group">
													<button name="set_target" class="btn btn-success" style="float:right;">Set Target</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-12">
									<div class="card card-info">
										<div class="card-header">
											<h4>
												Occupide Target Logs
												<div id="export_buttons" style="float: right;"></div>
											</h4>											
										</div>
										<div class="card-body">
											<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
											<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
												<thead>
													<tr>
														<th>Id</th>
														<th>Target id</th>
														<th>Target month</th>
														<th>Adding Date</th>
														<th>Adding By</th>
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
	</div>
</div>
<!----Careate Group-->
	<div class="modal fade" id="view_target_details_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="create_booking_group" action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Target Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="view_target_details_modal_result"></div>
				</form>
			</div>
		</div>
	</div>
<!----End Careate Group-->
<script>
function vire_branch_target_info(id){
	if(id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/receipt/view_target_details_information.php');?>",  
			method:"POST",  
			data:{target_id:id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$('#view_target_details_modal_result').html(data); 
				$('#view_target_details_modal').modal('show');   
			}  
		});
	}
}
$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/booking_occupency_target_datatable.php",
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            }, {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            }, {
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]

    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>