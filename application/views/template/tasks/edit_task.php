<div class="card card-primary">
		<div class="card-header">
			<h3 class="card-title">Assign a Task</h3>
		</div>
		<form role="form" action="<?=base_url('admin/s_it/tasks'); ?>" method="POST" id="myform" enctype="multipart/form-data">
		<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
			<div class="card-body">
				<div class="row">
				
					<div class="col-sm-12">
						<div class="form-group">
							<?php if ($_SESSION['user_info']['department']=='749568347163692080'): ?>

							<label>Assinged To</label>
							<select class="form-control" id="employee_id" name="employee_id">
								<option selected value="">Choose...</option>
								<?php foreach($result as $r): ?>
								<option value="<?php echo $r->employee_id; ?>" 
								<?php 
								if(!empty($edit)){ 
									if($edit->assigned_to == $r->employee_id || $edit->processing_by == $r->employee_id){ 
										$select = 'selected';
									}else{ 
										$select = null;
									} 
									echo $select ;
								}
								?>
								
								><?php echo $r->full_name; ?></option>
								<?php endforeach; ?>
							</select>
						<?php endif; if($dep_head->d_head==1 && $_SESSION['user_info']['department']!='749568347163692080'):?>
							<label>Assinged To</label>
							<select class="form-control" id="employee_id" name="employee_id">
								<option selected value="">Choose...</option>
								<?php foreach($emp_list as $r) { ?>
								<option value="<?php echo $r->employee_id; ?>"  
								<?php 
								if(!empty($edit)){ 
									if($edit->assigned_to == $r->employee_id || $edit->processing_by == $r->employee_id){ 
										$select = 'selected';
									}else{ 
										$select = null;
									} 
									echo $select ;
								}
								?>
								><?php echo $r->full_name; ?></option>
								<?php } ?>
							</select>
						<?php endif; ?>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Task Title<span class="text-danger">*</span> </label>
							<input id="title" name="title" value="<?php if(!empty($edit)){ echo $edit->title; } ?>" type="text" class=" form-control" required>
							<span class="text-danger"><?php echo form_error('title');?> </span>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Task Description<span class="text-danger">*</span> </label>
							<textarea name="description" id="description" class="form-control" cols="30" rows="5" required><?php if(!empty($edit)){ echo $edit->description; } ?></textarea>
							<span class="text-danger"><?php echo form_error('description');?> </span>
						</div>
					</div>
					<!-- <div class="col-sm-12">
						<label for="deadline">Task Deadline <small class="text-danger">(optional)</small> :  </label>
						<input type='date' id='deadline' name='deadline' min='<?= date("Y-m-d"); ?>'>
					</div> -->
					<div class="col-sm-8">
						<div class="form-group">
							<label>Task Image </label>
							<div class="input-group mb-3">
								<label class="input-group-text" for="inputGroupFile01">Upload</label>
								<input type="file" class="form-control" id="image" name="image">
							</div>
							<span class="text-danger"><?php echo form_error('description');?> </span>
						</div>
					</div>
					<?php if (!empty($edit) && !empty($edit->task_image)): ?>
						<div class="col-sm-4"><img class="w-75" src="<?= base_url()?>assets/uploads/task_list/<?= $edit->task_image ?>" alt="Task image"></div>
					<?php endif; ?>      
				</div>								
			</div>
			
			<div class="card-footer bg-white">
				<!-- <input type="hidden" name="update" value="update"> -->
				<button type="submit" id="update" name="update" class="btn btn-warning btn-small btn-block">Update</button>
			</div>
		</form>
	</div>