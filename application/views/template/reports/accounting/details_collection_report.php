<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Details Collection Report</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Report</a></li>
						<li class="breadcrumb-item"><a href="#">Collection Report</a></li>
						<li class="breadcrumb-item active">Details Collection Report</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	<div class="content">
		<div class="container-fluid">
			<div class="row">			
				<div class="col-sm-12">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Details Collection Report</h3>
							<div id="export_buttons" style="float: right;"></div>
						</div>
						<div class="card-body">
							<form id="details_collection_form" action="<?php echo current_url(); ?>" method="POST">
								<div class="row">
									<div class="col-sm-2">
										<div class="form-group">
											<label>Select Month</label>
											<input type="month" name="month_filter" value="<?php if(!empty($_POST['month_filter'])){ echo $_POST['month_filter']; } else{ echo date('Y-m'); } ?>" min="<?php echo date('2021-05'); ?>" class="form-control" required />
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label>Select Branch</label>
											<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
											<select name="branch_id" class="form-control select2" required>
												<option value="1">All Branch</option>
												<?php
													$branches = $this->Dashboard_model->mysqlii("SELECT * FROM branches WHERE status = '1'");
													foreach($branches as $row){
														if(!empty($_POST['branch_id'])){ if($_POST['branch_id'] == 1){ $selected = ''; }else{ if($_POST['branch_id'] == $row->branch_id){ $selected = 'selected'; }else{ $selected = ''; } } }else{ $selected = ''; }																											
														echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
													}
												?>
											</select>
											<?php }else{ ?>
											<select name="branch_id" class="form-control select2" required>
												<?php
													$branches = $this->Dashboard_model->mysqlii("SELECT * FROM branches WHERE status = '1'");
													foreach($branches as $row){
														if($_SESSION['user_info']['department'] == '2270968637477766714'){
															if(!empty($_POST['branch_id'])){ if($_POST['branch_id'] == 1){ $selected = ''; }else{ if($_POST['branch_id'] == $row->branch_id){ $selected = 'selected'; }else{ $selected = ''; } } }else{ $selected = ''; }		
															echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
														} else if($_SESSION['super_admin']['branch'] == $row->branch_id){
															if(!empty($_POST['branch_id'])){ if($_POST['branch_id'] == 1){ $selected = ''; }else{ if($_POST['branch_id'] == $row->branch_id){ $selected = 'selected'; }else{ $selected = ''; } } }else{ $selected = ''; }																											
															echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
														}
													}
												?>
											</select>
											<?php } ?>
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label>&nbsp;</label>
											<button name="apply_filter" type="submit" class="btn btn-success" style="width:100%;">Filter</button>
										</div>
									</div>
								</div>
							
								<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}</style>
								<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size:16px;white-space: nowrap;">
									<thead>
										<tr>
											<th>SL:</th>
											<th>Date</th>
											<th>Security Deposit</th>
											<th>Rent</th>
											<th>E-Bill</th>
											<th>Panalty</th>
											<th>Locker</th>
											<th>Parking</th>
											<th title="Due Collection (Tea & Coffee)">Due:coll(T&C)</th><!--Tea & Coffee-->
											<th>Card Charge</th>										
											<th>Refreshment</th>
											<th>Package Shifting</th>									
											<th>Card Change</th>
											<th>Bed Change</th>
											<th>Deposit Adjustment</th>
											<th>Auto:Sum</th>
											<th>Coll:Total</th>										
											<th>Extra</th>
											<th><abbr title="Add Money" style="color:green;">AM</abbr></th>
											<th><abbr title="DEDUCT Money" style="color:red;">DM</abbr></th>
											<th>Note</th>
											<?php if($_SESSION['user_info']['department'] == '816905694932688665'){ ?>
											<th>#</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
<?php
if(isset($_POST['month_filter'])){
	$m = explode("-",$_POST['month_filter']);
	$year = $m[0];
	$month = $m[1];
	$number_of_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
	if($_POST['branch_id'] == 1){
		$branch_filter = "";
		$branch_filter_join = "";
	}else{
		$branch_filter = " AND branch_id = '".$_POST['branch_id']."'";
		$branch_filter_join = " AND member_directory.branch_id = '".$_POST['branch_id']."'";
	}
}else{
	$year = date('Y');
	$month = date('m');
	$number_of_days = cal_days_in_month(CAL_GREGORIAN,$month,$year);
	if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
		$branch_filter = "";
		$branch_filter_join = "";
	}else{
		$branch_filter = " AND branch_id = '".$_SESSION['super_admin']['branch']."'";
		$branch_filter_join = " AND member_directory.branch_id = '".$_SESSION['super_admin']['branch']."'";
	}
}
$final_total_security_diposit = 0;
$final_total_rent = 0;
$final_total_ebil = 0;
$final_total_panalty = 0;
$final_total_locker = 0;
$final_total_parking = 0;
$final_total_teacoffe = 0;
$final_total_cardcharrge = 0;
$final_total_refreshment = 0;
$final_total_packagechange = 0;
$final_total_cardchange = 0;
$final_total_bedchange = 0;
$final_total_deposit_back = 0;
$final_total_ttotal = 0;
$final_total_ctotal = 0;
$final_total_extra = 0;
$final_total_add = 0;
$final_total_deduct = 0;

for($i = 1; $i <= $number_of_days ; $i++ ){
	$number = sprintf("%02d", $i);
	$date = $number.'/'.sprintf("%02d",$month).'/'.$year;
	$security_diposit = $this->Dashboard_model->mysqlii("SELECT SUM(security_deposit) AS security_deposit_total FROM booking_receipt_logs WHERE data = '".$date."' $branch_filter");
	$rent = $this->Dashboard_model->mysqlii("
		SELECT SUM(rent_amount) AS rent_amount_total, 
		SUM(electricity) AS electricity_total,				
		SUM(penalty) AS panalty_total,				
		SUM(locker) AS locker_total,				
		SUM(parking) AS parking_total,				
		SUM(card_p_amount) AS card_p_amount_total,			
		SUM(tea_coffee) AS tea_coffee_total
		FROM rent_info WHERE payment_pattern NOT IN ('2') AND data = '".$date."' $branch_filter
	");	

	$ad_payment_e_bill = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS electricity_total FROM payment_logs WHERE payment_type = 'Electric Bill' AND data = '".$date."' $branch_filter");
	$ad_payment_panalty = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS panalty_total FROM payment_logs WHERE payment_type = 'Penalty' AND data = '".$date."' $branch_filter");
	$ad_payment_locker = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS locker_total FROM payment_logs WHERE payment_type = 'Locker' AND data = '".$date."' $branch_filter");
	$ad_payment_parking = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS parking_total FROM payment_logs WHERE payment_type = 'Parking' AND data = '".$date."' $branch_filter");
	$ad_payment_rent = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS rent_total FROM payment_logs WHERE payment_type = 'Rent' AND data = '".$date."' $branch_filter");

	$refreshment = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS refreshment_total FROM transaction WHERE transaction_category = 'Refreshment Iteam' AND data = '".$date."' $branch_filter");	
	// $package_shift = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS package_shift_total FROM transaction WHERE ( transaction_category = 'Package Shifting Account' OR transaction_category = 'Booking Account (Add Payment)' ) AND data = '".$date."' $branch_filter");	
	$package_shift = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS package_shift_total FROM transaction WHERE transaction_category = 'Package Shifting Account' AND data = '".$date."' $branch_filter");	
	$card_change = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS card_change_total FROM transaction WHERE transaction_category = 'Card Change Account' AND data = '".$date."' $branch_filter");	
	$bed_change = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS bed_change_total FROM transaction WHERE transaction_category = 'Bed Change Account' AND data = '".$date."' $branch_filter");
	// $aggrement_deposit_return = $this->Dashboard_model->mysqlii("SELECT SUM(aggreement_monthly_deposit_back.amount) AS deposit_return_total FROM aggreement_monthly_deposit_back INNER JOIN member_directory using(booking_id) WHERE aggreement_monthly_deposit_back.data = '".$date."' $branch_filter_join GROUP BY aggreement_monthly_deposit_back.booking_id ORDER BY aggreement_monthly_deposit_back.id desc ");
	// $aggrement_deposit_return = $this->Dashboard_model->mysqlii("SELECT SUM(amount) AS deposit_return_total FROM aggreement_monthly_deposit_back where id in (SELECT max(aggreement_monthly_deposit_back.id) FROM aggreement_monthly_deposit_back INNER JOIN member_directory using(booking_id) WHERE aggreement_monthly_deposit_back.data = '".$date."' $branch_filter_join GROUP BY aggreement_monthly_deposit_back.booking_id)");

	$deposit_return = 0;
	$deposits = $this->Dashboard_model->mysqlii("SELECT member_directory.booking_date, aggreement_monthly_deposit_back.id, aggreement_monthly_deposit_back.data, aggreement_monthly_deposit_back.booking_id, aggreement_monthly_deposit_back.amount FROM aggreement_monthly_deposit_back INNER JOIN member_directory using(booking_id) WHERE aggreement_monthly_deposit_back.data = member_directory.data AND member_directory.data = '$date' $branch_filter_join");
	foreach($deposits as $deposit){
		$compare = DateTime::createFromFormat('d/m/Y', $deposit->data);
		$only_date = substr($deposit->booking_date, 0, 10);
		$validate = $this->Dashboard_model->mysqlij("SELECT count(*) as validate FROM aggreement_monthly_deposit_back where STR_TO_DATE(data, '%d/%m/%Y') < '".$compare->format('Y-m-d')."' AND booking_id = '".$deposit->booking_id."' and data != '$only_date'");
		if($validate->validate == 0){
			$deposit_return += $deposit->amount;
		}
	}
	// $aggrement_deposit_return = $this->Dashboard_model->mysqlii("SELECT SUM(aggreement_monthly_deposit_back.amount) AS deposit_return_total FROM aggreement_monthly_deposit_back INNER JOIN member_directory using(booking_id) WHERE aggreement_monthly_deposit_back.data = '".$date."' $branch_filter_join");

		
	$get_transaction = $this->Dashboard_model->mysqlii("SELECT * FROM transaction WHERE transaction_type = 'Credit' AND data = '".$date."' $branch_filter");
	$card_amount = 0;
	$cash_amount = 0;
	$mobile_amount = 0;
	$check_amount = 0;
	foreach($get_transaction AS $row){
		$c_total = $this->Dashboard_model->mysqlii("
			SELECT SUM(card_amount) AS card_a,
			SUM(cash_amount) AS cash_a,
			SUM(mobile_amount) AS mobile_a,
			SUM(check_amount) AS check_a
			FROM payment_received_method WHERE transaction_id = '".$row->transaction_id."'
		");
		$card_amount = $card_amount + (float)$c_total[0]->card_a;
		$cash_amount = $cash_amount + (float)$c_total[0]->cash_a;
		$mobile_amount = $mobile_amount + (float)$c_total[0]->mobile_a;
		$check_amount = $check_amount + (float)$c_total[0]->check_a;
	}
	
	if($card_amount > 0){
		$card_amount = $card_amount;
	}else{
		$card_amount = 0;
	} 
	if($cash_amount > 0){
		$cash_amount = $cash_amount;
	}else{
		$cash_amount = 0;
	} 
	if($mobile_amount > 0){
		$mobile_amount = $mobile_amount;
	}else{
		$mobile_amount = 0;
	} 
	if($check_amount > 0){
		$check_amount = $check_amount;
	}else{
		$check_amount = 0;
	} 
	
	$check_button = $this->Dashboard_model->mysqlii("SELECT * FROM details_report_deduction_logs WHERE work_date = '".$date."' $branch_filter");
	if(!empty($check_button[0]->id)){
		$add_money_security = 0;
		$deduct_money_security = 0;
		$add_money_rent = 0;
		$deduct_money_rent = 0;
		$add_money_ebill = 0;
		$deduct_money_ebill = 0;
		$add_money_panalty = 0;
		$deduct_money_panalty = 0;
		$add_money_locker = 0;
		$deduct_money_locker = 0;
		$add_money_parking = 0;
		$deduct_money_parking = 0;
		$add_money_teacoffee = 0;
		$deduct_money_teacoffee = 0;
		$add_money_cardcharge = 0;
		$deduct_money_cardcharge = 0;
		$add_money_refreshment = 0;
		$deduct_money_refreshment = 0;
		$add_money_packageshift = 0;
		$deduct_money_packageshift = 0;
		$add_money_cardchange = 0;
		$deduct_money_cardchange = 0;
		$add_money_bedchange = 0;
		$deduct_money_bedchange = 0;
		$add_money_extra = 0;
		$deduct_money_extra = 0;
		
		foreach($check_button as $row){ 
			if($row->head_type == 'Security Deposit'){
				if($row->adj_type == 1){
					$add_money_security = $add_money_security + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_security = $deduct_money_security + $row->amount;
				}
			}else if($row->head_type == 'Rent'){
				if($row->adj_type == 1){
					$add_money_rent = $add_money_rent + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_rent = $deduct_money_rent + $row->amount;
				}
			}else if($row->head_type == 'E-Bill'){
				if($row->adj_type == 1){
					$add_money_ebill = $add_money_ebill + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_ebill = $deduct_money_ebill + $row->amount;
				}
			}else if($row->head_type == 'Panalty'){
				if($row->adj_type == 1){
					$add_money_panalty = $add_money_panalty + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_panalty = $deduct_money_panalty + $row->amount;
				}
			}else if($row->head_type == 'Locker'){
				if($row->adj_type == 1){
					$add_money_locker = $add_money_locker + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_locker = $deduct_money_locker + $row->amount;
				}
			}else if($row->head_type == 'Parking'){
				if($row->adj_type == 1){
					$add_money_parking = $add_money_parking + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_parking = $deduct_money_parking + $row->amount;
				}
			}else if($row->head_type == 'Tea & Coffee'){
				if($row->adj_type == 1){
					$add_money_teacoffee = $add_money_teacoffee + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_teacoffee = $deduct_money_teacoffee + $row->amount;
				}
			}else if($row->head_type == 'Card Charge'){
				if($row->adj_type == 1){
					$add_money_cardcharge = $add_money_cardcharge + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_cardcharge = $deduct_money_cardcharge + $row->amount;
				}
			}else if($row->head_type == 'Refreshment'){
				if($row->adj_type == 1){
					$add_money_refreshment = $add_money_refreshment + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_refreshment = $deduct_money_refreshment + $row->amount;
				}
			}else if($row->head_type == 'Package Shifting'){
				if($row->adj_type == 1){
					$add_money_packageshift = $add_money_packageshift + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_packageshift = $deduct_money_packageshift + $row->amount;
				}
			}else if($row->head_type == 'Card Change'){
				if($row->adj_type == 1){
					$add_money_cardchange = $add_money_cardchange + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_cardchange = $deduct_money_cardchange + $row->amount;
				}
			}else if($row->head_type == 'Bed Change'){
				if($row->adj_type == 1){
					$add_money_bedchange = $add_money_bedchange + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_bedchange = $deduct_money_bedchange + $row->amount;
				}
			}else if($row->head_type == 'Extra'){
				if($row->adj_type == 1){
					$add_money_extra = $add_money_extra + $row->amount;
				}else if($row->adj_type == 2){
					$deduct_money_extra = $deduct_money_extra + $row->amount;
				}
			}		
		}		
		$button_date = "'".$check_button[0]->work_date."'";
		$button = '<button onclick="return view_deduction_logs('.$button_date.')" type="button" class="btn btn-xs btn-warning"><i class="far fa-eye"></i></button>';
	}else{
		$button = '--';
		$add_money_security = 0;
		$deduct_money_security = 0;
		$add_money_rent = 0;
		$deduct_money_rent = 0;
		$add_money_ebill = 0;
		$deduct_money_ebill = 0;
		$add_money_panalty = 0;
		$deduct_money_panalty = 0;
		$add_money_locker = 0;
		$deduct_money_locker = 0;
		$add_money_parking = 0;
		$deduct_money_parking = 0;
		$add_money_teacoffee = 0;
		$deduct_money_teacoffee = 0;
		$add_money_cardcharge = 0;
		$deduct_money_cardcharge = 0;
		$add_money_refreshment = 0;
		$deduct_money_refreshment = 0;
		$add_money_packageshift = 0;
		$deduct_money_packageshift = 0;
		$add_money_cardchange = 0;
		$deduct_money_cardchange = 0;
		$add_money_bedchange = 0;
		$deduct_money_bedchange = 0;
		$add_money_extra = 0;
		$deduct_money_extra = 0;
	} 
	
	$add_money = 
		$add_money_security +
		$add_money_rent +
		$add_money_ebill +
		$add_money_panalty +
		$add_money_locker +
		$add_money_parking +
		$add_money_teacoffee +
		$add_money_cardcharge +
		$add_money_refreshment +
		$add_money_packageshift +
		$add_money_cardchange +
		$add_money_bedchange +
		$add_money_extra
	;
	
	$deduct_money = 
		$deduct_money_security +
		$deduct_money_rent +
		$deduct_money_ebill +
		$deduct_money_panalty +
		$deduct_money_locker +
		$deduct_money_parking +
		$deduct_money_teacoffee +
		$deduct_money_cardcharge +
		$deduct_money_refreshment +
		$deduct_money_packageshift +
		$deduct_money_cardchange +
		$deduct_money_bedchange +
		$deduct_money_extra
	;
	
	if($add_money > 0){
		$add_money = $add_money;
	}else{
		$add_money = 0;
	} 
	if($deduct_money > 0){
		$deduct_money = $deduct_money;
	}else{
		$deduct_money = 0;
	} 

	$final_security_diposit = $security_diposit[0]->security_deposit_total + $add_money_security - $deduct_money_security;
	$final_rent = $rent[0]->rent_amount_total + $ad_payment_rent[0]->rent_total + $add_money_rent - $deduct_money_rent;
	$final_ebill = $rent[0]->electricity_total + $ad_payment_e_bill[0]->electricity_total + $add_money_ebill - $deduct_money_ebill;
	$final_panalty = $rent[0]->panalty_total + $ad_payment_panalty[0]->panalty_total + $add_money_panalty - $deduct_money_panalty;
	$final_locker = $rent[0]->locker_total + $ad_payment_locker[0]->locker_total + $add_money_locker - $deduct_money_locker;
	$final_parking = $rent[0]->parking_total + $ad_payment_parking[0]->parking_total + $add_money_parking - $deduct_money_parking;
	$final_teacoffee = $rent[0]->tea_coffee_total + $add_money_teacoffee - $deduct_money_teacoffee;
	$final_cardcharge = $rent[0]->card_p_amount_total + $add_money_cardcharge - $deduct_money_cardcharge;
	$final_refreshment = $refreshment[0]->refreshment_total + $add_money_refreshment - $deduct_money_refreshment;
	$final_packageshift = $package_shift[0]->package_shift_total + $add_money_packageshift - $deduct_money_packageshift;
	$final_cardchange = $card_change[0]->card_change_total + $add_money_cardchange - $deduct_money_cardchange;
	$final_bedchange = $bed_change[0]->bed_change_total + $add_money_bedchange - $deduct_money_bedchange;	
	
	$total_t = 
		$final_security_diposit +
		$final_rent +
		$final_ebill +
		$final_panalty +
		$final_locker +
		$final_parking +
		$final_teacoffee +
		$final_cardcharge +
		$final_refreshment +
		$final_packageshift +
		$final_cardchange +
		$final_bedchange + 
		$deposit_return
	;
	
	
	$g_c_total = $card_amount + $cash_amount + $mobile_amount + $check_amount;
	$extra = $g_c_total - $total_t;
	
	$final_extra = $extra + $add_money_extra - $deduct_money_extra;
	
	
?>
										<tr>
											<td><?php echo $number; ?></td>
											<td><?php echo $date; ?></td>
											<td><?php if($final_security_diposit > 0){ echo money_f($final_security_diposit); } else{ echo 0; } ; ?></td>
											<td><?php if($final_rent > 0){ echo money_f($final_rent); } else { echo 0; } ?></td>
											<td><?php if($final_ebill > 0){ echo money_f($final_ebill); } else { echo 0; } ?></td>
											<td><?php if($final_panalty > 0){ echo money_f($final_panalty); } else { echo 0; } ?></td>
											<td><?php if($final_locker > 0){ echo money_f($final_locker); } else{ echo 0; } ?></td>
											<td><?php if($final_parking > 0){ echo money_f($final_parking); } else { echo 0; } ?></td>
											<td><?php if($final_teacoffee > 0){ echo money_f($final_teacoffee); } else { echo 0; } ?></td>
											<td><?php if($final_cardcharge > 0){ echo money_f($final_cardcharge); } else { echo 0; } ?></td>
											<td><?php if($final_refreshment > 0){ echo money_f($final_refreshment); } else{ echo 0; } ?></td>
											<td><?php if($final_packageshift > 0){ echo money_f($final_packageshift); } else { echo 0; } ?></td>
											<td><?php if($final_cardchange > 0){ echo money_f($final_cardchange); } else { echo 0; } ?></td>
											<td><?php if($final_bedchange > 0){ echo money_f($final_bedchange); }else{ echo 0; } ?></td>
											<td><?php if($deposit_return > 0){ echo money_f($deposit_return); }else{ echo 0; } ?></td>
											<td><?php if($total_t > 0){echo money_f($total_t); } else{ echo 0; } ?></td>
											<td><?php if($g_c_total > 0){ echo money_f($g_c_total); } else { echo 0; } ?></td>
											<td><?php echo round($final_extra,2); ?></td>
											<td><?php if($add_money > 0){ echo money_f($add_money); } else { echo 0; } ?></td>
											<td><?php if($deduct_money > 0){ echo money_f($deduct_money); } else { echo 0; } ?></td>
											<td><?php echo $button; ?></td>
											<?php if($_SESSION['user_info']['department'] == '816905694932688665'){ ?>
											<td>												
												<button type="button" onclick="return open_adjustment_form('<?php echo $date; ?>')" class="btn btn-info btn-xs"><i class="fas fa-list-ul"></i></button>												
											</td>
											<?php } ?>
										</tr>
<?php 
	$final_total_security_diposit = $final_total_security_diposit + (float)$final_security_diposit;
	$final_total_rent = $final_total_rent + (float)$final_rent;
	$final_total_ebil = $final_total_ebil + (float)$final_ebill;
	$final_total_panalty = $final_total_panalty + (float)$final_panalty;
	$final_total_locker = $final_total_locker + (float)$final_locker;
	$final_total_parking = $final_total_parking + (float)$final_parking;
	$final_total_teacoffe = $final_total_teacoffe + (float)$final_teacoffee;
	$final_total_cardcharrge = $final_total_cardcharrge + (float)$final_cardcharge;
	$final_total_refreshment = $final_total_refreshment + (float)$final_refreshment;
	$final_total_packagechange = $final_total_packagechange + (float)$final_packageshift;
	$final_total_cardchange = $final_total_cardchange + (float)$final_cardchange;
	$final_total_bedchange = $final_total_bedchange + (float)$final_bedchange;
	$final_total_deposit_back += (int)$deposit_return;
	$final_total_ttotal = $final_total_ttotal + (float)$total_t;
	$final_total_ctotal = $final_total_ctotal + (float)$g_c_total;		
	$final_total_add = $final_total_add + (float)$add_money;
	$final_total_deduct = $final_total_deduct + (float)$deduct_money;		
	$final_total_extra = $final_total_extra + (float)$final_extra;		
	}
?>
										<tr style="font-weight:bolder;color:#f00;">
											<td>X</td>
											<td>TOTAL:</td>
											<td><?php echo round($final_total_security_diposit,2); ?>/-</td>
											<td><?php echo round($final_total_rent,2); ?>/-</td>
											<td><?php echo round($final_total_ebil,2); ?>/-</td>
											<td><?php echo round($final_total_panalty,2); ?>/-</td>
											<td><?php echo round($final_total_locker,2); ?>/-</td>
											<td><?php echo round($final_total_parking,2); ?>/-</td>
											<td><?php echo round($final_total_teacoffe,2); ?>/-</td>
											<td><?php echo round($final_total_cardcharrge,2); ?>/-</td>
											<td><?php echo round($final_total_refreshment,2); ?>/-</td>
											<td><?php echo round($final_total_packagechange,2); ?>/-</td>
											<td><?php echo round($final_total_cardchange,2); ?>/-</td>
											<td><?php echo round($final_total_bedchange,2); ?>/-</td>
											<td><?php echo $final_total_deposit_back; ?>/-</td>
											<td><?php echo round($final_total_ttotal,2); ?>/-</td>
											<td><?php echo round($final_total_ctotal,2); ?>/-</td>
											<td><?php echo round($final_total_extra,2); ?>/-</td>
											<td><?php echo round($final_total_add,2); ?>/-</td>
											<td><?php echo round($final_total_deduct,2); ?>/-</td>
											<td>--</td>
											<td>--</td>
										</tr>
									</tbody>
								</table>  
							</form>
						</div>					
					</div>
				</div>
	

			</div>
		</div>
	</div>
</div>
<!----Amount Dectector-->
	<div class="modal fade" id="amount_dectector_modal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form id="amount_dectector_form" action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-dark" style="background-color:#333;color:#fff;">
						<h4 class="modal-title">Adjustment</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="amount_dectector_result">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Selected Date</label>
									<input type="text" name="get_date" value="" class="form-control" readonly />
								</div>
								
								<div class="form-group">
									<label>Select Branch</label>
									<select name="branch_id" class="form-control select2" required >
										<option value="">--select One--</option>
										<?php
											$branches = $this->Dashboard_model->mysqlii("SELECT * FROM branches WHERE status = '1'");
											foreach($branches as $row){
												echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
											}
										?>
									</select>
								</div>
								
								<div class="form-group">
									<label>Write Amount</label>
									<input name="amount" type="text" class="number_int form-control" autocomplete="off" required />
								</div>
								
								<div class="form-group">
									<label>Select Adjust type</label>
									<select name="adj_type" class="form-control select2" required>
										<option value="">--select one--</option>
										<option value="1">ADD MONEY</option>
										<option value="2">DEDUCT MONEY</option>
									</select>
								</div>
								
								<div class="form-group">
									<label>Select Head</label>
									<select name="head_type" class="form-control select2" required>
										<option value="">--select one--</option>
										<option value="Security Deposit">Security Deposit</option>
										<option value="Rent">Rent</option>
										<option value="E-Bill">E-Bill</option>
										<option value="Panalty">Panalty</option>
										<option value="Locker">Locker</option>
										<option value="Parking">Parking</option>
										<option value="Tea & Coffee">Tea & Coffee</option>
										<option value="Card Charge">Card Charge</option>
										<option value="Refreshment">Refreshment</option>
										<option value="Package Shifting">Package Shifting</option>
										<option value="Card Change">Card Change</option>
										<option value="Bed Change">Bed Change</option>
										<option value="Extra">Extra</option>
									</select>
								</div>
								
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control" autocomplete="off" required></textarea>
								</div>
								
								<div class="form-group">
									<button name="add_adj" type="submit" class="btn btn-success" style="float:right;">Apply</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End Amount Dectector-->

<!----view Amount Deductor-->
	<div class="modal fade" id="view_amount_dectector_modal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form id="amount_dectector_form" action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning" style="background-color:#333;color:#fff;">
						<h4 class="modal-title">View Adjustment</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" style="color:#fff;">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="view_amount_dectector_result">

					</div>
				</form>
			</div>
		</div>
	</div>
<!----End View Amount Deductor-->
<script>
function view_deduction_logs(dates){ 
	var profile_id = dates; 
	$.ajax({ 
		url:"<?=base_url('assets/ajax/dashboard/view_amount_dectector_data.php');?>", 
		method:"POST", 
		data:{profile_id:profile_id}, 
		beforeSend:function(){ 
			$('#data-loading').html(data_loading); 
		}, 
		success:function(data){ 
			$('#data-loading').html(''); 
			$('#view_amount_dectector_result').html(data); 
			$('#view_amount_dectector_modal').modal('show'); 
		} 
	}); 
}
$('document').ready(function(){ 
	$('#amount_dectector_form').on("submit",function(){ 
		event.preventDefault(); 
		var form = $('#amount_dectector_form')[0]; 
		var data = new FormData(form); 
		$.ajax({ 
			type: "POST", 
			enctype: 'multipart/form-data', 
			url:"<?=base_url('assets/ajax/form_submit/report/insert_deduction_data_to_database.php');?>", 
			data: data, 
			processData: false, 
			contentType: false, 
			cache: false, 
			timeout: 600000, 
			beforeSend:function(){ 
				$('buttton[name="add_adj"]').prop("disabled", true); 
				$('#data-loading').html(data_loading); 
			}, 
			success:function(data){ 
				$('#data-loading').html(''); 
				$('buttton[name="add_adj"]').prop("disabled", false); alert(data); 
				$('input[name="get_date"]').val(''); 
				$("#amount_dectector_modal").modal('hide'); 
				$("#details_collection_form").submit(); 
			} 
		}); 
		return false; 
	}) 
})
function open_adjustment_form(date){ 
	$('input[name="get_date"]').val(date); 
	$("#amount_dectector_modal").modal('show'); 
}
$(document).ready(function() { var table_booking = $('#booking_data_table').DataTable({ "paging": true, "lengthChange": true, "lengthMenu": [ [50, 100, 500], [50, 100, 500] ], "searching": true, "ordering": true, "order": [[ 0, "asc" ]], /*"info": true,*/  /* "autoWidth": true, */ /*"responsive": true, */ "ScrollX": true, "processing": true, "serverSide": false, dom: 'lBfrtip', buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ] }); table_booking.buttons().container().appendTo($('#export_buttons')); })
</script>