
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Complain Categories</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Create</a></li>
              <li class="breadcrumb-item"><a href="#">Award</a></li>
              <li class="breadcrumb-item active">Sales Award</li>
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
							<h3 class="card-title">Complain Category Create</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Department</label>
											<select class="form-control" name="department_id">
												<option selected value="">Choose...</option>
												<?php foreach($result as $r) { ?>
												<option value="<?php echo $r->department_id; ?>" 
												<?php 
												if(!empty($edit)){ 
													if($edit->department_id == $r->department_id){ 
														$select = 'selected';
													}else{ 
														$select = null;
													} 
													echo $select ;
												}
												
												?>
												
												><?php echo $r->department_name; ?></option>
												<?php } ?>
											</select>
											<span class="text-danger"><?php echo form_error('department_id');?> </span>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Category </label>
											<input name="category_name" value="<?php if(!empty($edit)){ echo $edit->name; } ?>" type="text" class=" form-control" required>
											<span class="text-danger"><?php echo form_error('category_name');?> </span>
										</div>
									</div>
									
								</div>
								<div class="row">
									<div class="form-group">
										<label>Service Enable/Disable</label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
									
									</div>
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
							<h3 class="card-title">Complain Category list</h3>
						</div>
						<div class="card-body">
							<table class="table text-center" id="myTable">
								<thead>
									<tr>
										<th>Id</th>
										<th>Department</th>
									    <th>Category</th>
									    <th>Status</th>
									   <th>Action</th>
									</tr>
								</thead>
                                
								<tbody>
									<?php foreach($complain_category_list as $key=>$single){ ?>
										<tr>
											 <td><?php echo $key+1; ?></td>
											 <td><?php echo $single->department_name; ?></td>
											 <td><?php echo $single->name; ?></td>
											  <td><?php echo ( $single->status == '1') ? '<p class="badge badge-primary mb-0">Active</p>' : '<p class="badge badge-danger mb-0">Inactive</p>'; ?></td>
											 
											<td class="d-flex">
												<form action="<?=base_url()?>admin/create/complain/complain-category" method="post">
													<input type="hidden" name="id" value="<?php echo $single->id; ?>">	
													<button name="edit" value="edit" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></button>
												</form>
												<a style="cursor: pointer; color: white;" class="btn btn-xs btn-danger  delete_category"  data-id="<?php echo $single->id; ?>"><i class="fas fa-trash"></i></a>
											</td>
										</tr>
									<?php } ?>
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
  $(document).ready(function(){
		$('#myTable').DataTable();
      $(document).on('click', '.delete_category', function(e){
          //alert("tets");
          e.preventDefault();
          var id = $(this).data('id');
          if(confirm('Are you want to delete this?'))
          {
                   $.ajax({
                        url: "<?=base_url('admin/create/complain/complain-category'); ?>",

						type:"post",
						data:{'delete_id':id},
						dataType:"html",
						success:function(data) {
						  window.location.reload();
						},
                            
                });

          }
          
      });
	  
	 

  });
 
</script>