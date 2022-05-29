<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">PreBook & Police Varification Member Directory</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">PreBook Member Directory</li>
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
						<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-2">
								<div class="form-group" style="margin:0px;">
									<select onchange="return filter_data_table();" class="form-control select2" id="branch_id">
										<?php if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
										<option value="1">All Branches</option>
										<?php 
										}
										if(!empty($banches)){
											foreach($banches as $row){
												echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
											}
										}													
										?>
									</select>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-prepend">
										<span class="input-group-text">
											<i class="far fa-calendar-alt"></i>
										</span>
										</div>
										<input onchange="return filter_data_table()" id="date_range" type="text" class="form-control float-right date_range_default">
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group" style="margin:0px;">
									<select onchange="return filter_data_table();" class="form-control select2" id="booking">
										<option value="X">--select--</option>
										<option value="0">Booked</option>
										<option value="1">Not Booked</option>
									</select>
								</div>
							</div>
						</div>	
						<span id="data_send_success_message"></span>
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">PreBook Member Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#prebooking_data_table td{text-align:center;vertical-align: middle;}#prebooking_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="prebooking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>id</th>
												<th>Image</th>
												<th>Branch_Name</th>
												<th>Name</th>												
												<th>Phone Number</th>
												<th>Email</th>
												<th>NID</th>
												<th>Occupation</th>
												<th>Aaddress</th>
												<th>Submited_Date</th>
												<th><abbr title="How To Find Us">HTFU</abbr></th>
												<th>Option</th>
												<th>phone</th>
												<th>email</th>
												<th>nid</th>
											</tr>
										</thead>
										<tbody>	
										</tbody>
										<!--
										<tfoot>
											<th>id</th>
												<th>Image</th>
												<th>Branch_Name</th>
												<th>Name</th>												
												<th>Phone Number</th>
												<th>Email</th>
												<th>NID</th>
												<th>Occupation</th>
												<th>Aaddress</th>
												<th>Submited_Date</th>
												<th>HTFU</th>
												<th>Option</th>
												<th>phone</th>
												<th>email</th>
												<th>nid</th>
										</tfoot>
										-->
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
<!----vaiw prebook_information_model-->
	<div class="modal fade" id="prebook_information_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-dark">
						<h4 class="modal-title">PreBook Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="prebook_result" style="max-height:780px;overflow-y:scroll;">	

						
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
<!----End vaiw prebook_information_model-->


<!----vaiw print_police_verification_form-->
	<div class="modal fade" id="print_police_verification_form">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-success">
						<h4 class="modal-title">Print Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="print_prebook_result" style="">						
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw print_police_verification_form-->

<!---- Reupload Member Image -->
	<div class="modal fade" id="member_image_modal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<form action="" method="post" id="reupload_member_image_form">
					<!-- <div class="modal-header btn-success">
						<h4 class="modal-title">Print Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div> -->
					<div class="modal-body">	
						<div class="form-group">
							<input type="hidden" id="update_member" name="update_member">
							<label for="member_image">Reuplaod Member Image of <span style="font-style: italic;" id="update_member_name"></span></label>
							<input type="file" class="form-control-file" id="member_image" name="member_image">
						</div>					
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!---- End -->


<script>
//edit_ontable
function showEdit(editableObj) {
	$(editableObj).css("background", "#FFF");
}
function saveToDatabase(editableObj, column, id) {
	$(editableObj).css("background", "#FFF url(<?php echo base_url(); ?>assets/img/loaderIcon.gif) no-repeat center right 5px");
	$.ajax({
		url: '<?php echo base_url(); ?>assets/ajax/data_table/data_table_edit/pre_booking_member_directory_edit.php',
		type : "POST",
		data : 'column=' + column + '&editval=' + editableObj.innerHTML + '&id=' + id,
		success : function(data) {
			if(data != ''){
				if(data == 1){
					$(editableObj).css("background", "#dff3df");
				}else{
					$(editableObj).css("background", "#ffeaea");
				}
			}else{
				$(editableObj).css("background", "#ffeaea");
			}
			
		}
	});
}
//edit_ontable


function update_branch_from_prebook(id){
	var update_branch_id = $('#branch_id_'+id+'').val();
	var update_id = id;
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/prebook_branch_update_from_dropdown.php');?>",  
		method:"POST",  
		data:{
			update_id:update_id,
			branch_id:update_branch_id
		},
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




var branch_id = "<?php echo base64_encode($_SESSION['super_admin']['branch']); ?>";
function print_police_verification_form(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/prebook_police_verification_form_print.php');?>",  
			method:"POST",  
			data:{print_id:profile_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#print_prebook_result').html(data); 
				$('#print_police_verification_form').modal('show');
			}  
		});  
	}
}
function view_pre_book_infformation(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/member_profile_information.php');?>",  
			method:"POST",  
			data:{book_id:profile_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#prebook_result').html(data); 
				$('#prebook_information_model').modal('show');   
			}  
		});  
	}
}
function filter_data_table(){
	var branch_id = $("#branch_id").val();
	var date_range = $("#date_range").val();	
	var booking = $("#booking").val();	
    var condition = '?branch_id='+branch_id+'&date_range='+date_range+'&booking='+booking+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/prebooking_member_directiry_datatable.php"+condition;
	$('#prebooking_data_table').DataTable().ajax.url(ajax_data4).load();
}

$('#reupload_member_image_form').on('submit', () => {
	event.preventDefault();
	var form = $('#reupload_member_image_form')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?=base_url('admin/pre-book/member-image-reupload');?>",  
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			$('#member_image_modal').modal('toggle');
			$('#prebooking_data_table').DataTable().ajax.reload( null , false);							
		}
	});		
})

let reupload_member_image = (id, name) => {
	$('#update_member_name').html(name)
	$('#update_member').val(id)
	$('#member_image_modal').modal('toggle');
}

$(document).ready(function() {
    var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
	var table = $('#prebooking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, -1], 
			[25, 50, 100, 500, 1000, 1500, 2000, 3000, 5000, "All Data"] 
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/prebooking_member_directiry_datatable.php"+table_info,
		columnDefs: [
			{ targets: [ 12, 13, 14, 15 ], visible: false},
		],
		initComplete: function(){
            var api = this.api();
            api.columns().every(function(){
                var that = this;
                $('input', this.footer()).on('keyup change', function(){
                    if (that.search() !== this.value){
                        that.search(this.value).draw();
                    }
                });
            });
        },
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
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table.buttons().container().appendTo($('#export_buttons'));
	$('#prebooking_data_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
    });
})
</script>