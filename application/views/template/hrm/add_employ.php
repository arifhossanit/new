<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employees Directory</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Employees Directory</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">	
					<div class="button-group">
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#add-employ" style="float:right;"><i class="fas fa-user-plus"></i> &nbsp;Add Employee</button>
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-department" style="float:right;margin-right:15px;"><i class="fas fa-user-plus"></i> &nbsp;Add Department</button>
						<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#add-designation" style="float:right;margin-right:15px;"><i class="fas fa-user-plus"></i> &nbsp;Add Designation</button>
						<?php /* ?><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-role" style="float:right;margin-right:15px;"><i class="fas fa-user-plus"></i> &nbsp;Add Role</button><?php */ ?>
						<a href="<?=base_url('admin/exit-employee-directory'); ?>" class="btn btn-danger" style="float:right;margin-right:15px;"><i class="fas fa-user-times"></i> &nbsp;Exit Employee</a>
						<a href="<?=base_url('admin/hrm/employee-prebook-request'); ?>" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="far fa-arrow-alt-circle-right"></i> &nbsp;Employee Request</a>
						<button type="button" onclick="return employee_over_view_body()" class="btn btn-secondary" style="float:right;margin-right:15px;"><i class="far fa-list-alt"></i> &nbsp;Employee Overview</button>
						<button type="button" onclick="return employee_over_view_recharge_body()" class="btn btn-primary" style="float:right;margin-right:15px;"><i class="fas fa-file-excel"></i> &nbsp;Export Mobile Recharge List</button>
						<button type="button" onclick="return add_extra_recharge_phone_number_button()" class="btn btn-default" style="float:right;margin-right:15px;"><i class="fas fa-mobile-alt"></i> &nbsp;Add Extra Phone Number</button>
						<?php /* ?><button type="button" class="btn btn-success" style="float:right;margin-right:15px;"><i class="fas fa-chart-line"></i> &nbsp;Promotion / Increament</button><?php */ ?>
					</div>


<?php
if(!empty($edit)){
	$button = '
		<button type="submit" name="update" class="btn btn-warning">Update</button>
		<a href="'.current_url().'" class="btn btn-danger">Close</a>
	';
}else{
	$button = '<button type="submit" onclick="return add_image_employee()" name="add_employ" class="btn btn-info" style="float:right;">Add Employ</button>';
}
?>
<script>
//photo_avater_value_two
function add_image_employee(){
	if($("#photo_avater_value").val() == ''){
		alert('Please choose a employee photo!');
		return false;
	}
}
</script>
					<div class="modal fade" id="add-employ">
						<div class="modal-dialog modal-xl">
							<div class="modal-content">
								<div class="modal-header btn-info">
									<h4 class="modal-title">Write Employee information</h4>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body" style="max-height:845px;overflow-y:scroll;">
								  <!---------------------------------------------------------->
									<div class="card card-primary" >
										<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
											<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
											<div class="card-body" >
												<div class="col-md-12">
													<div class="box box-primary">
														<div class="box-body">
															<div class="tshadow mb25 bozero">
																<h4 class="pagetitleh2" style="text-decoration:underline;">Basic Information </h4>
																<div class="around10">
																	
																	
																	<div class="row">
																		<div class="col-md-4">
																			<div class="form-group">
																				<label>First Name</label><small class="req"> *</small>
																				<input name="f_name" value="<?php if(!empty($adse->f_name)){ echo $adse->f_name; } ?>" placeholder="First Name" type="text" class="form-control" autocomplete="off" required/>
																			</div>
																		</div>

																		<div class="col-md-4">
																			<div class="form-group">
																				<label>Last Name</label><small class="req"> *</small>
																				<input name="l_name" value="<?php if(!empty($adse->l_name)){ echo $adse->l_name; } ?>" placeholder="Last Name" type="text" class="form-control" required/>
																			</div>
																		</div>

																		<div class="col-md-4">
																			<div class="form-group">
																				<label>Religion</label><small class="req"> *</small>
																				<select class="form-control select2" name="religion" autocomplete="off" required>
																					<?php if(!empty($adse->religion)){ echo '<option value="'.$adse->religion.'">'.$adse->religion.'</option>'; } else{ echo '<option value="">Select</option>'; } ?>	
																					<option value="Islam">Islam</option>
																					<option value="Hinduism">Hinduism</option>
																					<option value="Christianity">Christianity</option>
																					<option value="Buddhism">Buddhism</option>
																					<option value="Judaism">Judaism</option> 
																					<option value="Other">Other</option> 
																					<option value="Not Specified">Not Specified</option> 
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-3">
																			<div class="form-group">
																				<label> Gender</label><small class="req"> *</small>
																				<select name="gender" class="form-control select2" name="gender" autocomplete="off" required>
																					<?php if(!empty($adse->gender)){ echo '<option value="'.$adse->gender.'">'.$adse->gender.'</option>'; } else{ echo '<option value="">Select</option>'; } ?>	
																					<option value="Male">Male</option>
																					<option value="Female">Female</option>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Marital Status</label><small class="req"> *</small>
																				<select class="form-control select2" name="marital_status" autocomplete="off" required>
																					<?php if(!empty($adse->marital_status)){ echo '<option value="'.$adse->marital_status.'">'.$adse->marital_status.'</option>'; } else{ echo '<option value="">Select</option>'; } ?>	
																					<option value="Single">Single</option>
																					<option value="Married">Married</option>
																					<option value="Widowed">Widowed</option>
																					<option value="Seperated">Seperated</option>
																					<option value="Not Specified">Not Specified</option> 
																				</select>
																			</div>
																		</div>																		
																		
																		<div class="col-md-3">
																			<div class="form-group"><small class="req"> *</small>
																				<label>Date Of Birth</label><small class="req"> *</small>																				
																				<input name="date_of_birth" value="<?php if(!empty($adse->date_of_birth)){ echo $adse->date_of_birth; } ?>" type="text" class="form-control" placeholder="DD/MM/YYYY" id="employ_date_of_birth" data-target="#employ_date_of_birth" data-toggle="datetimepicker" autocomplete="off" required/>		
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group"><small class="req"> *</small>
																				<label>Date Of Joining</label><small class="req"> *</small>
																				<input name="date_of_joining" value="<?php if(!empty($adse->date_of_joining)){ echo $adse->date_of_joining; } ?>" id="employ_date_of_joining" placeholder="DD/MM/YYYY"  data-target="#employ_date_of_joining" data-toggle="datetimepicker" type="text" class="form-control" autocomplete="off" required/>
																			</div>
																		</div>
																	</div>
																	
																	<div class="row">
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Blood Group</label><small class="req"> *</small>
																				<select class="form-control select2" name="blood_group" autocomplete="off" required>
																					<?php if(!empty($adse->blood_group)){ echo '<option value="'.$adse->blood_group.'">'.$adse->blood_group.'</option>'; } else{ echo '<option value="">Select</option>'; } ?>																					
																					<option value="A+">A+</option>
																					<option value="A-">A-</option>
																					<option value="B+">B+</option>
																					<option value="B-">B-</option>
																					<option value="O+">O+</option> 
																					<option value="O-">O-</option> 
																					<option value="AB+">AB+</option> 
																					<option value="AB-">AB-</option> 
																					<option value="N/A">N/A</option> 
																					<option value="Unknown">Unknown</option> 
																				</select>
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Personal Phone </label><small class="req"> *</small>
																				<input name="personal_Phone" value="<?php if(!empty($adse->personal_Phone)){ echo $adse->personal_Phone; } ?>" placeholder="Personal Phone" type="text" class="form-control" autocomplete="off" required/>
																			</div>
																		</div>																	
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Personal Email</label>
																				<input id="email" name="email" value="<?php if(!empty($adse->email)){ echo $adse->email; } ?>" placeholder="Personal Email" type="email" class="form-control" value="" autocomplete="off">
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Photo</label><small class="req"> *</small><br />																				
																				<span id="avater_image">
																					<?php
																					if(!empty($adse->photo)){
																						echo '<img src="'.base_url().$adse->photo.'" style="width:50px;"/>';
																					}
																					?>
																				</span>
																				<input type="hidden" id="photo_avater_value" name="photo_avater" value="<?php if(!empty($adse->photo)){ echo $adse->photo; } ?>"/>
																				<button type="button" id="photo_avater" onclick="return open_camera()" title="Upload / Select / Chapture Photo" class="form-control btn btn-info" style="height:38px;<?php if(!empty($adse->photo)){ echo 'width:170px;float:right;'; } ?>"><i class="fas fa-camera"></i>  Photo Upload  <i class="fas fa-upload"></i> </button>
																				<!--<style>.image-previewer { height: 25px; border-radius: 5px;</style>
																				<label for="input" class="image-previewer" data-cropzee="input">Photo</label><small class="req"> *</small>
																				<input id="input" accept="image/*" class="form-control" type="file" name="avater_photo" style="padding-top:3px;" autocomplete="off" required>-->
																			</div>
																		</div>																									
																		
																	</div>
																	
																	<div class="row">
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Company Phone </label>
																				<input name="Company_phone" placeholder="Phone" type="text" class="form-control" autocomplete="off"/>
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Company Email</label>
																				<input name="company_email" placeholder="Company Email" type="email" class="form-control" value="" autocomplete="off">
																			</div>
																		</div>

																		<div class="col-md-3">
																			<div class="form-group">
																				<label><abbr title="National Identity Card">NID<abbr> / Passport</label><small class="req"> *</small>
																				<input name="nid_number" value="<?php if(!empty($adse->nid_number)){ echo $adse->nid_number; } ?>" placeholder="NID / Passport" type="text" class="form-control" value="" autocomplete="off">
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<div class="form-group">
																					<label>Location (Branch)</label><small class="req"> *</small>
																					<select name="branch" class="form-control select2" autocomplete="off" required>
																						<option value="">Select</option>
																						<?php
																						if(!empty($banches)){
																							foreach($banches as $row){
																								echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
																							}
																						}
																						?>
																					</select>
																				</div>
																			</div>
																		</div>																		
																	</div>
																	
																	<div class="row">	
																		<div class="col-md-6">
																			<div class="form-group">
																				<label>Current address</label><small class="req"> *</small>
																				<textarea name="current_address" placeholder="Current Address" class="form-control" autocomplete="off" required><?php if(!empty($adse->current_address)){ echo $adse->current_address; } ?></textarea>
																			</div>
																		</div>
																		
																		<div class="col-md-6">
																			<div class="form-group">
																				<label>Permanent Address</label><small class="req"> *</small>
																				<textarea name="permanent_address" placeholder="Permanent Address" class="form-control" autocomplete="off" required><?php if(!empty($adse->permanent_address)){ echo $adse->permanent_address; } ?></textarea>
																			</div>
																		</div>
																	</div>
																	
																	<div class="row">					
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Emergency Contact Name 1</label><small class="req"> *</small>
																				<input name="emergency_name1" value="<?php if(!empty($adse->emergency_contact_name)){ echo $adse->emergency_contact_name; } ?>" placeholder="Emergency Contact Name 1" type="text" class="form-control" value="" autocomplete="off" required>
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Emergency Contact Relation 1</label><small class="req"> *</small>
																				<select name="emergency_relation1" class="form-control select2" required>
																					<?php if(!empty($adse->emergency_contact_relation)){ echo '<option value="'.$adse->emergency_contact_relation.'">'.$adse->emergency_contact_relation.'</option>'; } else{ echo '<option value="">Select</option>'; } ?>	
																					<option value="Father">Father</option>
																					<option value="Mother">Mother</option>
																					<option value="Brother">Brother</option>
																					<option value="Sister">Sister</option>
																					<option value="Cousin">Cousin</option>
																					<option value="Friends">Friends</option>
																					<option value="Husband">Husband</option>
																					<option value="Wife">Wife</option>
																					<option value="Uncle">Uncle</option>
																					<option value="Aunti">Aunti</option>
																					<option value="Daughter">Daughter</option>
																					<option value="Son">Son</option>
																					<option value="Other">Other</option>
																				</select>
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Emergency Contact Number 1</label><small class="req"> *</small>
																				<input id="mobileno" name="emergency_no1" value="<?php if(!empty($adse->emergency_no1)){ echo $adse->emergency_no1; } ?>" placeholder="Emergency Contact Number 1" type="text" class="form-control" value="" autocomplete="off" required>
																			</div>
																		</div>											
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Emergency Contact Attachment 1</label><br />
																				<span id="avater_image_one"> </span>
																				<input type="hidden" id="photo_avater_value_one" name="photo_avater_one" value=""/>
																				<button type="button" id="photo_avater_one" onclick="return open_camera_one()" title="Upload / Select / Chapture Photo" class="form-control btn btn-info" style="height:38px;<?php if(!empty($adse->emergency_attachment_1)){ echo 'width:170px;float:right;'; } ?>"><i class="fas fa-camera"></i>  File Upload  <i class="fas fa-upload"></i> </button>
																				<!--<input class="form-control" type="file" name="emergency_attachment_1"style="padding-top:3px;" autocomplete="off" required>-->
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Emergency Contact Name 2</label>
																				<input name="emergency_name2" value="<?php if(!empty($adse->emergency_contact_name2)){ echo $adse->emergency_contact_name2; } ?>" placeholder="Emergency Contact Name 2" type="text" class="form-control" value="" autocomplete="off">
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Emergency Contact Relation 2</label>
																				<select name="emergency_relation2" class="form-control select2">
																					<?php if(!empty($adse->emergency_contact_relation2)){ echo '<option value="'.$adse->emergency_contact_relation2.'">'.$adse->emergency_contact_relation2.'</option>'; } else{ echo '<option value="">Select</option>'; } ?>	
																					<option value="Father">Father</option>
																					<option value="Mother">Mother</option>
																					<option value="Brother">Brother</option>
																					<option value="Sister">Sister</option>
																					<option value="Cousin">Cousin</option>
																					<option value="Friends">Friends</option>
																					<option value="Husband">Husband</option>
																					<option value="Wife">Wife</option>
																					<option value="Uncle">Uncle</option>
																					<option value="Aunti">Aunti</option>
																					<option value="Daughter">Daughter</option>
																					<option value="Son">Son</option>
																					<option value="Other">Other</option>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Emergency Contact Number 2</label>
																				<input id="mobileno" value="<?php if(!empty($adse->emergency_no2)){ echo $adse->emergency_no2; } ?>" name="emergency_no2" placeholder="Emergency Contact Number 2" type="text" class="form-control" value="" autocomplete="off">
																			</div>
																		</div>
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Emergency Contact Attachment 2</label><br />
																				<span id="avater_image_two"> </span>
																				<input type="hidden" id="photo_avater_value_two" name="photo_avater_two" value=""/>
																				<button type="button" id="photo_avater_two" onclick="return open_camera_two()" title="Upload / Select / Chapture Photo" class="form-control btn btn-info" style="height:38px;"><i class="fas fa-camera"></i>  File Upload  <i class="fas fa-upload"></i> </button>
																				<!--<input class="form-control" type="file" name="emergency_attachment_2" style="padding-top:3px;" autocomplete="off" required>-->
																			</div>
																		</div>
																		
																	</div>
																	<div class="row">																
																		
																	<div class="col-md-12">
																			<div class="form-group">
																				<label>Educational Qualification</label>
																				<table class="table table-bordered table-hover">
																					<thead>
																						<tr>
																							<td style="width: 4%;">Delete</td>
																							<td>Level Of Education</td>
																							<td style="width: 12%;">Passing Year</td>
																							<td>Institution</td>
																							<td style="width: 12%;">Board</td>
																							<td>Group/Subject</td>
																							<td>Division/CGPA</td>
																							<td style="width: 8%;">GPA/CGPA Scale</td>
																						</tr>
																					</thead>
																					<tbody id="education_qualification_body">
																						<tr id="edu_1">
																							<td></td>
																							<td>
																								<select name="qualification[]" class="select2 form-control" style="width: 100%;">
																									<option value="">Level</option>
																									<?php 
																									if(!empty($adse->qualification)){
																										$QD = explode(',',$adse->qualification);
																										foreach($QD as $row){
																											echo '<option value="'.$row.'" selected>'.$row.'</option>';
																										}
																									}																					
																									?>
																									<option value="PSC">PSC</option>
																									<option value="JSC">JSC</option>
																									<option value="SSC">SSC</option>
																									<option value="HSC">HSC</option>
																									<option value="Diploma">Diploma</option>
																									<option value="B.Sc">B.Sc</option>
																									<option value="M.Sc">M.Sc</option>
																									<option value="BBA">BBA</option>
																									<option value="MBA">MBA</option>
																									<option value="BA">BA</option>
																									<option value="BSS">BSS</option>
																									<option value="BBS">BBS</option>
																									<option value="Honours">Honours</option>
																									<option value="Masters">Masters</option>
																									<option value="PHD">PHD</option>
																									<option value="LLB">LLB</option>
																									<option value="LLM">LLM</option>
																									<option value="Other">Other</option>
																								</select>
																							</td>
																							<td>
																								<input class="form-control datepicker date-only-year" type="text" name="passing_year[]" placeholder="Passing Year" class="form-control" autocomplete="off"/>										
																							</td>
																							<td>
																								<input name="institution[]" placeholder="Institution" type="text" class="form-control" autocomplete="off">
																							</td>
																							<td>
																								<select name="board[]" class="form-control select2" style="width: 100%;">
																									<option value="">Select</option>
																									<option value="Dhaka">Dhaka</option>
																									<option value="Chittagong">Chittagong</option>
																									<option value="Barishal">Barishal</option>
																									<option value="Mymensingh">Mymensingh</option>
																									<option value="Khulna">Khulna</option>
																									<option value="Rajshahi">Rajshahi</option>
																									<option value="Rangpur">Rangpur</option>
																									<option value="Sylhet">Sylhet</option>
																									<option value="Cumilla">Cumilla</option>
																									<option value="Jessore">Jessore</option>
																								</select>
																							</td>
																							<td>
																								<input name="group[]" placeholder="Group" type="text" class="form-control" autocomplete="off">
																							</td>
																							<td>
																								<select name="class[]" class="select2 select2-hidden-accessible form-control" data-placeholder="Select Class/GPA" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
																									<option value="GPA out of 4">GPA out of 4</option>
																									<option value="GPA out of 5">GPA out of 5</option>
																									<option value="1st Division">1st Division</option>
																									<option value="2nd Division">2nd Division</option>
																									<option value="3rd Division">3rd Division</option>
																									<option value="First Class">First Class</option>
																									<option value="Second Class">Second Class</option>
																									<option value="Third Class">Third Class</option>
																								</select>
																							</td>
																							<td>
																								<input name="gpa[]" placeholder="CGPA" type="text" class="form-control" autocomplete="off">
																							</td>
																						</tr>
																						<tr id="edu_2">
																							<td><button type="button" class="btn btn-xs btn-danger" value="2" onclick="removeEducationColumn(this.value)"><i class="fas fa-times"></i></button></td>
																							<td>
																								<select name="qualification[]" class="select2 form-control" style="width: 100%;">
																									<option value="">Level</option>
																									<?php 
																									if(!empty($adse->qualification)){
																										$QD = explode(',',$adse->qualification);
																										foreach($QD as $row){
																											echo '<option value="'.$row.'" selected>'.$row.'</option>';
																										}
																									}																					
																									?>
																									<option value="PSC">PSC</option>
																									<option value="JSC">JSC</option>
																									<option value="SSC">SSC</option>
																									<option value="HSC">HSC</option>
																									<option value="Diploma">Diploma</option>
																									<option value="B.Sc">B.Sc</option>
																									<option value="M.Sc">M.Sc</option>
																									<option value="BBA">BBA</option>
																									<option value="MBA">MBA</option>
																									<option value="BA">BA</option>
																									<option value="BSS">BSS</option>
																									<option value="BBS">BBS</option>
																									<option value="Honours">Honours</option>
																									<option value="Masters">Masters</option>
																									<option value="PHD">PHD</option>
																									<option value="LLB">LLB</option>
																									<option value="LLM">LLM</option>
																									<option value="DR">DR</option>
																									<option value="Engineer">Engineer</option>
																									<option value="Other">Other</option>
																								</select>
																							</td>
																							<td>
																								<input class="form-control datepicker date-only-year" type="text" name="passing_year[]" placeholder="Passing Year" autocomplete="off"/>										
																							</td>
																							<td>
																								<input name="institution[]" placeholder="Institution" type="text" class="form-control" autocomplete="off">
																							</td>
																							<td>
																								<select name="board[]" class="form-control select2" style="width: 100%;">
																									<option value="">Select</option>
																									<option value="Dhaka">Dhaka</option>
																									<option value="Chittagong">Chittagong</option>
																									<option value="Barishal">Barishal</option>
																									<option value="Mymensingh">Mymensingh</option>
																									<option value="Khulna">Khulna</option>
																									<option value="Rajshahi">Rajshahi</option>
																									<option value="Rangpur">Rangpur</option>
																									<option value="Sylhet">Sylhet</option>
																									<option value="Cumilla">Cumilla</option>
																									<option value="Jessore">Jessore</option>
																								</select>
																							</td>
																							<td>
																								<input name="group[]" placeholder="Group" type="text" class="form-control" autocomplete="off">
																							</td>
																							<td>
																								<select name="class[]" class="select2 select2-hidden-accessible form-control" data-placeholder="Select Class/GPA" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
																									<option value="GPA out of 4">GPA out of 4</option>
																									<option value="GPA out of 5">GPA out of 5</option>
																									<option value="1st Division">1st Division</option>
																									<option value="2nd Division">2nd Division</option>
																									<option value="3rd Division">3rd Division</option>
																									<option value="First Class">First Class</option>
																									<option value="Second Class">Second Class</option>
																									<option value="Third Class">Third Class</option>
																								</select>
																							</td>
																							<td>
																								<input name="gpa[]" placeholder="CGPA" type="text" class="form-control" autocomplete="off">
																							</td>
																						</tr>
																						<tr id="edu_3">
																							<td><button type="button" class="btn btn-xs btn-danger" value="3" onclick="removeEducationColumn(this.value)"><i class="fas fa-times"></i></button></td>
																							<td>
																								<select name="qualification[]" class="select2 form-control" style="width: 100%;">
																									<option value="">Level</option>
																									<?php 
																									if(!empty($adse->qualification)){
																										$QD = explode(',',$adse->qualification);
																										foreach($QD as $row){
																											echo '<option value="'.$row.'" selected>'.$row.'</option>';
																										}
																									}																					
																									?>
																									<option value="PSC">PSC</option>
																									<option value="JSC">JSC</option>
																									<option value="SSC">SSC</option>
																									<option value="HSC">HSC</option>
																									<option value="Diploma">Diploma</option>
																									<option value="B.Sc">B.Sc</option>
																									<option value="M.Sc">M.Sc</option>
																									<option value="BBA">BBA</option>
																									<option value="MBA">MBA</option>
																									<option value="BA">BA</option>
																									<option value="BSS">BSS</option>
																									<option value="BBS">BBS</option>
																									<option value="Honours">Honours</option>
																									<option value="Masters">Masters</option>
																									<option value="PHD">PHD</option>
																									<option value="LLB">LLB</option>
																									<option value="LLM">LLM</option>
																									<option value="DR">DR</option>
																									<option value="Engineer">Engineer</option>
																									<option value="Other">Other</option>
																								</select>
																							</td>
																							<td>
																								<input class="form-control datepicker date-only-year" type="text" name="passing_year[]" placeholder="Passing Year" autocomplete="off"/>										
																							</td>
																							<td>
																								<input name="institution[]" placeholder="Institution" type="text" class="form-control" autocomplete="off">
																							</td>
																							<td>
																								<select name="board[]" class="form-control select2" style="width: 100%;">
																									<option value="">Select</option>
																									<option value="Dhaka">Dhaka</option>
																									<option value="Chittagong">Chittagong</option>
																									<option value="Barishal">Barishal</option>
																									<option value="Mymensingh">Mymensingh</option>
																									<option value="Khulna">Khulna</option>
																									<option value="Rajshahi">Rajshahi</option>
																									<option value="Rangpur">Rangpur</option>
																									<option value="Sylhet">Sylhet</option>
																									<option value="Cumilla">Cumilla</option>
																									<option value="Jessore">Jessore</option>
																								</select>
																							</td>
																							<td>
																								<input name="group[]" placeholder="Group" type="text" class="form-control" autocomplete="off">
																							</td>
																							<td>
																								<select name="class[]" class="select2 select2-hidden-accessible form-control" data-placeholder="Select Class/GPA" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
																									<option value="GPA out of 4">GPA out of 4</option>
																									<option value="GPA out of 5">GPA out of 5</option>
																									<option value="1st Division">1st Division</option>
																									<option value="2nd Division">2nd Division</option>
																									<option value="3rd Division">3rd Division</option>
																									<option value="First Class">First Class</option>
																									<option value="Second Class">Second Class</option>
																									<option value="Third Class">Third Class</option>
																								</select>
																							</td>
																							<td>
																								<input name="gpa[]" placeholder="CGPA" type="text" class="form-control" autocomplete="off">
																							</td>
																						</tr>
																					</tbody>
																				</table>
																				<button type="button" class="btn btn-primary" onclick="addEducation()">Add Education</button>
																			</div>
																		</div>
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Note</label>
																				<textarea name="note" placeholder="note" class="form-control" autocomplete="off"><?php if(!empty($adse->note)){ echo $adse->note; } ?></textarea>
																			</div>
																		</div>
																	</div>
																</div>

															</div>
														</div>
														
														<!-- <div class="box-body">
															<div class="tshadow mb25 bozero">
																<h4 class="pagetitleh2" style="text-decoration:underline;">Previous Company Information</h4>
																<div class="around10">
																	<div class="row">
																		<div class="col-md-4">
																			<div class="form-group">
																				<label>Previous / Current Company Name</label><small class="req"> *</small>
																				<textarea id="previus_company" name="previus_company" placeholder="Previous / Current Company Name" class="form-control" autocomplete="off" required ><?php if(!empty($adse->previus_company)){ echo $adse->previus_company; } ?></textarea>
																			</div>
																		</div>								
																		<div class="col-md-4">
																			<div class="form-group">
																				<label>Designation</label><small class="req"> *</small>
																				<textarea name="previus_designation" placeholder="Designation" class="form-control" autocomplete="off" required ><?php if(!empty($adse->previus_designation)){ echo $adse->previus_designation; } ?></textarea>
																			</div>
																		</div>
																		<div class="col-md-4">
																			<div class="form-group">
																				<label>Reason About Leave</label><small class="req"> *</small>
																				<textarea name="reason_leave" placeholder="Reason About Leave" class="form-control" autocomplete="off" required ><?php if(!empty($adse->reason_leave)){ echo $adse->reason_leave; } ?></textarea>
																			</div>
																		</div>															
																	</div>												
																	
																</div>
															</div>
														</div> -->

														<div class="box-body">
															<div class="tshadow mb25 bozero">
																<h4 class="pagetitleh2" style="text-decoration:underline;">Employment History</h4>
																<div class="around10">
																<table class="table table-bordered table-hover">
																	<thead>
																		<tr>
																			<td style="width: 4%;">Delete</td>
																			<td>Employer/Company Name</td>
																			<td>Designation</td>
																			<td>Department</td>
																			<td style="width: 10%;">From</td>
																			<td style="width: 10%;">To</td>
																			<td>Core Responsibility</td>
																			<td>Reason For Leaving</td>
																		</tr>
																	</thead>
																	<tbody id="employment_history_body">
																		<tr id="empHst_1">
																			<td></td>
																			<td>
																				<input name="company_name[]" placeholder="Company Name" type="text" class="form-control" autocomplete="off">
																			</td>
																			<td>
																				<input name="designation_emp[]" placeholder="Designation" type="text" class="form-control" autocomplete="off">
																			</td>
																			<td>
																				<input name="department_emp[]" type="text" placeholder="Department" class="form-control" />										
																			</td>
																			<td>
																				<input name="from[]" placeholder="From" type="text" class="form-control datepicker" autocomplete="off">
																			</td>
																			<td>
																				<input name="to[]" placeholder="To" type="text" class="form-control datepicker" autocomplete="off">
																			</td>
																			<td>
																				<input name="responsibility[]" placeholder="Core Responsibility" type="text" class="form-control" autocomplete="off">
																			</td>
																			<td>
																				<input name="leaving_reason[]" placeholder="Leave Reason" type="text" class="form-control" autocomplete="off">
																			</td>
																		</tr>
																	</tbody>
																</table>												
																<button type="button" class="btn btn-primary mb-3" onclick="addEmploymentHistory()">Add Employee History</button>
																</div>
															</div>
														</div>


														<div class="box-body">
															<div class="tshadow mb25 bozero">
																<h4 class="pagetitleh2" style="text-decoration:underline;">Professional Training/Qualification</h4>
																<div class="around10">
																<table class="table table-bordered table-hover">
																	<thead>
																		<tr>
																			<td style="width: 4%;">Delete</td>
																			<td>Name of the Training</td>
																			<td>Institution</td>
																			<td>Place(Local/Foreign)</td>
																			<td>Completion Year</td>
																			<td>Duration</td>
																		</tr>
																	</thead>
																	<tbody id="professional_training_body">
																		<tr id="training_1">
																			<td></td>
																			<td>
																				<input name="training_name[]" placeholder="Name of the Training" type="text" class="form-control" autocomplete="off">
																			</td>
																			<td>
																				<input name="training_institution[]" placeholder="Institution" type="text" class="form-control" autocomplete="off">
																			</td>
																			<td>
																				<input name="place[]" placeholder="Place" type="text" class="form-control" />										
																			</td>
																			<td>
																				<input name="completion_year[]" placeholder="Completion Year" type="text" class="form-control datepicker date-only-year" autocomplete="off">
																			</td>
																			<td>
																				<input name="duration[]" placeholder="Duration" type="text" class="form-control" autocomplete="off">
																			</td>
																		</tr>
																	</tbody>
																</table>												
																<button type="button" class="btn btn-primary mb-3" onclick="addTraining()">Add More Training</button>
																</div>
															</div>
														</div>


														<div class="box-body">
															<div class="tshadow mb25 bozero">
																<h4 class="pagetitleh2" style="text-decoration:underline;">Family Details</h4>
																<div class="around10">
																<table class="table table-bordered table-hover">
																	<thead>
																		<tr>
																			<td style="width: 4%;">Delete</td>
																			<td>Relation</td>
																			<td>Name</td>
																			<td>Occupation</td>
																			<td>Contact Number</td>
																			<td>Contact Address</td>
																		</tr>
																	</thead>
																	<tbody id="employee_family_body">
																		<tr id="family_1">
																			<td></td>
																			<td>
																				<select name="relation[]" class="form-control select2">
																					<option value="">Select</option>
																					<option value="Father">Father</option>
																					<option value="Mother">Mother</option>
																					<option value="Brother">Brother</option>
																					<option value="Sister">Sister</option>
																					<option value="Cousin">Cousin</option>
																					<option value="Friends">Friends</option>
																					<option value="Husband">Husband</option>
																					<option value="Wife">Wife</option>
																					<option value="Uncle">Uncle</option>
																					<option value="Aunti">Aunti</option>
																					<option value="Daughter">Daughter</option>
																					<option value="Son">Son</option>
																					<option value="Other">Other</option>
																				</select>
																			</td>
																			<td>
																				<input name="name[]" placeholder="Name" type="text" class="form-control" autocomplete="off">
																			</td>
																			<td>
																				<input name="occupation[]" placeholder="Occupation" type="text" class="form-control" />										
																			</td>
																			<td>
																				<input name="contact_number[]" placeholder="Contact Number" type="text" class="form-control" autocomplete="off">
																			</td>
																			<td>
																				<input name="contact_address[]" placeholder="Contact Address" type="text" class="form-control" autocomplete="off">
																			</td>
																		</tr>
																	</tbody>
																</table>												
																<button type="button" class="btn btn-primary mb-3" onclick="addFamily()">Add More Family</button>
																</div>
															</div>
														</div>
														
														
														<div class="box-body">
															<div class="tshadow mb25 bozero">
																<h4 class="pagetitleh2" style="text-decoration:underline;">PayRoll Information </h4>
																<div class="around10">
																	<div class="row">
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Employee ID</label><small class="req"> *</small>
																				<input name="employee_id" value="<?php if(!empty($auto_employee_id->employee_id)){ echo (int)$auto_employee_id->employee_id + 1; } ?>" placeholder="Employee ID" type="text" class="form-control" autocomplete="off" readonly />
																			</div>
																		</div>
																		<div class="col-sm-7">
																			<div class="row">
																				<div class="col-md-4">
																					<div class="form-group">
																						<label>Role</label><small class="req"> *</small>
																						<select name="role" class="form-control select2" autocomplete="off" required/>
																							<option value="">Select</option>
																							<?php
																							if(!empty($role)){
																								foreach($role as $row){
																									if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
																										echo '<option value="'.$row->role_id.'">'.$row->role_name.'</option>';
																									}else{
																										if($row->role_id != '2805597208697462328' AND $row->role_id != '3386233961062517400'){
																											echo '<option value="'.$row->role_id.'">'.$row->role_name.'</option>';
																										}
																										
																									}																						
																								}
																							}
																							?>
																						</select>
																					</div>
																				</div>
																				<div class="col-md-4">
																					<div class="form-group">
																						<label>Designation</label><small class="req"> *</small>
																						<select name="designation" class="form-control select2" autocomplete="off" required>
																							<option value="">Select</option>
																							<?php
																							if(!empty($designation)){
																								foreach($designation as $row){
																									echo '<option value="'.$row->designation_id.'">'.$row->designation_name.'</option>';
																								}
																							}
																							?>
																						</select>
																					</div>
																				</div>
																				<div class="col-md-4">
																					<div class="form-group">
																						<label>Department</label><small class="req"> *</small>
																						<select id="department" name="department" class="form-control select2" autocomplete="off" required>
																							<option value="select">Select</option>
																							<?php
																							if(!empty($department)){
																								foreach($department as $row){
																									echo '<option value="'.$row->department_id.'">'.$row->department_name.'</option>';
																								}
																							}
																							?>
																						</select> 
																					</div>
																				</div>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Grade</label><small class="req"> *</small>
																				<select id="grade" name="grade" class="form-control select2" autocomplete="off" required>
																					<option value="select">Select</option>
																					<?php
																					if(!empty($grade)){
																						foreach($grade as $row){
																							echo '<option value="'.$row->grade_id.'">'.$row->grade_name.'</option>';
																						}
																					}
																					?>
																				</select> 
																			</div>
																		</div>																	
																	</div>
																	
																	<div class="row">
																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Salary (Daily)</label><small class="req"> *</small>
																				<input name="basic_salary" placeholder="Basic Salary" type="number" class="form-control" autocomplete="off" required/>
																			</div>
																		</div>
																		
																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Mobile Allowance</label>
																				<input name="mobile_allowance" placeholder="Mobile Allowance" type="number" class="form-control" autocomplete="off" />
																			</div>
																		</div>
																		
																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Salary Pay Method</label><small class="req"> *</small>
																				<select name="salary_pay_method" class="form-control select2" autocomplete="off" required>
																					<option value="">Select</option>
																					<option id="cash" value="cash">Cash</option>
																					<option id="bank" value="bank">Bank</option>																						
																				</select>
																			</div>
																		</div>

																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Contract Type</label><small class="req"> *</small>
																				<select name="contruct_type" class="form-control select2" autocomplete="off" required>
																					<option value="">Select</option>
																					<option value="Regular">Regular</option>
																					<option value="Probation">Probation</option>																						
																				</select>
																			</div>
																		</div>
																		
																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Work Shift</label><small class="req"> *</small>
																				<select name="work_shift" class="form-control select2" autocomplete="off" required>
																					<option value="">Select</option>
																					<option value="Day">Day</option>
																					<option value="Night">Night</option>																						
																				</select>
																			</div>
																		</div>
																		
																		<div class="col-md-2">
																			<div class="form-group" >
																				<label>Assign Bed</label>
																				<input name="assign_bed" placeholder="Assign Bed Name" type="text" class="form-control" autocomplete="off" />
																			</div>
																		</div>

																	</div>

																	<div class="row">
																		<div class="col-md-3">
																			<label>Card Number</label><small class="req"> *</small>
																			<input type="text" name="card_number" id="card_number" class="form-control" placeholder="Card Number" required>
																		</div>
																		<div class="col-md-3">
																			<label>Probation Periods</label>
																			<input type="text" name="probation_perido" id="probation_perido" class="form-control datepicker-multiple" placeholder="Enter Date" autocomplete="off" required>
																		</div>
																	</div>
																	
																</div>

															</div>
														</div>														
														<script>
														$('document').ready(function(){
															$('select[name="salary_pay_method"]').on("change",function(){
																if($(this).val() == 'bank'){
																	$("#bank-account-information").css({"display":"block"});
																	$('input[name="bank_account_title"]').prop('required', true);
																	$('input[name="bank_account_number"]').prop('required', true);
																	$('input[name="bank_name"]').prop('required', true);
																	$('input[name="bank_branch_name"]').prop('required', true);
																	$('select[name="account_type"]').prop('required', true);
																}else{
																	$("#bank-account-information").css({"display":"none"});
																	$('input[name="bank_account_title"]').prop('required', false);
																	$('input[name="bank_account_number"]').prop('required', false);
																	$('input[name="bank_name"]').prop('required', false);
																	$('input[name="bank_branch_name"]').prop('required', false);
																	$('select[name="account_type"]').prop('required', false);
																}
															})
														})
														</script>
														<div class="box-body" id="bank-account-information" style="display:none;">
															<div class="tshadow mb25 bozero">
																<h4 class="pagetitleh2" style="text-decoration:underline;">Bank Account Information </h4>
																<div class="around10">
																	
																	
																	<div class="row">
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Account Title</label>
																				<input name="bank_account_title" placeholder="Account Title" type="text" class="form-control" autocomplete="off"/>
																			</div>
																		</div>
																		
																		<div class="col-md-3">
																			<div class="form-group">
																				<label>Bank Account Number</label>
																				<input name="bank_account_number" placeholder="Bank Account Number" type="text" class="form-control" autocomplete="off"/>
																			</div>
																		</div>
																		
																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Bank Name</label>
																				<input name="bank_name" placeholder="Bank Name" type="text" class="form-control" autocomplete="off"/>
																			</div>
																		</div>
																		

																				<input name="bfsc_code" placeholder="BFSC Code" type="hidden" class="form-control" autocomplete="off"/>


																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Bank Branch Name</label>
																				<input name="bank_branch_name" placeholder="Bank Branch Name" type="text" class="form-control" autocomplete="off"/>
																			</div>
																		</div>
																		<div class="col-md-2">
																			<div class="form-group">
																				<label>Account Type</label><small class="req"> </small>
																				<select name="account_type" class="form-control select2" autocomplete="off">
																					<option value="">Select</option>
																					<option value="eblact">eblact</option>
																					<option value="eblcdp">eblcdp</option>																						
																				</select>
																			</div>
																		</div>
																	</div>
																	
																</div>

															</div>
														</div>





														
														<div class="tshadow mb25 bozero">    
															<h4 class="pagetitleh2" style="text-decoration:underline;">Social Media Link</h4>
															<div class="row around10">
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Facebook URL</label>
																		<input name="facebook" value="<?php if(!empty($adse->facebook)){ echo $adse->facebook; } ?>" placeholder="Facebook URL" type="url" class="form-control">
																	</div>
																</div>
																
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Twitter URL</label>
																		<input name="twitter" value="<?php if(!empty($adse->twitter)){ echo $adse->twitter; } ?>" placeholder="Twitter URL" type="url" class="form-control">
																	</div>
																</div>
																
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Linkedin URL</label>
																		<input name="linkedin" value="<?php if(!empty($adse->linkedin)){ echo $adse->linkedin; } ?>" placeholder="Linkedin URL" type="url" class="form-control">
																	</div>
																</div>
																
																<div class="col-md-6">
																	<div class="form-group">
																		<label>Instagram URL</label>
																		<input id="instagram" value="<?php if(!empty($adse->instagram)){ echo $adse->instagram; } ?>" name="instagram" placeholder="Instagram URL" type="url" class="form-control" value="">
																	</div>
																</div>
															</div>
														</div>  
														
														<div id="upload_documents_hide_show">
															<div class="row">
																<div class="col-md-12">
																	<div class="tshadow bozero">
																		<h4 class="pagetitleh2" style="text-decoration:underline;">Upload Documents</h4>
																		<div class="row around10">   
																			<div class="col-md-6">
																				<table class="table">
																					<tbody><tr>
																							<th style="width: 10px">#</th>
																							<th>Title</th>
																							<th>Documents</th>
																						</tr>
																						<tr>
																							<td>1.</td>
																							<td>Resume</td>
																							<td>
																								<input class="form-control" type="file" name="first_doc" id="doc1" style="padding-top:3px;">
																							</td>
																						</tr>
																						<tr>
																							<td>3.</td>
																							<td>Other Documents</td>
																							<td>
																								<input class="form-control" type="file" name="thired_doc[]" multiple id="doc4" style="padding-top:3px;">
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																			
																			<div class="col-md-6">
																				<table class="table">
																					<tbody><tr>
																							<th style="width: 10px">#</th>
																							<th>Title</th>
																							<th>Documents</th>
																						</tr>
																						<tr>
																							<td>2.</td>
																							<td>Joining Letter</td>
																							<td>
																								<input class="filestyle form-control" type="file" name="second_doc" id="doc2" style="padding-top:3px;">
																							</td>
																						</tr>
																						<tr>
																							<td>4.</td>
																							<td>Relese Letter</td>
																							<td>
																								<input class="filestyle form-control" type="file" name="forth_doc" id="doc2" style="padding-top:3px;">
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																		</div>
																		 
																	</div>    
																</div>
															</div>
														</div>
													</div>
													<div class="box-footer">
														<div class="modal-footer justify-content-between">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															<?php echo $button; ?>
														</div>														
													</div>
												</form>
											</div>               
										</div>
									</div>
								
								  <!---------------------------------------------------------->
								  


								  
							</div>							
						</div>
					</div>
				</div>			
					
				</div>
			</div>
<?php 
if(!empty($adse)){
?>
<script>
	$('document').ready(function(){
		$("#add-employ").modal('show');
	})
</script>
<?php } ?>
			<div class="row">
				<div class="col-sm-12" style="padding-top:20px;">
	
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Employee Directory</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<style>.employee .form-group{margin-right:10px;}</style>
						<div class="card-body">				
							<style>#employee_data_table td{text-align:center;vertical-align: middle;padding:0px;}#employee_data_table th{text-align:center;vertical-align: middle;}.image_employee:hover{transform:scale(1.5);}</style>
							<table id="employee_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
							   <thead>
								  <tr>
									 <th>Image</th>
									 <th>ID</th>
									 <th>Card#</th>
									 <th>Branch</th>
									 <th>Name</th>
									 <th>BG</th>
									 <th>Designation</th>
									 <th>Department</th>
									 <th>Role</th>
									 <th>Email</th>
									 <th>Phone</th>									 
									 <th>Joining date</th>
									 <th>Duration</th>
									 <th># <i class="fas fa-sign-out-alt"></i></th>
									 <th>Option</th>
								  </tr>
							   </thead>
							   <tbody>
							   </tbody>
							</table>					
						</div>
					</div>				
				</div>
			</div>			
		</div>
	</div>
</div>
<!----role add model-->
<div class="modal fade" id="add-role">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Add Role</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Write Role name</label>
						<input type="text" name="role_name" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="add_role" class="btn btn-primary">Add Role</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End role add model-->

<!----Designation model-->
<div class="modal fade" id="add-designation">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-warning">
					<h4 class="modal-title">Add Designation</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Write Designation name</label>
						<input type="text" name="designation_name" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="add_designation" class="btn btn-warning">Add Designation</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End Designation model-->

<!----Designation model-->
<div class="modal fade" id="employee_card_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="update_employeee_card" action="" method="post">
				<input type="hidden" id="card_employee_id">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Employee Card</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row justify-content-between">
						<div class="col-md-12 text-danger" id="card_error"></div>
						<div class="col-md-5">
							<label>Assigned Card Number</label>
							<input type="text" id="old_card_number" class="form-control" disabled />
						</div>
						<div class="col-md-5">
							<label>New Card Number</label>
							<input type="text" id="new_card_number" class="form-control" required /></div>
						</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="add_designation" class="btn btn-info">Update Card</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End Designation model-->

<!----Department model-->
<div class="modal fade" id="add-department">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-success">
					<h4 class="modal-title">Add Department</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Write Department name</label>
						<input type="text" name="department_name" class="form-control" required />
					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="add_department" class="btn btn-success">Add Department</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End Department model-->
<div class="modal fade" id="view_model_details">
	<div class="modal-dialog modal-xl" style="max-width: 1650px;">
		<div class="modal-content">
			<div class="modal-header btn-info">
				<h4 class="modal-title">Employ information</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="view_details">

			</div>							
		</div>
	</div>
</div>
<!----deactive model-->
<div class="modal fade" id="deactive_model">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<input type="hidden" name="hidden_id" value="" id="dactive_hidden_id"/>
				<div class="modal-header btn-danger">
					<h4 class="modal-title">Deactive Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<?php  ?>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Select aproval Employee</label>
								<select name="aproval_employee[]" multiple="multiple" class="form-control select2" required>
									<option value="">--select--</option>
									<?php										
										if(!empty($table)){
											foreach($table as $row){
												$select_department_head = $this->Dashboard_model->mysqlii("select * from set_department_head_logs where employee_id = '".$row->employee_id."'");
												if(!empty($select_department_head[0]->id)){
									?>
										<option value="<?php echo $row->employee_id; ?>"><?php echo $row->full_name; ?> - <?php echo $row->employee_id; ?> (<?php echo $row->department_name;?>)</option>
									<?php } } } ?>
								</select>
							</div>
						</div>
						<?php  ?>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Input Dactive Note</label>
								<textarea name="extra_note" style="height:150px;" class="form-control" required ></textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Select Date</label>
								<input type="date" class="form-control" name="deactive_Date" value="<?php echo date('Y-m-d'); ?>"/>
							</div>
						</div>
					</div>					
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="status_off" class="btn btn-danger">Deactive</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End deactive model-->


<!----hold model-->
<div class="modal fade" id="hold_model">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="employee_hold_request_form" action="<?=current_url(); ?>" method="post">
				<input type="hidden" name="hidden_id" value="" id="hold_hidden_id"/>
				<div class="modal-header btn-warning">
					<h4 class="modal-title">Hold Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Input Hold Note</label>
								<textarea name="note" style="height:150px;" class="form-control" required ></textarea>
							</div>
						</div>
					</div>					
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="status_to_hold" class="btn btn-warning">Hold</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End hold model-->



<!----Department model-->
<div class="modal fade" id="employee-overview">
	<div class="modal-dialog modal-lg" style="min-width:90%;">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-secondary">
					<div class="row" style="width:100%;">
						<div class="col-sm-3">
							<h4 class="modal-title">Employee Overview</h4>
						</div>
						<div class="col-sm-3">
							<input id="myInput" onkeyup="search_employee_overview()" type="text" placeholder="Search Employee.." class="form-control">
						</div>
						<div class="col-sm-5">
							<?php
								$total_sallary = $this->Dashboard_model->mysqlii("select sum(basic_salary) as total_sallary, count(id) as total_employee from employee where status = '1'");
								$increament = $this->Dashboard_model->mysqlii("select sum(amount) as total from employee_increament_logs where aproval = '1' and e_db_id in(select id from employee where status = '1')");
								$decreament = $this->Dashboard_model->mysqlii("select sum(amount) as total from employee_decreament_logs where aproval = '1' and e_db_id in(select id from employee where status = '1')");
							?>
							<div class="row">
								<div class="col-sm-6">
									
								</div>
								<div class="col-sm-6">
									<span><i class="fas fa-users" style="color:#fff;"></i> <b style="color:#ffd862;"><?php echo $total_sallary[0]->total_employee; ?></b></span>
									<span style="float:right;"><i class="far fa-money-bill-alt" style="color:#fff;"></i> <b style="color:#ffd862;"><?php echo money($total_sallary[0]->total_sallary + $increament[0]->total - $decreament[0]->total); ?></b></span>
								</div>
							</div>
						</div>
						<div class="col-sm-1">
							<button type="button" class="close btn btn-danger" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true" style="color: #fff;">&times;</span> </button>
						</div>
					</div>				
				</div>
				<div class="modal-body set_height" id="employee_over_view_body" style="overflow-y:scroll;">
				</div>
				<script>
				$(document).ready(function(){
					var w__height = $(window).height();
					var set_mode_over_view_height = w__height - 160;
					$(".set_height").height(set_mode_over_view_height);
				})
				</script>
			</form>
		</div>
	</div>
</div>
<!----End Department model-->



<!----Camera model-->
<div class="modal fade" id="camera_model">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Take Member photo</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<select class="form-control" id="videoSource" onchange="return open_camera()"></select>
							</div>
						</div>
					</div>						
						
					<div id="DesiredResult" style="background-color:grey;width: 100%;">
						<video id="video" playsinline autoplay style="width:766px;"></video>
					</div>						
					<div id="output"></div>
				</div>
				<div class="modal-footer justify-content-between">
					<button onclick="return snap()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
					<button onclick="return retake_image()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
					<input type="file" id="other_file" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
					<button onclick="return capture_image_done()" type="button" class="btn btn-sm btn-success">Done</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End Camera model-->
<!----emergency attachment one model-->
<div class="modal fade" id="camera_model_one">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Take emergency attachment one</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<select class="form-control" id="videoSource_one" onchange="return open_camera_one()"></select>
							</div>
						</div>
					</div>						
						
					<div id="DesiredResult_one" style="background-color:grey;width: 100%;">
						<video id="video_one" playsinline autoplay style="width:766px;"></video>
					</div>						
					<div id="output_one"></div>
				</div>
				<div class="modal-footer justify-content-between">
					<button onclick="return snap_one()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
					<button onclick="return retake_image_one()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
					<input type="file" id="other_file_one" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
					<button onclick="return capture_image_done_one()" type="button" class="btn btn-sm btn-success">Done</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End emergency attachment one model-->
<!----emergency attachment two model-->
<div class="modal fade" id="camera_model_two">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Take emergency attachment two</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<select class="form-control" id="videoSource_two" onchange="return open_camera_two()"></select>
							</div>
						</div>
					</div>						
						
					<div id="DesiredResult_two" style="background-color:grey;width: 100%;">
						<video id="video_two" playsinline autoplay style="width:766px;"></video>
					</div>						
					<div id="output_two"></div>
				</div>
				<div class="modal-footer justify-content-between">
					<button onclick="return snap_two()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
					<button onclick="return retake_image_two()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
					<input type="file" id="other_file_two" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
					<button onclick="return capture_image_done_two()" type="button" class="btn btn-sm btn-success">Done</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!----End emergency attachment two model-->

<!----Mobile Recharge Model-->
<div class="modal fade" id="mobile_recharge_model">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Employee Mobile Recharge List</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="mobile_recharge_model_result">
					
				</div>
			</form>
		</div>
	</div>
</div>
<!----End Mobile Recharge Model-->

<!----add_extra_recharge_phone_number_button-->
<div class="modal fade" id="add_extra_recharge_phone_number_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="add_extra_recharge_phone_number_form" action="<?=current_url(); ?>" method="post">
				<input type="hidden" name="uploader_info" value="<?php echo $_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']; ?>"/>
				<div class="modal-header btn-default">
					<h4 class="modal-title">Extra Phone Number Recharge List</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="add_extra_recharge_phone_number_result" style="max-height:700px;overflow-y:scroll;">
					<div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<select name="employee_id" class="form-control select2" required>
											<option value="">--select employee--</option>
											<?php
											if(!empty($table)){
												foreach($table as $d){ 
													echo '<option value="'.$d->employee_id.'">'.$d->full_name.'('.$d->employee_id.')</option>';
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" name="purpose" placeholder="Purrpose" class="form-control" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" name="phone_number" pattern=".{11,11}" maxlength="11" autocomplete="off" placeholder="Phone Number" class="number_int form-control" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<input type="text" name="amount" placeholder="Amount (BDT)" autocomplete="off" class="number_int form-control" required />
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<button id="extra_phone_number_recharge_submit" name="add_number" type="submit" class="btn btn-success" style="float:right;">Save</button>
							</div>
						</div>
						<div class="col-sm-12" style="margin-top:20px;">
							<style>#extra_phone_number_recharge_table td{text-align:center;vertical-align: middle;}#extra_phone_number_recharge_table th{text-align:center;vertical-align: middle;}#extra_phone_number_recharge_table td:last-child{text-align:left;}</style>
							<table id="extra_phone_number_recharge_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>Employee</th>
										<th>Purpose</th>
										<th>Number</th>
										<th>Amount</th>
										<th>Date</th>
										<th>OPT</th>									
									</tr>
								</thead>
								<tbody>	
								</tbody>								
							</table>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!----add_extra_recharge_phone_number_button-->

<!----print_applicant_account_Details Model-->
<div class="modal fade" id="print_applicant_account_Details_model">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Employee Applicant Account</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="print_applicant_account_Details_result">					
				</div>
			</form>
		</div>
	</div>
</div>
<!----End print_applicant_account_Details Model-->

<script type="text/javascript" src="<?=base_url('assets/'); ?>js/webcamjs/webcam.js"></script>
<script>

$('document').ready(function(){
	$("#employee_hold_request_form").on("submit",function(){
		event.preventDefault();
		var form = $('#employee_hold_request_form')[0];
		var data = new FormData(form);			
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/hold_an_employe_from_employee_list.php'); ?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$('button[name="status_to_hold"]').prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$('button[name="status_to_hold"]').prop("disabled", false);
				$("#hold_model").modal('hide');
				alert(data);
				$('#employee_data_table').DataTable().ajax.reload( null , false);
			}
		});
		return false;
	})
})
function un_hold_an_employee(id){
	$.ajax({
		type: 'post',
		url:"<?=base_url('assets/ajax/add_employee_tables/un_hold_an_employee.php');?>",
		data: {e_db_id: id},
		success: function(data){
			alert(data);
			$('#employee_data_table').DataTable().ajax.reload( null , false);
		} 
	})
}
// Adding column to education qualification
function addEducation(){
	last_idx = $('#education_qualification_body tr:last').attr('id');
	$.ajax({
		type: 'post',
		url:"<?=base_url('assets/ajax/add_employee_tables/add_education_qualification.php');?>",
		data: {last_idx: last_idx},
		success: function(response){
			$('#education_qualification_body').append(response);			
			$('.select2').select2({
				width: '100%'
			});
			$('.datepicker.date-only-year').datepicker({
				format: "yyyy",
				viewMode: "years", 
				minViewMode: "years",
				autoclose: true,
			});
		} 
	})
}
// Remove column of education table
function removeEducationColumn(row_id){
	$('#edu_'+row_id).remove();
}
// Adding column to Family table
function addFamily(){
	last_idx = $('#employee_family_body tr:last').attr('id');
	$.ajax({
		type: 'post',
		url:"<?=base_url('assets/ajax/add_employee_tables/add_employee_family.php');?>",
		data: {last_idx: last_idx},
		success: function(response){
			$('#employee_family_body').append(response);			
			$('.select2').select2({
				width: '100%'
			});
		} 
	})
}
// Remove column of Family table
function removeFamily(row_id){
	$('#family_'+row_id).remove();
}
// Adding column to employment history
function addEmploymentHistory(){
	last_idx = $('#employment_history_body tr:last').attr('id');
	$.ajax({
		type: 'post',
		url:"<?=base_url('assets/ajax/add_employee_tables/add_employment_history.php');?>",
		data: {last_idx: last_idx},
		success: function(response){
			$('#employment_history_body').append(response);
			$('.datepicker').datepicker({
				format: 'yyyy/mm/dd',
				todayHighlight:'TRUE',
				autoclose: true,
			});
		} 
	})
}
// Remove column of employment history
function removeEmploymentHistory(row_id){
	$('#empHst_'+row_id).remove();
}
// Add more training
function addTraining(){
	last_idx = $('#professional_training_body tr:last').attr('id');
	$.ajax({
		type: 'post',
		url:"<?=base_url('assets/ajax/add_employee_tables/add_training.php');?>",
		data: {last_idx: last_idx},
		success: function(response){
			$('#professional_training_body').append(response);
			$('.datepicker.date-only-year').datepicker({
				format: "yyyy",
				viewMode: "years", 
				minViewMode: "years",
				autoclose: true,
			});
		} 
	})
}
// Remove column of training
function removeTraining(row_id){
	$('#training_'+row_id).remove();
}


function print_applicant_account_Details(id){
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/print_applicant_account_Details.php');?>",  
		method:"POST",  
		data:{post_id:id},
		beforeSend:function(){			
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#print_applicant_account_Details_model').modal('show');
			$('#print_applicant_account_Details_result').html(data);
		}  
	});
}




$('dicument').ready(function(){
	$("#add_extra_recharge_phone_number_form").on("submit",function(){
		event.preventDefault();
		var form = $('#add_extra_recharge_phone_number_form')[0];
		var data = new FormData(form);			
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/insert_extra_recharge_phone_number.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#extra_phone_number_recharge_submit").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				$("#extra_phone_number_recharge_submit").prop("disabled", false);
				alert(data);
				$("#add_extra_recharge_phone_number_form")[0].reset();				
				$('select[name="employee_id"]').val('').trigger('change');
				$('#extra_phone_number_recharge_table').DataTable().ajax.reload( null , false);
			}
		});
		return false;
	})
})
function delete_extrarecharge_number(id){
	if(confirm('Are you sure want to delete this Number?')){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_submit/insert_extra_recharge_phone_number.php');?>",  
			method:"POST",  
			data:{post_id:id},
			beforeSend:function(){			
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				alert(data);
				$('#extra_phone_number_recharge_table').DataTable().ajax.reload( null , false);
			}  
		});
	}
}
function add_extra_recharge_phone_number_button(){
	$("#add_extra_recharge_phone_number_modal").modal('show');
}
function employee_over_view_recharge_body(){
	var post_id = 1111; 
	if(post_id != ''){	
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/employee_mobile_recharge_list_overview.php');?>",  
			method:"POST",  
			data:{post_id:post_id},
			beforeSend:function(){			
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#mobile_recharge_model_result').html(data);    
				$("#mobile_recharge_model").modal('show');				
			}  
		});  
	}
}
function employee_over_view_body(){
	var post_id = 1111; 
	if(post_id != ''){	
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/employee_overview.php');?>",  
			method:"POST",  
			data:{post_id:post_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#employee_over_view_body').html(data);    
				$("#employee-overview").modal('show');
				
			}  
		});  
	}	
}
var w = 766, h = 575;
var shutter = new Audio();
shutter.autoplay = false;
shutter.src = navigator.userAgent.match(/Firefox/) ? '<?=base_url("assets/"); ?>js/shutter.ogg' : '<?=base_url("assets/"); ?>js/shutter.mp3';
//----------------------------------------------------------------------------------
function capture_image_done(){	
	if(document.getElementById('camera_canvas')){
		var canvas = document.getElementById('camera_canvas');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/camera_session_employee_photo.php"); ?>', function(code, text) {
			$("#avater_image").html('<img src="<?=base_url();?>'+text+'" style="width:50px;" id="view_image"/>');
			$("#photo_avater_value").val(text);
			$("#photo_avater").css({"width":"170px","float":"right"});
			$('#image_test_avater').val('success');
			$('#camera_model').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file").on("change",function(){
	var fileUpload = document.getElementById('other_file');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult").textContent = "";
				document.getElementById("DesiredResult").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_camera(){	
	$('#camera_model').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video');
	const videoSelect = document.querySelector('select#videoSource');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start;
//-------------
	return camera_start();
}
function snap() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult").textContent = "";
    document.getElementById("DesiredResult").appendChild(cv);	
}
function retake_image(){
	var cm = document.createElement("video");
    cm.width = w;
    cm.id = "video" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult").html('<video id="video" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video');
	const videoSelect = document.querySelector('select#videoSource');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start;
//-------------
	return camera_start();
}
$(document).ready(function(){
	$('#camera_model').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------

//----------------------------------------------------------------------------------


//-------------------ONE---------------------------------------------------------------
function capture_image_done_one(){	
	if(document.getElementById('camera_canvas_one')){
		var canvas = document.getElementById('camera_canvas_one');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/camera_session_employee_photo_one.php"); ?>', function(code, text) {
			$("#avater_image_one").html('<img src="<?=base_url();?>'+text+'" style="width:50px;" id="view_image_one"/>');
			$("#photo_avater_value_one").val(text);
			$("#photo_avater_one").css({"width":"170px","float":"right"});
			$('#image_test_avater_one').val('success');
			$('#camera_model_one').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file_one").on("change",function(){
	var fileUpload = document.getElementById('other_file_one');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas_one";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult_one").textContent = "";
				document.getElementById("DesiredResult_one").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_camera_one(){	
	$('#camera_model_one').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video#video_one');
	const videoSelect = document.querySelector('select#videoSource_one');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_one() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start_one;
//-------------
	return camera_start_one();
}
function snap_one() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas_one";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video_one'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult_one").textContent = "";
    document.getElementById("DesiredResult_one").appendChild(cv);	
}
function retake_image_one(){
	var cm = document.createElement("video");
    cm.width = w;
    cm.id = "video_one" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult_one").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult_one").html('<video id="video_one" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video#video_one');
	const videoSelect = document.querySelector('select#videoSource_one');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_one() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start_one;
//-------------
	return camera_start_one();
}
$(document).ready(function(){
	$('#camera_model_one').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------

//----------------------------------------------------------------------------------

//-------------------TWO---------------------------------------------------------------
function capture_image_done_two(){	
	if(document.getElementById('camera_canvas_two')){
		var canvas = document.getElementById('camera_canvas_two');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/camera_session_employee_photo_two.php"); ?>', function(code, text) {
			$("#avater_image_two").html('<img src="<?=base_url();?>'+text+'" style="width:50px;" id="view_image_two"/>');
			$("#photo_avater_value_two").val(text);
			$("#photo_avater_two").css({"width":"170px","float":"right"});
			$('#image_test_avater_two').val('success');
			$('#camera_model_two').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file_two").on("change",function(){
	var fileUpload = document.getElementById('other_file_two');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas_two";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult_two").textContent = "";
				document.getElementById("DesiredResult_two").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_camera_two(){	
	$('#camera_model_two').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video#video_two');
	const videoSelect = document.querySelector('select#videoSource_two');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_two() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start_two;
//-------------
	return camera_start_two();
}
function snap_two() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas_two";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video_two'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult_two").textContent = "";
    document.getElementById("DesiredResult_two").appendChild(cv);	
}
function retake_image_two(){
	var cm = document.createElement("video");
    cm.width = w;
    cm.id = "video_two" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult_two").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult_two").html('<video id="video_two" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video#video_two');
	const videoSelect = document.querySelector('select#videoSource_two');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start_two() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start_two;
//-------------
	return camera_start_two();
}
$(document).ready(function(){
	$('#camera_model_two').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------

//----------------------------------------------------------------------------------
function hold_am_employee_click(id){	
	$('#hold_hidden_id').val(id);
	$('#hold_model').modal('show');
}

function deactive_model(id){	
	$('#dactive_hidden_id').val(id);
	$('#deactive_model').modal('show');
}

function view_profile(id){
	var profile_id = id; 
	if(profile_id != ''){	
		$.ajax({  
			url:"<?=base_url('assets/ajax/employee_single_view.php');?>",  
			method:"POST",  
			data:{view_id:profile_id},
			beforeSend:function(){					
				$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
			},
			success:function(data){	
				$('#view_details').html(data);    
				$('#view_model_details').modal('show');
				$('#data-loading').html('');
			}  
		});  
	}		
}	
$(document).ready(function() {	
	var table_booking = $('#extra_phone_number_recharge_table').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": false,
		"info": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/extra_phone_number_recharge_datatable.php"
    });
	
    var table = $('#employee_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 1, "asc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/employee_directory_datatable.php",
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table.buttons().container().appendTo($('#export_buttons'));
});

let employee_card_information = (card_number, employee_id) => {
	if(card_number == ''){
		$('#old_card_number').attr('placeholder', 'No Card Assigned!');
	}
	$('#old_card_number').val(card_number);
	$('#card_employee_id').val(employee_id);
}

$('#update_employeee_card').on('submit', () => {
	event.preventDefault();
	$('#card_error').html('');
	let new_card = $('#new_card_number').val();
	let employee_id = $('#card_employee_id').val();
	$.ajax({
		url:"<?=base_url('assets/ajax/update_employee_card.php');?>",  
		method:"POST",  
		data:{new_card, employee_id},
		beforeSend:function(){					
			$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
		},
		success:function(data){
			$('#data-loading').html('');
			let info = JSON.parse(data);
			if(info.error){
				$('#card_error').html(info.message);
				return;
			}

			$('#update_employeee_card').trigger('reset');
			$('#employee_card_modal').modal('toggle');
			$('#employee_data_table').DataTable().ajax.reload( null , false);
			
		}
	});  
})
</script>