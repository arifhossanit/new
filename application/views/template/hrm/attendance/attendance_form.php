<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Employee Attendance Form</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Attendance Form</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">	
					<div class="row">
						<div class="col-sm-2"></div>
						<div class="col-sm-4">
							<div class="card card-info">
								<div class="card-header">
									<h3 class="card-title"><i class="fas fa-search"></i> Select Criteria</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">	
									<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<select name="branch_id" class="form-control select2">													
														<option value="">All Branch</option>
														<?php
															if(!empty($banches)){
																foreach($banches as $row){
																	if(isset($_POST['branch_id']) AND $_POST['branch_id'] == $row->branch_id){
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
											
											<div class="col-sm-6">
												<div class="form-group">
													<select name="department_id" class="form-control select2">													
														<option value="">All Department</option>
														<?php
															if(!empty($department)){
																foreach($department as $row){
																	if(isset($_POST['department_id']) AND $_POST['department_id'] == $row->department_id){
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
											<div class="col-sm-12">
												<button name="search" type="submit" class="btn btn-sm btn-warning" style="float:right;"><i class="fas fa-search"></i> search</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						
						<div class="col-sm-4">
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title"><i class="far fa-file-excel"></i> xlsx Import</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">	
									<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
										<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="file" name="xlsx_sheet" class="form-control" style="padding-top:3px;" required /><!-- accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"-->
												</div>
											</div>
											
											
											<div class="col-sm-12">
												<a href="<?=base_url('assets/sample_files/attandencee_sample_file.xlsx'); ?>" type="button" class="btn btn-sm btn-info" style="float:left;color:#fff;" download><i class="fas fa-file-download"></i> Download Sample</a>
												<button name="import" type="submit" class="btn btn-sm btn-success" style="float:right;"><i class="fas fa-file-upload"></i> Import</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
<?php
if(!empty($table)){
?>
			<div class="row">
				<div class="col-sm-12" style="padding-top:20px;">				
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title"><i class="fas fa-user-tie"></i> Emploies List</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<style>.employee .form-group{margin-right:10px;}</style>
						<div class="card-body">	
							<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
								<style>#employee_data_table td{text-align:center;vertical-align: middle;padding-top:0px;padding-bottom:0px;}#employee_data_table th{text-align:center;vertical-align: middle;}</style>
								<table id="employee_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
								   <thead>
									  <tr>
										 <th>Image</th>
										 <th>ID</th>
										 <th>Employee ID</th>
										 <th>Name</th>
										 <th>Attendance type</th>
										 <th>CheckIn</th>
										 <th>CheckOut</th>
										 <th>Note</th>
									  </tr>
								   </thead>
								   <tbody>
<?php
foreach($table as $row ){
?>		
									<tr>
										<td>
											<?php
												if(!empty($row->photo)){
													echo '<img src="'.base_url().$row->photo.'" style="width:30px;"/>';
												}else{
													echo '<img src="'.base_url().'assets/imf/photo_avatar.png" style="width:30px;"/>';
												}
											?>
										</td>
										<td>
											<?php echo $row->id; ?>
											<input type="hidden" name="db_id[]" value="<?php echo $row->id; ?>"/>
										</td>
										<td>
											<?php echo $row->employee_id; ?>
											<input type="hidden" name="employee_id[]" value="<?php echo $row->employee_id; ?>"/>
										</td>
										<td><?php echo $row->full_name; ?></td>
										<td>
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<select name="attendence[]" class="form-control">
															<option value="">--select--</option>
															<option value="1" style="color:green;font-weight:bolder;">Present</option>
															<option value="0" style="color:red;font-weight:bolder;">Absent</option>
														</select>
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<input type="time" name="checkin[]" class="form-control"/>
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<input type="time" name="checkout[]" class="form-control"/>
													</div>
												</div>
											</div>
										</td>
										<td>
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<input type="text" name="note[]" placeholder="Note" class="form-control"/>
													</div>
												</div>
											</div>
										</td>
									</tr>
<?php } ?>
								   </tbody>
									
								</table>
								<div class="row">
									<div class="col-sm-12">
										<button name="save" type="submit" class="btn btn-success" style="float:right;">Save Attendance</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					
				
				</div>
			</div>			
<?php } ?>
			
		</div>
	</div>
</div>