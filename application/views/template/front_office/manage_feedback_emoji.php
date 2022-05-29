<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Manage Feedback Emoji</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Manage Feedback Emoji</li>
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
						<h3 class="card-title">Manage Feedback Emoji</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<table id="food_menu_data_table" class="table table-bordered">
									<thead>
										<tr>
											<th>Id</th>
											<th>Title</th>
											<th>Value</th>
											<th>Emoji</th>
											<th>Date</th>
											<th>Option</th>
										</tr>
									</thead>
									<tbody>
									<?php
										if(!empty($emoji)){
											foreach($emoji as $row){
									?>
										<tr>
											<td><?php echo $row->id; ?></td>
											<td>
												English: <?php echo $row->feedback_title_english; ?><hr style="margin:0px;padding:0px;"/>
												Bangla: <?php echo $row->feedback_title_bangla; ?>
											</td>
											<td><?php echo $row->feed_back_value; ?></td>
											<td>
												<img src="<?php echo base_url().$row->emoji_image;?>" style="width:60px;"/>
											</td>
											<td><?php echo $row->data; ?></td>
											<td>
												<form action="<?php echo current_url(); ?>" method="post">
													<input type="hidden" name="hidden_id" value="<?php echo $row->id; ?>" />
													<button onclick="confirm('Are you sure want to delete?')" name="delete" type="submit" class="btn btn-danger btn-xs">Delete</button>
												</form>
											</td>
										</tr>
									<?php
											}
										}
									?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

</script>