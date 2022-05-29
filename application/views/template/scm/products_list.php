<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Product Lists</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Products List</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
        <div class="row justify-content-center p-1">
			<div class="card" style="width: 95%;">
				<div class="card-body">
					<!-- <div class="col-md-12"><div id="export_buttons" style="float: right;"></div></div> -->
					<div class="col-md-12">
						<table id="product_list_datatable" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
							<thead>
								<tr>
									<th style="width: 10px;">id</th>
									<th style="width: 100px;">Image</th>
									<th>Name</th>
									<th>Brand</th>												
									<th>Category</th>
									<th>Type</th>
									<th>Departments</th>
									<th>Scale</th>
									<th>Option</th>
								</tr>
							</thead>
							<tbody>	
							</tbody>
							<tfoot>	
								<tr hidden>
									<th style="width: 10px;">id</th>
									<th style="width: 100px;">Image</th>
									<th>Name</th>
									<th>Brand</th>												
									<th>Category</th>
									<th>Type</th>
									<th>Departments</th>
									<th>Scale</th>
									<th>Option</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<!---- Show Product History -->
<div class="modal fade" id="edit_product">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="" id="update_product_form" method="post" enctype="multipart/form-data">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Edit Product</h4>
				</div>
				<div class="modal-body" id="edit_product_body">
					<div class="row justify-content-center">
						<div class="col-md-10">
							<input type="hidden" id="edit_update_id" name="edit_update_id">
							<div class="form-group">
								<label for="edit_product_name">Product Name</label>
								<input type="text" class="form-control" value="" id="edit_product_name" name="edit_product_name">
							</div>
							<div class="form-group">
								<input type="file" class="form-control-file" id="update_product_image" name="update_product_image">
							</div>
						</div>
					</div>
				</div>                
                <div class="modal-footer">
					<button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<script>
$('#update_product_form').on('submit', () => {
	event.preventDefault();
	var form = $('#update_product_form')[0];
	var data = new FormData(form);			
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?=base_url('admin/scm/update-product-name-image');?>",  
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');	
			let info = JSON.parse(data);	
			if(!info.error){
				$('#update_product_form').trigger("reset");
				$('#edit_product').modal('toggle');
				$('#product_list_datatable').DataTable().ajax.reload( null , false);
			}	
		}
	});
});

let edit_product = (id, name) => {
	$('#edit_product_name').val(name);
	$('#edit_update_id').val(id);
	$('#edit_product').modal('toggle');
}

$(document).ready(function () {
	var table_booking = $('#product_list_datatable').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		//"info": true,
		//"autoWidth": true,
		//"responsive": true,
		"ScrollX": true,
        "serverSide": true,
		"processing": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/product_list_datatable.php",
		initComplete: function(){
            var api = this.api();
            api.columns().every(function(){
                var that = this;
                $('input', this.footer()).on('keyup change', function(){
                    if (that.search() !== this.value){
                        that.search(this.value).draw();
                    }
                });
            });
        },
		// dom: 'lBfrtip',
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
	// table_booking.buttons().container().appendTo($('#export_buttons'));
});
</script>