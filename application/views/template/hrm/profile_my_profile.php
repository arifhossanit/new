<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">My Profile</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Profile</a></li>
              <li class="breadcrumb-item active">My Profile</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
		
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-info">
						<div class="card-header">
							My Profile
						</div>
						<div class="card-body" id="view_details">
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	return view_profile();
})
function view_profile(){
	var profile_id = '<?php echo $_SESSION['user_info']['employee_id']; ?>'; 
	if(profile_id != ''){
		var oke = '1';
		$.ajax({  
			url:"<?=base_url('assets/ajax/employee_single_view.php');?>",  
			method:"POST",  
			data:{view_id:profile_id,desiablities:oke},
			beforeSend:function(){					
				$('#data-loading').html('<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>');					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#view_details').html(data);    
			}  
		});  
	}		
}
</script>