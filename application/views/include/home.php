<div class="content-wrapper wrappersdf">		   
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<center><h1 style="margin-top:30px;">Welcome to <span style="color:#203399;font-weight:bolder;"><i>N<span style="color:#f00;">e</span>ways</i></span> Family</h1></center>
					<center>Welcome back, <b><?php echo $_SESSION['user_info']['user']; ?></b></center>					
					<center style="margin-top:10px;">
						<abbr title="Result Depends on Package Values">
							<button onclick="return package_valuefunction()" class="btn btn-info" type="button">
								<i class="fas fa-info-circle"></i>
							</button>							
						</abbr>						
						<button onclick="return branch_scealing()" class="btn btn-danger" type="button">
							<i class="fas fa-building"></i>&nbsp;&nbsp;
							Service Rate
						</button>
					</center>					
				</div>
				<?php if(check_permission('role_1617450261_65')){ ?>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-4"></div>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-4">&nbsp;</div>
								<div class="col-sm-4">
									<div class="form-group" style="margin-top:10px;">
										<input id="home_date_selector" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" type="date" name="change_date" class="form-control"/>
									</div>
								</div>
								<div class="col-sm-4">&nbsp;</div>
							</div>
						</div>
						<div class="col-sm-4"></div>
					</div>
				</div>
				<?php } ?>
				<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin' ){ ?>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-3"></div>
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-6">
											<button id="award_winner" onclick="return award_winner()" type="button" class="btn btn-success" style="width:100%;">Award Winner</button>
										</div>
										<div class="col-sm-6">
											<button id="challange_comparison" onclick="return challange_comparison()" type="button" class="btn btn-info" style="width:100%;">Challenge Comparison</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<div class="col-sm-3" id="left_side_best_saler_images" style="padding-bottom:50px;" ></div>
				<div class="col-sm-6" id="best_saler_images" style="padding-bottom:50px;"></div>
				<div class="col-sm-3" id="right_side_best_saler_images" style="padding-bottom:50px;" ></div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="package_value_model">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Result Depends on Package Values</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="package_value_model_result"></div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="branch_scealing_modal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-danger">
						<h4 class="modal-title">Branch Overall Service Rate</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="branch_scealing_result"></div>
				</form>
			</div>
		</div>
	</div>

</div>
<script>
function award_winner(){
	var date = $("#home_date_selector").val();
	var get_details = '1';
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/home_best_seller.php');?>",  
		method:"POST",
		data:{
			get_details:get_details,
			date_filter:date
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');	
			$('#best_saler_images').html(data);
			$('#award_winner').html('Award Winner <span style="width:10px;height:10px;background-color:#f00;border-radius:10px;display: inline-block;"></span>');
			$('#challange_comparison').html('Challenge Comparison');
		}  
	});
}
function challange_comparison(){
	var date = $("#home_date_selector").val();
	var get_details = '1';
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/home_best_seller_comparison.php');?>",  
		method:"POST",
		data:{
			get_details:get_details,
			date_filter:date
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');	
			$('#best_saler_images').html(data);
			$('#challange_comparison').html('Challenge Comparison <span style="width:10px;height:10px;background-color:#f00;border-radius:10px;display: inline-block;"></span>');
			$('#award_winner').html('Award Winner');
		}  
	});
}
$('document').ready(function(){
	$("#home_date_selector").on("change",function(){
		var date = $(this).val();
		var get_details = '1';
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/left_side_home_best_seller.php');?>",  
			method:"POST",
			data:{
				get_details:get_details,
				date_filter:date
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('#left_side_best_saler_images').html(data);
			}  
		}); 
		
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/home_best_seller.php');?>",  
			method:"POST",
			data:{
				get_details:get_details,
				date_filter:date
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('#best_saler_images').html(data);
				$('#award_winner').html('Award Winner <span style="width:10px;height:10px;background-color:#f00;border-radius:10px;display: inline-block;"></span>');
				$('#challange_comparison').html('Challenge Comparison');
			}  
		});
		
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/right_side_home_best_seller.php');?>",  
			method:"POST",
			data:{
				get_details:get_details,
				date_filter:date
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('#right_side_best_saler_images').html(data);
			}  
		});		
	})
})
function package_valuefunction(){
	var package_info = 1;
	if( package_info != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/package_valuefunction.php');?>",  
			method:"POST",
			data:{ package_info:package_info },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('#package_value_model').modal('show');
				$('#package_value_model_result').html(data);
			}  
		});  
	}	
}
function branch_scealing(){
	var branch_info = 1;
	if( branch_info != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/branch_scealing.php');?>",  
			method:"POST",
			data:{ branch_info:branch_info },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('#branch_scealing_modal').modal('show');
				$('#branch_scealing_result').html(data);
			}  
		});  
	}	
}
$(document).ready(function(){
	var get_details = '1';
	//left side
	if( get_details != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/left_side_home_best_seller.php');?>",  
			method:"POST",
			data:{ get_details:get_details },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('#left_side_best_saler_images').html(data);
			}  
		});  
	}
	//right side
	if( get_details != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/right_side_home_best_seller.php');?>",  
			method:"POST",
			data:{ get_details:get_details },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('#right_side_best_saler_images').html(data);
			}  
		});  
	}
	
	
	<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin' ){ ?>
	var date = $("#home_date_selector").val();
	var get_details = '1';
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/home_best_seller_comparison.php');?>",  
		method:"POST",
		data:{
			get_details:get_details,
			date_filter:date
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');	
			$('#best_saler_images').html(data);
			$('#challange_comparison').html('Challenge Comparison <span style="width:10px;height:10px;background-color:#f00;border-radius:10px;display: inline-block;"></span>');
			$('#award_winner').html('Award Winner');
		}  
	});
	
	
	<?php } else { ?>
	if( get_details != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/home_best_seller.php');?>",  
			method:"POST",
			data:{ get_details:get_details },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');	
				$('#best_saler_images').html(data);
				$('#award_winner').html('Award Winner <span style="width:10px;height:10px;background-color:#f00;border-radius:10px;display: inline-block;"></span>');
				$('#challange_comparison').html('Challenge Comparison');
			}  
		});  
	}
	<?php } ?>
})
</script>
<style>
.dimond_seller {
  --angle: 0deg;
  border-image: conic-gradient(from var(--angle), red, yellow, lime, aqua, blue, magenta, red) 1;

  animation: 10s rotate linear infinite;
}

@keyframes rotate {
  to {
    --angle: 360deg;
  }
}

@property --angle {
  syntax: '<angle>';
  initial-value: 0deg;
  inherits: false;
}


.wrappersdf{
	background: #50a3a2;
background: -webkit-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
background: -moz-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
background: -o-linear-gradient(top left, #50a3a2 0%, #53e3a6 100%);
background: linear-gradient(to bottom right, #50a3a2 0%, #53e3a6 100%);
}
html{
	/*overflow:hidden;*/
}
</style>