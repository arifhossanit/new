<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
<meta name="csrf-token" content="<?php echo time() * rand() ;?>">
  
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Change Profile Picture</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="#">Profile</a></li>
						<li class="breadcrumb-item active">Change Profile Picture</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-12" style="padding-top:20px;">				
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Change Profile Picture By your self</h3>							
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-4">
									<div id="preview-crop-image" style="background:#9d9d9d;width:100%;padding:50px 50px;">
									<?php if(!empty($profile_picture)){ ?>
										<img src="<?php echo base_url($profile_picture); ?>" style="width:100%;" class="image-responsive"/>
									<?php }else{ ?>
										<img src="<?php echo base_url('assets/img/empty-user-xl.png'); ?>" style="width:100%;" class="image-responsive"/>
									<?php } ?>
									</div>
								</div>
								<div class="col-sm-8">
									<div class="row">
										<div class="col-md-12" style="padding:5%;">
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label> Select image (min 600x600 - max 2000x2000).px: </label>
														<input type="file" id="image" class="form-control" style="padding-top:3px;">
													</div>
												</div>
												<div class="col-sm-6">
													<button class="btn btn-success btn-upload-image">Save Image</button>
												</div>
											</div>
											
											
										</div>
										<div class="col-md-12 text-center">
											<div id="upload-demo" style="display:none;"></div>
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
<script type="text/javascript">


var resize = $('#upload-demo').croppie({
    enableExif: true,
    enableOrientation: true,    
    viewport: { // Default { width: 100, height: 100, type: 'square' } 
        width: 600,
        height: 600,
        type: 'square' // circle
    },
    boundary: {
        width: 900,
        height: 900
    }
});
$('#image').on('change', function () { 	
	var reader = new FileReader();
	reader.onload = function (e) {
		resize.croppie('bind',{
			url: e.target.result
		}).then(function(){
			console.log('jQuery bind complete');
		});
	}
	reader.readAsDataURL(this.files[0]);
	$("#upload-demo").css({"display":"block"});
});
$('.btn-upload-image').on('click', function (ev) {
	if($('#image').val() != ''){	
		resize.croppie('result', {
			type: 'canvas',
			size: 'viewport'
		}).then(function (img) {
			$.ajax({
				url: "<?php echo base_url('assets/ajax/form_submit/camera/employee_profile_picture.php'); ?>",
				type: "POST",
				data: {"image":img},
				success: function (data) {
					html = '<img src="<?php echo base_url(); ?>' + data + '" style="width:100%;" />';
					$("#preview-crop-image").html(html);
					alert('Profile Picture Changed Successfully!');
				}
			});
		});
	}else{
		alert('Image Required!');
		$("image").focus();
	}
});


</script>