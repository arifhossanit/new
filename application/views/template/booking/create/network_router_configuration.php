<div class="content-wrapper">	
	<div class="content">
		<div class="container-flud">
			<div class="row">
				<div class="col-sm-12">
					<?php if(isset($_SESSION['super_admin']['branch'])){ ?>
					<iframe
						src="<?php echo base_url(); ?>assets/router_configuration/"
						style="
							width:100%;
							border:none;
						"
						id="router_configuration_frame"
					></iframe>
					<?php } ?>
				</div>
			</div>			
		</div>
	</div>
</div>
<script>
	$('document').ready(function(){
		var get_body_height = $(".content-wrapper").height();
		$("#router_configuration_frame").height(get_body_height);
	})
</script>