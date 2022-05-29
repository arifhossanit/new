<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Send SMS</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url('admin');?>">Home</a></li>
              <li class="breadcrumb-item active">Send SMS (Short Message Service)</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	

	<div class="content">
		<div class="container-flud">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<div class="card card-primary card-outline">
						  <div class="card-header">
							<h3 class="card-title"> Input Send SMS Information </h3>
						  </div>
						  <div class="card-body">
							<h4><i class="fas fa-edit"></i> Send SMS AS</h4>
							<div class="row">
								<div class="col-5 col-sm-3">
									<div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
										<a class="nav-link active" id="vert-tabs-Custom-SMS-tab" data-toggle="pill" href="#vert-tabs-Custom-SMS" role="tab" aria-controls="vert-tabs-Custom-SMS" aria-selected="true">Custom SMS</a>
										<a class="nav-link" id="vert-tabs-Group-SMS-tab" data-toggle="pill" href="#vert-tabs-Group-SMS" role="tab" aria-controls="vert-tabs-Group-SMS" aria-selected="false">Group SMS</a>
										<a class="nav-link" id="vert-tabs-Individual-SMS-tab" data-toggle="pill" href="#vert-tabs-Individual-SMS" role="tab" aria-controls="vert-tabs-Individual-SMS" aria-selected="false">Individual SMS</a>
										<a class="nav-link" id="vert-tabs-Member-SMS-tab" data-toggle="pill" href="#vert-tabs-Member-SMS" role="tab" aria-controls="vert-tabs-Member-SMS" aria-selected="false">Member SMS</a>
									</div>
								</div>
								<div class="col-7 col-sm-9">
									<div class="tab-content" id="vert-tabs-tabContent">
										<div class="tab-pane text-left fade show active" id="vert-tabs-Custom-SMS" role="tabpanel" aria-labelledby="vert-tabs-Custom-SMS-tab">
											<div class="row">
												<div class="col-sm-12">
													<div class="card card-primary">
														<div class="card-header">
															<h3 class="card-title">Custom SMS Sending</h3>
														</div>
														<form role="form" action="<?php echo current_url(); ?>" method="post">
															<input type="hidden" name="branch_id" value="<?php echo $_SESSION['super_admin']['branch']; ?>"/>
															<div class="card-body">
																<div class="row">
																	<div class="col-sm-12">
																		<div class="form-group">
																			<label>Input Correct Numbers <abbr title="Use ',' Comma end of each mobile number, No space & other character required." style="color:#f00;"><i class="far fa-question-circle"></i><abbr></label>
																			<textarea name="numbers" class="form-control" required></textarea>
																		</div>
																	</div>
																	<div class="col-sm-12">
																		<div class="form-group">
																			<label>Message Body <span id="character_counter_show" style="color:#f00;"></span></label>
																			<textarea name="massage_body" id="massage_body" class="form-control" style="height:200px;" required></textarea>
																		</div>
																	</div>
																	<div class="col-sm-12">
																		<div class="form-group">
																			<label>Note</label>
																			<textarea name="note" class="form-control"></textarea>
																		</div>
																	</div>
																</div>
															</div>
															<div class="card-footer">
																<div class="row">
																	<div class="col-sm-12">
																		<button name="send_sms_custom" type="submit" class="btn btn-success" style="float:right;"><i class="fas fa-sms"></i> &nbsp;Send SMS</button>
																	</div>
																</div>															  
															</div>
													  </form>
													</div>
												</div>
											</div>
										</div>
										<div class="tab-pane fade" id="vert-tabs-Group-SMS" role="tabpanel" aria-labelledby="vert-tabs-Group-SMS-tab">
											Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Ma
											uris pharetra purus ut ligula tempor, et vulputate metus facilisis
											. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestib
											ulum ante ipsum primis in faucibus orci luctus et ultrices posu
											ere cubilia Curae; Maecenas sollicitudin, nisi a luctus int
											erdum, nisl ligula placerat mi, quis posuere purus ligula e
											u lectus. Donec nunc tellus, elementum sit amet ultricies a
											t, posuere nec nunc. Nunc euismod pellentesque diam. 
										</div>
										<div class="tab-pane fade" id="vert-tabs-Individual-SMS" role="tabpanel" aria-labelledby="vert-tabs-Individual-SMS-tab">
											Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mau
											ris. Phasellus volutpat augue id mi placerat mollis. Vivamus faucib
											us eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique
											nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendi
											sse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur el
											eifend facilisis velit finibus tristique. Nam vulputate, eros non l
											uctus efficitur, ipsum odio volutpat massa, sit amet sollicitudin 
											est libero sed ipsum. Nulla lacinia, ex vitae gravida fermentum, le
											ctus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabi
											tur eget sem eu risus tincidunt eleifend ac ornare magna. 
										</div>
										<div class="tab-pane fade" id="vert-tabs-Member-SMS" role="tabpanel" aria-labelledby="vert-tabs-Member-SMS-tab">
											Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque m
											agna, iaculis tempus turpis ac, ornare sodales tellus. Mauris eg
											et blandit dolor. Quisque tincidunt venenatis vulputate. Morbi 
											euismod molestie tristique. Vestibulum consectetur dolor a vest
											ibulum pharetra. Donec interdum placerat urna nec pharetra. Etia
											m eget dapibus orci, eget aliquet urna. Nunc at consequat diam. 
											Nunc et felis ut nisl commodo dignissim. In hac habitasse platea
											dictumst. Praesent imperdiet accumsan ex sit amet facilisis. 
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
</div>
<script>
$(document).ready(function(){
	$("#massage_body").on("keyup keydown",function(){
		$("#character_counter_show").html(countChar($("#massage_body").val()));
	})
})
function countChar(val) {
    var len = val.length;
	var result = parseFloat(len) / 160;
    return 'SMS (' + parseFloat(result).toFixed(2)+')';
}
</script>