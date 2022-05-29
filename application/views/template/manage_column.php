<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Column</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Create</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Branch,Bed e.t.c</a></li>
              <li class="breadcrumb-item active">Manage Column</li>
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
				<div class="col-sm-3">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Input Column information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="form-group">
									<label>Select Branch</label>
									<select name="branch_id" id="branch_id" class="form-control select2" required>
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
								</div>
								<div class="form-group">
									<label>Select Floor</label>
									<select name="floor_id" id="floor_id" class="form-control select2" required>
										<?php if(!empty($edit)){ echo '<option value="'.$edit->floor_id.'">'.$edit->floor_name.'</option>'; } ?>
									</select>
								</div>
								<div class="form-group">
									<label>Select Unit</label>
									<select name="unit_id" id="unit_id" class="form-control select2" required>
										<?php if(!empty($edit)){ echo '<option value="'.$edit->unit_id.'">'.$edit->unit_name.'</option>'; } ?>
									</select>
								</div>
								<div class="form-group">
									<label>Select Room</label>
									<select name="room_id" id="room_id" class="form-control select2" required>
										<?php if(!empty($edit)){ echo '<option value="'.$edit->room_id.'">'.$edit->room_name.'</option>'; } ?>
									</select>
								</div>
								
								<div class="form-group">
									<label>Column Name</label>
									<input name="column_name" value="<?php if(!empty($edit)){ echo $edit->column_name; } ?>" type="text" class="form-control" placeholder="Column Name" required>
								</div>								
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control" placeholder="Note"><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
								</div>
								<div class="form-group">
									<label>Column Enable/Disable</label>
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
				
				<div class="col-sm-9">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Column List</h3>
						</div>
						<div class="card-body">				

							<table class="table table-sm" id="example2">
								<thead>
									<tr>
										<th>ID</th>
										<th>Branch</th>
										<th>Floors</th>
										<th>Unit</th>
										<th>Room</th>
										<th>Column</th>
										<th>Entry Date</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody>
<?php
if(!empty($table)){
	foreach($table as $qow){
?>
									<tr>
										<td><?=$qow->id;?></td>
										<td><?=$qow->branch_name;?></td>
										<td><?=$qow->floor_name;?></td>
										<td><?=$qow->unit_name;?></td>
										<td><?=$qow->room_name;?></td>
										<td><?=$qow->column_name;?></td>
										<td><?=$qow->data;?></td>
										<td>
											<form action="<?=current_url(); ?>" method="post">
												<input type="hidden" value="<?=$qow->id;?>" name="hidden_id"/>
												<?php if($qow->status == '1'){ ?>
													<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>	
												<?php }else{ ?>
													<button class="btn btn-danger btn-xs"><i class="fa fa-times"></i></button>	
												<?php } ?>
												<button name="edit" type="submit" class="btn btn-xs btn-success"><i class="fas fa-edit"></i></button>
												<button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>																															
											</form>
										</td>
									</tr>
									
									
<?php }} ?>
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






<script>
$(document).ready(function(){
	$("#branch_id").on("change",function(){
		var id = $( this ).val(); 
		if(id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/select_floor_options.php');?>",  
				method:"POST",  
				data:{view_id:id},
				beforeSend:function(){					
					$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
				},
				success:function(data){
					$('#data-loading').html('');
					$('#floor_id').html(data);
				}  
			});  
		}
	})
	$("#floor_id").on("change",function(){
		var id = $( this ).val(); 
		if(id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/select_unit_options.php');?>",  
				method:"POST",  
				data:{view_id:id},
				beforeSend:function(){					
					$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
				},
				success:function(data){	
					$('#unit_id').html(data);
					$('#data-loading').html('');
				}  
			});  
		}
	})
	$("#unit_id").on("change",function(){
		var id = $( this ).val(); 
		if(id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/option_select/select_room_options.php');?>",  
				method:"POST",  
				data:{view_id:id},
				beforeSend:function(){					
					$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
				},
				success:function(data){	
					$('#room_id').html(data);
					$('#data-loading').html('');
				}  
			});  
		}
	})
	
});
</script>

