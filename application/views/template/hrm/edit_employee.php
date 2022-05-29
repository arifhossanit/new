<div class="content-wrapper">	.
		<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employees  Directory</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Edit Employees  Directory</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">				
				<!---------------------------------------------------->
					<div class="card card-primary" >
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="col-md-12">
									<div class="box box-primary">
										<div class="box-body">
											<div class="tshadow mb25 bozero">
												<h4 class="pagetitleh2" style="text-decoration:undderline;">Basic Information </h4>
												<div class="around10">
													
													
													<div class="row">
													<div class="col-md-4">
															<div class="form-group">
																<label>First Name</label><small class="req"> *</small>
																<input name="f_name" value="<?php if(!empty($edit)){ echo $edit->f_name; } ?>" placeholder="First Name" type="text" class="form-control" autocomplete="off" required/>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label>Last Name</label><small class="req"> *</small>
																<input name="l_name" value="<?php if(!empty($edit)){ echo $edit->l_name; } ?>" placeholder="Last Name" type="text" class="form-control" required/>
															</div>
														</div>

														<div class="col-md-4">
															<div class="form-group">
																<label>Religion</label><small class="req"> *</small>
																<select class="form-control select2" name="religion" autocomplete="off" required>
																	<?php if(!empty($edit->religion)){ echo '<option value="'.$edit->religion.'">'.$edit->religion.'</option>'; } else{ echo '<option value="">Select</option>'; } ?>	
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
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->gender.'">'.$edit->gender.'</option>'; }else{ echo '<option value="">Select</option>'; } ?>
																	<option value="Male">Male</option>
																	<option value="Female">Female</option>
																	<option value="Other">Other</option>
																</select>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label>Marital Status</label><small class="req"> *</small>
																<select class="form-control select2" name="marital_status" autocomplete="off" required>
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->marital_status.'">'.$edit->marital_status.'</option>'; }else{ echo '<option value="">Select</option>'; } ?>
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
																<input name="date_of_birth" value="<?php if(!empty($edit)){ echo $edit->date_of_birth; } ?>" type="text" class="form-control" placeholder="DD/MM/YYYY" id="employ_date_of_birth" data-target="#employ_date_of_birth" data-toggle="datetimepicker" autocomplete="off" required/>		
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group"><small class="req"> *</small>
																<label>Date Of Joining</label><small class="req"> *</small>
																<input name="date_of_joining" value="<?php if(!empty($edit)){ echo $edit->date_of_joining; } ?>" id="employ_date_of_joining" placeholder="DD/MM/YYYY"  data-target="#employ_date_of_joining" data-toggle="datetimepicker" type="text" class="form-control" autocomplete="off" required/>
															</div>
														</div>
													</div>
													
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label>Blood Group</label><small class="req"> *</small>
																<select class="form-control select2" name="blood_group" autocomplete="off" required>
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->blood_group.'">'.$edit->blood_group.'</option>'; }else{ echo '<option value="">Select</option>'; } ?>
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
																<input name="personal_Phone" value="<?php if(!empty($edit)){ echo $edit->personal_Phone; } ?>" placeholder="Personal Phone" type="number" class="form-control" autocomplete="off" required/>
															</div>
														</div>																	
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Personal Email</label>
																<input id="email" name="email" value="<?php if(!empty($edit)){ echo $edit->email; } ?>" placeholder="Personal Email" type="email" class="form-control" value="" autocomplete="off" <?php if(!empty($edit->email)){ echo 'readonly'; }else{ echo 'required'; } ?>>
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Photo</label><small class="req"> *</small>
																<input class="form-control" type="file" name="avater_photo" style="padding-top:3px;" autocomplete="off"  <?php if(!empty($edit)){}else{ echo 'required'; } ?>>
															</div>
														</div>																									
														
													</div>
													
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label>Company Phone </label>
																<input name="Company_phone" value="<?php if(!empty($edit)){ echo $edit->Company_phone; } ?>" placeholder="Company Phone" type="number" class="form-control" autocomplete="off"/>
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Company Email</label>
																<input name="company_email" value="<?php if(!empty($edit)){ echo $edit->company_email; } ?>" placeholder="Company Email" type="email" class="form-control" value="" autocomplete="off">
															</div>
														</div>																
														<div class="col-md-3">
															<div class="form-group">
																<label><abbr title="National Identity Card">NID<abbr> / Passport</label><small class="req"> *</small>
																<input name="nid_number" value="<?php if(!empty($edit)){ echo $edit->nid_number; } ?>" placeholder="NID / Passport" type="text" class="form-control" value="" autocomplete="off">
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
																				if(!empty($edit) and $row->branch_id == $edit->branch){
																					$selected = 'selected';
																				}else{
																					$selected = '';
																				}
																				echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
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
																<textarea name="current_address" placeholder="Current Address" class="form-control" autocomplete="off" required><?php if(!empty($edit)){ echo $edit->current_address; } ?></textarea>
															</div>
														</div>
														
														<div class="col-md-6">
															<div class="form-group">
																<label>Permanent Address</label><small class="req"> *</small>
																<textarea name="permanent_address" placeholder="Permanent Address" class="form-control" autocomplete="off" required><?php if(!empty($edit)){ echo $edit->permanent_address; } ?></textarea>
															</div>
														</div>
													</div>
													
													<div class="row">	
														<div class="col-md-3">
															<div class="form-group">
																<label>Emergency Contact Name 1</label><small class="req"> *</small>
																<input name="emergency_name1" placeholder="Emergency Contact Name 1" type="text" class="form-control" value="<?php if(!empty($edit)){ echo $edit->emergency_contact_name ; } ?>" autocomplete="off" required>
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Emergency Contact Relation 1</label><small class="req"> *</small>
																<select name="emergency_relation1" class="form-control select2" required>
																	<?php
																	if(!empty($edit->emergency_contact_relation)){
																		echo '<option value="'.$edit->emergency_contact_relation.'">'.$edit->emergency_contact_relation.'</option>';
																	}
																	?>
																	<option value="">--select--</option>
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
																<input id="mobileno" name="emergency_no1" value="<?php if(!empty($edit)){ echo $edit->emergency_no1; } ?>" placeholder="Emergency Contact Number 1" type="text" class="form-control" autocomplete="off" required>
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Emergency Contact Attachment 1</label><small class="req"> *</small>
																<input class="form-control" type="file" name="emergency_attachment_1"style="padding-top:3px;" autocomplete="off"  <?php if(!empty($edit)){}else{ echo 'required'; } ?>>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label>Emergency Contact Name 2</label>
																<input name="emergency_name2" placeholder="Emergency Contact Name 2" type="text" class="form-control" value="<?php if(!empty($edit)){ echo $edit->emergency_contact_name2 ; } ?>" autocomplete="off">
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Emergency Contact Relation 2</label>
																<select name="emergency_relation2" class="form-control select2">
																	<?php
																	if(!empty($edit->emergency_contact_relation2)){
																		echo '<option value="'.$edit->emergency_contact_relation2.'">'.$edit->emergency_contact_relation2.'</option>';
																	}
																	?>
																	<option value="">--select--</option>
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
																<input id="mobileno" name="emergency_no2" value="<?php if(!empty($edit)){ echo $edit->emergency_no2; } ?>" placeholder="Emergency Contact Number 2" type="text" class="form-control" autocomplete="off">
															</div>
														</div>
														
														
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Emergency Contact Attachment 2</label>
																<input class="form-control" type="file" name="emergency_attachment_2" style="padding-top:3px;" autocomplete="off">
															</div>
														</div>
														
													</div>
													
													<div class="row">												
														<div class="col-md-12">
															<label>Educational Qualification</label>
															<table class="table table-bordered table-hover">
																<thead>
																	<tr>
																		<td style="width: 4%;">Delete</td>
																		<td>Level Of Education</td>
																		<td>Passing Year</td>
																		<td>Institution</td>
																		<td style="width: 12%;">Board</td>
																		<td>Group/Subject</td>
																		<td>Division/CGPA</td>
																		<td style="width: 8%;">GPA/CGPA Scale</td>
																	</tr>
																</thead>
																<tbody id="education_qualification_body">
																	<?php
																		$i = 1;
																		foreach($education_qualification as $education){ ?>
																		<tr id="edu_<?php echo $i; ?>">
																			<input type="hidden" name="education_id[]" value="<?php echo $education->id;?>">
																			<td>
																				<form action="<?php global $home; echo $home.'edit-employee';?>" method="post">
																					<input type="hidden" name="delete_employee" value="yes"/>
																					<input type="hidden" name="hidden_id" value="<?php echo $edit->id; ?>"/>
																					<input type="hidden" name="delete_information_table" value="employee_education_qualification">
																					<input type="hidden" name="information_table_id" value="<?php echo $education->id; ?>">
																					<button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>
																				</form>
																			</td>
																			<td>
																				<select name="qualification[]" class="select2 form-control" style="width: 100%;">
																					<?php echo '<option value="'.$education->level_of_education.'">'.$education->level_of_education.'</option>'; ?>
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
																				<input class="form-control datepicker date-only-year" type="text" name="passing_year[]" placeholder="Passing Year" class="form-control" autocomplete="off" value="<?php echo $education->passing_year;?>"/>										
																			</td>
																			<td>
																				<input name="institution[]" placeholder="Institution" type="text" class="form-control" autocomplete="off" value="<?php echo $education->institution;?>">
																			</td>
																			<td>
																				<select name="board[]" class="form-control select2" style="width: 100%;">
																					<?php echo '<option value="'.$education->board.'">'.$education->board.'</option>'; ?>
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
																				<input name="group[]" placeholder="Group" type="text" class="form-control" autocomplete="off" value="<?php echo $education->edu_group;?>">
																			</td>
																			<td>
																				<select name="class[]" class="select2 select2-hidden-accessible form-control" data-placeholder="Select Class/GPA" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true">
																					<?php echo '<option value="'.$education->class.'">'.$education->class.'</option>'; ?>
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
																				<input name="gpa[]" placeholder="CGPA" type="text" class="form-control" autocomplete="off" value="<?php echo $education->gpa;?>">
																			</td>
																		</tr>
																	<?php $i++;
																	} ?>
																	<?php if($i == 1){ ?>
																		<tr id="edu_1">
																			<input type="hidden" name="education_id[]" value="new">
																			<td></td>
																			<td>
																				<select name="qualification[]" class="select2 form-control" style="width: 100%;">
																					<option value="">Level</option>
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
																	<?php }?>																
																</tbody>
															</table>
															<button type="button" class="btn btn-primary" onclick="addEducation()">Add Education</button>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label>Note</label>
																<textarea name="note" placeholder="note" class="form-control" autocomplete="off"><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
										
										<div class="box-body">
											<div class="tshadow mb25 bozero">
												<h4 class="pagetitleh2" style="text-decoration:underline;">Employment History </h4>
												<div class="around10">
													<div class="row">
														<div class="col-md-12">
															<table class="table table-bordered table-hover">
																<thead>
																	<tr>
																		<td style="width: 4%;">Delete</td>
																		<td>Employer/Company Name</td>
																		<td>Designation</td>
																		<td>Department</td>
																		<td style="width: 12%;">From</td>
																		<td style="width: 12%;">To</td>
																		<td>Core Responsibility</td>
																		<td>Reason For Leaving</td>
																	</tr>
																</thead>
																<tbody id="employment_history_body">
																	<?php $i = 1; 
																		foreach($employment_history as $history){ ?>
																		<tr id="empHst_<?php echo $i; ?>">
																			<input type="hidden" name="history_id[]" value="<?php echo $history->id; ?>">
																			<td>
																				<form action="<?php global $home; echo $home.'edit-employee';?>" method="post">
																					<input type="hidden" name="delete_employee" value="yes"/>
																					<input type="hidden" name="hidden_id" value="<?php echo $edit->id; ?>"/>
																					<input type="hidden" name="delete_information_table" value="employment_history">
																					<input type="hidden" name="information_table_id" value="<?php echo $history->id; ?>">
																					<button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>
																				</form>
																			</td>
																			<td>
																				<input name="company_name[]" placeholder="Company Name" type="text" class="form-control" autocomplete="off" value="<?php echo $history->company_name; ?>">
																			</td>
																			<td>
																				<input name="designation_emp[]" placeholder="Designation" type="text" class="form-control" autocomplete="off" value="<?php echo $history->designation; ?>">
																			</td>
																			<td>
																				<input name="department_emp[]" type="text" placeholder="Department" class="form-control" value="<?php echo $history->department; ?>"/>										
																			</td>
																			<td>
																				<input name="from[]" placeholder="From" type="text" class="form-control datepicker" autocomplete="off" value="<?php echo $history->from_date; ?>">
																			</td>
																			<td>
																				<input name="to[]" placeholder="To" type="text" class="form-control datepicker" autocomplete="off" value="<?php echo $history->to_date; ?>">
																			</td>
																			<td>
																				<input name="responsibility[]" placeholder="Core Responsibility" type="text" class="form-control" autocomplete="off" value="<?php echo $history->responsibility; ?>">
																			</td>
																			<td>
																				<input name="leaving_reason[]" placeholder="Leave Reason" type="text" class="form-control" autocomplete="off" value="<?php echo $history->leaving_reason; ?>">
																			</td>
																		</tr>
																	<?php  $i++;
																	} ?>
																	<?php if($i == 1){ ?>
																		<tr id="empHst_1">
            																<input type="hidden" name="history_id[]" value="new">
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
																	<?php }?>
																</tbody>
															</table>
															<button type="button" class="btn btn-primary mb-3" onclick="addEmploymentHistory()">Add Employee History</button>
														</div>														
													</div>													
												</div>
											</div>
										</div>

										<div class="box-body">
											<div class="tshadow mb25 bozero">
												<h4 class="pagetitleh2" style="text-decoration:underline;">Professional Training/Qualification </h4>
												<div class="around10">
													<div class="row">
														<div class="col-md-12">
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
																	<?php $i = 1; 
																		foreach($professional_training as $training){ ?>
																		<tr id="training_<?php echo $i; ?>">
																			<input type="hidden" name="training_id[]" value="<?php echo $training->id; ?>">
																			<td>
																				<form action="<?php global $home; echo $home.'edit-employee';?>" method="post">
																					<input type="hidden" name="delete_employee" value="yes"/>
																					<input type="hidden" name="hidden_id" value="<?php echo $edit->id; ?>"/>
																					<input type="hidden" name="delete_information_table" value="employee_professional_training">
																					<input type="hidden" name="information_table_id" value="<?php echo $training->id; ?>">
																					<button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>
																				</form>
																			</td>
																			<td>
																				<input name="training_name[]" placeholder="Name of the Training" type="text" class="form-control" autocomplete="off" value="<?php echo $training->training_name; ?>">
																			</td>
																			<td>
																				<input name="training_institution[]" placeholder="Institution" type="text" class="form-control" autocomplete="off" value="<?php echo $training->institution; ?>">
																			</td>
																			<td>
																				<input name="place[]" placeholder="Place" type="text" class="form-control" value="<?php echo $training->place; ?>"/>										
																			</td>
																			<td>
																				<input name="completion_year[]" placeholder="Completion Year" type="text" class="form-control datepicker date-only-year" autocomplete="off" value="<?php echo $training->completion_year; ?>">
																			</td>
																			<td>
																				<input name="duration[]" placeholder="Duration" type="text" class="form-control" autocomplete="off" value="<?php echo $training->duration; ?>">
																			</td>
																		</tr>
																	<?php $i++;
																	} ?>
																	<?php if($i == 1){ ?>
																		<tr id="training_1">
																			<input type="hidden" name="training_id[]" value="new">
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
																	<?php }?>
																</tbody>
															</table>
															<button type="button" class="btn btn-primary mb-3" onclick="addTraining()">Add More Training</button>
														</div>														
													</div>													
												</div>
											</div>
										</div>

										<div class="box-body">
											<div class="tshadow mb25 bozero">
												<h4 class="pagetitleh2" style="text-decoration:underline;">Family Details </h4>
												<div class="around10">
													<div class="row">
														<div class="col-md-12">
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
																	<?php $i = 1; 
																		foreach($employee_family as $relation){ ?>
																		<tr id="family_<?php echo $i; ?>">
																			<input type="hidden" name="relation_id[]" value="<?php echo $relation->id; ?>">
																			<td>
																				<form action="<?php global $home; echo $home.'edit-employee';?>" method="post">
																					<input type="hidden" name="delete_employee" value="yes"/>
																					<input type="hidden" name="hidden_id" value="<?php echo $edit->id; ?>"/>
																					<input type="hidden" name="delete_information_table" value="employee_family">
																					<input type="hidden" name="information_table_id" value="<?php echo $relation->id; ?>">
																					<button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-times"></i></button>
																				</form>
																			</td>
																			<td>
																				<select name="relation[]" class="form-control select2">
																					<?php echo '<option value="'.$relation->relation.'">'.$relation->relation.'</option>'; ?>
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
																				<input name="name[]" type="text" class="form-control" autocomplete="off" value="<?php echo $relation->name; ?>">
																			</td>
																			<td>
																				<input name="occupation[]" type="text" class="form-control" value="<?php echo $relation->occupation; ?>"/>										
																			</td>
																			<td>
																				<input name="contact_number[]" type="text" class="form-control" autocomplete="off" value="<?php echo $relation->contact_number; ?>">
																			</td>
																			<td>
																				<input name="contact_address[]" type="text" class="form-control" autocomplete="off" value="<?php echo $relation->contact_address; ?>">
																			</td>
																		</tr>
																	<?php $i++;
																	} ?>
																	<?php if($i == 1){ ?>
																		<tr id="family_1">
																			<input type="hidden" name="relation_id[]" value="new">
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
																	<?php }?>
																</tbody>
															</table>
															<button type="button" class="btn btn-primary mb-3" onclick="addFamily()">Add More Family</button>
														</div>														
													</div>													
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
																<input name="employee_id" value="<?php if(!empty($edit)){ echo $edit->employee_id; } ?>" placeholder="Employee ID" type="text" class="form-control" autocomplete="off" <?php if(!empty($edit->employee_id)){ echo 'readonly'; } else{ echo 'required'; }?>/>
															</div>
														</div>
														<div class="col-md-7">
															<div class="row">
																<div class="col-md-4">
																	<div class="form-group">
																		<label>Role</label><small class="req"> *</small>
																		<select name="role" class="form-control select2" autocomplete="off" required/>
																			<option value="">Select</option>
																			<?php
																			if(!empty($role)){
																				foreach($role as $row){
																					if(!empty($edit) and $row->role_id == $edit->role){
																						$selected = 'selected';
																					}else{
																						$selected = '';
																					}
																					if($_SESSION['super_admin']['role_id'] == '2805597208697462328'){
																						echo '<option value="'.$row->role_id.'" '.$selected.'>'.$row->role_name.'</option>';
																					}else{
																						if($row->role_id != '2805597208697462328' AND $row->role_id != '3386233961062517400'){
																							echo '<option value="'.$row->role_id.'" '.$selected.'>'.$row->role_name.'</option>';
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
																		<!-- This field was changed! Thats why all designations are beeing iterated! -->
																		<!-- select name="designation" class="form-control select2-readonly" autocomplete="off" required>																					 -->
																			<?php
																			if(!empty($designation)){
																				foreach($designation as $row){
																					if(!empty($edit) and $row->designation_id == $edit->designation){ ?>
																						<input type="hidden" name="designation" value="<?= $row->designation_id ?>">
																						<input type="text" name="designation_show" class="form-control" value="<?= $row->designation_name ?>" readonly>
																			<?php	}
																				}
																			}
																			?>
																		<!-- </select> -->
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
																					if(!empty($edit) and $row->department_id == $edit->department){
																						$selected = 'selected';
																					}else{
																						$selected = '';
																					}
																					echo '<option value="'.$row->department_id.'" '.$selected.'>'.$row->department_name.'</option>';
																				}
																			}
																			?>
																		</select> 
																	</div>
																</div>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label>Grade</label><small class="req"> *</small>
																<select id="grade" name="grade" class="form-control select2" autocomplete="off" required>
																	<option value="select">Select</option>
																	<?php
																	if(!empty($grade)){
																		foreach($grade as $row){
																			if(!empty($edit) and $row->grade_id == $edit->grade_id){
																				$selected = 'selected';
																			}else{
																				$selected = '';
																			}
																			echo '<option value="'.$row->grade_id.'" '.$selected.'>'.$row->grade_name.'</option>';
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
																<input name="basic_salary" value="<?php if(!empty($edit)){ echo $edit->basic_salary; } ?>" placeholder="Basic Salary" type="number" class="form-control" autocomplete="off" readonly />
															</div>
														</div>
														
														<div class="col-md-2">
															<div class="form-group">
																<label>Mobile Allowance</label>
																<input name="mobile_allowance" value="<?php if(!empty($edit)){ echo $edit->mobile_allowance; } ?>" placeholder="Mobile Allowance" type="number" class="form-control" autocomplete="off" readonly />
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Salary Pay Method</label><small class="req"> *</small>
																<select name="salary_pay_method" class="form-control select2" autocomplete="off" required>
																	<?php if(!empty($edit)){
																			if($edit->salary_pay_method == 'cash'){
																				echo '<option value="cash" selected>Cash</option>
																					  <option value="bank">Bank</option>';
																			}else{
																				echo '<option value="cash">Cash</option>
																					  <option value="bank" selected>Bank</option>';
																			}
																		}else{ 
																			echo '<option value="">Select</option>
																				  <option value="cash">Cash</option>
																				  <option value="bank">Bank</option>'; 
																		} ?>
																	
																	
																</select>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Contract Type</label><small class="req"> *</small>
																<select name="contruct_type" class="form-control select2" autocomplete="off" required>
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->contruct_type.'">'.$edit->contruct_type.'</option>'; }else{ echo '<option value="">Select</option>'; } ?>
																	<option value="Regular">Regular</option>
																	<option value="Probation">Probation</option>																						
																</select>
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Work Shift</label><small class="req"> *</small>
																<select name="work_shift" class="form-control select2" autocomplete="off" required>
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->work_shift.'">'.$edit->work_shift.'</option>'; }else{ echo '<option value="">Select</option>'; } ?>
																	<option value="Day">Day</option>
																	<option value="Night">Night</option>																						
																</select>
															</div>
														</div>
														
														<div class="col-md-2">
															<div class="form-group" >
																<label>Assign Bed</label>
																<input name="assign_bed" placeholder="Assign Bed Name" value="<?php if(!empty($edit)){ echo $edit->assign_bed; } ?>" type="text" class="form-control" autocomplete="off" />
															</div>
														</div>

													</div>
													
												</div>

											</div>
										</div>
										
										<script>
										$('document').ready(function(){
											if($('select[name="salary_pay_method"]').val() == 'bank'){
												$("#bank-account-information").css({"display":"block"});
												$('input[name="bank_account_title"]').prop('required', true);
												$('input[name="bank_account_number"]').prop('required', true);
												$('input[name="bank_name"]').prop('required', true);
												$('input[name="bank_branch_name"]').prop('required', true);
												$('select[name="account_type"]').prop('required', true);
											}
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
																<input name="bank_account_title" value="<?php if(!empty($edit)){ echo $edit->bank_account_title; } ?>" placeholder="Account Title" type="text" class="form-control" autocomplete="off"/>
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Bank Account Number</label>
																<input name="bank_account_number" value="<?php if(!empty($edit)){ echo $edit->bank_account_number; } ?>" placeholder="Bank Account Number" type="text" class="form-control" autocomplete="off"/>
															</div>
														</div>
														
														<div class="col-md-2">
															<div class="form-group">
																<label>Bank Name</label>
																<input name="bank_name" value="<?php if(!empty($edit)){ echo $edit->bank_name; } ?>" placeholder="Bank Name" type="text" class="form-control" autocomplete="off"/>
															</div>
														</div>

																<input name="bfsc_code" value="<?php if(!empty($edit)){ echo $edit->bfsc_code; } ?>" placeholder="BFSC Code" type="hidden" class="form-control" autocomplete="off"/>

														<div class="col-md-2">
															<div class="form-group">
																<label>Bank Branch Name</label>
																<input name="bank_branch_name" value="<?php if(!empty($edit)){ echo $edit->bank_branch_name; } ?>" placeholder="Bank Branch Name" type="text" class="form-control" autocomplete="off"/>
															</div>
														</div>
														
														<div class="col-md-2">
															<div class="form-group">
																<label>Account Type</label><small class="req"> </small>
																<select name="account_type" class="form-control select2" autocomplete="off">
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->account_type.'">'.$edit->account_type.'</option>'; }else{ echo '<option value="">Select</option>'; } ?>
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
											<h4 class="pagetitleh2" style="text-decoration:undderline;">Social Media Link</h4>
											<div class="row around10">
												<div class="col-md-6">
													<div class="form-group">
														<label>Facebook URL</label>
														<input name="facebook" value="<?php if(!empty($edit)){ echo $edit->facebook; } ?>" placeholder="Facebook URL" type="url" class="form-control">
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>Twitter URL</label>
														<input name="twitter" value="<?php if(!empty($edit)){ echo $edit->twitter; } ?>" placeholder="Twitter URL" type="url" class="form-control">
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>Linkedin URL</label>
														<input name="linkedin" value="<?php if(!empty($edit)){ echo $edit->linkedin; } ?>" placeholder="Linkedin URL" type="url" class="form-control">
													</div>
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>Instagram URL</label>
														<input id="instagram" name="instagram" value="<?php if(!empty($edit)){ echo $edit->instagram; } ?>" placeholder="Instagram URL" type="url" class="form-control" value="">
													</div>
												</div>
											</div>
										</div>  
										
										<div id="upload_documents_hide_show">
											<div class="row">
												<div class="col-md-12">
													<div class="tshadow bozero">
														<h4 class="pagetitleh2" style="text-decoration:undderline;">Upload Documents</h4>

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
											<a href="<?=base_url('admin/employ-directory')?>" class="btn btn-danger">Go Back</a>
											<button class="btn btn-warning" name="update_employee" type="submit">Update Information</button>
										</div>														
									</div>
								</form>
							</div>               
						</div>
					</div>
				<!---------------------------------------------------->
				
				</div>
	

			</div>
		</div>
	</div>
</div>

<script>
	$('.datepicker.date-only-year').datepicker({
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
		autoclose: true,
	});
	$('.datepicker').datepicker({
		format: 'yyyy/mm/dd',
		todayHighlight:'TRUE',
		autoclose: true,
	});
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
</script>