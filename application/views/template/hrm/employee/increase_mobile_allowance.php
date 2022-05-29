<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Increase Mobile Allowance </h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Increase Mobile Allowance </li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">
			
			<div class="row">
                <div class="col-sm-4">
					<div class="card">
                        <form action="<?= current_url()?>" method="post">
                            <div class="card-header">
                                <h3 class="card-title">Increase Mobile Allowance </h3>
                                <div id="export_buttons" style="float: right;"></div>
                            </div>
                            <div class="card-body">
                                <label for="current_amount">Current Allowance</label>
                                <input class="form-control mb-3" type="number" name="current_amount" id="current_amount" value="<?= $current_amount->mobile_allowance ?>" readonly>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="current_amount">Increase Amount</label>
                                        <input class="form-control" type="number" name="request_amount" id="request_amount" placeholder="Increase Amount" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="current_amount">Total Amount</label>
                                        <input class="form-control" type="number" name="total_amount" id="total_amount" value="<?= $current_amount->mobile_allowance ?>" readonly>
                                    </div>
                                </div>
                                <textarea class="form-control mt-3" name="note" id="note" cols="30" rows="3" placeholder="Note" required></textarea>
                                <p class="mt-3 font-weight-bold text-info">N.B. : Increased mobile allowence will be effective form next month.</p>
                            </div>
                            <div class="card-footer">
                                <button name="submit" class="btn btn-info">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
				<div class="col-sm-8">				
					<div class="card card-danger">
						<div class="card-header">
							<h3 class="card-title">All requests </h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<style>.employee .form-group{margin-right:10px;}</style>
						<div class="card-body" style="overflow-x:scroll;">						
							<style>#employee_data_table td{text-align:center;vertical-align: middle;}#employee_data_table th{text-align:center;vertical-align: middle;}</style>
							<table id="example2" class="display table table-sm table-bordered table table-striped" style="width:100%;white-space: nowrap;">
							   <thead>
								  <tr>
									 <th>Id</th>
									 <th>Requested Amount</th>
									 <th>Approved Amount</th>
									 <th>Requested At</th>
									 <th>Note</th>
									 <th>Status</th>
									 <th>Option</th>
								  </tr>
							   </thead>
							   <tbody>
                                <?php foreach($mobile_allowances as $mobile_allowance){ ?>
                                    <tr>
                                        <td><?= $mobile_allowance->id; ?></td>
                                        <td><?= money($mobile_allowance->requested_amount); ?></td>
                                        <td><?= money($mobile_allowance->approved_amount); ?></td>
                                        <td><?= $mobile_allowance->creation_date; ?></td>
                                        <td><?= $mobile_allowance->note; ?></td>
                                        <td>
                                            <?php 
                                                switch($mobile_allowance->status){
                                                    case 0:
                                                        echo '<badge class="badge badge-warning">Pendign DH</badge>';
                                                        break;
                                                    case 1:
                                                        echo '<badge class="badge badge-info">Pendign Boss</badge>';
                                                        break;
                                                    case 2:
                                                        echo '<badge class="badge badge-danger">Rejected DH</badge>';
                                                        break;
                                                    case 3:
                                                        echo '<badge class="badge badge-success">Approved</badge>';
                                                        break;
                                                    case 4:
                                                        echo '<badge class="badge badge-danger">Rejected Boss</badge>';
                                                        break;
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($mobile_allowance->status == '0' OR $mobile_allowance->status == '1'){ ?>
                                                <form action="<?= current_url()?>" method="post">
                                                    <input type="hidden" name="remove_id" value="<?= $mobile_allowance->id ?>">
                                                    <button name="remove_request" class="btn btn-danger btn-xs" onclick="return confirm('Do you really want to remove this request?')"><i class="far fa-times-circle"></i> Remove</button>
                                                </form>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
							   </tbody>
							</table>					
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $('#request_amount').on('keyup keydown', (e) => {
        $('#total_amount').val(Number($('#request_amount').val()) + Number($('#current_amount').val()));
    });
</script>