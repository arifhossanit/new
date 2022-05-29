<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Audio Music Player</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Music Player</a></li>
						<li class="breadcrumb-item active">Audio Music Player</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-danger">
					<div class="card-header">
						<h3 class="card-title">Audio Music Player</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<iframe src="<?php echo base_url(); ?>assets/audio_player/index.php" id="audio_player" style="width:100%;border:none;" scrolling="no"></iframe>
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	var iframe_height = $(".content-wrapper").height();
	$("#audio_player").height(iframe_height);
})
</script>