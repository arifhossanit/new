<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Get A Free Award</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url('member'); ?>">Home</a></li>
						<li class="breadcrumb-item active">Get A Free Award</li>
					</ol>
				</div>
			</div>
		</div>
    </section>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-4">
					<form id="" method="post">
						<div class="card card-success">
							<div class="card-header">
								<h4>Request Submit</h4>
							</div>
							<div class="card-body">
								<div class="row">
									
								</div>
							</div>
						</div>						
					</form>
				</div>
				<div class="col-sm-8">
					<div class="card card-info">
						<div class="card-header">
							<h4>Request Log</h4>
						</div>
						<div class="card-bady">
						
						</div>
					</div>
				</div>
			</div>				
		</div>
	</div>
	
</div>
<script>
function member_withdraw_modal(id){
	if(confirm('Are You Confirm to withdraw Request Cancel?')){
		var book_id = id;
		if(book_id != ''){
			$.ajax({  
				url:"<?=base_url('assets/ajax/form_submit/request_for_withdraw_submit.php');?>",  
				method:"POST",  
				data:{ member_id:book_id },
				beforeSend:function(){					
					$('#data-loading').html(data_loading);					 
				},
				success:function(data){	
					$('#data-loading').html('');
					alert(data);
					window.open('<?=base_url()."member"; ?>','_self');
				}  
			});
		}
	}
}
</script>