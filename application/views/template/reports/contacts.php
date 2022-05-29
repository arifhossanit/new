<style type="stylesheet">
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Contacts</h1>
				</div> 
			</div> 
		</div> 
    </div>	
	<div class="content">
		<div class="container-fluid">			
			<div class="row">		
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					<div class="row">
								
						<div class="col-sm-12">
							<div class="card card-success">
								<div class="card-header">
									Employee Contact Infos
								</div>
								<div class="card-body">
									<table class="table table-sm table-bordered" id="example3">
										<thead>
											<tr>
												<th style="width:15vw;" class="sticky-header">Employee ID</th>
                                                <th style="width:15vw;" class="sticky-header">Contact Name</th>
												<th style="width:60px;" class="sticky-header">Email</th>
												<th style="width:100px;" class="sticky-header">Phone</th>
											</tr>
										</thead>
										<tbody style="height:300px !important;overflow-x:scroll;">
										<?php if(!empty($a)){ foreach($a as $LoopRow){?>
											<tr>
												<td><?php print $LoopRow->member_id; ?></td>
                                                <td><?php print $LoopRow->name; ?></td>
												<td><?php print $LoopRow->email; ?></td>
                                                <td><?php print $LoopRow->phone ; ?></td>
											</tr>
											<?php }
										} ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<script>
	$('#example3').DataTable();
</script>