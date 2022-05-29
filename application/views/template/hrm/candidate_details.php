<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">All Circular in ( <?php echo $cicular->job_title; ?> ) post</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">All Circular in ( <?php echo $cicular->job_title; ?> ) post</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
       
           <div class="row justify-content-center"> 
             
              <div class="col-md-10">
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Circular Details</h3> 
                  </div>
                
                <div class="card-body">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">All</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Short Lists</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Interview</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-done" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Final Interview</a>
                  </li>

                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-investor" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Observation</a>
                  </li>
                </ul><br> 
                
                <div class="tab-content" id="custom-tabs-four-tabContent">
                   <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                   <form role="form" action="<?=base_url('admin/make_short'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                     <input type="hidden" name="apply_id" value="<?php echo $cicular->id; ?>">
                     <div class="row full_video_content">
                     
                       <?php foreach($job_applications as $row): ?>
                        <?php 
                            $videos = $this->Dashboard_model->mysqlii("SELECT * FROM apply_videos WHERE video_random_id='$row->random_id'");
                            $one = $this->Dashboard_model->mysqlij("SELECT * FROM apply_videos WHERE video_random_id='$row->random_id' ORDER BY id ASC LIMIT 1");
                         ?>
                       <div class="col-md-3" id="source_data_<?php echo $row->id; ?>">
                         
                        <div class="card card_content" style="width: 26.5rem; margin: 5px auto;">
                          <?php if($one): ?>
                            <video style="height: 250px;" class="video_src" src="<?=base_url('/'.$one->video); ?>" controls></video>
                          <?php else: ?>
                            <video style="height: 250px;" class="video_src" src="<?=base_url('/'.$row->video_cv); ?>" controls></video>
                          <?php endif; ?> 
                              <div class="card-body">
                              <?php foreach($videos as $key=>$video_data): ?>
                           <a style="cursor: pointer; color: white;" class="btn btn-primary btn-sm source_video" data-id="<?php echo $video_data->id; ?>"><?php echo $key+1; ?></a>
                         <?php endforeach; ?><br><br>
                                 <h5 class="card-title">Phone: <?php echo $row->phone; ?></h5><br>
                                 <button type="button" class="btn btn-success view_image" data-id="<?php echo $row->id; ?>">View</button><br><br>
                                 <a href="<?php echo $row->portfolio_link; ?>" class="btn btn-primary" target="__blank">See Portfolio</a><br><br>
                                 <textarea onfocusout=save_remarks(<?= $row->id; ?>) class="form-control" name="remarks[<?php echo $row->id; ?>]"><?php echo $row->remarks; ?></textarea><br>
                                 <input style="cursor: pointer;" type="checkbox" class="selected_short" name="select_short[]" id="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" data-id="<?php echo $row->id; ?>">
                                 <label for="<?php echo $row->id; ?>">Select to short list</label>
                              </div>
                         </div>

                         
                       </div>
                       
                      <?php endforeach; ?> 
                      
                     </div>
                     <button style="position: fixed; right:50px; top: 700px; display: none;" type="submit" class="btn btn-sm" id="next_short"><img style="width: 60px; height: 60px;" src="<?=base_url('/'."images/inr.png"); ?>"></button>
                       </form>
                   </div> 

                   <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                   <form role="form" action="<?=base_url('admin/make_interview'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                     <input type="hidden" name="circular_id" value="<?php echo $cicular->id; ?>">
                      <table class="table table-bordered table-striped" id="candidate_details_4">
                        <thead>
                          <tr>
                            <th>Select For Interview</th>                            
                            <th>Phone</th>
                            <th>First Remarks</th>
                            <th>Remarks</th>
                            <th>Action</th>                         
                          </tr>
                        </thead>
                        <tbody>
                         <?php foreach($short_lists as $key=>$short_list): ?>
                          <tr>
                           
                           <td width="10%"><input type="checkbox" name="call_interview_id[]" value="<?php echo $short_list->id; ?>"></td>                           
                           <td width="20%"><?php echo $short_list->phone; ?></td>
                           <td width="20%"><?php echo $short_list->apply_remarks; ?></td>
                           <?php if($short_list->remarks == NULL): ?>
                            <td width="40%"><textarea class="form-control" name="remarks[<?php echo $short_list->id; ?>]"></textarea></td>
                           <?php else: ?>
                           <td width="40%"><textarea class="form-control" name="remarks[<?php echo $short_list->id; ?>]" readonly><?php echo $short_list->remarks; ?></textarea></td>
                           <?php endif; ?>

                           <td>
                             <button type="button" class="btn btn-primary btn-sm view_image" data-id="<?php echo $short_list->id; ?>">View Image</button>
                             <button type="button" class="btn btn-primary btn-sm view_videos" data-id="<?php echo $short_list->id; ?>">View Videos</button>
                           </td>
                          </tr>
                         <?php endforeach; ?>
                        </tbody>
                      </table>
                      <button type="submit" class="btn btn-success make_short">Call For Interview</button>
                      </form>
                   </div>

                   <div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                   <form role="form" action="<?=base_url('admin/make_final_interview'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                     <input type="hidden" name="circular_id" value="<?php echo $cicular->id; ?>">
                      <table class="table table-bordered table-striped" id="candidate_details_5">
                        <thead>
                          <tr>
                            <th>Select For Final Interview</th>
                            <th>Phone</th>
   
                           <th>Mark</th>
      
                           <th>Expected Salary</th>
                           <th>Short List Marks</th>
                           <th>Remarks</th>
                           <th>Action</th>
                          </tr>
                        </thead>
                        <tbody class="conts_int">
                         <?php foreach($interviews as $key=>$interview): ?>
                          <tr>
                           
                           <td width="10%"><input type="checkbox" id="source_cart_<?php echo $interview->id; ?>" class="ovs_id" name="call_final_interview_id[]" value="<?php echo $interview->id; ?>"></td>
  
                           <td width="12%"><?php echo $interview->phone; ?></td>

                           <td width="14%"><input type="radio" name="mark[<?php echo $interview->id; ?>]" value="1" <?php if($interview->marks == 1){echo "checked";} ?>><label style="cursor: pointer; margin-left: 2px;">1</label> <input  type="radio" name="mark[<?php echo $interview->id; ?>]" value="2" <?php if($interview->marks == 2){echo "checked";} ?>><label  style="cursor: pointer; margin-left: 2px;">2</label> <input  type="radio" name="mark[<?php echo $interview->id; ?>]" value="3" <?php if($interview->marks == 3){echo "checked";} ?>><label  style="cursor: pointer; margin-left: 2px;">3</label> <input  type="radio" name="mark[<?php echo $interview->id; ?>]" value="4" <?php if($interview->marks == 4){echo "checked";} ?>><label  style="cursor: pointer; margin-left: 2px;">4</label> <input  type="radio" name="mark[<?php echo $interview->id; ?>]" value="5" <?php if($interview->marks == 5){echo "checked";} ?>><label  style="cursor: pointer; margin-left: 2px;">5</label></td>
                           
                          
                           <td width="15%"><input type="number" class="form-control" id="expected_<?php echo $interview->id; ?>" name="expected_salary[<?php echo $interview->id ?>]" readonly value="<?php echo $interview->expected_salary; ?>"></td>
                            
                           <td><?php echo $interview->short_remarks; ?></td>

                           <?php if($interview->first_interview_remarks == NULL): ?>
                             <td width="25%;"><textarea class="form-control" name="first_interview_remarks[<?php echo $interview->id; ?>]"></textarea></td>
                           <?php else: ?>
                            <td width="25%"><textarea class="form-control" name="first_interview_remarks[<?php echo $interview->id; ?>]" readonly><?php echo $interview->first_interview_remarks; ?></textarea></td>
                            <?php endif; ?>
                            <td>
                             <button type="button" class="btn btn-primary btn-sm view_image" data-id="<?php echo $interview->id; ?>">View Image</button>
                             <button type="button" class="btn btn-primary btn-sm view_videos" data-id="<?php echo $interview->id; ?>">View Videos</button>
                           </td>
                          </tr>
                         <?php endforeach; ?>
                        </tbody>
                      </table>
                      <button type="submit" class="btn btn-success make_short">Call For Final Interview</button>
                      </form>
                   </div>
                     
                   <div class="tab-pane fade" id="custom-tabs-four-done" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                      <form role="form" action="<?=base_url('admin/make_observation'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                         <input type="hidden" name="circular_id" value="<?php echo $cicular->id; ?>">
                        <table class="table table-bordered table-striped" id="candidate_details_9">
                           <thead>
                             <tr>
                               <th>Select For Observation</th>
                               <th>Phone</th>
                               <th>Mark</th>
                               <th>Expected Salary</th>
                               <th>Action</th>
                               <th>First Interview Remarks</th>
                               <th>Remarks</th>
                               <th>Action</th>
                             </tr>
                           </thead>
                           <tbody>
                             <?php foreach($primary_interviews as $primary_interview): ?>
                             <tr id="<?php echo $primary_interview->id; ?>">
                               <td width="10%"><input type="checkbox" name="call_observation_id[]" value="<?php echo $primary_interview->id; ?>"></td>
    
                               <td width="15%"><?php echo $primary_interview->phone; ?></td>
  
                               <?php if($primary_interview->marks == 1): ?>
                                 <td width="10%"><i class="fas fa-star"></i></td>
                                <?php elseif($primary_interview->marks == 2): ?>
                                  <td width="10%"><i class="fas fa-star"></i> <i class="fas fa-star"></i></td>
                                <?php elseif($primary_interview->marks == 3): ?>
                                  <td width="10%"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></td>
                                <?php elseif($primary_interview->marks == 4): ?>
                                  <td width="10%"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></td>
                                <?php elseif($primary_interview->marks == 5): ?>
                                  <td width="10%"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></td>
                                <?php endif; ?>
                                <td width="10%"><?php echo $primary_interview->expected_salary; ?></td>
                                <td width="10%">
                                  <a style="cursor: pointer; color: white;" class="btn btn-primary btn-sm back_primary" data-id="<?php echo $primary_interview->id; ?>">Back</a>
                                </td>
                                <td width="10%"><?php echo $primary_interview->first_interview_remarks; ?></td>
                                <?php if($primary_interview->second_interview_remarks == NULL): ?>
                                <td width="15%">
                                  <textarea class="form-control" name="second_interview_remarks[<?php echo $primary_interview->id; ?>]"></textarea>
                                </td>
                                <?php else: ?>
                                  <td width="15%">
                                  <textarea class="form-control" name="second_interview_remarks[<?php echo $primary_interview->id; ?>]" readonly><?php echo $primary_interview->second_interview_remarks; ?></textarea>
                                </td>
                                <?php endif; ?>
                                <td width="10%">
                             <button type="button" class="btn btn-primary btn-sm view_image" data-id="<?php echo $primary_interview->id; ?>">View Image</button>
                             <button type="button" class="btn btn-primary btn-sm view_videos" data-id="<?php echo $primary_interview->id; ?>">View Videos</button>
                           </td>
                             </tr>
                             <?php endforeach; ?>
                           </tbody>
                         </table>
                      <button type="submit" class="btn btn-success">Call For Observation</button>
                   </form>
                  </div>

                   <div class="tab-pane fade" id="custom-tabs-four-investor" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                     <form role="form" action="<?=base_url('admin/make_final'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                        <input type="hidden" name="circular_id" value="<?php echo $cicular->id; ?>">
                         <table class="table table-bordered table-striped" id="candidate_details_6">
                           <thead>
                             <tr>
                               <th>Final Selection</th>
                               <th>Phone</th>
                               <th>Mark Obtained</th>
                               <th>Is Selected?</th>
                               <th>Expected Salary</th>
                                <th>Action</th>
                             </tr>
                           </thead>
                           <tbody>
                             <?php foreach($observations as $ovs): ?>
                             <tr>
                               <td width="10%"><input type="checkbox"  name="selected_id[]" value="<?php echo $ovs->id;?>"></td>
                               <td width="15%"><?php echo $ovs->phone; ?></td>
    
                               <?php if($ovs->marks == 1): ?>
                                 <td width="10%"><i class="fas fa-star"></i></td>
                                <?php elseif($ovs->marks == 2): ?>
                                  <td width="10%"><i class="fas fa-star"></i> <i class="fas fa-star"></i></td>
                                <?php elseif($ovs->marks == 3): ?>
                                  <td width="10%"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></td>
                                <?php elseif($ovs->marks == 4): ?>
                                  <td width="10%"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></td>
                                <?php elseif($ovs->marks == 5): ?>
                                  <td width="10%"><i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i></td>
                                <?php endif; ?>
                                <?php if($ovs->select_status == 1): ?>
                                <td width="10%">
                                  Selected
                                </td>
                                <?php else: ?>
                                  <td width="10%">Not Selected Yet</td>
                                <?php endif; ?>
                                <td width="10%">
                                  <input type="number" class="form-control" name="expected_salary[<?php echo $ovs->id; ?>]" value="<?php echo $ovs->expected_salary; ?>" readonly>
                                </td>
                                
                                <td>
                             <button type="button" class="btn btn-primary btn-sm view_image" data-id="<?php echo $ovs->id; ?>">View Image</button>
                             <button type="button" class="btn btn-primary btn-sm view_videos" data-id="<?php echo $ovs->id; ?>">View Videos</button>
                           </td>
                             </tr>
                             <?php endforeach; ?>
                           </tbody>
                         </table>
                         <button type="submit" class="btn btn-success">Final Selection</button>
                     </form>
                   </div>
                </div>
                
               
                </div>
                  </div>
                
              
              </div>
            
           </div>
        </div>
    </div>
</div>



<div class="modal fade" id="employee-overview">
 
	<div class="modal-dialog modal-lg" style="min-width:80%;">
		<div class="modal-content">
			
				<div class="modal-header btn-primary">
					<div class="row" style="width:100%;">
						<div class="col-md-6"><h3>Candidate Upload Images</h3></div>
            <div class="col-md-6"><a style="float: right; color: white;"  class="btn btn-danger close_modal_video">X</a></div>
					</div>				
				</div>
				<div class="modal-body set_height" id="employee_over_view_body" style="overflow-y:scroll;">
          <div class="container-fluid"> 
            <div class="row content_body">
               
                 
              </div>
            </div>
             
          </div>
				</div>
				<script>
				$(document).ready(function(){
					var w__height = $(window).height();
					var set_mode_over_view_height = w__height - 300;
					$(".set_height").height(set_mode_over_view_height);
				})
				</script>
			
		</div>
	</div>


  <div class="modal fade" id="employee-overview-video">
 
	<div class="modal-dialog modal-lg" style="min-width:80%;">
		<div class="modal-content">
			
				<div class="modal-header btn-primary">
					<div class="row" style="width:100%;">
						<div class="col-md-6"><h3>Candidate Uploaded Videos</h3></div>
            <div class="col-md-6"><a style="float: right; color: white;"  class="btn btn-danger close_modal">X</a></div>
					</div>				
				</div>
				<div class="modal-body set_height" id="employee_over_view_body" style="overflow-y:scroll;">
          <div class="container-fluid"> 
            <div class="row content_body_video">
               
                 
              </div>
            </div>
             
          </div>
				</div>
				<script>
				$(document).ready(function(){
					var w__height = $(window).height();
					var set_mode_over_view_height = w__height - 300;
					$(".set_height").height(set_mode_over_view_height);
				})
				</script>
			
		</div>
	</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    $(".ovs_id").click(function(){
        var selectedCountry = new Array();
       
        var id = $(this).val();
    
        var check = $(this).is(":checked");
        
        if(check == true)
        {
           $("#expected_"+id).removeAttr('readonly');
        }
        else if(check == false)
        {
          $("#expected_"+id).attr('readonly', true);
         
        }
         
    });

    $(document).on('click','.selected_short', function(){
          var id = $(this).data('id');
          let selected = false;
          $('input:checkbox[class=selected_short]').each(function() 
          {    
              
             if($(this).is(':checked')){
                $('#next_short').show(); 
                selected = true;
             }
               
          });
          if(!selected){
            $('#next_short').hide(); 
          }
          
    });

    $(document).on('click', '.view_image', function(){
        var id = $(this).data('id');
        $('#employee-overview').modal('show');
        $.ajax({
              url: "<?=base_url('admin/view_candidate_images/'); ?>"+id, 

              type:"GET",
              //data:{'id':id},
              dataType:"html",
              success:function(data) {
               
                
                $(".content_body").html(data);
                //alert(data);
              },
                              
          });
    });

    $(document).on('click','.close_modal', function(){
      $('#employee-overview').modal('hide');
    });

    $(document).on('click','.close_modal_video', function(){
       $("#employee-overview-video").modal('hide');
    });

    $(document).on('click', '.source_video', function(){
        var id = $(this).data('id');
        $.ajax({
              url: "<?=base_url('admin/source_video/'); ?>"+id, 

              type:"GET",
              //data:{'id':id},
              dataType:"html",
              success:function(data) {
                 $('.full_video_content').html(data);
              },
                              
          });
    });

    $(document).on('click', '.back_primary', function(){
       
       var id = $(this).data('id'); 
      
       if(confirm('Are you sure want to move this candidate?'))
       {
          $.ajax({
              url: "<?=base_url('admin/back_primary/'); ?>"+id, 

              type:"GET",
              //data:{'id':id},
              dataType:"html",
              success:function(data) {
                $("#"+id).hide();
                //
                
                $('.conts_int').html(data);
                
                
                //$(".content_body").html(data);
                //alert(data);
              },
                              
          });
       }
       
    });

    


    $(document).on('click', '.view_videos', function(){
      var id = $(this).data('id');
      
      $.ajax({
              url: "<?=base_url('admin/view_video_display/'); ?>"+id, 

              type:"GET",
              //data:{'id':id},
              dataType:"html",
              success:function(data) {
                // $('.full_video_content').html(data);
                if(data == 'no_data')
                {
                    alert('No video found');
                }
                else
                {  
                  $("#employee-overview-video").modal('show');
                  $('.content_body_video').html(data);
                }
                
                
              },
                              
          });
    });
  });

  let save_remarks = (id) => {
    let remark = $(`[name='remarks[${id}]']`).val();
    $.ajax({
      url: "<?=base_url('admin/save_remark/'); ?>"+id, 
      type:"POST",
      data:{id, remark},
      success:function(data) {
        let info = JSON.parse(data);
        if(info.error){
          $(`[name='remarks[${id}]']`).val('');
        }
      },
    });
  }
</script>