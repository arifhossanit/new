<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Recruitment Approval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item"><a href="#">Aproval</a></li>
						<li class="breadcrumb-item active">Employee Recruitment Approval</li>
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
							<h4 style="width: 400px; float: left;">Recruitment Aproval Logs</h4>
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
										<th>NO: of People</th>
										<th>Exixting People</th>
										<th>Required Date</th>
										<th>Uploader Info</th>
										<th>Status</th>
										<th>OPtion</th>
									</tr>
								</thead>
								<tbody>
<?php
if(!empty($table)){
	foreach($table as $row){
		$department = $this->Dashboard_model->mysqlii("select * from department where department_id = '".$row->department."'");
		$designation = $this->Dashboard_model->mysqlii("select * from designation where designation_id = '".$row->designation."'");
		$email = explode('___',$row->uploader_info);
		$emp = $this->Dashboard_model->mysqlii("select * from employee where email = '".$email[1]."'");
?>								
									<tr>
										<td><?=$row->id; ?></td>
										<td><?=$department[0]->department_name; ?></td>
										<td><?=$designation[0]->designation_name; ?></td>
										<td><?=$row->number_of_people; ?></td>
										<td><?=$row->exixting_people; ?></td>
										<td><?=$row->required_date; ?></td>
										<td> <?=$emp[0]->full_name; ?> - <?=$emp[0]->employee_id; ?></td>
										<td>
											<?php 
												if($row->boss_aproval == 1){
													echo '<button type="button" class="btn btn-success btn-xs">Approved</button>';
												} else if($row->boss_aproval == 2){
													echo '<button type="button" class="btn btn-danger btn-xs">Rejected</button>';
												}else{
													echo '<button type="button" class="btn btn-info btn-xs">Pending!</button>';
												}
											?>
										</td>
										<td>
											<form action="<?php echo current_url(); ?>" method="post">
												<input type="hidden" name="hidden_id" value="<?=$row->id; ?>" id="get_id"/>
											<?php if($row->boss_aproval == 1 OR $row->boss_aproval == 2){ } else{ ?> 
											<button name="accept_data_btn" id="<?=$row->number_of_people; ?>" type="button" class="btn btn-xs btn-success">Approve</button>
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
					<h4 class="modal-title">Job Responsibility</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" style="color:#fff;">&times;</span> </button>
				</div>
				<div class="modal-body" id="job_responsibility_modal_result"> </div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="boss_approval_modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form id="create_booking_group" action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-dark" style="background-color:#333;color:#fff;">
					<h4 class="modal-title">Approval form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" style="color:#fff;">&times;</span> </button>
				</div>
				<div class="modal-body" id="boss_approval_modal_result">
					<input type="hidden" name="hidden_id" value="" id="approved_id"/>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Number of People</label>
								<input type="number" name="number_of_people" id="number_of_people" min="1" class="form-control" placeholder="Number of People" autocomplete="off" required />
							</div>
							<div class="form-group">
								<label>Note</label>
								<textarea name="note" placeholder="Note/ Remarks" class="form-control" required ></textarea>
							</div>
							<div class="form-group">
								<button type="submit" name="accept_data" class="btn btn-success" style="float:right;">Approved</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
function view_job_responsibility(id){
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/hrm/view_job_responsibility.php');?>",  
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
	$('button[name="accept_data_btn"]').on("click",function(){
		var numofp = $(this).attr('id');
		var id = $('#get_id').val();		
		$('#approved_id').val(id);
		$('#number_of_people').val(numofp);
		$("#boss_approval_modal").modal('show');
		$('#job_responsibility_modal').modal('hide');
	})
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