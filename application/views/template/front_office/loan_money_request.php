<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Advance Salary Request</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Profile</a></li>
						<li class="breadcrumb-item active">Advance Salary Request</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Advance Salary Request</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="employee_id" value="<?php echo $_SESSION['super_admin']['employee_id']; ?>"/>
							<div class="row">
								<div class="col-sm-4"></div>
								<div class="col-sm-4">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<input type="text" name="amount" id="amount" class="form-control number_int" placeholder="Amount(BDT)" autocomplete="off" required />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<textarea name="note" id="note" class="form-control" style="height:120px;" placeholder="Note" required ></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<button name="send_request" type="submit" class="btn btn-success" style="float:right;">Send Request</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-4"></div>
							</div>
							<div class="row">
								<div class="col-sm-12" style="padding-top:20px;padding-bottom:10px;">
									<div id="export_buttons_due"></div>
								</div>
								<div class="col-sm-12">
									<style>#due_data_table td{text-align:center;vertical-align: middle;}#due_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="candidate_list" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;">
										<thead>
											<tr>
												<th>Name</th>
												<th>Amount</th>
												<th>D:Head Aproval</th>
												<th>Boss Aproval</th>
												<th>Aproval Note</th>
												<th>A:Aproval</th>
												<th>Uploader</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if(!empty($emp_list_table)){
												foreach($emp_list_table as $row){
													$emp = $this->Dashboard_model->mysqlii("select * from employee where id = '".$row->e_db_id."' order by id desc limit 01");
										?>
											<tr>
												<td><?php echo $emp[0]->full_name.' - '.$emp[0]->employee_id; ?></td>
												<td><?php echo money($row->amount); ?></td>
												<td>
													<?php if($row->aproval == 3){ ?>
														<button type="button" class="btn btn-xs btn-info">Pending</button>	
													<?php }else if($row->aproval == 4){ ?>
														<button type="button" class="btn btn-xs btn-danger">Rejected</button>
													<?php }else{ ?>
														<button type="button" class="btn btn-xs btn-success">Approved</button>
													<?php } ?>
												</td>
												<td>
													<?php if($row->aproval == 1){ ?>
														<button type="button" class="btn btn-xs btn-success">Approved</button>
													<?php }else if($row->aproval == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger">Rejected</button>
													<?php }else{ ?>
														<button type="button" class="btn btn-xs btn-info">Pending</button>	
													<?php } ?>
												</td>
												<td>
													<?php if($row->aproval != 0 AND $row->aproval != 3){ 
														$get_approval_note = $this->Dashboard_model->mysqlij("SELECT * from employee_loan_aproval where grant_loan_id = ".$row->id);
														echo $get_approval_note->note;
													 }else{
														echo ' - ';
													 }
													?>
												</td>
												<td>
													<?php if($row->aproval_account == 1){ ?>
														<button type="button" class="btn btn-xs btn-success">Approved</button>
													<?php }else if($row->aproval_account == 2){ ?>
														<button type="button" class="btn btn-xs btn-danger">Rejected</button>
													<?php }else{ ?>
														<button type="button" class="btn btn-xs btn-info">Pending</button>	
													<?php } ?>
												</td>
												<td>
													<?php
														$u = explode('___',$row->uploader_info);
														$em = $this->Dashboard_model->mysqlii("select full_name,employee_id from employee where email = '".$u[1]."' order by id desc limit 01");
														echo $em[0]->full_name.' - '.$em[0]->employee_id; 
													?>
												</td>
												<td><?php echo $row->data; ?></td>
											</tr>
										<?php } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	var employee_id = <?php echo $_SESSION['user_info']['employee_id']; ?>;
	var condition = '?employee_id='+employee_id;
	var table = $('#candidate_list').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500], //, 1000, 1500, 2000, 3000, 5000, -1
			[25, 50, 100, 500] //, 1000, 1500, 2000, 3000, 5000, "All Data"
		],
		"searching": true,
		"ordering": true,
		"scrollX": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": false,
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
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            }
        ]
    });
	table.buttons().container().appendTo($('#export_buttons_due'));
})
</script>