<?php 
// error_reporting(0);
include("../../application/config/ajax_config.php");
if(isset($_POST['change_info_id'])){
    $get_change_info = mysqli_fetch_assoc($mysqli->query("SELECT * from package_change_info where id = ".$_POST['change_info_id']));

    $old_package = mysqli_fetch_assoc($mysqli->query("SELECT * from packages where id = ".$get_change_info['old_package']));

    $new_package = mysqli_fetch_assoc($mysqli->query("SELECT * from packages where id = ".$get_change_info['new_package']));

	$get_rental_transactions = mysqli_fetch_assoc($mysqli->query("SELECT * from package_change_transaction_info where package_change_id = '".$get_change_info['id']."' AND transaction_category = 'Rental Account'"));
	$get_security_deposit_transactions = mysqli_fetch_assoc($mysqli->query("SELECT * from package_change_transaction_info where package_change_id = '".$get_change_info['id']."' AND transaction_category = 'Security Deposit Account'"));

    $member = mysqli_fetch_assoc($mysqli->query("SELECT * from member_directory where booking_id = '".$get_change_info['booking_id']."'"));
	

	$uploader_info = explode('___', $get_change_info['uploader_info']);
	$rentre = mysqli_fetch_assoc($mysqli->query("SELECT * from employee where email = '".$uploader_info[1]."'"));

	/**
	 * Generate QR code.
	 * Assign link.
	 */
	// include('../../application/helpers/qrcode_helper.php');
	// $qr_code_link = $home.'shifting-information/qr-code/'.$_POST['change_info_id'];
	// $file = '../uploads/qrcode/shifting_recipt_id_'.$get_change_info['id'].'.png'; 
	// QRcode::png($qr_code_link,$file, 'L', '10', 2); 

?>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta http-equiv="content-type" content="text-html; charset=utf-8">
<style>
	.col-print-1 {width:8%;  float:left;}
    .col-print-2 {width:16%; float:left;}
    .col-print-3 {width:25%; float:left;}
    .col-print-4 {width:33%; float:left;}
    .col-print-5 {width:42%; float:left;}
    .col-print-6 {width:50%; float:left;}
    .col-print-7 {width:58%; float:left;}
    .col-print-8 {width:66%; float:left;}
    .col-print-9 {width:75%; float:left;}
    .col-print-10{width:83%; float:left;}
    .col-print-11{width:92%; float:left;}
    .col-print-12{width:100%; float:left;}
</style>
<div class="card bg-light">
	<div class="card-body">
		<div class="col-sm-12" style="margin-bottom:30px;">
			<button type="button" id="print_button_new" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
		</div>
		<div style="width:100%;margin-top:30px;float:left;"></div>
		<section id="print_area_new">
			<header class="clearfix" style="margin-bottom:15px;">
				<div class="container">
					<figure>
						<img class="logo" src="<?php echo $home; ?>assets/img/n_logo.png" alt="" style="width:90px;">
					</figure>
					<div class="company-address">
						<h1 class="title" style="color:#0277bd;margin-bottom:0px;">SUPER HOME</h1>
						<p style="font-size:18px;"><?php echo $member['branch_name']; ?><br></p>
					</div>
					<div class="company-contact" style="height:80px;background-color:#4fc3f7;">
						<div class="phone left">
							<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjkuNzYycHgiIGhlaWdodD0iOS45NThweCINCgkgdmlld0JveD0iLTQuOTkyIDAuNTE5IDkuNzYyIDkuOTU4IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IC00Ljk5MiAwLjUxOSA5Ljc2MiA5Ljk1OCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMS4wMDAwMDAsIC01NC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJLT05UQUtUSSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjY3LjAwMDAwMCwgMzUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPGcgaWQ9Ik92YWwtMS1feDJCXy1GaWxsLTEiPg0KCQkJCQk8cGF0aCBpZD0iRmlsbC0xIiBmaWxsPSIjOEJDMzRBIiBkPSJNOC43NjUsMTIuMzc1YzAuMDIsMC4xNjItMC4wMjgsMC4zMDMtMC4xNDMsMC40MjJMNy4yNDYsMTQuMTkNCgkJCQkJCWMtMC4wNjIsMC4wNy0wLjE0MywwLjEzMy0wLjI0MywwLjE4MmMtMC4xMDEsMC4wNDktMC4xOTcsMC4wOC0wLjI5NSwwLjA5NGMtMC4wMDcsMC0wLjAyOCwwLTAuMDYyLDAuMDA0DQoJCQkJCQljLTAuMDM0LDAuMDA1LTAuMDgsMC4wMDgtMC4xMzQsMC4wMDhjLTAuMTMxLDAtMC4zNDMtMC4wMjMtMC42MzUtMC4wNjhjLTAuMjkzLTAuMDQ1LTAuNjUxLTAuMTU4LTEuMDc2LTAuMzM2DQoJCQkJCQljLTAuNDI0LTAuMTgyLTAuOTA0LTAuNDUxLTEuNDQyLTAuODA5Yy0wLjUzNi0wLjM1Ny0xLjEwOS0wLjg1Mi0xLjcxNi0xLjQ3OWMtMC40ODEtMC40ODQtMC44OC0wLjk1LTEuMTk4LTEuMzkzDQoJCQkJCQlDMC4xMjgsOS45NS0wLjEyNSw5LjU0MS0wLjMxOSw5LjE2NGMtMC4xOTMtMC4zNzYtMC4zMzgtMC43MTctMC40MzQtMS4wMjNjLTAuMDk3LTAuMzA2LTAuMTYxLTAuNTctMC4xOTUtMC43OTINCgkJCQkJCWMtMC4wMzUtMC4yMjEtMC4wNS0wLjM5NC0wLjA0Mi0wLjUyMWMwLjAwNy0wLjEyNiwwLjAxLTAuMTk3LDAuMDEtMC4yMTFjMC4wMTQtMC4wOTksMC4wNDQtMC4xOTgsMC4wOTMtMC4zMDENCgkJCQkJCWMwLjA0OS0wLjEwMSwwLjEwOC0wLjE4NCwwLjE3Ni0wLjI0N2wxLjM3NS0xLjQwM2MwLjA5Ny0wLjA5OCwwLjIwNi0wLjE0NywwLjMzLTAuMTQ3YzAuMDksMCwwLjE2OSwwLjAyNiwwLjIzOCwwLjA3OQ0KCQkJCQkJQzEuMyw0LjY0OCwxLjM1OSw0LjcxNCwxLjQwNiw0Ljc5MWwxLjEwNiwyLjE0MWMwLjA2MiwwLjExNCwwLjA4LDAuMjM1LDAuMDUyLDAuMzdDMi41MzgsNy40MzYsMi40NzgsNy41NDgsMi4zODksNy42NA0KCQkJCQkJTDEuODgzLDguMTU3QzEuODY5LDguMTcxLDEuODU2LDguMTk0LDEuODQ2LDguMjI2QzEuODM1LDguMjU2LDEuODMsOC4yODMsMS44Myw4LjMwNGMwLjAyNywwLjE0NywwLjA5LDAuMzE3LDAuMTg3LDAuNTA3DQoJCQkJCQljMC4wODIsMC4xNjksMC4yMSwwLjM3NSwwLjM4MiwwLjYxOGMwLjE3MiwwLjI0MywwLjQxNywwLjUyMSwwLjczNCwwLjgzOWMwLjMxMSwwLjMyMiwwLjU4NSwwLjU3NCwwLjgyOCwwLjc1NQ0KCQkJCQkJYzAuMjQsMC4xNzgsMC40NDMsMC4zMDksMC42MDQsMC4zOTVjMC4xNjIsMC4wODUsMC4yODYsMC4xMzUsMC4zNzIsMC4xNTRsMC4xMjgsMC4wMjRjMC4wMTUsMCwwLjAzOC0wLjAwNiwwLjA2Ny0wLjAxNg0KCQkJCQkJYzAuMDMyLTAuMDEsMC4wNTQtMC4wMjEsMC4wNjctMC4wMzdsMC41ODgtMC42MTJjMC4xMjUtMC4xMTIsMC4yNy0wLjE2OCwwLjQzNi0wLjE2OGMwLjExNywwLDAuMjA3LDAuMDIxLDAuMjc3LDAuMDYxaDAuMDENCgkJCQkJCWwxLjk5NSwxLjIwM0M4LjY1MSwxMi4xMiw4LjczNywxMi4yMzQsOC43NjUsMTIuMzc1TDguNzY1LDEyLjM3NXoiLz4NCgkJCQk8L2c+DQoJCQk8L2c+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==" alt=""><span class="helper"></span></span>
							<a href="tel:602-519-0450" style="text-decoration: none;font-size:20px;color:#000;">(+880) 96386-66333</a>
							<span class="helper"></span>
						</div>
						<div class="email right">
							<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
							<a href="mailto:info@superhomebd.com" style="text-decoration: none;font-size:20px;color:#000;">info@superhomebd.com</a>
							<span class="helper"></span>
							<!-- <span style="width:80px;height:80px;margin-left:10px;">
								<img src="<?php echo $home.'assets/uploads/qrcode/shifting_recipt_id_'.$get_change_info['id'].'.png'; ?>" style="width:81px;float:right;border: 1px #eee solid;" class="image-responsive"/>
							</span> -->
						</div>
						
					</div>
					<div style="width:100%;float:left;">
						<center>
							<h1 style="font-size:3em;font-weight:600;margin: 0.2em 0;"><u>Package Shifting Receipt</u></h1>
						</center>
					</div>
				</div>
			</header>

			<section>
				<div class="container">
					<div class="row justify-content-between" style="font-size:20px;">
						<div class="col-print-4">
							<div class="row">
								<div class="col-md-12">
									<p>INVOICE BY:</p>
									<p class="name" style="color:#0277bd;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
									<p><i class="fa fa-calendar"></i> &nbsp;&nbsp;<?= $get_change_info['data'] ?></p>
								</div>
								<?php if($get_change_info['shifting_transaction_id'] != ''){ ?>
									<div class="col-md-12"><hr></div>
									<div class="col-md-12 font-weight-bold h3">
										<?= $get_change_info['shifting_transaction_id'] ?>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="col-print-4 text-right">
							<p>INVOICE TO:</p>
							<p class="name" style="color:#0277bd;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $member['full_name']; ?></p>
							<p><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
							<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
							<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
							<p><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $member['bed_name']; ?></strong></p>
						</div>
						<div class="col-print-12"></div>
					</div>
					<div class="row">
						<table class="mt-5 sub-total text-center table-bordered" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
							<thead>
								<tr>
									<th style="color:#000;" class="qty">Package From</th>
									<th style="color:#000;" class="qty">Package To</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="qty" style="color:#000;"><?php echo $old_package['package_category_name']." - ".$old_package['package_name'];?></td>
									<td class="qty" style="color:#000;"><?php echo $new_package['package_category_name']." - ".$new_package['package_name'];?></td>
								</tr>
							</tbody>
						</table>
						<?php if(!is_null($get_rental_transactions) OR !is_null($get_security_deposit_transactions)){ ?>
							<table class="mt-5 sub-total text-center table table-bordered" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
								<thead>
									<tr>
										<th style="color:#000;" class="qty">Transaction Type</th>
										<th style="color:#000;" class="qty">Amount</th>
									</tr>
								</thead>
								<tbody>
										<?php if(!is_null($get_rental_transactions)){ ?>
											<tr>
												<td class="qty" style="color:#000;">Package Shifting Rent</td>
												<td class="qty" style="color:#000;"><?php echo money($get_rental_transactions['amount']) ?></td>
											</tr>
										<?php } ?>
										<?php if(!is_null($get_security_deposit_transactions)){ ?>
											<tr>
												<?php if($get_security_deposit_transactions['amount'] > 0){ ?>
													<td class="qty" style="color:#000;"><span>Collected Security Deposit </span></td>
													<td class="qty" style="color:#000;"><?php echo money($get_security_deposit_transactions['amount']) ?></td>
												<?php }else{ ?>
													<td class="qty" style="color:#000;"><span>Security Deposit Deduction </span></td>
													<td class="qty" style="color:#000;"><?php echo money($get_security_deposit_transactions['amount'] * -1) ?></td>									
												<?php } ?>
											</tr>
										<?php } ?>
								</tbody>
							</table>
							<?php if(!empty($get_change_info['shifting_transaction_id'])){ ?>
							<div class="col-md-12">
								<h4 style="display: inline-block;">Payment Method: </h4>
							</div>
							<ul style="font-size: 22px;list-style: none;">
							<?php								
									$get_payment_methods = $mysqli->query("SELECT * from payment_received_method where transaction_id = '".$get_change_info['shifting_transaction_id']."'");
									if($get_payment_methods->num_rows > 0){
										while($payment_method = mysqli_fetch_assoc($get_payment_methods)){
											$html = '<li> '. $payment_method['payment_method'].': <span style="font-weight: bold">';
											switch($payment_method['payment_method']){
												case 'Cash':
													$note = (empty($payment_method['note'])) ? '' : '. ('.$payment_method['note'].')';
													$html .= money($payment_method['cash_amount']) . '</span>' . $note;
													break;
												case 'Cash,':
													$note = (empty($payment_method['note'])) ? '' : '. ('.$payment_method['note'].')';
													$html .= money($payment_method['cash_amount']) . '</span>' . $note;
													break;
												case 'Check':
													$note = (empty($payment_method['note'])) ? '' : '. ('.$payment_method['note'].')';
													$html .= money($payment_method['check_amount']) . '</span>' . $note;
													break;
												case 'Credit / Debit Card':
													$note = (empty($payment_method['note'])) ? '' : '. ('.$payment_method['note'].')';
													$html .= money($payment_method['card_amount']) . '</span>' . $note;
													break;
												case 'Mobile Banking':
													$note = (empty($payment_method['note'])) ? '' : '. ('.$payment_method['note'].')';
													$html .= money($payment_method['mobile_amount']) . '</span>' . $note;
													break;
												case 'Mobile Banking.':
													$note = (empty($payment_method['note'])) ? '' : '. ('.$payment_method['note'].')';
													$html .= money($payment_method['mobile_amount']) . '</span>' . $note;
													break;
											}
											echo $html . ' </li>';
										}
									}
								}
							?>
						<?php } ?>
						</ul>
					</div>
				</div>
			</section>
			<footer>
				<div class="container mt-4">
					<div class="thanks">Thank you!</div>
					<div class="end-new">
						<div> <!-- redundent div for printing -->
							<div>
								<div style="padding-bottom:100px;">
									<div class="row text-center">
										<div class="col-sm invoice-disclaimer-border">
											<p>Invoice was created on a computer and is valid without the signature and seal.</p>
										</div>
									</div>
								</div>
							</div>
							<div style="width:100%" class="row justify-content-start text-start bottom-page-cut">
								<!-- <i class="fas fa-cut"></i> -->
								<div class="col-sm">
								</div>
							</div>								
							<div style="width:95%;right:5%;" class="row justify-content-between bottom-page">
								<div class="col-print-1">
									<div>
										<?php if(!empty($id['transaction_id'])){ ?>
										<div class="booking-form-tag">
											<img src="<?php echo $home.'assets/uploads/qrcode/rental_recipt_id_'.$row['booking_id'].'.png'; ?>" style="width:100px;float:right;border: 1px #eee solid;" class="image-responsive"/>
										</div>
										<?php } ?>
									</div>
								</div>
								<div class="col-print-3">
									<div style="font-size: 25px; font-weight: 500;">
										<?php
											if(!empty($id['transaction_id'])){
											$che_payment = mysqli_fetch_assoc($mysqli->query("select * from payment_received_method where transaction_id = '".$id['transaction_id']."'"));
											if(!empty($che_payment)){
										?>
										<ul style="list-style:none;padding:0px;">
											<?php
												$p_sql = $mysqli->query("select * from payment_received_method where transaction_id = '".$id['transaction_id']."'");
												while($pmw = mysqli_fetch_assoc($p_sql)){
													if($pmw['payment_method'] == 'Cash'){
														$amount = '<i class="far fa-money-bill-alt"></i> - <b style="font-size:30px;color: red;">'.money($pmw['cash_amount']).'</b>';
													} else if($pmw['payment_method'] == 'Mobile Banking'){
														$amount = '<i class="fas fa-mobile-alt"></i> - <b style="font-size:30px;">'.money($pmw['mobile_amount']).'</b>';
													} else if($pmw['payment_method'] == 'Credit / Debit Card'){
														$amount = '<i class="far fa-credit-card"></i> - <b style="font-size:30px;">'.money($pmw['card_amount']).'</b>';
													} else if($pmw['payment_method'] == 'Check'){
														$amount = '<i class="fas fa-money-check-alt"></i> - <b style="font-size:30px;">'.money($pmw['check_amount']).'</b>';
													}
													echo '<li>'.$amount.'</li>';
												}
											?>
										</ul>
											<?php } } ?>
									</div>
								</div>
								<div class="col-print-7">
									<div class="title" style="font-size: 45px;font-weight: 600;color: #4fc3f7"><?php if(!empty($id['transaction_id'])){ echo $id['transaction_id']; } ?> </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>

		<style type="text/css">
				#print_area_new .subtotal tbody td { 
					padding: 5px;
					background: #f9eecf;
					color: #777777;
					text-align: right;
					border-bottom: 5px solid #FFFFFF;
					border-right: 4px solid #f3e1d2;
				}
				#print_area_new p{
					margin:0px;
				}
				table {
					border-collapse: collapse; border-spacing: 0;
				}
				caption, th, td {
					text-align: left;
					font-weight: normal;
					vertical-align: middle;
				}
				q, blockquote {
					quotes: none;
				}
				q:before, q:after, blockquote:before, blockquote:after {
					content: "";
					content: none;
				}
				a img {
					border: none;
				}		
				body {
					font-family: 'Source Sans Pro', sans-serif;
					font-weight: 500;
					font-size: 16px;
					margin: 0;
					padding: 0;
				}
				body a {
					text-decoration: none;
					color: inherit;
				}
				body a:hover {
					color: inherit;
					opacity: 0.7;
				}
				body .container {
					min-width: 500px;
					margin: 0 auto;
					padding: 0 20px;
				}
				body .clearfix:after {
					content: "";
					display: table;
					clear: both;
				}
				body .left {
					float: left;
				}
				body .right {
					float: right;
				}
				body .helper {
					display: inline-block;
					height: 100%;
					vertical-align: middle;
				}
				body .no-break {
					page-break-inside: avoid;
				}
				header {
					margin-top: 20px;
				}
				header figure {
					float: left;
					text-align: center;
					margin:0px;
					margin-right: 10px;
				}
				header .company-address {
					float: left;
					max-width: 150px;
					line-height: 1.7em;
					font-weight:bolder;
				}
				header .company-address .title {
					color: #4fc3f7;
					font-weight: bolder;
					font-size: 25px;
					margin-top:0px;
					text-transform: uppercase;
				}
				header .company-contact {
					float: right;
					height: 60px;
					padding: 0 10px;
					background-color: #4fc3f7;
					color: white;
					padding-right:0px;
					font-weight:bolder;
				}
				header .company-contact span {
					display: inline-block;
					vertical-align: middle;
				}
				header .company-contact .circle {
					width: 30px;
					height: 30px;
					background-color: white;
					border-radius: 50%;
					text-align: center;
					margin-right:10px;
				}
				header .company-contact .circle img {
					vertical-align: middle;
				}
				header .company-contact .phone {
					height: 100%;
					margin-right: 20px;
				}
				header .company-contact .email {
					height: 100%;
					min-width: 100px;
					text-align: right;
				}

				section .details {
					margin-bottom: 10px;
				}
				section .details .client {
					width: 50%;
					line-height: 20px;
					font-weight:bolder;
				}
				section .details .client .name {
					color: #8BC34A;
				}
				section .details .data {
					width: 50%;
					text-align: right;
				}
				section .details .title {
					margin-bottom: 15px;
					color: #8BC34A;
					font-size: 20px;
					font-weight: 900;
					text-transform: uppercase;
				}
				
				#print_area_new section table {
					width: 100%;
					border-collapse: collapse;
					border-spacing: 0;
					font-size: 0.9166em;
				}
				#print_area_new section table .qty, section table .unit, section table .total {
					width: 25%;
				}
				#print_area_new section table .desc {
					width: 35%;
				}
				#print_area_new section table thead {
					display: table-header-group;
					vertical-align: middle;
					border-color: inherit;
				}
				#print_area_new section table thead th {
					padding: 5px 10px;
					background: #4fc3f7;
					border-bottom: 5px solid #FFFFFF;
					border-right: 4px solid #FFFFFF;
					text-align: right;
					color: white;
					font-weight: 400;
					text-transform: uppercase;
				}
				#print_area_new section table thead th:last-child {
					border-right: none;
				}
				#print_area_new section table thead .desc {
					text-align: left;
				}
				#print_area_new section table thead .qty {
					text-align: center;
				}
				#print_area_new section .grand-total tbody td {
					padding: 5px;
					background: #f9eecf;
					color: #777777;
					text-align: right;
					border-bottom: 5px solid #FFFFFF;
					border-right: 4px solid #E8F3DB;
				}
				
				#print_area_new section .subtotal tbody td { 
					padding: 5px;
					background: #f9eecf;
					color: #777777;
					text-align: right;
					border-bottom: 5px solid #FFFFFF;
					border-right: 4px solid #f3e1d2;
				}
				
				#print_area_new section table tbody td:last-child {
					border-right: none;
				}
				#print_area_new section table tbody h3 {
					margin-bottom: 5px;
					color: #8BC34A;
					font-weight: 600;
				}
				#print_area_new section table tbody .desc {
					text-align: left;
				}
				#print_area_new section table tbody .qty {
					text-align: center;
				}
				#print_area_new section table.grand-total {
					margin-bottom: 25px;
				}
				#print_area_new section table.grand-total td {
					padding: 5px 10px;
					border: none;
					color: #777777;
					text-align: right;
				}
				#print_area_new section table.grand-total .desc {
					background-color: transparent;
				}
				#print_area_new section table.grand-total tr:last-child td {
					font-weight: 600;
					color: #0277bd;
					font-size: 1.18181818181818em;
				}
				footer {
					margin-bottom: 20px;
				}
				footer .thanks {
					margin-bottom: 15px;
					color: #0277bd;
					font-size: 1.16666666666667em;
					font-weight: 600;
				}
				footer .notice {
					margin-bottom: 15px;
				}
				footer .end-new {
					padding-top: 5px;
					text-align: center;
				}
				.invoice-disclaimer-border{
					border-top: 2px solid #4fc3f7;
					margin-bottom: 5px;
				}
				.booking-form-tag{
					display: grid;
					justify-content: center;
					align-content: center;
					width: 100px;
					height: 100px;
					/* background-color: #4fc3f7; */
				}
				@media print {
					.bottom-page{
						position:absolute;
						bottom:0;
					}
					.bottom-page-cut{
						position:absolute;
						bottom:120px;
					}
				}
			</style>
		</section>
	</div>
</div>

<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>
<script>
    $('#print_button').on("click", function () {
      $('#print_area').printThis({
      });
    });
	$('#print_button_new').on("click", function () {
      $('#print_area_new').printThis({
      });
    });
</script>
<?php } ?>