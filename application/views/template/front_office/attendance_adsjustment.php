<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Attendance Adjustment</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Profile</a></li>
						<li class="breadcrumb-item active">Attendance Adjustment</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Attendance Adjustment</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="employee_id" value="<?php echo $_SESSION['super_admin']['employee_ids']; ?>"/>
							
							<div class="row" id='UnitBoxesGroup'>
								<div id="UnitBoxDiv1" class="row" style="width:100%;">							
									<div class="col-sm-6">
										<label>Select Date</label>
										<input type="date" name="adj_date[]" class="form-control" required />
									</div>
									<div class="col-sm-6">
										<label>Select Reason</label>
										<select name="adj_reason[]" class="form-control" required>
											<option value="">--select--</option>
											<?php 
											$reasons = $this->Dashboard_model->mysqlii("select * from fingure_missing_reason where status = '1'");
											foreach($reasons as $row){
											?>
											<option value="<?php echo $row->reason_name; ?>"><?php echo $row->reason_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12" style="margin-top: 12px;">
									<div class="row d-flex" style="float:right;padding-right: 16px;">										
										<button type="button" id='removeButton' class="btn btn-danger btn-xs" style="margin-right: 2px;padding-left: 5px;border-radius: 5px;"><i class="fas fa-minus-square"></i></button>
										<button type="button" id='addButton' class="btn btn-success btn-xs" style="border-radius:5px;padding-left: 5px;"><i class="fas fa-plus-square"></i></button>
									</div>
								</div>
							</div> 
							<div class="row">
								<div class="col-sm-12">
									<label>Note</label>
									<textarea name="note" placeholder="Note" class="form-control" required></textarea>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12" style="margin-top: 12px;">
									<button type="submit" name="submit" class="btn btn-success" style="float:right;">Apply</button>
								</div>
							</div>							
						</form>
					</div>
				</div>
			</div>
			
			
			<div class="col-sm-8">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Attendance Adjustment</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="employee_id" value="<?php echo $_SESSION['super_admin']['employee_id']; ?>"/>
							<div class="row">								
								<div class="col-sm-12">
									
								</div>
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
												<th>ID</th>
												<th>Number Of Days</th>
												<th>HR Checked</th>
												<th>Boss:Aproval</th>
												<th>Uploader</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										
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
	var counter = 2;
    $("#addButton").click(function () {
		if( counter == 100 ){
			alert("Sorry! Maximum number of field reached");
			return false;			
		}
		var newTextBoxDiv = $(document.createElement('div')).attr({
			id:'UnitBoxDiv1' + counter ,
			class: 'row',
			style: 'width:100%'
		});		
		var data = '<div class="col-sm-6">';
			data += '<label>Select Date</label>';
			data += '<input type="date" name="adj_date[]" class="form-control" required />';
			data += '</div>';
			data += '<div class="col-sm-6">';
			data += '<label>Select Reason</label>';
			data += '<select name="adj_reason[]" class="form-control" required>';
			data += '<option value="">--select--</option><?php $reasons = $this->Dashboard_model->mysqlii("select * from fingure_missing_reason where status = '1'"); foreach($reasons as $row){ ?> <option value="<?php echo $row->reason_name; ?>"><?php echo $row->reason_name; ?></option> <?php } ?>';
			data += '</select>';
			data += '</div>';
		newTextBoxDiv.after().html(data);
		newTextBoxDiv.appendTo("#UnitBoxesGroup");
		counter++;
    });
    $("#removeButton").click(function () {
		if( counter == 2 ){
			alert("Sorry! The System Can Not Remove This field");
			return false;
		}
		counter--;
        $("#UnitBoxDiv1" + counter).remove();
    });

	
	
	
	
	
	
	
	
	
	
	
	
	var employee_id = <?php echo $_SESSION['super_admin']['employee_ids']; ?>;
	var condition = '?employee_id='+employee_id;
	var table = $('#candidate_list').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[25, 50, 100, 500],
			[25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"scrollX": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
		"ajax": "<?=base_url(); ?>assets/ajax/data_table/hrm/pay_roll/employee_missing_attendance_request_datatable.php"+condition,
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