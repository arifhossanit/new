<script type="" src="<?php echo base_url('assets/js/ckkeditor/ckeditor.js'); ?>"></script>
<link rel="stylesheet" href="<?=base_url('assets/plugins/select2/css/select2.min.css');?>">
<script type="text/javascript" src="<?=base_url('assets/plugins/select2/js/select2.full.min.js');?>"></script>
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

/* Center the loader */


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

<style>
#google_translate_element span{
	color:#000 !important;
}
</style>
<div class="content-wrapper" style="background-color:#fff;">
	<div class="container">
		
		<div class="row animate-bottom" id="myDiv">
			<div class="col-sm-12">
				<div class="card card-dark">
					<div class="card-header">
						<h3 class="card-title"><i class="fas fa-chalkboard-teacher"></i> &nbsp;&nbsp;&nbsp;Online Curriculum Vitae (CV)</h3>
						<a href="<?php echo current_url(); ?>" style="float:right;" title="Refresh"><i class="fas fa-sync-alt"></i></a>
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
								  $('.goog-te-menu-value span:first').html('Translate');
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
					<div class="card-body" >
						<form action="<?php echo current_url(); ?>" method="post" enctype="multipart/fform-data">
							<div class="row">
								<div class="col-sm-12">
									<h3 style="text-decoration:underline;text-align:left;">Personal Informaion</h3>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Token NO:</label>
										<input type="text" id="generate_id" autocomplete="off" name="generate_id" class="form-control" value="<?php echo date('dmy').'-'.time(); ?>" placeholder="Id Number" readonly/>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>First Name</label><small class="req"> *</small>
										<input name="f_name" placeholder="First Name" type="text" class="form-control" autocomplete="off" required/>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Last Name</label><small class="req"> *</small>
										<input name="l_name" placeholder="Last Name" type="text" class="form-control" required/>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Father Name</label><small class="req"> *</small>
										<input name="father_name" placeholder="Father Name" type="text" class="form-control" autocomplete="off" required/>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label>Mother Name</label><small class="req"> *</small>
										<input name="mother_name" placeholder="Mother Name" type="text" class="form-control" autocomplete="off" required/>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label> Gender</label><small class="req"> *</small>
										<select name="gender" class="form-control select2" name="gender" autocomplete="off" style="width: 100%;" required>
											<option value="">Select</option>
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label>Marital Status</label><small class="req"> *</small>
										<select class="form-control select2" name="marital_status" autocomplete="off" style="width: 100%;" required>
											<option value="">Select</option>
											<option value="Single">Single</option>
											<option value="Married">Married</option>
											<option value="Widowed">Widowed</option>
											<option value="Seperated">Seperated</option>
											<option value="Not Specified">Not Specified</option> 
										</select>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group"><small class="req"> *</small>
										<label>Date Of Birth</label><small class="req"> *</small>																				
										<input name="date_of_birth" type="text" class="form-control" placeholder="DD/MM/YYYY" id="employ_date_of_birth" data-target="#employ_date_of_birth" data-toggle="datetimepicker" autocomplete="off" required/>		
									</div>
								</div>
							</div>
							<div class="row">

										<input name="date_of_joining" type="hidden" class="form-control" autocomplete="off" />

								<div class="col-md-4">
									<div class="form-group">
										<label>Blood Group</label><small class="req"> *</small>
										<select class="form-control select2" name="blood_group" autocomplete="off" required>
											<option value="">Select</option>
											<option value="A+">A+</option>
											<option value="A-">A-</option>
											<option value="B+">B+</option>
											<option value="B-">B-</option>
											<option value="O+">O+</option> 
											<option value="O-">O-</option> 
											<option value="AB+">AB+</option> 
											<option value="AB-">AB-</option> 
											<option value="N/A">N/A</option> 
											<option value="Unknown">Unknown</option> 
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Personal Phone </label><small class="req"> *</small>
										<input name="personal_Phone" placeholder="Personal Phone" type="text" class="form-control" autocomplete="off" required/>
									</div>
								</div>	
								<div class="col-md-4">
									<div class="form-group">
										<label>Personal Email</label><small class="req"> *</small>
										<input id="email" name="email" placeholder="Personal Email" type="email" class="form-control" value="" autocomplete="off" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group">
										<label>Take a Selfie:</label><small class="req"> *</small>
										<div class="custom-file">
											<span id="avater_image"></span>
											<input type="hidden" id="photo_avater_value" name="photo_avater" value=""/>
											<button type="button" id="photo_avater" onclick="return open_camera()" title="Upload / Select / Chapture Photo" class="form-control btn btn-info" style="height:38px;color: #939ba2; background-color: #ffffff; border-color: #ced4da; box-shadow: none;"><i class="fas fa-camera"></i>&nbsp;&nbsp;&nbsp; Capture Photo / Upload</button>
										</div>
									</div>
								</div>								
								<div class="col-md-4">
									<div class="form-group">
										<label><abbr title="National Identity Card">NID<abbr> / Passport</label><small class="req"> *</small>
										<input name="nid_number" placeholder="NID / Passport" type="text" class="form-control" value="" autocomplete="off" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Educational Qualification</label><small class="req"> *</small>
										<select name="qualification[]" class="select2 select2-hidden-accessible form-control" multiple="" data-placeholder="Select Qualification" style="width: 100%;" data-select2-id="7" tabindex="-1" aria-hidden="true" required>
											<option value="PSC">PSC</option>
											<option value="JSC">JSC</option>
											<option value="SSC">SSC</option>
											<option value="HSC">HSC</option>
											<option value="Diploma">Diploma</option>
											<option value="B.Sc">B.Sc</option>
											<option value="M.Sc">M.Sc</option>
											<option value="BBA">BBA</option>
											<option value="MBA">MBA</option>
											<option value="BA">BA</option>
											<option value="BSS">BSS</option>
											<option value="BBS">BBS</option>
											<option value="Honours">Honours</option>
											<option value="Masters">Masters</option>
											<option value="PHD">PHD</option>
											<option value="LLB">LLB</option>
											<option value="LLM">LLM</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
								
							</div>							
							<div class="row">					
								<div class="col-md-4">
									<div class="form-group">
										<label>Emergency Contact Name 1</label><small class="req"> *</small>
										<input name="emergency_name1" placeholder="Emergency Contact Name 1" type="text" class="form-control" value="" autocomplete="off" required>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Emergency Contact Relation 1</label><small class="req"> *</small>
										<select name="emergency_relation1" class="form-control select2" style="width: 100%;" required>
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
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Emergency Contact Number 1</label><small class="req"> *</small>
										<input id="mobileno" name="emergency_no1" placeholder="Emergency Contact Number 1" type="text" class="form-control" value="" autocomplete="off" required>
									</div>
								</div>											
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Emergency Contact Name 2</label>
										<input name="emergency_name2" placeholder="Emergency Contact Name 2" type="text" class="form-control" value="" autocomplete="off">
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Emergency Contact Relation 2</label>
										<select name="emergency_relation2" class="form-control select2" style="width: 100%;">
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
								<div class="col-md-4">
									<div class="form-group">
										<label>Emergency Contact Number 2</label>
										<input id="mobileno" name="emergency_no2" placeholder="Emergency Contact Number 2" type="text" class="form-control" value="" autocomplete="off">
									</div>
								</div>							
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Current address</label><small class="req"> *</small>
										<textarea name="current_address" placeholder="Current Address" class="form-control" autocomplete="off" required></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Permanent Address</label><small class="req"> *</small>
										<textarea name="permanent_address" placeholder="Permanent Address" class="form-control" autocomplete="off" required></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Previous / Current Company Name</label><small class="req"> *</small>
										<textarea id="previus_company" name="previus_company" placeholder="Previous / Current Company Name" class="form-control" autocomplete="off"></textarea>
									</div>
								</div>								
								<div class="col-md-4">
									<div class="form-group">
										<label>Designation</label><small class="req"> *</small>
										<textarea name="previus_designation" placeholder="Designation" class="form-control" autocomplete="off"></textarea>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Reason About Leave</label><small class="req"> *</small>
										<textarea name="reason_leave" placeholder="Reason About Leave" class="form-control" autocomplete="off"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Work Experience</label>
										<textarea id="work_exp" name="work_exp" placeholder="Work Experience" class="form-control" autocomplete="off" required></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Note</label>
										<textarea name="note" placeholder="note" class="form-control" autocomplete="off"></textarea>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">									
									<label>
										<h3 style="text-decoration:underline;text-align:left;line-height: 60px;">
											<input type="checkbox" onclick="return submit_button_event()" id="social_media" style="transform: scale(1.9); margin-right: 20px;"/>
											Social Media Link
										</h3>
									</label>
									<script>									
										function submit_button_event(){
											if($('#social_media').is(':checked')){
												$(".social_media_container").css({"display":"flex"});
											}else{
												$(".social_media_container").css({"display":"none"});
											}
										}									
									</script>
								</div>
							</div>
							<div class="row around10 social_media_container" style="display:none;">
								<div class="col-md-6">
									<div class="form-group">
										<label>Facebook URL</label>
										<input name="facebook" placeholder="Facebook URL" type="url" class="form-control">
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Twitter URL</label>
										<input name="twitter" placeholder="Twitter URL" type="url" class="form-control">
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Linkedin URL</label>
										<input name="linkedin" placeholder="Linkedin URL" type="url" class="form-control">
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Instagram URL</label>
										<input id="instagram" name="instagram" placeholder="Instagram URL" type="url" class="form-control" value="">
									</div>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-sm-12">
									<span id="error_message" style="margin:0px;padding:0px;color:#f00;font-weight:600;"></span>
									<span id="done_message" style="margin:0px;padding:0px;color:green;font-weight:600;"></span>
								</div>
							</div>
							<div class="form-group">								
								<button type="submit" id="save" name="save_submit" class="btn btn-success" style="float:right;">Submit</button>
								<button onclick="window.open('<?php echo current_url(); ?>','_self')" type="button" class="btn btn-warning" style="float:right;margin-right:20px;">Reset</button>
							</div>
							<input type="hidden" id="image_test_avater" value=""/>
						</form>
						<div class="row">
							<div class="col-sm-12">
								<p style="color:#f00;font-weight:bolder;">N:B: Try to fill all field with your correct information, If you give any of wrong information then you have to suffer!!</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
<!----emergency attachment one model-->
	<div class="modal fade" id="camera_model_one">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Take emergency attachment one</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<select class="form-control" id="videoSource_one" onchange="return open_camera_one()"></select>
								</div>
							</div>
						</div>						
							
						<div id="DesiredResult_one" style="background-color:grey;width: 100%;">
							<video id="video_one" playsinline autoplay style="width:766px;"></video>
						</div>						
						<div id="output_one"></div>
					</div>
					<div class="modal-footer justify-content-between">
						<button onclick="return snap_one()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
						<button onclick="return retake_image_one()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
						<input type="file" id="other_file_one" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
						<button onclick="return capture_image_done_one()" type="button" class="btn btn-sm btn-success">Done</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End emergency attachment one model-->
<!----emergency attachment two model-->
	<div class="modal fade" id="camera_model_two">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-info">
						<h4 class="modal-title">Take emergency attachment two</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<select class="form-control" id="videoSource_two" onchange="return open_camera_two()"></select>
								</div>
							</div>
						</div>						
							
						<div id="DesiredResult_two" style="background-color:grey;width: 100%;">
							<video id="video_two" playsinline autoplay style="width:766px;"></video>
						</div>						
						<div id="output_two"></div>
					</div>
					<div class="modal-footer justify-content-between">
						<button onclick="return snap_two()" type="button" class="btn btn-sm btn-primary"><i class="fas fa-camera"></i> Capture</button>
						<button onclick="return retake_image_two()" type="button" class="btn btn-sm btn-info"><i class="far fa-images"></i> Retake</button>
						<input type="file" id="other_file_two" accept="image/*" class="form-control" style="padding-top:3px;padding:3px;width:100px;overflow: hidden;"/>
						<button onclick="return capture_image_done_two()" type="button" class="btn btn-sm btn-success">Done</button>
					</div>
				</form>
			</div>
		</div>
	</div>
<!----End emergency attachment two model-->
<script type="text/javascript" src="<?=base_url('assets/'); ?>js/webcamjs/webcam.js"></script>
<script>
$('.select2').select2();

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
//-------------------ONE---------------------------------------------------------------
function capture_image_done_one(){	
	if(document.getElementById('camera_canvas_one')){
		var canvas = document.getElementById('camera_canvas_one');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/camera_session_employee_photo_one.php"); ?>', function(code, text) {
			$("#avater_image_one").html('<img src="<?=base_url();?>'+text+'" style="width:50px;" id="view_image_one"/>');
			$("#photo_avater_value_one").val(text);
			$("#photo_avater_one").css({"width":"170px","float":"right"});
			$('#image_test_avater_one').val('success');
			$('#camera_model_one').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file_one").on("change",function(){
	var fileUpload = document.getElementById('other_file_one');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas_one";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult_one").textContent = "";
				document.getElementById("DesiredResult_one").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_camera_one(){	
	$('#camera_model_one').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video#video_one');
	const videoSelect = document.querySelector('select#videoSource_one');
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
	function camera_start_one() {
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
	videoSelect.onchange = camera_start_one;
//-------------
	return camera_start_one();
}
function snap_one() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas_one";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video_one'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult_one").textContent = "";
    document.getElementById("DesiredResult_one").appendChild(cv);	
}
function retake_image_one(){
	var cm = document.createElement("video");
    cm.width = w;
    cm.id = "video_one" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult_one").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult_one").html('<video id="video_one" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video#video_one');
	const videoSelect = document.querySelector('select#videoSource_one');
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
	function camera_start_one() {
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
	videoSelect.onchange = camera_start_one;
//-------------
	return camera_start_one();
}
$(document).ready(function(){
	$('#camera_model_one').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
//-------------------------------------------

//----------------------------------------------------------------------------------

//-------------------TWO---------------------------------------------------------------
function capture_image_done_two(){	
	if(document.getElementById('camera_canvas_two')){
		var canvas = document.getElementById('camera_canvas_two');
		var dataURL = canvas.toDataURL('');		
		Webcam.upload( dataURL, '<?php echo base_url("assets/ajax/form_submit/camera/camera_session_employee_photo_two.php"); ?>', function(code, text) {
			$("#avater_image_two").html('<img src="<?=base_url();?>'+text+'" style="width:50px;" id="view_image_two"/>');
			$("#photo_avater_value_two").val(text);
			$("#photo_avater_two").css({"width":"170px","float":"right"});
			$('#image_test_avater_two').val('success');
			$('#camera_model_two').modal('hide');			
			console.log('Save successfully');
			console.log(text);
        });	
	}else{
		alert('Capture / Choose File First!');
	}	
}
$("#other_file_two").on("change",function(){
	var fileUpload = document.getElementById('other_file_two');
	var cvs = document.createElement("canvas");
	cvs.width = w;
    cvs.height = h;
    cvs.id = "camera_canvas_two";        
    var cxs = cvs.getContext('2d');
    cxs.fillRect(0, 0, w, h);
    if ( this.files && this.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
            var img = new Image();
            img.src = e.target.result;
            img.onload = function() {
				cxs.drawImage(img, 0, 0, w, h);
				document.getElementById("DesiredResult_two").textContent = "";
				document.getElementById("DesiredResult_two").appendChild(cvs);
           };
        };       
        FR.readAsDataURL( this.files[0] );
    }	
})
function open_camera_two(){	
	$('#camera_model_two').modal('show');
	//-----camera------
	const videoElement = document.querySelector('video#video_two');
	const videoSelect = document.querySelector('select#videoSource_two');
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
	function camera_start_two() {
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
	videoSelect.onchange = camera_start_two;
//-------------
	return camera_start_two();
}
function snap_two() {
    var cv = document.createElement("canvas");
    cv.width = w;
    cv.height = h;
    cv.id = "camera_canvas_two";        
    var cx = cv.getContext('2d');
    cx.fillRect(0, 0, w, h);
    cx.drawImage(document.getElementById('video_two'), 0, 0, w, h);
	if (window.stream) {
		window.stream.getTracks().forEach(track => {
			track.stop();
		});
	}
	shutter.play();
	document.getElementById("DesiredResult_two").textContent = "";
    document.getElementById("DesiredResult_two").appendChild(cv);	
}
function retake_image_two(){
	var cm = document.createElement("video");
    cm.width = w;
    cm.id = "video_two" + "playsinline autoplay"; 
    cm.playsinline = ''; 
    cm.autoplay = ''; 
	document.getElementById("DesiredResult_two").textContent = "";
    //document.getElementById("DesiredResult").appendChild(cm);
    $("#DesiredResult_two").html('<video id="video_two" playsinline autoplay style="width:766px;"></video>');
	//-----camera------
	const videoElement = document.querySelector('video#video_two');
	const videoSelect = document.querySelector('select#videoSource_two');
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
	function camera_start_two() {
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
	videoSelect.onchange = camera_start_two;
//-------------
	return camera_start_two();
}
$(document).ready(function(){
	$('#camera_model_two').on('hidden.bs.modal', function () {
		if (window.stream) {
			window.stream.getTracks().forEach(track => {
			  track.stop();
			});
		  }
	});
})
</script>