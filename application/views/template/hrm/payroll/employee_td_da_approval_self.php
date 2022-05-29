<div class="content-wrapper">
	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-12">
					<div class="row">
						
						<div class="col-sm-4"></div>
						<div class="col-sm-4">
							<div class="card card-success" style="margin-top:15px;">
								<div class="card-header">
									Employee TA/DA Receive Aprove
								</div>
								<div class="card-body">
									<form action="<?php echo current_url(); ?>" method="POST">
										<input type="hidden" name="form_submit" value="1" />
										<?php if(!empty($amount)){ ?>
										<div class="form-group">
											<label>Allowed Amount</label>
											<input type="text" name="amount" value="<?php echo money($amount); ?>" class="form-control" readonly />
										</div>
										<?php } ?>
										<div class="form-group">
											<label>Note</label>
											<textarea name="note" class="form-control"></textarea>
										</div>
										<div class="form-group">
											<button type="submit" name="received" class="btn btn-success" style="width:100%;">Received</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>