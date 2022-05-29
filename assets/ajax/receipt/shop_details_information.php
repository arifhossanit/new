<?php 
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['receipt_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from refreshment_item_sell where id = '".$_POST['receipt_id']."'"));
	if(!empty($row['uploader_info'])){
		$opt = explode("___",$row['uploader_info']);
		$rentre = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$opt[1]."'"));
	}
	$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."' or card_number = '".$row['buyer_id']."'"));
	include('../../../application/helpers/qrcode_helper.php');
	$daaata = $home.'member-shopping-information/qr-code/'.$member['booking_id'];
	$file = '../../uploads/qrcode/member_shop_recipt_id_'.$member['booking_id'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2); 
	$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$member['branch_id']."'"));
	$package_cgt = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$member['package_category']."'"));
	$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member['package']."'"));
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
	<div class="card-header">
		<ul class="nav nav-tabs" id="receipt-tab" role="tablist">
			<li class="nav-item"><a class="nav-link active" href="#old_receipt" aria-controls="activity" data-toggle="pill" role="tab" aria-selected="true">Old Receipt</a></li>
			<li class="nav-item"><a class="nav-link" href="#new_receipt" aria-controls="professional" data-toggle="pill" role="tab" aria-selected="false" style="background-color: #d32f2f; color: white">New Receipt</a></li>			
		</ul>		
	</div>
	<div class="card-body">
		<div class="tab-content">
			<div class="tab-pane active" id="old_receipt">
				<div class="col-sm-12" style="margin-bottom:30px;">
					<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
				</div>
				<div style="width:100%;margin-top:30px;float:left;"></div>
				<section id="print_area">

					<header class="clearfix" style="margin-bottom:30px;">
						<div class="container">
							<figure>
								<img class="logo" src="<?php echo $home; ?>assets/img/n_logo.png" alt="" style="width:90px;">
							</figure>
							<div class="company-address">
								<h1 class="title" style="color:#138294;margin-bottom:0px;">SUPER HOME</h1>
								<p style="font-size:18px;"><?php echo $branch_info['branch_name']; ?><br> <?php echo $branch_info['branch_location']; ?> </p>
							</div>
							<div class="company-contact" style="height:80px;">
								<div class="phone left">
									<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjkuNzYycHgiIGhlaWdodD0iOS45NThweCINCgkgdmlld0JveD0iLTQuOTkyIDAuNTE5IDkuNzYyIDkuOTU4IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IC00Ljk5MiAwLjUxOSA5Ljc2MiA5Ljk1OCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMS4wMDAwMDAsIC01NC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJLT05UQUtUSSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjY3LjAwMDAwMCwgMzUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPGcgaWQ9Ik92YWwtMS1feDJCXy1GaWxsLTEiPg0KCQkJCQk8cGF0aCBpZD0iRmlsbC0xIiBmaWxsPSIjOEJDMzRBIiBkPSJNOC43NjUsMTIuMzc1YzAuMDIsMC4xNjItMC4wMjgsMC4zMDMtMC4xNDMsMC40MjJMNy4yNDYsMTQuMTkNCgkJCQkJCWMtMC4wNjIsMC4wNy0wLjE0MywwLjEzMy0wLjI0MywwLjE4MmMtMC4xMDEsMC4wNDktMC4xOTcsMC4wOC0wLjI5NSwwLjA5NGMtMC4wMDcsMC0wLjAyOCwwLTAuMDYyLDAuMDA0DQoJCQkJCQljLTAuMDM0LDAuMDA1LTAuMDgsMC4wMDgtMC4xMzQsMC4wMDhjLTAuMTMxLDAtMC4zNDMtMC4wMjMtMC42MzUtMC4wNjhjLTAuMjkzLTAuMDQ1LTAuNjUxLTAuMTU4LTEuMDc2LTAuMzM2DQoJCQkJCQljLTAuNDI0LTAuMTgyLTAuOTA0LTAuNDUxLTEuNDQyLTAuODA5Yy0wLjUzNi0wLjM1Ny0xLjEwOS0wLjg1Mi0xLjcxNi0xLjQ3OWMtMC40ODEtMC40ODQtMC44OC0wLjk1LTEuMTk4LTEuMzkzDQoJCQkJCQlDMC4xMjgsOS45NS0wLjEyNSw5LjU0MS0wLjMxOSw5LjE2NGMtMC4xOTMtMC4zNzYtMC4zMzgtMC43MTctMC40MzQtMS4wMjNjLTAuMDk3LTAuMzA2LTAuMTYxLTAuNTctMC4xOTUtMC43OTINCgkJCQkJCWMtMC4wMzUtMC4yMjEtMC4wNS0wLjM5NC0wLjA0Mi0wLjUyMWMwLjAwNy0wLjEyNiwwLjAxLTAuMTk3LDAuMDEtMC4yMTFjMC4wMTQtMC4wOTksMC4wNDQtMC4xOTgsMC4wOTMtMC4zMDENCgkJCQkJCWMwLjA0OS0wLjEwMSwwLjEwOC0wLjE4NCwwLjE3Ni0wLjI0N2wxLjM3NS0xLjQwM2MwLjA5Ny0wLjA5OCwwLjIwNi0wLjE0NywwLjMzLTAuMTQ3YzAuMDksMCwwLjE2OSwwLjAyNiwwLjIzOCwwLjA3OQ0KCQkJCQkJQzEuMyw0LjY0OCwxLjM1OSw0LjcxNCwxLjQwNiw0Ljc5MWwxLjEwNiwyLjE0MWMwLjA2MiwwLjExNCwwLjA4LDAuMjM1LDAuMDUyLDAuMzdDMi41MzgsNy40MzYsMi40NzgsNy41NDgsMi4zODksNy42NA0KCQkJCQkJTDEuODgzLDguMTU3QzEuODY5LDguMTcxLDEuODU2LDguMTk0LDEuODQ2LDguMjI2QzEuODM1LDguMjU2LDEuODMsOC4yODMsMS44Myw4LjMwNGMwLjAyNywwLjE0NywwLjA5LDAuMzE3LDAuMTg3LDAuNTA3DQoJCQkJCQljMC4wODIsMC4xNjksMC4yMSwwLjM3NSwwLjM4MiwwLjYxOGMwLjE3MiwwLjI0MywwLjQxNywwLjUyMSwwLjczNCwwLjgzOWMwLjMxMSwwLjMyMiwwLjU4NSwwLjU3NCwwLjgyOCwwLjc1NQ0KCQkJCQkJYzAuMjQsMC4xNzgsMC40NDMsMC4zMDksMC42MDQsMC4zOTVjMC4xNjIsMC4wODUsMC4yODYsMC4xMzUsMC4zNzIsMC4xNTRsMC4xMjgsMC4wMjRjMC4wMTUsMCwwLjAzOC0wLjAwNiwwLjA2Ny0wLjAxNg0KCQkJCQkJYzAuMDMyLTAuMDEsMC4wNTQtMC4wMjEsMC4wNjctMC4wMzdsMC41ODgtMC42MTJjMC4xMjUtMC4xMTIsMC4yNy0wLjE2OCwwLjQzNi0wLjE2OGMwLjExNywwLDAuMjA3LDAuMDIxLDAuMjc3LDAuMDYxaDAuMDENCgkJCQkJCWwxLjk5NSwxLjIwM0M4LjY1MSwxMi4xMiw4LjczNywxMi4yMzQsOC43NjUsMTIuMzc1TDguNzY1LDEyLjM3NXoiLz4NCgkJCQk8L2c+DQoJCQk8L2c+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==" alt=""><span class="helper"></span></span>
									<a href="tel:602-519-0450" style="text-decoration: none;font-size:20px;color:#fff;">(+880) 96386-66333</a>
									<span class="helper"></span>
								</div>
								<div class="email right">
									<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
									<a href="mailto:info@superhomebd.com" style="text-decoration: none;font-size:20px;color:#fff;">info@superhomebd.com</a>
									<span class="helper"></span>
									<span style="width:80px;height:80px;margin-left:10px;">
										<img src="<?php echo $home.'assets/uploads/qrcode/member_shop_recipt_id_'.$member['booking_id'].'.png'; ?>" style="width:81px;float:right;border: 1px #eee solid;" class="image-responsive"/>
									</span>
								</div>
								
							</div>
							<div style="width:100%;float:left;margin-top:20px;">
								<center>
									<h1 style="font-size:3em;font-weight:600;"><u>Purchase Receipt</u></h1>
								</center>
							</div>
						</div>
					</header>

					<section>
						<div class="container">
							<div class="details clearfix">
								<div class="client left" style="font-size:20px;line-height:30px;">
									<p>INVOICE BY:</p>
									<p class="name" style="color:#138294;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
									<!--<a href="mailto:<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'Not provided!'; } ?></a><br />-->
									<!--<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php if(!empty($rentre['personal_Phone'])){ echo $rentre['personal_Phone']; }else{ echo 'Not provided!'; }  ?></a>-->
									<div style="width:100%;margin-top:10px;"></div>
									
									<?php /* ?>			<hr />			
									<p>INVOICE TO:</p>
									<p class="name" style="color:#138294;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $member['full_name']; ?></p>
									<p><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
									<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
									<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
									<p><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $member['bed_name']; ?></strong></p><?php */ ?>
								</div>
								<div class="data right">
									<?php
										$inv = explode('/',$row['data']);
										$invd = $inv[0].$inv[1].$inv[2];
									?>
									<div class="title" style="color:#138294;"> Invoice: #<?php echo $invd.$row['id']; ?> </div>
									<div class="date" style="font-weight:bolder;line-height: 30px;">
										<style>.right_cs_t tr{background-color:none;} .right_cs_t td{font-size:20px;color:#000;background:none;border:none;padding:2px;}</style>
										<table class="table table-sm right_cs_t" style="width:80%;float:right;" border="0" border-spacing="0">
											<tr>
												<td>Date of Invoice</td>
												<td>:</td>
												<td><strong style="font-weight:bolder;"><?php echo $row['data']; ?></strong></td>
											</tr>
											<?php /* ?>
											<tr>
												<td>CheckIn Date</td>
												<td>:</td>
												<td><strong style="font-weight:bolder;"><?php echo $member['check_in_date']; ?></strong></td>
											</tr>
											<tr>
												<td>Card Number</td>
												<td>:</td>
												<td><strong style="font-weight:bolder;"><?php if(!empty($member['card_number'])){ echo $member['card_number']; }else{ echo 'CheckOut'; } ?></strong></td>
											</tr>
											<?php */ ?>
											<?php 
												if($row['payment_status'] == 'Due'){
													$bg = 'btn-danger';
												}else{
													$bg = 'btn-info';
												}
											?>
											<tr>
												<td>Payment Status</td>
												<td>:</td>
												<td>
													<button type="button" class="btn  <?php echo $bg; ?>" style="padding: 0px 13px;">
														<strong style="font-weight:bolder;">
															<?php if($row['payment_status'] == 'Paid'){ echo '<i class="fas fa-check-circle"></i> &nbsp;&nbsp;PAID';}else{ echo '<i class="fas fa-times-circle"></i> &nbsp;&nbsp;DUE'; } ?>
														</strong>
													</button>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>

							<table class="subtotal" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
								<thead>
									<tr>
										<th class="desc" style="color:#000;">Product</th>
										<th class="qty" style="color:#000;">QTY</th>
										<th class="unit" style="color:#000;">Unit price</th>
										<th class="total" style="color:#000;">Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$pql = $mysqli->query("select * from refreshment_item_list where buer_code = '".$row['buying_code']."'");
									$grand_t = 0;
									$ttl = 0;
									while($pow = mysqli_fetch_assoc($pql)){
										$unit_price = mysqli_fetch_assoc($mysqli->query("select * from refreshment_item where code = '".$pow['product_code']."'"));
									$ttl = $pow['amount'];
									?>
									<tr>
										<td class="desc">
											<h3 style="color:#000;"><?php echo $pow['product_name']; ?></h3>
										</td>
										<td class="qty"> <h3 style="color:#000;"><?php echo $pow['qty']; ?></h3> </td>
										<td class="unit" style="color:#000;"><?php if($unit_price['price'] > 0 ){ echo money($unit_price['price']); }else{ echo money($ttl); } ?></td>
										<td class="total" style="color:#000;"><?php echo money($ttl); ?></td>
									</tr>
									<?php 
										$grand_t = $grand_t + $ttl;
									} ?>
								</tbody>
							</table>
							<div class="no-break">
								<table class="grand-total" style="border-collapse: collapse; border-spacing: 0;font-size:20px;">
									<tbody>					
										<tr>
											<td class="desc" style="color:#000;font-size:20px;font-weight:500;text-align:left;"> </td>
											<td class="unit" style="font-size:18px;color:#000;" colspan="2">GRAND TOTAL:</td>
											<td class="total" style="font-size:18px;color:#000;"><?php echo money($grand_t); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</section>

					<footer>
						<div class="container">
							<div class="thanks">Thank you!</div>
							<div class="notice">
								<div>NOTICE:</div>
								<div>Purchase iteams are not returnable!</div>
							</div>
							<div class="end">Invoice was created on a computer and is valid without the signature and seal.</div>
						</div>
					</footer>

				<style type="text/css">
						#print_area p{
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
							margin-bottom: 50px;
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
							color: #8BC34A;
							font-weight: bolder;
							font-size: 25px;
							margin-top:0px;
							text-transform: uppercase;
						}
						header .company-contact {
							float: right;
							height: 60px;
							padding: 0 10px;
							background-color: #17a2b8;
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
						
						#print_area section table {
							width: 100%;
							border-collapse: collapse;
							border-spacing: 0;
							font-size: 0.9166em;
						}
						#print_area section table .qty, section table .unit, section table .total {
							width: 25%;
						}
						#print_area section table .desc {
							width: 35%;
						}
						#print_area section table thead {
							display: table-header-group;
							vertical-align: middle;
							border-color: inherit;
						}
						#print_area section table thead th {
							padding: 5px 10px;
							background: #4ab6c7;
							border-bottom: 5px solid #FFFFFF;
							border-right: 4px solid #FFFFFF;
							text-align: right;
							color: white;
							font-weight: 400;
							text-transform: uppercase;
						}
						#print_area section table thead th:last-child {
							border-right: none;
						}
						#print_area section table thead .desc {
							text-align: left;
						}
						#print_area section table thead .qty {
							text-align: center;
						}
						#print_area section .grand-total tbody td {
							padding: 5px;
							background: #e0f5f9;
							color: #777777;
							text-align: right;
							border-bottom: 5px solid #FFFFFF;
							border-right: 4px solid #d4eaef;
						}
						
						#print_area section .subtotal tbody td { 
							padding: 5px;
							background: #e0f5f9;
							color: #777777;
							text-align: right;
							border-bottom: 5px solid #FFFFFF;
							border-right: 4px solid #d4eaef;
						}
						
						#print_area section table tbody td:last-child {
							border-right: none;
						}
						#print_area section table tbody h3 {
							margin-bottom: 5px;
							color: #8BC34A;
							font-weight: 600;
						}
						#print_area section table tbody .desc {
							text-align: left;
						}
						#print_area section table tbody .qty {
							text-align: center;
						}
						#print_area section table.grand-total {
							margin-bottom: 45px;
						}
						#print_area section table.grand-total td {
							padding: 5px 10px;
							border: none;
							color: #777777;
							text-align: right;
						}
						#print_area section table.grand-total .desc {
							background-color: transparent;
						}
						#print_area section table.grand-total tr:last-child td {
							font-weight: 600;
							color: #8BC34A;
							font-size: 1.18181818181818em;
						}
						
						
						

						footer {
							margin-bottom: 20px;
						}
						footer .thanks {
							margin-bottom: 40px;
							color: #4ab6c7;
							font-size: 1.16666666666667em;
							font-weight: 600;
						}
						footer .notice {
							margin-bottom: 25px;
						}
						footer .end {
							padding-top: 5px;
							border-top: 2px solid #4ab6c7;
							text-align: center;
						}
					</style>

				</section>
			</div>
			<div class="tab-pane" id="new_receipt">
				<div class="col-sm-12" style="margin-bottom:30px;">
					<button type="button" id="print_button_new" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
				</div>
				<div style="width:100%;margin-top:30px;float:left;"></div>
				<section id="print_area_new">

					<header class="clearfix" style="margin-bottom:30px;">
						<div class="container">
							<figure>
								<img class="logo" src="<?php echo $home; ?>assets/img/n_logo.png" alt="" style="width:90px;">
							</figure>
							<div class="company-address">
								<h1 class="title" style="color:#138294;margin-bottom:0px;">SUPER HOME</h1>
								<p style="font-size:18px;"><?php echo $branch_info['branch_name']; ?><br> <?php echo $branch_info['branch_location']; ?> </p>
							</div>
							<div class="company-contact" style="height:80px;">
								<div class="phone left">
									<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjkuNzYycHgiIGhlaWdodD0iOS45NThweCINCgkgdmlld0JveD0iLTQuOTkyIDAuNTE5IDkuNzYyIDkuOTU4IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IC00Ljk5MiAwLjUxOSA5Ljc2MiA5Ljk1OCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMS4wMDAwMDAsIC01NC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJLT05UQUtUSSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjY3LjAwMDAwMCwgMzUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPGcgaWQ9Ik92YWwtMS1feDJCXy1GaWxsLTEiPg0KCQkJCQk8cGF0aCBpZD0iRmlsbC0xIiBmaWxsPSIjOEJDMzRBIiBkPSJNOC43NjUsMTIuMzc1YzAuMDIsMC4xNjItMC4wMjgsMC4zMDMtMC4xNDMsMC40MjJMNy4yNDYsMTQuMTkNCgkJCQkJCWMtMC4wNjIsMC4wNy0wLjE0MywwLjEzMy0wLjI0MywwLjE4MmMtMC4xMDEsMC4wNDktMC4xOTcsMC4wOC0wLjI5NSwwLjA5NGMtMC4wMDcsMC0wLjAyOCwwLTAuMDYyLDAuMDA0DQoJCQkJCQljLTAuMDM0LDAuMDA1LTAuMDgsMC4wMDgtMC4xMzQsMC4wMDhjLTAuMTMxLDAtMC4zNDMtMC4wMjMtMC42MzUtMC4wNjhjLTAuMjkzLTAuMDQ1LTAuNjUxLTAuMTU4LTEuMDc2LTAuMzM2DQoJCQkJCQljLTAuNDI0LTAuMTgyLTAuOTA0LTAuNDUxLTEuNDQyLTAuODA5Yy0wLjUzNi0wLjM1Ny0xLjEwOS0wLjg1Mi0xLjcxNi0xLjQ3OWMtMC40ODEtMC40ODQtMC44OC0wLjk1LTEuMTk4LTEuMzkzDQoJCQkJCQlDMC4xMjgsOS45NS0wLjEyNSw5LjU0MS0wLjMxOSw5LjE2NGMtMC4xOTMtMC4zNzYtMC4zMzgtMC43MTctMC40MzQtMS4wMjNjLTAuMDk3LTAuMzA2LTAuMTYxLTAuNTctMC4xOTUtMC43OTINCgkJCQkJCWMtMC4wMzUtMC4yMjEtMC4wNS0wLjM5NC0wLjA0Mi0wLjUyMWMwLjAwNy0wLjEyNiwwLjAxLTAuMTk3LDAuMDEtMC4yMTFjMC4wMTQtMC4wOTksMC4wNDQtMC4xOTgsMC4wOTMtMC4zMDENCgkJCQkJCWMwLjA0OS0wLjEwMSwwLjEwOC0wLjE4NCwwLjE3Ni0wLjI0N2wxLjM3NS0xLjQwM2MwLjA5Ny0wLjA5OCwwLjIwNi0wLjE0NywwLjMzLTAuMTQ3YzAuMDksMCwwLjE2OSwwLjAyNiwwLjIzOCwwLjA3OQ0KCQkJCQkJQzEuMyw0LjY0OCwxLjM1OSw0LjcxNCwxLjQwNiw0Ljc5MWwxLjEwNiwyLjE0MWMwLjA2MiwwLjExNCwwLjA4LDAuMjM1LDAuMDUyLDAuMzdDMi41MzgsNy40MzYsMi40NzgsNy41NDgsMi4zODksNy42NA0KCQkJCQkJTDEuODgzLDguMTU3QzEuODY5LDguMTcxLDEuODU2LDguMTk0LDEuODQ2LDguMjI2QzEuODM1LDguMjU2LDEuODMsOC4yODMsMS44Myw4LjMwNGMwLjAyNywwLjE0NywwLjA5LDAuMzE3LDAuMTg3LDAuNTA3DQoJCQkJCQljMC4wODIsMC4xNjksMC4yMSwwLjM3NSwwLjM4MiwwLjYxOGMwLjE3MiwwLjI0MywwLjQxNywwLjUyMSwwLjczNCwwLjgzOWMwLjMxMSwwLjMyMiwwLjU4NSwwLjU3NCwwLjgyOCwwLjc1NQ0KCQkJCQkJYzAuMjQsMC4xNzgsMC40NDMsMC4zMDksMC42MDQsMC4zOTVjMC4xNjIsMC4wODUsMC4yODYsMC4xMzUsMC4zNzIsMC4xNTRsMC4xMjgsMC4wMjRjMC4wMTUsMCwwLjAzOC0wLjAwNiwwLjA2Ny0wLjAxNg0KCQkJCQkJYzAuMDMyLTAuMDEsMC4wNTQtMC4wMjEsMC4wNjctMC4wMzdsMC41ODgtMC42MTJjMC4xMjUtMC4xMTIsMC4yNy0wLjE2OCwwLjQzNi0wLjE2OGMwLjExNywwLDAuMjA3LDAuMDIxLDAuMjc3LDAuMDYxaDAuMDENCgkJCQkJCWwxLjk5NSwxLjIwM0M4LjY1MSwxMi4xMiw4LjczNywxMi4yMzQsOC43NjUsMTIuMzc1TDguNzY1LDEyLjM3NXoiLz4NCgkJCQk8L2c+DQoJCQk8L2c+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==" alt=""><span class="helper"></span></span>
									<a href="tel:602-519-0450" style="text-decoration: none;font-size:20px;color:#fff;">(+880) 96386-66333</a>
									<span class="helper"></span>
								</div>
								<div class="email right">
									<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
									<a href="mailto:info@superhomebd.com" style="text-decoration: none;font-size:20px;color:#fff;">info@superhomebd.com</a>
									<span class="helper"></span>
									<span style="width:80px;height:80px;margin-left:10px;">
										<img src="<?php echo $home.'assets/uploads/qrcode/member_shop_recipt_id_'.$member['booking_id'].'.png'; ?>" style="width:81px;float:right;border: 1px #eee solid;" class="image-responsive"/>
									</span>
								</div>
								
							</div>
							<div style="width:100%;float:left;margin-top:20px;">
								<center>
									<h1 style="font-size:3em;font-weight:600;"><u>Purchase Receipt</u></h1>
								</center>
							</div>
						</div>
					</header>

					<section>
						<div class="container">
							<div class="details clearfix">
								<div class="client left" style="font-size:20px;line-height:30px;">
									<p>INVOICE BY:</p>
									<p class="name" style="color:#138294;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
									<!--<a href="mailto:<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'Not provided!'; } ?></a><br />-->
									<!--<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php if(!empty($rentre['personal_Phone'])){ echo $rentre['personal_Phone']; }else{ echo 'Not provided!'; }  ?></a>-->
									<div style="width:100%;margin-top:10px;"></div>
									
									<?php /* ?>			<hr />			
									<p>INVOICE TO:</p>
									<p class="name" style="color:#138294;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $member['full_name']; ?></p>
									<p><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
									<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
									<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
									<p><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $member['bed_name']; ?></strong></p><?php */ ?>
								</div>
								<div class="data right">
									<?php
										$inv = explode('/',$row['data']);
										$invd = $inv[0].$inv[1].$inv[2];
									?>
									<div class="title" style="color:#138294;"> Invoice: #<?php echo $invd.$row['id']; ?> </div>
									<div class="date" style="font-weight:bolder;line-height: 30px;">
										<style>.right_cs_t tr{background-color:none;} .right_cs_t td{font-size:20px;color:#000;background:none;border:none;padding:2px;}</style>
										<table class="table table-sm right_cs_t" style="width:80%;float:right;" border="0" border-spacing="0">
											<tr>
												<td>Date of Invoice</td>
												<td>:</td>
												<td><strong style="font-weight:bolder;"><?php echo $row['data']; ?></strong></td>
											</tr>
											<?php /* ?>
											<tr>
												<td>CheckIn Date</td>
												<td>:</td>
												<td><strong style="font-weight:bolder;"><?php echo $member['check_in_date']; ?></strong></td>
											</tr>
											<tr>
												<td>Card Number</td>
												<td>:</td>
												<td><strong style="font-weight:bolder;"><?php if(!empty($member['card_number'])){ echo $member['card_number']; }else{ echo 'CheckOut'; } ?></strong></td>
											</tr>
											<?php */ ?>
											<?php 
												if($row['payment_status'] == 'Due'){
													$bg = 'btn-danger';
												}else{
													$bg = 'btn-info';
												}
											?>
											<tr>
												<td>Payment Status</td>
												<td>:</td>
												<td>
													<button type="button" class="btn  <?php echo $bg; ?>" style="padding: 0px 13px;">
														<strong style="font-weight:bolder;">
															<?php if($row['payment_status'] == 'Paid'){ echo '<i class="fas fa-check-circle"></i> &nbsp;&nbsp;PAID';}else{ echo '<i class="fas fa-times-circle"></i> &nbsp;&nbsp;DUE'; } ?>
														</strong>
													</button>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>

							<table class="subtotal" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
								<thead>
									<tr>
										<th class="desc" style="color:#000;">Product</th>
										<th class="qty" style="color:#000;">QTY</th>
										<th class="unit" style="color:#000;">Unit price</th>
										<th class="total" style="color:#000;">Total</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$pql = $mysqli->query("select * from refreshment_item_list where buer_code = '".$row['buying_code']."'");
									$grand_t = 0;
									$ttl = 0;
									while($pow = mysqli_fetch_assoc($pql)){
										$unit_price = mysqli_fetch_assoc($mysqli->query("select * from refreshment_item where code = '".$pow['product_code']."'"));
									$ttl = $pow['amount'];
									?>
									<tr>
										<td class="desc">
											<h3 style="color:#000;"><?php echo $pow['product_name']; ?></h3>
										</td>
										<td class="qty"> <h3 style="color:#000;"><?php echo $pow['qty']; ?></h3> </td>
										<td class="unit" style="color:#000;"><?php if($unit_price['price'] > 0 ){ echo money($unit_price['price']); }else{ echo money($ttl); } ?></td>
										<td class="total" style="color:#000;"><?php echo money($ttl); ?></td>
									</tr>
									<?php 
										$grand_t = $grand_t + $ttl;
									} ?>
								</tbody>
							</table>
							<div class="no-break">
								<table class="grand-total" style="border-collapse: collapse; border-spacing: 0;font-size:20px;">
									<tbody>					
										<tr>
											<td class="desc" style="color:#000;font-size:20px;font-weight:500;text-align:left;"> </td>
											<td class="unit" style="font-size:18px;color:#000;" colspan="2">GRAND TOTAL:</td>
											<td class="total" style="font-size:18px;color:#000;"><?php echo money($grand_t); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</section>

					<footer>
						<div class="container">
							<div class="thanks">Thank you!</div>
							<div class="notice">
								<div>NOTICE:</div>
								<div>Purchase iteams are not returnable!</div>
							</div>
							<div class="end-new">
								<div> <!-- redundent div for printing -->
									<div style="margin-bottom: 10px;">
										<div class="row text-center">
											<div class="col-sm invoice-disclaimer-border">
												<p>Invoice was created on a computer and is valid without the signature and seal.</p>
											</div>
										</div>										
									</div>
									<div style="margin-top: 45px; width:100%" class="row justify-content-start text-start bottom-page-cut">
										<!-- <i class="fas fa-cut"></i> -->
										<div class="col-sm">
										</div>
									</div>
									<div style="width:95%;right:5%;" class="row justify-content-between bottom-page">
										<div class="col-print-1">
											<div>
												<div class="booking-form-tag">
													<img src="<?php echo $home.'assets/uploads/qrcode/member_shop_recipt_id_'.$member['booking_id'].'.png'; ?>" style="width:100px;float:right;border: 1px #eee solid;" class="image-responsive"/>
												</div>
											</div>
										</div>
										<div class="col-print-3">
											<div style="font-size: 25px; font-weight: 500;">
												GRAND TOTAL: <br> <b><?php echo money($grand_t); ?></b>
											</div>
										</div>
										<div class="col-print-7">
											<div class="title" style="color:#138294; font-size: 45px;font-weight: 600;"> Invoice: #<?php echo $invd.$row['id']; ?> </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</footer>

				<style type="text/css">
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
							margin-bottom: 50px;
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
							color: #8BC34A;
							font-weight: bolder;
							font-size: 25px;
							margin-top:0px;
							text-transform: uppercase;
						}
						header .company-contact {
							float: right;
							height: 60px;
							padding: 0 10px;
							background-color: #17a2b8;
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
							background: #4ab6c7;
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
							background: #e0f5f9;
							color: #777777;
							text-align: right;
							border-bottom: 5px solid #FFFFFF;
							border-right: 4px solid #d4eaef;
						}
						
						#print_area_new section .subtotal tbody td { 
							padding: 5px;
							background: #e0f5f9;
							color: #777777;
							text-align: right;
							border-bottom: 5px solid #FFFFFF;
							border-right: 4px solid #d4eaef;
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
							margin-bottom: 45px;
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
							color: #8BC34A;
							font-size: 1.18181818181818em;
						}
						
						
						

						footer {
							margin-bottom: 20px;
						}
						footer .thanks {
							margin-bottom: 40px;
							color: #4ab6c7;
							font-size: 1.16666666666667em;
							font-weight: 600;
						}
						footer .notice {
							margin-bottom: 25px;
						}
						footer .end-new {
							padding-top: 5px;
							text-align: center;
						}
						.invoice-disclaimer-border{
							border-top: 2px solid #4ab6c7;
							margin-bottom: 5px;
						}
						.booking-form-tag{
							display: grid;
							justify-content: center;
							align-content: center;
							width: 100px;
							height: 100px;
							/* background-color: #4ab6c7; */
							bottom: 0;
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