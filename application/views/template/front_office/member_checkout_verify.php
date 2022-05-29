<div class="content-wrapper">	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary" style="margin-top:50px;">
					<div class="card-header">
						<h3 class="card-title">Please Rate your feeling about Super Home</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/fform-data">
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-sm table-bordered" style="text-align:center;color:#ffc107;">
										<thead style="color:#333 !important;font-weight:bolder;">
											<tr>
												<td>Mark</td>
												<td>Star</td>
											</tr>
										</thead>
										<tbody>										
											<tr>
												<td><input type="radio" name="value" value="5" id="sat_5" style="transform: scale(1.8);" required /></td>
												<td>
													<label for="sat_5">
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
													<label>
												</td>
											</tr>
											<tr>
												<td><input type="radio" name="value" value="4" id="sat_4" style="transform: scale(1.8);" required /></td>
												<td>
													<label for="sat_4">
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
													<label>
												</td>
											</tr>
											<tr>
												<td><input type="radio" name="value" value="3" id="sat_3" style="transform: scale(1.8);" required /></td>
												<td>
													<label for="sat_3">
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
													<label>
												</td>
											</tr>
											<tr>
												<td><input type="radio" name="value" value="2" id="sat_2" style="transform: scale(1.8);" required /></td>
												<td>
													<label for="sat_2">
														<i class="fas fa-star"></i>
														<i class="fas fa-star"></i>
													<label>
												</td>
											</tr>
											<tr>
												<td><input type="radio" name="value" value="1" id="sat_1" style="transform: scale(1.8);" required /></td>
												<td>
													<label for="sat_1">
														<i class="fas fa-star"></i>
													<label>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>	
							<div class="form-group">
								<button type="submit" name="confirm_checkout" class="btn btn-lg btn-success" style="width:100% !important;">
									<i class="fas fa-door-open"></i> &nbsp;&nbsp;&nbsp;
									Confirm Checkout
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>