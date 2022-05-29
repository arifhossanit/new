<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta http-equiv="content-type" content="text-html; charset=utf-8">
<style>

</style>
<div class="card bg-light transaction-body">
	<div class="card-body transaction-receipt">
		<div class="col-sm-12" style="margin-bottom:30px;">
			<button type="button" id="print_button_new" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
		</div>
		<div style="width:100%;margin-top:30px;float:left;"></div>
		<section id="print_area_new">
			<header class="clearfix" style="margin-bottom:15px;">
				<div class="">
					<figure>
						<img class="logo" src="<?php echo base_url(); ?>assets/img/neways.png" alt="" style="width:180px;">
					</figure>
					<div class="company-address">
						<h1 class="title" style="color:rgba(3, 169, 244, 0.6);margin-bottom:0px;"></h1>
					</div>
					<div  style="height:70px;float: right" class="p-0 mt-0">
						<strong>NEWAYS INTERNATIONAL COMPANY LIMITED</strong>
						<p>Corporate Office: House No. # 2/KA/10,<br> Mymensingh Road, Shahbag, Dhaka-1000</p>
					</div>
					<div class="mt-4" style="width:60%;float:left;font-size: 18px;">
						<div style="display: grid;">
							<div style="grid-column-start: auto">
								Trx ID: <?= $exp_info->trx_id ?>
							</div>
							<div style="grid-column-start: auto">
								Ref#: <?= $exp_info->ref ?>
							</div>
							<div style="grid-column-start: auto">
								Bill Date: <?= !empty($exp_info->bill_date) ?date("d-m-Y",strtotime($exp_info->bill_date)):'' ?>
							</div>
							<div style="grid-column-start: auto">
								Vendor: <?= $exp_info->company_name ?>
							</div>
							<div style="grid-column-start: auto">
								Employee Name: <?= $exp_info->emp_name ?>
							</div>
							<div style="grid-column-start: auto">
								Employee ID & Designation: <?= $exp_info->created_by ?>
							</div>
							<div style="grid-column-start: auto">
								Branch: <b style="color: blue;"><?= $exp_info->branch_name ?></b></p>
							</div>
						</div>
					</div>
					<div class="mt-2 text-align-start" style="width:29%;float:right;font-size: 14px;">
						<div style="grid-column-start: auto">
							<?=$exp_info->transit_fee? 'Transit Fee: '.$exp_info->transit_fee.' Tk |':'' ?>  
							<?=$exp_info->fixed_discount? 'Discount: '.$exp_info->fixed_discount.' Tk':'' ?>  <br>
							<?=$exp_info->fixed_tax? 'Tax: '.$exp_info->fixed_tax.' Tk':'' ?>
						</div>
						<div style="grid-column-start: auto">
							Total: <?= $exp_info->total_amount ?> Tk | Grand-total: <?= $exp_info->grand_amount ?> Tk
						</div>
						<div style="grid-column-start: auto">
							Due: <?= $exp_info->due_amount ?> Tk | <?= $exp_info->due_date !='0000-00-00 00:00:00'?'Due Date: '.date("Y-m-d",strtotime($exp_info->due_date)):'' ?>
						</div>
					</div>
					<div style="width:100%;float:left;">
						<center>
							<h1 style="font-size:2.5em;font-weight:600;margin: 0.2em 0;"><u>Expense Invoice</u></h1>
						</center>
					</div>
				</div>
			</header>

			<section class="footer-class" style="">
				<div class="">
					<div class="details clearfix"></div>
					<table class="table">
						<thead class="thead-dark">
							<tr>
								<th scope="col">#</th>
								<th scope="col">Item Name</th>
								<th scope="col">Cost center</th>
								<th scope="col">Unit Price</th>
								<th scope="col">Unit Type</th>
								<th scope="col">Qty</th>
								<th scope="col">Sub Total</th>
								<th scope="col">Discount</th>
								<th scope="col">Tax</th>
								<th scope="col">Net Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if (!empty($items_info)) {
								foreach ($items_info as $key => $item) {
									$pid=$item->item_id;
							?>
							<tr class="table-active">
								<th scope="row"><?=$key+1?></th>
								<td><?=$item->item_name?></td>
								<td></td>
								<td><?=$item->unit_price?></td>
								<td><?=$item->unit_name?></td>
								<td><?=$item->qty?></td>
								<td><?=$item->sub_total?></td>
								<td><?=$item->discount_amount?></td>
								<td><?=$item->tax_amount?></td>
								<td><?=$item->net_amount?></td>
							</tr>
							<?php
									foreach ($branch_items as $key => $branch_item) {
										if ($pid==$branch_item->purchese_item_id) {
							?>
											<tr>
												<th scope="row"></th>
												<td></td>
												<td><?=$branch_item->br_name?></td>
												<td><?=$branch_item->unit_price?></td>
												<td><?=$branch_item->unit_name?></td>
												<td><?=$branch_item->qty?></td>
												<td><?=$branch_item->sub_total?></td>
												<td><?=$branch_item->discount_amount?></td>
												<td><?=$branch_item->tax_amount?></td>
												<td><?=$branch_item->net_amount?></td>
											</tr>
							<?php
										}
									}

								}
							}
							?>
						</tbody>
					</table>
				</div>
				<div class="m-5 pt-5">
					<div class="row justify-content-between signature">
						<div class="col-print-3">
							<div class="row">
								<div class="col-print-12"> <hr> </div>
								<div class="col-print-12">
									Employee Signature
								</div>
							</div>
						</div>
						<div class="col-print-3">
							<div class="row">
									<div class="col-print-12"> <hr> </div>
									<div class="col-print-12">
										Checked by Accounts
									</div>
							</div>
						</div>
						<div class="col-print-3">
							<div class="row">
									<div class="col-print-12"> <hr> </div>
									<div class="col-print-12">
										Authorized Signature
									</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<footer>
				<div class="">
					<div class="thanks">Thank you!</div>
					<div class="end-new">
						<div> <!-- redundent div for printing -->
							<div>
								<div style="padding-bottom:100px;">
									<div class="employee_information text-center">
										<div class="col-sm invoice-disclaimer-border">
											<p>Invoice was created on a computer and is valid without the signature and seal.</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>

		
		</section>
	</div>
</div>
<script>
	$('#print_button_new').click(function(){
		jQuery('#print_area_new').print({
			globalStyles : true,
			mediaPrint : false,
			stylesheet : "https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext",
			noPrintSelector : '.no-print',
			iframe : true,
			append : null,
			prepend : null,
			manuallyCopyFormValues : true,
			deferred : jQuery.Deferred(),
			timeout : 750,
			title : null,
			doctype : '<!doctype html>'
		});
	})
</script>
