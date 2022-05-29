
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Roles</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Manage Roles</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
<?php
if(!empty($edit)){
	$button = '
		<button type="submit" name="update" class="btn btn-warning">Update</button>
		<a href="'.current_url().'" class="btn btn-danger">Close</a>
	';
}else{
	$button = '<button type="submit" name="save" class="btn btn-primary">Save</button>';
}
?>	
	<div class="content">
		<div class="container-flud">
			<div class="row">
				<?php if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
				<div class="col-sm-12">
					<span id="pertmission_result" style=""></span>
					<button onclick="return add_permission_field()" class="btn btn-danger btn-sm" style="float:right;margin-bottom:15px;"><i class="fas fa-user-lock"></i>&nbsp;&nbsp; Add Permission Field</button>
				</div>
				<?php } ?>
				<div class="col-sm-4">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Input Roles information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="form-group">
									<label>Role Title</label>
									<input name="role_name" value="<?php if(!empty($edit)){ echo $edit->role_name; } ?>" type="text" class="form-control" placeholder="Role Title" required>
								</div>
								<div class="form-group">
									<label>Service Enable/Disable</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control" placeholder="Note"><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
								</div>

							</div>
							<div class="card-footer">
								<?php echo $button; ?>
							</div>
						</form>
					</div>
				</div>				
				
				<div class="col-sm-8">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Branch List</h3>
						</div>
						<div class="card-body">
							<table class="table table-sm" id="example2">
								<thead>
									<tr>
										<th></th>
										<th>ID</th>
										<th>Roles</th>
										<th>Note</th>
										<th>Entry Date</th>
										<th>Status</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody>
<?php 
if(!empty($table)){
	foreach($table as $row){
		
?>								
									<tr>
										<td><input type="checkbox" value="<?=$row->id;?>" /></td>
										<td><?=$row->id; ?></td>
										<td><?=$row->role_name; ?></td>
										<td><?=$row->note; ?></td>
										<td><?=$row->data; ?></td>
										<td>
											<?php if($row->status == '1'){ ?>
												<button class="btn btn-xs btn-success">Active</button>
											<?php }else{ ?>
												<button class="btn btn-xs btn-danger">Deactive</button>
											<?php } ?>
										</td>
										<td>
											<?php if($row->id != '1'){ ?>
											<form action="<?=current_url(); ?>" method="post">
												<input type="hidden" value="<?=$row->id;?>" name="hidden_id"/>
												<button name="edit" type="submit" class="btn btn-xs btn-success">Edit</button>
												<button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-xs btn-danger">Delete</button>
												<?php if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){ ?>
												<button type="button" onclick="return set_permission_modal('<?=$row->id;?>')" class="btn btn-xs btn-info"><i class="fas fa-user-lock"></i> Set Permission</button>
												<?php } ?>
											</form>
											<?php } ?>
										</td>
									</tr>
<?php } }  ?>									
								</tbody>
							</table>
							<div align="left" style="margin-bottom:10px;">
								<button type="button" id="select" class="btn btn-xs btn-warning" style="margin-left:15px;"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
								<button type="button" id="unselect" class="btn btn-xs btn-success"><i class="fa fa-bars" aria-hidden="true"></i></button>
								<button type="button" id="btn_delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
							</div>
						</div>					
					</div>
				</div>
	

			</div>
		</div>
	</div>
</div>
<!----vaiw permission adding model-->
	<div class="modal fade" id="permission_adding_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="fields_name_submit" action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-danger">
						<h4 class="modal-title"><i class="fas fa-user-lock"></i>&nbsp;&nbsp; Permission Fields Management</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="max-height:780px;overflow-y:scroll;">	
						<div class="row">
							<div class="col-sm-4">
								<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
									<button type="button" id='removeButton' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
									<button type="button" id='addButton' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
								</div>
								<div class="form-group" id='UnitBoxesGroup'>
									<label>Input Field Name</label>
									<input type="hidden" name="form_submit" value="1"/>
									<div id="UnitBoxDiv1" class="row" style="width:100%;">
										<input type="text" name="field_name[]" id="field_name1" class="form-control" placeholder="Field Name #1" autocomplete="off" required style="margin-bottom:6px;"/>
									</div>
								</div>									
								<div class="form-group">
									<button type="submit" id="add_field" class="btn btn-sm btn-success">Add</button>
								</div>
							</div>
							<div class="col-sm-8">
								<div class="row">
									<div class="col-sm-12">
										<table class="table table-sm table-bordered" style="width:100%;">
											<thead>
												<tr>
													<th>SL:NO</th>
													<th>Field Name</th>
													<th>Field Code</th>
													<th>Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody id="new_result_fields">
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>							
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End permission adding model-->

<!----vaiw set permission model-->
	<div class="modal fade" id="set_permission_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="set_permission_form" action="<?=current_url(); ?>" method="post">
					<input type="hidden" name="value_set_permission" value="1"/>
					<div class="modal-header btn-info">
						<h4 class="modal-title"><i class="fas fa-user-lock"></i>&nbsp;&nbsp; SET Permission</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="set_permission_result" style="max-height:780px;overflow-y:scroll;">	
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close </button>
						<button type="submit" name="save_permission" id="save_permission" class="btn btn-success"><i class="fas fa-key"></i>&nbsp;&nbsp; Save Permission</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End set permission model-->
<script>
function set_permission_modal(id){
	if(id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/checked_permission_fields.php');?>",  
			method:"POST",  
			data:{role_id:id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');
				$("#set_permission_result").html(data);
				$("#set_permission_model").modal('show');
			}
		});
	}
}






function delete_items_field(id){
	if(confirm('Are you sure you want to Remove this thing ('+id+') from the database?')){
		if(id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/form_submit/add_permission_fields.php');?>",  
				method:"POST",  
				data:{field_name_delete:id},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);
				},
				success:function(data){	
					$('#data-loading').html('');
					$("#new_result_fields").html(data);
				}
			});
		}
	}
	
}
$('document').ready(function(){
	$("#set_permission_form").on("submit",function(){
		event.preventDefault();
		var form = $('#set_permission_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_model/checked_permission_fields.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#save_permission").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$("#save_permission").prop("disabled", false);
				$("#pertmission_result").html(data);
				$("#set_permission_model").modal('hide');
			}
		});
		return false;
	})
	
	
	$("#fields_name_submit").on("submit",function(){
		event.preventDefault();
		var form = $('#fields_name_submit')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/add_permission_fields.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#add_field").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$("#add_field").prop("disabled", false);
				$("#fields_name_submit").trigger("reset");
				$("#new_result_fields").html(data);				
			}
		});
		return false;
	})
})


function add_permission_field(){
	var form_submit = '2';
	if(form_submit != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_submit/add_permission_fields.php');?>",  
			method:"POST",  
			data:{form_submit:form_submit},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');
				$("#new_result_fields").html(data);
				$("#permission_adding_model").modal('show');
			}
		});
	}
}	
$(document).ready(function(){	
	var counter = 2;
    $("#addButton").click(function () {
		if( counter == 11 ){
			alert("Sorry! For 1 time Submit Maximum number of field reached");
			return false;			
		}		
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv1' + counter ,
			class: 'row',
			style: 'width:100%'
		});
		var data = '<input type="text" name="field_name[]" id="field_name'+counter+'" class="form-control" placeholder="Field Name #'+counter+'" autocomplete="off" required style="margin-bottom:6px;"/>';
		newTextBoxDiv.after().html(data);
		newTextBoxDiv.appendTo("#UnitBoxesGroup");
		counter++;
    });
    $("#removeButton").click(function () {
		if( counter == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter--;
        $("#UnitBoxDiv1" + counter).remove();
    });

	$("#select").click(function(){
		$('input:checkbox').prop('checked',true);     
	});
	$("#unselect").click(function(){
		$('input:checkbox').prop('checked',false);     
	});
	$('#btn_delete').click(function(){  
		if(confirm("Are you sure you want to delete selected Iteam?")){
			var id = [];   
			$(':checkbox:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					 url:'<?= current_url(); ?>',
					 method:'POST',
					 data:{delete_id:id},
					 success:function() {
						window.open('<?= current_url(); ?>','_self');
					}     
				});
			}   
		} else {
			return false;
		}
	}); 
});
</script>