<?php 
error_reporting(0);
include("../../application/config/ajax_config.php");
if(isset($_POST['book_id'])){
$rowir = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$_POST['book_id']."'"));
$row = mysqli_fetch_assoc($mysqli->query("select * from booking_receipt_logs where booking_id = '".$rowir['booking_id']."'"));
$rent = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' order by id ASC"));
$opt = explode("___",$row['uploader_info']);
$rentre = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$opt[1]."'"));
$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."'"));
$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch_id']."'"));
$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));
include('../../application/helpers/qrcode_helper.php');
$daaata = $home.'member-booking-information/qr-code/'.$row['booking_id'];
$file = '../uploads/qrcode/booking_recipt_id_'.$row['booking_id'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2);
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
	.rotate_copy{
		transform: rotate(
		-45deg
		);
			width: 200px;
			margin-top: -42px;
			margin-left: 204px;
			font-weight: bold;
			font-size: 40px;
	}
</style>
<div class="card lg-light">
	<!-- <div class="card-header">
			<ul class="nav nav-tabs" id="receipt-tab" role="tablist">
					<li class="nav-item"><a class="nav-link active" href="#old_receipt" aria-controls="activity" data-toggle="pill" role="tab" aria-selected="true">Old Receipt</a></li>
					<li class="nav-item"><a class="nav-link" href="#new_receipt" aria-controls="professional" data-toggle="pill" role="tab" aria-selected="false" style="background-color: #d32f2f; color: white">New Receipt</a></li>			
			</ul>
	</div> -->
	<div class="card-body">
		<div class="col-sm-12" style="margin-bottom:30px;">
			<button type="button" id="print_button_new" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
		</div>
		<div style="width:100%;margin-top:30px;float:left;"></div>
		<div class="row"  id="print-area">
           

		<div class="tab-content">
			<div class="tab-pane" id="old_receipt">			  
			
				
				<section id="print_area_new">
					<header class="clearfix" style="margin-bottom:30px;">
						<div class="container">
							<figure>
								<img class="logo" src="<?php echo $home; ?>assets/img/n_logo.png" alt="" style="width:90px;">
							</figure>
							<div class="company-address">
								<h1 class="title" style="color:green;">SUPER HOME</h1>
								<p style="font-size:18px;"><?php echo $branch_info['branch_name']; ?><br> <?php echo $branch_info['branch_location']; ?> </p>
							</div>
							<div class="company-contact" style="height:80px;">
								<div class="phone left">
									<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjkuNzYycHgiIGhlaWdodD0iOS45NThweCINCgkgdmlld0JveD0iLTQuOTkyIDAuNTE5IDkuNzYyIDkuOTU4IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IC00Ljk5MiAwLjUxOSA5Ljc2MiA5Ljk1OCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMS4wMDAwMDAsIC01NC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJLT05UQUtUSSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjY3LjAwMDAwMCwgMzUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPGcgaWQ9Ik92YWwtMS1feDJCXy1GaWxsLTEiPg0KCQkJCQk8cGF0aCBpZD0iRmlsbC0xIiBmaWxsPSIjOEJDMzRBIiBkPSJNOC43NjUsMTIuMzc1YzAuMDIsMC4xNjItMC4wMjgsMC4zMDMtMC4xNDMsMC40MjJMNy4yNDYsMTQuMTkNCgkJCQkJCWMtMC4wNjIsMC4wNy0wLjE0MywwLjEzMy0wLjI0MywwLjE4MmMtMC4xMDEsMC4wNDktMC4xOTcsMC4wOC0wLjI5NSwwLjA5NGMtMC4wMDcsMC0wLjAyOCwwLTAuMDYyLDAuMDA0DQoJCQkJCQljLTAuMDM0LDAuMDA1LTAuMDgsMC4wMDgtMC4xMzQsMC4wMDhjLTAuMTMxLDAtMC4zNDMtMC4wMjMtMC42MzUtMC4wNjhjLTAuMjkzLTAuMDQ1LTAuNjUxLTAuMTU4LTEuMDc2LTAuMzM2DQoJCQkJCQljLTAuNDI0LTAuMTgyLTAuOTA0LTAuNDUxLTEuNDQyLTAuODA5Yy0wLjUzNi0wLjM1Ny0xLjEwOS0wLjg1Mi0xLjcxNi0xLjQ3OWMtMC40ODEtMC40ODQtMC44OC0wLjk1LTEuMTk4LTEuMzkzDQoJCQkJCQlDMC4xMjgsOS45NS0wLjEyNSw5LjU0MS0wLjMxOSw5LjE2NGMtMC4xOTMtMC4zNzYtMC4zMzgtMC43MTctMC40MzQtMS4wMjNjLTAuMDk3LTAuMzA2LTAuMTYxLTAuNTctMC4xOTUtMC43OTINCgkJCQkJCWMtMC4wMzUtMC4yMjEtMC4wNS0wLjM5NC0wLjA0Mi0wLjUyMWMwLjAwNy0wLjEyNiwwLjAxLTAuMTk3LDAuMDEtMC4yMTFjMC4wMTQtMC4wOTksMC4wNDQtMC4xOTgsMC4wOTMtMC4zMDENCgkJCQkJCWMwLjA0OS0wLjEwMSwwLjEwOC0wLjE4NCwwLjE3Ni0wLjI0N2wxLjM3NS0xLjQwM2MwLjA5Ny0wLjA5OCwwLjIwNi0wLjE0NywwLjMzLTAuMTQ3YzAuMDksMCwwLjE2OSwwLjAyNiwwLjIzOCwwLjA3OQ0KCQkJCQkJQzEuMyw0LjY0OCwxLjM1OSw0LjcxNCwxLjQwNiw0Ljc5MWwxLjEwNiwyLjE0MWMwLjA2MiwwLjExNCwwLjA4LDAuMjM1LDAuMDUyLDAuMzdDMi41MzgsNy40MzYsMi40NzgsNy41NDgsMi4zODksNy42NA0KCQkJCQkJTDEuODgzLDguMTU3QzEuODY5LDguMTcxLDEuODU2LDguMTk0LDEuODQ2LDguMjI2QzEuODM1LDguMjU2LDEuODMsOC4yODMsMS44Myw4LjMwNGMwLjAyNywwLjE0NywwLjA5LDAuMzE3LDAuMTg3LDAuNTA3DQoJCQkJCQljMC4wODIsMC4xNjksMC4yMSwwLjM3NSwwLjM4MiwwLjYxOGMwLjE3MiwwLjI0MywwLjQxNywwLjUyMSwwLjczNCwwLjgzOWMwLjMxMSwwLjMyMiwwLjU4NSwwLjU3NCwwLjgyOCwwLjc1NQ0KCQkJCQkJYzAuMjQsMC4xNzgsMC40NDMsMC4zMDksMC42MDQsMC4zOTVjMC4xNjIsMC4wODUsMC4yODYsMC4xMzUsMC4zNzIsMC4xNTRsMC4xMjgsMC4wMjRjMC4wMTUsMCwwLjAzOC0wLjAwNiwwLjA2Ny0wLjAxNg0KCQkJCQkJYzAuMDMyLTAuMDEsMC4wNTQtMC4wMjEsMC4wNjctMC4wMzdsMC41ODgtMC42MTJjMC4xMjUtMC4xMTIsMC4yNy0wLjE2OCwwLjQzNi0wLjE2OGMwLjExNywwLDAuMjA3LDAuMDIxLDAuMjc3LDAuMDYxaDAuMDENCgkJCQkJCWwxLjk5NSwxLjIwM0M4LjY1MSwxMi4xMiw4LjczNywxMi4yMzQsOC43NjUsMTIuMzc1TDguNzY1LDEyLjM3NXoiLz4NCgkJCQk8L2c+DQoJCQk8L2c+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==" alt=""><span class="helper"></span></span>
									<a href="tel:602-519-0450" style="text-decoration: none;font-size:20px;color:#000;">(+880) 96386-66333</a>
									<span class="helper"></span>
								</div>
								<div class="email right">
									<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
									<a href="mailto:info@superhomebd.com" style="text-decoration: none;font-size:20px;color:#000;">info@superhomebd.com</a>
									<span class="helper"></span>
									<span style="width:80px;height:80px;margin-left:10px;">
										<img src="<?php echo $home.'assets/uploads/qrcode/booking_recipt_id_'.$row['booking_id'].'.png'; ?>" style="width:81px;float:right;border: 1px #eee solid;" class="image-responsive"/>
									</span>
								</div>				
							</div>
							<div style="width:100%;float:left;margin-top:20px;">
								<center>
									<h1 style="font-size:3em;font-weight:600;"><u>Booking Receipt</u></h1>
								
								</center>
							</div>
						</div>
					</header>
					
					<section>							
						<div class="container">
							<div class="details clearfix">
								<div class="client left" style="font-size:20px;line-height:30px;">
									<p>INVOICE BY:</p>
									<p class="name" style="color:green;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
									<!--<a href="mailto:<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'Not provided!'; } ?></a><br />-->
									<!--<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php if(!empty($rentre['personal_Phone'])){ echo $rentre['personal_Phone']; }else{ echo 'Not provided!'; }  ?></a>-->
									<div style="width:100%;margin-top:10px;"></div>
									<hr />					
									<p>INVOICE TO:</p>
									<p class="name" style="color:green;font-weight:bolder;margin: 0px;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $row['m_name']; ?></p>
									<p style="margin: 0px;"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
									<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
									<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
									<p style="margin: 0px;"><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $row['bed_name']; ?></strong></p>
								</div>
								<div class="data right">
									<?php
										$inv = explode('/',$row['data']);
										$invd = $inv[0].$inv[1].$inv[2];
										$id = mysqli_fetch_assoc($mysqli->query("select * from transaction where booking_id = '".$row['booking_id']."' and data = '".$row['data']."' and note = 'Booking Money Collection'"));
									?>
									<div class="title" style="color:#000;font-size:35px;"><?php echo $id['transaction_id']; ?> </div>
									<div class="date" style="font-weight:bolder;line-height: 30px;">
										<style>.right_cs_t tr{background-color:none;} .right_cs_t td{font-size:20px;color:#000;background:none;border:none;padding:2px;}</style>
										<table class="table table-sm right_cs_t" style="width:80%;float:right;" border="0" border-spacing="0">
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
							</div>

							<table class="sub-total" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
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
											<h3 style="color:#000;"> Security Money </h3>							
										</td>
										<td class="qty"> <h3 style="color:#000;"><?php echo $row['package_category_name']; ?></h3> </td>
										<td class="unit" style="color:#000;">
											<?php												
												if($package['aggreement'] == 1){
													$sd_m = 1000;
												}else{
													$sd_m = $row['security_deposit'];
												} 
												echo money($sd_m);																				
											?>
										</td>
										<td class="total" style="color:#000;"><?php echo money($sd_m); ?></td>
									</tr>
									<?php
										if($package['aggreement'] == 1){
									?>
									
									<tr>
										<td class="desc">
											<h3 style="color:#000;"> Adjustable Money</h3>
										</td>
										<td class="qty"> <h3 style="color:#000;"><?php echo $row['package_name']; ?></h3> </td>
										<td class="unit" style="color:#000;">
											<?php 
												echo money(1000); 
											?>
										</td>
										<td class="total" style="color:#000;">
											<?php 
												echo money($package['package_price'] - 1000); 
											?>
										</td>
									</tr>
									<?php 
										$sd_m = $sd_m + $package['package_price'] - 1000;
										$r_pk_name = '';
									}else{
										$r_pk_name = $row['package_name'];
									}
									?>
									<?php 
										if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid' AND $rent['note'] == 'booking'){
									?>									
									<tr>
										<td class="desc">
											<h3 style="color:#000;"> Rent </h3>
										</td>
										<td class="qty"> <h3 style="color:#000;"><?php echo $r_pk_name; ?></h3> </td>
										<td class="unit" style="color:#000;">
											<?php 
											if($package['aggreement'] == 1){
												echo money($row['rent_amount'] + 1000);
											}else{
												echo money($row['rent_amount']);
											} 
											?>
										</td>
										<td class="total" style="color:#000;">
											<?php 
											if($package['aggreement'] == 1){
												echo money($row['rent_amount'] + 1000);
											}else{
												echo money($row['rent_amount']);
											} 
											?>
										</td>
									</tr>
									
									<?php if((float)$rent['parking'] > 0 ){ ?>
									<tr>
										<td class="desc">
											<h3 style="color:#000;"> Parking </h3>
										</td>
										<td class="qty"> <h3 style="color:#000;">----</h3> </td>
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
											<h3 style="color:#000;"> Locker </h3>
										</td>
										<td class="qty"> <h3 style="color:#000;">----</h3> </td>
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
										if($package['aggreement'] == 1){
											$rent1 =  $row['rent_amount'] + 1000;
										}else{
											$rent1 =  $row['rent_amount'];
										} 
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
							<div class="no-break">
								<table class="grand-total" style="border-collapse: collapse; border-spacing: 0;font-size:20px;">
									<tbody>
										<?php 
										if(!empty($row['card_p_amount']) AND $row['card_p_amount'] > 0){
										?>
										<tr>
											<td class="desc" style="text-align:left;color:#000;"> 
											
											</td>
											<td class="qty"></td>
											<td class="unit" style="color:#000;">Card Charge:</td>
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
											<td class="qty"></td>
											<td class="unit" style="color:#000;">SUBTOTAL:</td>
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
											<td class="qty"></td>
											<td class="unit" style="color:#000;">Cash Back:</td>
											<td class="total">
												<?php								
												if($discount_show == '1'){	
													$td = explode('/',$rent['data']);
													$dis_check = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'")); // and month like '%".date($td[1])."%' and year LIKE '%".date($td[2])."%'
													if(!empty($dis_check['amount'])){
														if(!empty($rent['id'])){
															if($row['discount_pattern'] == 'YES'){
																echo money(0);
																$dis_mnt = 0;
															}else if($row['discount_pattern'] == 'A' OR $row['discount_pattern'] == 'B'){
																if($rent['payment_pattern'] == 0 AND $row['discount_pattern'] == 'A'){
																	echo money($dis_check['amount'] / 2);
																	$dis_mnt = $dis_check['amount'] / 2;
																}else if($row['discount_pattern'] == 'B'){
																	echo money($dis_check['amount']);
																	$dis_mnt = $dis_check['amount'];
																}else{
																	echo money(0);
																	$dis_mnt = 0;
																}
															}else{
																if($rent['payment_pattern'] == 0){
																	echo money($dis_check['amount'] / 2);
																	$dis_mnt = $dis_check['amount'] / 2;
																}else{
																	echo money($dis_check['amount']);
																	$dis_mnt = $dis_check['amount'];
																}
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
										<?php if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid'){ if($package['aggreement'] == 1){ ?>
										<tr>
											<td class="desc" style="text-align:left;color:#000;"> </td>
											<td class="qty"></td>
											<td class="unit" style="color:#000;">Diposit Adjust:</td>
											<td class="total">
												<?php echo money(1000); $diposit_back = 1000;?>
											</td>
										</tr>					
										<?php }else{ $diposit_back = 0;} }else{ $diposit_back = 0; } ?>
										
										<tr>
											<td class="desc" style="color:#000;font-size:20px;font-weight:500;text-align:left;">
												<?php /* ?>Payment Method: <strong style="font-weight:bolder;"><?php echo rtrim($row['payment_method'],','); ?></strong><?php */ ?>
											</td>
											<td class="qty"></td>
											<td class="unit" style="font-size:18px;color:#000;">GRAND TOTAL:</td> <!-- colspan="2"-->
											<?php
												$grand_t = (float)$total_amount - (float)$dis_mnt - $diposit_back; 
											?>
											<td class="total" style="font-size:18px;color:#000;"><?php echo money($grand_t); ?></td>
										</tr>
									</tbody>
								</table>
								<div style="width:100%;float:left;color: #000; font-size: 35px; font-weight: 500;">
									<div style="float:left;width:45%;">
										<?php
											$che_payment = mysqli_fetch_assoc($mysqli->query("select * from payment_received_method where transaction_id = '".$id['transaction_id']."'"));
											if(!empty($che_payment['transaction_id'])){
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
									<div style="float:left;width:55%;">
										<?php				
											$dis_checki = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'"));
											if(!empty($dis_checki['amount']) AND $dis_checki['amount'] > 0){ ?>
											<span style="float:right; width:100%;">
												<strong style="font-weight:bolder;color:green;font-size: 20px;">Congratulation! You get cashback <span style="color:#f00;"><?php echo money($dis_checki['amount']); ?></span> at 1st Rent</strong>							
											</span>
										<?php } ?>
										<?php if($package['aggreement'] == 1){ if($rent1 > 0){ ?>											
											<span style="float:right; width:100%;">
												<strong style="font-weight:bolder;color:green;font-size: 20px;">You get 1st Deposit Adjust <span style="color:#f00;"><?php echo money(1000); ?></span> at 1st Rent</strong>							
											</span>
										<?php } } ?>
									</div>					
								</div>
							</div>
						</div>
					</section>

					<footer>
						<div class="container">
							<div class="thanks">
								Thank you!								
							</div>
							<div class="notice">
								<?php if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid' AND $rent['note'] == 'booking'){ ?>
									<div>NOTICE: 
										<?php
											if($rent['payment_pattern'] == 0){						
											$bk_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM booking_info WHERE booking_id = '".$rent['booking_id']."'"));
											if($package['try_us'] == 1){
												if($bk_info['available_days'] > 0){
													$set_checkOut = date('d/m/Y', strtotime(date('Y-m-d'). ' + '.(int)$bk_info['available_days'].' days'));
												}else{
													$get_date = explode('/',$bk_info['checkin_date']);
													$cin_date = $get_date[2].'-'.$get_date[1].'-'.$get_date[0];
													$set_checkOut = date('d/m/Y', strtotime($cin_date. ' + 15 days'));
													//$set_checkOut = '25/'.date('m/y');
												}
											}else{
												$set_checkOut = '25/'.date('m/y');
											}
											
										?>
										<div><b>Please Pay the 2nd Installment before <span class="badge badge-secondary" style="font-size:18px;"><?php echo $set_checkOut; ?></span> ,Otherwise Your seat will be auto cancel.</b></div>
										<?php } ?>
									</div>
								<?php } ?>
								<div>A finance per day charge of BDT 100/- will be made on unpaid rent after 10 days & New CheckIn after 5 Days.</div>
								<?php if($package['aggreement'] == 1){ ?>
								<div style="color:#f00;"><b>Tearms:</b> If break the Contract, Adjustable Money Not Refundable!</div>	
								<?php } ?>
							</div>
							<div class="end-new">
								<div> <!-- redundent div for printing -->
									<div>
										<div class="row text-center">
											<div class="col-sm invoice-disclaimer-border">
												<p>Invoice was created on a computer and is valid without the signature and seal.</p>
											</div>
										</div>
									</div>
									<div style="margin-top: 10px; width:100%" class="row bottom-page-cut">
										<!-- <i class="fas fa-cut"></i> -->
										<div class="col-sm">
										</div>
									</div>
									<div style="width:95%;right:5%;" class="row justify-content-between bottom-page">
										<div class="col-print-1" style="margin-top: 10px;">
											<div>
												<div class="booking-form-tag ">
													<img src="<?php echo $home.'assets/uploads/qrcode/booking_recipt_id_'.$row['booking_id'].'.png'; ?>" style="width:100px;border: 1px #eee solid;" class="image-responsive"/>
												</div>
											</div>
										</div>
										<div class="col-print-3">
											<div style="color: #000; font-size: 25px; font-weight: 500;">
												<?php
													$che_payment = mysqli_fetch_assoc($mysqli->query("select * from payment_received_method where transaction_id = '".$id['transaction_id']."'"));
													if(!empty($che_payment['transaction_id'])){
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
															echo '<li style="margin-top: 10px">'.$amount.'</li>';
														}
													?>
												</ul>
												<?php } ?>
											</div>
										</div>
										<div class="col-print-7">
											<div class="title" style="color: #8BC34A;font-size: 45px;font-weight: 600;"><?php echo $id['transaction_id']; ?> </div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</footer>
					<style type="text/css">
						#print_area_new table {
							border-collapse: collapse; border-spacing: 0;
						}

						#print_area_new caption, th, td {
							text-align: left;
							font-weight: normal;
							vertical-align: middle;
						}

						#print_area_new q, blockquote {
							quotes: none;
						}
						#print_area_new q:before, q:after, blockquote:before, blockquote:after {
							content: "";
							content: none;
						}

						#print_area_new a img {
							border: none;
						}

						#print_area_new article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
							display: block;
						}
					/*
						body {
							font-family: 'Source Sans Pro', sans-serif;
							font-weight: 300;
							font-size: 12px;
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
						} */
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

						#print_area_new header {
							margin-top: 20px;
							margin-bottom: 50px;
						}
						#print_area_new header figure {
							float: left;
							text-align: center;
							margin:0px;
							margin-right: 10px;
						}

						#print_area_new header .company-address {
							float: left;
							max-width: 150px;
							line-height: 1.7em;
							font-weight:bolder;
						}
						#print_area_new header .company-address .title {
							color: #8BC34A;
							font-weight: bolder;
							font-size: 25px;
							margin-top:0px;
							text-transform: uppercase;
						}
						#print_area_new header .company-contact {
							float: right;
							height: 60px;
							padding: 0 10px;
							background-color: #8BC34A;
							color: white;
							padding-right:0px;
							font-weight:bolder;
						}
						#print_area_new header .company-contact span {
							display: inline-block;
							vertical-align: middle;
						}
						#print_area_new header .company-contact .circle {
							width: 30px;
							height: 30px;
							background-color: white;
							border-radius: 50%;
							text-align: center;
							margin-right:10px;
						}
						#print_area_new header .company-contact .circle img {
							vertical-align: middle;
						}
						#print_area_new header .company-contact .phone {
							height: 100%;
							margin-right: 20px;
						}
						#print_area_new header .company-contact .email {
							height: 100%;
							min-width: 100px;
							text-align: right;
						}

						#print_area_new section .details {
							margin-bottom: 10px;
						}
						#print_area_new section .details .client {
							width: 50%;
							line-height: 20px;
							font-weight:bolder;
						}
						#print_area_new section .details .client .name {
							color: #8BC34A;
						}
						#print_area_new section .details .data {
							width: 50%;
							text-align: right;
						}
						#print_area_new section .details .title {
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
							background: #8BC34A;
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
						
						#print_area_new section .sub-total tbody td {
							padding: 5px;
							background: #E8F3DB;
							color: #777777;
							text-align: right;
							border-bottom: 5px solid #FFFFFF;
							border-right: 4px solid #E8F3DB;
						}
						
						#print_area_new section .grand-total tbody td {
							padding: 5px;
							background: #E8F3DB;
							color: #777777;
							text-align: right;
							border-bottom: 5px solid #FFFFFF;
							border-right: 4px solid #E8F3DB;
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
						#print_area_new footer {
							margin-bottom: 20px;
						}
						#print_area_new footer .thanks {
							margin-bottom: 40px;
							color: #8BC34A;
							font-size: 1.16666666666667em;
							font-weight: 600;
						}
						#print_area_new footer .notice {
							margin-bottom: 25px;
						}						
						.rebonnn{
							right: 18px;
							top: 87px;
							box-shadow: 0 0 3px rgb(0 0 0 / 30%);
							font-size: .8rem;
							line-height: 100%;
							padding: .375rem 0;
							position: relative;
							text-align: center;
							text-shadow: 0 -1px 0 rgb(0 0 0 / 40%);
							text-transform: uppercase;
							-webkit-transform: rotate( -45deg );
							transform: rotate( -45deg );
							width: 250px;
						}
						.rebin_wrapper{
							overflow: hidden !important;
							position: absolute;
							right: 0px;
							bottom: 0px;
							width: 180px;
							height: 180px;
							z-index: 10;
						}
						footer .end-new {
							padding-top: 5px;
							text-align: center;
						}
						.invoice-disclaimer-border{
							border-top: 2px solid #8BC34A;							
							margin-bottom: 5px;
						}
						.booking-form-tag{
							display: grid;
							justify-content: center;
							align-content: center;
							width: 100px;
							height: 100px;
							/* background-color: #8BC34A; */
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

							.rotate_copy{
								transform: rotate(
								-45deg
								);
									width: 200px;
									margin-top: -42px;
									margin-left: 204px;
									font-weight: bold;
									font-size: 40px;
									color: red;
									text-align: center;
							}
						}
					</style>
					<?php if($member['member_type'] == 'GROUP'){ ?>	
						<div class="rebin_wrapper ribbon-xl">
							<div class="rebonnn bg-success text-xl">
							Group
							</div>
						</div>
					<?php } ?>
				</section>					
			</div>
			<div class="tab-pane active" id="new_receipt">
			
					<div class="col-print-12" id="shap_new_one">
						<section id="print_area_new">
							<header class="clearfix" style="margin-bottom:30px;">
								<div class="container">
									<figure>
										<img class="logo" src="<?php echo $home; ?>assets/img/n_logo.png" alt="" style="width:90px;">
									</figure>
									<div class="company-address">
										<h1 class="title" style="color:green;">SUPER HOME</h1>
										<p style="font-size:18px;"><?php echo $branch_info['branch_name']; ?><br> <?php echo $branch_info['branch_location']; ?> </p>
									</div>
									<div class="company-contact" style="height:80px;">
										<div class="phone left">
											<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjkuNzYycHgiIGhlaWdodD0iOS45NThweCINCgkgdmlld0JveD0iLTQuOTkyIDAuNTE5IDkuNzYyIDkuOTU4IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IC00Ljk5MiAwLjUxOSA5Ljc2MiA5Ljk1OCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMS4wMDAwMDAsIC01NC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJLT05UQUtUSSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjY3LjAwMDAwMCwgMzUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPGcgaWQ9Ik92YWwtMS1feDJCXy1GaWxsLTEiPg0KCQkJCQk8cGF0aCBpZD0iRmlsbC0xIiBmaWxsPSIjOEJDMzRBIiBkPSJNOC43NjUsMTIuMzc1YzAuMDIsMC4xNjItMC4wMjgsMC4zMDMtMC4xNDMsMC40MjJMNy4yNDYsMTQuMTkNCgkJCQkJCWMtMC4wNjIsMC4wNy0wLjE0MywwLjEzMy0wLjI0MywwLjE4MmMtMC4xMDEsMC4wNDktMC4xOTcsMC4wOC0wLjI5NSwwLjA5NGMtMC4wMDcsMC0wLjAyOCwwLTAuMDYyLDAuMDA0DQoJCQkJCQljLTAuMDM0LDAuMDA1LTAuMDgsMC4wMDgtMC4xMzQsMC4wMDhjLTAuMTMxLDAtMC4zNDMtMC4wMjMtMC42MzUtMC4wNjhjLTAuMjkzLTAuMDQ1LTAuNjUxLTAuMTU4LTEuMDc2LTAuMzM2DQoJCQkJCQljLTAuNDI0LTAuMTgyLTAuOTA0LTAuNDUxLTEuNDQyLTAuODA5Yy0wLjUzNi0wLjM1Ny0xLjEwOS0wLjg1Mi0xLjcxNi0xLjQ3OWMtMC40ODEtMC40ODQtMC44OC0wLjk1LTEuMTk4LTEuMzkzDQoJCQkJCQlDMC4xMjgsOS45NS0wLjEyNSw5LjU0MS0wLjMxOSw5LjE2NGMtMC4xOTMtMC4zNzYtMC4zMzgtMC43MTctMC40MzQtMS4wMjNjLTAuMDk3LTAuMzA2LTAuMTYxLTAuNTctMC4xOTUtMC43OTINCgkJCQkJCWMtMC4wMzUtMC4yMjEtMC4wNS0wLjM5NC0wLjA0Mi0wLjUyMWMwLjAwNy0wLjEyNiwwLjAxLTAuMTk3LDAuMDEtMC4yMTFjMC4wMTQtMC4wOTksMC4wNDQtMC4xOTgsMC4wOTMtMC4zMDENCgkJCQkJCWMwLjA0OS0wLjEwMSwwLjEwOC0wLjE4NCwwLjE3Ni0wLjI0N2wxLjM3NS0xLjQwM2MwLjA5Ny0wLjA5OCwwLjIwNi0wLjE0NywwLjMzLTAuMTQ3YzAuMDksMCwwLjE2OSwwLjAyNiwwLjIzOCwwLjA3OQ0KCQkJCQkJQzEuMyw0LjY0OCwxLjM1OSw0LjcxNCwxLjQwNiw0Ljc5MWwxLjEwNiwyLjE0MWMwLjA2MiwwLjExNCwwLjA4LDAuMjM1LDAuMDUyLDAuMzdDMi41MzgsNy40MzYsMi40NzgsNy41NDgsMi4zODksNy42NA0KCQkJCQkJTDEuODgzLDguMTU3QzEuODY5LDguMTcxLDEuODU2LDguMTk0LDEuODQ2LDguMjI2QzEuODM1LDguMjU2LDEuODMsOC4yODMsMS44Myw4LjMwNGMwLjAyNywwLjE0NywwLjA5LDAuMzE3LDAuMTg3LDAuNTA3DQoJCQkJCQljMC4wODIsMC4xNjksMC4yMSwwLjM3NSwwLjM4MiwwLjYxOGMwLjE3MiwwLjI0MywwLjQxNywwLjUyMSwwLjczNCwwLjgzOWMwLjMxMSwwLjMyMiwwLjU4NSwwLjU3NCwwLjgyOCwwLjc1NQ0KCQkJCQkJYzAuMjQsMC4xNzgsMC40NDMsMC4zMDksMC42MDQsMC4zOTVjMC4xNjIsMC4wODUsMC4yODYsMC4xMzUsMC4zNzIsMC4xNTRsMC4xMjgsMC4wMjRjMC4wMTUsMCwwLjAzOC0wLjAwNiwwLjA2Ny0wLjAxNg0KCQkJCQkJYzAuMDMyLTAuMDEsMC4wNTQtMC4wMjEsMC4wNjctMC4wMzdsMC41ODgtMC42MTJjMC4xMjUtMC4xMTIsMC4yNy0wLjE2OCwwLjQzNi0wLjE2OGMwLjExNywwLDAuMjA3LDAuMDIxLDAuMjc3LDAuMDYxaDAuMDENCgkJCQkJCWwxLjk5NSwxLjIwM0M4LjY1MSwxMi4xMiw4LjczNywxMi4yMzQsOC43NjUsMTIuMzc1TDguNzY1LDEyLjM3NXoiLz4NCgkJCQk8L2c+DQoJCQk8L2c+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==" alt=""><span class="helper"></span></span>
											<a href="tel:602-519-0450" style="text-decoration: none;font-size:20px;color:#000;">(+880) 96386-66333</a>
											<span class="helper"></span>
										</div>
										<div class="email right">
											<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
											<a href="mailto:info@superhomebd.com" style="text-decoration: none;font-size:20px;color:#000;">info@superhomebd.com</a>
											<span class="helper"></span>
											<span style="width:80px;height:80px;margin-left:10px;">
												<img src="<?php echo $home.'assets/uploads/qrcode/booking_recipt_id_'.$row['booking_id'].'.png'; ?>" style="width:81px;float:right;border: 1px #eee solid;" class="image-responsive"/>
											</span>
										</div>				
									</div>
									<div style="width:100%;float:left;margin-top:20px;">
									<h4 class="rotate_copy">Office Copy</h4>
										<center>
											
											<h1 style="font-size:3em;font-weight:600;"><u>Booking Receipt</u></h1>
										</center>
									</div>
								</div>
							</header>
							
							<section>							
								<div class="container">
									<div class="details clearfix">
										<div class="client left" style="font-size:20px;line-height:30px;">
											<p>INVOICE BY:</p>
											<p class="name" style="color:green;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
											<!--<a href="mailto:<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'Not provided!'; } ?></a><br />-->
											<!--<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php if(!empty($rentre['personal_Phone'])){ echo $rentre['personal_Phone']; }else{ echo 'Not provided!'; }  ?></a>-->
											<div style="width:100%;margin-top:10px;"></div>
											<hr />					
											<p>INVOICE TO:</p>
											<p class="name" style="color:green;font-weight:bolder;margin: 0px;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $row['m_name']; ?></p>
											<p style="margin: 0px;"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
											<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
											<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
											<p style="margin: 0px;"><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $row['bed_name']; ?></strong></p>
										</div>
										<div class="data right">
											<?php
												$inv = explode('/',$row['data']);
												$invd = $inv[0].$inv[1].$inv[2];
												$id = mysqli_fetch_assoc($mysqli->query("select * from transaction where booking_id = '".$row['booking_id']."' and data = '".$row['data']."' and note = 'Booking Money Collection'"));
											?>
											<div class="title" style="color:#000;font-size:35px;"><?php echo $id['transaction_id']; ?> </div>
											<div class="date" style="font-weight:bolder;line-height: 30px;">
												<style>.right_cs_t tr{background-color:none;} .right_cs_t td{font-size:20px;color:#000;background:none;border:none;padding:2px;}</style>
												<table class="table table-sm right_cs_t" style="width:80%;float:right;" border="0" border-spacing="0">
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
									</div>

									<table class="sub-total" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
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
													<h3 style="color:#000;"> Security Money </h3>							
												</td>
												<td class="qty"> <h3 style="color:#000;"><?php echo $row['package_category_name']; ?></h3> </td>
												<td class="unit" style="color:#000;">
													<?php												
														if($package['aggreement'] == 1){
															$sd_m = 1000;
														}else{
															$sd_m = $row['security_deposit'];
														} 
														echo money($sd_m);																				
													?>
												</td>
												<td class="total" style="color:#000;"><?php echo money($sd_m); ?></td>
											</tr>
											<?php
												if($package['aggreement'] == 1){
											?>
											
											<tr>
												<td class="desc">
													<h3 style="color:#000;"> Adjustable Money</h3>
												</td>
												<td class="qty"> <h3 style="color:#000;"><?php echo $row['package_name']; ?></h3> </td>
												<td class="unit" style="color:#000;">
													<?php 
														echo money(1000); 
													?>
												</td>
												<td class="total" style="color:#000;">
													<?php 
														echo money($package['package_price'] - 1000); 
													?>
												</td>
											</tr>
											<?php 
												$sd_m = $sd_m + $package['package_price'] - 1000;
												$r_pk_name = '';
											}else{
												$r_pk_name = $row['package_name'];
											}
											?>
											<?php 
												if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid' AND $rent['note'] == 'booking'){
											?>									
											<tr>
												<td class="desc">
													<h3 style="color:#000;"> Rent </h3>
												</td>
												<td class="qty"> <h3 style="color:#000;"><?php echo $r_pk_name; ?></h3> </td>
												<td class="unit" style="color:#000;">
													<?php 
													if($package['aggreement'] == 1){
														echo money($row['rent_amount'] + 1000);
													}else{
														echo money($row['rent_amount']);
													} 
													?>
												</td>
												<td class="total" style="color:#000;">
													<?php 
													if($package['aggreement'] == 1){
														echo money($row['rent_amount'] + 1000);
													}else{
														echo money($row['rent_amount']);
													} 
													?>
												</td>
											</tr>
											
											<?php if((float)$rent['parking'] > 0 ){ ?>
											<tr>
												<td class="desc">
													<h3 style="color:#000;"> Parking </h3>
												</td>
												<td class="qty"> <h3 style="color:#000;">----</h3> </td>
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
													<h3 style="color:#000;"> Locker </h3>
												</td>
												<td class="qty"> <h3 style="color:#000;">----</h3> </td>
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
												if($package['aggreement'] == 1){
													$rent1 =  $row['rent_amount'] + 1000;
												}else{
													$rent1 =  $row['rent_amount'];
												} 
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
									<div class="no-break">
										<table class="grand-total" style="border-collapse: collapse; border-spacing: 0;font-size:20px;">
											<tbody>
												<?php 
												if(!empty($row['card_p_amount']) AND $row['card_p_amount'] > 0){
												?>
												<tr>
													<td class="desc" style="text-align:left;color:#000;"> 
													
													</td>
													<td class="qty"></td>
													<td class="unit" style="color:#000;">Card Charge:</td>
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
													<td class="qty"></td>
													<td class="unit" style="color:#000;">SUBTOTAL:</td>
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
													<td class="qty"></td>
													<td class="unit" style="color:#000;">Cash Back:</td>
													<td class="total">
														<?php								
														if($discount_show == '1'){	
															$td = explode('/',$rent['data']);
															$dis_check = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'")); // and month like '%".date($td[1])."%' and year LIKE '%".date($td[2])."%'
															if(!empty($dis_check['amount'])){
																if(!empty($rent['id'])){
																	if($row['discount_pattern'] == 'YES'){
																		echo money(0);
																		$dis_mnt = 0;
																	}else if($row['discount_pattern'] == 'A' OR $row['discount_pattern'] == 'B'){
																		if($rent['payment_pattern'] == 0 AND $row['discount_pattern'] == 'A'){
																			echo money($dis_check['amount'] / 2);
																			$dis_mnt = $dis_check['amount'] / 2;
																		}else if($row['discount_pattern'] == 'B'){
																			echo money($dis_check['amount']);
																			$dis_mnt = $dis_check['amount'];
																		}else{
																			echo money(0);
																			$dis_mnt = 0;
																		}
																	}else{
																		if($rent['payment_pattern'] == 0){
																			echo money($dis_check['amount'] / 2);
																			$dis_mnt = $dis_check['amount'] / 2;
																		}else{
																			echo money($dis_check['amount']);
																			$dis_mnt = $dis_check['amount'];
																		}
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
												<?php if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid'){ if($package['aggreement'] == 1){ ?>
												<tr>
													<td class="desc" style="text-align:left;color:#000;"> </td>
													<td class="qty"></td>
													<td class="unit" style="color:#000;">Diposit Adjust:</td>
													<td class="total">
														<?php echo money(1000); $diposit_back = 1000;?>
													</td>
												</tr>					
												<?php }else{ $diposit_back = 0;} }else{ $diposit_back = 0; } ?>
												
												<tr>
													<td class="desc" style="color:#000;font-size:20px;font-weight:500;text-align:left;">
														<?php /* ?>Payment Method: <strong style="font-weight:bolder;"><?php echo rtrim($row['payment_method'],','); ?></strong><?php */ ?>
													</td>
													<td class="qty"></td>
													<td class="unit" style="font-size:18px;color:#000;">GRAND TOTAL:</td> <!-- colspan="2"-->
													<?php
														$grand_t = (float)$total_amount - (float)$dis_mnt - $diposit_back; 
													?>
													<td class="total" style="font-size:18px;color:#000;"><?php echo money($grand_t); ?></td>
												</tr>
											</tbody>
										</table>
										<div style="width:100%;float:left;color: #000; font-size: 35px; font-weight: 500;">
											<div style="float:left;width:45%;">
												<?php
													$che_payment = mysqli_fetch_assoc($mysqli->query("select * from payment_received_method where transaction_id = '".$id['transaction_id']."'"));
													if(!empty($che_payment['transaction_id'])){
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
											<div style="float:left;width:55%;">
												<?php				
													$dis_checki = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'"));
													if(!empty($dis_checki['amount']) AND $dis_checki['amount'] > 0){ ?>
													<span style="float:right; width:100%;">
														<strong style="font-weight:bolder;color:green;font-size: 20px;">Congratulation! You get cashback <span style="color:#f00;"><?php echo money($dis_checki['amount']); ?></span> at 1st Rent</strong>							
													</span>
												<?php } ?>
												<?php if($package['aggreement'] == 1){ if($rent1 > 0){ ?>											
													<span style="float:right; width:100%;">
														<strong style="font-weight:bolder;color:green;font-size: 20px;">You get 1st Deposit Adjust <span style="color:#f00;"><?php echo money(1000); ?></span> at 1st Rent</strong>							
													</span>
												<?php } } ?>
											</div>					
										</div>
									</div>
								</div>
							</section>

							<footer>
								<div class="container">
									<div class="thanks">
										Thank you!								
									</div>
									<div class="notice">
										<?php if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid' AND $rent['note'] == 'booking'){ ?>
											<div>NOTICE: 
												<?php
													if($rent['payment_pattern'] == 0){						
													$bk_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM booking_info WHERE booking_id = '".$rent['booking_id']."'"));
													if($package['try_us'] == 1){
														if($bk_info['available_days'] > 0){
															$set_checkOut = date('d/m/Y', strtotime(date('Y-m-d'). ' + '.(int)$bk_info['available_days'].' days'));
														}else{
															$get_date = explode('/',$bk_info['checkin_date']);
															$cin_date = $get_date[2].'-'.$get_date[1].'-'.$get_date[0];
															$set_checkOut = date('d/m/Y', strtotime($cin_date. ' + 15 days'));
															//$set_checkOut = '25/'.date('m/y');
														}
													}else{
														$set_checkOut = '25/'.date('m/y');
													}
													
												?>
												<div><b>Please Pay the 2nd Installment before <span class="badge badge-secondary" style="font-size:18px;"><?php echo $set_checkOut; ?></span> ,Otherwise Your seat will be auto cancel.</b></div>
												<?php } ?>
											</div>
										<?php } ?>
										<div>A finance per day charge of BDT 100/- will be made on unpaid rent after 10 days & New CheckIn after 5 Days.</div>
										<?php if($package['aggreement'] == 1){ ?>
										<div style="color:#f00;"><b>Tearms:</b> If break the Contract, Adjustable Money Not Refundable!</div>	
										<?php } ?>
									</div>
									<!-- copy here footer reciept -->
								</div>
							</footer>
							<style type="text/css">
								#print_area_new table {
									border-collapse: collapse; border-spacing: 0;
								}

								#print_area_new caption, th, td {
									text-align: left;
									font-weight: normal;
									vertical-align: middle;
								}

								#print_area_new q, blockquote {
									quotes: none;
								}
								#print_area_new q:before, q:after, blockquote:before, blockquote:after {
									content: "";
									content: none;
								}

								#print_area_new a img {
									border: none;
								}

								#print_area_new article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
									display: block;
								}
							/*
								body {
									font-family: 'Source Sans Pro', sans-serif;
									font-weight: 300;
									font-size: 12px;
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
								} */
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

								#print_area_new header {
									margin-top: 20px;
									margin-bottom: 50px;
								}
								#print_area_new header figure {
									float: left;
									text-align: center;
									margin:0px;
									margin-right: 10px;
								}

								#print_area_new header .company-address {
									float: left;
									max-width: 150px;
									line-height: 1.7em;
									font-weight:bolder;
								}
								#print_area_new header .company-address .title {
									color: #8BC34A;
									font-weight: bolder;
									font-size: 25px;
									margin-top:0px;
									text-transform: uppercase;
								}
								#print_area_new header .company-contact {
									float: right;
									height: 60px;
									padding: 0 10px;
									background-color: #8BC34A;
									color: white;
									padding-right:0px;
									font-weight:bolder;
								}
								#print_area_new header .company-contact span {
									display: inline-block;
									vertical-align: middle;
								}
								#print_area_new header .company-contact .circle {
									width: 30px;
									height: 30px;
									background-color: white;
									border-radius: 50%;
									text-align: center;
									margin-right:10px;
								}
								#print_area_new header .company-contact .circle img {
									vertical-align: middle;
								}
								#print_area_new header .company-contact .phone {
									height: 100%;
									margin-right: 20px;
								}
								#print_area_new header .company-contact .email {
									height: 100%;
									min-width: 100px;
									text-align: right;
								}

								#print_area_new section .details {
									margin-bottom: 10px;
								}
								#print_area_new section .details .client {
									width: 50%;
									line-height: 20px;
									font-weight:bolder;
								}
								#print_area_new section .details .client .name {
									color: #8BC34A;
								}
								#print_area_new section .details .data {
									width: 50%;
									text-align: right;
								}
								#print_area_new section .details .title {
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
									background: #8BC34A;
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
								
								#print_area_new section .sub-total tbody td {
									padding: 5px;
									background: #E8F3DB;
									color: #777777;
									text-align: right;
									border-bottom: 5px solid #FFFFFF;
									border-right: 4px solid #E8F3DB;
								}
								
								#print_area_new section .grand-total tbody td {
									padding: 5px;
									background: #E8F3DB;
									color: #777777;
									text-align: right;
									border-bottom: 5px solid #FFFFFF;
									border-right: 4px solid #E8F3DB;
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
								#print_area_new footer {
									margin-bottom: 20px;
								}
								#print_area_new footer .thanks {
									margin-bottom: 40px;
									color: #8BC34A;
									font-size: 1.16666666666667em;
									font-weight: 600;
								}
								#print_area_new footer .notice {
									margin-bottom: 25px;
								}						
								.rebonnn{
									right: 18px;
									top: 87px;
									box-shadow: 0 0 3px rgb(0 0 0 / 30%);
									font-size: .8rem;
									line-height: 100%;
									padding: .375rem 0;
									position: relative;
									text-align: center;
									text-shadow: 0 -1px 0 rgb(0 0 0 / 40%);
									text-transform: uppercase;
									-webkit-transform: rotate( -45deg );
									transform: rotate( -45deg );
									width: 250px;
								}
								.rebin_wrapper{
									overflow: hidden !important;
									position: absolute;
									right: 0px;
									bottom: 0px;
									width: 180px;
									height: 180px;
									z-index: 10;
								}
								footer .end-new {
									padding-top: 5px;
									text-align: center;
								}
								.invoice-disclaimer-border{
									border-top: 2px solid #8BC34A;							
									margin-bottom: 5px;
								}
								.booking-form-tag{
									display: grid;
									justify-content: center;
									align-content: center;
									width: 100px;
									height: 100px;
									/* background-color: #8BC34A; */
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

									.rotate_copy{
		transform: rotate(
		-45deg
		);
			width: 200px;
			margin-top: -42px;
			margin-left: 204px;
			font-weight: bold;
			font-size: 40px;
	}
								}
							</style>
							<?php if($member['member_type'] == 'GROUP'){ ?>	
								<div class="rebin_wrapper ribbon-xl">
									<div class="rebonnn bg-success text-xl">
									Group
									</div>
								</div>
							<?php } ?>
						</section>
					</div>


					<div class="col-print-6" style=" display:none" id="shap_new_two">
						<section id="print_area_new">
							<header class="clearfix" style="margin-bottom:30px;">
								<div class="container">
									<figure>
										<img class="logo" src="<?php echo $home; ?>assets/img/n_logo.png" alt="" style="width:90px;">
									</figure>
									<div class="company-address">
										<h1 class="title" style="color:green;">SUPER HOME</h1>
										<p style="font-size:18px;"><?php echo $branch_info['branch_name']; ?><br> <?php echo $branch_info['branch_location']; ?> </p>
									</div>
									<div class="company-contact" style="height:80px;">
										<div class="phone left">
											<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjkuNzYycHgiIGhlaWdodD0iOS45NThweCINCgkgdmlld0JveD0iLTQuOTkyIDAuNTE5IDkuNzYyIDkuOTU4IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IC00Ljk5MiAwLjUxOSA5Ljc2MiA5Ljk1OCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMS4wMDAwMDAsIC01NC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJLT05UQUtUSSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjY3LjAwMDAwMCwgMzUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPGcgaWQ9Ik92YWwtMS1feDJCXy1GaWxsLTEiPg0KCQkJCQk8cGF0aCBpZD0iRmlsbC0xIiBmaWxsPSIjOEJDMzRBIiBkPSJNOC43NjUsMTIuMzc1YzAuMDIsMC4xNjItMC4wMjgsMC4zMDMtMC4xNDMsMC40MjJMNy4yNDYsMTQuMTkNCgkJCQkJCWMtMC4wNjIsMC4wNy0wLjE0MywwLjEzMy0wLjI0MywwLjE4MmMtMC4xMDEsMC4wNDktMC4xOTcsMC4wOC0wLjI5NSwwLjA5NGMtMC4wMDcsMC0wLjAyOCwwLTAuMDYyLDAuMDA0DQoJCQkJCQljLTAuMDM0LDAuMDA1LTAuMDgsMC4wMDgtMC4xMzQsMC4wMDhjLTAuMTMxLDAtMC4zNDMtMC4wMjMtMC42MzUtMC4wNjhjLTAuMjkzLTAuMDQ1LTAuNjUxLTAuMTU4LTEuMDc2LTAuMzM2DQoJCQkJCQljLTAuNDI0LTAuMTgyLTAuOTA0LTAuNDUxLTEuNDQyLTAuODA5Yy0wLjUzNi0wLjM1Ny0xLjEwOS0wLjg1Mi0xLjcxNi0xLjQ3OWMtMC40ODEtMC40ODQtMC44OC0wLjk1LTEuMTk4LTEuMzkzDQoJCQkJCQlDMC4xMjgsOS45NS0wLjEyNSw5LjU0MS0wLjMxOSw5LjE2NGMtMC4xOTMtMC4zNzYtMC4zMzgtMC43MTctMC40MzQtMS4wMjNjLTAuMDk3LTAuMzA2LTAuMTYxLTAuNTctMC4xOTUtMC43OTINCgkJCQkJCWMtMC4wMzUtMC4yMjEtMC4wNS0wLjM5NC0wLjA0Mi0wLjUyMWMwLjAwNy0wLjEyNiwwLjAxLTAuMTk3LDAuMDEtMC4yMTFjMC4wMTQtMC4wOTksMC4wNDQtMC4xOTgsMC4wOTMtMC4zMDENCgkJCQkJCWMwLjA0OS0wLjEwMSwwLjEwOC0wLjE4NCwwLjE3Ni0wLjI0N2wxLjM3NS0xLjQwM2MwLjA5Ny0wLjA5OCwwLjIwNi0wLjE0NywwLjMzLTAuMTQ3YzAuMDksMCwwLjE2OSwwLjAyNiwwLjIzOCwwLjA3OQ0KCQkJCQkJQzEuMyw0LjY0OCwxLjM1OSw0LjcxNCwxLjQwNiw0Ljc5MWwxLjEwNiwyLjE0MWMwLjA2MiwwLjExNCwwLjA4LDAuMjM1LDAuMDUyLDAuMzdDMi41MzgsNy40MzYsMi40NzgsNy41NDgsMi4zODksNy42NA0KCQkJCQkJTDEuODgzLDguMTU3QzEuODY5LDguMTcxLDEuODU2LDguMTk0LDEuODQ2LDguMjI2QzEuODM1LDguMjU2LDEuODMsOC4yODMsMS44Myw4LjMwNGMwLjAyNywwLjE0NywwLjA5LDAuMzE3LDAuMTg3LDAuNTA3DQoJCQkJCQljMC4wODIsMC4xNjksMC4yMSwwLjM3NSwwLjM4MiwwLjYxOGMwLjE3MiwwLjI0MywwLjQxNywwLjUyMSwwLjczNCwwLjgzOWMwLjMxMSwwLjMyMiwwLjU4NSwwLjU3NCwwLjgyOCwwLjc1NQ0KCQkJCQkJYzAuMjQsMC4xNzgsMC40NDMsMC4zMDksMC42MDQsMC4zOTVjMC4xNjIsMC4wODUsMC4yODYsMC4xMzUsMC4zNzIsMC4xNTRsMC4xMjgsMC4wMjRjMC4wMTUsMCwwLjAzOC0wLjAwNiwwLjA2Ny0wLjAxNg0KCQkJCQkJYzAuMDMyLTAuMDEsMC4wNTQtMC4wMjEsMC4wNjctMC4wMzdsMC41ODgtMC42MTJjMC4xMjUtMC4xMTIsMC4yNy0wLjE2OCwwLjQzNi0wLjE2OGMwLjExNywwLDAuMjA3LDAuMDIxLDAuMjc3LDAuMDYxaDAuMDENCgkJCQkJCWwxLjk5NSwxLjIwM0M4LjY1MSwxMi4xMiw4LjczNywxMi4yMzQsOC43NjUsMTIuMzc1TDguNzY1LDEyLjM3NXoiLz4NCgkJCQk8L2c+DQoJCQk8L2c+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==" alt=""><span class="helper"></span></span>
											<a href="tel:602-519-0450" style="text-decoration: none;font-size:20px;color:#000;">(+880) 96386-66333</a>
											<span class="helper"></span>
										</div>
										<div class="email right">
											<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
											<a href="mailto:info@superhomebd.com" style="text-decoration: none;font-size:20px;color:#000;">info@superhomebd.com</a>
											<span class="helper"></span>
											<span style="width:80px;height:80px;margin-left:10px;">
												<img src="<?php echo $home.'assets/uploads/qrcode/booking_recipt_id_'.$row['booking_id'].'.png'; ?>" style="width:81px;float:right;border: 1px #eee solid;" class="image-responsive"/>
											</span>
										</div>				
									</div>
									<div style="width:100%;float:left;margin-top:20px;">
									<h4 class="rotate_copy">Member Copy</h4>
										<center>
										    
											<h1 style="font-size:3em;font-weight:600;"><u>Booking Receipt</u></h1>
										</center>
									</div>
								</div>
							</header>
							
							<section>							
								<div class="container">
									<div class="details clearfix">
										<div class="client left" style="font-size:20px;line-height:30px;">
											<p>INVOICE BY:</p>
											<p class="name" style="color:green;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
											<!--<a href="mailto:<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'Not provided!'; } ?></a><br />-->
											<!--<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php if(!empty($rentre['personal_Phone'])){ echo $rentre['personal_Phone']; }else{ echo 'Not provided!'; }  ?></a>-->
											<div style="width:100%;margin-top:10px;"></div>
											<hr />					
											<p>INVOICE TO:</p>
											<p class="name" style="color:green;font-weight:bolder;margin: 0px;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $row['m_name']; ?></p>
											<p style="margin: 0px;"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
											<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
											<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
											<p style="margin: 0px;"><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $row['bed_name']; ?></strong></p>
										</div>
										<div class="data right">
											<?php
												$inv = explode('/',$row['data']);
												$invd = $inv[0].$inv[1].$inv[2];
												$id = mysqli_fetch_assoc($mysqli->query("select * from transaction where booking_id = '".$row['booking_id']."' and data = '".$row['data']."' and note = 'Booking Money Collection'"));
											?>
											<div class="title" style="color:#000;font-size:35px;"><?php echo $id['transaction_id']; ?> </div>
											<div class="date" style="font-weight:bolder;line-height: 30px;">
												<style>.right_cs_t tr{background-color:none;} .right_cs_t td{font-size:20px;color:#000;background:none;border:none;padding:2px;}</style>
												<table class="table table-sm right_cs_t" style="width:80%;float:right;" border="0" border-spacing="0">
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
									</div>

									<table class="sub-total" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
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
													<h3 style="color:#000;"> Security Money </h3>							
												</td>
												<td class="qty"> <h3 style="color:#000;"><?php echo $row['package_category_name']; ?></h3> </td>
												<td class="unit" style="color:#000;">
													<?php												
														if($package['aggreement'] == 1){
															$sd_m = 1000;
														}else{
															$sd_m = $row['security_deposit'];
														} 
														echo money($sd_m);																				
													?>
												</td>
												<td class="total" style="color:#000;"><?php echo money($sd_m); ?></td>
											</tr>
											<?php
												if($package['aggreement'] == 1){
											?>
											
											<tr>
												<td class="desc">
													<h3 style="color:#000;"> Adjustable Money</h3>
												</td>
												<td class="qty"> <h3 style="color:#000;"><?php echo $row['package_name']; ?></h3> </td>
												<td class="unit" style="color:#000;">
													<?php 
														echo money(1000); 
													?>
												</td>
												<td class="total" style="color:#000;">
													<?php 
														echo money($package['package_price'] - 1000); 
													?>
												</td>
											</tr>
											<?php 
												$sd_m = $sd_m + $package['package_price'] - 1000;
												$r_pk_name = '';
											}else{
												$r_pk_name = $row['package_name'];
											}
											?>
											<?php 
												if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid' AND $rent['note'] == 'booking'){
											?>									
											<tr>
												<td class="desc">
													<h3 style="color:#000;"> Rent </h3>
												</td>
												<td class="qty"> <h3 style="color:#000;"><?php echo $r_pk_name; ?></h3> </td>
												<td class="unit" style="color:#000;">
													<?php 
													if($package['aggreement'] == 1){
														echo money($row['rent_amount'] + 1000);
													}else{
														echo money($row['rent_amount']);
													} 
													?>
												</td>
												<td class="total" style="color:#000;">
													<?php 
													if($package['aggreement'] == 1){
														echo money($row['rent_amount'] + 1000);
													}else{
														echo money($row['rent_amount']);
													} 
													?>
												</td>
											</tr>
											
											<?php if((float)$rent['parking'] > 0 ){ ?>
											<tr>
												<td class="desc">
													<h3 style="color:#000;"> Parking </h3>
												</td>
												<td class="qty"> <h3 style="color:#000;">----</h3> </td>
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
													<h3 style="color:#000;"> Locker </h3>
												</td>
												<td class="qty"> <h3 style="color:#000;">----</h3> </td>
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
												if($package['aggreement'] == 1){
													$rent1 =  $row['rent_amount'] + 1000;
												}else{
													$rent1 =  $row['rent_amount'];
												} 
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
									<div class="no-break">
										<table class="grand-total" style="border-collapse: collapse; border-spacing: 0;font-size:20px;">
											<tbody>
												<?php 
												if(!empty($row['card_p_amount']) AND $row['card_p_amount'] > 0){
												?>
												<tr>
													<td class="desc" style="text-align:left;color:#000;"> 
													
													</td>
													<td class="qty"></td>
													<td class="unit" style="color:#000;">Card Charge:</td>
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
													<td class="qty"></td>
													<td class="unit" style="color:#000;">SUBTOTAL:</td>
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
													<td class="qty"></td>
													<td class="unit" style="color:#000;">Cash Back:</td>
													<td class="total">
														<?php								
														if($discount_show == '1'){	
															$td = explode('/',$rent['data']);
															$dis_check = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'")); // and month like '%".date($td[1])."%' and year LIKE '%".date($td[2])."%'
															if(!empty($dis_check['amount'])){
																if(!empty($rent['id'])){
																	if($row['discount_pattern'] == 'YES'){
																		echo money(0);
																		$dis_mnt = 0;
																	}else if($row['discount_pattern'] == 'A' OR $row['discount_pattern'] == 'B'){
																		if($rent['payment_pattern'] == 0 AND $row['discount_pattern'] == 'A'){
																			echo money($dis_check['amount'] / 2);
																			$dis_mnt = $dis_check['amount'] / 2;
																		}else if($row['discount_pattern'] == 'B'){
																			echo money($dis_check['amount']);
																			$dis_mnt = $dis_check['amount'];
																		}else{
																			echo money(0);
																			$dis_mnt = 0;
																		}
																	}else{
																		if($rent['payment_pattern'] == 0){
																			echo money($dis_check['amount'] / 2);
																			$dis_mnt = $dis_check['amount'] / 2;
																		}else{
																			echo money($dis_check['amount']);
																			$dis_mnt = $dis_check['amount'];
																		}
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
												<?php if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid'){ if($package['aggreement'] == 1){ ?>
												<tr>
													<td class="desc" style="text-align:left;color:#000;"> </td>
													<td class="qty"></td>
													<td class="unit" style="color:#000;">Diposit Adjust:</td>
													<td class="total">
														<?php echo money(1000); $diposit_back = 1000;?>
													</td>
												</tr>					
												<?php }else{ $diposit_back = 0;} }else{ $diposit_back = 0; } ?>
												
												<tr>
													<td class="desc" style="color:#000;font-size:20px;font-weight:500;text-align:left;">
														<?php /* ?>Payment Method: <strong style="font-weight:bolder;"><?php echo rtrim($row['payment_method'],','); ?></strong><?php */ ?>
													</td>
													<td class="qty"></td>
													<td class="unit" style="font-size:18px;color:#000;">GRAND TOTAL:</td> <!-- colspan="2"-->
													<?php
														$grand_t = (float)$total_amount - (float)$dis_mnt - $diposit_back; 
													?>
													<td class="total" style="font-size:18px;color:#000;"><?php echo money($grand_t); ?></td>
												</tr>
											</tbody>
										</table>
										<div style="width:100%;float:left;color: #000; font-size: 35px; font-weight: 500;">
											<div style="float:left;width:45%;">
												<?php
													$che_payment = mysqli_fetch_assoc($mysqli->query("select * from payment_received_method where transaction_id = '".$id['transaction_id']."'"));
													if(!empty($che_payment['transaction_id'])){
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
											<div style="float:left;width:55%;">
												<?php				
													$dis_checki = mysqli_fetch_assoc($mysqli->query("select * from discount_member where booking_id = '".$row['booking_id']."'"));
													if(!empty($dis_checki['amount']) AND $dis_checki['amount'] > 0){ ?>
													<span style="float:right; width:100%;">
														<strong style="font-weight:bolder;color:green;font-size: 20px;">Congratulation! You get cashback <span style="color:#f00;"><?php echo money($dis_checki['amount']); ?></span> at 1st Rent</strong>							
													</span>
												<?php } ?>
												<?php if($package['aggreement'] == 1){ if($rent1 > 0){ ?>											
													<span style="float:right; width:100%;">
														<strong style="font-weight:bolder;color:green;font-size: 20px;">You get 1st Deposit Adjust <span style="color:#f00;"><?php echo money(1000); ?></span> at 1st Rent</strong>							
													</span>
												<?php } } ?>
											</div>					
										</div>
									</div>
								</div>
							</section>

							<footer>
								<div class="container">
									<div class="thanks">
										Thank you!								
									</div>
									<div class="notice">
										<?php if(!empty($rent['rent_status']) AND $rent['rent_status'] == 'Paid' AND $rent['note'] == 'booking'){ ?>
											<div>NOTICE: 
												<?php
													if($rent['payment_pattern'] == 0){						
													$bk_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM booking_info WHERE booking_id = '".$rent['booking_id']."'"));
													if($package['try_us'] == 1){
														if($bk_info['available_days'] > 0){
															$set_checkOut = date('d/m/Y', strtotime(date('Y-m-d'). ' + '.(int)$bk_info['available_days'].' days'));
														}else{
															$get_date = explode('/',$bk_info['checkin_date']);
															$cin_date = $get_date[2].'-'.$get_date[1].'-'.$get_date[0];
															$set_checkOut = date('d/m/Y', strtotime($cin_date. ' + 15 days'));
															//$set_checkOut = '25/'.date('m/y');
														}
													}else{
														$set_checkOut = '25/'.date('m/y');
													}
													
												?>
												<div><b>Please Pay the 2nd Installment before <span class="badge badge-secondary" style="font-size:18px;"><?php echo $set_checkOut; ?></span> ,Otherwise Your seat will be auto cancel.</b></div>
												<?php } ?>
											</div>
										<?php } ?>
										<div>A finance per day charge of BDT 100/- will be made on unpaid rent after 10 days & New CheckIn after 5 Days.</div>
										<?php if($package['aggreement'] == 1){ ?>
										<div style="color:#f00;"><b>Tearms:</b> If break the Contract, Adjustable Money Not Refundable!</div>	
										<?php } ?>
									</div>
									<!-- copy here footer reciept -->
								</div>
							</footer>
							<style type="text/css">
								#print_area_new table {
									border-collapse: collapse; border-spacing: 0;
								}

								#print_area_new caption, th, td {
									text-align: left;
									font-weight: normal;
									vertical-align: middle;
								}

								#print_area_new q, blockquote {
									quotes: none;
								}
								#print_area_new q:before, q:after, blockquote:before, blockquote:after {
									content: "";
									content: none;
								}

								#print_area_new a img {
									border: none;
								}

								#print_area_new article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
									display: block;
								}
							/*
								body {
									font-family: 'Source Sans Pro', sans-serif;
									font-weight: 300;
									font-size: 12px;
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
								} */
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

								#print_area_new header {
									margin-top: 20px;
									margin-bottom: 50px;
								}
								#print_area_new header figure {
									float: left;
									text-align: center;
									margin:0px;
									margin-right: 10px;
								}

								#print_area_new header .company-address {
									float: left;
									max-width: 150px;
									line-height: 1.7em;
									font-weight:bolder;
								}
								#print_area_new header .company-address .title {
									color: #8BC34A;
									font-weight: bolder;
									font-size: 25px;
									margin-top:0px;
									text-transform: uppercase;
								}
								#print_area_new header .company-contact {
									float: right;
									height: 60px;
									padding: 0 10px;
									background-color: #8BC34A;
									color: white;
									padding-right:0px;
									font-weight:bolder;
								}
								#print_area_new header .company-contact span {
									display: inline-block;
									vertical-align: middle;
								}
								#print_area_new header .company-contact .circle {
									width: 30px;
									height: 30px;
									background-color: white;
									border-radius: 50%;
									text-align: center;
									margin-right:10px;
								}
								#print_area_new header .company-contact .circle img {
									vertical-align: middle;
								}
								#print_area_new header .company-contact .phone {
									height: 100%;
									margin-right: 20px;
								}
								#print_area_new header .company-contact .email {
									height: 100%;
									min-width: 100px;
									text-align: right;
								}

								#print_area_new section .details {
									margin-bottom: 10px;
								}
								#print_area_new section .details .client {
									width: 50%;
									line-height: 20px;
									font-weight:bolder;
								}
								#print_area_new section .details .client .name {
									color: #8BC34A;
								}
								#print_area_new section .details .data {
									width: 50%;
									text-align: right;
								}
								#print_area_new section .details .title {
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
									background: #8BC34A;
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
								
								#print_area_new section .sub-total tbody td {
									padding: 5px;
									background: #E8F3DB;
									color: #777777;
									text-align: right;
									border-bottom: 5px solid #FFFFFF;
									border-right: 4px solid #E8F3DB;
								}
								
								#print_area_new section .grand-total tbody td {
									padding: 5px;
									background: #E8F3DB;
									color: #777777;
									text-align: right;
									border-bottom: 5px solid #FFFFFF;
									border-right: 4px solid #E8F3DB;
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
								#print_area_new footer {
									margin-bottom: 20px;
								}
								#print_area_new footer .thanks {
									margin-bottom: 40px;
									color: #8BC34A;
									font-size: 1.16666666666667em;
									font-weight: 600;
								}
								#print_area_new footer .notice {
									margin-bottom: 25px;
								}						
								.rebonnn{
									right: 18px;
									top: 87px;
									box-shadow: 0 0 3px rgb(0 0 0 / 30%);
									font-size: .8rem;
									line-height: 100%;
									padding: .375rem 0;
									position: relative;
									text-align: center;
									text-shadow: 0 -1px 0 rgb(0 0 0 / 40%);
									text-transform: uppercase;
									-webkit-transform: rotate( -45deg );
									transform: rotate( -45deg );
									width: 250px;
								}
								.rebin_wrapper{
									overflow: hidden !important;
									position: absolute;
									right: 0px;
									bottom: 0px;
									width: 180px;
									height: 180px;
									z-index: 10;
								}
								footer .end-new {
									padding-top: 5px;
									text-align: center;
								}
								.invoice-disclaimer-border{
									border-top: 2px solid #8BC34A;							
									margin-bottom: 5px;
								}
								.booking-form-tag{
									display: grid;
									justify-content: center;
									align-content: center;
									width: 100px;
									height: 100px;
									/* background-color: #8BC34A; */
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
									
									.rotate_copy{
										transform: rotate(
										-45deg
										);
											width: 200px;
											margin-top: -42px;
											margin-left: 204px;
											font-weight: bold;
											font-size: 40px;
									}
								}
							</style>
							<?php if($member['member_type'] == 'GROUP'){ ?>	
								<div class="rebin_wrapper ribbon-xl">
									<div class="rebonnn bg-success text-xl">
									Group
									</div>
								</div>
							<?php } ?>
						</section>
					</div>
			</div>
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
		$("#shap_new_one").attr('class','col-print-12');
		$("#shap_new_two").attr('class','col-print-12');
		$("#shap_new_two").css("display", "inline-block");
      $('#print-area').printThis({
		
      });
      
	  setTimeout(function(){
            $('#shap_new_two').css('display', 'none');
            
        }, 1000);

    });
</script>
<?php } ?>