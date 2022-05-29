	<div class="content">
		<div class="container-flud">
			<div class="row">	
				<div class="col-sm-10 m-auto">
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Task Details</h3>
						</div>
						<div class="card mb-3">
							<?php if($task_info->task_image): ?>
								<img src='<?= base_url()?>assets/uploads/task_list/<?=$task_info->task_image?>' class='card-img-top' style='max-height: 400px'>
							<?php endif; ?>
							
							<div class="card-header text-muted">
								<small><?=!empty($task_info->emp_name_by) ? " Assigned by: $task_info->emp_name_by," : '' ?></small>
								<small><?=!empty($task_info->emp_name_to) ? " Assigned to: $task_info->emp_name_to," : '' ?></small>
								<small><?=!empty($task_info->emp_name_pro) ? " Processing By: $task_info->emp_name_pro," : '' ?></small>
								<small><?=!empty($task_info->emp_name_com) ? " Complete By: $task_info->emp_name_com," : '' ?></small>
								<?php
									$phpdate = strtotime( $task_info->accepted_at );
									$mysqldate = date( 'd M Y h:i A', $phpdate );
								?>
								<small><?=!empty($task_info->accepted_at) ? " Accepted at: $mysqldate," : '' ?></small>
								<?php
									$phpdate = strtotime( $task_info->completed_at );
									$mysqldate = date( 'd M Y h:i A', $phpdate );
								?>
								<small><?=!empty($task_info->completed_at) ? " Completed at: $mysqldate," : '' ?></small>
								<small>Status: 
									<?php
									switch ($task_info->status) {
										case "1":
											echo 'Processing';
											break;
										case "2":
											echo 'Completed';
											break;
										default:
											echo 'Queue';
									}
									?>
								</small>
							</div>
							<div class="card-body">
								<h3 class="my-3"><?=$task_info->title?></h3>
								<p class="card-text"><?=$task_info->description?></p>
								<p class="card-text"><small class="text-muted"><?=$task_info->created_at?></small></p>
							</div>
						</div>
									
						<div class="row">
							<h2 class="col-2 text-right">
								<i class="far fa-user-circle pt-5 text-info"></i>
							</h2>
							
							<form class="col-10" method="post">
								<label for="floatingTextarea">Comments</label>
								<input type="hidden" id="task_id" value="<?php echo $task_info->id; ?>">
								<div class="input-group col-8">
									<textarea class="form-control" id="comment" placeholder="Leave a comment here" aria-label="With textarea" rows="1"></textarea>
									<div class="input-group-prepend">
										<input type='button' value='Post' id='sendcomment' class='input-group-text'>
									</div>
								</div>
							</form>
						</div>
						<div id="view"> </div>
						<?php
							
							foreach($comment as $data) {
							$phpdate = strtotime( $data->created_at );
							$mysqldate = date( 'd M Y, h:i A', $phpdate )
						?>
						<div class="d-flex flex-row mt-3">
							<h2 class="col-2 text-right">
								<i class="far fa-user-circle pt-1 pr-2 text-info"></i>
							</h2>
							<div class="">
								<h5><?php echo $data->full_name ?> <small class="text-muted" style="font-size:11px"><?php echo $mysqldate ?></small></h5>
								<p><?php echo $data->comment ?></p>
							</div>
						</div>
						<?php } ?> 
						<div id="shows"> </div>
						
						<button type="button" id="clicks" class="btn btn-secondary ms-4" value="<?php echo $task_info->id; ?>">Show More</button>  
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>

<script>
  /*---------------- make comment by ajax -------------*/
	$(document).ready(function () {

		$("#sendcomment").click(function(){
			var task_id =$('#task_id').val();
			var comment =$('#comment').val();
			$.ajax({
				// you can use both post and get method in this syntax
				method: "POST",
				url:"<?=base_url(); ?>/Task_list/comment", 
				data: {task_id: task_id, comment: comment}, 
				success: function(result){
					$('#comment').val('');
					var fresult=$("#view").html(); 
					result += fresult;
					$("#view").html(result);
			}
			});
		
		});
	});
 

 /*---------------- show more comment by ajax -------------*/
	$(document).ready(function () {
	var count = 0; 
		$("#clicks").click(function(){
		count+=3;
		var task_id =$(this).val();
		$.ajax({
			// you can use both post and get method in this syntax
			method: "POST",
			url:"<?=base_url(); ?>/Task_list/comment", 
			data: {count: count, task_id: task_id}, 
			success: function(result){
			$("#shows").html(result)
		}
		});
	});
	});
</script>