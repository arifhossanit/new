<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Change Password</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('member'); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">My Profile</a></li>
						<li class="breadcrumb-item active">Change Password</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Change Password</h3>
						</div>
						<form action="<?=current_url(); ?>" method="post">
							<div class="card-body">
								<div class="form-group">
									<label>Old Password</label>
									<input name="old_password" type="password" class="form-control" placeholder="Old Password" required/>
								</div>
								<div class="form-group">
									<label>New Password</label>
									<input name="new_password" type="password" class="form-control" placeholder="New Password" required/>
								</div>
								<div class="form-group">
									<label>Confirm Password</label>
									<input name="confirm_password" type="password" class="form-control" placeholder="Confirm Password" required/>
								</div>
							</div>
							<div class="card-footer">
								<button name="change_password" type="submit" class="btn btn-primary" style="float:right;">Change Password</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>