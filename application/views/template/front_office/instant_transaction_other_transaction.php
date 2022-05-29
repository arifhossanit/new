<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Instant Transaction (Other Trasaction)</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?= base_url(); ?>">Front Office</a></li>
						<li class="breadcrumb-item active">Instant Transaction (Other Trasaction)</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Instant Transaction (Other Trasaction)</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<Label>Trasaction ID</Label>
												<input type="text" class="form-control" name="trasaction_id">
											</div>
										
											<div>
												<div class="form-group"> <Label>Person</Label>
													<select name="Person" class="form-control" id="">
														<option value="">Person Search</option>
														<option value="">2</option>
														<option value="">3</option>
													</select>
												</div>
											</div>
											
											<div class="form-group"> <Label>Account Type</Label>
												<select name="Person" class="form-control"  id="">
													<option value="">Expenses</option>
													<option value="">Income</option>
													<option value="">Assets</option>
													<option value="">liabilities</option>
												</select>
											</div>
											
											<div>
												<div class="form-group">
													<Label>Amount</Label>
													<input type="text" class="form-control" name="amount">
												</div>
											</div>
											<br>
											<div>
												<div class="form-group"> <Label>Transaction Type</Label>
													<select name="Person" class="form-control" id="">
														<option value="">Credit</option>
														<option value="">Debit</option>
													</select>
												</div>
											</div>
											<br>
											<div>
												<div class="form-group"> <Label>Trasaction Method</Label>
													<select name="Person" class="form-control" id="">
														<option value="">Cash</option>
														<option value="">Mobile Banking</option>
														<option value="">Cheque</option>
													</select>
												</div>
											</div>

										</div>
										<div class="col-sm-6">
											<div>
												<div class="form-group">
													<Label>C/O</Label>
													<input type="text" class="form-control" name="c/o">
												</div>
											</div>
											<br>
											<div>
												<div class="form-group"> <Label>Account</Label>
													<select name="" class="form-control" id="">
														<option value="">Selected (Expenses)</option>
														<option value="">------------</option>
														<option value="">----------</option>
													</select>
												</div>
											</div>
											<br>
											<div>
												<form action=">
													<label for="">Date</label>
													<input type="date" class="form-control" id="" name="">
												</form>
											</div>
											<br>
											<br>
											<div>
												<div class="form-group">
													<Label>Note</Label>
													<input type="text" class="form-control" name="Note">
												</div>
											</div>
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
<script>


</script>