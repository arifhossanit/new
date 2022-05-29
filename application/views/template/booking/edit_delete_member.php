<div class="content-wrapper">	.
		<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Edit Member Information</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Edit Member Information</li>
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
												<h4 class="pagetitleh2" style="text-decoration:underline;">Basic Information </h4>
												<div class="around10">
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label>Full name</label><small class="req"> *</small>
																<input name="full_name" value="<?php if(!empty($edit)){ echo $edit->full_name; } ?>" type="text" class="form-control" autocomplete="off" required/>
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Email</label><small class="req"> *</small>
																<input id="email" name="email" value="<?php if(!empty($edit)){ echo $edit->email; } ?>" type="email" class="form-control" autocomplete="off" required/>
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Phone Number</label><small class="req"> *</small>
																<input id="phone_number" name="phone_number" value="<?php if(!empty($edit)){ echo $edit->phone_number; } ?>" type="text" class="form-control" autocomplete="off" required/>
															</div>
														</div>
														
														<div class="col-md-3">
															<div class="form-group">
																<label>Occupation</label><small class="req"> *</small>
																<select id="occupation" name="occupation" class="form-control">
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->occupation.'">'.$edit->occupation.'</option>'; }else{ echo '<option value="">--select--</option>'; } ?>																	
																	<option value="Student">Student</option>
																	<option value="Job Holder">Job Holder</option>
																	<option value="Business Man">Business Man</option>
																	<option value="Teacher">Teacher</option>
																	<option value="Doctor">Doctor</option>										
																	<option value="Driver">Driver</option>
																	<option value="Housewife">Housewife</option>
																	<option value="Other">Other</option>
																</select>
															</div>
														</div>
														
													</div>
													
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label>Religion</label><small class="req"> *</small>
																<select id="religion" name="religion" class="form-control">
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->religion.'">'.$edit->religion.'</option>'; }else{ echo '<option value="">--select--</option>'; } ?>	
																	<option value="Islam">Islam</option>
																	<option value="Hindu">Hindu</option>
																	<option value="Christian">Christian</option>
																	<option value="Buddhist">Buddhist</option>
																	<option value="Other">Other</option>
																</select>
															</div>
														</div>

														<div class="col-md-3">
															<div class="form-group">
																<label>How to find us</label><small class="req"> *</small>
																<select id="h_t_f_u" name="h_t_f_u" class="form-control">
																	<?php if(!empty($edit)){ echo '<option value="'.$edit->h_t_f_u.'">'.$edit->h_t_f_u.'</option>'; }else{ echo '<option value="">--select--</option>'; } ?>
																	<option value="News Paper">News Paper</option>
																	<option value="Google">Google</option>
																	<option value="Facebook">Facebook</option>
																	<option value="SMS">SMS</option>
																	<option value="Youtube">Youtube</option>
																	<option value="Parents">Parents</option>
																	<option value="TVC">TVC</option>
																	<option value="Friends">Friends</option>
																	<option value="Colleague">Colleague</option>
																</select>
															</div>
														</div>

														<div class="col-md-3">
															<div class="form-group">
																<label>Referance ID</label><small class="req"> *</small>
																<input name="referance_id" value="<?php if(!empty($edit)){ echo $edit->referance_id; } ?>" type="text" class="form-control" autocomplete="off" />
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label> Member Photo</label><small class="req"> *</small>
																<div class="custom-file">
																	<span id="avater_image">
																		<?php if(!empty($edit->photo_avater)){?>
																		<img src="<?php echo base_url().$edit->photo_avater; ?>" style="width:50px;" id="view_image">
																		<?php } ?>
																	</span>
																	<input type="hidden" id="photo_avater_value" name="photo_avater" value="<?php if(!empty($edit->photo_avater)){ echo $edit->photo_avater; } ?>"/>
																	<button type="button" id="photo_avater" onclick="return open_camera()" title="Upload / Select / Chapture Photo" class="form-control btn btn-info" style="height:38px;<?php if(!empty($edit->photo_avater)){ echo 'width: 180px; float: right;';} ?>"><i class="fas fa-camera"></i>  Photo Upload  <i class="fas fa-upload"></i> </button>
																	<?php /* ?><input type="file" id="photo_avater" name="photo_avater"   style="padding-top:3px;" accept="image/*;capture=camera" capture="camera"><?php */ ?>
																</div>
															</div>
														</div>
														
													</div>
													<div class="row">
														<div class="col-sm-10">
															<div class="row">
																<div class="col-md-3">
																	<div class="form-group">
																		<label>Father Name</label><small class="req"> *</small>
																		<input name="father_name" value="<?php if(!empty($edit)){ echo $edit->father_name; } ?>" type="text" class="form-control" autocomplete="off" required/>
																	</div>
																</div>
																
																<div class="col-md-3">
																	<div class="form-group">
																		<label>NID Number</label><small class="req"> *</small>
																		<input id="mother_name" name="mother_name" value="<?php if(!empty($edit)){ echo $edit->mother_name; } ?>" type="text" class="form-control" autocomplete="off" required/>
																	</div>
																</div>
																
																<div class="col-sm-3">
																	<div class="form-group">
																		<label>Emergency Contact name</label><small class="req"> *</small>
																		<input type="text" id="emergency_number_1" name="emergency_number_1" value="<?php if(!empty($edit)){ echo $edit->emergency_number_1; } ?>" autocomplete="off" class="form-control" />
																	</div>
																</div>
																<div class="col-sm-3">
																	<div class="form-group">
																		<label>Emergency number Two</label><small class="req"> *</small>
																		<input type="text" id="emergency_number_2" name="emergency_number_2" value="<?php if(!empty($edit)){ echo $edit->emergency_number_2; } ?>" autocomplete="off" class="form-control"/>
																	</div>
																</div>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label>Member Type</label>
																<select name="member_type" class="form-control select 2" required title="Please select Member Type">
																	<?php if(!empty($edit->member_type)){ echo '<option valye="'.$edit->member_type.'">'.$edit->member_type.'</option>'; }else{ echo '<option value="">Member Type</option>'; } ?>
																	<option value="NEW">NEW</option>
																	<option value="OLD">OLD</option>
																	<option value="GROUP">GROUP</option>
																</select>
															</div>
														</div>
														
													</div>
													
													<div class="row">					
														<div class="col-sm-6">
															<div class="form-group">
																<label>Address</label><small class="req"> *</small>
																<textarea id="address" name="address" autocomplete="off" class="form-control"><?php if(!empty($edit)){ echo $edit->address; } ?></textarea>
															</div>
														</div>
														<div class="col-sm-6">
															<div class="form-group">
																<label>Remarks</label><small class="req"> *</small>
																<textarea id="remarks" name="remarks" autocomplete="off" class="form-control"><?php if(!empty($edit)){ echo $edit->remarks; } ?></textarea>
															</div>
														</div>							
													</div>
													
													<div class="row">
														<div class="col-sm-12">
															<h4 style="text-decoration:underline;">
																Document Information									
																<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
																	<button type="button" id='removeButton' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
																	<button type="button" id='addButton' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
																</div>
															</h4>															
														</div>
													</div>					
													
													<div class="col-sm-12" style="padding-right: 0px;">
														<div class="row" id='UnitBoxesGroup'>
															<div id="UnitBoxDiv1" class="row" style="width:100%;">
																<div class="col-sm-6">
																	<div class="form-group">
																		<select name="document_type[]" class="form-control">
																			<option value="">select document type</option>
																			<?php
																				if(!empty($doc_type)){
																					foreach($doc_type as $row){
																						echo '<option value="'.$row->document_type.'">'.$row->document_type.'</option>';
																					}
																				}
																			?>
																		</select>
																	</div>
																</div>
																<input type="hidden" name="document_number[]" value="" placeholder="Document serial number" class="form-control" />												
																<div class="col-sm-6">
																	<div class="form-group">
																		<div class="custom-file">
																			<span id="avater_image_1"></span>
																			<input type="hidden" id="document_1_avater_val" name="document_upload[]" value=""/>
																			<button id="photo_avater_1" type="button" class="btn btn-info form-control" style="height:38px;"><i class="fas fa-camera"></i> Document upload <i class="fas fa-upload"></i></button>
																			<?php /* ?><input type="file" name="document_upload[]" id="photo_avater_1" style="padding-top:3px;"><?php */ ?>
																		</div>
																	</div>
																</div>								
																
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label>Parking</label><small class="req"> *</small>
																<select id="parking" <?php if(!empty($edit->parking) AND $edit->parking == '1'){}else{ echo 'onchange="return parking_payment_event()"'; } ?> name="parking" class="form-control">
																	<?php 
																		if(!empty($edit->parking) AND $edit->parking == '1'){ 
																			echo '
																				<option value="1">YES</option>
																				<option value="0">NO</option>
																			'; 
																		}else{ 
																			echo '
																				<option value="0">NO</option>
																				<option value="1">YES</option>
																			'; 
																		} 
																	?>
																</select>
															</div>
														</div>	
														<div class="col-md-3"> </div>														
														<div class="col-md-3"> </div>														
														<div class="col-sm-3" id="cal_container" style="display:none;background-color: #f1f1f1; border-radius: 10px; border: solid 4px #ced4da; padding: 6px;-webkit-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); -moz-box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75); box-shadow: inset 0px 0px 5px 0px rgba(0,0,0,0.75);margin-bottom:10px;">
															<div class="form-group" style="margin:0px;width:100%;">
																<label style="margin-bottom:0px;"><i class="fas fa-calculator"></i> Total Amount</label>
																<style>@font-face { font-family: OPTICalculator; src: url(<?=base_url('assets/font/OPTICalculator.otf'); ?>); } </style>
																<div style="text-align:right;font-size:30px;color:#823131;font-family: OPTICalculator;letter-spacing: 2px;font-weight:500;transform: scale(1.0, 1.5);">
																	<?php if(!empty($pa_amount)){ echo money($pa_amount->parking_amount); }else{ echo '0.00'; }?>
																</div>
															</div>
														</div>														
													</div>
													
													<div class="row" id="payment_information_container" style="display:none;">
														<div class="col-sm-12">
															<div class="row">
																<div class="col-sm-12">
																	<h4 style="text-decoration:underline;">
																		Payment Information									
																		<div class="row d-flex" style="float:right;padding-right: 16px;"><!--justify-content-end-->											
																			<button type="button" id='removeButton_payment' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
																			<button type="button" id='addButton_payment' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
																		</div>
																	</h4>
																	<span style="color:red;font-weight:bolder;" id="document_error_message"></span>
																</div>
															</div>
															<div id='UnitBoxesGroup_payment'>
																<div id="UnitBoxDiv_payment1">
																	<div class="row" style="margin-top: 10px;">
																		<div class="col-sm-3">
																			<div class="form-group">
																				<select onchange="return payment_function_on_change()" id="payment_method1" name="payment_method[]" class="form-control">
																					<option value="">select payment method</option>
																					<option value="Cash">Cash</option>
																					<option value="Mobile Banking">Mobile Banking</option>
																					<option value="Credit / Debit Card">Credit / Debit Card</option>
																					<option value="Check">Check</option>										
																				</select>
																			</div>
																		</div>
																		<div class="col-sm-9">								
																			<div class="row" id="mobile_banking1" style="display:none;">
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<select name="agent[]" class="form-control">
																							<option value="">select agent</option>
																							<option value="Bikash">bKash</option>
																							<option value="Rocket">Rocket</option>
																							<option value="Nogod">Nogod</option>
																						</select>
																					</div>
																				</div>
																				
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																				
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																				
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																				
																			</div>
																			<div class="row" id="check_number1" style="display:none;">
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																				
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																				
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="date" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" class="form-control"/>
																					</div>
																				</div>
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																			</div>
																			
																			<div class="row" id="credit_card1" style="display:none;">
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																				
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="card_secret[]" placeholder="Card secret" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																				
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="month" name="Expiry_Date[]" placeholder="Expiry Date" autocomplete="off" min="<?php echo date('Y-m-d'); ?>" class="form-control"/>
																					</div>
																				</div>
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																			</div>
																			
																			<div class="row" id="cash1" style="display:none;">
																				<div class="col-sm-9">
																					<div class="form-group" style="width:100%;">
																						<textarea name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>											
																					</div>
																				</div>
																				<div class="col-sm-3">
																					<div class="form-group" style="width:100%;">
																						<input type="text" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>
																					</div>
																				</div>
																			</div>							
																			
																		</div>
																	</div>	
																</div>
															</div>
														</div>
													</div>
													
																			
													
													
												</div>

											</div>
										</div>									

									</div>
									<div class="box-footer">
										<div class="modal-footer justify-content-between">
											<a href="<?=base_url('admin/member-directory')?>" class="btn btn-danger">Go Back</a>
											<button class="btn btn-warning" name="update_member" type="submit">Update Information</button>
										</div>														
									</div>
									<div class="row">
										<div class="col-sm-12">
											<h5 style="text-decoration:underline;">Files information</h5>
										</div>
										<div class="col-sm-12">
											<div class="row">
												<div class="col-sm-6">
													<span>Document Information</span>
													<input type="hidden" name="document_type_edit" value="<?php if(!empty($edit->document_type)){ echo $edit->document_type; } ?>"/>
													<input type="hidden" name="document_number_edit" value="<?php if(!empty($edit->document_number)){ echo $edit->document_number; } ?>"/>
													<input type="hidden" name="document_upload_edit" value="<?php if(!empty($edit->document_upload)){ echo $edit->document_upload; } ?>"/>
													<?php if(!empty($edit->document_type)){ ?>
													<table style="width:100%;">
														<thead>
															<tr>
																<th></th>
																<th>Document Number</th>
																<th></th>
																<th>Document Type</th>
																<th></th>
																<th>Uploaded File</th>
															</tr>
														</thead>
													<?php
													$document = explode(",",$edit->document_number);
													$nmb = count($document) - 1;
													$i = 1;
													$j = 0;
													$doc_typ = explode(",",$edit->document_type);
													$doc_up = explode(",",$edit->document_upload);
													foreach ($document as $roy){
														$r = $i++;
														$p = $j++;
													?>
														<tr>
															<td><b>Document #<?php echo $r;?>:</b></td>
															<td><?php echo $roy; ?></td>
															<td>:</td>
															<td><?php echo $doc_typ[$p]; ?></td>
															<td>:</td>
															<td><a href="<?php echo base_url().$doc_up[$p]; ?>" title="<?php echo base_url().$doc_up[$p]; ?>" target="_blank"><i class="fas fa-external-link-alt"></i> View File</a></td>
														</tr>
													<?php if($r == $nmb){ break; }} ?>	
													</table>
													<?php } ?>
												</div>
												<div class="col-sm-6">
													<span>Photo Information</span><br />
													<center>
														<a href="<?php echo base_url().$edit->photo_avater; ?>" target="_blank" title="Click to view image"> 
															<img src="<?php echo base_url().$edit->photo_avater; ?>" style="width:80px;height:80px;" class="image-responsive"/>
														</a>
													</center>
												</div>
											</div>
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
							<video id="video" playsinline autoplay style="width:1600px;"></video>
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

<!----Document 1 Camera model-->
	<div class="modal fade" id="camera_model_one">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Document</h4>
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
<!----End Document 1 Camera model-->

<!----Document 2 Camera model-->
	<div class="modal fade" id="camera_model_two">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Document</h4>
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
<!----End Document 2 Camera model-->

<!----Document 3 Camera model-->
	<div class="modal fade" id="camera_model_three">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Document</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<select class="form-control" id="videoSource_three" onchange="return open_camera_three()"></select>
								</div>
							</div>
						</div>						
							
						<div id="DesiredResult_three" style="background-color:grey;width: 100%;">
							<video id="video_three" playsinline autoplay style="width:766px;"></video>
						</div>						
					</div>
					<div class="modal-footer justify-content-between">
						<button onclick="return snap_three()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
						<button onclick="return retake_image_three()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
						<input type="file" id="other_file_three" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
						<button onclick="return capture_image_done_three()" type="button" class="btn btn-sm btn-success">Done</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End Document 3 Camera model-->


<script type="text/javascript" src="<?=base_url('assets/'); ?>js/webcamjs/webcam.js"></script>
<script>
var w = 766, h = 575;
var shutter = new Audio();
shutter.autoplay = false;
shutter.src = navigator.userAgent.match(/Firefox/) ? '<?=base_url("assets/"); ?>js/shutter.ogg' : '<?=base_url("assets/"); ?>js/shutter.mp3';
//---avater //due_sudm

function capture_image_done(){	
	if(document.getElementById('camera_canvas')){
		var canvas = document.getElementById('camera_canvas');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/camera_session.php"); ?>', function(code, text) {
			$("#avater_image").html('<img src="<?=base_url();?>'+text+'" style="width:50px;" id="view_image"/>');
			$("#photo_avater_value").val(text);
			$("#photo_avater").css({"width":"180px","float":"right"});
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
//-----------------document one--------------------------
function capture_image_done_one(){	
	if(document.getElementById('camera_canvas_one')){
		var canvas = document.getElementById('camera_canvas_one');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/document_one_session.php"); ?>', function(code, text) {
			$("#avater_image_1").html('<img src="<?=base_url(); ?>'+text+'" style="width:50px;" id="view_image_one"/>');
			$("#document_1_avater_val").val(text);
			$("#photo_avater_1").css({"width":"250px","float":"right"});
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
        var FR = new FileReader();
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
$("#photo_avater_1").on("click",function(){
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
})

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
	var cm = document.createElement("video_one");
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


//-----------------document two--------------------------
function capture_image_done_two(){	
	if(document.getElementById('camera_canvas_two')){
		var canvas = document.getElementById('camera_canvas_two');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/document_two_session.php"); ?>', function(code, text) {
			$("#avater_image_2").html('<img src="<?=base_url(); ?>'+text+'" style="width:50px;" id="view_image_two"/>');
			$("#document_2_avater_val").val(text);
			$("#photo_avater_2").css({"width":"250px","float":"right"});
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
        var FR = new FileReader();
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
function open_doc_camera_2(){
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
	var cm = document.createElement("video_two");
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


//-----------------document three--------------------------
function capture_image_done_three(){	
	if(document.getElementById('camera_canvas_three')){
		var canvas = document.getElementById('camera_canvas_three');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/document_three_session.php"); ?>', function(code, text) {
			$("#avater_image_3").html('<img src="<?=base_url(); ?>'+text+'" style="width:50px;" id="view_image_three"/>');
			$("#document_3_avater_val").val(text);
			$("#photo_avater_3").css({"width":"250px","float":"right"});
			$('#camera_model_three').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file_three").on("change",function(){
	var fileUpload = document.getElementById('other_file_three');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas_three";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR = new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult_three").textContent = "";
				document.getElementById("DesiredResult_three").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_doc_camera_3(){
	$('#camera_model_three').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video#video_three');
	const videoSelect = document.querySelector('select#videoSource_three');
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
	function camera_start_three() {
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
	videoSelect.onchange = camera_start_three;
//-------------
	return camera_start_three();
}


function snap_three() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas_three";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video_three'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult_three").textContent = "";
    document.getElementById("DesiredResult_three").appendChild(cv);	
}
function retake_image_three(){
	var cm = document.createElement("video_three");
    cm.width = w;
    cm.id = "video_three" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult_three").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult_three").html('<video id="video_three" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video#video_three');
	const videoSelect = document.querySelector('select#videoSource_three');
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
	function camera_start_three() {
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
	videoSelect.onchange = camera_start_three;
//-------------
	return camera_start_three();
}
$(document).ready(function(){
	$('#camera_model_three').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------
</script>




<script>
function parking_payment_event(){
	if($("#parking").val() == '1' ){
		$("#payment_information_container").css({"display":"flex"});
		$("#cal_container").css({"display":"flex"});
	}else{
		$("#payment_information_container").css({"display":"none"});
		$("#cal_container").css({"display":"none"});
	}
}
//-------------------------------------
function payment_function_on_change(){
	if($("#payment_method1").val() == 'Mobile Banking'){
		$("#mobile_banking1").css({"display":"flex"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
	}else if($("#payment_method1").val() == 'Check'){
		$("#mobile_banking1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#check_number1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
	}else if($("#payment_method1").val() == 'Credit / Debit Card'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"flex"});
		$("#cash1").css({"display":"none"});
	}else if($("#payment_method1").val() == 'Cash'){
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"flex"});
	}else{
		$("#mobile_banking1").css({"display":"none"});
		$("#check_number1").css({"display":"none"});
		$("#credit_card1").css({"display":"none"});
		$("#cash1").css({"display":"none"});
	}
	
	if($("#payment_method12").val() == 'Mobile Banking'){
		$("#mobile_banking12").css({"display":"flex"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
	}else if($("#payment_method12").val() == 'Check'){
		$("#mobile_banking12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#check_number12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
	}else if($("#payment_method12").val() == 'Credit / Debit Card'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"flex"});
		$("#cash12").css({"display":"none"});
	}else if($("#payment_method12").val() == 'Cash'){
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"flex"});
	}else{
		$("#mobile_banking12").css({"display":"none"});
		$("#check_number12").css({"display":"none"});
		$("#credit_card12").css({"display":"none"});
		$("#cash12").css({"display":"none"});
	}
	
	if($("#payment_method13").val() == 'Mobile Banking'){
		$("#mobile_banking13").css({"display":"flex"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
	}else if($("#payment_method13").val() == 'Check'){
		$("#mobile_banking13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#check_number13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
	}else if($("#payment_method13").val() == 'Credit / Debit Card'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"flex"});
		$("#cash13").css({"display":"none"});
	}else if($("#payment_method13").val() == 'Cash'){
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"flex"});
	}else{
		$("#mobile_banking13").css({"display":"none"});
		$("#check_number13").css({"display":"none"});
		$("#credit_card13").css({"display":"none"});
		$("#cash13").css({"display":"none"});
	}
}

$('document').ready(function(){
	//-------------------payment-----------
	
	var counter_payment = 2;
    $("#addButton_payment").click(function () {	
		if( counter_payment == 4 ){
			alert("Sorry! Maximum number of field reached");
			return false;			
		}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv_payment1' + counter_payment ,
			class: 'row',
			style: 'width:100%margin-top: 10px;'
		});
		
		var dataq = '<div class="col-sm-3">';
			dataq += '<div class="form-group">';
			dataq += '<select onchange="return payment_function_on_change()" id="payment_method1'+counter_payment+'" name="payment_method[]" class="form-control">';
			dataq += '<option value="">select payment method</option>';
			dataq += '<option value="Cash">Cash</option>';
			dataq += '<option value="Mobile Banking">Mobile Banking</option>';
			dataq += '<option value="Credit / Debit Card">Credit / Debit Card</option>';
			dataq += '<option value="Check">Check</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-9">	';							
			dataq += '<div class="row" id="mobile_banking1'+counter_payment+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<select name="agent[]" class="form-control">';
			dataq += '<option value="">select agent</option>';
			dataq += '<option value="Bikash">bKash</option>';
			dataq += '<option value="Rocket">Rocket</option>';
			dataq += '<option value="Nogod">Nogod</option>';
			dataq += '</select>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="mobile_banking_number[]" placeholder="Mobile Banking Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';			
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="transaction_id[]" placeholder="TrxID" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="mobile_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="check_number1'+counter_payment+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="bank_name[]" placeholder="Bank Name" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';			
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="check_number[]" placeholder="Check Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="date" name="withdraw_date[]" placeholder="Withdraw Date (MM/DD/YYYY)" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="check_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="credit_card1'+counter_payment+'" style="display:none;">';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="credit_card_number[]" placeholder="Card Number" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="card_secret[]" placeholder="Card secret" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="month" name="Expiry_Date[]" placeholder="Expiry Date" autocomplete="off" min="<?php echo date("Y-m-d"); ?>" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="card_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="row" id="cash1'+counter_payment+'" style="display:none;">';
			dataq += '<div class="col-sm-9">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<textarea name="cash_other_information_remarks[]" style="height: 38px;" placeholder="More transaction information / Transaction Remarks" class="form-control"></textarea>';											
			dataq += '</div>';
			dataq += '</div>';
			dataq += '<div class="col-sm-3">';
			dataq += '<div class="form-group" style="width:100%;">';
			dataq += '<input type="text" name="cash_amount[]" placeholder="Amount" autocomplete="off" class="form-control"/>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';
			dataq += '</div>';

		newTextBoxDiv.after().html(dataq);
		newTextBoxDiv.appendTo("#UnitBoxesGroup_payment");
		counter_payment++;
    });
    $("#removeButton_payment").click(function () {
		if( counter_payment == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter_payment--;
        $("#UnitBoxDiv_payment1" + counter_payment).remove();
    });
	
    var counter = 2;
    $("#addButton").click(function () {
		if( counter == 4 ){
			alert("Sorry! Maximum number of field reached");
			return false;			
		}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv1' + counter ,
			class: 'row',
			style: 'width:100%'
		});		
		var data = '<div class="col-sm-6">';
			data += '<div class="form-group">';
			data += '<select name="document_type[]" class="form-control" required>';
			data += '<option value="">select Document Type</option>';
			data += '<?php if(!empty($doc_type)){ foreach($doc_type as $row){ echo '<option value="'.$row->document_type.'">'.$row->document_type.'</option>'; } } ?>';
			data += '</select>';
			data += '</div>';
			data += '</div>';			
			data += '<input type="hidden" name="document_number[]" value="" placeholder="Document serial number" class="form-control" required />';		
			data += '<div class="col-sm-6">';
			data += '<div class="form-group">';
			data += '<div class="custom-file">';
			data += '<span id="avater_image_'+counter+'"></span>';
			data += '<button id="photo_avater_'+counter+'" onclick="open_doc_camera_'+counter+'()"  type="button" class="btn btn-info form-control" style="height:38px;"><i class="fas fa-camera"></i> Document upload <i class="fas fa-upload"></i></button>';
			data += '<input type="hidden" name="document_upload[]" id="document_'+counter+'_avater_val" class="form-control" style="padding-top:3px;" required>';
			//data += '<label class="custom-file-label" for="customFile">Upload Document</label>';
			data += '</div>';
			data += '</div>';
			data += '</div>';
		newTextBoxDiv.after().html(data);
		newTextBoxDiv.appendTo("#UnitBoxesGroup");
		counter++;
    });
    $("#removeButton").click(function () {
		if( counter == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter--;
        $("#UnitBoxDiv1" + counter).remove();
    });
})
</script>
<script>
	$(document).ready(function(){
		document.getElementById("phone_number").readOnly = true;
		document.getElementById("email").readOnly = true;
		document.getElementById("mother_name").readOnly = true;
	});
</script>