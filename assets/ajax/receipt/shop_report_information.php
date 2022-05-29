<?php 
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['report_id'])){
	$d = explode('-',$_POST['report_id']);
	$date = $d[2].'/'.$d[1].'/'.$d[0];
	$branch = $_SESSION['super_admin']['branch'];
	$row = mysqli_fetch_assoc($mysqli->query("select * from refreshment_item_sell where branch_id = '".$branch."' and  payment_status = 'Paid' and data = '".$date."'"));
	
	$emaili = $_SESSION['super_admin']['email'];
	$date = $date;
	$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$branch."'"));
	$empi = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$emaili."'"));
?>
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="content-type" content="text-html; charset=utf-8">
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
					<a href="#" style="text-decoration: none;font-size:20px;color:#fff;">Date: <?php echo $date; ?></a>
					<span class="helper"></span>
				</div>
				<div class="email right">
					<span class="circle">
						<i class="fas fa-user"></i>
					</span>
					<a href="mailto:<?php echo $empi['email']; ?>" style="text-decoration: none;font-size:20px;color:#fff;">
						<?php echo $empi['full_name']; ?> - <?php echo $empi['employee_id']; ?>
					</a>
					<span class="helper"></span>
				</div>
				
			</div>
			<div style="width:100%;float:left;margin-top:20px;">
				<center>
					<h1 style="font-size:25px;font-weight:600;"><u>Purchase Report</u></h1>
				</center>
			</div>
		</div>
	</header>

	<section>
		<div class="container">
			<table class="subtotal" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
				<thead>
					<tr>
						<th class="qty" style="color:#000;">Sl</th>
						<th class="desc" style="color:#000;">Name - ID</th>						
						<th class="unit" style="color:#000;">Saler ID</th>
						<th class="unit" style="color:#000;">QTY</th>
						<th class="total" style="color:#000;">Total</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$pql = $mysqli->query("select * from refreshment_item_sell where branch_id = '".$branch."' and  payment_status = 'Paid' and data = '".$date."'");
					$i = 1;
					$grand_t = 0;
					$ttl = 0;
					while($pow = mysqli_fetch_assoc($pql)){
						$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$pow['booking_id']."' or card_number = '".$pow['buyer_id']."'"));
						$u = explode('___',$pow['uploader_info']);
						$email = $u[1];
						$emp = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$email."'"));
					$ttl = $pow['total_amount'];
					?>
					<tr>
						<td class="qty">
							<h3 style="color:#000;"><?php echo $i++; ?></h3>
						</td>
						<td class="desc"> <h4 style="color:#000;"><?php echo $member['full_name'].' - '.$member['card_number'];  ?></h4> </td>						
						<td class="total" style="color:#000;"><?php echo $emp['employee_id']; ?></td>
						<td class="unit" style="color:#000;"><?php echo $pow['total_qty']; ?></td>
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
			width: 5%;
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