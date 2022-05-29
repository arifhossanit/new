
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Refreshment Item</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Refreshment Item</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container">
		<div class="card card-primary card-outline card-outline-tabs">
			<div class="card-header p-0 border-bottom-0">
				<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Sell</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Welcome Tea & Coffee</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Facebook Winner</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-investor" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Investor Refreshments</a>
					</li>
				</ul>
			</div>
			<div class="card-body">
				<div class="tab-content" id="custom-tabs-four-tabContent">
					<div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
						 <div class="card card-success">
							<div class="card-header">
								<h3 class="card-title">Sell Item</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">		
										<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/fform-data">
											<div class="row">
												<div class="col-sm-3">
													<div class="form-group">
														<input type="text" id="card_number" autocomplete="off" name="card_number" class="form-control" placeholder="Card Number" required/>
													</div>
												</div>
												<div class="col-sm-2">
													<div class="form-group">
														<select name="payment_status" class="form-control" required>
															<option value="">select</option>
															<option value="Paid">Paid</option>
															<option value="Due">Due</option>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12" id="refreshment_iteam" style="min-height:500px;max-height:500px;overflow-y:scroll;">								
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group" style="margin-top:20px;">
														<textarea name="note" class="form-control" placeholder="Note"></textarea>
													</div>
												</div>
											</div>
											<div class="form-group">
												<button type="submit" name="save" style="float:right;" class="btn btn-success">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
						<div class="card card-dark">
							<div class="card-header">
								<h3 class="card-title">Welcome Tea & Coffee</h3>
							</div>
							<div class="card-body">
								<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
											<div class="form-group">
												<label>Phone Number</label>
												<input type="text" name="phone_number" placeholder="Phone Number" autocomplete="off" class="number_int form-control" required />
											</div>
											<div class="form-group">
												<label>Select Iteam</label>
												<select name="item_id" class="select2 form-control">
													<option>--select one--</option>
													<?php 
														$item = $this->Dashboard_model->mysqlii("select * from refreshment_item where status = '1' and welcome_tea = '1' and branch_id = '".$_SESSION['super_admin']['branch']."'");
														if(!empty($item)){
															foreach($item as $row){
																echo '<option value="'.$row->id.'">'.$row->item_name.'</option>';
															}
														}
													?>
												</select>
											</div>
											<div class="form-group">
												<label>Note</label>
												<textarea name="note" class="form-control" placeholder="Note"></textarea>
											</div>
											<div class="form-group">
												<button name="submit_welcome_tea" type="submit" class="btn btn-dark" style="width:100%">Submit</button>
											</div>
										</div>
										<div class="col-sm-4"></div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
						<div class="card card-info">
							<div class="card-header">
								<h3 class="card-title">Facebook Winner</h3>
							</div>
							<div class="card-body">
								<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-4"></div>
										<div class="col-sm-4">
											<div class="form-group">
												<label>Phone Number</label>
												<input type="text" name="phone_number" placeholder="Phone Number" autocomplete="off" class="number_int form-control" required />
											</div>
											<div class="form-group">
												<label>Select Iteam</label>
												<select name="item_id" class="select2 form-control">
													<option>--select one--</option>
													<?php 
														$item = $this->Dashboard_model->mysqlii("select * from refreshment_item where status = '1' and facebook_winner = '1' and branch_id = '".$_SESSION['super_admin']['branch']."'");
														if(!empty($item)){
															foreach($item as $row){
																echo '<option value="'.$row->id.'">'.$row->item_name.'</option>';
															}
														}
													?>
												</select>
											</div>
											<div class="form-group">
												<label>Select Attachment</label>
												<input type="file" name="attachment[]" class="form-control" style="padding:3px;" multiple required />
											</div>
											<div class="form-group">
												<label>Post URL</label>
												<input type="url" name="post_url" placeholder="Post URL" autocomplete="off" class="form-control" required />
											</div>
											<div class="form-group">
												<label>Note</label>
												<textarea name="note" class="form-control" placeholder="Note"></textarea>
											</div>
											<div class="form-group">
												<button name="submit_facebook_winner" type="submit" class="btn btn-info" style="width:100%">Submit</button>
											</div>
										</div>
										<div class="col-sm-4"></div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="custom-tabs-four-investor" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
						 <div class="card card-success">
							<div class="card-header">
								<h3 class="card-title">Sell Item</h3>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">		
										<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/fform-data">
											<div class="row">
												<div class="col-sm-3">
													<div class="form-group">
														<input type="text" id="investor_card_number" autocomplete="off" name="investor_card_number" class="form-control" placeholder="Investor Card Number" required/>
													</div>
												</div>
											</div>
											<div class="row" id="investor_refreshment_div">
												
											</div>
											<div class="form-group mt-4" id="investor_refreshment_button">
											</div>
										</form>
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
<script>
var branch_id = "<?php echo $_SESSION['super_admin']['branch']; ?>";
$("#investor_card_number").on("keyup keydown",function(){
	var card_number = $(this).val();
	//if(card_number != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/investor_refreshment_iteam_list.php'); ?>",  
			method:"POST",  
			data:{card_number:card_number},
			success:function(data){
				let info = JSON.parse(data);
				$('#investor_refreshment_div').html(info.html);
			}  
		});
	//}
})
function send_investor_otp(card_number){
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/investor_refreshment_send_otp.php'); ?>",  
		method:"POST",  
		data:{card_number:card_number},
		success:function(data){
			let info = JSON.parse(data);
			$('#confirm_otp_div').html(info.html);
			$('#send_otp_button').html(info.button);
			$('#send_otp_button').removeAttr('onclick');
			setTimeout(function(){
				$('#send_otp_button').html('Resend');
				$('#send_otp_button').attr('onClick', `send_investor_otp('${card_number}')`);
			}, 60000)
		}  
	});
}
function confirm_investor_otp(){
	var card_number = $('#investor_card_number').val();
	var confirm_otp = $('#confirm_otp').val();
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/investor_refreshment_confirm_otp.php'); ?>",  
		method:"POST",  
		data:{confirm_otp:confirm_otp,card_number:card_number},
		success:function(data){
			let info = JSON.parse(data);
			$('#items_div').html(info.html);
			$('#investor_refreshment_button').html(info.button);
			$('#refreshment_table').DataTable();
		}  
	});
}
$('document').ready(function(){
	$("#card_number").focus();
	$("#card_number").on("keyup keydown",function(){
		var card_number = $(this).val();
		//if(card_number != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/form_model/refreshment_iteam_list.php'); ?>",  
				method:"POST",  
				data:{card_number:card_number,branch_id:branch_id},
				beforeSend:function(){					
					//$('#data-loading').html(data_loading);
				},
				success:function(data){
					//$('#data-loading').html('');
					$.ajax({
						url:"<?=base_url('assets/ajax/form_submit/member_type_package_chacker.php');?>",  
						method:"POST",  
						data:{card_number:card_number},
						success:function(data){
							if(data == 1){
								$('option[value="Due"]').css({"display":"none"});
							}else{
								$('option[value="Due"]').css({"display":"block"});
							}
						}
					})					
					$('#refreshment_iteam').html(data);  
				}  
			});
		//}
	})
})
</script>