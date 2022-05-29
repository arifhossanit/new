<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>View Profile</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('ipo-member'); ?>">Home</a></li>
						<li class="breadcrumb-item active">View Profile</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3">
					<div class="card">
						<div class="card-body text-center" id="member_profile_result">
                        	<img class="img-circle img-bordered-sm" src="<?php if(!empty($ipo_member_information)){ echo base_url($ipo_member_information->personal_images); }else{ echo base_url('assets/img/photo_avatar.png'); } ?>" alt="user image" style="height: 120px;">
							<h4><?php echo $ipo_member_information->personal_full_name; ?></h4>
							<h6 class="text-muted"><?php echo $ipo_member_information->personal_email; ?></h6>
							<h6 class="text-muted"><?php echo $ipo_member_information->personal_phone_number; ?></h6>
						</div>
					</div>
					<div class="card card-primary">
						<div class="card-header">
							<p class="card-title">Personal Information</p>
						</div>
						<div class="card-body">
							<strong><i class="fas fa-address-card"></i> Address</strong>
							<p class="text-muted"><?php echo $ipo_member_information->personal_address; ?></p>
							<hr>
							<strong><i class="fas fa-id-card"></i> NID</strong>
							<p class="text-muted"><?php echo $ipo_member_information->personal_nid_card; ?> <span><a style="color: #000" target="_blank" href="<?php echo base_url($ipo_member_information->personal_nid_attachment); ?>"><i class="fas fa-eye"></i></a></span></p>
							<hr>
							<strong><i class="fas fa-birthday-cake"></i> Date of Birth</strong>
							<p class="text-muted"><?php echo $ipo_member_information->personal_date_of_birth; ?></p>
						</div>
					</div>
					<div class="card card-primary">
						<div class="card-header">
							<p class="card-title">Bank Information</p>
						</div>
						<div class="card-body" id="member_profile_result">
							<div class="row">
								<div class="col-md-12">
									<p>Bank Name : <span class="text-muted"><?php echo $ipo_member_information->bank_name; ?></span></p>
									<p>Branch : <span class="text-muted"><?php echo $ipo_member_information->bank_branch_name; ?></span></p>
									<p>Address : <span class="text-muted"><?php echo $ipo_member_information->bank_address; ?></span></p>
									<p>Account Holder Name : <span class="text-muted"><?php echo $ipo_member_information->account_holder_name; ?></span></p>
									<p>Account Number : <span class="text-muted"><?php echo $ipo_member_information->account_number; ?></span></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-8">
					<div class="card card-primary">
						<div class="card-header">
							<p class="card-title">Nominee Information</p>
						</div>
						<div class="card-body" id="member_profile_result">
							<div class="row">
								<div class="col-md-4">
									<img class="img-circle img-bordered-sm" src="<?php if(!empty($ipo_member_information)){ echo ($ipo_member_information->nominee_images != '') ? base_url($ipo_member_information->nominee_images): 'assets/img/photo_avatar.png'; }else{ echo base_url('assets/img/photo_avatar.png'); } ?>" alt="user image" style="height: 120px;">
								</div>
								<div class="col-md-4">
									<p>Name : <span class="text-muted"><?php echo $ipo_member_information->nominee_name; ?></span></p>
									<p>Phone: <span class="text-muted"><?php echo $ipo_member_information->nominee_phone_number; ?></p>
									<p>Email: <span class="text-muted"><?php echo $ipo_member_information->nominee_email; ?></p>
									<p>Address: <span class="text-muted"><?php echo $ipo_member_information->nominee_address; ?></p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<p>Relationship with Nominee : <span class="text-muted"><?php echo $ipo_member_information->nominee_relation; ?></span></p>
									<p>Nominee NID: <span class="text-muted"><?php echo $ipo_member_information->nominee_nid_card.' '; ?></span><span><a style="color: #000" target="_blank" href="<?php echo base_url($ipo_member_information->personal_nid_attachment); ?>"><i class="fas fa-eye"></i></a></span></p>
									<p>Date of Birth: <span class="text-muted"><?php echo $ipo_member_information->nominee_date_of_birth; ?></span></p>
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
	$(document).ready(function(){
		$('#my_profile').addClass('active');
		$('#view_profile').addClass('active');
	});
</script>