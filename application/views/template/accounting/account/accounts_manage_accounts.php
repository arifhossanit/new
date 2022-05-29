<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Account Management</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
				<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounts</a></li>
				<li class="breadcrumb-item active">Account Management</li>
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
	$button = '<button name="save_account_type" type="submit" class="btn btn-success" style="width:100%;">SAVE</button>';
}

if(!empty($edit_sub)){
	$sub_button = '
		<button type="submit" name="sub_update" class="btn btn-warning">Update</button>
		<a href="'.current_url().'" class="btn btn-danger">Close</a>
	';
}else{
	$sub_button = '<button name="save_sub_account_type" type="submit" class="btn btn-success" style="width:100%;">SAVE</button>';
}
?>
	<div class="content">
		<div class="container-fluid">
			<div class="row">				
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="card card-success">
						<div class="card-header">
							<h4 style="float:left;">Manage Account Type</h4>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data" style="width:100%;">
										<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
										<div class="row">
											<div class="col-sm-3">
												<div class="form-group">
													<label>Select Branch</label>
													<select name="branch_id" id="branch_id" class="form-control select2" <?php if(!empty($edit)){ echo 'disabled'; }else{ echo 'required'; }?>>
														<option value="">Select Branch</option>
														<?php 
															$branches = $this->Dashboard_model->mysqlii("select * from branches where status = '1'");
															if(!empty($branches)){
																foreach($branches as $row){
																	if(!empty($edit) and $edit->branch_id == $row->branch_id){
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
											<div class="col-sm-3">
												<div class="form-group">
													<label>Account type</label>
													<input type="text" name="account_type" value="<?php if(!empty($edit)){ echo $edit->name; } ?>" class="form-control" placeholder="Account Type" autocomplete="off" required />
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label>Opening Balance</label>
													<input type="text" name="opening_balance" value="<?php if(!empty($edit)){ echo $edit->oppning_balance; }else{ echo '0'; } ?>" class="number_int form-control" placeholder="Opening Balance" autocomplete="off"  <?php if(!empty($edit)){ echo 'disabled'; }else{ echo 'required'; }?> />
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label>Status</label>
													<select name="status" class="form-control select2" required>
														<?php if(!empty($edit) AND $edit->status == '1'){ ?>
														<option value="1">Enable</option>
														<option value="0">Disable</option>
														<?php } else if(!empty($edit) AND $edit->status == '0'){ ?>
														<option value="2">Disable</option>
														<option value="1">Enable</option>														
														<?php }else{ ?>
														<option value="1">Enable</option>
														<option value="2">Disable</option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label>Choose Parents</label>
													<select name="parents_id" class="form-control select2">
														<option value="">Select Parents</option>														
													</select>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Note/Remarks</label>
													<textarea name="note" class="form-control" placeholder="Note" style="height: 38px;"><?php if(!empty($edit)){ echo $edit->note; } ?></textarea>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group">
													<label style="width: 100%;">&nbsp;</label>
													<?php echo $button; ?>													
												</div>
											</div>
											
										</div>
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
										<thead>
											<tr>
												<th>Id</th>
												<th>Code</th>
												<th>Branch</th>
												<th>Account_type</th>
												<th>Balance</th>
												<th>Uploader</th>
												<th>Date</th>
												<th>Status</th>
												<th>Option</th>
											</tr>
										</thead>
										<tbody>	
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

<script>
$(document).ready(function() {	
	var signal = '1';
	$.ajax({  
		url:"<?=base_url('assets/ajax/accounting/select_account_headt_parents.php'); ?>",  
		method:"POST",  
		data:{signal_one:signal},
		success:function(data){	
			$('select[name="parents_id"]').html(data);
		}
	}); 
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		//"info": true,
		//"autoWidth": true,
		//"responsive": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/accounting/accounts/account_type_information_datatable.php",
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
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
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]

    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
</script>