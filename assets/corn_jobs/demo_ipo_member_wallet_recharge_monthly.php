<?php 
include("../../application/config/ajax_config.php");
function emi_calculator($p, $r, $t){ $emi; $r = $r / (12 * 100);  $t = $t * 12;  $emi = ($p * $r * pow(1 + $r, $t)) / (pow(1 + $r, $t) - 1);  return ($emi); }
function emi_profit_with_principal($p, $r){ $r = $r / 100 / 12; $r = $r * $p; return($r); }
function month($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
$sql = $mysqli->query("select * from demo_ipo_member_directory where status = '1'");
while($row = mysqli_fetch_assoc($sql)){
	$ipo_wallet = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_member_balance where ipo_id = '".$row['ipo_id']."'"));
	$ipo_agreement_info = $mysqli->query("select * from demo_ipo_agreement_information where ipo_id = '".$row['ipo_id']."' and status = '1'");	
	while($agreement = mysqli_fetch_assoc($ipo_agreement_info)){
		$rd = explode('/',$agreement['data']);
		$Ymd_rd = $rd[2].'-'.$rd[1].'-'.$rd[0];
		$Ymd_rd_daily = date('Y-m-d', strtotime($Ymd_rd. ' + 1 year'));
		
		$after_month = date('Y-m-d', strtotime($Ymd_rd. ' + 1 month'));
		$monthly_payment_date = date('Y-m-d', strtotime($Ymd_rd. ' + 1 month'));
		$after_month_Ymd = date('Ymd', strtotime($Ymd_rd. ' + 1 month'));
		$after_date_Ymd = date('Ymd', strtotime($Ymd_rd. ' + 1 day'));
		$daily_payment_date = date('Y-m-d', strtotime($Ymd_rd. ' + 1 day'));
		
		$runing_date = date('Ymd');
		$today = date('d/m/Y');
		
		$after_year = date('Y-m-d', strtotime($Ymd_rd. ' + 1 year'));
		$after_year_Ymd = date('Ymd', strtotime($Ymd_rd. ' + 1 year'));
		
		$after_one_Day = date('Y-m-d', strtotime($Ymd_rd. ' + 1 day'));
		$after_one_Ymd = date('Ymd', strtotime($Ymd_rd. ' + 1 day'));
		
		$ipo_id = $agreement['ipo_id'];
		$aggreement_id = $agreement['id'];
		$purses_code = $agreement['purses_code'];
		$client_type = $agreement['bet_id'];
		$widthdraw_type = $agreement['bed_name'];
		$investment_type = $agreement['bet_type'];
		$aggreement_type = $agreement['agreement_type'];
		$investment_amount = $agreement['ipo_rate'];
		$commission_rate = $agreement['ipo_commission'];
		if($investment_amount > 0){
			
			//Daily Transaction Data
			$start = new DateTime($Ymd_rd);
			$expired = new DateTime($Ymd_rd_daily);
			$total_number_Days = $expired->diff($start)->format("%a");
			
			$check_daily_logs = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_investment_daily_logs where ipo_id = '".$agreement['ipo_id']."' order by id desc"));
			if(!empty($check_daily_logs['id'])){
				$lm = explode('-',$check_daily_logs['payment_date']);
				$Ymd_lm = $lm[0].'-'.$lm[1].'-'.$lm[2];
				$last_date = date('Y-m-d', strtotime($Ymd_lm. ' + 1 day'));
				$last_date_Ymd = date('Ymd', strtotime($Ymd_lm. ' + 1 day'));
				if($last_date_Ymd == $runing_date){
					if($widthdraw_type == '1'){
						$total_only_profit = ( $investment_amount * ( $commission_rate / 100 ) );
						$per_day_amount = $total_only_profit / (float)$total_number_Days;
						$mysqli->query("INSERT INTO demo_ipo_investment_daily_logs VALUES(
							'',
							'".$ipo_id."',
							'".$aggreement_id."',
							'".$purses_code."',
							'".$client_type."',
							'".$widthdraw_type."',
							'".$investment_type."',
							'".$aggreement_type."',
							'".$investment_amount."',
							'".$commission_rate."',
							'".$per_day_amount."',
							'".$last_date."',
							'".$last_date_Ymd."',
							'Only Profit',
							'1',
							'',							
							'".$today."'
						)");
					}else if($widthdraw_type == '2'){
						$only_principle = $investment_amount;
						$per_day_amount = $only_principle / (float)$total_number_Days;
						$mysqli->query("INSERT INTO demo_ipo_investment_daily_logs VALUES(
							'',
							'".$ipo_id."',
							'".$aggreement_id."',
							'".$purses_code."',
							'".$client_type."',
							'".$widthdraw_type."',
							'".$investment_type."',
							'".$aggreement_type."',
							'".$investment_amount."',
							'".$commission_rate."',
							'".$per_day_amount."',
							'".$last_date."',
							'".$last_date_Ymd."',
							'Only Principle',
							'1',
							'',							
							'".$today."'
						)");						
					}else if($widthdraw_type == '3'){						
						$principle_profit = emi_calculator($investment_amount, $commission_rate,1);
						$intrest_profit = emi_profit_with_principal($investment_amount,$commission_rate);
						$per_day_amount = $intrest_profit / (float)$total_number_Days;
						$mysqli->query("INSERT INTO demo_ipo_investment_daily_logs VALUES(
							'',
							'".$ipo_id."',
							'".$aggreement_id."',
							'".$purses_code."',
							'".$client_type."',
							'".$widthdraw_type."',
							'".$investment_type."',
							'".$aggreement_type."',
							'".$investment_amount."',
							'".$commission_rate."',
							'".$per_day_amount."',
							'".$last_date."',
							'".$last_date_Ymd."',
							'Principle + Profit',
							'1',
							'',							
							'".$today."'
						)");
					}
				}
			}else{	
				if($after_date_Ymd == $runing_date){
					if($widthdraw_type == '1'){
						$total_only_profit = ( $investment_amount * ( $commission_rate / 100 ) );
						$per_day_amount = $total_only_profit / $total_number_Days;
						$mysqli->query("INSERT INTO demo_ipo_investment_daily_logs VALUES(
							'',
							'".$ipo_id."',
							'".$aggreement_id."',
							'".$purses_code."',
							'".$client_type."',
							'".$widthdraw_type."',
							'".$investment_type."',
							'".$aggreement_type."',
							'".$investment_amount."',
							'".$commission_rate."',
							'".$per_day_amount."',
							'".$daily_payment_date."',
							'".$after_date_Ymd."',
							'Only Profit',
							'1',
							'',							
							'".$today."'
						)");
					}else if($widthdraw_type == '2'){
						$only_principle = $investment_amount;
						$per_day_amount = $only_principle / $total_number_Days;
						$mysqli->query("INSERT INTO demo_ipo_investment_daily_logs VALUES(
							'',
							'".$ipo_id."',
							'".$aggreement_id."',
							'".$purses_code."',
							'".$client_type."',
							'".$widthdraw_type."',
							'".$investment_type."',
							'".$aggreement_type."',
							'".$investment_amount."',
							'".$commission_rate."',
							'".$per_day_amount."',
							'".$daily_payment_date."',
							'".$after_date_Ymd."',
							'Only Principle',
							'1',
							'',							
							'".$today."'
						)");						
					}else if($widthdraw_type == '3'){
						$principle_profit = emi_calculator($investment_amount, $commission_rate,1);
						$intrest_profit = emi_profit_with_principal($investment_amount,$commission_rate);
						$per_day_amount = $intrest_profit / (float)$total_number_Days;						
						$mysqli->query("INSERT INTO demo_ipo_investment_daily_logs VALUES(
							'',
							'".$ipo_id."',
							'".$aggreement_id."',
							'".$purses_code."',
							'".$client_type."',
							'".$widthdraw_type."',
							'".$investment_type."',
							'".$aggreement_type."',
							'".$investment_amount."',
							'".$commission_rate."',
							'".$per_day_amount."',
							'".$daily_payment_date."',
							'".$after_date_Ymd."',
							'Principle + Profit',
							'1',
							'',							
							'".$today."'
						)");
					}
				}				
			}			
			//exit;
			//======================
			
			if($aggreement_type == 'Monthly') {			
				$check_wallet_logs = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_member_wallet_insert_logs where ipo_id = '".$agreement['ipo_id']."' order by id desc"));
				if(!empty($check_wallet_logs['id'])){
					$number = mysqli_fetch_assoc($mysqli->query("select count(*) as total from demo_ipo_member_wallet_insert_logs where ipo_id = '".$agreement['ipo_id']."'"));
					$lm = explode('-',$check_wallet_logs['payment_date']);
					$Ymd_lm = $lm[0].'-'.$lm[1].'-'.$lm[2];
					$last_month = date('Y-m-d', strtotime($Ymd_lm. ' + 1 month'));
					$last_month_Ymd = date('Ymd', strtotime($Ymd_lm. ' + 1 month'));			
					
					if($last_month_Ymd == $runing_date){
						$total_logs = (int)$number['total'];
						$total_logs_asc = (int)$check_wallet_logs['number_of_payment_asc'] + 1;
						$total_logs_desc = (int)$check_wallet_logs['number_of_payment_desc'] - 1;
						
						$start_amount_data = (float)$check_wallet_logs['bigining_amount'];
						$end_amount_data = (float)$check_wallet_logs['ending_amount'];
						
						if($widthdraw_type == '1'){
							$total_only_profit = ($investment_amount * ($commission_rate / 100));
							$monthly_only_profit = ($investment_amount * ($commission_rate / 100)) / 12;
							$start_amount = $end_amount_data;
							$ending_amount = $start_amount - $monthly_only_profit;
							if($total_logs == 11){
								$update_wallet = $ipo_wallet['balance'] + $monthly_only_profit + $investment_amount;								
								$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
								$mysqli->query("update demo_ipo_agreement_information set status = '0' where id = '".$aggreement_id."'");
								$runing = 'Finished';
								sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($monthly_only_profit + $investment_amount).'. Thank you for stay with us. For any query feel free to call us +880 9638666333 (SUPER HOME)');
							}else{
								$update_wallet = $ipo_wallet['balance'] + $monthly_only_profit;
								$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
								$runing = 'Runing';
								sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($monthly_only_profit).'. Thank you for stay with us. For any query feel free to call US +880 9638666333 (SUPER HOME)');
							}
							$mysqli->query("INSERT INTO demo_ipo_member_wallet_insert_logs VALUES(
								'',
								'".$ipo_id."',
								'".$aggreement_id."',
								'".$purses_code."',
								'".$client_type."',
								'".$widthdraw_type."',
								'".$investment_type."',
								'".$aggreement_type."',
								'".$investment_amount."',
								'".$start_amount."',
								'".$ending_amount."',
								'".$monthly_only_profit."',
								'0',
								'".$monthly_only_profit."',
								'".$commission_rate."',
								'".$last_month."',
								'".$total_logs_asc."',
								'".$total_logs_desc."',
								'".$runing." - Only Profit',
								'1',
								'',
								'".$today."'
							)");							
						} else if($widthdraw_type == '2'){
							$only_principle = ($investment_amount / 12);
							$only_profit = ($investment_amount * ($commission_rate / 100)) / 12;
							$start_amount = $end_amount_data;
							$ending_amount = $only_profit + $start_amount;
							if($total_logs == 11){
								$update_wallet = $ipo_wallet['balance'] + $only_principle + $ending_amount;								
								$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
								$mysqli->query("update demo_ipo_agreement_information set status = '0' where id = '".$aggreement_id."'");
								$runing = 'Finished';
								sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($only_principle + $ending_amount).'. Thank you for stay with us. For any query feel free to call us +880 9638666333 (SUPER HOME)');
							}else{
								$update_wallet = $ipo_wallet['balance'] + $only_principle;
								$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
								$runing = 'Runing';
								sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($only_principle).'. Thank you for stay with us. For any query feel free to call US +880 9638666333 (SUPER HOME)');
							}
							$mysqli->query("INSERT INTO demo_ipo_member_wallet_insert_logs VALUES(
								'',
								'".$ipo_id."',
								'".$aggreement_id."',
								'".$purses_code."',
								'".$client_type."',
								'".$widthdraw_type."',
								'".$investment_type."',
								'".$aggreement_type."',
								'".$investment_amount."',
								'".$start_amount."',
								'".$ending_amount."',
								'".$only_principle."',
								'0',
								'".$only_principle."',
								'".$commission_rate."',
								'".$last_month."',
								'".$total_logs_asc."',
								'".$total_logs_desc."',
								'".$runing." - Only Principle',
								'1',
								'',
								'".$today."'
							)");							
						} else if($widthdraw_type == '3'){
							$principle_profit = emi_calculator($investment_amount, $commission_rate,1);
							$runing_investment = (float)$end_amount_data;
							$intrest_profit = emi_profit_with_principal($runing_investment,$commission_rate);							
							$actual_principal_amount = $principle_profit - $intrest_profit;
							$start_amount = $runing_investment;
							$endiing_amount = $start_amount - $actual_principal_amount;					
							if($total_logs == 11){
								$update_wallet = $ipo_wallet['balance'] + $principle_profit;								
								$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
								$mysqli->query("update demo_ipo_agreement_information set status = '0' where id = '".$aggreement_id."'");
								$runing = 'Finished';
								sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($principle_profit).'. Thank you for stay with us. For any query feel free to call us +880 9638666333 (SUPER HOME)');
							}else{
								$update_wallet = $ipo_wallet['balance'] + $principle_profit;
								$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
								$runing = 'Runing';
								sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($principle_profit).'. Thank you for stay with us. For any query feel free to call us +880 9638666333 (SUPER HOME)');
							}
							$mysqli->query("INSERT INTO demo_ipo_member_wallet_insert_logs VALUES(
								'',
								'".$ipo_id."',
								'".$aggreement_id."',
								'".$purses_code."',
								'".$client_type."',
								'".$widthdraw_type."',
								'".$investment_type."',
								'".$aggreement_type."',
								'".$investment_amount."',
								'".$start_amount."',
								'".$endiing_amount."',
								'".$intrest_profit."',
								'".$actual_principal_amount."',
								'".$principle_profit."',
								'".$commission_rate."',
								'".$last_month."',
								'".$total_logs_asc."',
								'".$total_logs_desc."',
								'".$runing." - Principle + Profit',
								'1',
								'',
								'".$today."'
							)");							
						}
					}
				}else{
					if($after_month_Ymd == $runing_date){
						if($widthdraw_type == '1'){
							$total_only_profit = ( $investment_amount * ( $commission_rate / 100 ) );
							$monthly_only_profit = $total_only_profit / 12;
							$start_amount = $total_only_profit;
							$ending_amount = $total_only_profit - $monthly_only_profit;
							$mysqli->query("INSERT INTO demo_ipo_member_wallet_insert_logs VALUES(
								'',
								'".$ipo_id."',
								'".$aggreement_id."',
								'".$purses_code."',
								'".$client_type."',
								'".$widthdraw_type."',
								'".$investment_type."',
								'".$aggreement_type."',
								'".$investment_amount."',
								'".$start_amount."',
								'".$ending_amount."',
								'".$monthly_only_profit."',
								'0',
								'".$monthly_only_profit."',
								'".$commission_rate."',
								'".$monthly_payment_date."',
								'1',
								'12',
								'This Agreement First Payment(Only Profit)',
								'1',
								'',
								'".$today."'
							)");
							$update_wallet = $ipo_wallet['balance'] + $monthly_only_profit;
							$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
							sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($monthly_only_profit).'. Thank you for stay with us. For any query feel free to call us +880 9638666333 (SUPER HOME)');
						} else if($widthdraw_type == '2'){
							$only_principle = ($investment_amount / 12);
							$only_profit = ($investment_amount * ($commission_rate / 100)) / 12;
							$start_amount = 0;
							$ending_amount = $only_profit + $start_amount;
							$mysqli->query("INSERT INTO demo_ipo_member_wallet_insert_logs VALUES(
								'',
								'".$ipo_id."',
								'".$aggreement_id."',
								'".$purses_code."',
								'".$client_type."',
								'".$widthdraw_type."',
								'".$investment_type."',
								'".$aggreement_type."',
								'".$investment_amount."',
								'".$start_amount."',
								'".$ending_amount."',
								'".$only_principle."',
								'0',
								'".$only_principle."',
								'".$commission_rate."',
								'".$monthly_payment_date."',
								'1',
								'12',
								'This Agreement First Payment(Only Principle)',
								'1',
								'',
								'".$today."'
							)");
							$update_wallet = $ipo_wallet['balance'] + $only_principle;
							$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
							sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($only_principle).'. Thank you for stay with us. For any query feel free to call us +880 9638666333 (SUPER HOME)');
						} else if($widthdraw_type == '3'){
							$principle_profit = emi_calculator($investment_amount, $commission_rate,1);
							$intrest_profit = emi_profit_with_principal($investment_amount,$commission_rate);						
							$actual_principal_amount = $principle_profit - $intrest_profit;
							$endiing_amount = $investment_amount - $actual_principal_amount;
							$mysqli->query("INSERT INTO demo_ipo_member_wallet_insert_logs VALUES(
								'',
								'".$ipo_id."',
								'".$aggreement_id."',
								'".$purses_code."',
								'".$client_type."',
								'".$widthdraw_type."',
								'".$investment_type."',
								'".$aggreement_type."',
								'".$investment_amount."',
								'".$investment_amount."',
								'".$endiing_amount."',
								'".$intrest_profit."',
								'".$actual_principal_amount."',
								'".$principle_profit."',
								'".$commission_rate."',
								'".$monthly_payment_date."',
								'1',
								'12',
								'This Agreement First Payment (Principle + Profit)',
								'1',
								'',
								'".$today."'
							)");
							$update_wallet = $ipo_wallet['balance'] + $principle_profit;
							$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
							sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($principle_profit).'. Thank you for stay with us. for any query feel free to call us +880 9638666333 (SUPER HOME)');
						}
					}
				}			
			} else if ($aggreement_type == 'Yearly'){
				if($after_year_Ymd == $runing_date){
					$profit_amount = $investment_amount * ($commission_rate / 100);
					$start_amount = $investment_amount;
					$end_amount = $investment_amount + $profit_amount;
					$mysqli->query("INSERT INTO demo_ipo_member_wallet_insert_logs VALUES(
						'',
						'".$ipo_id."',
						'".$aggreement_id."',
						'".$purses_code."',
						'".$client_type."',
						'".$widthdraw_type."',
						'".$investment_type."',
						'".$aggreement_type."',
						'".$investment_amount."',
						'".$investment_amount."',
						'".$end_amount."',
						'".$investment_amount."',
						'".$end_amount."',
						'".$end_amount."',
						'".$commission_rate."',
						'".$after_year."',
						'1',
						'1',
						'This Agreement Yearly Payment Finished(Principle + Profit)',
						'1',
						'',
						'".$today."'
					)");
					$update_wallet = $ipo_wallet['balance'] + $end_amount;								
					$mysqli->query("update demo_ipo_member_balance set balance = '".$update_wallet."' where ipo_id = '".$row['ipo_id']."'");
					$mysqli->query("update demo_ipo_agreement_information set status = '0' where id = '".$aggreement_id."'");
					sendsms($row['personal_phone_number'],'(DEMO) Dear, '.$row['personal_full_name'].', Your account credieted with '.money($end_amount).'. Thank you for stay with us. For any query feel free to call us +880 9638666333 (SUPER HOME)');
				}
			}
		}
	}
}

//============================Corn Jobs Traces by database & sms =======================================

if($mysqli->query("INSERT INTO corn_jobs_log VALUES(
	'',
	'Demo Investor wallet reacharge & finished agreement corn job',
	'".date("l")."',
	'".date("h:i:sa")."',
	'".date("d/m/Y")."'
)")){
	$message = 'Message From Corn Jobs (Demo Investor wallet reacharge & finished agreement). Job done at '. date("l, d-m-Y (h:i:sa)");
	sendsms('01704123498',$message);
	sendsms('01704123492',$message);
}else{
	$message = 'Something wrong! Message From Corn Jobs (Demo Investor wallet reacharge & finished agreement). Job done at '. date("l, d-m-Y (h:i:sa)");
	sendsms('01704123498',$message);
	sendsms('01704123492',$message);
}

?>