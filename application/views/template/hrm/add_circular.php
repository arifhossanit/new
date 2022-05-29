
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Circular</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Add Circular</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			<div class="row justify-content-center">
              <div class="col-md-8">
                <form role="form" action="<?=base_url('admin/hrm/insert_circular'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Job Title</label> 
                                <input type="text" class="form-control" name="job_title" id="title" placeholder="Job Title" required>  
                            </div>
                       </div>


                       <div class="col-md-6">
                            <div class="form-group">
                                <label for="job_nature">Job Nature</label> 
                                <input type="text" class="form-control" name="job_nature" id="job_nature" placeholder="Job Nature" required>  
                            </div>
                       </div>


                       <div class="col-md-6">
                            <div class="form-group">
                                <label for="salary">Salary</label> 
                                <input type="text" class="form-control" name="salary" id="salary" placeholder="Salary" required>  
                            </div>
                       </div>


                       <div class="col-md-6">
                            <div class="form-group">
                                <label for="job_deadline">Deadline</label> 
                                <input type="date" class="form-control" name="job_deadline" id="job_deadline" placeholder="Deadline" required>  
                            </div>
                       </div>
                       
                       <div class="col-md-6">
                         <div class="form-group">
                            <label for="department_id">Select Department</label>
                            <select class="form-control select2" name="department_id" id="department_id" required>
                               <option value="" selected disabled>Select Department</option>
                               <?php foreach($departments as $department): ?>
                                  <option value="<?php echo $department->id ?>"><?php echo $department->department_name; ?></option>
                               <?php endforeach; ?>
                            </select>
                         </div>
                       </div>


                       <div class="col-md-6">
                         <div class="form-group">
                            <label for="designation_id">Select Desgination</label>
                            <select class="form-control select2" name="designation_id" id="designation_id" required>
                               <option value="" selected disabled>Select Desgination</option>
                               <?php foreach($designations as $designation): ?>
                                  <option value="<?php echo $designation->id ?>"><?php echo $designation->designation_name; ?></option>
                               <?php endforeach; ?>
                            </select>
                         </div>
                       </div>

                       <div class="col-md-12">
                          <div class="form-group">
                             <label for="job_description">Job Description</label>
                             <textarea class="form-control" name="job_description" id="job_description" required></textarea>
                          </div>
                       </div>
                       
                       <div class="col-md-12">
                           <div class="form-group">
                             <input type="submit" name="submit" class="btn btn-success" value="Add">
                           </div>
                       </div>
                   </div>
                </form>
                
              </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script>
CKEDITOR.replace( 'job_description', {
    height: '400px'
});
</script>
