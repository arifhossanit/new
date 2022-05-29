<?php 
// error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include("../../../application/config/ajax_config.php");
if(isset($_POST['slip_id'])){
	$sl_no = 1;
	$row = mysqli_fetch_assoc($mysqli->query("select branches.branch_name, employee.full_name, employee.employee_id,employee.designation_name, instant_transaction_slip_logs.* from instant_transaction_slip_logs INNER JOIN employee using(employee_id) INNER JOIN branches on branches.branch_id = instant_transaction_slip_logs.branch_id where slip_id = '".$_POST['slip_id']."'"));
	$min_max_date = mysqli_fetch_assoc($mysqli->query("SELECT MAX(str_to_date(data, '%d/%m/%Y')) as max_date, MIN(str_to_date(data, '%d/%m/%Y')) as min_date FROM `instant_transaction_logs` WHERE slip_id = '".$_POST['slip_id']."'"));
	$transaction_logs = $mysqli->query("SELECT * from instant_transaction_logs where slip_id = '".$_POST['slip_id']."'");
?>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta http-equiv="content-type" content="text-html; charset=utf-8">
<style>
	.row{display: flex;}
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
	/* .receipt-table.table-bordered > thead > tr{
		border:1px solid black;
	} */
	.transaction-receipt .receipt-table td, .receipt-table th {
		border: 1px solid black;
	}
	.transaction-receipt .receipt-table {
		border: 1px solid black;
	}
	.transaction-receipt .table thead th {
		vertical-align: bottom;
		border-bottom: 1px solid black;
	}
</style>
<div class="card bg-light transaction-body">
	<div class="card-body transaction-receipt">
		<div class="col-sm-12" style="margin-bottom:30px;">
			<button type="button" id="print_button_new" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
		</div>
		<div style="width:100%;margin-top:30px;float:left;"></div>
		<section id="print_area_new">
			<header class="clearfix" style="margin-bottom:15px;">
				<div class="container">
					<figure>
						<img class="logo" src="<?php echo $home; ?>assets/img/neways.png" alt="" style="width:180px;">
					</figure>
					<div class="company-address">
						<h1 class="title" style="color:rgba(3, 169, 244, 0.6);margin-bottom:0px;"></h1>
					</div>
					<div  style="height:80px;float: right">
						<strong>NEWAYS INTERNATIONAL COMPANY LIMITED</strong>
						<p>Corporate Office: House No. # 2/KA/10, Mymensingh</p>
						<p>Road, Shahbag, Dhaka-1000</p>
					</div>
					<div class="mt-4" style="width:60%;float:left;font-size: 18px;">
						<div style="display: grid;">
							<div style="grid-column-start: auto">
								Slip ID: <?= $_POST['slip_id'] ?>
							</div>
							<div style="grid-column-start: auto">
								Date: <?php $date = new DateTime($row['created_at']); echo $date->format('d/m/Y') ?>
							</div>
							<div style="grid-column-start: auto">
								Employee Name: <?= $row['full_name'] ?>
							</div>
							<div style="grid-column-start: auto">
								Employee ID & Designation: <?= $row['employee_id']." - ".$row['designation_name'] ?>
							</div>
						</div>
					</div>
					<div class="mt-3 text-align-end" style="float:right;font-size: 20px;">
						<p>Date Range: <?= $min_max_date['min_date'] . ' to ' . $min_max_date['max_date'] ?></p>
						<p>Branch: <b style="color: blue;"><?= $row['branch_name'] ?></b></p>
					</div>
					<div style="width:100%;float:left;">
						<center>
							<h1 style="font-size:2.5em;font-weight:600;margin: 0.2em 0;"><u>Expense Invoice</u></h1>
						</center>
					</div>
				</div>
			</header>

			<section class="footer-class" style="">
				<div class="container">
					<div class="details clearfix"></div>
					<table class="table table-bordered receipt-table" style="font-size:15px;">
						<thead>
							<tr>
								<th>SL No.</th>
								<th>Description</th>
								<th>Expense Made For</th>
								<th>Amount (TK)</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							<?php $total = 0;$i = 0; ?>
							<?php while($transaction = mysqli_fetch_assoc($transaction_logs)){ $i++; ?>
								<tr <?= ($i%15 == 0) ? 'class="page-break"' : ''?>>
									<td><?= $sl_no++ ?></td>
									<td><?= $transaction['note'] ?></td>
									<?php if(strpos($transaction['note'], 'Security Diposit') === false){ ?>
										<td class="transaction-td"><?= $transaction['transaction_id'] ?></td>
									<?php }else{											
											$booking_info = mysqli_fetch_assoc($mysqli->query("SELECT `transaction`.`transaction_id`, member_directory.full_name from transaction INNER JOIN member_directory USING(booking_id) where booking_id = (SELECT booking_id FROM `transaction` WHERE `transaction_id` LIKE '".$transaction['transaction_id']."') ORDER BY transaction.id ASC LIMIT 1"));
											$booking_transaction = "";
											if(!is_null($booking_info)){
												$booking_transaction = " <p> (".$booking_info['transaction_id'].": ".$booking_info['full_name'].")</p> ";
											}
									?>
										<td class="transaction-td"><?= $transaction['transaction_id'] . $booking_transaction ?></td>
									<?php } ?>
									<td><?= money($transaction['amount']) ?></td>
									<td><?= $transaction['data'] ?></td>
								</tr>
								<?php $total += $transaction['amount']; ?>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3">Total</td>
								<td><?= money($total); ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="m-5">
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
				<div class="container">
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

		<style type="text/css">
				
				#print_area_new p{
					margin:0px;
				}
				table {
					border-collapse: collapse; border-spacing: 0;
				}
				caption, th, td {
					text-align: left;
					/* font-weight: normal; */
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
				.transaction-body {
					font-family: 'Source Sans Pro', sans-serif;
					font-weight: 501;
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
					color: #03a9f4;
					font-weight: bolder;
					font-size: 25px;
					margin-top:0px;
					text-transform: uppercase;
				}
				header .company-contact {
					float: right;
					height: 60px;
					padding: 0 10px;
					background-color: #03a9f4;
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
				#print_area_new section {
					font-weight: 501;
				}
				#print_area_new section table thead th {
					/* padding: 5px 10px; */
					background: #03a9f4;
					/* border-bottom: 5px solid #FFFFFF; */
					/* border-right: 4px solid #FFFFFF; */
					text-align: center;
					color: white;
					font-weight: 501;
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
					background: rgba(3, 169, 244, 0.4);
					color: #777777;
					text-align: right;
					border-bottom: 5px solid black;
					border-right: 4px solid black;
				}
				
				#print_area_new section .subtotal tbody td { 
					padding: 5px;
					background: rgba(3, 169, 244, 0.4);
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
					font-weight: 900;
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
					color: rgba(3, 169, 244, 0.6);
					font-size: 1.18181818181818em;
				}
				footer {
					margin-bottom: 20px;
				}
				footer .thanks {
					margin-bottom: 15px;
					color: rgba(3, 169, 244, 0.6);
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
					border-top: 2px solid #03a9f4;
					margin-bottom: 5px;
				}
				.booking-form-tag{
					display: grid;
					justify-content: center;
					align-content: center;
					width: 100px;
					height: 100px;
					/* background-color: #03a9f4; */
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
					#print_area_new section table thead th {
						color: black;
					}
					
					.transaction-td{
						font-weight: bold;
					}
					.footer-class{
						margin-top: 67px !important;
					}
				}
				#print_area_new hr {
					margin-top: 1rem;
					/* margin-bottom: 1rem; */
					border: 0;
					border-top: 1px solid black;
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