<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Front Office Setup</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Front Office Setup</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="container">
		<div class="row">
			<div class="col-sm-12">		
				<div class="card card-primary card-outline">
					<div class="card-header">
						<h3 class="card-title">
							<i class="fas fa-edit"></i>
							Front Office Setup
						</h3>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-2">
								<div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
									<a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="false">Purpose</a>
									<a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Complain Type</a>
									<a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Source</a>
									<a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="true">Reference</a>
								</div>
							</div>
							<div class="col-sm-10">
								<div class="tab-content" id="vert-tabs-tabContent">
									<div class="tab-pane fade active show" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
										<div class="row">
											<form action="<?php echo current_url(); ?>" method="post">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<input type="hidden" name="type" value="purpose"/>
															<input type="text" name="type_name" class="form-control" placeholder="Input Purpose" required/>
														</div>
														<div class="form-group">
															<textarea name="note" class="form-control" placeholder="Description"></textarea>
														</div>
														<div class="form-group">
															<button name="add_purpose" type="submit" class="btn btn-info pull-right">Add</button>
														</div>
													</div>
												</div>
											</form>
											<div class="col-sm-9">
												<table class="table table-sm table-bordered">
													<thead>
														<tr>
															<th>Id</th>
															<th>Content</th>
															<th>Adding Date</th>
															<th>Option</th>
														</tr>
													</thead>
													<tbody>
<?php 
if(!empty($fr_ctg)){
foreach($fr_ctg as $pur){
if($pur->type == 'purpose'){
?>															
														<tr>
															<td><?php echo $pur->id; ?></td>
															<td><?php echo $pur->content; ?></td>
															<td><?php echo $pur->data; ?></td>
															<td>
																<form action="" method="post">
																	<input type="hidden" name="delete_id" value="<?php echo $pur->id; ?>"/>
																	<button type="submit" name="delete" class="btn btn-xs btn-danger">Delete</button>
																</form>
															</td>
														</tr>
<?php } } } ?>																
													</tbody>
												</table>
											</div>
										</div>										
									</div>
									<div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
										<div class="row">
											<form action="<?php echo current_url(); ?>" method="post">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<input type="hidden" name="type" value="complain_type"/>
															<input type="text" name="type_name" class="form-control" placeholder="Input Complain Type" required/>
														</div>
														<div class="form-group">
															<textarea name="note" class="form-control" placeholder="Description"></textarea>
														</div>
														<div class="form-group">
															<button name="add_purpose" type="submit" class="btn btn-info pull-right">Add</button>
														</div>
													</div>
												</div>
											</form>
											<div class="col-sm-9">
												<table class="table table-sm table-bordered">
													<thead>
														<tr>
															<th>Id</th>
															<th>Content</th>
															<th>Adding Date</th>
															<th>Option</th>
														</tr>
													</thead>
													<tbody>
<?php 
if(!empty($fr_ctg)){
foreach($fr_ctg as $pur){
if($pur->type == 'complain_type'){
?>															
														<tr>
															<td><?php echo $pur->id; ?></td>
															<td><?php echo $pur->content; ?></td>
															<td><?php echo $pur->data; ?></td>
															<td>
																<form action="" method="post">
																	<input type="hidden" name="delete_id" value="<?php echo $pur->id; ?>"/>
																	<button type="submit" name="delete" class="btn btn-xs btn-danger">Delete</button>
																</form>
															</td>
														</tr>
<?php } } } ?>																
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
										<div class="row">
											<form action="<?php echo current_url(); ?>" method="post">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<input type="hidden" name="type" value="source"/>
															<input type="text" name="type_name" class="form-control" placeholder="Input Source" required/>
														</div>
														<div class="form-group">
															<textarea name="note" class="form-control" placeholder="Description"></textarea>
														</div>
														<div class="form-group">
															<button name="add_purpose" type="submit" class="btn btn-info pull-right">Add</button>
														</div>
													</div>
												</div>
											</form>
											<div class="col-sm-9">
												<table class="table table-sm table-bordered">
													<thead>
														<tr>
															<th>Id</th>
															<th>Content</th>
															<th>Adding Date</th>
															<th>Option</th>
														</tr>
													</thead>
													<tbody>
<?php 
if(!empty($fr_ctg)){
foreach($fr_ctg as $pur){
if($pur->type == 'source'){
?>															
														<tr>
															<td><?php echo $pur->id; ?></td>
															<td><?php echo $pur->content; ?></td>
															<td><?php echo $pur->data; ?></td>
															<td>
																<form action="" method="post">
																	<input type="hidden" name="delete_id" value="<?php echo $pur->id; ?>"/>
																	<button type="submit" name="delete" class="btn btn-xs btn-danger">Delete</button>
																</form>
															</td>
														</tr>
<?php } } } ?>																
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
										<div class="row">
											<form action="<?php echo current_url(); ?>" method="post">
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<input type="hidden" name="type" value="referance"/>
															<input type="text" name="type_name" class="form-control" placeholder="Input Referance" required/>
														</div>
														<div class="form-group">
															<textarea name="note" class="form-control" placeholder="Description"></textarea>
														</div>
														<div class="form-group">
															<button name="add_purpose" type="submit" class="btn btn-info pull-right">Add</button>
														</div>
													</div>
												</div>
											</form>
											<div class="col-sm-9">
												<table class="table table-sm table-bordered">
													<thead>
														<tr>
															<th>Id</th>
															<th>Content</th>
															<th>Adding Date</th>
															<th>Option</th>
														</tr>
													</thead>
													<tbody>
<?php 
if(!empty($fr_ctg)){
foreach($fr_ctg as $pur){
if($pur->type == 'referance'){
?>															
														<tr>
															<td><?php echo $pur->id; ?></td>
															<td><?php echo $pur->content; ?></td>
															<td><?php echo $pur->data; ?></td>
															<td>
																<form action="" method="post">
																	<input type="hidden" name="delete_id" value="<?php echo $pur->id; ?>"/>
																	<button type="submit" name="delete" class="btn btn-xs btn-danger">Delete</button>
																</form>
															</td>
														</tr>
<?php } } } ?>																
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
			</div>
		</div>
	</div>
</div>