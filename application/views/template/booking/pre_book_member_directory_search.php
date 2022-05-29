<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">PreBook Member Directory Search</h1>
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
							
						</div>	
						<span id="data_send_success_message"></span>
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">PreBook Member Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body" style="height: 700px;">
									<div class="row m-5 p-2">
										<div class="col-md-4 offset-md-4">
											<div class="input-group">
											  <input type="text" id='search' name="search" class="form-control form-control-lg " placeholder="( NID/E-MAIL ADDRESS/PHONE NUMBER )" aria-describedby="basic-addon2">
											  <div class="input-group-append">
												<span class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></span>
											  </div>
											</div>
										</div>
									</div>
									
									<table id="prebooking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										
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


<!---- Member Branch update flash message. -->
	<div class="modal fade" id="branch_update_message">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header btn-success">
					<h4 class="modal-title">Message</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">	
					<span class="text-success">Action Updated Successfully !</span>					
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
					
				</div>
			</div>
		</div>
	</div>
<!---- Member Branch update flash message. End -->

<script>


	$(document).on("keyup", "#search", function(){
		var search = $("#search").val();
		if(search != ''){
			$.ajax({
				url: "<?php echo base_url('admin/pre-book-member-directory-search-ajax');?>",
				method: "POST",
				dataType: "html",
				data: {search: search},
				success: function(data){
					$("#prebooking_data_table").empty();
					$("#prebooking_data_table").append(data);
				}
				
			});
		}else{
			$("#prebooking_data_table").empty();
		}
		
		
	});
	
	$(document).on("change", "#branch", function(){
		
		var branch = $("#branch").val();
		var update_id = $("#branch").data("update_id");
		
		if(branch != '' && update_id != ''){
			$.ajax({
				url: "<?php echo base_url('admin/pre-book-member-directory-change-branch');?>",
				method: "POST",
				dataType: "html",
				data: {branch: branch, update_id: update_id},
				success: function(data){
					if(data==1){
						$("#branch_update_message").modal('show');
					}else{
						
					}
					
				}
				
			});
		}else{
			//$("#prebooking_data_table").empty();
		}
	});


function view_pre_book_infformation(id){
	
	var profile_id = parseInt(id);
	
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


$('#reupload_member_image_form').on('submit', () => {
	event.preventDefault();
	console.log("submited");
	var form = $('#reupload_member_image_form')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?=base_url('admin/pre-book/member-image-reupload');?>",  
		dataType: "html",
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			var base_url = "<?php echo base_url(); ?>";
			$('#photo_avater').attr("src", base_url+data);
			$('#data-loading').html('');
			$('#member_image_modal').modal('toggle');
			$('#branch_update_message').modal('show');							
		}
	});		
})

function  reupload_member_image(id, name){
	
	$('#update_member_name').html(name);
	$('#update_member').val(id);
	$('#member_image_modal').modal('toggle');
}

</script>