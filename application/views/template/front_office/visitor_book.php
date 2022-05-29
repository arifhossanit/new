<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Visitor Book</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Visitor Book</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Visitor Book</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/fform-data">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" id="generate_id" name="generate_id" class="form-control" value="<?php echo time(); ?>" placeholder="Id Number" readonly/>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" id="name" autocomplete="off" name="name" class="form-control" placeholder="Name" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<input type="number" id="phone" autocomplete="off" name="phone" class="form-control" placeholder="Phone" required />
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<select id="Reason" name="Reason" class="form-control" required>
											<option value="">--Reason--</option>
											<option value="Visitor">Visitor (1)</option>
											<option value="Mobile Visitor">Mobile Visitor (2)</option>
											<option value="Candidate">Candidate (3)</option>
											<option value="Vendor">Vendor (4)</option>											
											<option value="Member Guest">Member Guest (5)</option>
											<option value="Advocate Clients">Advocate Clients (6)</option>
											<!--<option value="Other">Other (7)</option>-->
										</select>
									</div>
								</div>							
							</div>
							<div class="row" id="dipartment_container" style="display:none;">
								<div class="col-sm-3">
									<div class="form-group">
										<select id="department" name="department" class="form-control select2">
											<option value="">--Select Department--</option>											
											<?php
											if(!empty($department)){
												foreach($department as $row){
													echo '<option value="'.$row->department_name.'">'.$row->department_name.'</option>';
												}
											}
											?>										
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<select id="designation" name="designation" class="form-control select2">											
											<option value="">--Select Designation--</option>	
											<?php
											if(!empty($designation)){
												foreach($designation as $row){
													echo '<option value="'.$row->designation_name.'">'.$row->designation_name.'</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>							
							<div class="form-group" style="margin-top:100px;">
								<button type="submit" name="save" class="btn btn-lg btn-success" style="width:100% !important;">
									<i class="far fa-save"></i>
									Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$("#Reason").on("change",function(){
		var can_get = $(this).val();
		if(can_get == 'Candidate'){
			$("#dipartment_container").css({"display":"flex"});
			$('#department').prop('required',true);
			$('#designation').prop('required',true);
		}else{
			$("#dipartment_container").css({"display":"none"});
			$('#department').prop('required',false);
			$('#designation').prop('required',false);
		}
	})
})
</script>