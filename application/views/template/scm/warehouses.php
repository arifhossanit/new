<!---- edit product sacle modal-->
<div class="modal fade" id="edit_scale">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=base_url()?>admin/scm/product-type/scale-update" method="post">
                <input type="hidden" name="scale_id" id="scale_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product Scale Name</h4>
				</div>
				<div class="modal-body" id="print_applicant_account_Details_result">
                    <div class="form-group">
                        <input class="form-control" type="text" name="product_scale" id="product_scale">
                    </div>
                    <!-- <div class="form-group">
                        <label>package Enable/Disable</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="scale_status" name="scale_status" data-bootstrap-switch data-off-color="danger" data-on-color="success" >
                    </div> -->
				</div>                
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<!----End edit product scale modal-->
<!---- edit product type modal-->
<div class="modal fade" id="edit_type">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="<?=base_url()?>admin/scm/product-type/type-update" method="post">
                <input type="hidden" name="type_id" id="type_id">
				<div class="modal-header btn-primary">
					<h4 class="modal-title">Product Types</h4>
				</div>
				<div class="modal-body" id="print_applicant_account_Details_result">
                    <div class="form-group">
                        <input class="form-control" type="text" name="product_type" id="product_type">
                    </div>
                    <!-- <div class="form-group">
                        <label>package Enable/Disable</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" id="type_status" name="type_status" data-bootstrap-switch data-off-color="danger" data-on-color="success" >
                    </div> -->
				</div>                
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm">Update</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
			</form>
		</div>
	</div>
</div>
<!----End edit product type modal-->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Warehouses</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Warehouse</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
		<div class="container-flud">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-header">
                            Add New Warehouse
                        </div>
                        <form action="<?=base_url()?>admin/scm/warehouses/insert" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <input class="form-control mb-1" type="text" name="warehouse_name" placeholder="Enter Warehouse Name">
                                    <input class="form-control mb-1" type="text" name="warehouse_address" placeholder="Enter Address">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-info">
                        <div class="card-header">
                            Supplier List
                        </div>
                        <div class="card-body">
							<table class="table table-sm text-center table-bordered table-hover" id="product_types_table">
                                <thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Address</th>
										<th>Status</th>
										<th style="width: 75px;">Option</th>
									</tr>
								</thead>
                                <tbody>
                                    <?php foreach($warehouses as $warehouse){ ?>
                                    <tr>
                                        <td><?php echo $warehouse->id;?></td>
                                        <td><?php echo $warehouse->name;?></td>
                                        <td><?php echo $warehouse->address;?></td>
                                        <td><?php echo ($warehouse->status == '1') ? '<span class="badge badge-primary">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?></td>
                                        <td>
                                            <div class="row justify-content-center" >
                                                <div class="col-sm">
                                                    <button data-target="#edit_type" data-toggle="modal" class="btn btn-info btn-xs" onclick="edit_type(this.value)" value="<?php echo $warehouse->id.'~'.$warehouse->name.'~'.$warehouse->status; ?>"><i class="far fa-edit"></i></button>
                                                </div>
                                                <div class="col-sm">
                                                    <form action="<?=base_url()?>admin/scm/manage-warehouse/delete" method="post">
                                                        <input type="hidden" name="warehouse_id" value="<?php echo $warehouse->id; ?>">
                                                        <button class="btn btn-danger btn-xs"><i class="fas fa-times"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
									<tr hidden>
                                        <th>ID</th>
										<th>Name</th>
										<th>Address</th>
										<th>Status</th>
										<th style="width: 75px;">Option</th>
									</tr>
								</tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function edit_type(info) {
    info = info.split('~');
    $('#type_id').val(info[0]);
    $('#product_type').val(info[1]);
    if(info[2] === '1'){
        $('#type_status').attr('checked', 'checked');
    }else{
        $('#type_status').attr('unchecked', 'unchecked');
    }
}
function edit_scale(info) {
    info = info.split('~');
    $('#scale_id').val(info[0]);
    $('#product_scale').val(info[1]);
    if(info[2] === '1'){
        $('#scale_status').attr('checked', 'checked');
    }else{
        $('#scale_status').attr('unchecked', 'unchecked');
    }
}
$(document).ready(function () {
    var table_booking = $('#product_scales_table').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": false,
		"info": true,
		"ScrollX": false,
    });
    var table_booking = $('#product_types_table').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": false,
		"info": true,
		"ScrollX": false,
    });
});
</script>