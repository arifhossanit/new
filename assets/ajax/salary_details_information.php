<?php 
// error_reporting(0);
include("../../application/config/ajax_config.php");
if(isset($_POST['id'])){
	$employee_information = mysqli_fetch_assoc($mysqli->query("SELECT * from employee_monthly_sallary INNER JOIN employee using(employee_id) where employee_monthly_sallary.id = ".$_POST['id']));
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
						<img class="logo" src="<?php echo $home; ?>assets/img/neways.png" alt="" style="width:180px;">
					</figure>
					<div class="company-address">
						<h1 class="title" style="color:rgba(3, 169, 244, 0.6);margin-bottom:0px;"></h1>
					</div>
					<div class="company-contact" style="height:80px;background-color:#03a9f4;">
						<div class="phone left">
							<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjkuNzYycHgiIGhlaWdodD0iOS45NThweCINCgkgdmlld0JveD0iLTQuOTkyIDAuNTE5IDkuNzYyIDkuOTU4IiBlbmFibGUtYmFja2dyb3VuZD0ibmV3IC00Ljk5MiAwLjUxOSA5Ljc2MiA5Ljk1OCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+DQo8dGl0bGU+RmlsbCAxPC90aXRsZT4NCjxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPg0KPGcgaWQ9IlBhZ2UtMSIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+DQoJPGcgaWQ9IklOVk9JQ0UtMSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwMS4wMDAwMDAsIC01NC4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNBcnRib2FyZEdyb3VwIj4NCgkJPGcgaWQ9IlpBR0xBVkxKRSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMzAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIj4NCgkJCTxnIGlkPSJLT05UQUtUSSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMjY3LjAwMDAwMCwgMzUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TU2hhcGVHcm91cCI+DQoJCQkJPGcgaWQ9Ik92YWwtMS1feDJCXy1GaWxsLTEiPg0KCQkJCQk8cGF0aCBpZD0iRmlsbC0xIiBmaWxsPSIjOEJDMzRBIiBkPSJNOC43NjUsMTIuMzc1YzAuMDIsMC4xNjItMC4wMjgsMC4zMDMtMC4xNDMsMC40MjJMNy4yNDYsMTQuMTkNCgkJCQkJCWMtMC4wNjIsMC4wNy0wLjE0MywwLjEzMy0wLjI0MywwLjE4MmMtMC4xMDEsMC4wNDktMC4xOTcsMC4wOC0wLjI5NSwwLjA5NGMtMC4wMDcsMC0wLjAyOCwwLTAuMDYyLDAuMDA0DQoJCQkJCQljLTAuMDM0LDAuMDA1LTAuMDgsMC4wMDgtMC4xMzQsMC4wMDhjLTAuMTMxLDAtMC4zNDMtMC4wMjMtMC42MzUtMC4wNjhjLTAuMjkzLTAuMDQ1LTAuNjUxLTAuMTU4LTEuMDc2LTAuMzM2DQoJCQkJCQljLTAuNDI0LTAuMTgyLTAuOTA0LTAuNDUxLTEuNDQyLTAuODA5Yy0wLjUzNi0wLjM1Ny0xLjEwOS0wLjg1Mi0xLjcxNi0xLjQ3OWMtMC40ODEtMC40ODQtMC44OC0wLjk1LTEuMTk4LTEuMzkzDQoJCQkJCQlDMC4xMjgsOS45NS0wLjEyNSw5LjU0MS0wLjMxOSw5LjE2NGMtMC4xOTMtMC4zNzYtMC4zMzgtMC43MTctMC40MzQtMS4wMjNjLTAuMDk3LTAuMzA2LTAuMTYxLTAuNTctMC4xOTUtMC43OTINCgkJCQkJCWMtMC4wMzUtMC4yMjEtMC4wNS0wLjM5NC0wLjA0Mi0wLjUyMWMwLjAwNy0wLjEyNiwwLjAxLTAuMTk3LDAuMDEtMC4yMTFjMC4wMTQtMC4wOTksMC4wNDQtMC4xOTgsMC4wOTMtMC4zMDENCgkJCQkJCWMwLjA0OS0wLjEwMSwwLjEwOC0wLjE4NCwwLjE3Ni0wLjI0N2wxLjM3NS0xLjQwM2MwLjA5Ny0wLjA5OCwwLjIwNi0wLjE0NywwLjMzLTAuMTQ3YzAuMDksMCwwLjE2OSwwLjAyNiwwLjIzOCwwLjA3OQ0KCQkJCQkJQzEuMyw0LjY0OCwxLjM1OSw0LjcxNCwxLjQwNiw0Ljc5MWwxLjEwNiwyLjE0MWMwLjA2MiwwLjExNCwwLjA4LDAuMjM1LDAuMDUyLDAuMzdDMi41MzgsNy40MzYsMi40NzgsNy41NDgsMi4zODksNy42NA0KCQkJCQkJTDEuODgzLDguMTU3QzEuODY5LDguMTcxLDEuODU2LDguMTk0LDEuODQ2LDguMjI2QzEuODM1LDguMjU2LDEuODMsOC4yODMsMS44Myw4LjMwNGMwLjAyNywwLjE0NywwLjA5LDAuMzE3LDAuMTg3LDAuNTA3DQoJCQkJCQljMC4wODIsMC4xNjksMC4yMSwwLjM3NSwwLjM4MiwwLjYxOGMwLjE3MiwwLjI0MywwLjQxNywwLjUyMSwwLjczNCwwLjgzOWMwLjMxMSwwLjMyMiwwLjU4NSwwLjU3NCwwLjgyOCwwLjc1NQ0KCQkJCQkJYzAuMjQsMC4xNzgsMC40NDMsMC4zMDksMC42MDQsMC4zOTVjMC4xNjIsMC4wODUsMC4yODYsMC4xMzUsMC4zNzIsMC4xNTRsMC4xMjgsMC4wMjRjMC4wMTUsMCwwLjAzOC0wLjAwNiwwLjA2Ny0wLjAxNg0KCQkJCQkJYzAuMDMyLTAuMDEsMC4wNTQtMC4wMjEsMC4wNjctMC4wMzdsMC41ODgtMC42MTJjMC4xMjUtMC4xMTIsMC4yNy0wLjE2OCwwLjQzNi0wLjE2OGMwLjExNywwLDAuMjA3LDAuMDIxLDAuMjc3LDAuMDYxaDAuMDENCgkJCQkJCWwxLjk5NSwxLjIwM0M4LjY1MSwxMi4xMiw4LjczNywxMi4yMzQsOC43NjUsMTIuMzc1TDguNzY1LDEyLjM3NXoiLz4NCgkJCQk8L2c+DQoJCQk8L2c+DQoJCTwvZz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==" alt=""><span class="helper"></span></span>
							<a href="tel:602-519-0450" style="text-decoration: none;font-size:20px;color:#000;">(+880) 96386-66333</a>
							<span class="helper"></span>
						</div>
						<div class="email right">
							<span class="circle"><img src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAxNS4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIg0KCSB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjE0LjE3M3B4Ig0KCSBoZWlnaHQ9IjE0LjE3M3B4IiB2aWV3Qm94PSIwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwLjM1NCAtMi4yNzIgMTQuMTczIDE0LjE3MyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSINCgk+DQo8dGl0bGU+ZW1haWwxOTwvdGl0bGU+DQo8ZGVzYz5DcmVhdGVkIHdpdGggU2tldGNoLjwvZGVzYz4NCjxnIGlkPSJQYWdlLTEiIHNrZXRjaDp0eXBlPSJNU1BhZ2UiPg0KCTxnIGlkPSJJTlZPSUNFLTEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00MTcuMDAwMDAwLCAtNTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCI+DQoJCTxnIGlkPSJaQUdMQVZMSkUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDMwLjAwMDAwMCwgMTUuMDAwMDAwKSIgc2tldGNoOnR5cGU9Ik1TTGF5ZXJHcm91cCI+DQoJCQk8ZyBpZD0iS09OVEFLVEkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDI2Ny4wMDAwMDAsIDM1LjAwMDAwMCkiIHNrZXRjaDp0eXBlPSJNU1NoYXBlR3JvdXAiPg0KCQkJCTxnIGlkPSJPdmFsLTEtX3gyQl8tZW1haWwxOSIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTE3LjAwMDAwMCwgMC4wMDAwMDApIj4NCgkJCQkJPHBhdGggaWQ9ImVtYWlsMTkiIGZpbGw9IiM4QkMzNEEiIGQ9Ik0zLjM1NCwxNC4yODFoMTQuMTczVjUuMzQ2SDMuMzU0VjE0LjI4MXogTTEwLjQ0LDEwLjg2M0w0LjYyNyw2LjAwOGgxMS42MjZMMTAuNDQsMTAuODYzDQoJCQkJCQl6IE04LjEyNSw5LjgxMkw0LjA1LDEzLjIxN1Y2LjQwOUw4LjEyNSw5LjgxMnogTTguNjUzLDEwLjI1M2wxLjc4OCwxLjQ5M2wxLjc4Ny0xLjQ5M2w0LjAyOSwzLjM2Nkg0LjYyNEw4LjY1MywxMC4yNTN6DQoJCQkJCQkgTTEyLjc1NSw5LjgxMmw0LjA3NS0zLjQwM3Y2LjgwOEwxMi43NTUsOS44MTJ6Ii8+DQoJCQkJPC9nPg0KCQkJPC9nPg0KCQk8L2c+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=" alt=""><span class="helper"></span></span>
							<a href="mailto:info@superhomebd.com" style="text-decoration: none;font-size:20px;color:#000;">info@superhomebd.com</a>
							<span class="helper"></span>
						</div>
						
					</div>
					<div style="width:100%;float:left;">
						<center>
							<h1 style="font-size:3em;font-weight:600;margin: 0.2em 0;"><u>Employee Payslip</u></h1>
						</center>
					</div>
				</div>
			</header>

			<section>
				<div class="container">
					<div class="details clearfix">
						<div class="client left" style="font-size:20px;line-height:30px;">					
							<p>Paid To:</p>	
							<p class="name" style="color:rgba(3, 169, 244, 0.6);font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $employee_information['full_name'] . ' ('.$employee_information['employee_id'].')'; ?></p>
							<p><i class="fas fa-briefcase"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $employee_information['designation_name'].', '.$employee_information['department_name']; ?></strong></p>
						</div>
						<div class="data right">
							<div class="date" style="font-weight:bolder;line-height: 30px;">
								<?php $salary_date = DateTime::createFromFormat('d/m/Y', '01/'.$employee_information['date_full']); ?>
								<style>.right_cs_t tr{background-color:none;} .right_cs_t td{font-size:20px;color:#000;background:none;border:none;padding:2px;}</style>
								<table class="table table-sm right_cs_t" style="width:80%;float:right;" border="0" border-spacing="0">
									<tr>
										<td>Salary Month</td>
										<td>:</td>
										<td><strong style="font-weight:bolder;"><?php echo $salary_date->format('F, Y'); ?></strong></td>
									</tr>									
								</table>
							</div>
						</div>
					</div>
					<?php
						$total_salary = $employee_information['attendence_wise_sallary'] - $employee_information['slary_deduction'];
						$basic = $total_salary * 0.6;
						$house_rent = $total_salary * 0.3;
						$medical = $total_salary * 0.06;
						$ta = $total_salary * 0.04;
						$sub_total = $total_salary;
					?>
					<table class="subtotal" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
						<thead>
							<tr>
								<th class="desc" style="color:#000;">#</th>
								<th class="total" style="color:#000;">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="desc">
									<h4 style="color:#000;"> Basic </h4>
								</td>
								<td class="total" style="color:#000;"><?= money(round($basic)); ?></td>
							</tr>
							<tr>
								<td class="desc">
									<h4 style="color:#000;"> House Rent </h4>
								</td>
								<td class="total" style="color:#000;"><?= money(round($house_rent)); ?></td>
							</tr>
							<tr>
								<td class="desc">
									<h4 style="color:#000;"> Medical Allowance </h4>
								</td>
								<td class="total" style="color:#000;"><?= money(round($medical)); ?></td>
							</tr>
							<tr>
								<td class="desc">
									<h4 style="color:#000;"> Transport Allowance </h4>
								</td>
								<td class="total" style="color:#000;"><?= money(round($ta)); ?></td>
							</tr>
							<?php
								if($employee_information['festival_deauty_bonus'] != '0'){
									$sub_total += $employee_information['festival_deauty_bonus'];
							?>								
								<tr>
									<td class="desc">
										<h4 style="color:#000;"> Festival Bonus </h4>
									</td>
									<td class="total" style="color:#000;"><?= money($employee_information['festival_deauty_bonus']); ?></td>
								</tr>
							<?php } ?>
							<?php
								if($employee_information['attendance_bonus'] != '0'){
									$sub_total += $employee_information['attendance_bonus'];
							?>								
								<tr>
									<td class="desc">
										<h4 style="color:#000;"> Attendance Bonus </h4>
									</td>
									<td class="total" style="color:#000;"><?= money($employee_information['attendance_bonus']); ?></td>
								</tr>
							<?php } ?>
							<?php
								if($employee_information['performance_bonus'] > 0){
									$sub_total += $employee_information['attendance_bonus'];
							?>								
								<tr>
									<td class="desc">
										<h4 style="color:#000;"> Performance Bonus </h4>
									</td>
									<td class="total" style="color:#000;"><?= money($employee_information['performance_bonus']) . ' (<span class="text-secondary">'.$employee_information['performance_bonus_percentage'].'%</span>)'; ?></td>
								</tr>
							<?php } ?>								
							<tr>
								<td style="background: white;color: black;">
									<h4> Total </h4>
								</td>
								<td style="background: white;color: black;"><?= money($sub_total); ?></td>
							</tr>
								<tr>
									<td class="desc">
										<h4 style="color:#000;"> Advance Salary </h4>
									</td>
									<?php if($employee_information['advance_salary'] != '0'){ ?>								
										<td class="total" style="color:red;">- <?= money($employee_information['advance_salary']); ?></td>
									<?php }else{ ?>
										<td class="total" style="color:#000;"><?= money($employee_information['advance_salary']); ?></td>
									<?php } ?>
								</tr>
							<?php
								if($employee_information['performance_bonus'] < 0){
							?>								
								<tr>
									<td class="desc">
										<h4 style="color:#000;"> Performance Bonus </h4>
									</td>
									<td class="total" style="color:red;">- <?= money(abs($employee_information['performance_bonus'])) . ' (<span class="text-secondary">'.$employee_information['performance_bonus_percentage'].'%</span>)'; ?></td>
								</tr>
							<?php } ?>																
							<tr>
								<td style="background: white;color: black;">
									<h4> Sub-total </h4>
								</td>
								<td style="background: white;color: black;"><?= money($employee_information['total_sallary']); ?></td>
							</tr>
						</tbody>
					</table>
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
				#print_area_new section table thead th {
					padding: 5px 10px;
					background: #03a9f4;
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
					background: rgba(3, 169, 244, 0.4);
					color: #777777;
					text-align: right;
					border-bottom: 5px solid #FFFFFF;
					border-right: 4px solid #E8F3DB;
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