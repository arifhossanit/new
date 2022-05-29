<?php 
// error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){ 
	$row = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where id = '".$_POST['view_id']."'"));
	$education_qualification = $mysqli->query("SELECT * from employee_education_qualification where employee_id = '".$_POST['view_id']."'");
	$employment_history = $mysqli->query("SELECT * from employment_history where employee_id = '".$_POST['view_id']."'");
	$professional_training = $mysqli->query("SELECT * from employee_professional_training where employee_id = '".$_POST['view_id']."'");
	$employee_family = $mysqli->query("SELECT * from employee_family where employee_id = '".$_POST['view_id']."'");
	$role = mysqli_fetch_assoc($mysqli->query("SELECT * from roles where role_id = '".$row['role']."'"));
	$department = mysqli_fetch_assoc($mysqli->query("SELECT * from department where department_id = '".$row['department']."'"));
	$designation  = mysqli_fetch_assoc($mysqli->query("SELECT * from designation where designation_id = '".$row['designation']."'"));
	$branchn = mysqli_fetch_assoc($mysqli->query("SELECT branch_name from branches where branch_id = '".$row['branch']."'"));
	$rating = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as total_rating, sum(value) as total_value from employee_rating where employee_id = '".$row['id']."' and month = '".date('m')."' and year = '".date('Y')."'"));
	$rt_point = 0;
	if($rating['total_rating'] != 0){
		$rt_point = round(($rating['total_value'] ) / $rating['total_rating'],'2');
	}
?>
<style>
.ratin .fas{
	color:#ffc107;
}
.profile_img{
    height: 150px;
    width: 150px;
    border-radius: 50%;
    margin-top: 15px;
    margin-bottom: 15px;
}
.name_div{
    background-color: #424242;
    color: white;
    padding: 9px;
}
.custom_btn{
    font-size: 20px;
    margin-top: 5px;
}
.phone_div{
    background-color: rgba(0, 145, 234, 0.7);
    color: white;
    padding: 5px;
}
.email_div{
    background-color: rgba(0, 145, 234, 1);
    color: white;
    padding: 5px;
}
.personal_info{
    padding: 45px;
}
.big_icons{
    height: 38px;
    width: 38px;
    text-align: center;
    color: white;
    font-size: 25px;
    background-color: rgba(0, 145, 234, 0.7);
    border-radius: 50%;
}
.detailed_info{
    padding: 55px;
}
.information-box{
    margin-bottom: 20px;
}
.left-bar{
	background-color: rgba(245, 245, 245, 0.9);
}
.one-page{
	height: 1500px;
}
.col-print-1 {width:8%;  float:left;}
.col-print-2 {width:16%; float:left;}
.col-print-3 {width:25%; float:left;}
.col-print-4 {width:33%; float:left;}
.col-print-5 {width:42%; float:left;}
.col-print-6 {width:50%; float:left;}
.col-print-7 {width:58%; float:left;}
.col-print-8 {width:66%; float:left;}
.col-print-9 {width:75%; float:left;}
.col-print-10{width:83%; float:left;}
.col-print-11{width:92%; float:left;}
.col-print-12{width:100%; float:left;}
.bottom-right{
	position: fixed;
    /* width: 100%; */
    right: 65px;
    bottom: 65px;
}
.sig-text{
    text-decoration: overline;
}
@media print {
    #cv_print{
        display: static;
    }
}
@media screen  {
    #cv_print{
        display: none;
    }
}
</style>
<section class="content">
	<div id="cv_print">
        <div class="row">
            <div class="col-print-4 left-bar one-page">
                <div class="row text-center"><div class="col-sm"><img class="profile_img profile-user-img img-responsive" src="<?php echo $home.$row['photo']; ?>" alt="<?php echo $home.$row['full_name']; ?>"></div></div>
                <div class="name_div">
                    <div class="row text-center">
                        <div class="col-print-12"><h3><?php echo $row['full_name']; ?></h3></div>
                    </div>
                </div>
                <div class="phone_div">
                    <div class="row">
                        <div class="col-print-2 text-center"><i class="fa fa-phone custom_btn" aria-hidden="true"></i></div>
                        <div class="col-print-10"><h5><?php echo $row['personal_Phone']; ?></h5></div>
                    </div>
                </div>
                <div class="email_div">
                    <div class="row">
                        <div class="col-print-2 text-center"><i class="far fa-envelope custom_btn"></i></div>
                        <div class="col-print-10"><h5><?php echo $row['company_email']; ?></h5></div>
                    </div>
                </div>
                <div class="row">
                    <div class="personal_info">
                        <div class="col-print-12 ">
                            <h2 class="mb-0">About Me</h2>
                        </div>
                        <div class="col-print-12">
                        <hr>
                        </div>
                        <div class="col-print-12">
							<div class="row">
								<div class="col-print-6">Date of birth:</div>
								<div class="col-print-6"><?php echo $row['date_of_birth']; ?></div>
							</div>
							<div class="row">
								<div class="col-print-6">Material Status: </div>
								<div class="col-print-6"><?php echo $row['marital_status']; ?></div>
							</div>
							<div class="row">
								<div class="col-print-6">Religion: </div>
								<div class="col-print-6"><?php echo $row['religion']; ?></div>
							</div>
							<div class="row">
								<div class="col-print-6">Current Addr: </div>
								<div class="col-print-6"><?php echo $row['current_address']; ?></div>
							</div>
							<div class="row">
								<div class="col-print-6">Permanent Addr: </div>
								<div class="col-print-6"><?php echo $row['permanent_address']; ?></div>
							</div>
                        </div>
                    </div>
                </div>
                <div class="row"></div>
                <div class="row"></div>
                <div class="row"></div>
            </div>


            <div class="col-print-8 detailed_info one-page">
                <!-- Experience -->
                <div class="row information-box">
                    <div class="col-print-12">
                        <div class="row">
                            <div class="col-print-1">
                                <div class="big_icons"><i class="fas fa-briefcase"></i></div>
                            </div>
                            <div class="col-print-11">
                                <h2>Work Experience</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-print-12"><hr></div>
                        </div>
						<?php if($employment_history->num_rows != 0){?>
							<?php while($employment_history_row = mysqli_fetch_assoc($employment_history)){?>
								<div class="row">
									<div class="col-print-5">
										<div class="row">
											<div class="col-print-12">
												<h5><?php echo $employment_history_row['designation'] ?></h5>
											</div>
											<div class="col-print-12">
												<h6> <span style="font-size: 0.9em;">from</span>  <?php echo $employment_history_row['from_date'] ?> <span style="font-size: 0.9em;">to</span> <?php echo $employment_history_row['to_date'] ?></h6>
											</div>
										</div>
									</div>
									<div class="col-print-7 mb-3 pl-2">
										<div class="row">
											<div class="col-print-12">
												<h5 class="ml-0 pl-0"><?php echo $employment_history_row['company_name'] ?></h5>
											</div>
											<div class="col-print-12">
												<p><?php echo $employment_history_row['responsibility'] ?></p>
											</div>
										</div>
									</div>
								</div>
						<?php 	}
							} ?>
                    </div>
                </div>
                <!-- End Experience -->
                <!-- Professional Qualification -->
                <div class="row information-box">
                    <div class="col-print-12">
                        <div class="row">
                            <div class="col-print-1">
                                <div class="big_icons"><i class="fas fa-wrench"></i></div>
                            </div>
                            <div class="col-print-11">
                                <h2>Professional Training</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-print-12"><hr></div>
                        </div>
                        <div class="row">
							<?php if($professional_training->num_rows != 0){?>
								<?php while($professional_training_row = mysqli_fetch_assoc($professional_training)){?>
									<div class="col-print-5">
										<div class="row">
											<div class="col-print-12">
												<h5 class="ml-0 pl-0"><?php echo $professional_training_row['training_name'] ?></h5>
											</div>
											<div class="col-print-12">
												<h6><?php echo $professional_training_row['completion_year'].", duration: ".$professional_training_row['duration'] ?></h6>
											</div>
										</div>
									</div>
									<div class="col-print-7 mb-3 pl-2">
										<div class="row">											
											<div class="col-print-12">
												<h5><?php echo $professional_training_row['institution'] ?></h5>
											</div>											
											<div class="col-print-12">
												<h5><?php echo $professional_training_row['place'] ?></h5>
											</div>
										</div>
									</div>
							<?php }
							} ?>
                        </div>
                    </div>
                </div>
                <!-- End Professional Qualification -->
                <!-- Education -->
                <div class="row information-box">
                    <div class="col-print-12">
                        <div class="row">
                            <div class="col-print-1">
                                <div class="big_icons"><i class="fas fa-graduation-cap"></i></div>
                            </div>
                            <div class="col-print-11">
                                <h2>Education</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-print-12"><hr></div>
                        </div>
                        <div class="row">
							<?php if($education_qualification->num_rows != 0){?>
								<?php while($education_qualification_row = mysqli_fetch_assoc($education_qualification)){?>
									<div class="col-print-5">
										<div class="row">
											<div class="col-print-12">
												<h5><?php echo $education_qualification_row['institution'] ?></h5>
											</div>
											<div class="col-print-12">
												<h6><?php echo $education_qualification_row['passing_year'] ?></h6>
											</div>
										</div>
									</div>
									<div class="col-print-7 mb-3 pl-2">
										<div class="row">
											<div class="col-print-12">
												<h5 class="ml-0 pl-0"><?php echo $education_qualification_row['degree_title'] ?></h5>
												<h6><?php echo $education_qualification_row['edu_group'] ?></h6>
												<h6><?php echo $education_qualification_row['class']; echo ($education_qualification_row['gpa'] != '') ? ': '.$education_qualification_row['gpa'] : '' ?></h6>
											</div>
										</div>
									</div>
							<?php }
							} ?>                            
                        </div>
                    </div>
                </div>
                <!-- End Education -->
				<!-- Signatute -->
				<div class="bottom-right">
					<p class="sig-text">  Signature  </p>
				</div>
				<!-- End Signatute -->
            </div>
        </div>
    </div>
	<?php
	$education_qualification = $mysqli->query("SELECT * from employee_education_qualification where employee_id = '".$_POST['view_id']."'");
	$employment_history = $mysqli->query("SELECT * from employment_history where employee_id = '".$_POST['view_id']."'");
	$professional_training = $mysqli->query("SELECT * from employee_professional_training where employee_id = '".$_POST['view_id']."'");
	$employee_family = $mysqli->query("SELECT * from employee_family where employee_id = '".$_POST['view_id']."'");
	?>
    <div class="row">
        <div class="col-md-3">                
            <div class="box box-primary">
                <div class="box-body box-profile">
					<center>
						<?php if(!empty($row['photo'])){ ?>
							<img class="profile-user-img img-responsive" src="<?php echo $home.$row['photo']; ?>" alt="<?php echo $home.$row['full_name']; ?>" style="width:200px;height:210px;">
						<?php }else{ ?>
							<img class="profile-user-img img-responsive" src="<?php echo $home.'assets/img/photo_avatar.png'; ?>" alt="<?php echo $row['full_name']; ?>" style="width:200px;">
						<?php } ?>						
					</center>
                    <h3 class="profile-username text-center ratin" style="padding-top:15px;padding-bottom:15px;font-size:25px;font-weight:bolder;">
						<?php echo $row['full_name']; ?> <br />
						<?php
							if($rt_point == '5'){
								echo ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> ';
							}else if($rt_point < '5' AND '4' < $rt_point){
								echo ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> ';
							}else if($rt_point < '4' AND '3' < $rt_point){
								echo ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> ';
							}else if($rt_point < '3' AND '2' < $rt_point){
								echo ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> '; 
							}else if($rt_point < '2' AND '1' < $rt_point){
								echo ' <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> ';
							}else if($rt_point < '1' AND '0' < $rt_point){
								echo ' <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> '; 
							}
						?>
					</h3>
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item listnoback">
							Staff ID : <b><span style="float:right;"><?php echo $row['employee_id']; ?></span></b>
						</li>
						<li class="list-group-item listnoback">
							Role : <b><span style="float:right;"><?php echo $role['role_name']; ?></span></b>
						</li>
						<li class="list-group-item listnoback">
							Designation : <b><span style="float:right;"><?php echo $designation['designation_name']; ?></span></b>
						</li>

						<li class="list-group-item listnoback">
							Department : <b><span style="float:right;"><?php echo $department['department_name']; ?></span></b>
						</li>
						<li class="list-group-item listnoback">
							Location: <b><span style="float:right;"><?php echo $branchn['branch_name']; ?></span></b>
						</li>
						<li class="list-group-item listnoback">
							Date Of Joining: <b><span style="float:right;"><?php echo $row['date_of_joining']; ?></span></b>
						</li>
						<li class="list-group-item listnoback">
							Phone: <b><span style="float:right;"><?php echo $row['Company_phone']; ?></span></b>
						</li>
						<li class="list-group-item listnoback">
							Email: <b><span style="float:right;"><?php echo $row['company_email']; ?></span></b>
						</li>
						<li class="list-group-item listnoback">
							Blood Group: <b><span style="float:right;"><?php echo $row['blood_group']; ?></span></b>
						</li>
						<li class="list-group-item listnoback">
							NID: <b><span style="float:right;"><?php echo $row['nid_number']; ?></span></b>
						</li>
					</ul>
				</div>
			</div>

		</div>

            <div class="col-md-9">
				<div class="card card-success card-outline card-outline-tabs">
					
					<div class="card-header p-0 border-bottom-0">
						<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist" style="float: left;">
							<li class="nav-item"><a class="nav-link active" href="#activity" aria-controls="activity" data-toggle="pill" role="tab" aria-selected="true">Profile</a></li>
							<li class="nav-item"><a class="nav-link" href="#professional" aria-controls="activity" data-toggle="pill" role="tab" aria-selected="true">Professional</a></li>
							<li class="nav-item"><a class="nav-link " href="#payroll" aria-controls="payroll" data-toggle="pill" role="tab" aria-selected="false">Payroll</a></li>
							<li class="nav-item"><a class="nav-link" href="#leaves" aria-controls="leaves" data-toggle="pill" role="tab" aria-selected="false">Leaves</a></li>
							<li class="nav-item"><a class="nav-link" href="#attendance" aria-controls="attendance" data-toggle="pill" role="tab" aria-selected="false">Attendance</a></li>
							<li class="nav-item"><a class="nav-link" href="#documents" aria-controls="documents" data-toggle="pill" role="tab" aria-selected="false">Documents</a></li>
							<li class="nav-item"><a class="nav-link" href="#timelineh" aria-controls="timelineh" data-toggle="pill" role="tab" aria-selected="false">Timeline</a></li>
							<li class="nav-item"><a class="nav-link" href="#id_card" aria-controls="id_card" data-toggle="pill" role="tab" aria-selected="false">ID Card</a></li>							
						</ul>
						<ul style="float: right;list-style-type: none;">
							<li>
								<button id="print_button_cv" class="btn btn-sm btn-info"><i class="fas fa-print"></i></button>
							</li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">
							<div class="tab-pane active" id="activity">
								<div class="tshadow mb25 bozero">
									<div class="table-responsive around10 pt0">									
										<div class="col-sm-12" style="padding-top:15px;">
											<div class="card-success">
												<div class="card-header">
													<h5 style="margin:0px;">Profile Information</h5>
												</div>
												<div class="card-body" style="padding:5px;">
													<div class="row">
														<div class="col-sm-6">
															<table class="table table-sm table-bordered">
																<thead>
																	<tr>
																		<th>#</th>
																		<th>Info</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>Phone</td>
																		<td><?php echo $row['personal_Phone']; ?></td>
																	</tr>
																	<tr>
																		<td><abbr title="Emergency Contact Number One">ECN:1</abbr></td>
																		<td><?php echo $row['emergency_no1']; ?></td>
																	</tr>
																	<tr>
																		<td>Gender</td>
																		<td><?php echo $row['gender']; ?></td>
																	</tr>
																	<tr>
																		<td>Marital Status</td>
																		<td><?php echo $row['marital_status']; ?></td>
																	</tr>
																	<tr>
																		<td>Religion</td>
																		<td><?php echo $row['religion']; ?></td>
																	</tr>
																	<tr>
																		<td>Work Experience</td>
																		<td><?php echo $row['work_exp']; ?></td>
																	</tr>
																</tbody>
															</table>
														</div>
														<div class="col-sm-6">
															<table class="table table-sm table-bordered">
																<thead>
																	<tr>
																		<th>#</th>
																		<th>Info</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>Email</td>
																		<td><?php echo $row['email']; ?></td>
																	</tr>
																	<tr>
																		<td><abbr title="Emergency Contact Number Two">ECN:2</abbr></td>
																		<td><?php echo $row['emergency_no2']; ?></td>
																	</tr>
																	<tr>
																		<td><abbr title="Date Of Birth">DOB</abbr></td>
																		<td><?php echo $row['date_of_birth']; ?></td>
																	</tr>
																	<tr>
																		<td>Qualification</td>
																		<td><?php echo $row['qualification']; ?></td>
																	</tr>
																	<tr>
																		<td>Note</td>
																		<td><?php echo $row['note']; ?></td>
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
								
								<div class="col-sm-12">
									<h5 style="text-decoration:underline;">Address </h5>
									<div class="row">
										<div class="col-sm-6">
											<table class="table table-sm table-bordered">
												<tbody>
													<tr>
														<td>Current Addr.</td>
														<td><?php echo $row['current_address']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-sm-6">
											<table class="table table-sm table-bordered">
												<tbody>
													<tr>
														<td>Permanent Addr.</td>
														<td><?php echo $row['permanent_address']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<h5 style="text-decoration:underline;">Bank Information </h5>
									<div class="row">
										<div class="col-sm-3">
											<table class="table table-sm table-bordered">
												<tbody>
													<tr>
														<th>Account Title</td>
														<td><?php echo $row['bank_account_title']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-sm-3">
											<table class="table table-sm table-bordered">
												<tbody>
													<tr>
														<th>Bank Account Number</td>
														<td><?php echo $row['bank_account_number']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-sm-2">
											<table class="table table-sm table-bordered">
												<tbody>
													<tr>
														<th>Bank Name</td>
														<td><?php echo $row['bank_name']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-sm-2">
											<table class="table table-sm table-bordered">
												<tbody>
													<tr>
														<th>Bank Branch Name</td>
														<td><?php echo $row['bank_branch_name']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-sm-2">
											<table class="table table-sm table-bordered">
												<tbody>
													<tr>
														<th>Account Type</td>
														<td><?php echo $row['account_type']; ?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<h5 style="text-decoration:underline;">Family Information </h5>
									<div class="row">
										<div class="col-sm-12">
											<table class="table table-sm table-bordered">
												<thead>
													<tr>
														<th>Relation</th>
														<th>Name</th>
														<th>Occupation</th>
														<th>Contact Number</th>
														<th>Contact Address</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<?php if($employee_family->num_rows != 0){?>
															<?php while($employee_family_row = mysqli_fetch_assoc($employee_family)){?>
																<tr>
																	<td> <?php echo $employee_family_row['relation'] ?> </td>
																	<td> <?php echo $employee_family_row['name'] ?> </td>
																	<td> <?php echo $employee_family_row['occupation'] ?> </td>
																	<td> <?php echo $employee_family_row['contact_number'] ?> </td>
																	<td> <?php echo $employee_family_row['contact_address'] ?> </td>
																</tr>
															<?php } ?>
														<?php }else{?>
															<tr>
																<td colspan="5"> No Information </td>
															</tr>
														<?php } ?>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="payroll">
								<div class="col-sm-12">
									<div class="row" style="margin-top:15px;">
										<div class="col-sm-6">
											<div class="card card-success">
												<div class="card-header">
													Employee Rating (Monthly - <?php echo date('M-Y');?>)
												</div>
												<div class="card-body">												
													<?php												
														if($rating['total_rating'] > 0){
													?>
													<table class="table table-sm table-bordered">
														<tbody>
															<tr>
																<td>Rating Point:</td>
																<td><?php echo round(($rating['total_value'] )/ $rating['total_rating'],'2'); ?></td>
															</tr>
															<tr>
																<td>Total Rating:</td>
																<td><?php echo $rating['total_rating']; ?></td>
															</tr>
															<tr>
																<td>Maximum Rating:</td>
																<td>
																<?php
																	$maxi_r = mysqli_fetch_assoc($mysqli->query("select value from employee_rating where employee_id = '".$row['id']."' and month = '".date('m')."' and year = '".date('Y')."' order by value desc"));
																	echo $maxi_r['value']; 
																?>
																</td>
															</tr>
															<tr>
																<td>Minimum Rating:</td>
																<td>
																<?php
																	$mini_r = mysqli_fetch_assoc($mysqli->query("select value from employee_rating where employee_id = '".$row['id']."' and month = '".date('m')."' and year = '".date('Y')."' order by value asc"));
																	echo $mini_r['value']; 
																?>
																</td>
															</tr>
														</tbody>
													</table>
													<?php }else{ ?>
														<p>NO Rating Yet!</p>
													<?php } ?>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="card card-success">
												<div class="card-header">
													Employee Rating (All)
												</div>
												<div class="card-body">												
													<?php
														$rating_a = mysqli_fetch_assoc($mysqli->query("select count(*) as total_rating, sum(value) total_value from employee_rating where employee_id = '".$row['id']."'"));
														if($rating_a['total_rating'] > 0){
													?>
													<table class="table table-sm table-bordered">
														<tbody>
															<tr>
																<td>Rating Point:</td>
																<td><?php echo round(($rating_a['total_value'] )/ $rating_a['total_rating'],'2'); ?></td>
															</tr>
															<tr>
																<td>Total Rating:</td>
																<td><?php echo $rating_a['total_rating']; ?></td>
															</tr>
															<tr>
																<td>Maximum Rating:</td>
																<td>
																<?php
																	$maxi_ra = mysqli_fetch_assoc($mysqli->query("select value from employee_rating where employee_id = '".$row['id']."' order by value desc"));
																	echo $maxi_ra['value']; 
																?>
																</td>
															</tr>
															<tr>
																<td>Minimum Rating:</td>
																<td>
																<?php
																	$mini_ra = mysqli_fetch_assoc($mysqli->query("select value from employee_rating where employee_id = '".$row['id']."' order by value asc"));
																	echo $mini_ra['value']; 
																?>
																</td>
															</tr>
														</tbody>
													</table>
													<?php }else{ ?>
														<p>NO Rating Yet!</p>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="row" style="margin-top:15px;">
										<div class="col-sm-3">
											<div class="card">
												<div class="card-header">
													<h5><i class="fas fa-money-check-alt"></i> Total Net Salary Paid</h5>
												</div> 
												<div class="card-body">
													BDT 20000.00
												</div>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="card">
												<div class="card-header">
													<h5><i class="fas fa-money-check-alt"></i> Total Gross Salary</h5>
												</div> 
												<div class="card-body">
													BDT 20000.00
												</div>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="card">
												<div class="card-header">
													<h5><i class="fas fa-money-check-alt"></i> Total Earning</h5>
												</div> 
												<div class="card-body">
													BDT 20000.00
												</div>
											</div>
										</div>
										
										<div class="col-sm-3">
											<div class="card">
												<div class="card-header">
													<h5><i class="fas fa-money-check-alt"></i> Total Deduction</h5>
												</div> 
												<div class="card-body">
													BDT 20000.00
												</div>
											</div>
										</div>

									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="row" style="margin-top:15px;">                        
										<div class="col-sm-12">
											<div class="card card-info">
												<div class="card-header">
													Sallary Shit for <?php echo $row['full_name']; ?>
												</div>
												<div class="card-body">
													<table class="table table-sm table-bordered">
														<thead>
															<tr>
																<th>Payslip#</td>
																<th>Month - Year</td>
																<th>Date</td>
																<th>Mode</td>
																<th>Status</td>
																<th>Net Sallary</td>
																<th>Option</td>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>          
								</div>  
								
							</div> 
							<!-- Professional Inforrmation -->
							<div class="tab-pane" id="professional">
								<div class="timeline-header no-border">
									<div class="row">
										<div class="col-md-12">
											<h5>Academic Qulification</h5>
											<div class="row">
												<div class="col-sm-12">
													<table class="table table-sm table-bordered">
														<thead>
															<tr>
																<td style="width: 8%;">Level Of Education</td>
																<td style="width: 8%;">Passing Year</td>
																<td>Institution</td>
																<td style="width: 8%;">Board</td>
																<td style="width: 16%;">Group/Subject</td>
																<td style="width: 8%;">Division/CGPA</td>
																<td style="width: 8%;">GPA/CGPA Scale</td>
															</tr>
														</thead>
														<tbody>
															<?php if($education_qualification->num_rows != 0){?>
																<?php while($education_qualification_row = mysqli_fetch_assoc($education_qualification)){?>
																	<tr>
																		<td> <?php echo $education_qualification_row['level_of_education'] ?> </td>
																		<td> <?php echo $education_qualification_row['passing_year'] ?> </td>
																		<td> <?php echo $education_qualification_row['institution'] ?> </td>
																		<td> <?php echo $education_qualification_row['board'] ?> </td>
																		<td> <?php echo $education_qualification_row['edu_group'] ?> </td>
																		<td> <?php echo $education_qualification_row['class'] ?> </td>
																		<td> <?php echo $education_qualification_row['gpa'] ?> </td>
																	</tr>
																<?php } ?>
															<?php }else{?>
																<tr>
																	<td colspan="8"> No Information </td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>										
										</div>
										<div class="col-md-12">
											<h5>Profession Qulification/Training</h5>
											<div class="row">
												<div class="col-sm-12">
													<table class="table table-sm table-bordered">
														<thead>
															<tr>
																<td style="width: 28%;">Name of the Training</td>
																<td>Institution</td>
																<td style="width: 25%;">Place(Local/Foreign)</td>
																<td style="width: 8%;">Completion Year</td>
																<td style="width: 10%;">Duration</td>
															</tr>
														</thead>
														<tbody>
															<?php if($professional_training->num_rows != 0){?>
																<?php while($professional_training_row = mysqli_fetch_assoc($professional_training)){?>
																	<tr>
																		<td> <?php echo $professional_training_row['training_name'] ?> </td>
																		<td> <?php echo $professional_training_row['institution'] ?> </td>
																		<td> <?php echo $professional_training_row['place'] ?> </td>
																		<td> <?php echo $professional_training_row['completion_year'] ?> </td>
																		<td> <?php echo $professional_training_row['duration'] ?> </td>
																	</tr>
																<?php } ?>
															<?php }else{?>
																<tr>
																	<td colspan="6"> No Information </td>
																</tr>
															<?php } ?>
														</tbody>
													</table>
												</div>
											</div>										
										</div>
										<div class="col-md-12">
											<h5>Employment History</h5>
											<div class="row">
												<div class="col-sm-12">
													<table class="table table-sm table-bordered">
														<thead>
															<tr>
																<td>Employer/Company Name</td>
																<td>Designation</td>
																<td>Department</td>
																<td>From</td>
																<td style="width: 8%;">To</td>
																<td>Core Responsibility</td>
																<td>Reason For Leaving</td>
															</tr>
														</thead>
														<tbody>
															<?php if($employment_history->num_rows != 0){?>
																<?php while($employment_history_row = mysqli_fetch_assoc($employment_history)){?>
																	<tr>
																		<td> <?php echo $employment_history_row['company_name'] ?> </td>
																		<td> <?php echo $employment_history_row['designation'] ?> </td>
																		<td> <?php echo $employment_history_row['department'] ?> </td>
																		<td> <?php echo $employment_history_row['from_date'] ?> </td>
																		<td> <?php echo $employment_history_row['to_date'] ?> </td>
																		<td> <?php echo $employment_history_row['responsibility'] ?> </td>
																		<td> <?php echo $employment_history_row['leaving_reason'] ?> </td>
																	</tr>
																<?php } ?>
															<?php }else{?>
																<tr>
																	<td colspan="7"> No Information </td>
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
	<!-----------------------DOCUMENT AREA----------------------->						
							<div class="tab-pane" id="documents">
								<div class="timeline-header no-border">
									<div class="row">
										<div class="col-md-12">
											<h3>Document</h3>
											<div class="row">
												<div class="col-sm-6">
													<table class="table table-sm table-bordered">
														<thead>
															<tr>
																<th>#Name</th>
																<th>URL</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Employee Image</td>
																<td>
																	<?php if(!empty($row['photo'])){ ?>
																	<a href="<?php echo $home.$row['photo']; ?>" title="Click to view Employee Image" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
															<tr>
																<td>Emergency Attachment 1</td>
																<td>
																	<?php if(!empty($row['emergency_attachment_1'])){ ?>
																	<a href="<?php echo $home.$row['emergency_attachment_1']; ?>" title="Click to view Emergency Attachment 1" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
															<tr>
																<td>Emergency Attachment 2</td>
																<td>
																	<?php if(!empty($row['emergency_attachment_2'])){ ?>
																	<a href="<?php echo $home.$row['emergency_attachment_2']; ?>" title="Click to view Emergency Attachment 2" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>														
															<tr>
																<td>Resume</td>
																<td>
																	<?php if(!empty($row['first_doc'])){ ?>
																	<a href="<?php echo $home.$row['first_doc']; ?>" title="Click to view Resume" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
															<tr>
																<td>Joining Letter</td>
																<td>
																	<?php if(!empty($row['second_doc'])){ ?>
																	<a href="<?php echo $home.$row['second_doc']; ?>" title="Click to view Joining Letter" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
															<tr>
																<td>Relese Letter</td>
																<td>
																	<?php if(!empty($row['forth_doc'])){ ?>
																	<a href="<?php echo $home.$row['forth_doc']; ?>" title="Click to view Relese Letter" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
														</tbody>
													</table>
													
													<table class="table table-sm table-bordered">
														<thead>
															<tr>
																<th>#Name (Social Links)</th>
																<th>URL</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td>Facebook</td>
																<td>
																	<?php if(!empty($row['facebook'])){ ?>
																	<a href="<?php echo $row['facebook']; ?>" title="Click to view Facebook Profile" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
															<tr>
																<td>Twitter</td>
																<td>
																	<?php if(!empty($row['twitter'])){ ?>
																	<a href="<?php echo $row['twitter']; ?>" title="Click to view Twitter Profile" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
															<tr>
																<td>Linkedin</td>
																<td>
																	<?php if(!empty($row['linkedin'])){ ?>
																	<a href="<?php echo $row['linkedin']; ?>" title="Click to view Linkedin Profile" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
															<tr>
																<td>Instagram</td>
																<td>
																	<?php if(!empty($row['instagram'])){ ?>
																	<a href="<?php echo $row['instagram']; ?>" title="Click to view Instagram Profile" class="" target="_blank">
																		<i class="fas fa-external-link-alt"></i>
																	</a>
																	<?php } else{ ?>
																		<a>----</a>
																	<?php } ?>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="col-sm-6">
													<table class="table table-sm table-bordered">
														<thead>
															<tr>
																<th>#Name</th>
																<th>URL</th>
															</tr>
														</thead>
														<tbody>														
															<tr>
																<td>Other Documents</td>
																<td>
																	<?php if(!empty($row['thired_doc'])){ 
																		$o_document = explode(",",$row['thired_doc']);
																		$don = 1;
																		foreach($o_document as $file){
																	?>
																		<a href="<?php echo $home.$file; ?>" title="Click to view <?php echo $don++; ?>. Other Documents" class="" target="_blank">
																			<i class="fas fa-external-link-alt"></i>
																		</a>
																		<br />
																	<?php } } else{ ?>
																		<a>----</a>
																	<?php } ?>
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
	<!-----------------------DOCUMENT AREA----------------------->

							<div class="tab-pane" id="timelineh">
								<div>                                                       <input type="button" id="myTimelineButton" class="btn btn-sm btn-primary pull-right " value="Add"> 
								</div>
								<br>

								<div class="timeline-header no-border">

									<div id="timeline_list">
																							<br>
											<div class="alert alert-info">No Record Found</div>
	  

										
									</div>


	 <!-- <h2 class="page-header"> </h2> -->

								</div>

							</div>  
							<div class="tab-pane" id="attendance">						
								<div class="row">
									<div class="col-sm-3">
										<div class="staffprofile">
											<h5>Total Present</h5>
											<?php 
												$year = date('y');
												$to_att = '0';
												$gett = $mysqli->query("SELECT * FROM employee_attendence where e_db_id = '".$row['id']."' and attendance = '1' AND years = '".$year."'");
												while($ewo = mysqli_fetch_assoc($gett)){
													if($ewo['e_db_id'] == $row['id']){
														$to_att = $to_att + $ewo['attendance'];
													}else{
														$to_att = '0';
													}													
												}
											?>
											<h4><?php echo $to_att; ?></h4>
										</div>
									</div>
									<div class="col-sm-9">
										<div class="halfday pull-right">                                                 
											<b> Present: <b class="text text-success">P</b></b>&nbsp;|&nbsp;
											<b> Absent: <b class="text text-danger">A</b> </b>&nbsp;|&nbsp;
											<b> Uncount: <b class="text text-danger">--</b> </b>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="download_label">Attendance Report <b><?php echo $row['full_name']; ?></b></div>
									<style> .table-sm td, .table-sm th { padding: 0px; text-align: center; } </style>
									<table class="table table-sm table-striped table-bordered table-hover dataTable no-footer" id="attendancetable" role="grid">
										<thead>
											<tr role="row">
												<th rowspan="1" colspan="1" style="width: 0px;"> Date | Month (<?php echo date('Y'); ?>)</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Jan</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Feb</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Mar</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Apr</th>
												<th rowspan="1" colspan="1" style="width: 0px;">May</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Jun</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Jul</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Aug</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Sep</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Oct</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Nov</th>
												<th rowspan="1" colspan="1" style="width: 0px;">Dec</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$i = '1';										
											for($i ; $i < 32; $i++ ){
											?>
											<tr role="row" class="odd">                                                
												<td><b><?php echo $i; ?></b></td>
												<?php for($j = 1; $j < 13; $j++ ){ ?>
												<td>
												<?php
													if($year >= 21){
														$get_leave = mysqli_fetch_assoc($mysqli->query("SELECT employee_everyday_leave_logs.id, employee_everyday_leave_logs.h_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.e_db_id = '".$row['id']."' AND employee_everyday_leave_logs.days = '".sprintf("%02d", $i)."' AND employee_everyday_leave_logs.month = '".sprintf("%02d", $j)."' AND employee_everyday_leave_logs.year = '20".$year."' AND employee_everyday_leave_logs.status = 1 AND employee_leave_logs.aproval = 1 AND employee_leave_logs.h_aproval = 1 LIMIT 1"));
													}else if($i >= 1 AND $j >= 9){
														$get_leave = mysqli_fetch_assoc($mysqli->query("SELECT employee_everyday_leave_logs.id, employee_everyday_leave_logs.h_days from employee_everyday_leave_logs INNER JOIN employee_leave_logs using(unique_id) where employee_leave_logs.e_db_id = '".$row['id']."' AND employee_everyday_leave_logs.days = '".sprintf("%02d", $i)."' AND employee_everyday_leave_logs.month = '".sprintf("%02d", $j)."' AND employee_everyday_leave_logs.year = '20".$year."' AND employee_everyday_leave_logs.status = 1 AND employee_leave_logs.aproval = 1 AND employee_leave_logs.h_aproval = 1 LIMIT 1"));
													}else{
														$get_leave = null;
													}
													$get = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where e_db_id = '".$row['id']."' AND days = '".sprintf("%02d", $i)."' AND month = '".sprintf("%02d", $j)."' AND years = '".$year."' order by id asc"));
													if(!is_null($get_leave)){
														if($get_leave['h_days'] == '0.5'){
															echo '<span style="font-weight:bolder;color:#8500ff;">H</span>';
														}else{
															echo '<span style="font-weight:bolder;color:red;">L</span>';
														}
													}else{								
														if(!empty($get['id'])){
															if($get['attendance'] == '1'){
																if($get['note'] == 'half'){
																	echo '<span style="font-weight:bolder;color:#8500ff;">H</span>';
																}else if($get['note'] == 'home'){
																	echo '<span style="font-weight:bolder;color:blue;">W</span>';
																}else{
																	echo '<span style="font-weight:bolder;color:green;">P</span>';
																}
															}else{
																echo '<span style="font-weight:bolder;color:red;">A</span>';
															}															
														}else{
															echo '<span style="color:#f00;">--</span>';
														}
														
													}
												?>
												</td>
												<?php } ?>												
											</tr>
											<?php
											}
											?>	
													
										</tbody>
									</table>

								</div>
							</div>
							<div class="tab-pane" id="leaves">
								<div class="row">

								</div>
								<div class="timeline-header no-border">
									<div class="download_label">Leave Request K E H Rahat</div>
									<div class="table-responsive" style="clear: both;">
										<div id="DataTables_Table_1_wrapper" class="dataTables_wrapper no-footer"><div class="dt-buttons btn-group btn-group2">               <a class="btn btn-default dt-button buttons-copy buttons-html5" tabindex="0" aria-controls="DataTables_Table_1" href="#" title="Copy"><span><i class="fa fa-files-o"></i></span></a> <a class="btn btn-default dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="DataTables_Table_1" href="#" title="Excel"><span><i class="fa fa-file-excel-o"></i></span></a> <a class="btn btn-default dt-button buttons-csv buttons-html5" tabindex="0" aria-controls="DataTables_Table_1" href="#" title="CSV"><span><i class="fa fa-file-text-o"></i></span></a> <a class="btn btn-default dt-button buttons-pdf buttons-html5" tabindex="0" aria-controls="DataTables_Table_1" href="#" title="PDF"><span><i class="fa fa-file-pdf-o"></i></span></a> <a class="btn btn-default dt-button buttons-print" tabindex="0" aria-controls="DataTables_Table_1" href="#" title="Print"><span><i class="fa fa-print"></i></span></a> <a class="btn btn-default dt-button buttons-collection buttons-colvis" tabindex="0" aria-controls="DataTables_Table_1" href="#" title="Columns"><span><i class="fa fa-columns"></i></span></a> </div><div id="DataTables_Table_1_filter" class="dataTables_filter"><label><input type="search" class="" placeholder="Search..." aria-controls="DataTables_Table_1"></label></div><table class="table table-striped table-bordered table-hover example dataTable no-footer dtr-inline" id="DataTables_Table_1" role="grid" aria-describedby="DataTables_Table_1_info" style="width: 0px;">
											<thead>
											<tr role="row"><th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" style="width: 0px;" aria-label="Leave Type: activate to sort column ascending">Leave Type</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" style="width: 0px;" aria-label="Leave Date: activate to sort column ascending">Leave Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" style="width: 0px;" aria-label="Days: activate to sort column ascending">Days</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" style="width: 0px;" aria-label="Apply Date: activate to sort column ascending">Apply Date</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" style="width: 0px;" aria-label="Status: activate to sort column ascending">Status</th><th class="text-right sorting" tabindex="0" aria-controls="DataTables_Table_1" rowspan="1" colspan="1" style="width: 0px;" aria-label="Action: activate to sort column ascending">Action</th></tr></thead>
											<tbody>

											<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No data available in table <br> <br><img src="https://smart-school.in/ssappresource/images/addnewitem.svg" width="150"><br><br> <span class="text-success bolds"><i class="fa fa-arrow-left"></i> Add new record or search with different criteria.</span></td></tr></tbody>
										</table><div class="dataTables_info" id="DataTables_Table_1_info" role="status" aria-live="polite">Records: 0 to 0 of 0</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_1_paginate"><a class="paginate_button previous disabled" aria-controls="DataTables_Table_1" data-dt-idx="0" tabindex="0" id="DataTables_Table_1_previous"><i class="fa fa-angle-left"></i></a><span></span><a class="paginate_button next disabled" aria-controls="DataTables_Table_1" data-dt-idx="1" tabindex="0" id="DataTables_Table_1_next"><i class="fa fa-angle-right"></i></a></div></div>
									</div>
								</div>
							</div>   
<!-------------------ID Card----------------------->
							<div class="tab-pane" id="id_card">
								<div class="row">
									<div class="col-sm-12">
										<div class="card card-primary">
											<div class="card-header">
												<h3 class="card-title">ID Card</h3>							
											</div>
											<div class="card-body" id="id_card_result">
												
											</div>
										</div>	
									</div>
								</div>
							</div> 
						</div>
					</div>
                </div>
            </div>
    </div></section>
	
	
	
<script>
$('#print_button_cv').on("click", function () {
	$("#cv_print").print({
        noPrintSelector: ".exclude",
        globalStyles: true,
        doctype: '<!doctype html>',    
    })
});
var employee_id = "<?php echo rahat_encode($row['id']); ?>";
$('document').ready(function(){
	return get_employee_attendance_information(employee_id);
})
function get_employee_attendance_information(em_id){
	$.ajax({  
		url:"<?php echo $home.'assets/ajax/data_table/employee_id_card_from_profile.php';?>",  
		method:"POST",  
		data:{
			employee_id:em_id,
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#id_card_result').html(data);    
		}  
	});
}
</script>
<?php } ?>