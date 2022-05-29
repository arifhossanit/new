<style>
 .notification_base{
     display: none;
 }
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Select Department</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Add Department</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
            <form role="form" action="<?=base_url('admin/hrm/recruitment/insert_department'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
              <div class="col-md-12">
                  <div class="form-group">
                    <?php foreach($department as $row): ?>
                    <input style="margin-left: 10px;" type="checkbox" name="department[]" id="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" <?php if($row->recruitment == '1'){echo "checked";} ?>>
                    
                    <label style="cursor: pointer;" for="<?php echo $row->id; ?>"><?php echo $row->department_name; ?></label>
                    <?php endforeach; ?>
                  </div>

                  <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-success" value="Add">
                  </div>
              </div>
            </form>
            </div>
        </div>
    </div>
</div> 