<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Floors</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Manage Floors</li>
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
				<div class="col-sm-4">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Input Floors information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="form-group">
									<?php if($_SESSION['super_admin']['user_type'] == 'admin' ){ ?>
									<label>Branch name</label>
									<input type="text" name="branch_id" value="<?php echo $_SESSION['super_admin']['branch']; ?>" readonly />
									<?php }else{ ?>
									<label>Select Branch</label>
									<select name="branch_id" class="form-control select2" required>
										<option value="">--choose one--</option>
										<?php
											if(!empty($banches)){
												foreach($banches as $row){
													if(!empty($edit) AND $edit->branch_id == $row->branch_id){
														$selected = 'selected';
													}else{
														$selected = '';
													}
													echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
												}
											}
										?>				
									</select>
									<?php } ?>
								</div>
								<div class="form-group">
									<label>Floor Name</label>
									<input name="floor_name" value="<?php if(!empty($edit)){ echo $edit->floor_name; } ?>" type="text" class="form-control" placeholder="Floor Name" required>
								</div>
								<input type="hidden" name="floor_type" value=""/>
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control" placeholder="Note"><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
								</div>
								<div class="form-group">
									<label>Floor Enable/Disable</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
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
							<h3 class="card-title">Branch & Floor List</h3>
						</div>
						<div class="card-body" style="max-height:720px;overflow-y:scroll;">
							<div class="row">
<?php 
	if(!empty($table)){
		foreach($table as $row){
?>

						
								<div class="col-sm-12">
									<div class="card card-info">
										<div class="card-header">
											<h3 class="card-title" style="color:#fff;font-weight:bolder;"><?=$row->branch_name;?></h3>
										</div>
										<div class="card-body">
											<table id="example222<?=$row->id;?>" class="table table-sm">
												<thead>
													<tr>
														<th>ID</th>
														<th>Name</th>
														<th>Entry Date</th>
														<th style="text-align: end;">Option</th>
													</tr>
												</thead>
												<tbody>
<?php
	if(!empty($table2)){
		foreach($table2 as $qow){
			if($qow->branch_id == $row->branch_id){
				if($qow->status == '1'){
					$style= 'Style="background-color:#28a745;color:#fff;"';
				}else{
					$style= 'Style="background-color:#dc3545;color:#fff;"';
				}
?>
													<tr>
														<td><?=$qow->id;?></td>
														<td><?=$qow->floor_name;?></td>
														<td><?=$qow->data;?></td>
														<td style="text-align: end;">
															<form action="<?=current_url(); ?>" method="post">
																<input type="hidden" value="<?=$qow->id;?>" name="hidden_id"/>
																<?php if($qow->status == '1'){ ?>
																	<button class="btn btn-success btn-xs"><i class="fa fa-check"></i>&nbsp;&nbsp;Active</button>	
																<?php }else{ ?>
																	<button class="btn btn-danger btn-xs"><i class="fa fa-times"></i>&nbsp;&nbsp;Deactive</button>	
																<?php } ?>
																<button name="edit" type="submit" class="btn btn-xs btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Edit</button>
																<button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Delete</button>																															
																<button onclick="return add_unit('<?=$row->branch_id;?>','<?=$qow->id;?>')" type="button" class="btn btn-xs btn-warning" title="Add Unit"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Add Unit</button>
																<button onclick="return add_rooms('<?=$row->branch_id;?>','<?=$qow->id;?>')" type="button" class="btn btn-xs btn-info" title="Add Rooms"><i class="fas fa-plus-circle"></i>&nbsp;&nbsp;Add Room</button>
																<button onclick="return add_beds('<?=$row->branch_id;?>','<?=$qow->id;?>')" type="button" class="btn btn-xs btn-primary" title="Add Beds"><i class="fas fa-bed"></i>&nbsp;&nbsp;Add Bed</button>
															</form>
														</td>
													</tr>
													
													
<?php }}} ?>
												</tbody>
											</table>
<script>$(function () { $('#example222<?=$row->id;?>').DataTable({ });  })</script>
										</div>
									</div>
								</div>
<?php } }  ?>							
							</div>							
						</div>					
					</div>
				</div>
	

			</div>
<!---------------------unit model------------------------>
<div class="modal fade" id="Add_unit_model">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header">
					<h4 class="modal-title">Input Unit Information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input id="branch_id" type="hidden" name="branch_id" value=""/>
					<input id="floor_id" type="hidden" name="floor_id" value=""/>
					<div id='UnitBoxesGroup'>
						<div class="form-group" id="UnitBoxDiv1">
							<label>Unit Name #1:</label>
							<div class="unit_div">
								<input type="text" name="unit_name[]" class="form-control" id='unitbox1' required /> 
								<input type="hidden" name="unit_type[]" value="" class="form-control" /> 
							</div>
						</div>
					</div>
					<div style="margin-top:10px;">
						<button type="button" id='removeButton' class="btn btn-danger btn-xs">Remove Fields</button>
						<button type="button" id='addButton' class="btn btn-success btn-xs">Add Fields</button>						
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button name="add_unit" type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
        </div>
    </div>
</div>	
<!---------------------unit model------------------------>			

<!---------------------Room model------------------------>
<div class="modal fade" id="Add_room_model">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header">
					<h4 class="modal-title">Input Room Information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input id="branch_id_rooms" type="hidden" name="branch_id" value=""/>
					<input id="floor_id_rooms" type="hidden" name="floor_id" value=""/>
					<div class="form-group">
						<label>Select Unit</label>
						<select name="unit_id" id="unit_id" class="form-control select2" required></select>
					</div>
					<div class="form-group" id="RoomBoxDiv1">
						<label>Category & Room Type:</label>
						<div class="room_div">
							<div class="row">
								<div class="col-sm-6">
									<select id="package_category" name="package_category" class="form-control right_sl" required></select>
								</div>
								<div class="col-sm-6">
									<select id="room_type" name="room_type" class="form-control right_sl" required></select>
								</div>
							</div>							
						</div>
					</div>
					<div id='RoomBoxesGroup'>
						<div class="form-group" id="RoomBoxDiv1">
							<label>Room Name #1:</label>
							<div class="room_div">
								<input type="text" name="room_name[]" class="form-control" id='roombox1' required /> 
							</div>
						</div>
					</div>
					<div style="margin-top:10px;">
						<button type="button" id='removefiels' class="btn btn-danger btn-xs">Remove Fields</button>
						<button type="button" id='addfield' class="btn btn-success btn-xs">Add Fields</button>						
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button name="add_room" type="submit" class="btn btn-primary">Save Rooms</button>
				</div>
			</form>
        </div>
    </div>
</div>	
<!---------------------Room model------------------------>	


<!---------------------Bed model------------------------>
<div class="modal fade" id="Add_bed_model">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header">
					<h4 class="modal-title">Input Bed Information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<input id="branch_id_bed" type="hidden" name="branch_id" value=""/>
					<input id="floor_id_bed" type="hidden" name="floor_id" value=""/>
					<div class="form-group">
						<label>Select Unit</label>
						<select name="unit_id" id="unit_iid" class="form-control select2" required></select>
					</div>
					
					<div class="form-group">
						<label>Select Room</label>
						<select name="room_id" id="room_id" class="form-control select2" required></select>
					</div>
					
					
					<div id='BedBoxesGroup'>
						<div class="form-group" id="BedBoxDiv1">
							<label>Bed Name #1:</label>
							<input type="text" name="bed_name[]" class="form-control" id='bedbox1' required /> 
						</div>
					</div>
					<div style="margin-top:10px;">
						<button type="button" id='removebed' class="btn btn-danger btn-xs">Remove Fields</button>
						<button type="button" id='addbed' class="btn btn-success btn-xs">Add Fields</button>						
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button name="add_bed" type="submit" class="btn btn-primary">Save Beds</button>
				</div>
			</form>
        </div>
    </div>
</div>	
<!---------------------Bed model------------------------>		
			
			
			
			
			
		</div>
	</div>
</div>






<script>
function add_beds( branch, floor){
	$('#branch_id_bed').val(branch);
	$('#floor_id_bed').val(floor);
	var id = floor; 
	if(id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/select_unit_options.php');?>",  
			method:"POST",  
			data:{view_id:id},
			beforeSend:function(){					
				$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
			},
			success:function(data){	
				$('#unit_iid').html(data);    
				$('#Add_bed_model').modal('show');
				$('#data-loading').html('');
			}  
		});  
	}
}
function add_rooms( branch, floor){
	$('#branch_id_rooms').val(branch);
	$('#floor_id_rooms').val(floor);
	var id = floor; 
	if(id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/select_unit_options.php');?>",  
			method:"POST",  
			data:{view_id:id},
			beforeSend:function(){					
				$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
			},
			success:function(data){
				$.ajax({  
					url:"<?=base_url('assets/ajax/select_spackage_category_options.php');?>",  
					method:"POST",  
					data:{view_id:branch},
					beforeSend:function(){					
						$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
					},
					success:function(data){						
						$('#data-loading').html('');
						$('#package_category').html(data);
						$('#Add_room_model').modal('show');				
					}  
				});
				$('#unit_id').html(data); 
			}  
		});  
	}
}
function add_unit( branch, floor){	
	$('#branch_id').val(branch);
	$('#floor_id').val(floor);
	$('#Add_unit_model').modal('show');
}
$(document).ready(function(){
	$("#package_category").on("change",function(){
		var id = $( this ).val(); 
		if(id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/option_select/select_room_type_options.php');?>",  
				method:"POST",  
				data:{view_id:id},
				success:function(data){	
					$('#room_type').html(data);    
				}  
			});  
		}
	})
	
	
	$("#unit_iid").on("change",function(){
		var id = $( this ).val(); 
		if(id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/select_room_options.php');?>",  
				method:"POST",  
				data:{view_id:id},
				success:function(data){	
					$('#room_id').html(data);    
				}  
			});  
		}
	})
//start bed section
	var counter = 2;
    $("#addbed").click(function () {
		var newTextBoxDiv = $(document.createElement('div')).attr("id", 'BedBoxDiv1' + counter);
		
		var data = '<div class="form-group"><label>Bed Name #'+ counter + ' : </label>';
			data += '<input type="text" name="bed_name[]" class="form-control" id="bedbox' + counter + '" required/>';
			data += '</div>';
		newTextBoxDiv.after().html(data);
		newTextBoxDiv.appendTo("#BedBoxesGroup");
		counter++;
    });
    $("#removebed").click(function () {
		if( counter == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter--;
        $("#BedBoxDiv1" + counter).remove();
    });	
		
	//start room section
	var counter = 2;
    $("#addfield").click(function () {
		var newTextBoxDiv = $(document.createElement('div')).attr("id", 'RoomBoxDiv1' + counter);
		
		var data = '<div class="form-group"><label>Room Name #'+ counter + ' : </label>';
			data += '<div class="room_div">';
			data += '<input type="text" name="room_name[]" class="form-control left_in" id="roombox' + counter + '" required/>';
			data += '</div>';
			data += '</div>';
		newTextBoxDiv.after().html(data);
		newTextBoxDiv.appendTo("#RoomBoxesGroup");
		counter++;
    });
    $("#removefiels").click(function () {
		if( counter == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter--;
        $("#RoomBoxDiv1" + counter).remove();
    });
	
	//start unit section
    var counter = 2;
    $("#addButton").click(function () {
		var newTextBoxDiv = $(document.createElement('div')).attr("id", 'UnitBoxDiv1' + counter);
		
		var data = '<div class="form-group"><label>Unite Name #'+ counter + ' : </label>';
			data += '<div class="unit_div">';
			data += '<input type="text" name="unit_name[]" class="form-control" id="unitbox' + counter + '" required/>';
			data += '<input type="hidden" value="" name="unit_type[]" class="form-control"/>';
			data += '</div>';
			data += '</div>';
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
});
</script>

