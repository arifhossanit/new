<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['transaction_id'])){
$row = mysqli_fetch_assoc($mysqli->query("select * from transaction where id = '".$_POST['transaction_id']."'"));
$opt = explode("___",$row['uploader_info']);
$rentre = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$opt[1]."'"));
$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."'"));
include('../../../application/helpers/qrcode_helper.php');
$daaata = $home.'member-booking-information/qr-code/'.$row['booking_id'];
$file = '../../uploads/qrcode/booking_recipt_id_'.$row['booking_id'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2);
$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch_id']."'"));

//get withdraw_checkout s non returned items
$non_returned = mysqli_fetch_assoc($mysqli->query("select * from withdraw_checkout where  booking_id = '".$row['booking_id']."'"));
if(!empty($non_returned)){
	$non_returnd = $non_returned['checkout_iteams'];

	$non_returnd_items_sql = $mysqli->query("select * from checkout_iteam where id  in($non_returnd)");

	function isJson($string) {
	   json_decode($string);
	   return json_last_error() === JSON_ERROR_NONE;
	}
}


?>

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="content-type" content="text-html; charset=utf-8">
	
	<?php if(!empty($row['amount'])){ ?>
	<div class="col-sm-12" style="margin-bottom:30px;">
		<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
	</div>
	<?php } ?>
<div style="width:100%;margin-top:30px;float:left;"></div>
<section id="print_area">

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
					<h1 style="font-size:3em;font-weight:600;"><u>Payment Receipt</u></h1>
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
					<?php if(empty($member['email'])){ ?>
					<a href="mailto:<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'Not provided!'; } ?></a><br />
					<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php if(!empty($rentre['personal_Phone'])){ echo $rentre['personal_Phone']; }else{ echo 'Not provided!'; }  ?></a>
					<?php } ?>
					<div style="width:100%;margin-top:10px;"></div>
					<?php if(!empty($member['email'])){ ?>
					<hr />					
					<p>INVOICE TO:</p>
					<p class="name" style="color:green;font-weight:bolder;margin: 0px;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $member['full_name']; ?></p>
					<p style="margin: 0px;"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['address']; ?></p>
					<a href="mailto:<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['email'])){ echo $member['email']; }else{ echo 'Not provided!'; } ?></a><br />
					<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['phone_number']; ?></a>
					<p style="margin: 0px;"><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $member['bed_name']; ?></strong></p>
					<?php } ?>
				</div>
				<div class="data right">
					<?php
						$inv = explode('/',$row['data']);
						$invd = $inv[0].$inv[1].$inv[2];
						$id = mysqli_fetch_assoc($mysqli->query("select * from transaction where id = '".$row['id']."'"));
					?>
					<div class="title" style="color:green;font-size:33px;"><?php echo $row['transaction_id']; ?> </div>
					<?php if(!empty($member['email'])){ ?>
					<div class="date" style="font-weight:bolder;line-height: 30px;">
						<style>.right_cs_t tr{background-color:none;} .right_cs_t td{font-size:20px;color:#000;background:none;border:none;padding:2px;}</style>
						<table class="table table-sm right_cs_t" style="width:80%;float:right;" border="0" border-spacing="0">
							<tr>
								<td>Checkout Date</td>
								<td>:</td>
								<td><strong style="font-weight:bolder;"><?php echo $member['check_out_date']; ?></strong></td>
							</tr>
							<tr>
								<td>Date of Invoice</td>
								<td>:</td>
								<td><strong style="font-weight:bolder;"><?php echo $row['data']; ?></strong></td>
							</tr>
							<tr>
								<td>CheckIn Date</td>
								<td>:</td>
								<td><strong style="font-weight:bolder;"><?php echo $member['check_in_date']; ?></strong></td>
							</tr>
							<tr>
								<td>Card Number</td>
								<td>:</td>
								<td><strong style="font-weight:bolder;"><?php echo $member['card_number']; ?></strong></td>
							</tr>							
						</table>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<?php $payment_info = mysqli_fetch_assoc($mysqli->query("select * from payment_logs where booking_id = '".$member['booking_id']."' and data = '".$row['data']."'")); ?>
				<h3 class="text-center"><?php echo $row['note']; ?></h3>
				<table class="sub-total" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
					<thead>
						<tr>
							<th>#</th>
							<th>Items</th>
							<th>Cost</th>
						</tr>
					</thead>
					<tbody>
					
						<?php 
						$total_arr = [];
						$row_count = 1;
						if(!empty($non_returnd_items_sql)){
						
						
						while($return_row = $non_returnd_items_sql->fetch_assoc()){ 
						$total_arr[] = $return_row['lost_amount'];
						?>
						<tr >
							<td><?php echo $row_count;  ?></td>
							<td><?php echo $return_row['checkout_iteam']; ?></td>
							<td><?php echo $return_row['lost_amount']; ?></td>
						</tr>
						<?php $row_count++; } ?>
						
						<?php
						if(isJson($non_returned['additional_items'])){
							
							$additional_items = json_decode($non_returned['additional_items'], true);

						foreach($additional_items as $key => $value) {
						?>
						<tr>
							<td><?php echo $row_count;  ?></td>
							<td><?php echo $key;  ?></td>
							<td><?php echo $value;  ?></td>
						</tr>
						<?php $row_count++; } 
	 
							}else{
						?>
						<tr>
							
							<td colspan='3'><strong><?php echo !empty($non_returned['additional_items']) ? rtrim($non_returned['additional_items'], ','): null; ?></strong></td>
						</tr>
						<?php } } ?>
						<tr>
							<td></td>
							<td><strong><?php if(empty($non_returnd_items_sql)){ echo $row['note']; }else{ echo "SUBTOTAL:"; } ?></strong></td>
							<td>
								<strong style="font-weight:bolder;">
									<?php echo money($row['amount']); ?>
								</strong>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><strong>GRAND TOTAL:</strong></td>
							<td><strong><?php echo money($row['amount']); ?></strong></td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<?php if(!empty($row['amount'])){ ?>
			<div class="no-break">
				<div style="width:100%;float:left;color: #000; font-size: 20px; font-weight: 500;">
					<div style="float:left;width:50%;">
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
					<div style="float:left;width:50%;">
						<?php if(!empty($member['email'])){ if(!empty($payment_info['remarks'])){ echo $payment_info['remarks']; } } else{
							$tn_trn = $mysqli->query("select * from instant_transaction_iteams where transaction_id = '".$row['transaction_id']."'");
							echo '<ul>';
							while($trns_itm = mysqli_fetch_assoc($tn_trn)){
								echo '<li>'.$trns_itm['item_name'].' - '.$trns_itm['purpose'].'</li>';
							}
							echo '</ul>';
						}
						?>
					</div>					
				</div>
			</div>
			<?php } ?>
		</div>
	</section>

	<footer>
		<div class="container">
			<div class="thanks">
				Thank you!
			</div>
			<div class="notice">
				<div>NOTICE:</div>
				<div>A finance per day charge of BDT 100/- will be made on unpaid rent after 10 days.</div>
			</div>
			<div class="end">Invoice was created on a computer and is valid without the signature and seal.</div>
		</div>
	</footer>

<style type="text/css">
		#print_area table {
			border-collapse: collapse; border-spacing: 0;
		}

		#print_area caption, th, td {
			text-align: left;
			font-weight: normal;
			vertical-align: middle;
		}

		#print_area q, blockquote {
			quotes: none;
		}
		#print_area q:before, q:after, blockquote:before, blockquote:after {
			content: "";
			content: none;
		}

		#print_area a img {
			border: none;
		}

		#print_area article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
			display: block;
		}

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

		#print_area header {
			margin-top: 20px;
			margin-bottom: 50px;
		}
		#print_area header figure {
			float: left;
			text-align: center;
			margin:0px;
			margin-right: 10px;
		}

		#print_area header .company-address {
			float: left;
			max-width: 150px;
			line-height: 1.7em;
			font-weight:bolder;
		}
		#print_area header .company-address .title {
			color: #8BC34A;
			font-weight: bolder;
			font-size: 25px;
			margin-top:0px;
			text-transform: uppercase;
		}
		#print_area header .company-contact {
			float: right;
			height: 60px;
			padding: 0 10px;
			background-color: #8BC34A;
			color: white;
			padding-right:0px;
			font-weight:bolder;
		}
		#print_area header .company-contact span {
			display: inline-block;
			vertical-align: middle;
		}
		#print_area header .company-contact .circle {
			width: 30px;
			height: 30px;
			background-color: white;
			border-radius: 50%;
			text-align: center;
			margin-right:10px;
		}
		#print_area header .company-contact .circle img {
			vertical-align: middle;
		}
		#print_area header .company-contact .phone {
			height: 100%;
			margin-right: 20px;
		}
		#print_area header .company-contact .email {
			height: 100%;
			min-width: 100px;
			text-align: right;
		}

		#print_area section .details {
			margin-bottom: 10px;
		}
		#print_area section .details .client {
			width: 50%;
			line-height: 20px;
			font-weight:bolder;
		}
		#print_area section .details .client .name {
			color: #8BC34A;
		}
		#print_area section .details .data {
			width: 50%;
			text-align: right;
		}
		#print_area section .details .title {
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
			background: #8BC34A;
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
		
		#print_area section .sub-total tbody td {
			padding: 5px;
			background: #E8F3DB;
			color: #777777;
			text-align: right;
			border-bottom: 5px solid #FFFFFF;
			border-right: 4px solid #E8F3DB;
		}
		
		#print_area section .grand-total tbody td {
			padding: 5px;
			background: #E8F3DB;
			color: #777777;
			text-align: right;
			border-bottom: 5px solid #FFFFFF;
			border-right: 4px solid #E8F3DB;
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
		
		
		

		#print_area footer {
			margin-bottom: 20px;
		}
		#print_area footer .thanks {
			margin-bottom: 40px;
			color: #8BC34A;
			font-size: 1.16666666666667em;
			font-weight: 600;
		}
		#print_area footer .notice {
			margin-bottom: 25px;
		}
		#print_area footer .end {
			padding-top: 5px;
			border-top: 2px solid #8BC34A;
			text-align: center;
		}
	</style>

</section>	

<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>
<script>
    $('#print_button').on("click", function () {
      $('#print_area').printThis({
      });
    });
</script>
<?php } ?>

<!--Last edit date-->
<?/*
	*Payment pettarn
	*payment purpose
	date: 18/04/2021
*/?>
<!--Last edit date-->