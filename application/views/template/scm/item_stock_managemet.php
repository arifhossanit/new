<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Refreshment Items Stock List</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active">Products List</li>
					</ol>
                    <?php if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['user_info']['department'] == '1596237883895240682'){ //Supply Chain Department  ?>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg">Create Refreshment Stock</button>
                    <?php } ?>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
        <div class="row justify-content-center p-1">
			<div class="card" style="width: 95%;">
				<div class="card-body">
					<div class="col-md-12">
                        <form id="YearMonthForm" name="YearMonthForm" action="<?php print current_url()?>" method="GET" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-2 mb-3" style="float: left;">
                                    <input name="date_range" id="date_range_tmp" type="text" class="form-control float-right date_range_tmp">
                                </div>
                                <div class="col-md-2 mb-3 form-group" style="float: right;">
                                    <select class="form-control" name="branch" id="branch" onchange="setBranchItemDisplayBlockFilter()">
                                        <?php if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['super_admin']['role_id'] == '1622657840330042228' OR $_SESSION['super_admin']['role_id'] == '981787227107114796'){ ?>
                                            <option value="">All Branches</option>
                                        <?php } ?>
                                        <?php if(!empty($branches)){ foreach($branches as $row){ ?>
                                            <?php if($branch_name === $row->branch_id) { ?>
                                                <option value="<?=$row->branch_id?>" selected><?php print $row->branch_name; ?></option>
                                            <?php }else{ ?>
                                                <option value="<?=$row->branch_id?>"><?php print $row->branch_name; ?></option>
                                            <?php } ?>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3 form-group" style="float: right;">
                                    <select class="form-control" name="item_name" id="item_name">
                                        <option value="">All Items</option>
                                        <?php foreach($products as $item){ ?>
                                            <?php if($_GET['item_name'] === $item->item_name) { ?>
                                                <option class="classToHide_filter <?=$item->branch_id?>" selected><?= $item->item_name ?></option>
                                            <?php }else{ ?>
                                                <option class="classToHide_filter <?=$item->branch_id?>" ><?= $item->item_name ?></option>
                                            <?php } ?>
                                        <?php }  ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-2 mb-3 form-group" style="float: right;">
                                    <button type="button" class="btn btn-info btn-sm" onclick="filterData()">Apply</button>
                                </div>
                            </div>
                        </form>
						<table id="product_list_datatable" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
							<thead>
								<tr>
									<th>id</th>
                                    <th>Branch</th>
                                    <th>Product Name</th>
                                    <th>Initial Quantity</th>
                                    <th>Remaining</th>
                                    <th>Created</th>
								</tr>
							</thead>
							<tbody>	
							</tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" style="text-align:right"></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th colspan="4" style="text-align:right"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
						</table>
					</div>
				</div>
			</div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 style="text-align: center;background-color:beige;padding:20px;font-weight:800;">
                        Add New Refreshment Stock
                    </h4>
                    <form id="refreshment_item_add_form"  action="<?=current_url()?>" method="POST">
                        <div class="row" style="padding: 20px !important;">
                            <div class="form-group col-md-12" id="main-div">
                                <label for="recipient-name" class="col-form-label">Branch:</label>
                                <select type="text" class="form-control" id="branch_name" name="branch_name" onchange="setBranchItemDisplayBlock()" required>
                                    <option value="">Select a Branch</option>
                                    <?php foreach($branches as $row){ ?>
                                    <option class="form-control" value="<?=$row->branch_id?>" >
                                        <?=$row->branch_name?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="recipient-name" class="col-form-label">Product:</label>
                                <select type="text" class="form-control" id="refreshment_product_name" name="refreshment_product_name" required>
                                    <option value="">Select a Product</option>
                                    <?php foreach($products as $row){ ?>
                                    <option class="form-control classToHide <?=$row->branch_id?>" value="<?=$row->item_name?>" style="display: none;">
                                        <?=$row->item_name?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="recipient-name" class="col-form-label">Quantity:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="form-group col-md-12">
                                <center>
                                    <button type="submit" class="btn btn-info" style="margin-top: 30px;padding:10px;font-size:large;font-weight:800;min-width:200px;">Submit</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
$(document).ready(function () {
    var getdateRange = document.getElementById('date_range_tmp').value;
    var getBranchName = document.getElementById('branch').value;
    console.log(getdateRange);
    console.log(getBranchName);
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
        "serverSide": false,
		"processing": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/scm/stock_item_datatable.php?branch=" + getBranchName + '&date='+getdateRange,

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Update footer
            $( api.column( 4 ).footer() ).html(
                'This Page: '+pageTotal +' (All Pages: '+ total +')'
            );


             // Remove the formatting to get integer data for summation
             var intVal2 = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            // Total over all pages
            total2 = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Total over this page
            pageTotal2 = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            // Update footer
            $( api.column( 3 ).footer() ).html(
               'This Page: ' +pageTotal2 +' (All Pages: '+ total2 +')'
            );
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

function setBranchItemDisplayBlock(){
    var getClassName = document.getElementById('branch_name').value;
    var lengthToHide = document.querySelectorAll('.classToHide').length;
    var lengthToShowList = document.querySelectorAll('.'+getClassName).length;
    document.getElementById('refreshment_product_name').value = '';
    
    for(var i = 0; i < lengthToHide; i ++) {
        document.getElementsByClassName('classToHide')[i].style.display = 'none';
    }

    for(var j = 0; j < lengthToShowList; j ++) {
        document.getElementsByClassName(getClassName)[j].style.display = 'block';
    }
}

function setBranchItemDisplayBlockFilter(){
    var getClassName = document.getElementById('branch').value;
    var lengthToHide = document.querySelectorAll('.classToHide_filter').length;

    if(getClassName.length != 0){
        var lengthToShowList = document.querySelectorAll('.'+getClassName).length;
        document.getElementById('item_name').value = '';
        
        for(var i = 0; i < lengthToHide; i ++) {
            document.getElementsByClassName('classToHide_filter')[i].style.display = 'none';
        }

        for(var j = 0; j < lengthToShowList; j ++) {
            document.getElementsByClassName(getClassName)[j].style.display = 'block';
        }
    }else{
        for(var i = 0; i < lengthToHide; i ++) {
            document.getElementsByClassName('classToHide_filter')[i].style.display = 'block';
        }
    }
    
}


function filterData(){

    var getdateRange = document.getElementById('date_range_tmp').value;
    var getBranchName = document.getElementById('branch').value;
    var getItemName = document.getElementById('item_name').value;
    var parameter = 'date='+getdateRange+'&branch='+getBranchName+'&item='+getItemName;

    var ajax_data = "<?=base_url(); ?>assets/ajax/data_table/scm/stock_item_datatable.php?"+parameter;
    console.log(ajax_data);
	$('#product_list_datatable').DataTable().ajax.url(ajax_data).load();
    
    
}
</script>
