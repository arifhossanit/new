
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Add Refreshment Item</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Add Refreshment Item</li>
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
							<h3 class="card-title">Add Refreshment Item information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="form-group">
									<label>Select Branch</label>
									<select id="branch_id" name="branch_id" class="form-control select2" required>
										<option value="">Select</option>
										<?php
											if(!empty($banches)){
												$last = 1; $start = 0;
												foreach($banches as $row){
													if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
														if(!empty($edit)){ 
															if($edit->branch_id == $row->branch_id){
																echo '<option value="'.$row->branch_id.'" selected>'.$row->branch_name.'</option>';
															}else{
																echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
															}
														}else{
															echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
														}	
													}else if($_SESSION['super_admin']['role_id'] == '2833509622926062010'){
														if(!empty($banches_permission->permission)){																
															$permission = explode(',',$banches_permission->permission);
															foreach( array_slice( $permission , $start++, $last) as $rain){
																if($rain == $row->branch_id){
																	if(!empty($edit)){ 
																		if($edit->branch_id == $row->branch_id){
																			echo '<option value="'.$row->branch_id.'" selected>'.$row->branch_name.'</option>';
																		}else{
																			echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
																		}
																	}else{
																		echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
																	}																	
																}															
															}																
														}
													}else{
														$branch_id = $_SESSION['super_admin']['branch'];
														if($branch_id == $row->branch_id){
															echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
														}
													}														
												}
											}
										?>
									</select>
								</div>
								<div class="form-group">
									<label>Item Name</label>
									<input type="text" value="<?php if(!empty($edit)){ echo $edit->item_name; } ?>" name="item_name" class="form-control" placeholder="Item Name" required/>
								</div>
								<div class="form-group">
									<label>Item Picture</label>
									<input type="file" name="item_picture" class="form-control" style="padding-top:3px;" <?php if(!empty($edit)){ echo ''; }else{ echo 'required'; } ?> />
								</div>
								<div class="form-group">
									<label>Price</label>
									<input name="price" value="<?php if(!empty($edit)){ echo $edit->price; } ?>" type="text" class="form-control" placeholder="price" required>
								</div>
								<div class="form-group">
									<label>Status Enable/Disable</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
								</div>
								<div class="form-group">
									<label>Welcome Tea</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="welcome_tea" <?php if(!empty($edit)){ if($edit->welcome_tea == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
								</div>
								<div class="form-group">
									<label>Facebook Winner</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="facebook_winner" <?php if(!empty($edit)){ if($edit->facebook_winner == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
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
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Refreshment Item List</h3>
						</div>
						<div class="card-body">
							<table class="table table-sm" id="example2">
								<thead>
									<tr>
										<th>ID</th>
										<th>Branch</th>
										<th>Item Name</th>
										<th>Image</th>
										<th>Price</th>
										<th>Date</th>
										<th>Status</th>
										<th>Welcome</th>
										<th>Facebook</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody>
<?php 
if(!empty($table)){
	foreach($table as $row){
?>								
									<tr>
										<td><?=$row->id;?></td>
										<td><?=$row->branch_name;?></td>
										<td><?=$row->item_name;?></td>
										<td><img src="<?php echo base_url($row->item_picture); ?>" style="width:40px;" /></td>
										<td><?=money($row->price);?></td>
										<td><?=$row->data;?></td>
										<td>
											<?php if($row->status == '1'){ ?>
												<button class="btn btn-xs btn-success">Active</button>
											<?php }else{ ?>
												<button class="btn btn-xs btn-danger">Deactive</button>
											<?php } ?>
										</td>
										<td>
											<?php if($row->welcome_tea == '1'){ ?>
												<button class="btn btn-xs btn-success">Active</button>
											<?php }else{ ?>
												<button class="btn btn-xs btn-danger">Deactive</button>
											<?php } ?>
										</td>
										<td>
											<?php if($row->facebook_winner == '1'){ ?>
												<button class="btn btn-xs btn-success">Active</button>
											<?php }else{ ?>
												<button class="btn btn-xs btn-danger">Deactive</button>
											<?php } ?>
										</td>
										<td>
											<form action="<?=current_url(); ?>" method="post">
												<input type="hidden" value="<?=$row->id;?>" name="hidden_id"/>
												<button name="edit" type="submit" class="btn btn-xs btn-success">Edit</button>
												<button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-xs btn-danger">Delete</button>
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
<script>
$('document').ready(function(){
	$("#branch_id").on("change",function(){
		var branch_id = $("#branch_id").val(); 
		if(branch_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/select_spackage_category_options.php');?>",  
				method:"POST",  
				data:{view_id:branch_id},
				beforeSend:function(){					
					$('#data-loading').html(data_loading);
				},
				success:function(data){	
					$('#data-loading').html('');
					$('#package_category').html(data);
				}
			});
		}
	})
})
</script>