<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Set Attendance Bonus</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">HRM</a></li>
						<li class="breadcrumb-item"><a href="#">Payroll</a></li>
						<li class="breadcrumb-item active">Set Attendance Bonus</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="row">		
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-3">
									<div class="card card-info">
										<div class="card-header">
											Set Attendance Bonus
										</div>
										<div class="card-body">
											<form action="<?php echo current_url(); ?>" method="POST">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<label>Select Designation</label>
															<select name="designation_id" class="form-control select2" required >
																<option value="">--select--</option>
																<?php
																	if(!empty($designations)){
																		foreach($designations as $row){
																			echo '<option value="'.$row->designation_id.'">'.$row->designation_name.'</option>';
																		}
																	}
																?>
															</select>
														</div>
														<div class="form-group">
															<label>Amount</label>
															<input type="text" name="amount" autocomplete="off" placeholder="Bonus Amount" class="number_int form-control" required="required"/>
														</div>
														<div class="form-group">
															<label>Note</label>
															<textarea name="note" placeholder="Note" class="form-control"></textarea>
														</div>
														<div class="form-group">
															<button type="submit" name="save" class="btn btn-success" style="float:right;">Save</button>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
								<div class="col-sm-9">
									<div class="card card-success">
										<div class="card-header">
											Set Attendance Bonus Logs
										</div>
										<div class="card-body">
											<table class="table table-sm table-bordered" id="example2">
												<thead>
													<tr>
														<th>Name</th>
														<th>Amount</th>
														<th>Uploader</th>
														<th>Date</th>
														<th>Option</th>
													</tr>
												</thead>
												<tbody>
												<?php
													if(!empty($att_bonus_log)){
														foreach($att_bonus_log as $row){
															$desig = $this->Dashboard_model->mysqlii("select * from designation where designation_id = '".$row->designation_id."' order by id desc limit 01");
												?>
													<tr>
														<td><?php echo $row->designation_name; ?></td>
														<td><?php echo money($row->amount); ?></td>
														<td>
															<?php
																$u = explode('___',$row->uploader_info);
																$em = $this->Dashboard_model->mysqlii("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01");
																echo $em[0]->full_name.' - '.$em[0]->employee_id; 
															?>
														</td>
														<td><?php echo $row->data; ?></td>
														<td>
															<form action="<?php echo current_url(); ?>" method="post">
																<input type="hidden" name="delete_id" value="<?php echo $row->id; ?>"/>
																<button type="submit" name="delete_data"  class="btn btn-xs btn-danger" onclick="return confirm('Are you sure want to Remove <?php echo $row->designation_name; ?>?')">Remove</button>
															</form>
														</td>
													</tr>
												<?php } } ?>
												</tbody>
											</table>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>