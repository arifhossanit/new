<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<?php unset($_SESSION['pre_book_otp']);?>
<style>
.card-body form label{
	margin-bottom:0px;
}
.card-body form .form-group{
	margin-bottom:10px;
}
.card-body form span{
	color:#f00;
}


@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;

}
#google_translate_element span{
	color:#000 !important;
}
.trm_list li{
	padding-bottom:7px;
}
.error_messages_custom{
	margin-left: 0;
	margin-right: 0;
}
.error_messages_fixed{
	position: fixed;
	z-index: 1000;
	top: 0;
    right: 0;
    left: 0;	
	background-color: #e0e0e0;
	padding: 10px;
}
.error_messages_static{
	position: static;	
	background-color: #e0e0e0;
	padding: 10px;
}
</style>


<div id="loader" style=" margin-top: 20%;
    padding-top: 48px;
    background: #fff;
    position: absolute;
    width: 100%;">
	<center>
		<div style="width:311px;">
			<img src="<?php echo base_url('assets/img/load_pre.png'); ?>" style="width:311px;">
			<img src="<?php echo base_url('assets/img/loader.gif'); ?>" style="width:311px;">
		</div>		
	</center>
</div>



<script>
$('document').ready(function(){
	setTimeout(function(){
		$("#loader").css({"display":"none"});
		$("#myDiv").css({"display":"block"});
	}, 1000);
})
</script>


<div class="content-wrapper" style="background-color:#fff;">
	<div class="container">
		
		<div class="row animate-bottom" id="myDiv" style="margin-left: 0;margin-right: 0;">
			<div class="col-sm-12">
				<div class="card card-dark">
					<div class="card-header">
						<h3 class="card-title"><i class="fas fa-chalkboard-teacher"></i> &nbsp;&nbsp;&nbsp;Pre Booking Form</h3>
						<!--<a href="<?php echo current_url(); ?>" style="float:right;" title="Refresh"><i class="fas fa-sync-alt"></i></a>-->
						<div style=" float: right; margin-right: 20px; color: #000 !important;">
							<div id="google_translate_element"></div>
							<script type="text/javascript">
								function googleTranslateElementInit() {
									new google.translate.TranslateElement({  
										pageLanguage: 'en', 
										layout: google.translate.TranslateElement.InlineLayout.SIMPLE
									}, 'google_translate_element');
								}
							</script>
							<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
							<script>
								$(document).ready(function(){
									$('#google_translate_element').bind('DOMNodeInserted', function(event) {
										$('.goog-te-menu-value span:first').html('Language');
										$('.goog-te-menu-frame.skiptranslate').load(function(){
											setTimeout(function(){
												$('.goog-te-menu-frame.skiptranslate').contents().find('.goog-te-menu2-item-selected .text').html('Translate');    
											}, 1);
										});
									});
								});
							</script>
						</div>
					</div>
					<div class="row error_messages_custom">
						<div class="col-sm-12">
							<p id="error_message" style="margin:0px;padding:0px;color:#f00;font-weight:600;"></p>
							<p id="done_message" style="margin:0px;padding:0px;color:green;font-weight:600;"></p>
						</div>
					</div>
					<div class="card-body">						
						<form id="pre_booking_form" action="<?php echo current_url(); ?>" method="post" enctype="multipart/fform-data">
							
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Token NO:</label>
										<input type="text" id="generate_id" autocomplete="off" name="generate_id" class="form-control" value="<?php echo date('dmy').'-'.time(); ?>" placeholder="Id Number" readonly/>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Full Name:</label><span>*<span>
										<input type="text" id="" autocomplete="off" name="full_name" class="form-control" placeholder="Full Name" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Father Name:</label><span>*<span>
										<input type="text" id="" autocomplete="off" name="father_name" class="form-control" placeholder="Father Name" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Dath Of Birth:</label><span>*<span>
										<?php
											$now = date('Y') - 10;
											$ac_date = $now.'-'.date('m-d');
										?>
										<input type="date" id="" autocomplete="off" name="date_of_birth" class="form-control" max="<?php echo $ac_date; ?>" placeholder="Father Name"/>
										<!--<input name="date_of_birth" type="text" class="form-control" placeholder="DD/MM/YYYY" id="employ_date_of_birth" data-target="#employ_date_of_birth" data-toggle="datetimepicker" autocomplete="off" required="">-->
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label>Marital Status:</label><span>*<span>
										<select name="marital_status" class="form-control" required>
											<option value="">--select--</option>
											<option value="Single">Single</option>
											<option value="Married">Married</option>
										</select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label>Blood Group:</label><span>*<span>
										<select name="blood_group" class="form-control" required>
											<option value="">--select--</option>
											<option value="A+">A+</option>
											<option value="A-">A-</option>
											<option value="B+">B+</option>
											<option value="B-">B-</option>
											<option value="O+">O+</option>
											<option value="O-">O-</option>
											<option value="AB+">AB+</option>
											<option value="AB-">AB-</option>
											<option value="Unknown">Unknown</option>
										</select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label>Religion:</label><span>*<span>
										<select id="religion" name="religion" class="form-control" required>
											<option value="">--select--</option>
											<option value="Islam">Islam</option>
											<option value="Hindu">Hindu</option>
											<option value="Christian">Christian</option>
											<option value="Buddhist">Buddhist</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Occupation:</label><span>*<span>
										<select id="occupation" name="occupation" class="form-control" required>
											<option value="">--select--</option>
											<option value="Student">Student</option>
											<option value="Job Holder">Job Holder</option>
											<option value="Business Man">Business Man</option>
											<option value="Teacher">Teacher</option>
											<option value="Doctor">Doctor</option>										
											<option value="Driver">Driver</option>
											<option value="Housewife">Housewife</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Choose Photo:</label><span>*<span>
										<div class="custom-file">
											<span id="avater_image"></span>
											<input type="file" name="photo_avater" class="form-control" accept="image/x-png,image/gif,image/jpeg" style="padding-top:3px;" required />
											<!--
											<input type="hidden" id="photo_avater_value" name="photo_avater" value=""/>
											<button type="button" id="photo_avater" onclick="return open_camera()" title="Upload / Select / Chapture Photo" class="form-control btn btn-info" style="height:38px;color: #939ba2; background-color: #ffffff; border-color: #ced4da; box-shadow: none;"><i class="fas fa-camera"></i>&nbsp;&nbsp;&nbsp;  Photo Upload</button>-->
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Educational Qualification:</label><span>*<span>
										<select name="qualification[]" class="select2 form-control" multiple="" data-placeholder="Select Qualification" style="width: 100%;">
											<option value="PSC">PSC</option>
											<option value="JSC">JSC</option>
											<option value="SSC">SSC</option>
											<option value="HSC">HSC</option>
											<option value="Diploma">Diploma</option>
											<option value="B.Sc">B.Sc</option>
											<option value="M.Sc">M.Sc</option>
											<option value="BBA">BBA</option>
											<option value="MBA">MBA</option>
											<option value="Honours">Honours</option>
											<option value="Masters">Masters</option>
											<option value="PSD">PSD</option>
											<option value="MBBS">MBBS</option>
										</select>
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label>Phone Number:</label><span>*<span><span id="phone_message"></span>
										<input type="number" id="phone" autocomplete="off" name="phone" minlength="11" maxlength="11" class="form-control" placeholder="E.x 01000000000" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Email:</label><span>*<span>
										<input type="Email" id="Email" autocomplete="off" name="email" class="form-control" placeholder="Email" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>NID:</label><span>*<span>
										<input type="text" autocomplete="off" name="nid" class="number_int form-control" placeholder="NID" required />
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Passport NO:</label>
										<input type="text" id="" autocomplete="off" name="passport_no" class="form-control" placeholder="Passport NO"/>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group" id="custom_field_one">
										<label>How to find Us:</label><span>*<span>
										<select id="h_t_f_u" name="h_t_f_u" class="form-control" required >
											<option value="">How to find us</option>
											<option value="News Paper">News Paper</option>
											<option value="Google">Google</option>
											<option value="Facebook">Facebook</option>
											<option value="SMS">SMS</option>
											<option value="Youtube">Youtube</option>
											<option value="Parents">Parents</option>
											<option value="TVC">TVC</option>
											<option value="Friends">Friends</option>
											<option value="Colleague">Colleague</option>
											<option value="I dont Know">I don't Know</option>
											<option value="Other">Other</option>
											<option value="Custom Text">Custom Text</option>
										</select>
									</div>
									<script>
										$('document').ready(function(){
											$("#h_t_f_u").on("change",function(){
												var h_val = $(this).val();
												if(h_val == 'Custom Text'){
													$("#h_t_f_u").css({"display":"none"});
													$("#custom_field_one").html('<label>How to fint Us:</label><span>*<span><input type="text" name="h_t_f_u" id="h_t_f_u" class="form-control" placeholder="How to find us" required />');
													$("#h_t_f_u").focus();												
												}
											})
										})
									</script>
								</div>
								<?php if(!isset($from_pkg_pln)){ ?>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Select Our Branch:</label><span>*<span>
										<select id="" name="branch_id" class="form-control" required >
											<option value="">--select--</option>
											<?php
												if(!empty($banches)){
													foreach($banches as $row){
														if($row->branch_id != 'BAR_011220_210463187872898170_1606780607'){
															echo '<option value="'.$row->branch_id.'">'.$row->branch_name.' ('.$row->branch_type.' - '.$row->branch_location.')</option>';
														}
													}
												}
											?>
										</select>
									</div>
								</div>
								<?php }else{ ?>
									<input type="hidden" name="selected_pkg" value="<?php echo $package_id; ?>">
									<input type="hidden" name="branch_id" value="<?php echo $branch_id; ?>">
									<input type="hidden" name="checkin_date" value="<?php echo $checkin_date; ?>">
									<input type="hidden" name="parking" value="<?php echo $parking; ?>">
									<input type="hidden" name="payment" value="<?php echo $payment; ?>">
									<input type="hidden" name="locker" value="<?php echo $locker; ?>">
									<div class="col-sm-3">
										<div class="form-group" id="custom_field_one">
											<label>Are You A Returning Member: </label><span>*<span>
											<select name="member_type" class="form-control" required title="Please select Member Type">
												<option value="">Member Type</option>
												<option value="NEW">NEW</option>
												<option value="OLD">OLD</option>
											</select>
										</div>
									</div>
								<?php } ?>
							</div>	
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Permanent Address:</label><span>*<span>
										<textarea name="permament_address" autocomplete="off" class="form-control" placeholder="Permanent Address" required ></textarea>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label>Present Address:</label><span>*<span>
										<textarea name="present_addrress" autocomplete="off" class="form-control" placeholder="Present Address" required ></textarea>
									</div>
								</div>
								
							</div>

							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Emergency Contact name</label><span>*<span>
										<input type="text" id="" autocomplete="off" name="emergency_contact_name" class="form-control" placeholder="Emergency Contact name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" required />
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label>Emergency Contact Number</label><span>*<span>
										<input type="text" id="" autocomplete="off" minlength="11" maxlength="11" name="emergency_contact_number" class="number_int form-control" placeholder="E.x 01000000000" required />
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label>Emergency Contact Relation</label><span>*<span>
										<select name="emergency_relation" class="form-control" required >
											<option value="">--select--</option>
											<option value="Father">Father</option>
											<option value="Mother">Mother</option>
											<option value="Brother">Brother</option>
											<option value="Sister">Sister</option>
											<option value="Cousin">Cousin</option>
											<option value="Friends">Friends</option>
											<option value="Husband">Husband</option>
											<option value="Wife">Wife</option>
											<option value="Uncle">Uncle</option>
											<option value="Aunti">Aunti</option>
											<option value="Daughter">Daughter</option>
											<option value="Son">Son</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Emergency Contact Address</label><span>*<span>
										<input type="text" id="" autocomplete="off" name="emergency_contact_address" class="form-control" placeholder="Emergency Contact Address" required />
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Old Home owner Name</label>
										<input type="text" autocomplete="off" name="old_home_owner_name" class="form-control" placeholder="Old Home owner Name"/>										
									</div>
								</div>								
								<div class="col-sm-6">
									<div class="form-group">
										<label>Old Home owner Number</label>
										<input type="text" autocomplete="off" minlength="11" maxlength="11" name="old_home_owner_number" class="number_int form-control" placeholder="E.x 01000000000"/>										
									</div>
								</div>
							</div>	
							
							<div class="row">
								<div class="col-sm-12">
									<label style="color:Red;">Terms & Conditions</label>
									<div class="form-group" style="max-height:200px;overflow-y:scroll;text-align:left;float:left;font-weight:500;border: 1px solid #ced4da; border-radius: 5px;padding-top:15px;padding-bottom:15px;">
										<ol class="trm_list">
											<li>All Super Home resident/customer must abide by the rules and regulations of the Super Home as may be framed from time to time.</li>
											<li>Every resident/customer must be paid his/her Security deposit according to our policy during booking or before shifting to the Super Home; Every resident/ customer must Collect his/her Membership card and booking money receipt from the consultancy Zone (Lobby) during the time of check-in.</li>
											<li>Security Deposit is fully refundable at the time of leaving from Hostel subject to certain conditions.</li>
											<li>You have to bring your NID/Smart Card/Passport/Birth Certificate along with original copy of Institutional ID or Employee ID during booking and shifting. Foreigners have to show their passport, including valid visa page. If any resident/customer below age of 18 years, wants to stay then have to provide the guardian’s NID copy.</li>
											<li>The rent will be counted from the shifting date which is provided by the customer/ hostel residents unless he/she informs the authority.</li>
											<li>If a guardian books a seat for a student, then he/she must give the authority to the Super Home management regarding the cancelation and handling the Security Deposit.</li>
											<li>Resident/Customer has to fill up the Police verification Form properly with accurate information and authentic emergency contact number.</li>
											<li>Security Deposit will not be adjusted with the rent of last month and no consideration will be taken into notice in this regard.</li>
											<li>There is one time slot in a month. Have to be submitted an application physically from 1st to 10th days of month for the cancellation of seat or package shifting, then authority will take further steps according to the policy.</li>
											<li>Electricity bill is excluded. Every month electricity bill has to be adjusted at the end of the month.</li>
											<li>Cancellation paper work must be completed 1(one) day prior to your departure with the help of Branch management.</li>
											<li>In first month Super Hostel’s resident/customer can’t cancel the seat, the procedure of the cancelation will start in next month.</li>
											<li>Hostel’s resident/customer should always keep their room neat and tidy and use the dustbin properly.</li>
											<li>Hostel’s resident/customer must use the washroom and flash properly so that other resident/customer can use it without any worries.</li>
											<li>Maintain dining schedule as per the rules and timing, please use the dining room for your meal, No resident/customer is allowed to take his/her meal outside from dining area.</li>
											<li>Every resident/customer will collect his/her locker keys, led light, laundry bag etc. from branch office at the time of checking into the Hostel and do not abuse those.</li>
											<li>Hostel premise is completely a non-smoking zone, consumption of any alcoholic beverages and gambling is strictly prohibited and any violation of such rule will be viewed as serious offence under laws of Bangladesh; offender will be handed over to the legal authority of Bangladesh and  also security deposit money of concern resident/customer will be seized.</li>
											<li>Political activities as well as grouping are hardly restricted amongst the hostel residents/customers in the Hostel premises; if found, membership will be cancelled instantly and get him/her out from the Hostel right that moment or handed to the legal authority of Bangladesh.</li>
											<li>Carrying illegal substances such as drugs, explosives substances etc. in the hostel premises is forbidden and hostel resident/customer shall not use the same for doing any unlawful activities. Any kind of anti-government or anti-social activities will not be tolerated in any circumstances.</li>
											<li>Betting, making turbulence in the hostel premises, making noise and loudly talking or singing is highly prohibited and any activities regarding hampering the harmony of the neighborhood are strictly prohibited; Hostel authority reserves all rights to take any kind of decisions & legal actions when such situation arises.</li>
											<li>Playing loud musical game or making loud noise is prohibited; maintain personal conversation over cell phone with discreetly; also you are expected to open and close the door with proper manner.</li>
											<li>Hostel resident/customer is not allowed to display any obscene posters or calendars, wall writing etc. in the room or anywhere of the Hostel premises.</li>
											<li>Hostel residents/customers are supposed to take care of themselves. If Hostel resident/customer  is suffering from any contagious disease, must have to leave the Hostel premises for medical treatment and unless the Hostel resident/customer is fully recovered would not be allowed to enter or stay in the Hostel premises for the safety and wellbeing of other Hostel residents/customers.</li>
											<li>Hostel resident/customer do not lock room or  main door as according to the directions of DMP authority; they reserve the rights to check customer’s personal belongings randomly at any time.</li>
											<li>The Hostel customer/resident themselves are personally responsible to safeguard their belongings against any theft of laptop, mobile phone, computer, purse, calculator, wristwatch, wallet or any other valuable item but every case of theft should be reported promptly to the hostel administration so that proper steps could be taken against the guilty person.</li>
											<li>If anyone loses the locker key, it will be replaced to him/her after  payment of BDT 500/- (for each key). For each laundry bag replacement cost is BDT 200/- and for each Bed Light & USB converter replacement cost are BDT 300/-.</li>
											<li>Guests are allowed only in lobby of the hostel but cannot stay in here or not allowed to visit in the room. Female guests are NOT allowed inside the male hostel and male guests are NOT allowed inside the female hostel; however, for meeting & greetings they can use only downstairs lobby.</li>
											<li>Hostel resident/customer should co-operate in carrying out maintenance work and vacate him/her rooms completely when the Hostel authority requires the rooms for maintenance purpose. On such occasions, the authority will try to provide him/her alternate accommodation. If any maintenance work is to be carried out when the room is under occupation, it is the occupant’s responsibility to make the room available for the same time.</li>
											<li>The Authority reserves the right to cancel  the seat  of any Hostel resident/customer at any time</li>
											<li>The Authority reserves the right to increase rent in a reasonable manner.</li>
											<li>No Hostel resident/customer is allowed to change his seat without prior permission of Branch Management.</li>
											<li>Every Hostel resident/customer must inform the Hostel Authority if he/she is staying outside of hostel overnight for their own safety.</li>
											<li>To carry or keep Fire Arms or any other Arms and  Knife or as like other sharp things are strictly prohibited for Hostel resident/customer in Hostel Premises.</li>
											<li>For changing seat, first month have to stay and in second month within 1st to 5th day of that month have to apply in the consultancy zone by paying BDT 500, then Authority will check availability of desire seat and will take necessary steps for this.</li>
											<li>For parking bike, monthly BDT 500/- will be paid by bike holder for each bike and bike holder has to provide blue book copy and maintain the parking rules. This fee has to pay with monthly rent.</li>
											<li>Hostel Authority highly restricted for any kinds of personal electrical belonging used i.e.  Auto-Heat water Machine, Iron Machine, Rice Cooker and etc. in Hostel Premises.</li>
											<li>Indulging in physical fight/quarrel/bout/teasing/using offensive or undermining language/non-observance of Hostel rules is strictly prohibited and every Hostel resident/customer must show respect and behave with modesty with the fellow Hostel residents/customers.</li>
											<li>You the Hostel resident/customer DO NOT have any authority to take any action inside the Hostel premises regarding any issues or circumstances. And for these, please contact to the Branch management immediately.</li>
											<li>For clothes washing service, Hostel resident/customer must use the laundry bag. Daily Limit is 1 set of clothes per day.</li>
											<li>Dining time need to maintain, only in  lunch time we keep  meal till 6 PM only for some students and for some job holders who are coming from their work area.</li>
											<li>If any Hostel resident/customer wishes to be away from the Hostel during the weekend, holidays or any other time, he/she has to notify Hostel Authority.</li>
											<li>Hostel resident/customer will use all the electronic goods i.e. AC, hair dryer, shoe-polisher etc. with proper safety & care. Resident/customer will be  responsible for any damages done by him/her and have to pay compensation for that.</li>
											<li>Before leaving the Hostel please return all the key of lockers, LED lamp, laundry bag, membership card MR copy to the Branch Office and collect your clearance to complete your check out process; If lost or damaged any above have to pay the compensation before leave.</li>
											<li>No pet animals are allowed in the Hostel premise. Any mattress, table, shelf or any kinds of pots etc. are restricted.</li>
											<li>One resident/customer has one finger prints to enter into Hostel. Register your name at the time of late night entry or exit. Please, co-operate with the security during the entry and exit time on daily basis.</li>
											<li>Monthly rent is payable in advance within 10th  day of each month. From 11th  day of this month fine will be imposed BDT 100/-day for late payment of monthly rent and no consideration will be shown in this regard.</li>
											<li>Hostel Authority reserves all the exclusive right regarding continuation of stay of a resident/customer in the Hostel premises as well as in liberty to make any kind of decision and holds the right to change or alter  the policy at any time.</li>
											<li>Room members can only enter their own room. After 11 PM no gossiping is allowed inside the room even in reading room.</li>
											<li>If any of the above mentioned terms & conditions need to be clarified to our customer or any one, the Neways International Company Ltd. reserves the right to clarify the same to them.</li>
										</ol>
									</div>
								</div>
							</div>
							<div class="row">
								<div id="aggre_button" class="col-sm-12" style="display: none;">
									<label>
										<input type="checkbox" id="accept_trms_condition" onclick="return submit_button_event()" name="transconditions" required style="transform: scale(1.6);"/>
										&nbsp;&nbsp;&nbsp;&nbsp;
										<b style="color:#a50101;">I, hereby acknowledge & agree to abide by the terms and conditions as provided here above. I understand that any violation of the aforesaid terms and conditions may result in the revocation of my access and privileges in the Hostel premises and/or disciplinary actions may be taken along with other legal action. </b>
									<label>
								</div>
								<script>									
									function submit_button_event(){
										if($('#accept_trms_condition').is(':checked')){
											$("#submit_button").css({"display":"block"});
										}else{
											$("#submit_button").css({"display":"none"});
										}
									}									
								</script>
							</div>
							<div class="row justify-content-between mt-2">
								<div class="col-sm-3 col-5">
									<div class="row">
										<div class="col-sm-10 col-10">
											<div class="form-group" id="pre_book_otp">
												<input name="otp_confirm" id="otp_confirm" type="number" class="form-control" placeholder="Enter OTP" maxlength="4">
											</div>
										</div>
										<div class="col-sm-2 col-2 align-self-center" style="display: none;" id="otp_loader">
											<i class="fas fa-spinner fa-spin"></i>
										</div>
									</div>
								</div>
								<div class="col-sm-2 col-5">
									<div class="form-group" id="submit_button" style="display:none;">								
										<button type="submit" id="save" name="save" class="btn btn-success" style="float:right;" disabled><i class="fas fa-chalkboard-teacher"></i>  &nbsp;&nbsp;&nbsp;Apply</button>								
									</div>
								</div>
							</div>
							<input type="hidden" id="image_test_avater" value=""/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php /* ?>
<!----Camera model-->
	<div class="modal fade" id="camera_model">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Take photo</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<select class="form-control" id="videoSource" onchange="return open_camera()"></select>
								</div>
							</div>
						</div>						
							
						<div id="DesiredResult" style="background-color:grey;width: 100%;">
							<video id="video" playsinline autoplay style="width:766px;"></video>
						</div>						
						<div id="output"></div>
					</div>
					<div class="modal-footer justify-content-between">
						<button onclick="return snap()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
						<button onclick="return retake_image()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
						<input type="file" id="other_file" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
						<button onclick="return capture_image_done()" type="button" class="btn btn-sm btn-success">Done</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End Camera model-->

<script type="text/javascript" src="<?=base_url('assets/'); ?>js/webcamjs/webcam.js"></script>
<?php */ ?>
<script>
var distance = $('.content-wrapper').offset().top;

$(window).scroll(function() {
	if($('#done_message').html() != '' || $('#error_message').html() != ''){
		if ( $(this).scrollTop() >= 100 ) {
			$('.error_messages_custom').removeClass('error_messages_static');
			$('.error_messages_custom').addClass('error_messages_fixed');
		} else {
			$('.error_messages_custom').removeClass('error_messages_fixed');
			$('.error_messages_custom').addClass('error_messages_static');
		}
	}    
});

$('#phone').bind('keyup keydown', () => {
	let phone = $('#phone').val();
	if(phone.length == 11){
		$('#aggre_button').show();
	}
})
$('#accept_trms_condition').change(() => {
	if(document.getElementById('accept_trms_condition').checked) {
		let phone = $('#phone').val();
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/send_prebook_otp.php');?>",  
			data: {phone},
			beforeSend:function(){
				$('#otp_loader').show();
				$("#error_message").html('');
				$("#done_message").html('');
			},
			success:function(data){
				$('#otp_loader').hide();
				let info = JSON.parse(data);
				if(info.error){
					$('#error_message').html(info.message);
					$('#accept_trms_condition').prop('checked', false);				
				}else{
					$('#done_message').html(info.message);
					$('#pre_book_otp').show();
				}
				if ( $(window).scrollTop() >= 100 ) {
					$('.error_messages_custom').removeClass('error_messages_static');
					$('.error_messages_custom').addClass('error_messages_fixed');
				} else {
					$('.error_messages_custom').removeClass('error_messages_fixed');
					$('.error_messages_custom').addClass('error_messages_static');
				}
			}
		});
	}
})
$('#otp_confirm').bind('keyup keydown', () => {
	let otp_confirm = $('#otp_confirm').val();
	if(otp_confirm.length == 4){
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/confirm_prebook_otp.php');?>",  
			data: {otp_confirm},
			beforeSend:function(){
				$('#otp_loader').show();
				$("#error_message").html('');
				$("#done_message").html('');
			},
			success:function(data){
				$('#otp_loader').hide();
				let info = JSON.parse(data);
				if(info.error){
					$('#error_message').html(info.message);
					if ( $(window).scrollTop() >= 100 ) {
						$('.error_messages_custom').removeClass('error_messages_static');
						$('.error_messages_custom').addClass('error_messages_fixed');
					} else {
						$('.error_messages_custom').removeClass('error_messages_fixed');
						$('.error_messages_custom').addClass('error_messages_static');
					}
				}else{
					$('#error_message').html('');
					$('#done_message').html('');
					$('#save').prop('disabled', false);
					$('.error_messages_custom').hide();
				}
			}
		});
	}
})
$('document').ready(function(){
	$("#pre_booking_form").on('submit',function(){		
		if($('input[name="phone"]').val().length != 11) {
			$("#error_message").html('Phone Number shound be 11 Character!');
			$('.error_messages_custom').show();
		} else if($('input[name="emergency_contact_number"]').val().length != 11) {
			$("#error_message").html('Emergency contact Number shound be 11 Character!');
			$('.error_messages_custom').show();
		} else {
			event.preventDefault();
			var form = $('#pre_booking_form')[0];
			var data = new FormData(form);			
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url:"<?=base_url('assets/ajax/form_submit/prebooking_form_submit_data.php');?>",  
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				beforeSend:function(){
					$("#save").prop("disabled", true);
					$('#data-loading').html(data_loading);
					$("#error_message").html('');
					$("#done_message").html('');
				},
				success:function(data){
					$('#data-loading').html('');
					$("#save").prop("disabled", false);
					var value = data.split('_______');
					if(value[1] == 1){
						$("#error_message").html(value[0]);
						$('.error_messages_custom').show();
						if(value[2] == 1){
							$("#error_message").html(value[0]);
							$('.error_messages_custom').show();
							$('input[name="phone"]').css({"border":"solid 1px #f00"});
							$('input[name="phone"]').on("keyup",function(){
								if($(this).val() != value[3]){
									$('input[name="phone"]').css({"border":"solid 1px green"});
								}else{
									$('input[name="phone"]').css({"border":"solid 1px #f00"});
								}
							})
							$('input[name="phone"]').focus();
							return false;
						}else if(value[1] == 2){
							$("#error_message").html(value[0]);
							$('.error_messages_custom').show();
							$('input[name="email"]').css({"border":"solid 1px #f00"});
							$('input[name="email"]').on("keyup",function(){
								if($(this).val() != value[3]){
									$('input[name="email"]').css({"border":"solid 1px green"});
								}else{
									$('input[name="email"]').css({"border":"solid 1px #f00"});
								}
							})
							$('input[name="email"]').focus();
							return false;
						}else if(value[1] == 2){
							$("#error_message").html(value[0]);
							$('.error_messages_custom').show();
							$('#otp_confirm').css({"border":"solid 1px #f00"});
							$('#otp_confirm').focus();
							return false;
						}
					}else{
						$("#done_message").html(value[0]);
						$('.error_messages_custom').show();
						$('#pre_booking_form')[0].reset();
						setTimeout(function () {
						 	window.open('<?php echo base_url("member"); ?>','_self');
						}, 5000);
					}					
				}
			});
		}
		return false;
	})
})
<?php /* ?>
var w = 766, h = 575;
var shutter = new Audio();
shutter.autoplay = false;
shutter.src = navigator.userAgent.match(/Firefox/) ? '<?=base_url("assets/"); ?>js/shutter.ogg' : '<?=base_url("assets/"); ?>js/shutter.mp3';
function capture_image_done(){	
	if(document.getElementById('camera_canvas')){
		var canvas = document.getElementById('camera_canvas');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/camera_session.php"); ?>', function(code, text) {
			$("#avater_image").html('<img src="<?=base_url();?>'+text+'" style="width:50px;" id="view_image"/>');
			$("#photo_avater_value").val(text);
			$("#photo_avater").css({"width":"150px","float":"right"});
			$('#image_test_avater').val('success');
			$('#camera_model').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file").on("change",function(){
	var fileUpload = document.getElementById('other_file');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult").textContent = "";
				document.getElementById("DesiredResult").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_camera(){	
	$('#camera_model').modal('show');
	const videoElement = document.querySelector('video');
	const videoSelect = document.querySelector('select#videoSource');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start;
	return camera_start();
}
function snap() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult").textContent = "";
    document.getElementById("DesiredResult").appendChild(cv);	
}
function retake_image(){
	var cm = document.createElement("video");
    cm.width = w;
    cm.id = "video" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult").textContent = "";
    $("#DesiredResult").html('<video id="video" playsinline autoplay style="width:766px;"></video>');
	const videoElement = document.querySelector('video');
	const videoSelect = document.querySelector('select#videoSource');
	const selectors = [videoSelect];
	function gotDevices(deviceInfos) {
		const values = selectors.map(select => select.value);
		selectors.forEach(select => {
			while (select.firstChild) {
				select.removeChild(select.firstChild);
			}
		});
		for (let i = 0; i !== deviceInfos.length; ++i) {
			const deviceInfo = deviceInfos[i];
			const option = document.createElement('option');
			option.value = deviceInfo.deviceId;
			if (deviceInfo.kind === 'videoinput') {
				option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`;
				videoSelect.appendChild(option);
			}
		}
		selectors.forEach((select, selectorIndex) => {
			if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
				select.value = values[selectorIndex];
			}
		});
	}
	navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError);
	function gotStream(stream) {
		window.stream = stream;
		videoElement.srcObject = stream;
		return navigator.mediaDevices.enumerateDevices();
	}
	function handleError(error) {
		console.log('navigator.MediaDevices.getUserMedia error: ', error.message, error.name);
	}
	function camera_start() {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
				track.stop();
			});
		}
		const videoSource = videoSelect.value;
		const constraints = {
			video: {deviceId: videoSource ? {exact: videoSource} : undefined}
		};
		navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError);
		return false;
	}
	videoSelect.onchange = camera_start;
	return camera_start();
}
$(document).ready(function(){
	$('#camera_model').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})

function IsEmail(email) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(!regex.test(email)) {
		return true;
	}else{
		return false;
	}
} <?php */ ?>
</script>


<?php

/*
if($('input[name="full_name"]').val() == '' ){
			$("#error_message").html('Full name Required!');
			$('input[name="full_name"]').css({"border":"solid 1px #f00"});
			$('input[name="full_name"]').on("keyup",function(){
				if($(this).val() != ''){
					$('input[name="full_name"]').css({"border":""});
				}else{
					$('input[name="full_name"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="full_name"]').focus();			
			return false;
		}else if($('input[name="father_name"]').val() == '' ){
			$("#error_message").html('Father name Required!');
			$('input[name="father_name"]').css({"border":"solid 1px #f00"});
			$('input[name="father_name"]').on("keyup",function(){
				if($(this).val() != ''){
					$('input[name="father_name"]').css({"border":""});
				}else{
					$('input[name="father_name"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="father_name"]').focus();
			return false;
		}else if($('input[name="date_of_birth"]').val() == '' ){
			$("#error_message").html('Date of Birth Required!');
			$('input[name="date_of_birth"]').css({"border":"solid 1px #f00"});
			$('input[name="date_of_birth"]').on("keyup keydown change focus focusout",function(){
				if($(this).val() != ''){
					$('input[name="date_of_birth"]').css({"border":""});
				}else{
					$('input[name="date_of_birth"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="date_of_birth"]').focus();
			return false;
		}else if($('select[name="marital_status"]').val() == '' ){
			$("#error_message").html('Marital Status Required!');
			$('select[name="marital_status"]').select2('open');
			return false;
		}else if($('select[name="blood_group"]').val() == '' ){
			$("#error_message").html('Blood Group Required!');
			$('select[name="blood_group"]').select2('open');
			return false;
		}else if($('select[name="religion"]').val() == '' ){
			$("#error_message").html('Religion Required!');
			$('select[name="religion"]').select2('open');
			return false;
		}else if($('select[name="occupation"]').val() == '' ){
			$("#error_message").html('Occupation Required!');
			$('select[name="occupation"]').select2('open');
			return false;
		}else if($("#image_test_avater").val() == '' ){
			$("#error_message").html('Photo Required');
			return open_camera();			
		}else if($('select[name="qualification[]"]').val() == '' ){
			$("#error_message").html('Qualification Required!');
			$('select[name="qualification[]"]').select2('open');
			return false;
		}else if($('input[name="phone"]').val() == '' ){
			$("#error_message").html('Phone Number Required');
			$('input[name="phone"]').css({"border":"solid 1px #f00"});
			$('input[name="phone"]').on("keyup",function(){
				if($(this).val() != ''){
					$('input[name="phone"]').css({"border":""});
				}else{
					$('input[name="phone"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="phone"]').focus();
			return false;
		}else if(IsEmail($('input[name="email"]').val())){
			$("#error_message").html('Enter Valid Email!');
			$('input[name="email"]').css({"border":"solid 1px #f00"});
			$('input[name="email"]').on("keyup",function(){
				if($(this).val() != ''){
					$('input[name="email"]').css({"border":""});
				}else{
					$('input[name="email"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="email"]').focus();
			return false;
		}else if($('input[name="nid"]').val() == '' ){
			$("#error_message").html('NID Required');
			$('input[name="nid"]').css({"border":"solid 1px #f00"});
			$('input[name="nid"]').on("keyup",function(){
				if($(this).val() != ''){
					$('input[name="nid"]').css({"border":""});
				}else{
					$('input[name="nid"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="nid"]').focus();
			return false;
		}else if($('select[name="h_t_f_u"]').val() == '' ){
			$("#error_message").html('How To Find Us Required');
			$('select[name="h_t_f_u"]').select2('open');
			return false;
		}else if($('select[name="branch_id"]').val() == '' ){
			$("#error_message").html('Branch Required');
			$('select[name="branch_id"]').select2('open');
			return false;
		}else if($('textarea[name="permament_address"]').val() == '' ){
			$("#error_message").html('Permanent Address Required');
			$('textarea[name="permament_address"]').css({"border":"solid 1px #f00"});
			$('textarea[name="permament_address"]').on("keyup",function(){
				if($(this).val() != ''){
					$('textarea[name="permament_address"]').css({"border":""});
				}else{
					$('textarea[name="permament_address"]').css({"border":"solid 1px #f00"});
				}
			})
			$('textarea[name="permament_address"]').focus();
			return false;
		}else if($('textarea[name="present_addrress"]').val() == '' ){
			$("#error_message").html('Present Address Required');
			$('textarea[name="present_addrress"]').css({"border":"solid 1px #f00"});
			$('textarea[name="present_addrress"]').on("keyup",function(){
				if($(this).val() != ''){
					$('textarea[name="present_addrress"]').css({"border":""});
				}else{
					$('textarea[name="present_addrress"]').css({"border":"solid 1px #f00"});
				}
			})
			$('textarea[name="present_addrress"]').focus();
			return false;
		}else if($('input[name="emergency_contact_name"]').val() == '' ){
			$("#error_message").html('Emergency Contact Name Required');
			$('input[name="emergency_contact_name"]').css({"border":"solid 1px #f00"});
			$('input[name="emergency_contact_name"]').on("keyup",function(){
				if($(this).val() != ''){
					$('input[name="emergency_contact_name"]').css({"border":""});
				}else{
					$('input[name="emergency_contact_name"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="emergency_contact_name"]').focus();
			return false;
		}else if($('input[name="emergency_contact_number"]').val() == '' ){
			$("#error_message").html('Emergency Contact Number Required');
			$('input[name="emergency_contact_number"]').css({"border":"solid 1px #f00"});
			$('input[name="emergency_contact_number"]').on("keyup",function(){
				if($(this).val() != ''){
					$('input[name="emergency_contact_number"]').css({"border":""});
				}else{
					$('input[name="emergency_contact_number"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="emergency_contact_number"]').focus();
			return false;
		}else if($('select[name="emergency_relation"]').val() == '' ){
			$("#error_message").html('Emergency Relation Required');
			$('select[name="emergency_relation"]').select2('open');
			return false;
		}else if($('input[name="emergency_contact_address"]').val() == '' ){
			$("#error_message").html('Emergency Contact Address Required');
			$('input[name="emergency_contact_address"]').css({"border":"solid 1px #f00"});
			$('input[name="emergency_contact_address"]').on("keyup",function(){
				if($(this).val() != ''){
					$('input[name="emergency_contact_address"]').css({"border":""});
				}else{
					$('input[name="emergency_contact_address"]').css({"border":"solid 1px #f00"});
				}
			})
			$('input[name="emergency_contact_address"]').focus();
			return false;
		}else{ 
*/

?>