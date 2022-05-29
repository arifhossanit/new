

<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Building List</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Building List</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			<div class="row justify-content-center">
        
              <div class="col-md-8">
              <div class="card card-primary">
                  <div class="card-header">
                       <h3 class="card-title">Building List</h3> 
                    </div>
                  
                    <div class="card-body">
                    <table class="table table-bordered table-striped" id="example2">
                    <thead>
                      <tr>
                       <th>SL</th>
                       <th>Owner Name</th>
                       <th>Owner Phone</th>
                       <th>Area</th>
                       <th>Building Floor</th>
                       <th>Building Type</th>
                       <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($buildings as $key=>$row): ?>
                        <tr id="<?php echo $row->id; ?>">
                         <td><?php echo $key+1; ?></td>
                         <td><?php echo $row->owner_name; ?></td>
                         <td><?php echo $row->owner_phone; ?></td>
                         <td><?php echo $row->area; ?></td>
                         <td><?php echo $row->bulding_floor; ?></td>
                         <td><?php echo $row->building_type; ?></td>
                         <td>
                          <a href="<?=base_url('admin/edit_building/'.$row->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                          <!-- <button data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success btn-sm">view</button> -->
                          <button type="button" class="btn btn-success btn-sm view_building" data-id="<?php echo $row->id; ?>">View</button>
                         </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
                    </div>
              </div>
                
                <form style="display:none;" action="<?= base_url("json/store_candidate")?>" method="post" enctype="multipart/form-data">
                  <input type="file" name="video_cv" id="video_cv">
                  <input type="file" name="document_cv" id="video_cv">
                  <button type="submit">Save</button>
                </form>
              </div>
            </div>
        </div>
        <!-- <div class="modal fade bd-example-modal-lg"  id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="buildingOverviewModal">
                  
              </div>
            </div>
          </div>
        </div> -->


        <!----Department model-->
<div class="modal fade" id="employee-overview">
 
	<div class="modal-dialog modal-lg" style="min-width:80%;">
		<div class="modal-content">
			
				<div class="modal-header btn-secondary">
					<div class="row" style="width:100%;">
						<div class="col-md-6"><h3>Building Overview</h3></div>
            <div class="col-md-6"><a style="float: right;" href="" target="__blank" class="btn btn-primary print_building"><i class="fa fa-print" aria-hidden="true"></i></a></div>
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
					var set_mode_over_view_height = w__height - 160;
					$(".set_height").height(set_mode_over_view_height);
				})
				</script>
			
		</div>
	</div>
</div>
<!----End Department model-->

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
     $(document).on('click', '.view_building', function(e){
       e.preventDefault();
       var id = $(this).data('id');
       var url = "<?=base_url('admin/print_building/'); ?>"+id;
       $(".print_building").attr('href', url);
       
      $("#employee-overview").modal('show');
       $.ajax({
                url: "<?=base_url('admin/view_building/'); ?>"+id, 

            type:"GET",
            //data:{'id':id},
            dataType:"html",
            success:function(data) {
               $(".content_body").html(data);
               //alert(data);
            },
                            
        });

     });
  });
</script>