<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['profile_id'])){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$_POST['profile_id']."'"));
$email = explode("___",$row['uploader_info']);
$member = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$email[1]."'"));
?>
<div class="row">
	<div class="col-sm-12">
		<div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title"><b>Profile Information</b></h3></li>
				  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Account Information</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Rental Information</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Other</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                     <div class="row">
						<div class="col-sm-3">
							<img src="<?php echo $home.$row['photo_avater']; ?>" style="width:140px;" class="image-responsive"/>
						</div>
						<div class="col-sm-9">
							<h1><?php echo $row['full_name']; ?></h1>
							<p style="margin:0px;">Phone: <?php echo $row['phone_number']; ?></p>
							<p style="margin:0px;">Address: <?php echo $row['phone_number']; ?></p>
						</div>
					 </div>
					 <div>
						<div class="col-sm-12" style="margin-top:50px;">
							<h3>Personal Information</h3>
							<table style="width:100%;">
								<tr>
									<td><b>Name</b></td>
									<td>:</td>
									<td><?php echo $row['full_name']; ?></td>
								</tr>
								<tr>
									<td><b>Email</b></td>
									<td>:</td>
									<td><?php echo $row['email']; ?></td>
								</tr>
								<tr>
									<td><b>Phone</b></td>
									<td>:</td>
									<td><?php echo $row['phone_number']; ?></td>
								</tr>
								<tr>
									<td><b>Id Card</b></td>
									<td>:</td>
									<td><?php echo $row['id_card']; ?></td>
								</tr>
								<tr>
									<td><b>Occupation</b></td>
									<td>:</td>
									<td><?php echo $row['occupation']; ?></td>
								</tr>
								<tr>
									<td><b>Religion</b></td>
									<td>:</td>
									<td><?php echo $row['religion']; ?></td>
								</tr>
								<tr>
									<td><b>Father name</b></td>
									<td>:</td>
									<td><?php echo $row['father_name']; ?></td>
								</tr>
								<tr>
									<td><b>Mother name</b></td>
									<td>:</td>
									<td><?php echo $row['mother_name']; ?></td>
								</tr>
								<tr>
									<td><b>Emergency Number One</b></td>
									<td>:</td>
									<td><?php echo $row['emergency_number_1']; ?></td>
								</tr>
								<tr>
									<td><b>Emergency Number Two</b></td>
									<td>:</td>
									<td><?php echo $row['emergency_number_2']; ?> </td>
								</tr>
							</table>
						</div>

						<div class="col-sm-12" style="margin-top:50px;">
							<h3>Document Information</h3>
							<table style="width:100%;">
								<thead>
									<tr>
										<th></th>
										<th>Document Number</th>
										<th></th>
										<th>Document Type</th>
										<th></th>
										<th>Uploaded File</th>
									</tr>
								</thead>
							<?php
							$document = explode(",",$row['document_number']);
							$nmb = count($document) - 1;
							$i = 1;
							$j = 0;
							$doc_typ = explode(",",$row['document_type']);
							$doc_up = explode(",",$row['document_upload']);
							foreach ($document as $roy){
								$r = $i++;
								$p = $j++;
							?>
								<tr>
									<td><b>Document #<?php echo $r;?>:</b></td>
									<td><?php echo $roy; ?></td>
									<td>:</td>
									<td><?php echo $doc_typ[$p]; ?></td>
									<td>:</td>
									<td><a href="<?php echo $home.$doc_up[$p]; ?>" title="<?php echo $home.$doc_up[$p]; ?>" target="_blank"><i class="fas fa-external-link-alt"></i> View File</a></td>
								</tr>
							<?php if($r == $nmb){ break; }} ?>	
							</table>
						</div>
						
						<div class="col-sm-12" style="margin-top:50px;">
							<h3>Booking Information</h3>
							<table style="width:100%;">
								<tr>
									<td><b>Branch</b></td>
									<td>:</td>
									<td><?php echo $row['branch_name']; ?></td>
								</tr>
								<tr>
									<td><b>Floor</b></td>
									<td>:</td>
									<td><?php echo $row['floor_name']; ?></td>
								</tr>
								<tr>
									<td><b>Unit</b></td>
									<td>:</td>
									<td><?php echo $row['unit_name']; ?></td>
								</tr>
								<tr>
									<td><b>Room</b></td>
									<td>:</td>
									<td><?php echo $row['room_name']; ?></td>
								</tr>
								<tr>
									<td><b>Bed Type</b></td>
									<td>:</td>
									<td><?php echo $row['bet_type']; ?></td>
								</tr>
								<tr>
									<td><b>Bed</b></td>
									<td>:</td>
									<td><?php echo $row['bed_name']; ?></td>
								</tr>
								<tr>
									<td><b>Booking Date</b></td>
									<td>:</td>
									<td><?php echo $row['booking_date']; ?></td>
								</tr>
								<tr>
									<td><b>CheckIn Date</b></td>
									<td>:</td>
									<td><?php echo $row['check_in_date']; ?></td>
								</tr>
								<tr>
									<td><b>CheckOut Date</b></td>
									<td>:</td>
									<td><?php echo $row['check_out_date']; ?></td>
								</tr>
								<tr>
									<td><b>Card Number</b></td>
									<td>:</td>
									<td><?php echo $row['card_number']; ?></td>
								</tr>
								<tr>
									<td><b>Package</b></td>
									<td>:</td>
									<td><?php echo $row['package_name']; ?></td>
								</tr>
								<tr>
									<td><b>Security Deposit</b></td>
									<td>:</td>
									<td><?php echo $row['security_deposit']; ?></td>
								</tr>
								<tr>
									<td><b>Booked By</b></td>
									<td>:</td>
									<td><?php echo $member['full_name']; ?></td>
								</tr>
								
							</table>
						</div>
						
					 </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                     <div class="row">
						<div class="col-sm-12">
							<h3>Rental Information</h3>
							<table class="table table-sm table-bordered table-condensed table-striped">
								<thead>
									<tr>
										<th>Id</th>
										<th>Payment Date</th>
										<th>Package</th>
										<th>Rent Amount</th>
										<th>Recharge Days</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								$rent_query = $mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."'");
								while($rent = mysqli_fetch_assoc($rent_query)){
								?>
									<tr>
										<td><?php echo $rent['id']; ?></td>
										<td><?php echo $rent['data']; ?></td>
										<td><?php echo $rent['package_name']; ?></td>
										<td><?php echo money($rent['rent_amount']); ?></td>
										<td><?php echo $rent['recharge_days']; ?> Days</td>
										<td>
											<a href="">Edit</a>
										</td>
									</tr>
								</tbody>
								<?php } ?>
							</table>
						</div>
					 </div>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                     <div class="row">
						<div class="col-sm-12">
							<h1 style="text-align:center; font-size:50px;">Under Construction</h1>
						</div>
					 </div>
                  </div>
                </div>
              </div>
            </div>
	</div>
</div>


<?php } ?>