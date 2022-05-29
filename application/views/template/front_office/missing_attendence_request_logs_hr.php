<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Attendance Adjustment Checked By HR</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Profile</a></li>
						<li class="breadcrumb-item active">Attendance Adjustment Checked By HR</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container-fluid">
		<div class="row">			
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Attendance Adjustment Checked By HR</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="employee_id" value="<?php echo $_SESSION['super_admin']['employee_id']; ?>"/>
							<div class="row">								
								<div class="col-sm-12">
									
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12" style="padding-top:20px;padding-bottom:10px;">
									<div id="export_buttons_due"></div>
								</div>
								<div class="col-sm-12">
									<style>#due_data_table td{text-align:center;vertical-align: middle;}#due_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="candidate_list" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
										<thead>
											<tr>
												<th>ID</th>
												<th>Number Of Days</th>
												<th>HR Checked</th>
												<th>Boss:Aproval</th>
												<th>Note</th>
												<th>Department</th>
												<th>Designation</th>
												<th>Image</th>
												<th>Uploader</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										
										</tbody>
									</table>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="missing_attendance_info_model">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">	
			<div class="modal-header btn-warning">
				<h4 class="modal-title">Missing Attendance info</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>
			<div class="modal-body" id="missing_attendance_info_result"> </div>
		</div>
	</div>
</div>
<script>
function checked_by_hrm_hr(id, unique_id){
	var note = $('#text_note_'+id+'').val();
	if(note != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/employee_missing_attendance_info_hrm.php');?>",  
			method:"POST",  
			data:{ accept_checked_id:id, note: note},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				alert(data);
				if(unique_id != ''){
					$.ajax({  
						url:"<?=base_url('assets/ajax/form_model/employee_missing_attendance_info_hrm.php');?>",  
						method:"POST",  
						data:{ unique_id:unique_id },
						beforeSend:function(){					
							$('#data-loading').html(data_loading);					 
						},
						success:function(data){	
							$('#data-loading').html('');
							$('#missing_attendance_info_result').html(data); 
							$('#candidate_list').DataTable().ajax.reload( null , false);
						}
					});
				} 			
			}
		});	
	}else{
		alert('Note Is Required');
		note.focus();
	}
}

function reject_by_hrm_hr(id, unique_id){
	var note = $('#text_note_'+id+'').val();
	if(note != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/employee_missing_attendance_info_hrm.php');?>",  
			method:"POST",  
			data:{ reject_checked_id:id, note: note},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				alert(data);
				if(unique_id != ''){
					$.ajax({  
						url:"<?=base_url('assets/ajax/form_model/employee_missing_attendance_info_hrm.php');?>",  
						method:"POST",  
						data:{ unique_id:unique_id },
						beforeSend:function(){					
							$('#data-loading').html(data_loading);					 
						},
						success:function(data){	
							$('#data-loading').html('');
							$('#missing_attendance_info_result').html(data); 
							$('#candidate_list').DataTable().ajax.reload( null , false);
						}
					});
				} 			
			}
		});	
	}else{
		alert('Note Is Required');
		note.focus();
	}
}


function view_dates_data(unique_id){
	if(unique_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/employee_missing_attendance_info_hrm.php');?>",  
			method:"POST",  
			data:{ unique_id:unique_id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#missing_attendance_info_result').html(data); 
				$('#missing_attendance_info_model').modal('show'); 			
			}
		});
	}
}
$('document').ready(function(){
	
	
	var employee_id = <?php echo $_SESSION['super_admin']['employee_ids']; ?>;
	var condition = '?employee_id='+employee_id;
	var table = $('#candidate_list').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500],
			[25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"scrollX": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
		"ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_missing_attendance_request_htm.php"+condition,
		dom: 'lBfrtip',
		"columnDefs": [
			{ "width": "20%", "targets": 4 }
		],
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
	table.buttons().container().appendTo($('#export_buttons_due'));
})
</script>