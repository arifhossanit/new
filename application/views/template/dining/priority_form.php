<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4" style="margin-top:5vw;">
				<form id="" action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-12" style="border:solid 1px #e3e3e3;margin-bottom:25px;background-color:#fff;border-radius:5px;padding-top:15px;padding-bottom:15px;">
							<div class="row">
								<div class="col-sm-12" style="margin-bottom:30px;">
									<center>
										<img class="logo" src="<?php echo base_url(); ?>assets/img/n_logo.png" alt="" style="width:90px;">
										<h2>Priority Form</h2>
									</center>
								</div>
								<div class="col-sm-12" style=" padding-left: 15px; padding-right: 15px;">
									<div class="row">
										<div class="col-sm-4" style="min-width:100%;">
											<div class="form-group">
												<label>Your Name</label>
												<input type="text" name="applicant_name" class="form-control" placeholder="Your Name" required />
											</div>
										</div>
										<div class="col-sm-4" style="min-width:100%;">
											<div class="form-group">
												<label>Your Phone Number</label>
												<input type="number" name="phone_number" class="mumber_int form-control" placeholder="Phone Number" minlength="11" maxlength="11" required />
											</div>
										</div>
										
										<div class="col-sm-4" style="min-width:100%;">
											<div class="form-group">
												<label>Select Branches</label>
												<select name="branch_is" class="form-control" required> <!--select2-->
													<option value="">--select one--</option>
													<?php
														$branches = $this->Dashboard_model->mysqlii("select * from branches where id not in('1')");
														if(!empty($branches)){
															foreach($branches as $row){
																echo '<option value="'.$row->branch_id.'">'.$row->branch_location.' ('.$row->branch_name.')</option>';
															}
														}
													?>
												</select>
											</div>
										</div>
										
										<div class="col-sm-4" style="min-width:100%;">
											<div class="form-group">
												<label>Select Package</label>
												<select name="package_name" class="form-control" required><!--select2-->
													<option value="">--select one--</option>
													<option value="1 Day Package">1 Day Package</option>
													<option value="3 Days Packages">3 Days Packages</option>
													<option value="7 Days Packages">7 Days Packages</option>
													<option value="15 Days Packages">15 Days Packages</option>
													<option value="Monthly Packages">Monthly Packages</option>												
												</select>
											</div>
										</div>
										
										<div class="col-sm-4" style="min-width:100%;">
											<div class="form-group">
												<label>Needed Date</label>
												<input type="date" id="needed_date" name="needed_date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo $max_date; ?>" class="form-control" required placeholder="Needed Date"/>
											</div>
										</div>
										<div class="col-sm-4" style="min-width:100%;">
											<div class="form-group">
												<label>&nbsp;</label>
												<button type="submit" name="submit" class="btn btn-success" style="width:100%;">Submit</button>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>					
				</form>
			</div><?php echo $max_date; ?>
		
		</div>
	</div>
</div>
