<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['booking_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$_POST['booking_id']."'"));
$rent = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' order by id ASC"));
$opt = explode("___",$row['uploader_info']);
$rentre = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$opt[1]."'"));
$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."'"));
$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch_id']."'"));
$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));
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
	.qty-low{
		width: 18%;
	}
	.unit-low{
		width: 19%;
	}
	.bottom-table{
		font-size:20px;
	}
	@media  screen and (max-width: 600px){
		.bottom-table{
			font-size: 15px;
		}
		.qty-low{
			width: 1px;
		}
		.unit-low{
			width: 9%;
		}
		.watermark::after {
			background-size: 350px;
			background-position: 20px 500px;
		}
		table{
			font-size: 15px !important;
		}
		table h5{
			font-size: 15px !important;
		}
		.desc{
			width: 40%;
		}
	}
</style>
<div class="row">
	<div class="col-sm-12" id="print_area">
		<div class="row" style="margin-bottom:20px;margin-top:40px;">
			<div class="col-sm-12">
				<center>
					<img src="<?php echo $home; ?>assets/img/logo.png" style="width:130px;" class="image-responsive"/>
					<h3 style="text-align:center;">Booking information</h3>
					<span style="text-align:center;">ID: <b><?php echo $row['card_no']; ?></b></span><br />
					<span style="text-align:center;">Application date: <b><?php echo $row['data']; ?></b></span>
				</center>
			</div>
		</div>
		<div class="row justify-content-between watermark">
			<div class="col-sm-4">
				<p>INVOICE BY:</p>
				<p class="name" style="color:green;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
				<hr>
				<p>INVOICE TO:</p>
				<p class="name" style="color:green;font-weight:bolder;margin: 0px;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $row['m_name']; ?></p>
				<p style="margin: 0px;"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
				<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
				<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
				<p style="margin: 0px;"><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $member['bed_name']; ?></strong></p>
			</div>
			<div class="col-sm-6">
				<?php
					$inv = explode('/',$row['data']);
					$invd = $inv[0].$inv[1].$inv[2];
					$id = mysqli_fetch_assoc($mysqli->query("select * from transaction where booking_id = '".$row['booking_id']."' and data = '".$row['data']."' and note = 'Booking Money Collection'"));
				?>
				<div class="title" style="color:#000;font-size:25px;"><?php echo $id['transaction_id']; ?> </div>
				<div class="date" style="font-weight:bolder;line-height: 30px;">
					<table class="table table-sm table-borderless">
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
						<?php if($row['checkout_date']){ ?>
						<tr>
							<td>CheckOut Date</td>
							<td>:</td>
							<td><strong style="font-weight:bolder;"><?php echo $row['checkout_date']; ?> <?php if($row['checkout_date'] != 'Not Confirm Yet'){ echo '- 2.00 PM'; } ?></strong></td>
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
					</table>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table bottom-table">
					<thead>
						<tr>
							<th style="color:#000;" class="desc">#</th>
							<th style="color:#000;" class="qty">Type</th>
							<th style="color:#000;" class="unit">Unit price</th>
							<th style="color:#000;" class="total">Total</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="desc">
								<h5 style="color:#000;"> Security Money </h5>							
							</td>
							<td class="qty"> <h5 style="color:#000;"><?php echo $row['package_category_name']; ?></h5> </td>
							<td class="unit" style="color:#000;">
								<?php
									echo money($row['security_deposit']);
									$sd_m = $row['security_deposit'];								
								?>
							</td>
							<td class="total" style="color:#000;"><?php echo money($sd_m); ?></td>
						</tr>
						<?php 
							if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid' AND $rent['note'] == 'booking'){
						?>
						<tr>
							<td class="desc">
								<h5 style="color:#000;"> Rent </h5>
							</td>
							<td class="qty"> <h5 style="color:#000;"><?php echo $row['package_name']; ?></h5> </td>
							<td class="unit" style="color:#000;">
								<?php echo money($row['rent_amount']); ?>
							</td>
							<td class="total" style="color:#000;"><?php echo money($row['rent_amount']); ?></td>
						</tr>
						
						<?php if((float)$rent['parking'] > 0 ){ ?>
						<tr>
							<td class="desc">
								<h5 style="color:#000;"> Parking </h5>
							</td>
							<td class="qty"> <h5 style="color:#000;">----</h5> </td>
							<td class="unit" style="color:#000;">
								<?php echo money((float)$rent['parking']); ?>
							</td>
							<td class="total" style="color:#000;"><?php echo money((float)$rent['parking']); ?></td>
						</tr>
						<?php 
							$parking = (float)$rent['parking'];
						}else{
							$parking = 0;
						}
						?>
						
						<?php if((float)$rent['locker'] > 0 ){ ?>
						<tr>
							<td class="desc">
								<h5 style="color:#000;"> Locker </h5>
							</td>
							<td class="qty"> <h5 style="color:#000;">----</h5> </td>
							<td class="unit" style="color:#000;">
								<?php echo money((float)$rent['locker']); ?>
							</td>
							<td class="total" style="color:#000;"><?php echo money((float)$rent['locker']); ?></td>
						</tr>
						<?php 
							$locker = (float)$rent['locker'];
						}else{
							$locker = 0;
						}
						?>
						
						<?php
							$rent1 =  $row['rent_amount'];
							$discount_show = '1';
							if($rent['payment_pattern'] == 0){
								$pay_ptrn = 'Payment Pattern: <b>Half Payment</b>';
							}else{
								$pay_ptrn = 'Payment Pattern: <b>Full Payment</b>';
							}
						}else{
							$rent1 =  0;
							$locker = 0;
							$parking = 0;
							$discount_show = '0';
							$pay_ptrn = '';
						}
						?>
					</tbody>
				</table>
				<table class="table table-borderless bottom-table">
					<tbody>
						<?php 
						if(!empty($row['card_p_amount']) AND $row['card_p_amount'] > 0){
						?>
						<tr>
							<td class="desc" style="text-align:left;color:#000;"> 
							
							</td>
							<td class="qty-low" style="width: 10%;"></td>
							<td class="unit-low" style="color:#000;">Card Charge:</td>
							<td class="total">
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
							<td class="desc" style="text-align:left;color:#000;">
								<?php if(!empty($pay_ptrn)){ echo $pay_ptrn; } ?>
							</td>
							<td class="qty-low" style="color:#000;"></td>
							<td class="unit-low" style="color:#000;">SUBTOTAL:</td>
							<td class="total" style="color:#000;">
								<strong style="font-weight:bolder;">
									<?php
										$total_amount = (float)$sd_m + (float)$rent1 + $parking + $locker + (float)$card_charge;
										echo money((float)$total_amount); 
									?>
								</strong>
							</td>
						</tr>
						<?php
						if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid'){
						?>
						<tr>
							<td class="desc" style="text-align:left;color:#000;">
								<?php 
									if($rent['payment_pattern'] == '1' OR $rent['payment_pattern'] == '2' OR $rent['payment_pattern'] == '0'){  //payment_pattern
										if($rent['recharge_days'] > 0){
								?>
									Recharge: <b><?php echo $rent['recharge_days']; ?> Days</b>
								<?php } } ?>		
							</td>
							<td class="qty-low"></td>
							<td class="unit-low" style="color:#000;">Cash Back:</td>
							<td class="total">
								<?php								
								if($discount_show == '1'){	
									$td = explode('/',$rent['data']);
									$dis_check = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'")); // and month like '%".date($td[1])."%' and year LIKE '%".date($td[2])."%'
									if(!empty($dis_check['amount'])){
										if(!empty($rent['id'])){
											if($rent['payment_pattern'] == 0){
												echo money($dis_check['amount'] / 2);
												$dis_mnt = $dis_check['amount'] / 2;
											}else{
												echo money($dis_check['amount']);
												$dis_mnt = $dis_check['amount'];
											}											
										}else{
											echo money(0);
											$dis_mnt = 0;
										}
										
									}else{
										$dis_mnt = '0';
										echo money(0);
									}
								}else{
									$dis_mnt = '0';
									echo money(0);
								}
								?>
							</td>
						</tr>					
						<?php }else{ 
							$dis_mnt = 0;
						} ?>
						
						
						<tr>
							<td class="desc" style="color:#000;font-size:20px;font-weight:500;text-align:left;">
								<?php /* ?>Payment Method: <strong style="font-weight:bolder;"><?php echo rtrim($row['payment_method'],','); ?></strong><?php */ ?>
							</td>
							<td class="qty-low"></td>
							<td class="unit-low" style="color:#000;">GRAND TOTAL:</td> <!-- colspan="2"-->
							<?php
								$grand_t = (float)$total_amount - (float)$dis_mnt; 
							?>
							<td class="total" style="color:#000;"><?php echo money($grand_t); ?></td>
						</tr>
					</tbody>
				</table>
				<div class="col-md-12">
					
					<div style="width:100%;float:left;color: #000; font-size: 25px; font-weight: 500;">
						<div style="float:left;width:65%;">
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
							<?php
								if(!empty($row['note'])){
									echo '
										<hr />
										'.$row['note'].'
									';
								}
							?>
						</div>
						<div style="float:left;width:100%;">
							<?php				
								$dis_checki = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'"));
								if(!empty($dis_checki['amount']) AND $dis_checki['amount'] > 0){ ?>
								<span style="float:right;">
									<strong style="font-weight:bolder;color:green;font-size: 20px;">Congratulation! You get cashback <span style="color:#f00;"><?php echo money($dis_checki['amount']); ?></span> at 1st Rent</strong>							
								<span>
							<?php } ?>
						</div>					
					</div>
				</div>
			</div>
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
			<div style="width:50%;">
				<span>
					________________________<br />
					Member Sign & Date
				</span>
			</div>
		</div>
	</div>
</div>
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<?php } ?>