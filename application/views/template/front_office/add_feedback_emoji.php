<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add Feedback Emoji</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Add Feedback Emoji</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Add Feedback Emoji</h3>
					</div>
					<div class="card-body">
						<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Feedback Code</label>
										<input type="text" name="feedback_cade" id="feedback_cade" value="<?php echo date('dmY').'-'.time() * rand(); ?>" class="form-control" readonly="readonly"/>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Feedback Value</label>
										<select name="feed_back_value" class="form-control select2" required>
											<option>--select--</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
										</select>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Feedback Title(English)</label>
										<input type="text" name="feedback_title_english" id="feedback_title_english" class="form-control" required="required"/>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Feedback Title(Bangla)</label>
										<input type="text" name="feedback_title_bangla" id="feedback_title_bangla" class="form-control" required="required"/>
									</div>
								</div>								
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Emoji Image</label>
										<input type="file" name="emoji_image" id="emoji_image" class="form-control" style="padding-top:3px;" required="required"/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label>Note</label>
										<textarea name="note" class="form-control" style="height:120px;"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<button type="submit" onclick="return confirm('Are you sure want to save this data?')" name="save" class="btn btn-success">Save</button>
									</div>
								</div>								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

</script>