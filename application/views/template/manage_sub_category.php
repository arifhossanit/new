
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Sub Category</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Manage Sub Category</li>
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
							<h3 class="card-title">Input sub Category information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">

								<div class="form-group">
									<label>Sub Package Name</label>
									<input name="sub_package_name" value="<?php if(!empty($edit)){ echo $edit->sub_package_name; } ?>" type="text" class="form-control" placeholder="Sub Package Name" required>
								</div>
								
								<div class="form-group">
									<label>Value</label>
									<input name="booking_value" value="<?php if(!empty($edit)){ echo $edit->booking_value; } ?>" type="text" class="number_int form-control" placeholder="Value" required>
								</div>
								
								<div class="form-group">
									<label>package Enable/Disable</label>
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
							<h3 class="card-title">Package List</h3>
						</div>
						<div class="card-body">
							<table class="table table-sm" id="example2">
								<thead>
									<tr>
										<th>ID</th>
										<th>Sub Category Name</th>
										<th>Value</th>
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
										<td><?=$row->id;?></td>
										<td><?=$row->sub_package_name;?></td>
										<td><?=$row->booking_value;?></td>
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
						</div>					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

</script>