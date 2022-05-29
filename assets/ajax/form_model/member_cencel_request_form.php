<?php
include("../../../application/config/ajax_config.php");
function month_name($num){ if($num == '01'){ return 'January'; }else if($num == '02'){ return 'February'; }else if($num == '03'){ return 'March'; }else if($num == '04'){ return 'April'; }else if($num == '05'){ return 'May'; }else if($num == '06'){ return 'Jun'; }else if($num == '07'){ return 'July'; }else if($num == '08'){ return 'August'; }else if($num == '09'){ return 'September'; }else if($num == '10'){ return 'October'; }else if($num == '11'){ return 'November'; }else{ return 'December'; } }
if(isset($_POST['pre_check_print'])){
	$row = mysqli_fetch_assoc($mysqli->query("SELECT * FROM member_directory WHERE id = '".$_POST['pre_check_print']."'"));
	//$_INSERT_CHECK_DATA = $mysqli->query("INSERT INTO ");
}




if(isset($_POST['book_id'])){ 
$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['book_id']."'"));
$bed_info = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$member_info['bed_id']."'"));
$rent_info = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$member_info['booking_id']."' order by id desc"));
if($member_info['card_number'] == 'Unauthorized'){ ?>
	<div class="row">
		<div class="col-sm-12">
			<h1 style="text-align:center;color:#f00;margin-top: 169px;">Account Unauthorized!<br />Please Athorized It Before Cancel Request</h1>
		</div>	
	</div>		
<?php 
	$unatho = '1';
}else{ 
	$unatho = '0'
?>
<div class="row">
	<div class="col-sm-12">
		<form id="cencel_requiest_form" action="#" method="post" enctype="multipart/form-data">
			<input type="hidden" name="member_id" value="<?php echo $member_info['id']; ?>"/>
			<input type="hidden" name="bed_id" value="<?php echo $member_info['id']; ?>"/>
			<input type="hidden" name="uploader_info" value="<?php echo $_POST['uploader_info']; ?>"/>
			<div class="row">
				<div class="col-sm-12">
					<span id="cencel_request_error_message" style="color:#f00;font-weight:bolder;"></span>
				</div>
			</div>
			<div class="row">				
				<div class="col-sm-9">
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Cancel Form</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Select Check Out Date</label>
										<?php $number_of_month = cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));?>
										<?php
											$pckg_inf = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member_info['package']."'")); //
											if($pckg_inf['try_us'] == '1'){
												$tyu = explode('/',$member_info['check_out_date']); //check_out_date
												$min_data = $tyu[2].'-'.$tyu[1].'-'.$tyu[0];
												$tryus = 1;
											}else{
												$min_data = date('Y-m').'-'.$number_of_month;
												$tryus = 0;
											}
										?>
										
										<input type="date" name="checkout_date" value="" min="<?php echo $min_data; ?>" class="form-control" required/>
									</div>
									<div class="form-group">
										<label>Note / Reason</label>
										<textarea name="note" class="form-control" required></textarea>
									</div>
								</div>
								<div class="col-sm-6">
									<center style="margin-top:70px;">
										<?php
											if($tryus == 0){
												//$rent_d = explode(" ", $rent_info['data']);
												if(!empty($rent_info['data'])){												
													$rent_s = explode('/',$rent_info['data']);
													$rent_g = $rent_s[0];
													$rent_m = $rent_s[1];
													if(date('d') <= 10 AND $rent_info['payment_pattern'] == 1 AND $rent_info['month_name'] == month_name(date('m'))){ // 
														$rent_clr = 1;
										?>
										<span style="color:green;font-size:30px;">
											Rent Clear FOR CENCEL
										</span>		
										<?php 
													}else{ 
														$rent_clr = 0;
										?>
										<span style="color:#f00;font-size:30px;">
											Rent Not Clear FOR CENCEL
										</span>		
										<?php 
													}
												}else{ 
													$rent_clr = 0;
										?>
										<span style="color:#f00;font-size:30px;">
											Rent Not Clear FOR CENCEL
										</span>	
										<?php
												}
											}else{ 
											$rent_clr = 1;
										?>
										<span style="color:#f00;font-size:30px;">
											Membership : Try Us
										</span>	
										<?php 
											} 
										if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
											$rent_clr = 1;
										}
										?>							
									</center>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" id="cencel_request_button" class="btn btn-danger" style="float:right;" <?php if($rent_clr == '0'){ echo 'disabled'; } ?>><i class="fas fa-calendar-times"></i> Request Cencel</button>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="card card-info">
						<div class="card-header">
							<h3 class="card-title">Member Details</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<?php 
									if(!empty($member_info['photo_avater'])){
										echo '<img src="'.$home.$member_info['photo_avater'].'" style="width:100%;" class="image-responsive"/>';
									}else{
										echo '<img src="'.$home.'assets/img/photo_avatar.png" style="width:100%;" class="image-responsive"/>';
									}
									?>								
								</div>
								<div class="col-sm-12">
									<p>&nbsp;</p>
									Name: <b style="float:right;"><?php echo $member_info['full_name']; ?></b><br />
									Card NO: <b style="float:right;"><?php echo $member_info['card_number']; ?></b><br />
									Bed No: <b style="float:right;"><?php echo $member_info['bed_name']; ?></b><br />
									Phone NO: <b style="float:right;"><?php echo $member_info['phone_number']; ?></b><br />
									CheckInDate: <b style="float:right;"><?php echo $member_info['check_in_date']; ?></b><br />
									Package: <b style="float:right;"><?php echo $member_info['package_name']; ?></b><br />
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script>
$("#cencel_requiest_form").on("submit",function(){
	event.preventDefault();
	var form = $('#cencel_requiest_form')[0];
	var data = new FormData(form);
	$.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url:"<?php echo $home.'assets/ajax/form_submit/request_for_cencel_submit.php'; ?>",  
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		beforeSend:function(){
			$("#cencel_request_button").prop("disabled", true);
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			$('#data-loading').html('');
			var value = data.split('____');
			if(value[1] == '1'){
				$('#cencel_request_error_message').html(value[0]);
				$("#cencel_request_button").prop("disabled", false);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
			}else{
				$('#data_send_success_message').html(value[0]);										
				$('#request_for_celcel_model').modal('hide');
				$("#cencel_request_button").prop("disabled", false);
				$('#booking_data_table').DataTable().ajax.reload( null , false);
			}					
		}
	});
	return false;
})
</script>		
<?php } ?>
<script>
$('document').ready(function(){
	var member_id = "<?php echo $member_info['id']; ?>";
	$("#force_cencel_button").on("click",function(){
		if(confirm("Are you sure want to force cancel this member (<?php echo $member_info['full_name']; ?>)")){
			if(member_id != ''){
				$.ajax({  
					url:"<?php echo $home.'assets/ajax/form_submit/force_cancel_submit.php';?>",  
					method:"POST",  
					data:{member_id:member_id},
					beforeSend:function(){
						$("#force_cencel_button").prop("disabled", true);
						$('#data-loading').html(data_loading);					 
					},
					success:function(data){	
						$('#data-loading').html('');
						$("#force_cencel_button").prop("disabled", false);
						$('#booking_data_table').DataTable().ajax.reload( null , false);
						alert(data); 
						$('#request_for_celcel_model').modal('hide'); 
					}
				});  
			}
		}else{
			return false;
		}
	})
})
</script>
<div class="row">
	<div class="col-sm-12">
		<?php
		if($unatho == '0'){
		$package_info = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$member_info['package']."'")); 
		if($package_info['try_us'] == 0){
		?>
		<button type="button" onclick="return send_cencel_request_message(<?php echo $member_info['id']; ?>)" class="btn btn-success" style="float:right;margin-right:15px;"><i class="fas fa-user"></i> Send Message</button>
		<?php }} ?>
		<?php if(check_permission('role_1631090450_89')){ ?>
		<button type="button" id="force_cencel_button" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="fas fa-user-times"></i> Force Cancel!</button>
		<?php } ?>
	</div>
</div>
<?php } ?>