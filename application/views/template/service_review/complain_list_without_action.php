<style>


.nav-tabs .nav-item .nav-link.active {
  color: #0080FF;
}

</style>
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
		  <!--
            <h1 class="m-0 text-dark">Complain List</h1>
			-->
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
				
				
				<div class="col-sm-10 offset-sm-1">
					<div class="card card-info">
						<div class="card-header">
						
							<h3 class="card-title">Complain list</h3>
							
						</div>
						<div class="card-body">
							<div id='counting'></div>
							<ul class="nav nav-pills" id="complain_tab" role="tablist">
							  <li class="nav-item">
								<a class="nav-link active btn btn-default" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">Pending</a>
							  </li><br>
							  <li class="nav-item">
								<a class="nav-link btn btn-default" id="ongoing-tab" data-toggle="tab" href="#ongoing" role="tab" aria-controls="ongoing" aria-selected="false">Ongoing</a>
							  </li><br>
							  <li class="nav-item">
								<a class="nav-link btn btn-default" id="fixed-tab" data-toggle="tab" href="#fixed" role="tab" aria-controls="fixed" aria-selected="false">Fixed</a>
							  </li>
							</ul><br>
							<div class="tab-content" id="complain_tabContent">
							<?php 
							$department = $_SESSION['user_info']['department'];
							$pending_sql = $this->db->query("SELECT complain.id, complain.created_at, complain.note, complain.status, department.department_name, complain_category.name, MEMBER_DIRECTORY.BRANCH_NAME, MEMBER_DIRECTORY.FLOOR_NAME,
							MEMBER_DIRECTORY.FULL_NAME, MEMBER_DIRECTORY.PHONE_NUMBER, MEMBER_DIRECTORY.ROOM_NAME, MEMBER_DIRECTORY.BED_NAME
							FROM `complain` 
							left join complain_category on complain_category.id=complain.category_id 
							left join department on complain_category.department_id=department.department_id
							INNER JOIN MEMBER_DIRECTORY ON MEMBER_DIRECTORY.ID = COMPLAIN.MEMBER_DIRECTORY_ID
							where complain.status='1'
							  and member_directory.status='1' group by complain.id
							");
							$pending = $pending_sql->result();
							
							?>
							  <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
								<table class="table text-center display table-sm table-bordered table-striped" id="table_pending">
									<thead>
										<tr>
											<th>Id</th>
											<th>Department</th>
											<th>Complain Category</th>
											<th>Note</th>
											<th>Pending time</th>
											<th>Person Info</th>
										   
										</tr>
									</thead>
									
									<tbody>
										<?php foreach($pending as $key=>$single){ ?>
											<tr >
												 <td><?php echo $key+1; ?></td>
												 <td><?php echo $single->department_name; ?></td>
												 <td><?php echo $single->name; ?></td>
												 <td><?php echo $single->note; ?></td>
												 <td class="row_seq pending_time" id="row_<?php echo $single->id; ?>" data-row_id="<?php echo $single->id; ?>"></td>
												 <td>
													<b>Name: </b><?php echo $single->FULL_NAME; ?><br>
													<b>Phone: </b><?php echo $single->PHONE_NUMBER; ?><br>
													<b>Branch: </b><?php echo $single->BRANCH_NAME; ?><br>
													<b>Floor: </b><?php echo $single->FLOOR_NAME; ?><br>
													<b>Room: </b><?php echo $single->ROOM_NAME; ?><br>
													<b>Bed: </b><?php echo $single->BED_NAME; ?>
												</td>
											</tr>
										<?php } ?>
									</tbody>
										
								</table>
							  </div>
							  <div class="tab-pane fade" id="ongoing" role="tabpanel" aria-labelledby="ongoing-tab">
								<?php 
								$ongoing_sql = $this->db->query("SELECT complain.id, complain.created_at, complain.note, complain.status, department.department_name, complain_category.name,  MEMBER_DIRECTORY.BRANCH_NAME, MEMBER_DIRECTORY.FLOOR_NAME,
								MEMBER_DIRECTORY.FULL_NAME, MEMBER_DIRECTORY.PHONE_NUMBER, MEMBER_DIRECTORY.ROOM_NAME, MEMBER_DIRECTORY.BED_NAME
							
								FROM `complain` 
								left join complain_category on complain_category.id=complain.category_id 
								left join department on complain_category.department_id=department.department_id
								INNER JOIN MEMBER_DIRECTORY ON MEMBER_DIRECTORY.ID = COMPLAIN.MEMBER_DIRECTORY_ID
								where complain.status='2' and complain.ongoing_from is not null
								  and member_directory.status='1' group by complain.id
								");
								$ongoing = $ongoing_sql->result();
								
								?>
								  <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
									<table class="table text-center display table-sm table-bordered table-striped" id="table_ongoing">
										<thead>
											<tr>
												<th>Id</th>
												<th>Department</th>
												<th>Complain Category</th>
												<th>Note</th>
												<th>Ongoing time</th>
												<th>Person Info</th>
											   
											</tr>
										</thead>
										
										<tbody>
											<?php foreach($ongoing as $key=>$single){ ?>
												<tr >
													 <td><?php echo $key+1; ?></td>
													 <td><?php echo $single->department_name; ?></td>
													 <td><?php echo $single->name; ?></td>
													 <td><?php echo $single->note; ?></td>
													 <td class="row_seq ongoing_time" id="row_<?php echo $single->id; ?>" data-row_id="<?php echo $single->id; ?>"></td>
													 <td>
														<b>Name: </b><?php echo $single->FULL_NAME; ?><br>
														<b>Phone: </b><?php echo $single->PHONE_NUMBER; ?><br>
														<b>Branch: </b><?php echo $single->BRANCH_NAME; ?><br>
														<b>Floor: </b><?php echo $single->FLOOR_NAME; ?><br>
														<b>Room: </b><?php echo $single->ROOM_NAME; ?><br>
														<b>Bed: </b><?php echo $single->BED_NAME; ?>
													</td>
												</tr>
											<?php } ?>
										</tbody>
											
									</table>
								</div>
							  </div>
							  <div class="tab-pane fade" id="fixed" role="tabpanel" aria-labelledby="fixed-tab">
								<?php 
								$fixed_sql = $this->db->query("SELECT complain.id, complain.created_at,complain.finished_at, complain.note, complain.status, department.department_name, complain_category.name,MEMBER_DIRECTORY.BRANCH_NAME, MEMBER_DIRECTORY.FLOOR_NAME,
								MEMBER_DIRECTORY.FULL_NAME, MEMBER_DIRECTORY.PHONE_NUMBER, MEMBER_DIRECTORY.ROOM_NAME, MEMBER_DIRECTORY.BED_NAME
								
								FROM `complain` left join complain_category on complain_category.id=complain.category_id 
								left join department on complain_category.department_id=department.department_id
								INNER JOIN MEMBER_DIRECTORY ON MEMBER_DIRECTORY.ID = COMPLAIN.MEMBER_DIRECTORY_ID
								where complain.status='0'
								  and member_directory.status='1' group by complain.id
								");
								$fixed = $fixed_sql->result();
								?>
								  <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
									<table class="table text-center display table-sm table-bordered table-striped" id="table_fixed">
										<thead>
											<tr>
												<th>Id</th>
												<th>Department</th>
												<th>Complain Category</th>
												<th>Note</th>
												<th>Duration</th>
												<th>Person Info</th>
											   
											</tr>
										</thead>
										
										<tbody>
											<?php foreach($fixed as $key=>$single){ ?>
												<tr data-id="<?php echo $single->id; ?>">
													 <td><?php echo $key+1; ?></td>
													 <td><?php echo $single->department_name; ?></td>
													 <td><?php echo $single->name; ?></td>
													 <td><?php echo $single->note; ?></td>
													 <!--
													 <td><?php echo date("d-m-Y", $single->created_at); ?></td>
													 -->
													 <td><?php 
														$diff = $single->finished_at - $single->created_at;
														$days = (int)($diff/86400);
														$left_secs = $diff % 86400;
														$hours = (int) ($left_secs / 3600);
														$left_secs = $left_secs % 3600;
														$mins = (int) ($left_secs / 60);
														$secs = $left_secs % 60;
														echo "$days Days : $hours Hours : $mins Minutes : $secs Seconds";
													 ?></td>
													
													<td>
														<b>Name: </b><?php echo $single->FULL_NAME; ?><br>
														<b>Phone: </b><?php echo $single->PHONE_NUMBER; ?><br>
														<b>Branch: </b><?php echo $single->BRANCH_NAME; ?><br>
														<b>Floor: </b><?php echo $single->FLOOR_NAME; ?><br>
														<b>Room: </b><?php echo $single->ROOM_NAME; ?><br>
														<b>Bed: </b><?php echo $single->BED_NAME; ?>
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
	</div>
</div>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="complain_view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Complain details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="complain_imgs">
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Ok</button>
      </div>
    </div>
  </div>
</div>



<?php $length = count($pending)+count($ongoing);?>
<script>
  $(document).ready(function(){
	  
	$('#table_pending').DataTable();
	$('#table_ongoing').DataTable();
	$('#table_fixed').DataTable();
	$(document).on('click', '.delete_complain', function(e){
	  
	  e.preventDefault();
	  var id = $(this).data('id');
	  if(confirm('Are you want to delete this?'))
	  {
			   $.ajax({
					url: "<?=base_url('admin/create/complain/complain-list'); ?>",

					type:"post",
					data:{'delete_id':id},
					dataType:"html",
					success:function(data) {
					  window.location.reload();
					},
						
			});

	  }
	  
	});
	  
	   $(document).on('click', '.ongoing_complain', function(e){
          //alert("tets");
          e.preventDefault();
          var id = $(this).data('id');
          if(confirm('Are you want to update status to ongoing ?'))
          {
                   $.ajax({
                        url: "<?=base_url('admin/create/complain/complain-list'); ?>",

						type:"post",
						data:{'ongoing_id':id},
						dataType:"html",
						success:function(data) {
						  window.location.reload();
						},
                            
                });

          }
          
      });
	  
	   $(document).on('click', '.fixed_complain', function(e){
          //alert("tets");
          e.preventDefault();
          var id = $(this).data('id');
          if(confirm('Are you want to update status to fixed ?'))
          {
                   $.ajax({
                        url: "<?=base_url('admin/create/complain/complain-list'); ?>",

						type:"post",
						data:{'fixed_id':id},
						dataType:"html",
						success:function(data) {
						  window.location.reload();
						},
                            
                });

          }
          
      });
	  
	  $(document).on('click', '.return_fixed', function(e){
          //alert("tets");
          e.preventDefault();
          var id = $(this).data('id');
          if(confirm('Are you want to update status to fixed ?'))
          {
                   $.ajax({
                        url: "<?=base_url('admin/create/complain/complain-list'); ?>",

						type:"post",
						data:{'return_fixed_id':id},
						dataType:"html",
						success:function(data) {
						  window.location.reload();
						},
                            
                });

          }
          
      });
	  
	  $(document).on('click', '.return_pending', function(e){
          //alert("tets");
          e.preventDefault();
          var id = $(this).data('id');
          if(confirm('Are you want to update status to fixed ?'))
          {
                   $.ajax({
                        url: "<?=base_url('admin/create/complain/complain-list'); ?>",

						type:"post",
						data:{'return_pending_id':id},
						dataType:"html",
						success:function(data) {
						  window.location.reload();
						},
                            
                });

          }
          
      });
	  
	  $(document).on('click', '.complain_details', function(e){
          e.preventDefault();
		  var clicked_id = $(this).data('id');
		  //console.log(clicked_id);
          
          if(clicked_id)
          {
			   $.ajax({
					url: "<?=base_url('admin/create/complain/complain-details'); ?>",

					type:"post",
					data:{'row_id':clicked_id},
					dataType:"html",
					success:function(data) {
					  $("#complain_imgs").html(data);
					},
						
			});

          }
          
      });
	  
	  
	  var current_time = "<?php echo time(); ?>";
	  var row_seq = $(".row_seq");
	  for(var i=0; i < row_seq.length; i++){
		var row_id = $(".row_seq").eq(i).data('row_id');
		
		$.ajax({
			url: "<?=base_url('admin/create/complain/get_start_time'); ?>",
			type:"POST",
			data:{'row_id':row_id},
			dataType:"JSON",
			success:function(data) {
				if(data.ongoing_from){
					var elapse_time =  current_time - data.ongoing_from;
				}else{
					var elapse_time =  current_time - data.created_at;
				}
				$("#row_"+data.row_id).text(toReadableString(elapse_time));
			},		
		});
	  }
	  
	
	function toReadableString(time) {
	  var days = parseInt(time / 86400);
	  var left_secs = time % 86400;
	  var hours = parseInt(left_secs / 3600);
	  var left_secs = left_secs % 3600;
	  var mins = parseInt(left_secs / 60);
	  var secs = left_secs % 60;
	  return days+" Days : "+hours+" Hours : "+mins+" Minutes : "+secs+" Seconds";
	}
	
	 

  });
 
</script>