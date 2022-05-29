<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Video Player</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Video Player</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-danger">
					<div class="card-header">
						<h3 class="card-title">Music Player <?php echo $time; ?></h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<?php
								function getYouTubeThumbnailImage($video_id) {
									return "http://i3.ytimg.com/vi/$video_id/hqdefault.jpg";
								}

								function extractVideoID($url){
									$regExp = "/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/";
									preg_match($regExp, $url, $video);
									return $video[7];
								}
								?>							
								<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/video_gallery/jquery.fancybox.min.css" />
								<div class="container">
									<h3 class="text-center">Music Video Gallery</h3>
									<div class="row">
										<?php 
										if(!empty($videoss)){
											foreach ($videoss as $video) { 
										?>
											<?php
											$video_id = extractVideoID($video->video_url);
											$video_thumbnail = getYouTubeThumbnailImage($video_id);
											?>
											<div class="col-md-4">
												<div class="pb-2">
													<a data-fancybox="video-gallery" href="<?php echo $video->video_url; ?>">
														<img src="<?php echo $video_thumbnail; ?>" class="img-thumbnail" />
													</a>
												</div>
											</div>
										<?php 
											} 
										}else{
										?>
										<div class="col-sm-12">
											<h2 style="text-align:center;">
												No Video to Show
											</h2>
										</div>
										<?php } ?>
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
<script src="<?php echo base_url(); ?>assets/js/video_gallery/jquery.fancybox.min.js"></script>
<!--https://artisansweb.net/create-youtube-video-gallery-website/-------->