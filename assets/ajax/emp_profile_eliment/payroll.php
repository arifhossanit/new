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
							$ratingm = mysqli_fetch_assoc($mysqli->query("select count(*) as total_rating, sum(value) as total_value from employee_rating where employee_id = '".$row['id']."' and month = '".date('m')."' and year = '".date('Y')."'")); 
							if($ratingm['total_rating'] > 0){
						?>
						<table class="table table-sm table-bordered">
							<tbody>
								<tr>
									<td>Rating Point:</td>
									<td><?php echo round(($ratingm['total_value'] )/ $ratingm['total_rating'],'2'); ?></td>
								</tr>
								<tr>
									<td>Total Rating:</td>
									<td><?php echo $ratingm['total_rating']; ?></td>
								</tr>
								<tr>
									<td>Maximum Rating:</td>
									<td>
									<?php
										if(!empty($maxi_r['value'])){
											$maxi_r = mysqli_fetch_assoc($mysqli->query("select value from employee_rating where employee_id = '".$row['id']."' and month = '".date('m')."' and year = '".date('Y')."' order by value desc"));
											echo $maxi_r['value']; 
										}else{
											echo '0';
										}
										
									?>
									</td>
								</tr>
								<tr>
									<td>Minimum Rating:</td>
									<td>
									<?php
										if(!empty($mini_r['value'])){
											$mini_r = mysqli_fetch_assoc($mysqli->query("select value from employee_rating where employee_id = '".$row['id']."' and month = '".date('m')."' and year = '".date('Y')."' order by value asc"));
											echo $mini_r['value']; 
										}else{
											echo '0'; 
										}
										
									?>
									</td>
								</tr>
							</tbody>
						</table>
						<?php }else{ ?>
							<p style="text-align:">NO Rating Yet!</p>
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
							<p style="text-align:">NO Rating Yet!</p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<div class="row" style="margin-top:15px;">
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h5><i class="fas fa-money-check-alt"></i> Total Gross Salary</h5>
					</div> 
					<div class="card-body">
						BDT 20000.00
					</div>
				</div>
			</div>
			
			<div class="col-sm-4">
				<div class="card">
					<div class="card-header">
						<h5><i class="fas fa-money-check-alt"></i> Total Net Salary Paid</h5>
					</div> 
					<div class="card-body">
						BDT 20000.00
					</div>
				</div>
			</div>
			
			<div class="col-sm-4">
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