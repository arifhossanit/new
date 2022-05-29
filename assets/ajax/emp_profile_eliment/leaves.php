<div class="tab-pane" id="leaves">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-info">
				<div class="card-header">
					Leave Request Logs
				</div>
				<div class="card-body">
					<table id="example2" class="table table-sm table-bordered" id="example2" style="width: 100% !important;">
						<thead>
							<tr>
								<th>Name</th>
								<th>Start Date</th>
								<th>NOD</th>
								<th>End Date</th>
								<th>Status</th>												
								<th>Requested</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>	
							<?php
								$sql = $mysqli->query("select * from employee_leave_logs where e_db_id = '".$row['id']."'");
								while($emp = mysqli_fetch_assoc($sql)){
							?>
								<tr>
									<td><?php echo $row['full_name'].' - '.$row['employee_id']; ?></td>
									<td><?php echo $emp['start_days']; ?></td>												
									<td><?php echo $emp['how_many_days']; ?> Days</td>
									<td><?php echo $emp['end_date']; ?></td>
									<td>
										<?php if($emp['aproval'] == 1){ ?>
											<button type="button" class="btn btn-xs btn-success">Approved</button>
										<?php }else if($emp['aproval'] == 2){ ?>
											<button type="button" class="btn btn-xs btn-danger">Rejected</button>
										<?php }else{ ?>
											<button type="button" class="btn btn-xs btn-info">Pending</button>	
										<?php } ?>
									</td>
									<td>
										<?php
											$u = explode('___',$emp['uploader_info']);
											$em = mysqli_fetch_assoc($mysqli->query("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01"));
											echo $em['full_name'].' - '.$em['employee_id']; 
										?>
									</td>
									<td><?php echo $emp['data']; ?></td>
								</tr>
							<?php }  ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	$('#example2').DataTable({
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