<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Leave Widthdraw Request</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item"><a href="#">Aproval</a></li>
						<li class="breadcrumb-item active">Employee Leave Widthdraw Request</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">	
			<div class="row">
				<div class="col-sm-1">
					
				</div>
				<div class="col-sm-10">
					<div class="card card-info">
						<div class="card-header">
							<h4 style="width: 500px; float: left;">Employee Leave Widthdraw Request Logs</h4>
							<div id="export_buttons" style="float:right;"></div>
						</div>
						<div class="card-body">
							<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Department</th>
										<th>Designation</th>
										<th>Date</th>
										<th>Uploader Info</th>
										<th>Status</th>
										<th>OPtion</th>
									</tr>
								</thead>
								<tbody>
<?php
if(!empty($table)){
	foreach($table as $row){
		$empi = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->e_db_id."'");
		$department = $this->Dashboard_model->mysqlii("select * from department where department_id = '".$empi[0]->department."'");
		$designation = $this->Dashboard_model->mysqlii("select * from designation where designation_id = '".$empi[0]->designation."'");
		$email = explode('___',$row->uploader_info);
		$emp = $this->Dashboard_model->mysqlii("select * from employee where email = '".$email[1]."'");
?>								
									<tr>
										<td><?=$row->id; ?></td>
										<td><?=$department[0]->department_name; ?></td>
										<td><?=$designation[0]->designation_name; ?></td>
										<td><?=$row->data; ?></td>
										<td> <?=$emp[0]->full_name; ?> - <?=$emp[0]->employee_id; ?></td>
										<td>
											<?php 
												if($row->approval == 1){
													echo '<button type="button" class="btn btn-success btn-xs">Approved</button>';
												} else if($row->approval == 2){
													echo '<button type="button" class="btn btn-danger btn-xs">Rejected</button>';
												}else{
													echo '<button type="button" class="btn btn-info btn-xs">Pending!</button>';
												}
											?>
										</td>
										<td>
											<form action="<?php echo current_url(); ?>" method="post">
												<input type="hidden" name="hidden_id" value="<?=$row->id; ?>" id="get_id"/>
											<?php if($row->approval == 1 OR $row->approval == 2){ } else{ ?> 
											<button name="accept_data_btn" onclick="return confitm('Are you sure?')" type="submit" class="btn btn-xs btn-success">Approve</button>
											<button name="reject_data" onclick="return confitm('Are you sure?')" type="submit" class="btn btn-xs btn-danger">Reject</button>
											<?php } ?>
											<button onclick="return view_job_responsibility(<?=$row->id; ?>)" type="button" class="btn btn-xs btn-warning"><i class="far fa-eye"></i></button>
											</form>
										</td>
									</tr>
<?php } } ?>									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="job_responsibility_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="create_booking_group" action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-dark" style="background-color:#333;color:#fff;">
					<h4 class="modal-title">Information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" style="color:#fff;">&times;</span> </button>
				</div>
				<div class="modal-body" id="job_responsibility_modal_result"> </div>
			</form>
		</div>
	</div>
</div>

<script>
function view_job_responsibility(id){
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/hrm/view_leave_widthdraw_request.php');?>",  
		method:"POST",  
		data:{view_id:id},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#job_responsibility_modal_result').html(data);
			$('#job_responsibility_modal').modal('show');
			$("#boss_approval_modal").modal('hide');
		}
	}); 
}
$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": false,
        //"ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/leave/employee_performance_approval_datatable.php",
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>