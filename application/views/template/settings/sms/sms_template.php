
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">SMS Templates</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Settings</a></li>
              <li class="breadcrumb-item"><a href="#">SMS</a></li>
              <li class="breadcrumb-item active">SMS Templates</li>
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
							<h3 class="card-title">Input SMS Templates</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="form-group">
									<label>Choose Configuration</label>
									<select name="configuration" class="form-control select2" required>
										<option value="">--select--</option>
										<?php 
										if(!empty($configuration)){
											foreach($configuration as $row){
												if(!empty($edit) AND $edit->configuration == $row->id){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												echo '<option value="'.$row->id.'" '.$selected.'>'.$row->configuration_name.'</option>';
											}
										}
										?>
									</select>
								</div>								
								<div class="form-group">
									<label>Choose Purpase</label>
									<select name="purpase" class="form-control select2" required>
										<option value="">--select--</option>
										<?php 
										if(!empty($purpase)){
											foreach($purpase as $row){
												if(!empty($edit) AND $edit->purpase == $row->id){
													$selected = 'selected';
												}else{
													$selected = '';
												}
												echo '<option value="'.$row->id.'" '.$selected.'>'.$row->purpuse_name.'</option>';
											}
										}
										?>
									</select>
								</div>								
								<div class="form-group">
									<label>Exmple Message</label>
									<textarea name="message" placeholder="Message" class="form-control" required><?php if(!empty($edit)){ echo $edit->message; }else{ echo "'.member->name.'"; } ?></textarea>
								</div>								
								<div class="form-group">
									<label>Enable/Disable</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" placeholder="Note" class="form-control"><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
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
							<h3 class="card-title">Template List</h3>
						</div>
						<div class="card-body">
							<table class="table table-sm" id="example2">
								<thead>
									<tr>
										<th></th>
										<th>ID</th>
										<th>Configuration</th>
										<th>Purpase</th>
										<th>Message</th>
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
										<td><?=$row->id;?></td>
										<td><?=$row->configuration;?></td>
										<td><?=$row->purpase;?></td>
										<td><?=$row->message;?></td>
										<td><?=$row->data;?></td>
										<td>
											<?php if($row->status == '1'){ ?>
												<button class="btn btn-sm btn-success">Active</button>
											<?php }else{ ?>
												<button class="btn btn-sm btn-danger">Deactive</button>
											<?php } ?>
										</td>
										<td>
											<form action="<?=current_url(); ?>" method="post">
												<input type="hidden" value="<?=$row->id;?>" name="hidden_id"/>
												<button name="edit" type="submit" class="btn btn-sm btn-success">Edit</button>
												<button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-sm btn-danger">Delete</button>
											</form>
										</td>
									</tr>
<?php } } ?>									
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
<script>
$(document).ready(function(){ 
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