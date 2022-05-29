
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">TD/DA Bill List</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Accounting</a></li>
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Expence</a></li>
              <li class="breadcrumb-item active">TD/DA Bill</li>
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
						<div class="col-sm-2">
							<div class="form-group" style="margin:0px;">
								<select onchange="return filter_data_table();" class="form-control select2" id="branch_id">
									<option value="1">All Branches</option>
									<?php 
									$banches = $this->Dashboard_model->mysqlii("SELECT * FROM branches");
									if(!empty($banches)){
										foreach($banches as $row){
											echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
										}
									}													
									?>
								</select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group" style="margin:0px;">
								<select onchange="return filter_data_table();" class="form-control select2" id="department_id">
									<option value="1">All Department</option>
									<?php 
									$banches = $this->Dashboard_model->mysqlii("SELECT * FROM department");
									if(!empty($banches)){
										foreach($banches as $row){
											echo '<option value="'.$row->department_id.'">'.$row->department_name.'</option>';
										}
									}													
									?>
								</select>
							</div>
						</div>
						<div class="col-sm-2">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-prepend">
									<span class="input-group-text">
										<i class="far fa-calendar-alt"></i>
									</span>
									</div>
									<input onchange="return filter_data_table()" id="date_range" type="text" class="form-control float-right date_range">
								</div>
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card card-success">
								<div class="card-header">
									<h3 class="card-title">Refunded Member Directory</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%">
										<thead>
											<tr>
												<th>id</th>
												<th>Transaction ID</th>
												<th>Branch</th>
												<th>Department</th>
												<th>Designation</th>
												<th>Care of</th>
												<th>Amount</th>												
												<th>Date</th>
												<th>Type</th>
												<th>Transaction By</th>
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
function filter_data_table(){
	var branch_id = $("#branch_id").val();
	var date_range = $("#date_range").val();	
	var department_id = $("#department_id").val();	
    var condition = '?branch_id='+branch_id+'&date_range='+date_range+'&department_id='+department_id+'';
	var ajax_data4 = "<?=base_url(); ?>assets/ajax/data_table/accounting/expence/ta_da_bill_datatable.php"+condition;
	$('#booking_data_table').DataTable().ajax.url(ajax_data4).load();
}



$(document).ready(function() {
	var table = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/accounting/expence/ta_da_bill_datatable.php",
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
	table.buttons().container().appendTo($('#export_buttons'));
})
</script>