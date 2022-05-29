<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Terms & Conditions IPO Referal Approval</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front End</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Static Page</a></li>
						<li class="breadcrumb-item active">Terms & Conditions IPO Referal Approval</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">		
				<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/fform-data">
					<div class="form-group">
						<textarea name="content" id="editor1" class="form-control"><?php echo $content->content; ?></textarea>
					</div>
					<div class="form-group">
						<button type="submit" onclick="return confirm('Are you sure want to save this data?')" name="save" class="btn btn-success">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
CKEDITOR.replace('editor1', { });
</script>