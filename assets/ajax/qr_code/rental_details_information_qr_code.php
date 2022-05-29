<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['rent_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from rent_info where id = '".$_POST['rent_id']."'"));
$opt = explode("___",$row['uploader_info']);
$rentre = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$opt[1]."'"));
$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."'"));
$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$member['branch_id']."'"));
$package_cgt = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$member['package_category']."'"));
$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member['package']."'"));
?>
<style>
	.watermark::after {
		content: "";
		background-image:url('<?php echo $home; ?>assets/img/receipt_scan_qr_code.png');
		background-size: 900px;
		background-repeat: space; 
		background-position: 70px 500px;
		opacity: 0.05;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		position: absolute;
	}
	.bottom-table{
		font-size:20px;
	}
    @media only screen and (max-width: 600px) {
		.bottom-table{
			font-size: 15px;
		}
	}
</style>
<div class="row">
	<div class="col-sm-12" style="padding-top:20px;" id="print_area">
		<div class="row" style="margin-bottom:20px;margin-top:40px;">
			<div class="col-sm-12">
				<center>
					<img src="<?php echo $home; ?>assets/img/logo.png" style="width:130px;" class="image-responsive"/>
					<h3>Rental information</h3>
					<span>ID: <b><?php echo $row['card_no']; ?></b></span><br />
					<span>Application date: <b><?php echo $row['data']; ?></b></span>
				</center>
			</div>
		</div>
		<div class="row watermark">
			<div class="col-sm-12">
				<section>
					<div class="container">
						<div class="row">
							<div class="col-md-6" style="font-size:20px;line-height:30px;">
								<p>INVOICE BY:</p>
								<p class="name" style="color:#fd7e14;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
								<!--<a href="mailto:<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'Not provided!'; } ?></a><br />-->
								<!--<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php if(!empty($rentre['personal_Phone'])){ echo $rentre['personal_Phone']; }else{ echo 'Not provided!'; }  ?></a>-->
								<div style="width:100%;margin-top:10px;"></div>
								<hr />					
								<p>INVOICE TO:</p>
								<p class="name" style="color:#fd7e14;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $row['m_name']; ?></p>
								<p><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
								<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
								<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
								<p><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $member['bed_name']; ?></strong></p>
							</div>
							<div class="col-md-6">
								<?php
									$inv = explode('/',$row['data']);
									$invd = $inv[0].$inv[1].substr($inv[2],2).$row['id'];
									//echo $invd;
									//$count_check = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM transaction where booking_id = '".$row['booking_id']."' AND data = '".$row['data']."'"));
									//if($count_check[0] > 1){
									//	$id = mysqli_fetch_assoc($mysqli->query("select * from transaction where booking_id = '".$row['booking_id']."' AND data = '".$row['data']."' order by id desc limit 1,1"));
									//}else{
										$id = mysqli_fetch_assoc($mysqli->query("select * from transaction where booking_id = '".$row['booking_id']."' AND transaction_category IN ('Rental Account','Authorize Account') AND data = '".$row['data']."' order by id desc"));
									//}
									
								?>
								<div class="title" style="color:#000;font-size:25px;"><?php echo $id['transaction_id']; ?> </div>
								<div class="date" style="font-weight:bolder;line-height: 30px;">
									<table class="table table-sm" style="width:80%;" border-spacing="0">
										<tr>
											<td>Date of Invoice</td>
											<td>:</td>
											<td><strong style="font-weight:bolder;"><?php echo $row['data']; ?></strong></td>
										</tr>
										<tr>
											<td>CheckIn Date</td>
											<td>:</td>
											<td><strong style="font-weight:bolder;"><?php echo $row['checkin_date']; ?></strong></td>
										</tr>
										<?php if($member['check_out_date']){ ?>
										<tr>
											<td>CheckOut Date</td>
											<td>:</td>
											<td>
												<strong style="font-weight:bolder;">
													<?php
														if(!empty($row['checkout_date'])){
															$check_out_data = $row['checkout_date'];
														}else{
															$check_out_data = $member['check_out_date'];
														}
													?>
													<?php echo $check_out_data; ?> 
													<?php if($member['check_out_date'] != 'Not Confirm Yet'){ echo '- 2.00 PM'; } ?>
												</strong>
											</td>
										</tr>
										<?php } ?>
										<?php if($package['try_us'] == 0){ ?>
										<tr>
											<td>Rental Month</td>
											<td>:</td>
											<td><strong style="font-weight:bolder;"><?php echo $row['month_name']; ?></strong></td>
										</tr>
										<?php } ?>
										<tr>
											<td>Card Number</td>
											<td>:</td>
											<td><strong style="font-weight:bolder;"><?php echo $row['card_no']; ?></strong></td>
										</tr>
										<tr>
											<td>Package Category</td>
											<td>:</td>
											<td> <strong style="font-weight:bolder;"><?php echo $row['package_category_name']; ?> - <?php echo $row['package_name']; ?></strong></td>
										</tr>
										<tr>
											<td>Source</td>
											<td>:</td>
											<td> <strong style="font-weight:bolder;"><?php echo $member['h_t_f_u']; ?></strong></td>
										</tr>
										<tr>
											<td>Occupation</td>
											<td>:</td>
											<td> <strong style="font-weight:bolder;"><?php echo $member['occupation']; ?></strong></td>
										</tr>
										<?php 
											if($row['rent_status'] == 'Due'){
												$bg = 'btn-danger';
											}else{
												$bg = 'btn-success';
											}
										?>
										<tr>
											<td>Rental Status</td>
											<td>:</td>
											<td>
												<button type="button" class="btn  <?php echo $bg; ?>" style="padding: 0px 13px;">
													<strong style="font-weight:bolder;">
														<?php if($row['rent_status'] == 'Paid'){ echo '<i class="fas fa-check-circle"></i> &nbsp;&nbsp;PAID';}else{ echo '<i class="fas fa-times-circle"></i> &nbsp;&nbsp;DUE'; } ?>
													</strong>
												</button>
											</td>
										</tr>
										
										<?php if($package['try_us'] == '1'){ 
											if(!empty($row['data_three']) AND $row['data_three'] == 'renew'){
										?>
										<tr>
											<td>ReNew Status</td>
											<td>:</td>
											<td>
												<button type="button" class="btn btn-info" style="padding: 0px 13px;">
													<strong style="font-weight:bolder;">
														<i class="fas fa-check-circle"></i> &nbsp;&nbsp;Renewed
													</strong>
												</button>
											</td>
										</tr>
										<?php } } ?>
										
									</table>
								</div>
							</div>
						</div>

						<table class="table bottom-table">
							<thead>
								<tr>
									<th class="desc" style="color:#000;">#</th>
									<th class="qty" style="color:#000;">Type</th>
									<th class="unit" style="color:#000;">Unit price</th>
									<th class="total" style="color:#000;">Total</th>
								</tr>
							</thead>
							<tbody>
								<?php /* ?>
								<tr>
									<td class="desc">
										<h3>
											Security Money
											<?php
												$chksec = mysqli_fetch_array($mysqli->query("select count(*) from rent_info where booking_id = '".$row['booking_id']."'"));
											?>
										</h3>							
									</td>
									<td class="qty"> <h3><?php echo $row['package_category_name']; ?></h3> </td>
									<td class="unit" style="color:#000;">
										<?php
											if($chksec['0'] < 2){
												echo money($member['security_deposit']);
												$sd_m = $member['security_deposit'];
											}else{
												$sd_m = 0;
											}
										?>
									</td>
									<td class="total" style="color:#000;"><?php echo money($sd_m); ?></td>
								</tr>
								<?php */ 
									$sd_m = 0;
								?>
								<tr>
									<?php
									if($row['dis_aamt'] == 1){
										$dis_check = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'"));
										$brento_n_c = mysqli_fetch_array($mysqli->query("select count(*) from rent_info where booking_id = '".$row['booking_id']."'"));
										if($row['payment_pattern'] == 0){								
											if($brento_n_c[0] < 3 AND $brento_n_c[0] > 0){
												$dis_mnt = $dis_check['amount'] / 2;
											}else{
												$dis_mnt = '0';
											}
										}else{
											if($brento_n_c[0] < 3 AND $brento_n_c[0] > 0){
												if($brento_n_c[0] > 1){ // condition open by rayhan  19-04-2021
													$dis_mnt = $dis_check['amount'] / 2;
												}else{
													$dis_mnt = $dis_check['amount'];
												}									
											}else{
												$dis_mnt = '0';
											}
										}
									}else{
										$dis_mnt = '0';
									}					
									?>
									<td class="desc">
										Rent 
									</td>
									<td class="qty"> <?php echo $row['package_name']; ?> </td>
									<td class="unit" style="color:#000;">
										<?php echo money($row['rent_amount'] + $dis_mnt); ?>
									</td>
									<td class="total" style="color:#000;"><?php echo money($row['rent_amount'] + $dis_mnt); ?></td>
								</tr>
								
								<tr>
									<td class="desc">
										Purchase
									</td>
									<td class="qty" style="color:#000;">
										----
									</td>
									<td class="unit" style="color:#000;">
										<?php echo money($row['tea_coffee']); ?>
									</td>
									<td class="total" style="color:#000;">
										<?php echo money($row['tea_coffee']); ?>
									</td>
								</tr>
								<tr>
									<td class="desc">
										Electricity Bill
									</td>
									<td class="qty" style="color:#000;">----</td>
									<td class="unit" style="color:#000;"><?php echo money($row['electricity']); ?></td>
									<td class="total" style="color:#000;"><?php echo money($row['electricity']); ?></td>
								</tr>
								<tr>
									<td class="desc">
										Penalty
									</td>
									<td class="qty" style="color:#000;">----</td>
									<td class="unit" style="color:#000;"><?php echo money($row['penalty']); ?></td>
									<td class="total" style="color:#000;"><?php echo money($row['penalty']); ?></td>
								</tr>
								<tr>
									<td class="desc">
										Locker
									</td>
									<td class="qty" style="color:#000;">----</td>
									<td class="unit" style="color:#000;"><?php echo money($row['locker']); ?></td>
									<td class="total" style="color:#000;"><?php echo money($row['locker']); ?></td>
								</tr>
								<tr>
									<td class="desc">
										Parking
									</td>
									<td class="qty" style="color:#000;">----</td>
									<td class="unit" style="color:#000;"><?php echo money($row['parking']); ?></td>
									<td class="total" style="color:#000;"><?php echo money($row['parking']); ?></td>
								</tr>
							</tbody>
						</table>
						<div class="no-break">
							<table class="table bottom-table" style="border-collapse: collapse; border-spacing: 0;">
								<tbody>
									<?php 
									if(!empty($row['card_p_amount']) AND $row['card_p_amount'] > 0){
									?>
									<tr>
										<td class="desc" style="text-align:left;color:#000;width: 47%;"> </td>
										<td class="unit" style="color:#000;width: 27%;">Card Charge:</td>
										<td class="total" style="color:#000;">
											<?php echo money($row['card_p_amount']); ?>
										</td>
									</tr>
									<?php 
										$card_charge = $row['card_p_amount'];
									}else{
										$card_charge = 0;
									} 
									?>
									<tr>
										<td class="desc" style="text-align:left;color:#000;width: 47%;">
											Payment Pattern: 
											<?php
												if($row['payment_pattern'] == '1'){
													echo ' <strong style="font-weight:bolder;">Full/Rest of Payment</strong>';
												}else if($row['payment_pattern'] == '0'){
													echo ' <strong style="font-weight:bolder;">Half Payment</strong>';
												}else if($row['payment_pattern'] == '3'){
													echo ' <strong style="font-weight:bolder;">Pendamic</strong>';
												}else if($row['payment_pattern'] == '2'){
													echo ' <strong style="font-weight:bolder;">Due Payment</strong>';
												}
											?>
										</td>
										<td class="unit" style="color:#000;width: 27%;">SUBTOTAL:</td>
										<td class="total" style="color:#000;">
											<strong style="font-weight:bolder;color:#000;">
												<?php
													$total_amount = (float)$sd_m + (float)$row['rent_amount'] + $dis_mnt + (float)$row['tea_coffee'] + (float)$row['electricity'] + (float)$row['penalty'] + (float)$row['locker'] + (float)$row['parking'] + $card_charge; //+ $dis_mnt
													echo money((float)$total_amount); 
												?>
											</strong>
										</td>
									</tr>
									<tr>
										<td class="desc" style="text-align:left;color:#000;width: 47%;">
											<?php if(!empty($row['recharge_days'])){ ?>Recharge Days: <strong style="font-weight:bolder;"><?php echo $row['recharge_days']; ?> Days</strong><?php } ?>
										</td>
										<td class="unit" style="color:#000;width: 27%;">Cash Back:</td>
										<td class="total">
											<?php
												echo money($dis_mnt);
											?>
										</td>
									</tr>					
									
									<tr>
										<td class="desc" style="color:#000;font-size:20px;font-weight:500;text-align:left;width: 47%;">
											<?php /* ?>Payment Method: <strong style="font-weight:bolder;"><?php echo rtrim($row['payment_method'],','); ?></strong><?php */ ?>
										</td>
										<td class="unit" style="color:#000;width: 27%;">GRAND TOTAL:</td> <!-- colspan="2"-->
										<?php
											$grand_t = (float)$total_amount - (float)$dis_mnt ; 
										?>
										<td class="total" style="color:#000;"><?php echo money($grand_t); ?></td>
									</tr>
								</tbody>
							</table>
							<div style="width:100%;float:left;color: #000; font-size: 25px; font-weight: 500;">
								<div style="float:left;width:75%;">
									<?php
										$che_payment = mysqli_fetch_assoc($mysqli->query("select * from payment_received_method where transaction_id = '".$id['transaction_id']."'"));
										if(!empty($che_payment)){
									?>
									Payment Method: <br />
									<ul>
										<?php
											$p_sql = $mysqli->query("select * from payment_received_method where transaction_id = '".$id['transaction_id']."'");
											while($pmw = mysqli_fetch_assoc($p_sql)){
												if($pmw['payment_method'] == 'Cash'){
													$amount = $pmw['cash_amount'];
												} else if($pmw['payment_method'] == 'Mobile Banking'){
													$amount = $pmw['mobile_amount'];
												} else if($pmw['payment_method'] == 'Credit / Debit Card'){
													$amount = $pmw['card_amount'];
												} else if($pmw['payment_method'] == 'Check'){
													$amount = $pmw['check_amount'];
												}
												echo '<li>'.$pmw['payment_method'].' - <b>'.money($amount).'</b></li>';
											}
										?>
									</ul>
									<?php } ?>
								</div>
								<div style="float:left;width:25%;">
									<?php				
										if(!empty($row['remarks'])){ ?>
										<span style="float:right;">
											<strong><?php echo $row['remarks']; ?></strong>							
										<span>
									<?php } ?>
								</div>					
							</div>
						</div>
					</div>
				</section>
			</div>			
		</div>
		<div class="col-sm-12">
	<?php
		$cond = mysqli_fetch_assoc($mysqli->query("select * from static_content where page_type = 'Terms & Conditions'"));
		echo '<div style="padding-left:15px;padding-right:15px;">'.$cond['content'].'</div>';
	?>
	</div>
	<div class="col-sm-12">
		<div style="width:100%;margin-top:50px;">
			<div style="width:30%;">
				<span>
					________________________<br />
					Member Sign & Date
				</span>
			</div>
		</div>
	</div>
	</div>
</div>
  <link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
  <link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>

  <!-- demo -->
  <script>
    $('#print_button').on("click", function () {
      $('#print_area').printThis({
      });
    });
  </script>

<?php } ?>