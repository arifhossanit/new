<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['post_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$_POST['post_id']."'"));	
?>
<div class="col-sm-12" style="margin-bottom:30px;">
	<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
</div>
<div style="width:100%;margin-top:30px;float:left;"></div>
<section id="print_area">	
	<div class="row" style="padding: 0px 75px;">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-12">
					<h2>Applicant Details</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table class="custom_table_1 table table-bordered">
						<tr>
							<td style="width:50px;padding: 0px 10px;">1.</td>
							<td style="width:145px;padding: 0px 10px;">Name</td>
							<td style="padding: 0px 10px;"><?php echo $row['full_name']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">2.</td>
							<td style="width:145px;padding: 0px 10px;">Father's Name</td>
							<td style="padding: 0px 10px;"><?php echo $row['father_name']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">3.</td>
							<td style="width:145px;padding: 0px 10px;">Mother's Name</td>
							<td style="padding: 0px 10px;"><?php echo $row['mother_name']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">4.</td>
							<td style="width:145px;padding: 0px 10px;">Date of Birth</td>
							<td style="padding: 0px 10px;"><?php echo $row['date_of_birth']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">5.</td>
							<td style="width:145px;padding: 0px 10px;">Marital Status</td>
							<td style="padding: 0px 10px;"><?php echo $row['marital_status']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">6.</td>
							<td style="width:145px;padding: 0px 10px;">Spouse Name</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">7.</td>
							<td style="width:145px;padding: 0px 10px;">Present Address</td>
							<td style="padding: 0px 10px;"><?php echo $row['current_address']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">8.</td>
							<td style="width:145px;padding: 0px 10px;">Permanent Address</td>
							<td style="padding: 0px 10px;"><?php echo $row['permanent_address']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">9.</td>
							<td style="width:145px;padding: 0px 10px;">Date of Joining</td>
							<td style="padding: 0px 10px;"><?php echo $row['date_of_joining']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">10.</td>
							<td style="width:145px;padding: 0px 10px;">Designation</td>
							<td style="padding: 0px 10px;"><?php echo $row['designation_name']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">11.</td>
							<td style="width:145px;padding: 0px 10px;">Mobile No.</td>
							<td style="padding: 0px 10px;"><?php echo $row['personal_Phone']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">12.</td>
							<td style="width:145px;padding: 0px 10px;">NID No.</td>
							<td style="padding: 0px 10px;"><?php echo $row['nid_number']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">13.</td>
							<td style="width:145px;padding: 0px 10px;">Email:</td>
							<td style="padding: 0px 10px;"><?php echo $row['email']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">14.</td>
							<td style="width:145px;padding: 0px 10px;">Debit Card Name(19 Character):</td>
							<td style="padding: 0px 10px;">
								<table class="table table-bordered" style="margin-top: 23px;">
									<tr>
									<?php 
										foreach(array_slice(str_split($row['full_name'], 1),0,18) as $name){
											echo '<td style="text-transform: uppercase;">'.$name.'</td>';
										}
									?>
										
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<h2>Nominee Details</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table class="custom_table_1 table table-bordered">
						<tr>
							<td style="width:50px;padding: 0px 10px;">1.</td>
							<td style="width:160px;padding: 0px 10px;">Name</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">2.</td>
							<td style="width:160px;padding: 0px 10px;">Father's Name</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">3.</td>
							<td style="width:160px;padding: 0px 10px;">Mother's Name</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">4.</td>
							<td style="width:160px;padding: 0px 10px;">Date of Birth</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">5.</td>
							<td style="width:160px;padding: 0px 10px;">Marital Status</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">6.</td>
							<td style="width:160px;padding: 0px 10px;">Spouse Name</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">7.</td>
							<td style="width:160px;padding: 0px 10px;">Occupation</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="border-bottom: 0px;width:50px;padding: 0px 10px;">8.</td>
							<td style="width:160px;padding: 0px 10px;">Present Address</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;"></td>
							<td style="width:160px;padding: 0px 10px;">Permanent Address</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">9.</td>
							<td style="width:160px;padding: 0px 10px;">Relationship with applicant</td>
							<td style="padding: 0px 10px;"></td>
						</tr>						
					</table>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<h2>Emergency Contact Persion Details</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table class="custom_table_1 table table-bordered">
						<tr>
							<td style="width:50px;padding: 0px 10px;">1.</td>
							<td style="width:160px;padding: 0px 10px;">Name</td>
							<td style="padding: 0px 10px;"><?php echo $row['emergency_contact_name']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">2.</td>
							<td style="width:160px;padding: 0px 10px;">Address</td>
							<td style="padding: 0px 10px;"></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">3.</td>
							<td style="width:160px;padding: 0px 10px;">Relationship With</td>
							<td style="padding: 0px 10px;"><?php echo $row['emergency_contact_relation']; ?></td>
						</tr>
						<tr>
							<td style="width:50px;padding: 0px 10px;">4.</td>
							<td style="width:160px;padding: 0px 10px;">Mobile No & e-mail address</td>
							<td style="padding: 0px 10px;"><?php echo $row['emergency_no1']; ?></td>
						</tr>												
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12" style="font-weight:bolder;margin-top:15px;">
					<span>___________________</span><br />
					<span>Singnature  of the Applicatnt</span>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12" style="font-weight:bolder;margin-top:15px;">
					<span>Required Docs:</span><br />
					<ol type="1">
						<li>2 copy clear passport size lab print photo of applicant</li>
						<li>1 copy clear passport size lab print photo of nominee (attested by applicant)</li>
						<li>Clear photocopy of NID/Passport of the applicant+Nominee (attensted by applicant)</li>
					</ol>
				</div>
			</div>
			
		</div>
	</div>
</section>	
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>
<script>
    $('#print_button').on("click", function () {
      $('#print_area').printThis({
      });
    });
</script>	
<?php } ?>