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
											<td>Father Name</td>
											<td><?php echo $row['father_name']; ?></td>
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
											<td>Mother Name</td>
											<td><?php echo $row['mother_name']; ?></td>
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
							<td>Current Address</td>
							<td><?php echo $row['current_address']; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<table class="table table-sm table-bordered">
					<tbody>
						<tr>
							<td>Permanent Address</td>
							<td><?php echo $row['permanent_address']; ?></td>
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