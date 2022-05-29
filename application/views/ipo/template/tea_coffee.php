<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Tea / Coffee</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('member'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Tea / Coffee</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
<?php if(!empty($page_view)){ 
		if($page_view == 'scan'){ ?>
					<div class="card card-warning">
						<div class="card-header">
							<h3 class="card-title">Warning</h3>
						</div>
						<form action="<?=current_url(); ?>" method="post">
							<div class="card-body">
								<h4>Please Scane The QR CODE Belong coffee Matchine</h4>
							</div>
						</form>
					</div>
<?php }else if($page_view == 'no_branch_member'){ ?>
					<div class="card card-danger">
						<div class="card-header">
							<h3 class="card-title">Danger</h3>
						</div>
						<form action="<?=current_url(); ?>" method="post">
							<div class="card-body">
								<h4>You are not a verified Member in this branch, Try it another branch</h4>
							</div>
						</form>
					</div>
<?php }else if($page_view == 'verified'){ ?>
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Scan Success</h3>
						</div>
						<form action="<?=current_url(); ?>" method="post">
							<div class="card-body">
								<div class="row">
									<div class="col-sm-12">
										<h5 style="text-align:center;">Click the button which you want to take!</h5>
										<div class="row">
											<div class="col-sm-4"></div>
											<div class="col-sm-4">
												<div class="row">
													<div class="col-sm-6">
														<button name="tea" type="submit" class="btn btn-success btn-lg" style="width:100%;">TEA</button>
													</div>
													<div class="col-sm-6">
														<button name="coffee" type="submit" class="btn btn-success btn-lg" style="width:100%;">COFFEE</button>
													</div>
												</div>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
<?php } } ?>
					
				</div>
			</div>
		</div>
	</div>
</div>