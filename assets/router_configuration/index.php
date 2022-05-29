<?php
include("../../application/config/ajax_config.php");
if(isset($_SESSION['super_admin']['branch'])){
include("engine/mikrotik/routeros_api.class.php");
ob_start();
include("engine/query.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include("include/css.php"); ?>
</head>
<body>
	<div id="data-loading"></div>
	<div class="container-fluid">
		<div class="content-header">
		  <div class="container-fluid">
			<div class="row mb-2">
			  <div class="col-sm-6">
				<h1 class="m-0 text-dark">Router Configuration</h1>
			  </div> 
			  <div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
				  <li class="breadcrumb-item"><a href="#">Home</a></li>
				  <li class="breadcrumb-item"><a href="#">Create</a></li>
				  <li class="breadcrumb-item"><a href="#">Network</a></li>
				  <li class="breadcrumb-item active">Router Configuration</li>
				</ol>
			  </div> 
			</div> 
		  </div> 
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Router Configuration</h3>
					</div>
					<div class="card-body">
						<form id="router_configuration_form" action="#" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit['id'])){ echo $edit['id']; } ?>"/>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Choose branch</label>
										<select name="branch_id" class="form-control select2" required>
											<option value="">--select--</option>
											<?php 
												$branch_sql = $mysqli->query("select * from branches where status = '1'");											
												while($row = mysqli_fetch_assoc($branch_sql)){
													if(!empty($edit['branch_id']) AND $edit['branch_id'] == $row['branch_id']){
														$selected = 'selected';
													}else{
														$selected = '';
													}
													echo '<option value="'.$row['branch_id'].'" '.$selected.'>'.$row['branch_name'].'</option>';
												}
											?>
										</select>
									</div>
									<div class="form-group">
										<label>Router IP Address</label>
										<input type="text" name="router_id_address" value="<?php if(!empty($edit['router_id_address'])){ echo $edit['router_id_address']; } ?>" class="form-control" placeholder="Router IP Address" required />
									</div>
									<div class="form-group">
										<label>Router Access Password</label>
										<input type="text" name="router_password" value="<?php if(!empty($edit['router_password'])){ echo $edit['router_password']; } ?>" class="form-control" placeholder="Router Access Password" required />
									</div>
									<div class="form-group">
										<label>Router Name</label>
										<input type="text" name="router_name" value="<?php if(!empty($edit['router_name'])){ echo $edit['router_name']; } ?>" class="form-control" placeholder="Router Name" required />
									</div>
									<div class="form-group">
										<label>Service Enable/Disable</label>
										<select name="status" class="form-control select2" required>
											<?php
												if(!empty($edit['id'])){
													if($edit['status'] == 1){
														echo '
															<option value="1">Enabled</option>
															<option value="0">Disabled</option>
														';
													}else{
														echo '															
															<option value="0">Disabled</option>
															<option value="1">Enabled</option>
														';
													}
												}else{
											?>
											<option value="">--sselect--</option>
											<option value="1">Enabled</option>
											<option value="0">Disabled</option>	
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label>Note</label>
										<textarea name="note" class="form-control"><?php if(!empty($edit['note'])){ echo $edit['note']; } ?></textarea>
									</div>
									<div class="form-group">
									<?php if(!empty($edit['id'])){ ?>
										<a href="index.php" class="btn btn-danger">Back</a>
										<button name="update_router" type="submit" class="btn btn-warning" style="float:right;">Update Router</button>
									<?php }else{ ?>
										<button name="add_router" type="submit" class="btn btn-success" style="float:right;">Add Router</button>
									<?php } ?>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="card card-success">
					<div class="card-header">
						<h3 class="card-title">Router List</h3>
						<div id="export_buttons" style="float: right;"></div>
					</div>
					<div class="card-body">
						<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
						<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
							<thead>
								<tr>
									<th>Id</th>
									<th>Branch</th>
									<th>Address</th>
									<th>Password</th>
									<th>Name</th>
									<th>Connection</th>									
									<th>Status</th>
									<th>Date</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$router_api = new routeros_api();
							$router_sql = $mysqli->query("select * from router_configuration");
							while($row = mysqli_fetch_assoc($router_sql)){
								$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch_id']."'"));
								$router_connection = $router_api->connect($row['router_id_address'], $row['router_name'], $row['router_password']);
							
							?>
								<tr>
									<td><?php echo $row['id']; ?></td>
									<td><?php echo $branch['branch_name']; ?></td>
									<td><?php echo $row['router_id_address']; ?></td>
									<td><?php echo $row['router_password']; ?></td>
									<td><?php echo $row['router_name']; ?></td>
									<td>
										<?php
											if($router_connection){
												echo '<button type="button" class="btn btn-xs btn-success">Connected</button>';
												echo '&nbsp;<button onclick="return view_router_information('.$row['id'].')" type="button" class="btn btn-xs btn-info"><i class="fas fa-bars"></i></button>';
												echo '&nbsp;<button onclick="return view_router_dashboard('.$row['id'].')" type="button" class="btn btn-xs btn-dark"><i class="fas fa-globe-americas"></i></button>';
											}else{
												echo '<button type="button" class="btn btn-xs btn-danger">Disconnected</button>';
											}
										?>
									</td>
									<td>
										<?php 
											if($row['status'] == 1){
												echo '<button type="button" class="btn btn-xs btn-success">Enabled</button>';
											}else{
												echo '<button type="button" class="btn btn-xs btn-danger">Disabled</button>';
											}
										?>
									</td>
									<td><?php echo $row['data']; ?></td>
									<td>
										<a href="?edit_router=<?php echo $row['id']; ?>" class="btn btn-xs btn-success"><i class="far fa-edit"></i></a>
										<a href="?delete_router=<?php echo $row['id']; ?>" class="btn btn-xs btn-danger" onclick="confirm('Are you sure want to delete?')"><i class="fas fa-trash-alt"></i></a>
									</td>
								</tr>
							<?php } ?>
							</tbody>							
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!----Router Information-->
	<div class="modal fade" id="router_information_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form id="create_booking_group" action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Router Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="router_information_result"></div>
				</form>
			</div>
		</div>
	</div>
<!----End Router Information-->
<!----Router Information-->
	<div class="modal fade" id="router_dashboard_modal">
		<div class="modal-dialog modal-xl" style="min-width:85%;">
			<div class="modal-content">
				<form id="create_booking_group" action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-dark">
						<h4 class="modal-title">Router Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="router_dashboard_result"></div>
				</form>
			</div>
		</div>
	</div>
<!----End Router Information-->
<?php include("include/js.php"); ?>
</body>
</html>
<?php } ?>