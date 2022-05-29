<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">All Circular</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">All Circular</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			<div class="row justify-content-center">
              <div class="col-md-8">
                <table class="table table-bordered table-striped" id="example2">
                    <thead>
                      <tr>
                       <th>SL</th>
                       <th>Job Title</th>
                       <th>Department</th>
                       <th>Designation</th>
                       <th>Job Nature</th>
                       <th>Salary</th>
                       <th>Deadline</th>
                       <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($ciculars as $key=>$row): ?>
                        <tr id="<?php echo $row->id; ?>">
                         <td><?php echo $key+1; ?></td>
                         <td><?php echo $row->job_title; ?></td>
                         <td><?php echo $row->department_name; ?></td>
                         <td><?php echo $row->designation_name; ?></td>
                         <td><?php echo $row->job_nature; ?></td>
                         <td><?php echo $row->salary; ?></td>
                         <td><?php echo $row->job_deadline; ?></td>
               
                         <td>
                         <p id="text_element" style="display:none;">akash vora tara</p>
                          <a href="<?=base_url('admin/hrm/edit_circular/'.$row->id); ?>" class="btn btn-primary btn-sm">Edit</a>
                          <!-- <a style="cursor: pointer; color: white;" class="btn btn-success btn-sm copy_text" id="source_cat_<?php echo $row->id; ?>" onclick="copyToClipboard('text_element')" data-id="<?php //echo $row->id; ?>">Copy Link</a> -->
                          
                          <input style="width: 100px;" class="data_val" type="text" id="source_cat_<?php echo $row->id; ?>" value="<?php echo "https://superhomebd.com/job_apply_form/".$row->id."/".$row->job_title; ?>" readonly>
                          
                          <button type="button" class="btn btn-info btn-sm copy" id="btn_cat_<?php echo $row->id; ?>" data-id="<?php echo $row->id; ?>"><i class="fa fa-clone"></i></button>

                          <a style="cursor: pointer; color: white;" class="btn btn-danger btn-sm delete_circular"  data-id="<?php echo $row->id; ?>">Delete</a>

                          <a href="<?=base_url('admin/hrm/candidate_details/'.$row->id); ?>" class="btn btn-primary btn-sm">All Applicant Info</a>
                         </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                </table>
                <form style="display:none;" action="<?= base_url("json/store_candidate")?>" method="post" enctype="multipart/form-data">
                        <input type="file" name="video_cv" id="video_cv">
                        <input type="file" name="document_cv" id="video_cv">
                        <button type="submit">Save</button>
            </form>
              </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
    //$(".data_val").val('akash_vora_tara');
      $(document).on('click', '.delete_circular', function(e){
          //alert("tets");
          e.preventDefault();
          var id = $(this).data('id');
          if(confirm('Are you want to delete this?'))
          {
                    $.ajax({
                        url: "<?=base_url('admin/hrm/delete_circular/'); ?>"+id,

                    type:"GET",
                    //data:{'id':id},
                    dataType:"html",
                    success:function(data) {
                      window.location.reload();
                    },
                            
                });

          }
          
      });

      // $(document).on('click', '#copyButton', function(){
      //     alert('working');
      // });

      $(document).on('click', '.copy', function(){
          var id = $(this).data('id');
          var val = $("#source_cat_"+id).val();
          $("#source_cat_"+id).select();
         document.execCommand("copy"); 
         $("#btn_cat_"+id).html('copied');
         //alert('Successfully Copied');
      });
  });
  
      function copyToClipboard(elementId) {
        $("#text_element").html('hoga_mara_sara');

        var change_val = $("#text_element").html();
        // Create an auxiliary hidden input
        var aux = document.createElement("input");

        // Get the text from the element passed into the input
        aux.setAttribute("value", document.getElementById(elementId).innerHTML);

        // Append the aux input to the body
        document.body.appendChild(aux);

        // Highlight the content
        aux.select();

        // Execute the copy command
        document.execCommand("copy");

        // Remove the input from the body
        document.body.removeChild(aux);
        // var id = $(copyButton).attr.data("id");
         var id = $('#copyButton').attr("data-id");
        console.log(id);

    }

    function log(){
      console.log('---')
    }

</script>