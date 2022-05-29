<div class="content">
		<div class="container-flud">
			<div class="row">	
				<div class="col-sm-8 m-auto">
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Task Review & Confirmation</h3>
						</div>
						<div class="card mb-3">
							<?php if($task_info->task_image): ?>
								<img src='<?= base_url()?>assets/uploads/task_list/<?=$task_info->task_image?>' class='card-img-top' style='max-height: 400px'>
							<?php endif; ?>

							<div class="card-body">
								<h3 class="my-3"><?=$task_info->title?></h3>
								<p class="card-text"><?=$task_info->description?></p>
								<p class="card-text"><small class="text-muted"><?=$task_info->created_at?></small></p>
							</div>
						</div>
                        <div class="text-center mb-3">
                            <h3 class="text-info  mb-4">Do you complete your work?</h3>
                            <form action="<?=base_url('admin/s_it/tasks'); ?>" method="post">
                                <input type="hidden" name="task_id" value="<?=$task_info->id ?>">
                                <input type="hidden" name="emp_id" value="<?=$task_info->processing_by?>">
                                <button type="submit" class="btn btn-danger" name="complete_task">Yes, Confirm</button>
                            </form>
                        </div>
                        
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>