<div class="tab-pane" id="timelineh">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-primary card-tabs">
				<div class="card-header p-0 pt-1" style="height: 48px;">
					<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist" style="margin-left:10px;">
						<li class="nav-item"> <a class="nav-link active" id="custom-tabs-one-increament-tab" data-toggle="pill" href="#custom-tabs-one-increament" role="tab" aria-controls="custom-tabs-one-increament" aria-selected="true">Increament</a> </li>
						<li class="nav-item"> <a class="nav-link" id="custom-tabs-one-decreament-tab" data-toggle="pill" href="#custom-tabs-one-decreament" role="tab" aria-controls="custom-tabs-one-decreament" aria-selected="false">Decreament</a> </li>
						<li class="nav-item"> <a class="nav-link" id="custom-tabs-one-loan-tab" data-toggle="pill" href="#custom-tabs-one-loan" role="tab" aria-controls="custom-tabs-one-loan" aria-selected="false">Loan</a> </li>
						<li class="nav-item"> <a class="nav-link" id="custom-tabs-one-performance-tab" data-toggle="pill" href="#custom-tabs-one-performance" role="tab" aria-controls="custom-tabs-one-performance" aria-selected="false">Performance</a> </li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content" id="custom-tabs-one-tabContent">
						<div class="tab-pane fade active show" id="custom-tabs-one-increament" role="tabpanel" aria-labelledby="custom-tabs-one-increament-tab">
							<table class="table table-sm table-bordered" id="example6" style="width:100%;">
								<thead>
									<tr>
										<th>Name</th>
										<th>Amount</th>
										<th>Start Date</th>
										<th>Designation</th>
										<th>Aproval</th>
										<th>Uploader</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$sql = $mysqli->query("select * from employee_increament_logs where e_db_id = '".$row['id']."'");
									while($info = mysqli_fetch_assoc($sql)){
										$emp = mysqli_fetch_assoc($mysqli->query("select employee_id,full_name from employee where id = '".$row['id']."' order by id desc limit 01"));
										$deg = mysqli_fetch_assoc($mysqli->query("select designation_name from designation where designation_id = '".$info['designation']."' order by id desc limit 01"));
								?>
									<tr>
										<td><?php echo $emp['full_name'].' - '.$emp['employee_id']; ?></td>
										<td><?php echo money($info['amount']); ?></td>
										<td><?php echo $info['start_date']; ?></td>												
										<td><?php echo $deg['designation_name']; ?></td>
										<td>
											<?php if($info['aproval'] == 1){ ?>
												<button type="button" class="btn btn-xs btn-success">Approved</button>
											<?php }else if($info['aproval'] == 2){ ?>
												<button type="button" class="btn btn-xs btn-danger">Rejected</button>
											<?php }else{ ?>
												<button type="button" class="btn btn-xs btn-info">Pending</button>	
											<?php } ?>
										</td>
										<td>
											<?php
												$u = explode('___',$info['uploader_info']);
												$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01"));
												echo $em['full_name'].' - '.$em['employee_id']; 
											?>
										</td>
										<td><?php echo $info['data']; ?></td>
									</tr>
								<?php }  ?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="custom-tabs-one-decreament" role="tabpanel" aria-labelledby="custom-tabs-one-decreament-tab">
							<table class="table table-sm table-bordered" id="example7" style="width:100%;">
								<thead>
									<tr>
										<th>Name</th>
										<th>Amount</th>
										<th>Start Date</th>
										<th>Designation</th>
										<th>Aproval</th>
										<th>Uploader</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$sql = $mysqli->query("select * from employee_decreament_logs where e_db_id = '".$row['id']."'");
									while($info = mysqli_fetch_assoc($sql)){
										$emp = mysqli_fetch_assoc($mysqli->query("select employee_id,full_name from employee where id = '".$row['id']."' order by id desc limit 01"));
										$deg = mysqli_fetch_assoc($mysqli->query("select designation_name from designation where designation_id = '".$info['designation']."' order by id desc limit 01"));
								?>
									<tr>
										<td><?php echo $emp['full_name'].' - '.$emp['employee_id']; ?></td>
										<td><?php echo money($info['amount']); ?></td>
										<td><?php echo $info['start_date']; ?></td>												
										<td><?php echo $deg['designation_name']; ?></td>
										<td>
											<?php if($info['aproval'] == 1){ ?>
												<button type="button" class="btn btn-xs btn-success">Approved</button>
											<?php }else if($info['aproval'] == 2){ ?>
												<button type="button" class="btn btn-xs btn-danger">Rejected</button>
											<?php }else{ ?>
												<button type="button" class="btn btn-xs btn-info">Pending</button>	
											<?php } ?>
										</td>
										<td>
											<?php
												$u = explode('___',$info['uploader_info']);
												$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01"));
												echo $em['full_name'].' - '.$em['employee_id']; 
											?>
										</td>
										<td><?php echo $info['data']; ?></td>
									</tr>
								<?php }  ?>
								</tbody>
							</table>
						</div> 
						<div class="tab-pane fade" id="custom-tabs-one-loan" role="tabpanel" aria-labelledby="custom-tabs-one-loan-tab">
							<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
								<thead>
									<tr>
										<th>Employee</th>
										<th>Amount</th>
										<th>Uploder</th>
										<th>Aproval</th>
										<th>A:Aproval</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$sql = $mysqli->query("select * from employee_grant_loan where e_db_id = '".$row['id']."'");
									while($info = mysqli_fetch_assoc($sql)){
										$emp = mysqli_fetch_assoc($mysqli->query("select employee_id,full_name from employee where id = '".$row['id']."' order by id desc limit 01"));
										
								?>
									<tr>
										<td><?php echo $emp['full_name'].' - '.$emp['employee_id']; ?></td>
										<td><?php echo money($info['amount']); ?></td>
										<td>
											<?php
												$u = explode('___',$info['uploader_info']);
												$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01"));
												echo $em['full_name'].' - '.$em['employee_id']; 
											?>
										</td>											
										<td>
											<?php if($info['aproval'] == 1){ ?>
												<button type="button" class="btn btn-xs btn-success">Approved</button>
											<?php }else if($info['aproval'] == 2){ ?>
												<button type="button" class="btn btn-xs btn-danger">Rejected</button>
											<?php }else{ ?>
												<button type="button" class="btn btn-xs btn-info">Pending</button>	
											<?php } ?>
										</td>
										<td>
											<?php if($info['aproval_account'] == 1){ ?>
												<button type="button" class="btn btn-xs btn-success">Approved</button>
											<?php }else if($info['aproval_account'] == 2){ ?>
												<button type="button" class="btn btn-xs btn-danger">Rejected</button>
											<?php }else{ ?>
												<button type="button" class="btn btn-xs btn-info">Pending</button>	
											<?php } ?>
										</td>
										
										<td><?php echo $info['data']; ?></td>
									</tr>
								<?php }  ?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="custom-tabs-one-performance" role="tabpanel" aria-labelledby="custom-tabs-one-performance-tab">
							<table class="table table-sm table-bordered" id="example2" style="width:100%;">
								<thead>
									<tr>
										<th>Name</th>
										<th>Percentage</th>
										<th>Month</th>
										<th>Aproval</th>
										<th>Uploader</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$sql = $mysqli->query("select * from employee_performance_logs where e_db_id = '".$row['id']."'");
									while($info = mysqli_fetch_assoc($sql)){
										$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$info['e_db_id']."' order by id desc limit 01"));
								?>
									<tr>
										<td><?php echo $emp['full_name'].' - '.$emp['employee_id']; ?></td>
										<td><b><?php echo $info['percentage']; ?></b><small>%</small></td>
										<td><?php echo $info['month_year']; ?></td>												
										<td>
											<?php if($info['aproval'] == 1){ ?>
												<button type="button" class="btn btn-xs btn-success">Approved</button>
											<?php }else if($info['aproval'] == 2){ ?>
												<button type="button" class="btn btn-xs btn-danger">Rejected</button>
											<?php }else{ ?>
												<button type="button" class="btn btn-xs btn-info">Pending</button>	
											<?php } ?>
										</td>
										<td>
											<?php
												$u = explode('___',$info['uploader_info']);
												$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01"));
												echo $em['full_name'].' - '.$em['employee_id']; 
											?>
										</td>
										<td><?php echo $info['data']; ?></td>
									</tr>
								<?php }  ?>
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
            </div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	$('#example6').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true
    });
	$('#example7').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true
    });
	$('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
		"responsive": true
    });
	
})
</script>