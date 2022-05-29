<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['branch_id'])){
	$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$_POST['branch_id']."' and status = '1'"));
?>
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/fullcalendar/main.min.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/fullcalendar-bootstrap/main.min.css">
<style>
	.color_code_bed{
		width: 7px;
		height:7px;
	}
	.bed_color_info{
		padding-left: 20px;
	}
	.p_b_b{
		width:7px;
		height:7px;
		border-radius:20px;
		display:block !important;
		float:left;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<?php
			$target_elec = mysqli_fetch_assoc($mysqli->query("select * from branch_elictric_bill where branch_id = '".$branch_info['branch_id']."' and month_year = '".date('m/Y')."' order by id desc"));
			if(!empty($target_elec['amount']) AND $target_elec['amount'] > 0){
				$target_elec_amount = (int)$target_elec['amount'];
			}else{
				$target_elec_amount = 0;
			}
			$adj_amount = mysqli_fetch_assoc($mysqli->query("select sum(amount) as adjest_amount from electicity_bill where branch_id = '".$branch_info['branch_id']."' and month_year = '".date('m/Y')."' order by id desc"));
		?>
		<center>
			<h1><i class="far fa-building"></i> Branch: <b><?php echo $branch_info['branch_name']; ?></b></h1>
			<?php  ?>
			<span style="line-height: 35px;">
				Target Electric Bill: <b><?php echo money($target_elec_amount); ?></b> - 
				Adjust Amount: <b><?php echo money($adj_amount['adjest_amount']); ?></b>
			</span>
			<?php ?>
		</center>
<?php
$ful = $mysqli->query("select * from floors where branch_id = '".$branch_info['branch_id']."' and status = '1' order by floor_name desc");
while($floor_info = mysqli_fetch_assoc($ful)){
?>
		<div class="card card-primary" style="border:solid 1px #333;">
            <div class="row">
				<div class="col-sm-1" style="">
					<div class="card-header">
						<h3 class="card-title"><b><?php echo $floor_info['floor_name']; ?></b> <?php if(!empty($floor_info['note'])){ echo '- '.$floor_info['note']; } ?></h3>
					</div> 
					<div class="row">
						<div class="col-sm-12">
							<ul class="bed_color_info">
<?php
$Available = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND uses = '0' AND status = '1'"));
$Booked = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND uses = '2' AND status = '1'"));
$Occupide = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND uses = '3' AND status = '1'"));
$Request = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND uses = '4' AND status = '1'"));
$Employee = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND uses = '5' AND status = '1'"));
$Service = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND uses = '6' AND status = '1'"));
$Disabled = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND status = '0'"));

?>							
								<?php if( $Available[0] > 0){ ?><li><div class="badge badge-info">Available (<?php echo $Available[0]; ?>)</div></li><?php } ?>
								<?php if( $Booked[0] > 0){ ?><li><div class="badge badge-default" style="border: solid 1px #cecece;">Booked (<?php echo $Booked[0]; ?>)</div></li><?php } ?>
								<?php if( $Occupide[0] > 0){ ?><li><div class="badge badge-warning">Occupide (<?php echo $Occupide[0]; ?>)</div></li><?php } ?>
								<?php if( $Request[0] > 0){ ?><li><div class="badge badge-danger">Request For Cancel (<?php echo $Request[0]; ?>)</div></li><?php } ?>
								<?php if( $Employee[0] > 0){ ?><li><div class="badge badge-primary">Employee (<?php echo $Employee[0]; ?>)</div></li><?php } ?>
								<?php if( $Service[0] > 0){ ?><li><div class="badge badge-secondary">Out Of Service (<?php echo $Service[0]; ?>)</div></li><?php } ?>
								<?php if( $Disabled[0] > 0){ ?><li><div class="badge badge-dark">Disabled (<?php echo $Disabled[0]; ?>)</div></li><?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-11">         
					<form role="form" style="padding:0px;">
						<div class="card-body" style="padding:0px;">
							<div class="row">
<?php
$unt = $mysqli->query("select * from units where floor_id = '".$floor_info['id']."' and status = '1'");
while($unit_info = mysqli_fetch_assoc($unt)){
?>
								<div class="col-sm-6">								
									<div class="card card-warning">
										<div class="row">
											<div class="col-sm-1">
												<div class="card-header">
													<h3 class="card-title"><b><?php echo $unit_info['unit_name']; ?></b> <?php if(!empty($unit_info['note'])){ echo '- '.$unit_info['note']; } ?></h3>
												</div>  
											</div>
											<div class="col-sm-11">														
												<form role="form">
													<div class="card-body" style="padding:0px;">
														<div class="row">
<?php
$sql3 = $mysqli->query("select * from rooms where unit_id = '".$unit_info['id']."'");
while($room = mysqli_fetch_assoc($sql3)){
?>
														<div class="col-sm-6">
															<div class="card card-success">
																<div class="card-header">
																	<h3 class="card-title" style="font-size:14px;">Room:- <?php echo $room['room_name']; ?><?php if(!empty($room['note'])){ echo ' - '.$room['note']; } ?></h3>
																	<?php  if(check_permission('role_1618136583_47')){ ?>
																	<button type="button" onclick="return add_electricity_bill('<?php echo $room['id']; ?>','Room:- <?php echo $room['room_name']; ?><?php if(!empty($room['note'])){ echo ' - '.$room['note']; } ?>')" class="btn btn-xs btn-dark" style="float:right;" title="Add Electic Bill"><i class="fas fa-bolt"></i></button>
																	<?php }  ?>
																</div>
																<div class="card-body" style="padding-left:1px;padding-right:1px;">
																	<div class="row">
																	
																	
<?php
$sq_com = $mysqli->query("select * from column_list where room_id = '".$room['id']."'");
while($col = mysqli_fetch_assoc($sq_com)){
?>													
																	<div class="col-sm-2" style="">
<?php
$sql4 = $mysqli->query("select * from beds where room_id = '".$room['id']."' and coloumn_id = '".$col['id']."' order by id desc");
while($bed = mysqli_fetch_assoc($sql4)){	
	if($bed['uses'] == 2 ){
	$member_information = mysqli_fetch_assoc($mysqli->query("SELECT * FROM member_directory WHERE bed_id = '".$bed['id']."' AND status = '1' ORDER BY id DESC"));
	if(!empty($member_information['id'])){
		$package = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$member_information['package']."'"));
		if($package['try_us'] == 0){
			$check_in = explode('/',$member_information['check_in_date']);
			if($member_information['check_out_date'] == 'Not Confirm Yet'){
				$pad = explode('/',$member_information['check_in_date']);
				$pao = $pad[2].'-'.$pad[1].'-'.$pad[0];
				$check_outt = date('d/m/Y', strtotime($pao. ' + 180 days')); //membership days variable				
				$check_out = explode('/',$check_outt);			
			}else{
				$check_out = explode('/',$member_information['check_out_date']);
			}
		}else{
			$check_in = explode('/',$member_information['check_in_date']);
			$check_out = explode('/',$member_information['check_out_date']);			
		}
		$in_year = $check_in[2];
		$in_month = $check_in[1];
		$in_day = $check_in[0];
		
		$out_year = $check_out[2];
		$out_month = $check_out[1];
		$out_day = $check_out[0];
		
		$run_year = date('Y');
		$run_month = date('m');
		$run_day = date('d');
		
		$send_in_date = rahat_encode($in_day.'/'.$in_month.'/'.$in_year);
		$send_out_date = rahat_encode($out_day.'/'.$out_month.'/'.$out_year);
		
		$c_live_data = $in_year.$in_month.$in_day;

		$bed_count =  mysqli_fetch_assoc($mysqli->query("SELECT * FROM member_directory WHERE bed_id = '".$bed['id']."' AND status = '1' ORDER BY id DESC"));
		
		if( date('Ymd') <= $c_live_data ){ //date('d') <= $in_day AND  date('m') <= $in_month AND  date('Y') <= $in_year
?>
																		<button onclick="return boked_clander('<?php echo $bed['id']; ?>', '<?php echo $send_in_date; ?>', '<?php echo $send_out_date; ?>')" class="btn btn-info btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;">
																			<div class="badge badge-danger p_b_b"></div>
																			<?php echo substr($bed['bed_name'],4); ?>
																		</button>
<?php }else{
	if($member_information['card_number'] == 'Unauthorized'){			// adding dot in booked bed by rayhan siddiki (23-06-2021)
?>																		<button  onclick="return boked_clander('<?php echo $bed['id']; ?>', '<?php echo $send_in_date; ?>', '<?php echo $send_out_date; ?>')" class="btn btn-default btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;height:23px;"> <!---onclick="return view_member_profile(<?php if(!empty($member_information['id'])){ echo $member_information['id']; } ?>)"---->
																			<div class="badge badge-dark p_b_b" style="float:right;"></div>
																			<?php if(!empty($member_information['parking']) AND $member_information['parking'] == '1' ){ ?>
																			<span class="button_icon" style="left: 9%;color:red;"><i class="fas fa-biking"></i></span>
																			<?php } if(!empty($member_information['locker_qty']) AND $member_information['locker_qty'] == '1' ){ ?>
																			<span class="button_icon" style="right: 5%;color:green"><i class="fas fa-user-lock"></i></span>
																			<?php } ?>		
																			
																			<div class="inline-block" style="margin-top:-5px;">
																				<?php echo substr($bed['bed_name'],4); ?>
																			</div>
																			<!--booked to Ocupide edit by Shariful islam (22-06-2021)-->
																		</button>

	<?php } else {?>
																		
																		<button  onclick="return boked_clander('<?php echo $bed['id']; ?>', '<?php echo $send_in_date; ?>', '<?php echo $send_out_date; ?>')" class="btn btn-warning btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;height:23px;"> <!---onclick="return view_member_profile(<?php if(!empty($member_information['id'])){ echo $member_information['id']; } ?>)"---->
																			<div class="badge badge-dark p_b_b" style="float:right;"></div>
																			<?php if(!empty($member_information['parking']) AND $member_information['parking'] == '1' ){ ?>
																			<span class="button_icon" style="left: 9%;color:red;"><i class="fas fa-biking"></i></span>
																			<?php } if(!empty($member_information['locker_qty']) AND $member_information['locker_qty'] == '1' ){ ?>
																			<span class="button_icon" style="right: 5%;color:green"><i class="fas fa-user-lock"></i></span>
																			<?php } ?>		
																			
																			<div class="inline-block" style="margin-top:-5px;">
																				<?php echo substr($bed['bed_name'],4); ?>
																			</div>
																			<!--booked to Ocupide edit by Shariful islam (22-06-2021)-->
																		</button>
<?php } } } else{ ?>																		
																		<button onclick="return get_bet_info_at(<?php echo $bed['id']; ?>)" class="btn btn-info btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;"><?php echo substr($bed['bed_name'],4); ?></button>
<?php 
	}
}else if($bed['uses'] == 3 ){ 
	$member_information = mysqli_fetch_assoc($mysqli->query("select id,parking,locker_qty from member_directory where bed_id = '".$bed['id']."'"));

	$b_id=$branch_info['branch_id'];
	$bad_n=$bed['bed_name'];
	$mycount=mysqli_fetch_array($mysqli->query("SELECT COUNT(*) AS mem_num FROM member_directory WHERE member_directory.branch_id ='$b_id' AND member_directory.bed_name='$bad_n' AND member_directory.status = 1"));
	// echo $bad_ob= $mycount['mem_num']; 
	
// ?>																		
																		<button onclick="return view_member_profile(<?php if(!empty($member_information['id'])){ echo $member_information['id']; } ?>)" class="btn btn-warning btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;height:23px;">
																			<?php if(!empty($member_information['parking']) AND $member_information['parking'] == '1' ){ ?>
																			<span class="button_icon" style="left: 9%;color:red;"><i class="fas fa-biking"></i></span>

																			<?php } if(!empty($member_information['locker_qty']) AND $member_information['locker_qty'] == '1' ){ ?>
																			<span class="button_icon" style="right: 5%;color:green"><i class="fas fa-user-lock"></i></span>
																			<?php } ?>
																			<div  class="inline-block">
																				<?php echo substr($bed['bed_name'],4); ?><?php if ($mycount['mem_num']>1) { echo '/&nbsp;'.$mycount['mem_num']; }; ?>
																			</div >
																		</button>
<?php }else if($bed['uses'] == 4 ){ 
	$member_information = mysqli_fetch_assoc($mysqli->query("select id,parking,locker_qty from member_directory where bed_id = '".$bed['id']."'"));
?>
																		<button onclick="return view_member_profile(<?php if(!empty($member_information['id'])){ echo $member_information['id']; } ?>)" class="btn btn-danger btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;height:23px;">
																			<?php if(!empty($member_information['parking']) AND $member_information['parking'] == '1' ){ ?>
																			<!-- <span class="button_icon" style="left: 9%;color:red;"><i class="fas fa-biking"></i></span> -->
																			<?php } if(!empty($member_information['locker_qty']) AND $member_information['locker_qty'] == '1' ){ ?>
																			<span class="button_icon" style="right: 5%;color:green"><i class="fas fa-user-lock"></i></span>
																			<?php } ?>
																			<div  class="inline-block">
																				<?php echo substr($bed['bed_name'],4); ?>
																			</div>
																		</button>
<?php }else if($bed['uses'] == 5 ){ 
	//$employee_info = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE assign_bed = '".$bed['id']."'"));
?>
																		<button onclick="" class="btn btn-primary btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;height:23px;cursor: not-allowed;" >
																			<div class="inline-block">
																				<?php echo substr($bed['bed_name'],4); ?>
																			</div>
																		</button>
<?php }else if($bed['uses'] == 6 ){ 
?>
																		<button onclick="" class="btn btn-xs" id="" type="button" style="background-color: lightslategray;width:100%;margin-bottom:10px;height:23px;cursor: not-allowed;color:#fff;" >
																			<div class="inline-block">
																				<?php echo substr($bed['bed_name'],4); ?>
																			</div>
																		</button>
<?php }else{ 
		if($bed['status'] == 1){
			if($bed['uses'] == 0){
?>
																		<button onclick="return get_bet_info_at(<?php echo $bed['id']; ?>)" class="btn btn-info btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;"><?php echo substr($bed['bed_name'],4); ?></button>										
<?php
			}
		}else{
?>
																		<button class="btn btn-dark btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;height:23px;cursor: not-allowed;" title="Disable">
																			<div class="inline-block">
																				<?php echo substr($bed['bed_name'],4); ?>
																			</div>
																		</button>
<?php 
		}
	} 
} 
?>

																	</div>
<?php } ?>
																</div>
																			
<?php
$msg = mysqli_fetch_assoc($mysqli->query("select * from beds where room_id = '".$room['id']."'"));
if(empty($msg['id'])){
	echo '<h3 class="" style="text-align:center;">Bed Not Available!</h3>';
}
?>												
																</div>
															</div>
														</div>
<?php } ?>
														</div>
													</div>
												</form>
											</div>
										</div>
										
									</div>
									
									
									
								</div>
<?php } ?>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
<?php } ?>
	</div>
</div>
<style>
.button_icon{
	position: absolute;
	margin-top: -15%;
}
</style>
<div class="modal fade" id="bed_selecting_model_clender"> 
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Bed booked information</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="bed_result_clander"></div>
			</form>
		</div>
	</div>
</div>
<!----End bed model-->

<div class="modal fade" id="add_eleecctriciry_bill_modal"> 
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="add_eleecctriciry_bill_form" action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-dark">
					<h4 class="modal-title">Add Eleccrity Bill</h4>
					<button onclick="return close_electricity_bill()" type="button" class="close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="add_eleecctriciry_bill_result">					
				</div>
			</form>
		</div>
	</div>
</div>
<!----End bed model-->
<script>
$('document').ready(function(){
	$("#add_eleecctriciry_bill_form").on("submit",function(){
		if(confirm('Are you checked All data correctly!?')){
			event.preventDefault();
			var form = $('#add_eleecctriciry_bill_form')[0];
			var data = new FormData(form);
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url:"<?php echo $home.'assets/ajax/option_select/add_room_electrict_bill_overview_booking.php'; ?>",  
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				beforeSend:function(){
					$('input[name="add_electricity_bill_button"]').prop("disabled", true);
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$('input[name="add_electricity_bill_button"]').prop("disabled", true);
					alert(data);
					$('#add_eleecctriciry_bill_modal').modal('hide');													
				}
			});			
		}else{
			$('#return_money_manage_modal').modal('hide');
		}
		return false;
	})
})
function close_electricity_bill(){
	$("#add_eleecctriciry_bill_modal").modal('hide');
}
function add_electricity_bill(id,name){
	if( id != ''){
		$.ajax({  
			url:"<?php echo $home.'assets/ajax/option_select/add_room_electrict_bill_overview_booking.php'; ?>",  
			method:"POST",
			data:{ 
				room_id:id,
				room_name:name
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');											
				$("#add_eleecctriciry_bill_result").html(data);
				$("#add_eleecctriciry_bill_modal").modal('show');
			}
		});  
	}else{
		alert('Something wrong! Please try again.');
	}	
}
function boked_clander(id, in_date, out_date){
	if( id != ''){
		$.ajax({  
			url:"<?php echo $home.'assets/ajax/option_select/clander_building_overview_booking.php'; ?>",  
			method:"POST",
			data:{
				bed_id:id,
				in_date:in_date,
				out_date:out_date
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');								
				$('#bed_result_clander').html(data);
				$("#bed_selecting_model_clender").modal('show');
				setTimeout(function(){ 
					return booking_calender_fuc();
				}, 500);
			}  
		});  
	}	
}
</script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar/main.min.js"></script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar-interaction/main.min.js"></script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar-bootstrap/main.min.js"></script>
<?php } ?>