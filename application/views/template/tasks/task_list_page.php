<style>
	/* vertical scrollbar for table */
	.my-custom-scrollbar {
	position: relative;
	max-height: 70vh;
	overflow: auto;
	}
	.table-wrapper-scroll-y {
	display: block;
	}

	/* styleing for task priority star */
	.rate {
    float: right;
    height: 46px;
    padding: 0 10px;
	}
	.rate:not(:checked) > input {
		position:absolute;
		top:-9999px;
	}
	.rate:not(:checked) > label {
		float:right;
		width:1em;
		overflow:hidden;
		white-space:nowrap;
		cursor:pointer;
		font-size:30px;
		color:#ccc;
	}
	.rate:not(:checked) > label:before {
		content: '★ ';
	}
	.rate > input:checked ~ label {
		color: #ffc700;    
	}
	.rate:not(:checked) > label:hover,
	.rate:not(:checked) > label:hover ~ label {
		color: #deb217;  
	}
	.rate > input:checked + label:hover,
	.rate > input:checked + label:hover ~ label,
	.rate > input:checked ~ label:hover,
	.rate > input:checked ~ label:hover ~ label,
	.rate > label:hover ~ input:checked ~ label {
		color: #c59b08;
	}


	/* rating show */
	.checked {
		color: orange;
	}
</style>

<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark d-inline-flex mr-2">Todo/Task List</h1>
			<!-- Button trigger modal for add task -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
			Add Task <i class="fas fa-plus"></i>
			</button>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">List</a></li>
              <li class="breadcrumb-item active">Task list</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container-flud">
			<div class="row flex-row flex-nowrap">
				<!-- table 1 -->
				<div class="col-sm-4">
					<div class="card card-warning">
						<div class="card-header">
							<h3 class="card-title">Task list (Queue)</h3>
						</div>
						<div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
							<table class="table table-striped table-bordered table-sm small" id="myTable">
								<thead>
									<tr>
										<th>SL</th>
										<th>Title</th>
									    <th>Assigned By</th>
									    <th>Assigned To</th>
									    <th>Priority</th>
									    <th>Deadline</th>
									    <th>Action</th>
									</tr>
								</thead>
                                
								<tbody id='tdata'>
									<?php foreach($task_queue as $key=>$task): ?>
										<tr>
											 <td><?php echo $key+1; ?></td>
											 <td class="text-truncate" style="max-width: 150px;"><?php echo $task->title; ?></td>
											 <td><?php echo $task->emp_name_by; ?></td>
											 <td><?php echo $task->emp_name_to; ?></td>
											 <td  style="font-size: 8px">
													<span class="fa fa-star <?=$task->priority_rate>0 ? 'checked' : '' ?>"></span>
													<span class="fa fa-star <?=$task->priority_rate>1 ? 'checked' : '' ?>"></span>
													<span class="fa fa-star <?=$task->priority_rate>2 ? 'checked' : '' ?>"></span>
													<span class="fa fa-star <?=$task->priority_rate>3 ? 'checked' : '' ?>"></span>
													<span class="fa fa-star <?=$task->priority_rate>4 ? 'checked' : '' ?>"></span>
											 </td>
											 <td>
												 <?php
												 if ($task->deadline_at == "0000-00-00 00:00:00") {
													 echo '';
												 }else {
													$phpdate = strtotime( $task->deadline_at );
													$mysqldate = date( 'd M Y', $phpdate );
													echo $mysqldate; 
												 }
												  ?>
												</td>
											<td class="d-flex">
												<!-- Button trigger modal for accept task -->
												<button style="cursor: pointer; color: white;" class="btn btn-xs btn-success accept"
													data-task_accept="<?php echo $task->id;?>"
													data-toggle="modal" data-target="#exampleModal2"
													<?php echo $task->assigned_to==$_SESSION['super_admin']['employee_ids'] || empty($task->assigned_to) ? '' : 'disabled'; ?>
													>
													<i class="fas fa-clipboard-check"></i>
												</button>

												<!-- Button trigger modal for veiw -->
												<a href="#" data-task_info="<?php echo $task->id; ?>" class="btn btn-xs btn-warning task_veiw" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye"></i></a>
												<!-- Button trigger modal for edit task -->
												<button href="#" data-task_edit="<?php echo $task->id; ?>" class="btn btn-xs btn-primary task_edit" data-toggle="modal" data-target="#exampleModal2" <?php echo $task->assigned_by==$_SESSION['super_admin']['employee_ids'] ? '' : 'disabled'; ?>><i class="fa fa-edit"></i></button>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
                                    
							</table>
						</div>
					</div>
				</div>
				<!-- table 2 -->
				<div class="col-sm-4">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Task list (Processing)</h3>
						</div>
						<div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
							<table class="table table-striped table-bordered table-sm small" id="myTable">
								<thead>
									<tr>
										<th>SL</th>
										<th>Title</th>
									    <th>Assigned By</th>
									    <th>Processing By</th>
									    <th>Time Left</th>
									    <th>Action</th>
									</tr>
								</thead>
                                
								<tbody id='tdata'>
									<?php foreach($task_processing as $key=>$task): ?>
										<tr>
											 <td><?php echo $key+1; ?></td>
											 <td class="text-truncate" style="max-width: 150px;"><?php echo $task->title; ?></td>
											 <td><?php echo $task->emp_name_by; ?></td>
											 <td><?php echo $task->emp_name_pro; ?></td>
											 <td class="demo" data-val="<?php echo $task->target_at ?>"></td>
											<td class="d-flex">
												<!-- Button trigger modal for accept task -->
												<button style="cursor: pointer; color: white;" class="btn btn-xs btn-success complete"
													data-task_complete="<?php echo $task->id;?>"
													data-toggle="modal" data-target="#exampleModal"
													<?php echo $task->processing_by==$_SESSION['super_admin']['employee_ids'] ? '' : 'disabled'; ?>
													>
													<i class="fas fa-check-double"></i>
												</button>
												<!-- Button trigger modal for veiw -->
												<a href="#" data-task_info="<?php echo $task->id; ?>" class="btn btn-xs btn-warning task_veiw" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye"></i></a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- table 3 -->
				<div class="col-sm-4">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Task list (Completed)</h3>
						</div>
						<div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
							<table class="table table-striped table-bordered table-sm small" id="myTable">
								<thead>
									<tr>
										<th>SL</th>
										<th>Title</th>
									    <th>Assigned By</th>
									    <th>Completed By</th>
									    <th>Completed At</th>
									    <th>Action</th>
									</tr>
								</thead>
                                
								<tbody id='tdata'>
									<?php foreach($task_complete as $key=>$task): ?>
										<tr>
											 <td><?php echo $key+1; ?></td>
											 <td class="text-truncate" style="max-width: 150px;"><?php echo $task->title; ?></td>
											 <td><?php echo $task->emp_name_by; ?></td>
											 <td><?php echo $task->emp_name_com; ?></td>
											 <?php
												$phpdate = strtotime( $task->completed_at );
												$mysqldate = date( 'd M Y', $phpdate );
											?>
											 <td><?php echo $mysqldate ?></td>
											 
											<td class="d-flex">
												<!-- Button trigger modal for veiw -->
												<a href="#" data-task_info="<?php echo $task->id; ?>" class="btn btn-xs btn-warning task_veiw" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-eye"></i></a>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
                                    
							</table>
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>



<!-- Veiw Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Task Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="task_item">
        ...
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- Add Task Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Add New Task</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form role="form" action="<?=current_url(); ?>" method="POST" id="myform" enctype="multipart/form-data">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
								<?php if ($_SESSION['user_info']['department']=='749568347163692080'): ?>
									<label>Assinged To</label>
									<select class="form-control" id="employee_id" name="employee_id">
										<option selected value="">Choose...</option>
										<?php foreach($result as $r): ?>
										<option value="<?php echo $r->employee_id; ?>"><?php echo $r->full_name; ?></option>
										<?php endforeach ?>
									</select>
								<?php endif; if($dep_head->d_head ==1 && $_SESSION['user_info']['department']!='749568347163692080'): ?>
									<label>Assinged To</label>
									<select class="form-control" id="employee_id" name="employee_id">
										<option selected value="">Choose...</option>
										<?php foreach($emp_list as $r): ?>
										<option value="<?php echo $r->employee_id; ?>"><?php echo $r->full_name; ?></option>
										<?php endforeach ?>
									</select>
								<?php endif;?>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label>Task Title<span class="text-danger">*</span> </label>
									<input id="title" name="title" value="" type="text" class=" form-control" required>
									<span class="text-danger"><?php echo form_error('title');?> </span>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label>Task Description<span class="text-danger">*</span> </label>
									<textarea name="description" id="description" class="form-control" cols="30" rows="5" required></textarea>
									<span class="text-danger"><?php echo form_error('description');?> </span>
								</div>
							</div>
							<div class="row align-items-center ml-2">
								<label for="rate" class="pt-2 mr-2">Task Priority :<span class="text-danger">*</span></label>
								<div class="rate">
									<input type="radio" id="star5" name="rate" value="5" required/>
									<label for="star5" title="text">5 stars</label>
									<input type="radio" id="star4" name="rate" value="4" />
									<label for="star4" title="text">4 stars</label>
									<input type="radio" id="star3" name="rate" value="3" />
									<label for="star3" title="text">3 stars</label>
									<input type="radio" id="star2" name="rate" value="2" />
									<label for="star2" title="text">2 stars</label>
									<input type="radio" id="star1" name="rate" value="1" />
									<label for="star1" title="text">1 star</label>
								</div>
							</div>
							<div class="col-sm-12">
								<label for="deadline">Task Deadline <small class="text-danger">(optional)</small> :  </label>
								<input type='date' id='deadline' name='deadline' min='<?= date("Y-m-d"); ?>'>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label>Task Image </label>
									<div class="input-group mb-3">
										<label class="input-group-text" for="inputGroupFile01">Upload</label>
										<input type="file" class="form-control" id="image" name="image">
									</div>
									<span class="text-danger"><?php echo form_error('description');?> </span>
								</div>
							</div>     
						</div>								
					</div>
					<div class="card-footer bg-white">
						<input type="hidden" name="save" value="save">
						<button type="submit" id="button" name="save" value="save" class="btn btn-primary btn-small btn-block">Save</button>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit/Confirmation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="edit_form">
        ...
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function(){
		// $('#myTable').DataTable();

	//  for submit form with ajax
	$("#myform").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        	url: "<?=current_url(); ?>",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result)
		    {
				$("#myform")[0].reset();
				window.location.reload();
		    },
		  	error: function() 
	    	{
				window.location.reload();
	    	} 	        
	   	});
	}));


	//  view page with modal
	$(document).on('click', ".task_veiw", function(e){
		e.preventDefault();
		var task_info = $(this).data("task_info");
		$.ajax({
			url: "<?php echo base_url("admin/s_it/task-detail"); ?>",
			method: "POST",
			dataType: "HTML",
			data: {"task_info": task_info},
			success: function(data){
				$("#task_item").html(data);
			}
			
		})
	});

	//  task edit page with modal
	$(document).on('click', ".task_edit", function(e){
		e.preventDefault();
		var task_edit = $(this).data("task_edit");
		$.ajax({
			url: "<?php echo base_url("admin/s_it/tasks"); ?>",
			method: "POST",
			dataType: "HTML",
			data: {"task_edit": task_edit},
			success: function(data){
				$("#edit_form").html(data);
			}
			
		})
	});

	//  task accept page with modal
	$(document).on('click', ".accept", function(e){
		e.preventDefault();
		var task_accept = $(this).data("task_accept");
		$.ajax({
			url: "<?php echo base_url("admin/s_it/tasks"); ?>",
			method: "POST",
			dataType: "HTML",
			data: {"task_accept_id": task_accept},
			success: function(data){
				$("#edit_form").html(data);
			}
			
		})
	});

	//  task complete page with modal
	$(document).on('click', ".complete", function(e){
		e.preventDefault();
		var task_complete = $(this).data("task_complete");
		$.ajax({
			url: "<?php echo base_url("admin/s_it/tasks"); ?>",
			method: "POST",
			dataType: "HTML",
			data: {"task_complete_id": task_complete},
			success: function(data){
				$("#task_item").html(data);
			}
			
		})

	});

	// timer for task period
	$(".demo").each(function(index){
		var obj=$(this);
		var countDownDate=new Date(obj.data('val')).getTime();
		var x=setInterval(function(obj,countDownDate){
			var now=new Date().getTime();
			var distance=countDownDate-now;
			// If the count down is over 
			if (distance<0){
				// clearInterval(x);
				// obj.text("EXPIRED");
				
				// Time calculations for days, hours, minutes and seconds
				var dist=now-countDownDate;
				var days = Math.floor(dist / (1000 * 60 * 60 * 24));
				var hours = Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((dist % (1000 * 60)) / 1000);
				obj.text('-'+days+"d "+hours+"h "+minutes+"m "+seconds+"s ");
			}else{
				// Time calculations for days, hours, minutes and seconds
				var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				obj.text(days+"d "+hours+"h "+minutes+"m "+seconds+"s ");
			}
		}, 1000,obj,countDownDate);
	});

  });

</script>