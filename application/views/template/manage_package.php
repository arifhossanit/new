<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Packages</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Manage Packages</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
<?php
if(!empty($edit)){
	$button = '
		<button type="submit" name="update" class="btn btn-warning">Update</button>
		<a href="'.current_url().'" class="btn btn-danger">Close</a>
	';
}else{
	$button = '<button type="submit" name="save" class="btn btn-primary">Save</button>';
}
?>	
	<div class="content">
		<div class="container-flud">
			<div class="row">
				<div class="col-sm-3">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Input Packages information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="form-group">
									<label>Select Branch</label>
									<select name="branch_id" id="branch_id" class="form-control select2" required>
										<option value="">--choose one--</option>
										<?php
											if(!empty($banches)){
												foreach($banches as $row){
													if(!empty($edit) AND $edit->branch_id == $row->branch_id){
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
								
								<div class="form-group">
									<label>Select Package Category</label>
									<select name="packagr_id_category" id="packagr_id_category" class="form-control select2" required>	
										<?php 
											if(!empty($edit)){ 
													echo '<option value="'.$edit->package_category_id.'" selected>'.$edit->package_category_name.'</option>';
											} 
										?>
									</select>
								</div>
								
								<div class="form-group">
									<div class="card card-default">
										<div class="card-body">
											<div class="row">
												<div class="col-12">
													<div class="form-group">
														<label>Select Services</label>
														<select name="services[]" id="services" class="duallistbox" multiple="multiple" required>
															<?php
																if(!empty($service)){
																	foreach($service as $row){
																		echo '<option value="'.$row->service_name.'" '.$selected.'>'.$row->service_name.'</option>';
																	}
																}
																if(!empty($edit)){ 
																	$enc = explode(",",$edit->services);
																	$i = '0';
																	foreach($enc as $row){
																		echo '<option value="'.$row.'" selected>'.$row.'</option>';
																	}
																} 
															?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Select Sub Category</label>
									<select name="sub_category_id" id="sub_category_id" class="form-control select2" required>
										<option value="">--choose one--</option>
										<?php
											if(!empty($sub_category)){
												foreach($sub_category as $row){
													if(!empty($edit) AND $edit->sub_category_id == $row->id){
														$selected = 'selected';
													}else{
														$selected = '';
													}
													echo '<option value="'.$row->id.'" '.$selected.'>'.$row->sub_package_name.'</option>';
												}
											}
										?>				
									</select>
								</div>
								<div class="form-group">
									<label>Package Name</label>
									<input name="package_name" value="<?php if(!empty($edit)){ echo $edit->package_name; } ?>" type="text" class="form-control" placeholder="Package Name" required>
								</div>
								<div class="form-group">
									<label>Is It TryUs?</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="toggle-two" name="try_us" <?php if(!empty($edit)){ if($edit->try_us == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo ''; } ?> data-toggle="toggle" data-on="YES" data-off="NO" data-onstyle="success" data-offstyle="danger"/>
								</div>
								<div class="form-group">
									<label>Is It Aggreement?</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="toggle-two" name="aggreement" <?php if(!empty($edit)){ if($edit->aggreement == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo ''; } ?> data-toggle="toggle" data-on="YES" data-off="NO" data-onstyle="success" data-offstyle="danger"/>
								</div>
								<div class="form-group">
									<label>Installment?</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="toggle-two" name="installment" <?php if(!empty($edit)){ if($edit->installment == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo ''; } ?> data-toggle="toggle" data-on="YES" data-off="NO" data-onstyle="success" data-offstyle="danger"/>
								</div>
								<div class="form-group">
									<label>Monthly Package?</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" id="toggle-two" name="monthly_package" <?php if(!empty($edit)){ if($edit->monthly_package == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo ''; } ?> data-toggle="toggle" data-on="YES" data-off="NO" data-onstyle="success" data-offstyle="danger"/>
								</div>
								<div class="form-group">
									<label>Security Deposit</label>
									<input name="package_price" value="<?php if(!empty($edit)){ echo $edit->package_price; } ?>" type="number" class="form-control" placeholder="Security Deposit" required>
								</div>								
								<div class="form-group">
									<label>Rental amount</label>
									<input name="monthly_rent" value="<?php if(!empty($edit)){ echo $edit->monthly_rent; } ?>" type="number" class="form-control" placeholder="Monthly Rent" required>
								</div>								
								<div class="form-group">
									<label>Package Days</label>
									<input name="package_days" value="<?php if(!empty($edit)){ echo $edit->package_days; } ?>" type="number" class="form-control" placeholder="Package Days" required>
								</div>
								<div class="form-group">
									<label>Parking Amount</label>
									<input name="parking_amount" value="<?php if(!empty($edit)){ echo $edit->parking_amount; } ?>" type="number" class="form-control" placeholder="Parking Amount" required>
								</div>
								
								<div class="form-group">
									<label>Card Change Amount</label>
									<input name="card_change_amount" value="<?php if(!empty($edit)){ echo $edit->card_change_amount; } ?>" type="number" class="form-control" placeholder="Card Change Amount" required>
								</div>
								
								<div class="form-group">
									<label>Discount Amount</label>
									<input name="discount_amount" value="<?php if(!empty($edit)){ echo $edit->discount_amount; } ?>" type="number" class="form-control" placeholder="Discount Amount" required>
								</div>

								<div class="form-group">
									<label>Group Discount Amount</label>
									<input name="group_discount_amount" value="<?php if(!empty($edit)){ echo $edit->group_discount_amount; } ?>" type="number" class="form-control" placeholder="Group Discount Amount" required>
								</div>
								
								<div class="form-group">
									<label>Auto cancel Days (Half Payment)</label>
									<input name="auto_cancel_days_half" value="<?php if(!empty($edit)){ echo $edit->auto_cancel_days_half; } ?>" type="number" class="form-control" placeholder="Auto cancel Days (Half Payment)" >
								</div>
								
								<div class="form-group">
									<label>Auto cancel Days (Full Payment)</label>
									<input name="auto_cancel_days_full" value="<?php if(!empty($edit)){ echo $edit->auto_cancel_days_full; } ?>" type="number" class="form-control" placeholder="Auto cancel Days (Full Payment)" >
								</div>
								
								<div class="form-group">
									<label>Auto cancel Days (After checkIn Date)</label>
									<input name="auto_cancel_days_checkin_date" value="<?php if(!empty($edit)){ echo $edit->auto_cancel_days_checkin_date; } ?>" type="number" class="form-control" placeholder="Auto cancel Days (After checkIn Date)" >
								</div>
								
								<div class="form-group">
									<label>Panalty Start days (Half Payment)</label>
									<input name="panalty_start_days_half_payment" value="<?php if(!empty($edit)){ echo $edit->panalty_start_days_half_payment; } ?>" type="number" class="form-control" placeholder="Panalty Start days" >
								</div>
								
								<div class="form-group">
									<label>Panalty Start days (Full Payment)</label>
									<input name="panalty_start_days_full_payment" value="<?php if(!empty($edit)){ echo $edit->panalty_start_days_full_payment; } ?>" type="number" class="form-control" placeholder="Panalty Start days" >
								</div>
								
								<div class="form-group">
									<label>Panalty Start days (After checkIn Date)</label>
									<input name="panalty_start_days_checkin_date" value="<?php if(!empty($edit)){ echo $edit->panalty_start_days_checkin_date; } ?>" type="number" class="form-control" placeholder="Panalty Start days (After checkIn Date)" >
								</div>
								
								<div class="form-group">
									<label>Panalty Amount</label>
									<input name="panalty_amount" value="<?php if(!empty($edit)){ echo $edit->panalty_amount; } ?>" type="number" class="form-control" placeholder="Panalty Amount" >
								</div>
								
								<div class="form-group">
									<label>package Enable/Disable</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="checkbox" name="status" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-toggle="toggle" data-on="ON" data-off="OFF" data-onstyle="success" data-offstyle="danger"/>
								</div>
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control" placeholder="Note"><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
								</div>

							</div>
							<div class="card-footer">
								<?php echo $button; ?>
							</div>
						</form>
					</div>
				</div>				
				
				<div class="col-sm-9">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Package List</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body" style="max-width:100%;">
						<style>div.dataTables_wrapper div.dataTables_paginate ul.pagination{justify-content: flex-start !important;}</style>
							<table class="table table-sm table-bordered" id="data_table" style=" white-space: nowrap;">
								<thead>
									<tr>
										<th>ID</th> 										
										<th>Option</th>
										<th>Status</th>
										<th>TryUs</th>
										<th>Aggreement</th>
										<th>Installment</th>
										<th>Monthly Package</th>
										<th>Branch</th>
										<th>Package Category</th>
										<th>Package Name</th>
										<th>Security Deposit</th>
										<th>Rental Amount</th>										
										<th>Parking Amount</th>										
										<th>Card Change Amount</th>
										<th>Discount Amount</th>
										<th>Group Discount Amount</th>
										<th>Panalty Amount</th>
										<th>Package Days</th>
										<th>Auto Cancel Days (Half Payment)</th>
										<th>Auto Cancel Days (Full Payment)</th>
										<th>Auto Cancel Days (After CheckIn)</th>
										<th>Panalty Start Days (Half Payment)</th>
										<th>Panalty Start Days (Full Payment)</th>
										<th>Panalty Start Days (After CheckIn)</th>																			
										<th>Entry Date</th>
										
									</tr>
								</thead>
								<tbody>
<?php /*
if(!empty($table)){
	foreach($table as $row){
?>								
									<tr>
										<td><?=$row->id;?></td>										
										<td>
											<form action="<?=current_url(); ?>" method="post">
												<input type="hidden" value="<?=$row->id;?>" name="hidden_id"/>
												<button name="edit" type="submit" class="btn btn-xs btn-success"><i class="far fa-edit"></i></button>
												<button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
											</form>
										</td>
										<td>
											<?php if($row->status == '1'){ ?>
												<button class="btn btn-xs btn-success">Active</button>
											<?php }else{ ?>
												<button class="btn btn-xs btn-danger">Deactive</button>
											<?php } ?>
										</td>
										<td>
											<?php if($row->try_us == '1'){ ?>
												<button class="btn btn-xs btn-warning">TryUs</button>
											<?php }else{ ?>
												<button class="btn btn-xs btn-primary">General</button>
											<?php } ?>
										</td>
										<td><?=$row->branch_name;?></td>
										<td><?=$row->package_category_name;?></td>
										<td><?=$row->package_name;?></td>
										<td><?=money($row->package_price);?></td>
										<td><?=money($row->monthly_rent);?></td>										
										<td><?=money($row->parking_amount);?></td>										
										<td><?=money($row->card_change_amount);?></td>										
										<td><?php if(!empty($row->discount_amount)){ echo money($row->discount_amount); } ?></td>										
										<td><?=$row->package_days;?> Days</td>
										<td><?=$row->data;?></td>
										
									</tr>
<?php } } */ ?>									
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
$(document).ready(function() {
	$("#branch_id").on("change",function(){
		var id = $( this ).val(); 
		if(id != ''){		
			$.ajax({  
				url:"<?=base_url('assets/ajax/select_spackage_category_options.php');?>",  
				method:"POST",  
				data:{view_id:id},
				beforeSend:function(){					
					$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
				},
				success:function(data){	
					$('#packagr_id_category').html(data);
					$('#data-loading').html('');
				}  
			});	
			
		}
	})	
	
})
$(document).ready(function() {
	var table_info = '<?php echo "?branch_id=".rahat_encode($_SESSION['super_admin']['branch'])."&user_type=".rahat_encode($_SESSION['super_admin']['user_type']).""; ?>';
    var table_booking = $('#data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		"searching": true,
		"ordering": true,
		"processing": true,
        "serverSide": true,
		"scrollX": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/package_information_datatable.php"+table_info,
		<?php if(check_permission('role_1603968189_34')){ ?>
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
		<?php } ?>
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>