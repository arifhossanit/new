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
			<div class="row justify-content-between">				
				<div class="col-sm-4">
                    <div class="card card-success">
                        <form action="<?=base_url('admin/accounting/expense/expense-category')?>" method="post">
                            <div class="card-header">
                                <h4 style="float:left;">Add Expense Categries</h4>
                            </div>
                            <div class="card-body">
                                <label for="expense_type">Expense Type</label>
                                <input class="form-control" type="text" name="expense_type" id="expense_type" placeholder="Enter Expense Type" value="<?php echo (isset($_POST['expense_type']) ? $_POST['expense_type'] : '')?>" require>
                                <label class="mt-3" for="expense_sub_type">Expense Sub-Type Type <small>(Separete With 'Comma')</small></label>
                                <input class="form-control" type="text" name="expense_sub_type" id="expense_sub_type" placeholder="Enter Expense Sub-type" value="<?php echo (isset($_POST['expense_sub_type']) ? $_POST['expense_sub_type'] : '')?>">
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-sm" name="save">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
				<div class="col-sm-8">
					<div class="card card-success">
						<div class="card-header">
							<h4 style="float:left;">Expense Categries</h4>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
                            <style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
                            <table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Sub Types</th>
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
<div class="modal fade" id="add_sub_type"> <!-- oncontextmenu="return false;"-->
    <div class="modal-dialog">
        <div class="modal-content">
            <style>.form_b_class .form-control:focus{border:solid 2px #f00;}</style>
            <form action="<?=base_url('admin/accounting/expense/expense-category')?>" method="post" enctype="multipart/form-data">		
                <input type="hidden" name="expense_type_modal" id="expense_type_modal">
                <div class="modal-header btn-success">
                    <h4 class="modal-title"><i class="fas fa-check"></i> Add Sub Types </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height:780px;overflow-y:scroll;">
                    <p style="font-size: 22px;"><span class="text-secondary">Sub Type For: </span><span id="sub_type_for"></span></p>
                    <label class="mt-3" for="expense_sub_type">Expense Sub-Type Type <small>(Separete With 'Comma')</small></label>
                    <input class="form-control" type="text" name="update_sub_type" id="update_sub_type" placeholder="Enter Expense Sub-type">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="update_sub_type_button">Add Sub-Types</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function sub_type_modals(id, expense_type){
    $('#expense_type_modal').val(id);
    $('#sub_type_for').html(expense_type);
}

$(document).ready(function() {	
	var signal = '1';
	$.ajax({  
		url:"<?=base_url('assets/ajax/accounting/expense_category.php'); ?>",  
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
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/accounting/accounts/expense_category_datatable.php",
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