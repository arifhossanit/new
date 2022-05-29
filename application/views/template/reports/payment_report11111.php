<?php 
set_time_limit(0);
ini_set('memory_limit', -1);

<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">All Collection Report</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Report</a></li>
              <li class="breadcrumb-item active">All Collection Report</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
<style>
@media print
{    
    .no-print {
        display: none !important;
    }
}
<?php $member_id_of_member_table = NULL; ?>
</style>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">					
					<div class="row">
						<div class="col-sm-12">
							<form action="<?php echo current_url(); ?>" method="post">
								<div class="row" style="margin-bottom:15px;">								
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-2">
												<div class="form-group">
													<select name="branch_id" class="form-control select2">
														<?php
														if($_SESSION['super_admin']['role_id'] == '2805597208697462328' OR $_SESSION['super_admin']['role_id'] == '1622657840330042228'){
															echo '<option value="1">All Branches</option>';
														}									
														if(!empty($banches)){
															foreach($banches as $row){
																if(!empty($b_id) AND $row->branch_id == $b_id){
																	$selected = 'selected';
																}else{
																	$selected = '';
																}
																echo '<option value="'.$row->branch_id.'" '.$selected.'>'.$row->branch_name.'</option>';
															}
														}													
														?>
													</select>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend">
														<span class="input-group-text">
															<i class="far fa-calendar-alt"></i>
														</span>
														</div>
														<input name="date_range" type="text" value="<?php if(!empty($date_range)){ echo $date_range; } ?>" class="form-control float-right date_range">
													</div>
												</div>
											</div>
											<div class="col-sm-2">
												<button type="submit" name="date_sub" class="btn btn-success" style="float:left;"> Filter</button>
											</div>										
										</div>											
										<div class="row">																			
											
										</div>
										
									</div>
								</div>
							</form>
							

							<div class="card card-primary card-outline card-outline-tabs">
								<div class="card-header p-0 border-bottom-0">
									<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
										<?php if(check_permission('role_1609928808_79')){ ?>
										<li class="nav-item">
											<a class="nav-link <?php if(empty($mis_act)){ echo  'active'; } ?>" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Collection (Credit)</a>
										</li>
										<?php } ?>
										<?php if(check_permission('role_1609928808_74')){ ?>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Collection (Debit)</a>
										</li>
										<?php } ?>
										<?php if(check_permission('role_1609828362_40')){ ?>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-four-dropbox-tab <?php if(!empty($mis_act)){ echo  'active'; } ?>" data-toggle="pill" href="#custom-tabs-four-dropbox" role="tab" aria-controls="custom-tabs-four-dropbox" aria-selected="false">DropBox</a>
										</li>
										<?php } ?>
										<?php if(check_permission('role_1609828362_81')){ ?>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-four-collected_dropbox-tab" data-toggle="pill" href="#custom-tabs-four-collected_dropbox" role="tab" aria-controls="custom-tabs-four-collected_dropbox" aria-selected="false">Collected From DropBox</a>
										</li>
										<?php } ?>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-four-tabContent">
										<?php if(check_permission('role_1609928808_79')){ ?>
										<div class="tab-pane fade <?php if(empty($mis_act)){ echo  'show active'; } ?>" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
											<div class="card card-success">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i>Collection Report Credit</h3>
													<div id="export_buttons" style="float: right;"></div>
												</div>
												<div class="card-body">	
													<table id="booking_data_table" class="display table table-sm table-bordered table table-stripped" style="width:100%">
														<thead>
															<tr>
																<th>#</th>
																<th>SL</th>
																<th>Branch</th>
																<th>Transaction_ID</th>
																<th>Payment_Purpose</th>
																<th>Payments_Details</th>
																<th>Name</th>										
																<th>Package</th>												
																<th>Card</th>												
																<th>Cash</th>												
																<th>Mobile</th>											
																<th>Chaque</th>											
																<th>Sub_total</th>	
																<th>TX Amount</th>															
																<th>Received_By</th>
																<th>Date</th>
																<th>Option</th>
															</tr>
														</thead>
														<tbody>
															<?php
															if(!empty($payment_reports)){
																$i = 1;
																$card_total = 0;
																$cash_total = 0;
																$mobile_total = 0;
																$check_total = 0;
																$subb_total = 0;
																$swf_amount = 0;
																foreach($payment_reports as $idx=>$row){	
																	if(!empty($transaction)){		
																		foreach($transaction as $tow){
																			if($tow->transaction_id == $row->transaction_id){
																				$Payment_Purpose = $tow->note;
																				$type = $tow->transaction_type;
																				$transaction_id = $tow->transaction_id;
																				$amount = $tow->amount;
																			}		    
																		}
																	}else{
																		$Payment_Purpose = '';
																		$type = '';
																		$transaction_id = '';
																		$amount = '';
																	}																	
																	if(!empty($banches)){
																		$branch_name = '';
																		foreach($banches as $bow){
																			if($bow->branch_id == $row->branch_id){
																				$branch_name .= $bow->branch_name;
																			}else{
																				$branch_name .= '';
																			}		    
																		}
																	}
																	$member_info = $this->Dashboard_model->mysqlii("select * from member_directory where booking_id = '".$row->booking_id."' order by id desc limit 01");
																	$rent_info = $this->Dashboard_model->mysqlii("select * from rent_info where data_two = '".$row->transaction_id."' order by id desc limit 01");
																	if(!empty($member_info[0]->full_name)){
																		$full_name = $member_info[0]->full_name;
																	}else{
																		$full_name = '----';
																	}
																	if(!empty($rent_info->id)){
																		$package = $rent_info->package_name;
																	}else{
																		if(!empty($member_info[0]->package_name)){
																			$package = $member_info[0]->package_name;
																		}else{
																			$package = '----';
																		}																																				
																	}
																	
																	$up_inf = explode('___',$row->uploader_info);
																	if(!empty($employee_info)){
																		foreach($employee_info as $eow){
																			if(!empty($eow->email) AND !empty($up_inf[1]) AND $eow->email == $up_inf[1] ){
																				$employee_name = $eow->full_name.' | '.$eow->employee_id;
																			}	    
																		}
																	}else{
																		$employee_name = '';
																	}
																	if(!empty($type) AND $type == 'Credit'){
																		$tamount = '';
																		if($idx==0 OR ($payment_reports[$idx-1]->transaction_id != $row->transaction_id)){
																			$total_received_ammount = $this->Dashboard_model->mysqlij("select sum(amount) as TAmount from transaction where transaction_id = '".$transaction_id."' ");
																			$tamount = $total_received_ammount->TAmount;
																		}
																		$sub_total = (float)$row->card_amount + (float)$row->cash_amount + (float)$row->mobile_amount + (float)$row->check_amount;

																		$member_id_of_member_table = null;
																		$get_if_of_member_directory_table = $this->Dashboard_model->mysqlij("select id as ID from member_directory where booking_id = '".$row->booking_id."' ");
																		if(!empty($get_if_of_member_directory_table)){
																			$member_id_of_member_table = $get_if_of_member_directory_table->ID;
																		}
															?>										
															<tr>
																<td style="white-space: unset;">
																	<?php if($row->note == 'drop_box_checked' ){ ?>
																		<div style="width:18.33px;height:18.33px;background-color:green;border-radius:5px;margin-left:3.3px;border:solid 3px #333;"></div>
																	<?php 
																	}else{
																		if($row->cash_amount > 0 OR $row->check_amount > 0){ ?>
																	<input type="checkbox" class="sent_ides_checkbox" id="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" style="transform: scale(1.5);"/>
																	<?php }else{ ?>
																		<div style="width:18.33px;height:18.33px;background-color:#f00;border-radius:5px;margin-left:3.3px;border:solid 3px #333;"></div>
																	<?php } } ?>
																</td>
																<td><?php echo $i++; if(!empty($_SESSION['super_admin']['user_type']) AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>_<?php echo $row->id; } ?></td>
																<td><?php echo $branch_name; ?></td>
																<!--<td style="font-weight:bolder;color:green;">#<?php echo $row->invoice_number; ?></td>-->
																<td style="font-weight:bolder;color:green;"><?php echo $transaction_id; ?></td>
																<!--<td><?php echo $type; ?></td>-->
																<td><?php echo $Payment_Purpose; ?></td>
																<td><marquee style="width:150px; height: 17px; line-height: 16px;"><?php echo $row->details; ?></marquee></td>
																<td><?php if(!empty($full_name)){ echo $full_name; } ?></td>
																<td><?php if(!empty($package)){ echo $package; } ?></td>
																<td style="text-align:right;<?php if($row->card_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->card_amount; ?></td>
																<td style="text-align:right;<?php if($row->cash_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->cash_amount; ?></td>
																<td style="text-align:right;<?php if($row->mobile_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->mobile_amount; ?></td>
																<td style="text-align:right;<?php if($row->check_amount > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo (int)$row->check_amount; ?></td>
																<td style="text-align:right;<?php if($sub_total > 0){ ?>background-color:#01ff702e;<?php }else{ ?>background-color:#f0000014;<?php } ?>"><?php echo $sub_total; ?></td>
																<td style="text-align:right;"><?= $tamount ?></td>
																<td style="text-align:right;"><?php echo $employee_name; ?></td>
																<td style="text-align:right;"><?php echo $row->data; ?></td>
																<td style="text-align:right;">
																<?php 
																 if($member_id_of_member_table !== null ){ ?>
																	<button onclick="return view_member_profile('<?= $member_id_of_member_table ?>') " type="button" class="btn btn-xs btn-warning" title="View member profile"><i class="fa fa-eye"></i></button>
																<?php } ?>
																</td>
															</tr>											
															<?php 
																	$card_total = $card_total + (float)$row->card_amount;
																	$cash_total = $cash_total + (float)$row->cash_amount;
																	$mobile_total = $mobile_total + (float)$row->mobile_amount;
																	$check_total = $check_total + (float)$row->check_amount;
																	$subb_total = $subb_total + $sub_total;
																	$swf_amount = $swf_amount + $amount;
																	}
																}
															?>	
														</tbody>
														<tfoot>
															<tr style="font-size:23px;">
																<td style="font-size:0px;">x</td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td style="text-align:right;font-weight:bolder;color:green;">Total:</td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $card_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $cash_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $mobile_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $check_total; ?></td>
																<td style="text-align:right;font-weight:bolder;color:green;"><?php echo $subb_total; ?></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														</tfoot>
															<?php																
															} 
															?>											
													</table>
													<div align="left" style="margin-bottom:10px;margin-top: 15px;">
														<button type="button" id="select" class="btn btn-warning" style="margin-left:15px;">Select All</button>
														<button type="button" id="unselect" class="btn btn-success">Unselect All</button>
														<button type="button" id="btn_delete" class="btn btn-danger">Send to Drop List</button>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if(check_permission('role_1609928808_74')){ ?>
										<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
											<div class="card card-danger">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i>Collection Report Debit</h3>
													<div id="export_buttons_due" style="float: right;"></div>
												</div>
												<div class="card-body">									
													<!-- <style>#booking_data_table_due td{text-align:center;vertical-align: middle;white-space: pre;}#booking_data_table_due th{text-align:center;vertical-align: middle;}#booking_data_table_due td:last-child{text-align:left;}</style> -->
													<div class="table-responsive">
														<table id="booking_data_table_due" class="table table-bordered">
															<thead>
																<tr>
																	<th>SL</th>
																	<th>Branch</th>
																	<th>Transaction_ID</th>
																	<th>Type</th>
																	<th>Payment_Purpose</th>
																	<th>Payments_Details</th>
																	<th>Name</th>												
																	<th>Package</th>												
																	<th>Card</th>												
																	<th>Cash</th>												
																	<th>Mobile</th>											
																	<th>Chaque</th>	
																	<th>TX Amount</th>										
																	<th>Given_By</th>
																	<th>Date</th>
																	<th>Option</th>
																</tr>
															</thead>
															<tbody>
																<?php
																if(!empty($payment_reports)){
																	$i = 1;
																	$card_total = 0;
																	$cash_total = 0;
																	$mobile_total = 0;
																	$check_total = 0;
																	foreach($payment_reports as $row){	
																		if(!empty($transaction)){		
																			foreach($transaction as $tow){
																				if($tow->transaction_id == $row->transaction_id){
																					$Payment_Purpose = $tow->note;
																					$type = $tow->transaction_type;
																					$transaction_id = $tow->transaction_id;
																				}		    
																			}
																		}else{
																			$Payment_Purpose = '';
																			$type = '';
																			$transaction_id = '';
																		}																	
																		if(!empty($banches)){
																			$branch_name = '';
																			foreach($banches as $bow){
																				if($bow->branch_id == $row->branch_id){
																					$branch_name .= $bow->branch_name;
																				}else{
																					$branch_name .= '';
																				}		    
																			}
																		}
																		
																		$member_info = $this->Dashboard_model->mysqlii("select * from member_directory where booking_id = '".$row->booking_id."' order by id desc limit 01");
																		$rent_info = $this->Dashboard_model->mysqlii("select * from rent_info where data_two = '".$row->transaction_id."' order by id desc limit 01");
																		if(!empty($member_info[0]->full_name)){
																			$full_name = $member_info[0]->full_name;
																		}else{
																			$full_name = '----';
																		}
																		if(!empty($rent_info->id)){
																			$package = $rent_info->package_name;
																		}else{
																			if(!empty($member_info[0]->package_name)){
																				$package = $member_info[0]->package_name;
																			}else{
																				$package = '----';
																			}																																				
																		}
																		/*
																		if(!empty($row->booking_id)){
																			if(!empty($member_info)){
																				foreach($member_info as $mow){
																					if($mow->booking_id == $row->booking_id){
																						$member_name = $mow->full_name;
																						$package = $mow->package_name;
																					}
																				}
																			}else{
																				$member_name = '-----';
																				$package = '-----';
																			}
																		}else{
																			$member_name = '-----';
																			$package = '-----';
																		}	*/ 																
																		$up_inf = explode('___',$row->uploader_info);
																		if(!empty($employee_info)){
																			$employee_name = '';
																			foreach($employee_info as $eow){
																				if(!empty($eow->email) AND !empty($up_inf[1]) AND $eow->email == $up_inf[1] ){
																					$employee_name .= $eow->full_name.' | '.$eow->employee_id;
																				}else{
																					$employee_name .= '';
																				}		    
																			}
																		}
																		if(!empty($type) AND $type == 'Debit'){
																			$tamount = '';
																			if($idx==0 OR ($payment_reports[$idx-1]->transaction_id != $row->transaction_id)){
																				$total_received_ammount = $this->Dashboard_model->mysqlij("select sum(amount) as TAmount from transaction where transaction_id = '".$transaction_id."' ");
																				$tamount = $total_received_ammount->TAmount;
																			}

																		$get_if_of_member_directory_table_debit = $this->Dashboard_model->mysqlij("select id as ID from member_directory where booking_id = '".$row->booking_id."' ");
																		if(!empty($get_if_of_member_directory_table_debit)){
																			$member_id_of_member_table_debit = $get_if_of_member_directory_table_debit->ID;
																		}
																		
																?>										
																<tr>
																	<td><?php echo $i++; if(!empty($_SESSION['super_admin']['user_type']) AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>_<?php echo $row->id; } ?></td>
																	<td><?php echo $branch_name; ?></td>
																	<td style="font-weight:bolder;color:red;"><?php echo $transaction_id; ?></td>
																	<td><?php echo $type; ?></td>
																	<td><?php echo $Payment_Purpose; ?></td>
																	<td><marquee style="width:150px;"><?php echo $row->details; ?></marquee></td>
																	<td><?php if(!empty($full_name)){ echo $full_name; } ?></td>
																	<td><?php echo $package; ?></td>
																	<td style="text-align:right;"><?php echo (int)$row->card_amount; ?></td>
																	<td style="text-align:right;"><?php echo (int)$row->cash_amount; ?></td>
																	<td style="text-align:right;"><?php echo (int)$row->mobile_amount; ?></td>
																	<td style="text-align:right;"><?php echo (int)$row->check_amount; ?></td>
																	<td style="text-align:right;"><?= $tamount ?></td>
																	<td style="text-align:right;"><?php echo $employee_name; ?></td>
																	<td style="text-align:right;"><?php echo $row->data; ?></td>
																	<td>
																		<?php 
																		if($member_id_of_member_table !== null ){ ?>
																			<button onclick="return view_member_profile('<?= $member_id_of_member_table_debit ?>') " type="button" class="btn btn-xs btn-warning" title="View member profile"><i class="fa fa-eye"></i></button>
																		<?php } ?>
																	</td>
																</tr>											
																<?php 
																		$card_total = $card_total + (float)$row->card_amount;
																		$cash_total = $cash_total + (float)$row->cash_amount;
																		$mobile_total = $mobile_total + (float)$row->mobile_amount;
																		$check_total = $check_total + (float)$row->check_amount;
																		}
																	}
																?>	
																<tr style="font-size:23px;">
																	<td>x</td>
																	<td></td>
																	<td></td>
																	<td></td>
																	<td></td>
																	<td></td>
																	<td></td>
																	<td style="text-align:right;font-weight:bolder;color:red;">Total:</td>
																	<td style="text-align:right;font-weight:bolder;color:red;"><?php echo $card_total; ?></td>
																	<td style="text-align:right;font-weight:bolder;color:red;"><?php echo $cash_total; ?></td>
																	<td style="text-align:right;font-weight:bolder;color:red;"><?php echo $mobile_total; ?></td>
																	<td style="text-align:right;font-weight:bolder;color:red;"><?php echo $check_total; ?></td>
																	<td style="text-align:right;"><?= $tamount ?></td>
																	<td></td>
																	<td></td>
																	<td></td>
																</tr>
																<?php																
																} 
																?>											
															</tbody>
														</table>	
													</div>												
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if(check_permission('role_1609828362_40')){ ?>
										<div class="tab-pane fade <?php if(!empty($mis_act)){ echo  'show active'; } ?>" id="custom-tabs-four-dropbox" role="tabpanel" aria-labelledby="custom-tabs-four-dropbox-tab">
											<div class="card card-info">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i>DropBox</h3>
													<div id="export_buttons_dropbox" style="float: right;"></div>
												</div>
												<div class="card-body">	 <!--display: contents;-->								
													<!-- <style>#data_table_drop_box td{text-align:center;vertical-align: middle;white-space: pre;}#data_table_drop_box th{text-align:center;vertical-align: middle;}#booking_data_table_due td:last-child{text-align:left;}</style> -->
													<table id="data_table_drop_box" class="display table table-sm table-bordered table table-striped" style="width:100%">
														<thead>
															<tr>
																<th class="d-print-none">Option</th>
																<th>SL</th>
																<th>Branch</th>
																<th>Purpose</th>
																<th>Transaction_ID</th>
																<th>Phone Number</th>
																<th>Amount</th>
																<th>Done_by</th>
																<th>Date</th>												
															</tr>
														</thead>
														<tbody>
															<?php
															if(!empty($drop_box_data)){
																$i = 1;
																$cash_total = 0;
																$trn_ids = '';
																foreach($drop_box_data as $row){
																if($row->note != 'money_collected'){
																	
																	$Payment_Purpose = '';
																	$type = '';
																	$transaction_id = $row->transaction_id;
																	if(!empty($transaction)){		
																		foreach($transaction as $tow){
																			if($tow->transaction_id == $row->transaction_id){
																				$Payment_Purpose = $tow->note;
																				$type = $tow->transaction_type;
																				$transaction_id = $tow->transaction_id;
																			}		    
																		}
																	}																	
																	if(!empty($banches)){
																		$branch_name = '';
																		foreach($banches as $bow){
																			if($bow->branch_id == $row->branch_id){
																				$branch_name .= $bow->branch_name;
																			}else{
																				$branch_name .= '';
																			}		    
																		}
																	}
																												
																	$up_inf = explode('___',$row->uploader_info);
																	if(!empty($employee_info)){
																		$employee_name = '';
																		foreach($employee_info as $eow){
																			if(!empty($eow->email) AND !empty($up_inf[1]) AND $eow->email == $up_inf[1] ){
																				$employee_name .= $eow->full_name.' | '.$eow->employee_id;
																			}else{
																				$employee_name .= '';
																			}		    
																		}
																	}

																	$get_booking_id_from_payment_received_method = $this->Dashboard_model->mysqlii("select * from payment_received_method where id = '".$row->payment_id."' order by id desc limit 01");

																	$get_phone_number_from_booking_info = $this->Dashboard_model->mysqlii("select * from booking_info where booking_id = '".$get_booking_id_from_payment_received_method[0]->booking_id."' order by id desc limit 01");

																	$phone_number;
																	if(!empty($get_phone_number_from_booking_info)){
																		$phone_number = $get_phone_number_from_booking_info[0]->phone_number;
																	}
																	
															?>										
															<tr>
																<td class="d-print-none" style="white-space: unset;">
																	<label class="btn btn-xs btn-danger" title="Click to missing it!" style="margin: -2px;">
																		<input type="checkbox" class="sent_back_ides_checkbox" id="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>"/>
																		Send Missing
																	</label>
																</td>
																<td><?php echo $i++; if(!empty($_SESSION['super_admin']['user_type']) AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>_<?php echo $row->id; } ?></td>
																<td><?php echo $branch_name; ?></td>
																<td style="font-weight:bolder;color:green;"><?php echo $Payment_Purpose; ?></td>
																<td style="font-weight:bolder;color:red;"><b><?php echo $transaction_id; ?></b></td>
																<td>
																	<?php
																		if(!empty($phone_number)){
																			print $phone_number;
																		}
																	?>
																</td>
																<td style="text-align:right;"><?php echo (int)$row->amount; ?></td>
																<td style="text-align:right;"><?php echo $employee_name; ?></td>
																<td style="text-align:right;"><?php echo $row->data; ?></td>
															</tr>											
															<?php 
																	$cash_total = $cash_total + (float)$row->amount;
																	$trn_ids .= $row->id.',';
																} } 
																$transaction_ids = rtrim($trn_ids,',');
															?>	
															<tr style="font-size:23px;">
																<td class="d-print-none"> </td>
																<td> </td>
																<td> </td>
																<td></td>				
																<td style="text-align:right;font-weight:bolder;color:red;">Total:</td>
																<td></td>
																<td style="text-align:right;font-weight:bolder;color:red;"><?php echo $cash_total; ?></td>
																<td></td>
																<td></td>
															</tr>
															<?php																
															} 
															?>											
														</tbody>
													</table>
													<div class="row">
														<div class="col-sm-12">
															<div class="row">
																<div class="col-sm-4">
																	<div align="left" style="margin-bottom:10px;">
																		<button type="button" id="select_back" class="btn btn-warning" style="margin-left:15px;">Select All</button>
																		<button type="button" id="unselect_back" class="btn btn-success">Unselect All</button>
																		<button type="button" id="btn_delete_back" class="btn btn-danger">Make Selected Missing</button>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="row">
																		<div class="col-sm-6"></div>
																		<div class="col-sm-6">
																		
																		</div>
																	</div>
																</div>
																<div class="col-sm-4">
																	<?php if(check_permission('role_1609828362_81')){ ?>
																	<?php if(!empty($transaction_ids)){ ?>
																	<form action="<?php echo current_url(); ?>" method="post">
																		<select name="branch_id" class="form-control select2" required>
																			<?php
																				echo '<option value="">Select Collected From Branch</option>';										
																				if(!empty($banches)){
																					foreach($banches as $row){
																						echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';
																					}
																				}													
																			?>
																		</select>
																		<textarea name="receive_money_note" class="form-control" placeholder="Note / Remarks" style="margin-bottom:10px;height:120px;" required></textarea>
																		<input type="hidden" name="total_money" value="<?php echo $cash_total; ?>"/>
																		<input type="hidden" name="transac_uniq_id" value="<?php echo rand() * time(); ?>"/>
																		<input type="hidden" name="transaction_ids" value="<?php echo $transaction_ids; ?>"/>
																		<button type="submit" class="btn btn-sm btn-success" name="generate_received_money" style="float:right;" onclick="return confirm('Are You sure want to Receiveed Those Money?')" >Generate Money Received Report <i class="fas fa-redo"></i></button>
																	</form>
																	<?php } } ?>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php } ?>
										<?php if(check_permission('role_1609828362_81')){ ?>
										<div class="tab-pane fade" id="custom-tabs-four-collected_dropbox" role="tabpanel" aria-labelledby="custom-tabs-four-collected_dropbox-tab">
											<div class="card card-primary">
												<div class="card-header">
													<h3 class="card-title"><i class="far fa-bed"></i>Collected Form DropBox</h3>
													<div id="export_buttons_dropbox_collection" style="float: right;"></div>
												</div>
												<style>
													.table_header{
														color:#f00;
														font-weight:bolder;
														background-color:#fff;
														padding:3px;
														border-radius:5px;
													}
												</style>											
												<div class="card-body">	
													<table id="collection_money_from_dropbox" class="table table-sm table-bordered" style="width:100%;white-space: nowrap;">
														<thead>
															<tr>
																<th>DB:ID</th>																
																<th>Collected Money ID</th>																
																<th>Collected By</th>
																<th>Date</th>
																<th>Collected Branch</th>
																<th>Note</th>
																<th>Collected Amount</th>
																<th>Option</th>
															</tr>
														</thead>
														<tbody><?php /* ?>


<?php
if(!empty($collection_money_from_dropbox)){
	$total_amount_collection = 0;
	foreach($collection_money_from_dropbox as $row){ 

	$up_inf = explode('___',$row->uploader_info);
	if(!empty($employee_info)){
		$employee = '';
		foreach($employee_info as $eow){
			if(!empty($eow->email) AND !empty($up_inf[1]) AND $eow->email == $up_inf[1] ){
				$employee .= $eow->full_name.' | <span style="font-weight:bolder;">'.$eow->employee_id.'</span> | <a href="mailto:'.$eow->email.'" target="_blank" title="Click to send mail">'.$eow->email.'</a>';
			}else{
				$employee .= '';
			}		    
		}
	}
	$cl_amount = 0;
	$ids = explode(",",$row->transaction_ids);
	foreach($ids as $iow){
		if(!empty($drop_box_data)){
			foreach($drop_box_data as $dow){
				if($dow->id == $iow){
					$cl_amount = $cl_amount + (float)$dow->amount;
				}
			}
		}
	}
?>
															<tr>
																<td><?php echo $row->uniq_id; ?></td>																
																<td><?php echo $employee; ?></td>
																<td><?php echo $row->data; ?></td>
																<td><?php echo $row->branch_name; ?></td>
																<td><?php echo $row->note; ?></td>
																<td><?php echo money($cl_amount); ?></td>
																<td>
																	<button onclick="return details_collection_money('<?php echo rahat_encode($row->transaction_ids); ?>')" class="btn btn-xs btn-success" type="button">View Details</button>
																</td>
															</tr>											
<?php 
	$total_amount_collection = (int)$total_amount_collection + $cl_amount;
	} 
}
?>	
															<tr>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td style="text-align:right;font-weight:bolder;">Total:</td>
																<td><span class="table_header" style="font-weight:bolder;"><?php echo money($total_amount_collection); ?></span></td>
																<td> </td>
															</tr><?php */ ?>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<?php } ?>
										
									</div>
								</div>
							</div>

							
							
							
						</div>
					</div>		
					
				</div>
			</div>
		</div>
	</div>
</div>
<!----Add Rent Model-->
	<div class="modal fade" id="collection_details_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">				
				<div class="modal-header btn-success">
					<h4 class="modal-title">Callection Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="callection_details_body" style="max-height:780px;min-height:400px;overflow-y:scroll;">	
					
				</div>
			</div>
		</div>
	</div>
<!----End Add Rent Model-->

<!----vaiw member profile model-->
<div class="modal fade" id="member_prifile_model">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-warning">
						<h4 class="modal-title">Member Profile Information</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="members_result" style="max-height:780px;overflow-y:scroll;">	

						
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" onclick="return ref_bed_typ()" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
						<div>
							<button type="button" id="select_bed" class="btn btn-warning"><i class="fas fa-save"></i> Select</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End vaiw member profile model-->

<!---
<form action="<?php echo current_url(); ?>" method="post">
	<input type="hidden" name="hidden_id" value="<?php echo $row->id; ?>"/>
	<button onclick="return confirm('Are You sure want to sent back this transaction?')" class="btn btn-xs btn-danger" name="missing" type="submit"><i class="fas fa-backspace"></i> Missing</button>
</form>
																	
-->																	

<script>
function view_member_profile(id){
	var profile_id = id;
	if(profile_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/member_profile_information.php');?>",  
			method:"POST",  
			data:{profile_id:profile_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result').html(data); 
				$('#member_prifile_model').modal('show');   
			}  
		});  
	}
}
function details_collection_money(ids){
	if(ids != ''){
		$.ajax({
			url:'<?php echo base_url(); ?>assets/ajax/option_select/collected_money_details_information.php',
			method:'POST',
			data:{collected_id:ids},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){
				$('#data-loading').html('');
				$("#callection_details_body").html(data);				
				$("#collection_details_model").modal('show');				
			}     
		});
	} 
}
$(document).ready(function(){ 
	$("#select_back").click(function(){
			$('.sent_back_ides_checkbox:checkbox').prop('checked',true);     
	});
	$("#unselect_back").click(function(){
			$('.sent_back_ides_checkbox:checkbox').prop('checked',false);     
	});
	$('#btn_delete_back').click(function(){  
		if(confirm("Are you sure you want to Missing selected Iteam?")){
			var id = [];   
			$('.sent_back_ides_checkbox:checkbox:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					url:'<?= current_url(); ?>',
					method:'POST',
					data:{missing_id:id},
					beforeSend:function(){					
						$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
					},
					success:function(data){
						$('#data-loading').html('');
						var val = data.split('________');
						alert(val[0]);
						window.open('<?= current_url(); ?>','_self');
					}     
				});
			}   
		}else{
			return false;
		}
	});

	//sent_ides_checkbox
	$("#select").click(function(){
			$('.sent_ides_checkbox:checkbox').prop('checked',true);     
	});
	$("#unselect").click(function(){
			$('.sent_ides_checkbox:checkbox').prop('checked',false);     
	});
	$('#btn_delete').click(function(){  
		if(confirm("Are you sure you want to send selected Iteam?")){
			var id = [];   
			$('.sent_ides_checkbox:checkbox:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select at least one checkbox");
			} else {
				$.ajax({
					url:'<?= current_url(); ?>',
					method:'POST',
					data:{copy_id:id},
					beforeSend:function(){					
						$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
					},
					success:function(data){
						$('#data-loading').html('');
						var val = data.split('________');
						alert(val[0]);
						window.open('<?= current_url(); ?>','_self');
					}     
				});
			}   
		}else{
			return false;
		}
	});
 
});

//-----------------rental work java script-------------------------
$('document').ready(function(){
	var table_booking1 = $('#booking_data_table').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": false,
		"autoWidth": false,
		"responsive": false,		
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				customize: function(win)
				{
	
					var last = null;
					var current = null;
					var bod = [];
	
					var css = '@page { size: landscape; }',
						head = win.document.head || win.document.getElementsByTagName('head')[0],
						style = win.document.createElement('style');
	
					style.type = 'text/css';
					style.media = 'print';
	
					if (style.styleSheet)
					{
					style.styleSheet.cssText = css;
					}
					else
					{
					style.appendChild(win.document.createTextNode(css));
					}
	
					head.appendChild(style);
				}
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table_booking1.buttons().container().appendTo($('#export_buttons'));
	
	var table_booking2 = $('#booking_data_table_due').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": false,
		"autoWidth": false,
		"responsive": false,		
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table_booking2.buttons().container().appendTo($('#export_buttons_due'));	
	
	var table_booking3 = $('#data_table_drop_box').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": false,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print',
				exportOptions: {
                    columns: ':visible'
                }
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	table_booking3.buttons().container().appendTo($('#export_buttons_dropbox'));
	
	
	var table_booking4 = $('#collection_money_from_dropbox').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": true,
		"responsive": true,
		"serverSide": true,
		"ScrollX": true,
		"processing": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/report/collection_money_from_dropbox_datatable.php",
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            },{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]
    });
	 table_booking4.buttons().container().appendTo($('#export_buttons_dropbox_collection'));
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>