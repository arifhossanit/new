
<link href="https://rawgit.com/select2/select2/master/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://rawgit.com/select2/select2/master/dist/js/select2.js"></script>
<style>

</style>

<!----End edit product type modal-->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Expenses</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounts</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Expense</a></li>
						<li class="breadcrumb-item active">View Expense</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	<div class="content">
		<div class="container-flud">
            <div class="mx-5 pb-3">
                
				<!-- table 3 -->
				<div class="col-sm-12">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Transaction List by Expense</h3>
						</div>
						<div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
							<table class="table table-striped table-bordered table-sm small" id="myTable">
								<thead>
									<tr>
										<th>SL</th>
										<th>Transaction Id</th>
									    <th>Branch</th>
									    <th>Vendor</th>
									    <th>Total Amount</th>
									    <th>Due Amount</th>
									    <th>Due Date</th>
									    <th>Transit Fee</th>
									    <th>Ref</th>
									    <th>Note</th>
									    <th>Uploader</th>
									    <th>Status</th>
									    <th>Date</th>
									    <th>Action</th>
									</tr>
								</thead>
								<tbody id='tdata'>
									<?php foreach ($expense_info as $key => $exp_data) :?>
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?=$exp_data->trx_id ?></td>
                        <td><?=$exp_data->branch_name ?></td>
                        <td><?=$exp_data->company_name ?></td>
                        <td><?=$exp_data->total_amount ?></td>
                        <td><?=$exp_data->due_amount ?></td>
                        <td><?=!empty($exp_data->due_date)?date("d-m-Y", strtotime($exp_data->due_date)):''?></td>
                        <td><?=$exp_data->transit_fee ?></td>
                        <td><?=$exp_data->ref ?></td>
                        <td><?=$exp_data->note ?></td>
                        <td><?=$exp_data->created_by ?></td>
                        <td>
                        <?php 
                          if ($exp_data->status==0) {
                              echo "Pending";
                          }elseif ($exp_data->status==1) {
                              echo "Approved";
                          }elseif ($exp_data->status==2) {
                              echo "Rejected";
                          }
                        ?>
                        </td>
                        <td><?=date("d-m-Y", strtotime($exp_data->created_at)) ?></td>
                        <td class='text-center'>
                            <button class="btn btn-white p-0" data-toggle="modal" data-target="#expModal" onclick="exp_detail('<?=$exp_data->trx_id ?>')">
                                <i class="fas fa-eye text-warning"></i>
                            </button>
                        </td>
                    </tr>
                  <?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>	
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="expModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalData">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


            
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );

    function exp_detail(trxId) {
        $.ajax({
            url: "<?=current_url()?>",
            dataType: "HTML",
            type: "POST",
            async: true,
            data: {"exp_id":trxId},
            success: function (data) {
                $("#modalData").html(data);
            }
        })
    }
</script>
<script type="text/javascript" src="<?= base_url('/assets/js/accounts/ac_scripts.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('/assets/js/accounts/single_scripts.js'); ?>"></script>