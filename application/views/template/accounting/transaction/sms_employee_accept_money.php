<div class="content-wrapper">
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<div class="card card-success">
						<div class="card-header">
							SMS Confarmation
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12">
									<?php
										if(!empty($message)){ 
											if($message == '1'){
												echo '
													<span style="color:red;font-weight:bolder;text-align:center;">
														This Transaction Allready Accepted!
													</span>
												';
											}else if ($message == '2'){
												echo '
													<span style="color:red;font-weight:bolder;text-align:center;">
														Something wrong! Please tray again
													</span>
												';
											}else if($message == '3'){
												echo '
													<span style="color:green;font-weight:bolder;text-align:center;">
														Transaction Accepted Successfuly!
													</span>
												';
											}else if($message == '5'){
												echo '
													<span style="color:red;font-weight:bolder;text-align:center;">
														You are not Request form advance money!
													</span>
												';
											}else if($message == '4'){
									?>
									<form action="<?php echo current_url(); ?>" method="post">
										<div class="row">
											<div class="col-sm-12">
												<center>
													<button type="submit" name="accept_money" class="btn btn-success">Confirm Received!</button>
												</center>
											</div>
										</div>
									</form>
									<?php
											}
										}
									?>
								</div>
							</div>							
						</div>
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>