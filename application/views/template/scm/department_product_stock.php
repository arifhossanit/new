<style>
	.product-image{
		width: 80px;
		border-radius: 5px;
		transition: 80ms;
	}
	.product-image:hover{
		transform: scale(2);
	}
</style>

<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Department Product Stock</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Requisitions</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
		<div class="container-flud">
            <div class="row justify-content-center" style="width: 100%;">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-primary">Department Product Stock</div>
                        <div class="card-body">
                            <table class="table table-bordered" id="product_stock">
                                <thead>
                                    <tr>
                                        <td style="width: 8%;">Image</td>
                                        <td style="width: 18%;">Name</td>
                                        <td>Receive Date</td>
                                        <td style="width: 18%;">Branch</td>
                                        <td style="width: 10%;">Amount</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>                    
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
var purchase_order = $('#product_stock').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "order": [[ 2, "asc" ]],
    "info": true,
    "ScrollX": true,
    "processing": true,
    "serverSide": true,
    "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/department_product_stock_datatable.php",
    columnDefs: [
        { targets: [ 2 ], visible: false},
    ]
});
$.ajax({
    type: 'post',
    url: "<?=base_url()?>assets/ajax/scm/add_to_department_transfer_cart.php",
    success: function (data) {
        let info = JSON.parse(data);
        $('#product_cart_div').html(info.html);
        product_cart = $('#product_cart').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "order": [[ 0, "desc" ]],
            "info": true,
            "ScrollX": true
        });
    }
});
});
</script>