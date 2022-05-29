<div class="tab-pane" id="documents">
	<div class="timeline-header no-border">
		<div class="row">
			<div class="col-md-12">
				<h3>Document</h3>
				<div class="row">
					<div class="col-sm-6">
						<table class="table table-sm table-bordered">
							<thead>
								<tr>
									<th>#Name</th>
									<th>URL</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Employee Image</td>
									<td>
										<?php if(!empty($row['photo'])){ ?>
										<a href="<?php echo $home.$row['photo']; ?>" title="Click to view Employee Image" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>Emergency Attachment 1</td>
									<td>
										<?php if(!empty($row['emergency_attachment_1'])){ ?>
										<a href="<?php echo $home.$row['emergency_attachment_1']; ?>" title="Click to view Emergency Attachment 1" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>Emergency Attachment 2</td>
									<td>
										<?php if(!empty($row['emergency_attachment_2'])){ ?>
										<a href="<?php echo $home.$row['emergency_attachment_2']; ?>" title="Click to view Emergency Attachment 2" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>														
								<tr>
									<td>Resume</td>
									<td>
										<?php if(!empty($row['first_doc'])){ ?>
										<a href="<?php echo $home.$row['first_doc']; ?>" title="Click to view Resume" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>Joining Letter</td>
									<td>
										<?php if(!empty($row['second_doc'])){ ?>
										<a href="<?php echo $home.$row['second_doc']; ?>" title="Click to view Joining Letter" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>Relese Letter</td>
									<td>
										<?php if(!empty($row['forth_doc'])){ ?>
										<a href="<?php echo $home.$row['forth_doc']; ?>" title="Click to view Relese Letter" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
							</tbody>
						</table>
						
						<table class="table table-sm table-bordered">
							<thead>
								<tr>
									<th>#Name (Social Links)</th>
									<th>URL</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Facebook</td>
									<td>
										<?php if(!empty($row['facebook'])){ ?>
										<a href="<?php echo $row['facebook']; ?>" title="Click to view Facebook Profile" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>Twitter</td>
									<td>
										<?php if(!empty($row['twitter'])){ ?>
										<a href="<?php echo $row['twitter']; ?>" title="Click to view Twitter Profile" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>Linkedin</td>
									<td>
										<?php if(!empty($row['linkedin'])){ ?>
										<a href="<?php echo $row['linkedin']; ?>" title="Click to view Linkedin Profile" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
								<tr>
									<td>Instagram</td>
									<td>
										<?php if(!empty($row['instagram'])){ ?>
										<a href="<?php echo $row['instagram']; ?>" title="Click to view Instagram Profile" class="" target="_blank">
											<i class="fas fa-external-link-alt"></i>
										</a>
										<?php } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="col-sm-6">
						<table class="table table-sm table-bordered">
							<thead>
								<tr>
									<th>#Name</th>
									<th>URL</th>
								</tr>
							</thead>
							<tbody>														
								<tr>
									<td>Other Documents</td>
									<td>
										<?php if(!empty($row['thired_doc'])){ 
											$o_document = explode(",",$row['thired_doc']);
											$don = 1;
											foreach($o_document as $file){
										?>
											<a href="<?php echo $home.$file; ?>" title="Click to view <?php echo $don++; ?>. Other Documents" class="" target="_blank">
												<i class="fas fa-external-link-alt"></i>
											</a>
											<br />
										<?php } } else{ ?>
											<a>----</a>
										<?php } ?>
									</td>
								</tr>														
							</tbody>
						</table>
					</div>
				</div>										
			</div>
		</div>
	</div>                            
</div> 