<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Group Member Directory</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">CRM</a></li>
              <li class="breadcrumb-item active">Group Member Directory</li>
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
						<div class="col-sm-2" style="margin-bottom:15px;">
							<div class="form-group" style="margin:0px;">
								<select onchange="return booking_report_table();" class="form-control select2" id="branch_id_hrad">
									<?php
									if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
										echo '<option value="1">All Branches</option>';
									}									
									if(!empty($banches)){
										foreach($banches as $row){
											echo '<option value="'.rahat_encode($row->branch_id).'">'.$row->branch_name.'</option>';
										}
									}													
									?>
								</select>
							</div>
						</div>
						<div class="col-sm-12">
							<span id="data_send_success_message"></span>
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">Member Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>id</th>
												<th>Image</th>
												<th>Branch</th>
												<th>Card No</th>
												<th>Name</th>												
												<th>Phone Number</th>
												<th>Group ID</th>
												<th>Bed</th>
												<th>CheckIN</th>
												<th>CheckOut</th>
												<th>P:Category</th>
												<th>Package</th>
												<th>S:Deposit</th>
												<th style="width:170px;">Option</th>
											</tr>
										</thead>
										<tbody>	
										</tbody>
										<tfoot>
											<tr>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>												
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th style="width:170px;"></th>
											</tr>
										</tfoot>
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




<!----vaiw member profile model-->
	<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Member Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">	

						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="button" id="select_bed" class="btn btn-warning"><i class="fas fa-save"></i> Select</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw member profile model-->


<!----vaiw model-->
	<div class="modal fade" id="member_rental_information">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Rental information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result_rental">	
					
					</div>

				</form>
			</div>
		</div>
	</div>
<!----End vaiw model-->
<!----vaiw Group Members-->
	<div class="modal fade" id="view_group_members_modal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Group Members <span style="color:#f00;" id="group_id"></span></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="view_group_members_result">					
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw Group Members-->
<script>
var uploader_info = "<?php echo base64_encode($_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']); ?>";
function view_group_members(group_id){
	if(group_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/view_group_members_information.php');?>",  
			method:"POST",  
			data:{group_id:group_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#group_id').html(group_id); 
				$('#view_group_members_result').html(data); 
				$('#view_group_members_modal').modal('show');   
			}  
		});  
	}
}
function view_member_profile2(id){
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
				$('#members_result').html(data); 				   
				$('#view_group_members_modal').modal('hide');
				$('#member_prifile_model').modal('show');				
			}  
		});  
	}
}
function view_rental_recipt(id){
	var rent_id = id;
	if(rent_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/rental_details_information.php');?>",  
			method:"POST",  
			data:{rent_id:rent_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result_rental').html(data); 
				$('#member_rental_information').modal('show');   
			}  
		});  
	}
}	
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
				$('#members_result').html(data); 
				$('#member_prifile_model').modal('show');   
			}  
		});  
	}
}
//==================================================================

function booking_report_table(){
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
    var condition_2 = '?branch_id='+branch_sele_id;	
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/group_member_directiry_datatable.php"+condition_2;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
}



$(document).ready(function() {
	if($("#branch_id_hrad").val() != ''){
		var branch_sele_id = $("#branch_id_hrad").val();
	}else{
		var branch_sele_id = "<?php echo rahat_encode($_SESSION['super_admin']['branch']); ?>";
	}
	var table_info = '?branch_id='+branch_sele_id;
    var condition = table_info;	
    var table = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, -1],
			[10, 25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, "All Data"]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/group_member_directiry_datatable.php"+condition,
		initComplete: function() {
            var api = this.api();
 
            // Apply the search
            api.columns().every(function() {
                var that = this;
 
                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        },
		<?php if(check_permission('role_1606371206_64')){ ?>
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
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            }
        ]
		<?php } ?>
    });
	table.buttons().container().appendTo($('#export_buttons'));

	/*$('#booking_data_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });*/
})
</script>