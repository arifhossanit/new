<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Exit Employees </h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Exit Employees </li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">	
					<div class="button-group">
						<a href="<?=base_url('admin/employ-directory'); ?>" class="btn btn-success" style="float:right;"><i class="fas fa-user-tie"></i> &nbsp;Employees </a>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12" style="padding-top:20px;">
				
					<div class="card card-danger">
						<div class="card-header">
							<h3 class="card-title">Exit Employees </h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<style>.employee .form-group{margin-right:10px;}</style>
						<div class="card-body" style="overflow-x:scroll;">						
							<style>#employee_data_table td{text-align:center;vertical-align: middle;}#employee_data_table th{text-align:center;vertical-align: middle;}</style>
							<table id="employee_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
							   <thead>
								  <tr>
									 <th>Image</th>
									 <th>ID</th>
									 <th>Name</th>
									 <th>Designation</th>
									 <th>Department</th>
									 <th>Role</th>
									 <th>Email</th>
									 <th>Phone</th>									 
									 <th>Joining date</th>
									 <th>Duration</th>
									 <th># <i class="fas fa-sign-in-alt"></i></th>
									 <th>Release Date</th>
									 <th>Reason</th>
									 <th>Release Type</th>
									 <th>Last Working Date</th>
									 <th>Card Number</th>
									 <th>Option</th>
								  </tr>
							   </thead>
							   <tbody>
<?php
error_reporting(0);
function duration($d,$b){
	$a = explode('/',$d);			
	$b = explode('/',$b);			
	$date1 = $a[2].'-'.$a[1].'-'.$a[0];
	$date2 = $b[2].'-'.$b[1].'-'.$b[0]; 
	$diff = abs(strtotime($date2) - strtotime($date1));
	$years   = floor($diff / (365*60*60*24)); 
	$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
	$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	return $years.' Years '.$months.' Months '.$days.' Days';
}
function status($d,$id){
	if($d == '1'){
		return '
			<form action="'.current_url().'" method="post">
				<input type="hidden" name="hidden_id" value="'.$id.'"/>
				<button class="btn btn-xs btn-danger" name="status_off" type="submit" style="width:150px;font-weight:bolder;">Deactive</button>
			</form>
		';
	}else{
		return '
			<form action="'.current_url().'" method="post">
				<input type="hidden" name="hidden_id" value="'.$id.'"/>
				<button class="btn btn-xs btn-success" name="status_on" type="submit" style="width:150px;font-weight:bolder;">Active</button>
			</form>
		';
	}
}
if(!empty($table)){
// 	foreach($table as $d){	
// 		if($d->status == '1'){
// 			$style = 'style="background-color:#fff;color:#000;"';
// 		}else{
// 			$style = 'style="background-color:#ffbfbf;color:#dc3545;font-weight: bold;"';
// 		}
// 	echo '
// 								<tr>
// 									<td>
// 										<center><img src="'.base_url($d->photo).'" style="height:52px;width:50px;" /></center>
// 									</td>
// 									<td>'.$d->employee_id.'</td>
// 									<td>'.$d->full_name.'</td>
// 									<td>'.$d->designation_name.'</td>
// 									<td>'.$d->department_name.'</td>
// 									<td>'.$d->role_name.'</td>
// 									<td>'.$d->email.'</td>
// 									<td>'.$d->personal_Phone.'</td>
// 									<td>'.$d->date_of_joining.'</td>
// 									<td>'.duration($d->date_of_joining,$d->data).'</td>
// 									<td>'.status($d->status,$d->id).'</td>
// 									<td>'.$d->data.'</td>
// 									<td>'.$d->extra_note.'</td>
// 									<td>
// 										<form action="'.base_url().'admin/edit-employee" method="post">
// 											<input type="hidden" name="hidden_id" value="'.$d->id.'"/>
// 											<button onclick="return view_profile('.$d->id.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>';
// 										if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
// 											echo '<button type="submit" name="edit" class="btn btn-xs btn-success"><i class="fas fa-edit"></i></button>';
// 										}											
// 										if(check_permission('role_1604921365_99')){	
// 											echo '<button type="submit" name="delete" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>';
// 										}
// 										echo '</form>
// 									</td>
// 								</tr>
//  '; } 
 } ?>								
							   </tbody>

							</table>
					
						</div>
					</div>
					
				
				</div>
			</div>			
			
			
		</div>
	</div>
</div>
<!----role add model-->
					<div class="modal fade" id="add-role">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="<?=current_url(); ?>" method="post">
									<div class="modal-header btn-primary">
										<h4 class="modal-title">Add Role</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Write Role name</label>
											<input type="text" name="role_name" class="form-control" required />
										</div>
									</div>
									<div class="modal-footer justify-content-between">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" name="add_role" class="btn btn-primary">Add Role</button>
									</div>
								</form>
							</div>
						</div>
					</div>
<!----End role add model-->

<!----Designation model-->
					<div class="modal fade" id="add-designation">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="<?=current_url(); ?>" method="post">
									<div class="modal-header btn-warning">
										<h4 class="modal-title">Add Designation</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Write Designation name</label>
											<input type="text" name="designation_name" class="form-control" required />
										</div>
									</div>
									<div class="modal-footer justify-content-between">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" name="add_designation" class="btn btn-warning">Add Designation</button>
									</div>
								</form>
							</div>
						</div>
					</div>
<!----End Designation model-->

<!----Department model-->
					<div class="modal fade" id="add-department">
						<div class="modal-dialog">
							<div class="modal-content">
								<form action="<?=current_url(); ?>" method="post">
									<div class="modal-header btn-success">
										<h4 class="modal-title">Add Department</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Write Department name</label>
											<input type="text" name="department_name" class="form-control" required />
										</div>
									</div>
									<div class="modal-footer justify-content-between">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										<button type="submit" name="add_department" class="btn btn-success">Add Department</button>
									</div>
								</form>
							</div>
						</div>
					</div>
<!----End Department model-->
<div class="modal fade" id="view_model_details">
	<div class="modal-dialog modal-xl" style="max-width: 1650px;">
		<div class="modal-content">
			<div class="modal-header btn-info">
				<h4 class="modal-title">Employ information</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="view_details">

			</div>							
		</div>
	</div>
</div>
	
<!--
<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
	<center>
		<img src="<?=base_url('assets/img/loading.gif');?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/>
	</center>
</div>-->


<script>
function view_profile(id){
	var profile_id = id; 
	if(profile_id != ''){	
		$.ajax({  
			url:"<?=base_url('assets/ajax/employee_single_view.php');?>",  
			method:"POST",  
			data:{view_id:profile_id},
			beforeSend:function(){					
				$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
			},
			success:function(data){	
				$('#view_details').html(data);    
				$('#view_model_details').modal('show');
				$('#data-loading').html('');
			}  
		});  
	}		
}	
$(document).ready(function() {
    var table = $('#employee_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": false,
		//"order": [[ 1, "asc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/exit_employee_directory_datatable.php",
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
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
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table.buttons().container().appendTo($('#export_buttons'));
});
</script>
