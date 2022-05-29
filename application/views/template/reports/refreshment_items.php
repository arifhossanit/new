<style type="stylesheet">
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Refreshment Items</h1>
				</div> 
			</div> 
		</div> 
    </div>	
	<div class="content">
		<div class="container-fluid">	
			<div class="row">		
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<form id="YearMonthForm" name="YearMonthForm" action="<?php print current_url()?>" method="GET" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-2 mb-3" style="float: left;">
								<input name="date_range" id="date_range_tmp" type="text" class="form-control float-right date_range_tmp">
							</div>
							<div class="col-md-2 mb-3 form-group" style="float: right;">
								<select class="form-control" name="branch" id="branch">
									<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['super_admin']['role_id'] == '1622657840330042228'){ ?>
										<option value="">All Branches</option>
									<?php } ?>
									<?php if(!empty($branches)){ foreach($branches as $row){ ?>
										<?php if($branch_name === $row->branch_id) { ?>
											<option value="<?php print $row->branch_id; ?>" selected><?php print $row->branch_name; ?></option>
										<?php }else{ ?>
											<option value="<?php print $row->branch_id; ?>"><?php print $row->branch_name; ?></option>
										<?php } ?>
									<?php } } ?>
								</select>
							</div>
							<div class="col-md-2 mb-3 form-group" style="float: right;">
								<select class="form-control" name="item_name" id="item_name">
									<option value="">All Items</option>
									<?php foreach($items as $item){ ?>
										<?php if($_GET['item_name'] === $item->item_name) { ?>
											<option selected><?= $item->item_name ?></option>
										<?php }else{ ?>
											<option><?= $item->item_name ?></option>
										<?php } ?>
									<?php }  ?>
								</select>
							</div>
							
							<div class="col-md-2 mb-3 form-group" style="float: right;">
								<button class="btn btn-info btn-sm">Apply</button>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-sm-12">
							<div class="card card-success">
								<div class="card-header">
                                Refreshment Items Report
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="example3">
										<thead>
											<tr>
												<th style="width:15vw;" class="sticky-header">Branch Name</th>
                                                <th style="width:15vw;" class="sticky-header">Item Name</th>
												<th style="width:60px;" class="sticky-header">Quantity</th>
												<th style="width:100px;" class="sticky-header">Amount</th>
                                                <th style="width:100px;" class="sticky-header">Payment Status</th>
                                                <th style="width:100px;" class="sticky-header">Date</th>
											</tr>
										</thead>
										<tbody style="height:300px !important;overflow-x:scroll;">
										<?php if(!empty($a)){ foreach($a as $LoopRow){?>
											<tr>
												<td><?php print $LoopRow->branch_name; ?></td>
                                                <td><?php print $LoopRow->product_name; ?></td>
												<td><?php print $LoopRow->total_qty; ?></td>
                                                <td><?php print $LoopRow->total_amount ; ?></td>
                                                <td><?php print $LoopRow->payment_status; ?></td>
												<td><?php $date = DateTime::createFromFormat('d/m/Y',$LoopRow->data); print $date->format('d F, Y'); ?></td>
											</tr>
											<?php }
										} ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<script>
	$('#example3').DataTable();
    function filter(){
        document.getElementById('YearMonthForm').submit();
        // return false;
    }
	let test = () => {
		console.log('test');
	}
</script>