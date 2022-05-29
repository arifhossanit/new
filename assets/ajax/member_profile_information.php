<?php 
include("../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['profile_id']."'"));
$email = explode("___",$row['uploader_info']);
$member = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$email[1]."'"));
$booking_info = mysqli_fetch_assoc($mysqli->query("select * From booking_info where booking_id = '".$row['booking_id']."'"));


//get withdraw_checkout s non returned items
$non_returned = mysqli_fetch_assoc($mysqli->query("select checkout_iteams, data_two from withdraw_checkout where  booking_id = '".$row['booking_id']."'"));

if(!empty($non_returned)){
	$non_returnd = $non_returned['checkout_iteams'];
	$non_returnd_items_sql = $mysqli->query("select * from checkout_iteam where id  in($non_returnd)");
}


if(!empty($non_returned)){
	$returnd = $non_returned['data_two'];
	if(!empty($returnd)){ 
		$returnd_items_sql = $mysqli->query("select * from checkout_iteam where id  in($returnd)");
	}
	
}
//print_r($returnd_items_sql); exit();





?>
<style>
.custom-color a{
	color:#333 !important;
}
</style>
<div class="row">
	<div class="col-sm-12" style="min-height:780px;">
		<div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title"><b>Profile Information</b></h3></li>
				  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Account Information</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Rental Information</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-refreshment-tab" data-toggle="pill" href="#custom-tabs-one-refreshment" role="tab" aria-controls="custom-tabs-one-refreshment" aria-selected="false">Purchase Item</a>
                  </li>				  
				  <li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Other </a>
						<div class="custom-color dropdown-menu" aria-labelledby="navbarDropdown" style="left: 0px; right: inherit;width: 200px;">
							<a class="nav-link" id="custom-tabs-package_shifting-tab" data-toggle="pill" href="#custom-tabs-package_shifting" role="tab" aria-controls="custom-tabs-package_shifting" aria-selected="false">Package Shifting</a>
							<a class="nav-link" id="custom-tabs-bed_change-tab" data-toggle="pill" href="#custom-tabs-bed_change" role="tab" aria-controls="custom-tabs-bed_change" aria-selected="false">Bed Change</a>
							<a class="nav-link" id="custom-tabs-transaction-tab" data-toggle="pill" href="#custom-tabs-transaction" role="tab" aria-controls="custom-tabs-transaction" aria-selected="false">Transaction</a>
							<a class="nav-link" id="custom-tabs-transaction-tab" data-toggle="pill" href="#custom-tabs-all-transaction" role="tab" aria-controls="custom-tabs-transaction" aria-selected="false">All Collection</a>
							<a class="nav-link" id="custom-tabs-dining-tab" data-toggle="pill" href="#custom-tabs-dining" role="tab" aria-controls="custom-tabs-dining" aria-selected="false">Dining</a>
							
							<a class="nav-link" id="custom-tabs-checkout-tab" data-toggle="pill" href="#custom-tabs-checkout" role="tab" aria-controls="custom-tabs-checkout" aria-selected="false">Checkout Items</a>
							
						</div>
				  </li>
				  <?php if(!empty($_SESSION['super_admin']) and $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
				  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-member-cancelation-tab" data-toggle="pill" href="#custom-tabs-member-cancelation" role="tab" aria-controls="custom-tabs-member-cancelation" aria-selected="false">Member Cancelation</a>
                  </li>
				  <?php } ?>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                     <div class="row">
						<div class="col-sm-3">
							<img src="<?php echo $home.$row['photo_avater']; ?>" style="width:200px;height:210px;" class="image-responsive"/>
						</div>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-8">
									<h1><?php echo $row['full_name']; ?></h1>
									<p style="margin:0px;">Phone: <?php echo $row['phone_number']; ?></p>
									<p style="margin:0px;">Address: <?php echo $row['address']; ?></p>
								</div>
								<div class="col-sm-4" style="color:#f00;">
									<?php
										$check_cancel = mysqli_fetch_assoc($mysqli->query("select * from cencel_request where booking_id = '".$row['booking_id']."' order by id desc"));
										if(!empty($check_cancel['id'])){
											echo '<span>Cancel Date:: <b>'.$check_cancel['data'].'</b><span><br />';
											if($check_cancel['note'] == 'Request For Cancel for rental payment issue (auto cancel from software)'){
												$auto_cancel = 'YES';
											}else{
												$auto_cancel = 'NO';
											}
											echo '<span>Auto Cancel:: <b>'.$auto_cancel.'</b><span>';
										}
										$check_checkOut = mysqli_fetch_assoc($mysqli->query("select * from withdraw_checkout where booking_id = '".$row['booking_id']."' order by id desc"));
										if(!empty($check_checkOut['id'])){
											echo '<hr style="margin:0px;"/><span>CheckOut Times:: <br /><b>'.$check_checkOut['checkoutdate'].'</b><span><br />';
										}
									?>
								</div>
							</div>
							
						</div>
					 </div>
					 <div>
						<div class="col-sm-12" style="margin-top:50px;">
							<div class="row">
								<div class="col-sm-4">
									<h3>Personal Information</h3>
								</div>
								<div class="col-sm-8">
									<button onclick="return view_profile_from_booking(<?php echo $booking_info['id']; ?>)" type="button" class="btn btn-success" style="float:right;"><i class="fas fa-eye"></i> &nbsp; View Booking Receipt</button>
								</div>
							</div>							
							<table style="width:100%;">
								<tr>
									<td><b>Name</b></td>
									<td>:</td>
									<td><?php echo $row['full_name']; ?></td>
								</tr>
								<tr>
									<td><b>Email</b></td>
									<td>:</td>
									<td><?php echo $row['email']; ?></td>
								</tr>
								<tr>
									<td><b>Phone</b></td>
									<td>:</td>
									<td><?php echo $row['phone_number']; ?></td>
								</tr>
								<tr>
									<td><b>Occupation</b></td>
									<td>:</td>
									<td><?php echo $row['occupation']; ?></td>
								</tr>
								<tr>
									<td><b>Religion</b></td>
									<td>:</td>
									<td><?php echo $row['religion']; ?></td>
								</tr>
								<tr>
									<td><b>Father name</b></td>
									<td>:</td>
									<td><?php echo $row['father_name']; ?></td>
								</tr>
								<tr>
									<td><b>NID</b></td>
									<td>:</td>
									<td><?php echo $row['mother_name']; ?></td>
								</tr>
								<tr>
									<td><b>Emergency Name</b></td>
									<td>:</td>
									<td><?php echo $row['emergency_number_1']; ?></td>
								</tr>
								<tr>
									<td><b>Emergency Number</b></td>
									<td>:</td>
									<td><?php echo $row['emergency_number_2']; ?> </td>
								</tr>
							</table>
						</div>

						<div class="col-sm-12" style="margin-top:50px;">
							<h3>Document Information</h3>
							<table style="width:100%;">
								<thead>
									<tr>
										<th></th>
										<!--<th>Document Number</th>-->
										<th></th>
										<th>Document Type</th>
										<th></th>
										<th>Uploaded File</th>
									</tr>
								</thead>
							<?php
							$document = explode(",",$row['document_upload']);
							$nmb = count($document) - 1;
							$i = 1;
							$j = 0;
							$doc_typ = explode(",",$row['document_type']);
							$doc_up = explode(",",$row['document_upload']);
							foreach ($document as $roy){
								$r = $i++;
								$p = $j++;
							?>
								<tr>
									<td><b>Document #<?php echo $r;?>:</b></td>
									<td><?php //echo $roy; ?></td>
									<td>:</td>
									<td><?php echo $doc_typ[$p]; ?></td>
									<td>:</td>
									<td><a href="<?php echo $home.$doc_up[$p]; ?>" title="<?php echo $home.$doc_up[$p]; ?>" target="_blank"><i class="fas fa-external-link-alt"></i> View File</a></td>
								</tr>
							<?php if($r == $nmb){ break; }} ?>	
							</table>
						</div>
						
						<div class="col-sm-12" style="margin-top:50px;">
							<h3>Booking Information</h3>
							<table style="width:100%;">
								<tr>
									<td><b>Branch</b></td>
									<td>:</td>
									<td><?php echo $row['branch_name']; ?></td>
								</tr>
								<tr>
									<td><b>Floor</b></td>
									<td>:</td>
									<td><?php echo $row['floor_name']; ?></td>
								</tr>
								<tr>
									<td><b>Unit</b></td>
									<td>:</td>
									<td><?php echo $row['unit_name']; ?></td>
								</tr>
								<tr>
									<td><b>Room</b></td>
									<td>:</td>
									<td><?php echo $row['room_name']; ?></td>
								</tr>
								<tr>
									<td><b>Bed Type</b></td>
									<td>:</td>
									<td><?php echo $row['bet_type']; ?></td>
								</tr>
								<tr>
									<td><b>Bed</b></td>
									<td>:</td>
									<td><?php echo $row['bed_name']; ?></td>
								</tr>
								<tr>
									<td><b>Booking Date</b></td>
									<td>:</td>
									<td><?php echo $row['booking_date']; ?></td>
								</tr>
								<tr>
									<td><b>CheckIn Date</b></td>
									<td>:</td>
									<td><?php echo $row['check_in_date']; ?></td>
								</tr>
								<tr>
									<td><b>CheckOut Date</b></td>
									<td>:</td>
									<td><?php echo $row['check_out_date']; ?></td>
								</tr>
								<tr>
									<td><b>Card Number</b></td>
									<td>:</td>
									<td><?php echo $row['card_number']; ?></td>
								</tr>
								<tr>
									<td><b>Package</b></td>
									<td>:</td>
									<td><?php echo $row['package_name']; ?></td>
								</tr>
								<tr>
									<td><b>Security Deposit</b></td>
									<td>:</td>
									<td style="font-weight:bolder;color:#f00;"><?php echo money($row['security_deposit']); ?></td>
								</tr>
								<tr>
									<td><b>Parking</b></td>
									<td>:</td>
									<td><?php if($row['parking'] == 1){ echo '<span style="color:red;font-weight:bolder;">YES</span>'; } else { echo 'NO'; } ?></td>
								</tr>
								<tr>
									<td><b>Booked By</b></td>
									<td>:</td>
									<td><?php if(!empty($member['full_name'])){ echo $member['full_name']; } ?></td>
								</tr>
								
							</table>
						</div>
						
					 </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                     <div class="row">
						<div class="col-sm-12">
							<h3>Rental Information</h3>
							<table class="table table-sm table-bordered table-condensed table-striped">
								<thead>
									<tr>
										<th>Id</th>
										<th>Payment Date</th>
										<th>Package</th>
										<th>Rent Amount</th>
										<th>Recharge Days</th>
										<th>Rental Month</th>
										<th>Status</th>
										<th>view</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$i = 1;
								$rent_query = $mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' order by id desc");
								while($rent = mysqli_fetch_assoc($rent_query)){
								?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $rent['data']; ?></td>
										<td><?php echo $rent['package_name']; ?></td>										
										<td><?php echo money($rent['rent_amount']); ?></td>
										<td><?php echo $rent['recharge_days']; ?> Days</td>
										<td><?php echo $rent['month_name']; ?></td>
										<td>
											<?php
											if($rent['rent_status'] == 'Paid'){
												echo '<button class="btn btn-xs btn-success" type="button">Paid</button>';
											}else{
												echo '<button class="btn btn-xs btn-danger" type="button">Due</button>';
											}
											?>
										</td>
										<td>
											<button onclick="return view_rental_recipt(<?php echo $rent['id']; ?>)" class="btn btn-xs btn-warning" type="button"><i class="fa fa-eye"></i></button>
										</td>
									</tr>
								</tbody>
								<?php } ?>
							</table>
						</div>
					 </div>
                  </div>
				  
                  <div class="tab-pane fade" id="custom-tabs-one-refreshment" role="tabpanel" aria-labelledby="custom-tabs-one-refreshment-tab">
                     <div class="row">
						<div class="col-sm-12">
							<h3>Refreshment Items</h3>
							<table class="table table-sm table-bordered table-condensed table-striped">
								<thead>
									<tr>
										<th>Id</th>
										<th>Date</th>
										<th>Item</th>
										<th>Qty</th>
										<th>Amount</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$rent_queri = $mysqli->query("select * from refreshment_item_sell where buyer_id = '".$row['card_number']."'");
								
								while($rent = mysqli_fetch_assoc($rent_queri)){
								?>
									<tr>
										<td><?php echo $rent['id']; ?></td>
										<td><?php echo $rent['data']; ?></td>
										<td>
											<ul>
												<?php
													$pwq = $mysqli->query("select * from refreshment_item_list where buer_code = '".$rent['buying_code']."'");
													while($lo = mysqli_fetch_assoc($pwq)){
														echo '<li>'.$lo['product_name'].' - '.$lo['qty'].' ('.money($lo['amount']).')</li>';
													}
												?>
											</ul>
										</td>
										<td><?php echo $rent['total_qty']; ?></td>
										<td><?php echo money($rent['total_amount']); ?></td>
										<td>
											<?php
											if($rent['payment_status'] == 'Paid'){
												echo '<button class="btn btn-xs btn-success" type="button">Paid</button>';
											}else{
												echo '<button class="btn btn-xs btn-danger" type="button">Due</button>';
											}
											?>
										</td>
									</tr>
								</tbody>
								<?php } ?>
							</table>
						</div>
					 </div>
                  </div>
				  
				  <div class="tab-pane fade" id="custom-tabs-dining" role="tabpanel" aria-labelledby="custom-tabs-dining-tab">
                     <div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-5">
									<h3>Dining Report</h3>
								</div>
								<div class="col-sm-7">
									<div id="export_buttonsi" style="float:right;"></div>
								</div>
							</div>						
							<table id="member_dining_report" class="table table-sm table-bordered table-condensed table-striped">
								<thead>
									<tr>
										<th>Id</th>
										<th>Days</th>
										<th>BreaKfast</th>
										<th>Lunch</th>
										<th>Dinner</th>
										<th>Request</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>								
								</tbody>
							</table>
						</div>
					 </div>
                  </div>
				  
				  <div class="tab-pane fade" id="custom-tabs-checkout" role="tabpanel" aria-labelledby="custom-tabs-checkout-tab">
                     <div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-md-6">
									<div class="card">
									  <div class="card-header">
										Return Items
									  </div>
									  <div class="card-body">
										<ul class="list-group list-group-flush">
											<?php if(!empty($returnd_items_sql)){ ?>
											
												<?php while($row = $returnd_items_sql->fetch_assoc()){ ?>
													<li class="list-group-item"><b><?php echo $row['checkout_iteam'] ?>: </b><?php echo $row['lost_amount'] ?></li>
												<?php } ?>
												
											<?php } ?>
										</ul>
									  </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="card">
									  <div class="card-header">
										Non Return Items
									  </div>
									  <div class="card-body">
										<ul class="list-group list-group-flush">
										<?php if(!empty($non_returnd_items_sql)){ ?>
											<?php while($row = $non_returnd_items_sql->fetch_assoc()){ ?>
											<li class="list-group-item"><b><?php echo $row['checkout_iteam'] ?>: </b><?php echo $row['lost_amount'] ?></li>
											<?php } ?>
										<?php } ?>
										</ul>
									  </div>
									</div>
								</div>
							</div>
						</div>
					 </div>
                  </div>
				  
				  <div class="tab-pane fade" id="custom-tabs-transaction" role="tabpanel" aria-labelledby="custom-tabs-transaction-tab">
                     <div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-5">
									<h3>Transaction Report</h3>
								</div>
								<div class="col-sm-7">
									<div id="export_buttonsj" style="float:right;"></div>
								</div>
							</div>
							<table id="member_transaction_report" class="table table-sm table-bordered table-condensed table-striped" style="white-space: nowrap;">
								<thead>
									<tr>
										<th>Id</th>
										<th>TransactionID</th>
										<th>Amount</th>
										<th>Type</th>
										<th>Category</th>
										<th>By</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>								
								</tbody>
							</table>
						</div>
					 </div>
                  </div>

				  <div class="tab-pane fade" id="custom-tabs-all-transaction" role="tabpanel" aria-labelledby="custom-tabs-transaction-tab">
                     <div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-5">
									<h3>All Collection Report</h3>
								</div>
								<div class="col-sm-7">
									<div id="export_buttonsM" style="float:right;"></div>
								</div>
							</div>
							<table id="member_all_transaction_report" class="table table-sm table-bordered table-responsive table-striped" style="white-space: nowrap;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Transaction ID</th>
										<th>Card</th>
										<th>Cash</th>
										<th>Mobile</th>
										<th>Cheque</th>
										<th>Total Amount</th>
										<th>Transection Type</th>
										<th>Collection Purpose</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>								
								</tbody>
							</table>
						</div>
					 </div>
                  </div>


				  <div class="tab-pane fade" id="custom-tabs-bed_change" role="tabpanel" aria-labelledby="custom-tabs-bed_change-tab">
                     <div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-5">
									<h3>Bed Change Report</h3>
								</div>
								<div class="col-sm-7">
									<div id="export_buttonsk" style="float:right;"></div>
								</div>
							</div>
							<table id="member_bed_change_report" class="table table-sm table-bordered table-condensed table-striped" style="white-space: nowrap;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Old Bed</th>
										<th>New Bed</th>
										<th>Change Date</th>
										<th>Request Date</th>
										<th>By</th>
									</tr>
								</thead>
								<tbody>								
								</tbody>
							</table>
						</div>
					 </div>
                  </div>
				  
				  <div class="tab-pane fade" id="custom-tabs-package_shifting" role="tabpanel" aria-labelledby="custom-tabs-package_shifting-tab">
                     <div class="row">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-5">
									<h3>Package Shifting Report</h3>
								</div>
								<div class="col-sm-7">
									<div id="export_buttonsl" style="float:right;"></div>
								</div>
							</div>
							<table id="member_package_shifting_report" class="table table-sm table-bordered table-condensed table-striped" style="white-space: nowrap;">
								<thead>
									<tr>
										<th>Id</th>
										<th>Old.Ctg</th>
										<th>Old.Pkg</th>
										<th>New.Ctg</th>
										<th>New.Pkg</th>
										<th>Cng.Date</th>
										<th>Req.Date</th>
										<th>By</th>
										<th>Receipt</th>
									</tr>
								</thead>
								<tbody>								
								</tbody>
							</table>
						</div>
					 </div>
                  </div>
				  
				  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                     <div class="row">
						<div class="col-sm-12">
							<h1 style="text-align:center; font-size:50px;">Under Construction</h1>
						</div>
					 </div>
                  </div>
				  
				  
					<!--Member cancelation form management tab div-->
					<div class="tab-pane fade" id="custom-tabs-member-cancelation" role="tabpanel" aria-labelledby="custom-tabs-member-cancelation-tab">
						<div class="row">
							<div class="col-sm-9">
								<form id="cancelation_form" action="#" method="post">
									<span id="acencel_request_error_message" style="color:#f00;fonr-weight:bolder;"></span>
									<span id="adata_send_success_message" style="color:green;fonr-weight:bolder;"></span>
									<input type="hidden" name="member_id" value="<?php echo $row['id']; ?>"/>
									<div class="row">
										<div class="col-sm-3">
											<div class="form-group">
												<label>Choose Cancelation Type</label>
												<select name="cancelation_type" id="cancelation_type" class="form-control select2" required>
													<option value="">--select--</option>
													<option value="1">Cancel Reminder</option>
													<option value="2">Menual Cancel</option>
													<option value="3">Auto Cancel</option>
													<option value="4">Force Cancel</option>
												</select>
											</div>
										</div>
									</div>
									
									<div class="row" id="send_cancel_reminder_form" style="display:none;">
										<div class="col-sm-12">
											<h2>Send reminder message to member</h2>
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<label>Write Reminder Message</label>
														<textarea name="reminder_message" id="reminder_message" class="form-control" style="height:120px;"></textarea>
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group">
														<label>Remarks (Optional)</label>
														<textarea name="reminder_remarks" class="form-control"></textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row" id="menual_cencel_form" style="display:none;">
										<div class="col-sm-12">
											<h2>Manual Send Cancel Reminder SMS</h2>
											<div class="row">
												
											</div>
										</div>										
									</div>
									<div class="row" id="auto_cancel_form" style="display:none;">
										Auto Cancel
									</div>
									<div class="row" id="force_cancel_form" style="display:none;">
										Force Cancel
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<button type="submit" name="submit_cancel_button" class="btn btn-danger" style="float:right;">SUBMIT</button>
											</div>
										</div>
									</div>
								</form>
							</div>
							
							
						</div>
					</div>
					<script>
						$('document').ready(function(){
							$("#cancelation_type").on("change",function(){
								var value = $(this).val();
								if ( value == '1' ){
									$("#send_cancel_reminder_form").css({"display":"block"});
									$("#menual_cencel_form").css({"display":"none"});
									$("#auto_cancel_form").css({"display":"none"});
									$("#force_cancel_form").css({"display":"none"});
									$("#cancelation_form").on("submit",function(){
										if($("#reminder_message").val() == ''){
											alert('Reminder Message Required!');
											$("#reminder_message").focus();
											return false;
										}else{
											event.preventDefault();
											var form = $('#cancelation_type')[0];
											var data = new FormData(form);
											$.ajax({
												type: "POST",
												enctype: 'multipart/form-data',
												url:"<?php echo $home.'assets/ajax/form_submit/member_cancelation_form_submit.php'; ?>",  
												data: data,
												processData: false,
												contentType: false,
												cache: false,
												timeout: 600000,
												beforeSend:function(){
													$("#submit_cancel_button").prop("disabled", true);
													$('#data-loading').html(data_loading);
												},
												success:function(data){
													$('#data-loading').html('');
													var value = data.split('____');
													if(value[1] == '1'){
														$('#acencel_request_error_message').html(value[0]);
														$("#submit_cancel_button").prop("disabled", false);
														$('#booking_data_table').DataTable().ajax.reload( null , false);
													}else{
														$('#adata_send_success_message').html(value[0]);										
														$('#member_prifile_model').modal('hide');
														$("#cencel_request_button").prop("disabled", false);
														$('#booking_data_table').DataTable().ajax.reload( null , false);
													}					
												}
											});
											return false;
										}
										return false;
									})
									
								} else if ( value == '2' ){
									$("#send_cancel_reminder_form").css({"display":"none"});
									$("#menual_cencel_form").css({"display":"block"});
									$("#auto_cancel_form").css({"display":"none"});
									$("#force_cancel_form").css({"display":"none"});
								} else if ( value == '3' ){
									$("#send_cancel_reminder_form").css({"display":"none"});
									$("#menual_cencel_form").css({"display":"none"});
									$("#auto_cancel_form").css({"display":"block"});
									$("#force_cancel_form").css({"display":"none"});
								} else if ( value == '4' ){
									$("#send_cancel_reminder_form").css({"display":"none"});
									$("#menual_cencel_form").css({"display":"none"});
									$("#auto_cancel_form").css({"display":"none"});
									$("#force_cancel_form").css({"display":"block"});
								} else {
									$("#send_cancel_reminder_form").css({"display":"none"});
									$("#menual_cencel_form").css({"display":"none"});
									$("#auto_cancel_form").css({"display":"none"});
									$("#force_cancel_form").css({"display":"none"});
								}
							})
						})
					</script>
					<!--End Member cancelation form management tab div-->
                </div>
            </div>
        </div>
	</div>
</div>

<script>
$(document).ready(function() {
	
	var member_id = '<?php echo "?member_id=".rahat_encode($row['booking_id']).""; ?>';
    var table = $('#member_package_shifting_report').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?php echo $home; ?>assets/ajax/data_table/report/member_personal_package_shifting_report.php"+member_id,
		dom: 'lBfrtip',
        buttons: [			
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel' },
            { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV' },
            { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, 
			{ extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print' } 
		]
    });
	table.buttons().container().appendTo($('#export_buttonsl'));
})
$(document).ready(function() {
	var member_id = '<?php echo "?member_id=".rahat_encode($row['booking_id']).""; ?>';
    var table = $('#member_bed_change_report').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?php echo $home; ?>assets/ajax/data_table/report/member_personal_bed_change_report.php"+member_id,
		dom: 'lBfrtip',
        buttons: [			
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel' },
            { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV' },
            { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, 
			{ extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print' } 
		]
    });
	table.buttons().container().appendTo($('#export_buttonsk'));
})
$(document).ready(function() {
	var member_id = '<?php echo "?member_id=".rahat_encode($row['booking_id']).""; ?>';
    var table = $('#member_transaction_report').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?php echo $home; ?>assets/ajax/data_table/report/member_all_credit_personal_transaction_datatable.php"+member_id,
		dom: 'lBfrtip',
        buttons: [			
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel' },
            { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV' },
            { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, 
			{ extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print' } 
		]
    });
	table.buttons().container().appendTo($('#export_buttonsj'));
})
$(document).ready(function() {
	var member_id = '<?php echo "?member_id=".rahat_encode($row['booking_id']).""; ?>';
    var table = $('#member_all_transaction_report').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?php echo $home; ?>assets/ajax/data_table/report/member_all_credit_collection_datatable.php"+member_id,
		dom: 'lBfrtip',
        buttons: [			
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel' },
            { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV' },
            { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, 
			{ extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print' } 
		]
    });
	table.buttons().container().appendTo($('#export_buttonsM'));
})
$(document).ready(function() {
	var member_id = '<?php echo "?member_id=".rahat_encode($row['booking_id']).""; ?>';
    var table = $('#member_dining_report').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"processing": true,
        "serverSide": true,
        "ajax": "<?php echo $home; ?>assets/ajax/data_table/report/member_personal_dining_report.php"+member_id,
		dom: 'lBfrtip',
        buttons: [			
            { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy' },
            { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel' },
            { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV' },
            { extend: 'pdf', text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, 
			{ extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print' } 
		]
    });
	table.buttons().container().appendTo($('#export_buttonsi'));
})
</script>
<?php } ?>