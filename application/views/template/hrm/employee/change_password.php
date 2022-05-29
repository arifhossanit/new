<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Change Password</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item active">Change Password</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-sm-4" style="padding-top:20px;"></div>			
				<div class="col-sm-4" style="padding-top:20px;">				
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Write Your Self</h3>
						</div>
						<div class="card-body">	
							<form action="<?php echo current_url(); ?>" method="post">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<input type="password" name="old_password" class="form-control" placeholder="Old Password" required />
											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
												<input type="password" name="new_password" minlength="8" maxlength="50" class="form-control" placeholder="New Password" required />
											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
												<input type="password" name="confirm_password" minlength="8" maxlength="50" class="form-control" placeholder="Confirm Password" required />
											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
												<button type="submit" name="change_password" class="btn btn-success" style="float:right;"><i class="fas fa-key"></i> Change Password</button>
											</div>
										</div>
									</div>
								</div>
							</form>		
						</div>
					</div>			
				</div>
			</div>
			
		</div>
	</div>
</div>
