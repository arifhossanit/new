<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['ipo_member_view_id'])){ 
	$_MEMBER_INFO = mysqli_fetch_assoc($mysqli->query("SELECT * FROM ipo_member_directory WHERE id = '".$_POST['ipo_member_view_id']."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<div class="card card-primary card-outline card-tabs">
			<div class="card-header p-0 pt-1 border-bottom-0">
				<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="true">PROFILE</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-three-agreement-tab" data-toggle="pill" href="#custom-tabs-three-agreement" role="tab" aria-controls="custom-tabs-three-agreement" aria-selected="false">AGREEMENT</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-three-widthdraw_payment-tab" data-toggle="pill" href="#custom-tabs-three-widthdraw_payment" role="tab" aria-controls="custom-tabs-three-widthdraw_payment" aria-selected="false">WIDTHDRAW PAYMENT</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> More </a>
						<div class="custom-color dropdown-menu" aria-labelledby="navbarDropdown" style="left: 0px; right: inherit;width: 200px;padding:0px;">
							<a class="nav-link" id="custom-tabs-three-daily_payment-tab" data-toggle="pill" href="#custom-tabs-three-daily_payment" role="tab" aria-controls="custom-tabs-three-daily_payment" aria-selected="false">DAILY PAYMENT INFO</a>
							<a class="nav-link" id="custom-tabs-three-investmennt_payment-tab" data-toggle="pill" href="#custom-tabs-three-investmennt_payment" role="tab" aria-controls="custom-tabs-three-investmennt_payment" aria-selected="false">INVESTMENT PAYMENT</a>
							<a class="nav-link" id="custom-tabs-three-referal_payment-tab" data-toggle="pill" href="#custom-tabs-three-referal_payment" role="tab" aria-controls="custom-tabs-three-referal_payment" aria-selected="false">REFERAL PAYMENT</a>
							<a class="nav-link" id="custom-tabs-three-widthdraw_request-tab" data-toggle="pill" href="#custom-tabs-three-widthdraw_request" role="tab" aria-controls="custom-tabs-three-widthdraw_request" aria-selected="false">WIDTHDRAW REQUEST</a>
						</div>
					</li>
                </ul>
             </div>
             <div class="card-body">
				<div class="tab-content" id="custom-tabs-three-tabContent">
					<div class="tab-pane fade show active" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
						<?php include("profile/profile.php"); ?>
					</div>
					<div class="tab-pane fade" id="custom-tabs-three-agreement" role="tabpanel" aria-labelledby="custom-tabs-three-agreement-tab">
						<?php include("profile/agreement.php"); ?>
					</div>
					<div class="tab-pane fade" id="custom-tabs-three-daily_payment" role="tabpanel" aria-labelledby="custom-tabs-three-daily_payment-tab">
						<?php include("profile/daily_payment.php"); ?>
					</div>
					<div class="tab-pane fade" id="custom-tabs-three-investmennt_payment" role="tabpanel" aria-labelledby="custom-tabs-three-investmennt_payment-tab">
						<?php include("profile/investmennt_payment.php"); ?>
					</div>
					<div class="tab-pane fade" id="custom-tabs-three-referal_payment" role="tabpanel" aria-labelledby="custom-tabs-three-referal_payment-tab">
						<?php include("profile/referal_payment.php"); ?>
					</div>
					<div class="tab-pane fade" id="custom-tabs-three-widthdraw_request" role="tabpanel" aria-labelledby="custom-tabs-three-widthdraw_request-tab">
						<?php include("profile/widthdraw_request.php"); ?>
					</div>
					<div class="tab-pane fade" id="custom-tabs-three-widthdraw_payment" role="tabpanel" aria-labelledby="custom-tabs-three-widthdraw_payment-tab">
						<?php include("profile/widthdraw_payment.php"); ?>
					</div>
                </div>
              </div>
              <!-- /.card -->
            </div>
	</div>
</div>
<?php	
}

if(isset($_POST['ipo_db_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("SELECT * FROM ipo_member_directory WHERE id = '".$_POST['ipo_db_id']."'"));
?>
<input type="hidden" name="ipo_member_edit_token" value="<?php echo $row['id']; ?>"/>
<div class="row">
	<div class="col-sm-12">
		<h5 style="text-decoration:underline;">Personal Information</h5>
	</div>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label>Full Name</label>
					<input name="personal_full_name" value="<?php if(!empty($row['personal_full_name'])){ echo $row['personal_full_name']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			
			<div class="col-sm-3">
				<div class="form-group">
					<label>Phone Number</label>
					<input name="personal_phone_number" value="<?php if(!empty($row['personal_phone_number'])){ echo $row['personal_phone_number']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			
			<div class="col-sm-3">
				<div class="form-group">
					<label>Date of Birth<small>(mm/dd/yyyy)</small></label>
					<input name="personal_date_of_birth" value="<?php if(!empty($row['personal_date_of_birth'])){ $d = explode('/',$row['personal_date_of_birth']); echo $d[2].'-'.$d[1].'-'.$d[0]; } ?>" type="date" class="form-control" required />
				</div>
			</div>
			
			<div class="col-sm-3">
				<div class="form-group">
					<label>Email</label>
					<input name="personal_email" value="<?php if(!empty($row['personal_email'])){ echo $row['personal_email']; } ?>" type="email" class="form-control" required />
				</div>
			</div>
			
			<div class="col-sm-3">
				<div class="form-group">
					<label>NID</label>
					<input name="personal_nid_card" value="<?php if(!empty($row['personal_nid_card'])){ echo $row['personal_nid_card']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			
			<div class="col-sm-9">
				<div class="form-group">
					<label>Address</label>
					<input name="personal_address" value="<?php if(!empty($row['personal_address'])){ echo $row['personal_address']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-9">
				<ul>
					<?php if(!empty($row['personal_nid_attachment'])){ ?>
						<li><a href="<?php echo $home.$row['personal_nid_attachment']; ?>" target="_blank" title="Click to view Member NID Card">Member NID Card</a></li>
					<?php } ?>
					<?php if(!empty($row['personal_images'])){ ?>
						<li><a href="<?php echo $home.$row['personal_images']; ?>" target="_blank" title="Click to view Member Image">Member Image</a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Nid Attachment</label>
					<input name="personal_nid_attachment" type="file" class="form-control" style="padding-top:3px;" <?php if(!empty($row['personal_nid_attachment'])){ }else{ echo 'required'; } ?> />
				</div>
				<div class="form-group">
					<label>Member Image</label>
					<input name="personal_images" type="file" class="form-control" style="padding-top:3px;" <?php if(!empty($row['personal_images'])){ }else{ echo 'required'; } ?> />
				</div>
			</div>
		</div>		
	</div>
	<div class="col-sm-12">
		<h5 style="text-decoration:underline;">Bank Information</h5>
	</div>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label>Bank name</label>
					<input name="bank_name" value="<?php if(!empty($row['bank_name'])){ echo $row['bank_name']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Account Holder name</label>
					<input name="account_holder_name" value="<?php if(!empty($row['account_holder_name'])){ echo $row['account_holder_name']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Account Number</label>
					<input name="account_number" value="<?php if(!empty($row['account_number'])){ echo $row['account_number']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Routing Number</label>
					<input name="routing_number" value="<?php if(!empty($row['routing_number'])){ echo $row['routing_number']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Branch name</label>
					<input name="bank_branch_name" value="<?php if(!empty($row['bank_branch_name'])){ echo $row['bank_branch_name']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-9">
				<div class="form-group">
					<label>Address</label>
					<input name="bank_address" value="<?php if(!empty($row['bank_address'])){ echo $row['bank_address']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-9">
				<ul>
					<?php 
						if(!empty($row['bank_attachment'])){ 
							$data = explode(",",$row['bank_attachment']); $i = 1; 
							foreach($data as $arow){							
					?>						
						<li><a href="<?php echo $home.$arow; ?>" target="_blank" title="Click to view">Bank Attachment <?php echo $i++; ?></a></li>
					<?php } } ?>
				</ul>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Bank Attachment</label>
					<input name="bank_attachment[]" type="file" multiple class="form-control" style="padding-top:3px;" <?php if(!empty($row['bank_attachment'])){ }else{ echo 'required'; } ?> />
				</div>
			</div>
		</div>		
	</div>
	<div class="col-sm-12">
		<h5 style="text-decoration:underline;">Nominee Information</h5>
	</div>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label>Nominee name</label>
					<input name="nominee_name" value="<?php if(!empty($row['nominee_name'])){ echo $row['nominee_name']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Phone Number</label>
					<input name="nominee_phone_number" value="<?php if(!empty($row['nominee_phone_number'])){ echo $row['nominee_phone_number']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Date of Birth<small>(mm/dd/yyyy)</small></label>
					<input name="nominee_date_of_birth" value="<?php if(!empty($row['nominee_date_of_birth'])){ $d = explode('/',$row['nominee_date_of_birth']); echo $d[2].'-'.$d[1].'-'.$d[0]; } ?>" type="date" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Email</label>
					<input name="nominee_email" value="<?php if(!empty($row['nominee_email'])){ echo $row['nominee_email']; } ?>" type="email" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>NID</label>
					<input name="nominee_nid_card" value="<?php if(!empty($row['nominee_nid_card'])){ echo $row['nominee_nid_card']; } ?>" type="text" class="form-control" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Relation</label>
					<select name="nominee_relation" class="form-control select2" required>
						<?php if(!empty($row['nominee_relation'])){ echo '<option>'.$row['nominee_relation'].'</option>'; }else{ ?><option value="">select</option><?php } ?>
						<option value="Father">Father</option>
						<option value="Mother">Mother</option>
						<option value="Brother">Brother</option>
						<option value="Sister">Sister</option>
						<option value="Cousin">Cousin</option>
						<option value="Friends">Friends</option>
						<option value="Husband">Husband</option>
						<option value="Wife">Wife</option>
						<option value="Uncle">Uncle</option>
						<option value="Aunti">Aunti</option>
						<option value="Daughter">Daughter</option>
						<option value="Son">Son</option>
						<option value="Other">Other</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Address</label>
					<input name="nominee_address" value="<?php if(!empty($row['nominee_address'])){ echo $row['nominee_address']; } ?>" type="text" class="form-control" required />
				</div>
			</div>			
		</div>
		<div class="row">
			<div class="col-sm-9">
				<ul>
					<?php if(!empty($row['nominee_nid_attachment'])){ ?>
						<li><a href="<?php echo $home.$row['nominee_nid_attachment']; ?>" target="_blank" title="Click to view Nominee NID Card">Nominee NID Card</a></li>
					<?php } ?>
					<?php if(!empty($row['nominee_images'])){ ?>
						<li><a href="<?php echo $home.$row['nominee_images']; ?>" target="_blank" title="Click to view Nominee Image">Nominee Image</a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>NID Attachment</label>
					<input name="nominee_nid_attachment" type="file" class="form-control" style="padding-top:3px;" <?php if(!empty($row['nominee_nid_attachment'])){ }else{ echo 'required'; } ?> />
				</div>
				<div class="form-group">
					<label>Nominee Image</label>
					<input name="nominee_images" type="file" class="form-control" style="padding-top:3px;" <?php if(!empty($row['nominee_images'])){ }else{ echo 'required'; } ?> />
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-12">
		<h5 style="text-decoration:underline;">Agreement Attachment</h5>
	</div>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-9">
				<ul>
					<?php 
						if(!empty($row['ipo_attachment'])){ 
							$data = explode(",",$row['ipo_attachment']); $i = 1; 
							foreach($data as $arow){							
					?>						
						<li><a href="<?php echo $home.$arow; ?>" target="_blank" title="Click to view">Attachment <?php echo $i++; ?></a></li>
					<?php } } ?>
				</ul>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label>Agreement Attachment</label>
					<input name="ipo_attachment[]" multiple type="file" class="form-control" style="padding-top:3px;" <?php if(!empty($row['ipo_attachment'])){ }else{ echo 'required'; } ?> />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label>Note</label>
					<textarea name="note" class="form-control"><?php if(!empty($row['note'])){ echo $row['note']; } ?></textarea>
				</div>
			</div>
		</div>
	</div>	
</div>
<?php
}
if(isset($_POST['ipo_member_edit_token'])){
	$row = mysqli_fetch_assoc($mysqli->query("SELECT * FROM ipo_member_directory WHERE id = '".$_POST['ipo_member_edit_token']."'"));
	if($_FILES['nominee_nid_attachment']['name'] != ''){
		$nominee_nid_attachment = ipo_image_and_file_upload('nominee_nid_attachment','ipo_nominee_document');
	}else{
		$nominee_nid_attachment = $row['nominee_nid_attachment'];
	}	
	if($_FILES['nominee_images']['name'] != ''){
		$nominee_images = ipo_image_and_file_upload('nominee_images','ipo_nominee_document');
	}else{
		$nominee_images = $row['nominee_images'];
	}	
	if($_FILES['personal_nid_attachment']['name'] != ''){
		$personal_nid_attachment = ipo_image_and_file_upload('personal_nid_attachment','ipo_personal_document');
	}else{
		$personal_nid_attachment = $row['personal_nid_attachment'];
	}	
	if($_FILES['personal_images']['name'] != ''){
		$personal_images = ipo_image_and_file_upload('personal_images','ipo_personal_document');
	}else{
		$personal_images = $row['personal_images'];
	}
	
	if($_FILES['bank_attachment']['name'][0] != ''){
		$bank_attachment_var = '';
		foreach($_FILES['bank_attachment']['name'] as $k => $v ){
			$bank_attachment_var .= ipo_image_and_file_upload_multiple($_FILES['bank_attachment']['name'][$k], $_FILES['bank_attachment']['tmp_name'][$k], 'ipo_bank_document').',';
		}
		$bank_attachment = rtrim($bank_attachment_var,',');
	}else{
		$bank_attachment = $row['bank_attachment'];
	}
	
	if($_FILES['ipo_attachment']['name'][0] != ''){
		$ipo_attachment_var = '';
		foreach($_FILES['ipo_attachment']['name'] as $k => $v ){
			$ipo_attachment_var .= ipo_image_and_file_upload_multiple($_FILES['ipo_attachment']['name'][$k], $_FILES['ipo_attachment']['tmp_name'][$k], 'ipo_document').',';
		}		
		$ipo_attachment = rtrim($ipo_attachment_var,',');
	}else{
		$ipo_attachment = $row['ipo_attachment'];
	}
	
	
	
	if($mysqli->query("UPDATE ipo_member_directory SET
		personal_full_name 			= '".$mysqli->real_escape_string($_POST['personal_full_name'])."',
		personal_phone_number 		= '".$mysqli->real_escape_string($_POST['personal_phone_number'])."',
		personal_date_of_birth 		= '".$mysqli->real_escape_string(date_converter($_POST['personal_date_of_birth']))."',
		personal_email 				= '".$mysqli->real_escape_string($_POST['personal_email'])."',
		personal_nid_card 			= '".$mysqli->real_escape_string($_POST['personal_nid_card'])."',
		personal_address 			= '".$mysqli->real_escape_string($_POST['personal_address'])."',
		personal_nid_attachment 	= '".$mysqli->real_escape_string($personal_nid_attachment)."',
		personal_images 			= '".$mysqli->real_escape_string($personal_images)."',
		bank_name 					= '".$mysqli->real_escape_string($_POST['bank_name'])."',
		account_holder_name 		= '".$mysqli->real_escape_string($_POST['account_holder_name'])."',
		account_number 				= '".$mysqli->real_escape_string($_POST['account_number'])."',
		routing_number 				= '".$mysqli->real_escape_string($_POST['routing_number'])."',
		bank_branch_name 			= '".$mysqli->real_escape_string($_POST['bank_branch_name'])."',
		bank_address 				= '".$mysqli->real_escape_string($_POST['bank_address'])."',
		bank_attachment 			= '".$mysqli->real_escape_string($bank_attachment)."',
		nominee_name 				= '".$mysqli->real_escape_string($_POST['nominee_name'])."',
		nominee_phone_number 		= '".$mysqli->real_escape_string($_POST['nominee_phone_number'])."',
		nominee_date_of_birth 		= '".$mysqli->real_escape_string(date_converter($_POST['nominee_date_of_birth']))."',
		nominee_email 				= '".$mysqli->real_escape_string($_POST['nominee_email'])."',
		nominee_nid_card 			= '".$mysqli->real_escape_string($_POST['nominee_nid_card'])."',
		nominee_relation 			= '".$mysqli->real_escape_string($_POST['nominee_relation'])."',
		nominee_address 			= '".$mysqli->real_escape_string($_POST['nominee_address'])."',
		nominee_nid_attachment 		= '".$mysqli->real_escape_string($nominee_nid_attachment)."',
		nominee_images 				= '".$mysqli->real_escape_string($nominee_images)."',
		ipo_attachment 				= '".$mysqli->real_escape_string($ipo_attachment)."',
		note 						= '".$mysqli->real_escape_string($_POST['note'])."'
		WHERE id 					= '".$row['id']."'
	")){
		echo 'Information Updated Successfuly!';
	}else{
		echo 'Something Wrong! Please Try again';
	}
}
?>
