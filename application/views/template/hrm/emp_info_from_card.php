<?php
$department = $this->Dashboard_model->select('department',array( 'department_id' => $emp->department),'id','desc','row');;
$designation = $this->Dashboard_model->select('designation',array( 'designation_id' => $emp->designation),'id','desc','row');;
$branch = $this->Dashboard_model->select('branches',array( 'branch_id' => 'BAR_011220_210463187872898170_1606780607'),'id','desc','row');;
?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/card/css/template_normal.min.css">
<!--<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Averia+Serif+Libre:wght@300&display=swap" rel="stylesheet">
-->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Telex&display=swap" rel="stylesheet">

<div class="vcard-template style2" id="rootElement" style="/* font-family: 'Averia Serif Libre', cursive !important; */ font-family: 'Telex', sans-serif !important;">
    <div class="bgd-shadow"></div>
    <div class="page-home page">
        <div class="vcard-header gradient-red-orange-bg" style="background: rgb(<?php echo rand(000,255); ?>, <?php echo rand(000,255); ?>, <?php echo rand(000,255); ?>);">
            <div class="vcard-header-wrapper">
                <div class="vcard-top-info">
                    <h4 class="top"></h4>
                    <div class="img">
						<img src="<?php echo base_url($emp->photo); ?>" style="margin: 10px auto 0 auto;height:95px;width:95px;border-radius:50%;"/>
					</div>
                    <h2 class="name dynamicTextColor ng-binding" ng-show="view.firstname || view.lastname"><?php echo $emp->full_name; ?></h2>
                    <h6 class="title dynamicTextColor ng-binding">
						<?php echo $designation->designation_name; ?> - <?php echo $department->department_name; ?>
					</h6>
                </div>
                <div class="vcard-functions">
                    <div class="vcard-functions-wrapper">
						<a href="tel:<?php echo $emp->personal_Phone; ?>">
							<i class="fas fa-phone-square-alt"></i>
							<small class="dynamicTextColor">Call</small>
						</a>

						<a href="mailto:<?php echo $emp->email; ?>?subject=From my vCard(QRcode)&amp;body=" target="_newEmail">
							<i class="fas fa-envelope"></i>
							<small class="dynamicTextColor">Email</small>
						</a>

						<a href="https://www.google.com/maps/search/<?php echo urlencode($emp->current_address); ?>/" target="_blank" class="last-element">
							<i class="fas fa-map-marker-alt"></i>
							<small class="dynamicTextColor">Directions</small>
						</a>


                    </div>
                </div>
            </div>
        </div>
        <div class="vcard-body-wrapper">
            <div class="vcard-body">
                <div id="dvcard-details">				
					<div class="vcard-row">
						<i class="fas fa-flag-checkered"></i>
						<p class="ng-binding">
							<a href="javascript:void(0);" class="ng-binding">
								<?php echo $emp->job_responsibilities; ?>
							</a>
						</p>
						<small>Responsibilities</small>
					</div>
					
					<div class="vcard-row">
						<i class="fas fa-user-graduate"></i>
						<p class="ng-binding">
							<a href="javascript:void(0);" class="ng-binding">
								<?php echo $emp->qualification; ?>
							</a>
						</p>
						<small>Qualification</small>
					</div>
					
					<div class="vcard-row">
						<i class="fas fa-fist-raised"></i>
						<p class="ng-binding">
							<a href="javascript:void(0);" class="ng-binding">
								<?php echo $emp->work_exp; ?>
							</a>
						</p>
						<small>Experience</small>
					</div>
					
					
					<div class="vcard-separator"></div>
					<div class="vcard-row">
						<i class="fas fa-phone-square-alt"></i>
						<p><a href="tel:<?php echo $emp->personal_Phone; ?>" class="ng-binding"><?php echo $emp->personal_Phone; ?></a></p>
						<small>Mobile</small>
					</div>
					<div class="vcard-row" ng-show="view.email">
						<i class="fas fa-envelope"></i>
						<p><a href="mailto:<?php echo $emp->email; ?>?subject=From my vCard(QRcode)&amp;body=" target="_newEmail" class="ng-binding"><?php echo $emp->email; ?></a></p>
						<small>Email</small>
					</div>
					<div class="vcard-separator"></div>
					<div class="vcard-row">
						<i class="fas fa-briefcase"></i>
						<p class="ng-binding" style="font-weight:bolder;">Neways International</p>
						<small class="ng-binding"><?php echo $designation->designation_name; ?> - <?php echo $department->department_name; ?></small>
					</div>
					<div class="vcard-row">
						<i class="fas fa-map-marker-alt"></i>
						<p class="ng-binding"><?php echo $branch->branch_location; ?> </p>

						<div class="floated-container ng-scope">
							<a href="https://www.google.com/maps/search/<?php echo urlencode($branch->branch_location); ?>/" target="_blank" class="event-slim-button ripplelink left_15 mt-10" style="color: rgb(232, 87, 119);">
								Show on map            
							</a>
						</div>
					</div>
					<div class="vcard-separator"></div>
					<div class="vcard-row">
						<i class="fas fa-globe"></i>
						<p><a href="https://neways3.com/" target="_newLink" class="ng-binding">www.neways3.com</a></p>
						<small>Website</small>
					</div>
	
					<?php 
						if(
							!empty($emp->twitter) OR
							!empty($emp->instagram) OR
							!empty($emp->facebook) OR
							!empty($emp->linkedin)
						){ 
					?>
					<div id="socialmedialinksContainer">
						<div class="vcard-social" style="margin-bottom:20px;">
							<div class="socialMedia-container" ng-show="view.code.channels.length > 0">
								<label>Social Media</label>
								<i class="icon-social-media"></i>
								<div class="channels-padding mt-0">
									<?php if(!empty($emp->twitter)){ ?>
									<a href="<?php echo $emp->twitter; ?>" target="_blank" class="channel-container ng-scope" data-toggle="tooltip" data-placement="top" title="Twitter">
										<div class="table-cell-middle pl-55 pos-relative">
											<div class="channel-bgd-instagram">
												<span class="d-md-none d-lg-none d-xl-none d-sm-none">
													<i class="fab fa-twitter" style="font-size: 24px !important; margin-top: -4px !important;margin-left: -9px; box-shadow: none;"></i>
												</span>
												<span class="hidden-xs" style="color: white;">
													<i class="fab fa-twitter" style="font-size: 24px !important; margin-top: -4px !important;margin-left: -2px; box-shadow: none;"></i>
												</span>												
											</div>
										</div>
									</a>
									<?php } ?>
									<?php if(!empty($emp->instagram)){ ?>
									<a href="<?php echo $emp->instagram; ?>" target="_blank" class="channel-container ng-scope" data-toggle="tooltip" data-placement="top" title="Instagram">
										<div class="table-cell-middle pl-55 pos-relative">
											<div class="channel-bgd-dribbble">
												<span class="d-md-none d-lg-none d-xl-none d-sm-none">
													<i class="fab fa-instagram" style="font-size: 24px !important; margin-top: -4px !important;margin-left: -9px; box-shadow: none;"></i>
												</span>
												<span class="hidden-xs" style="color: white;">
													<i class="fab fa-instagram" style="font-size: 24px !important; margin-top: -4px !important;margin-left: -1px; box-shadow: none;"></i>
												</span>
												
											</div>
										</div>
									</a>
									<?php } ?>
									<?php if(!empty($emp->facebook)){ ?>
									<a href="<?php echo $emp->facebook; ?>" target="_blank" class="channel-container ng-scope" data-toggle="tooltip" data-placement="top" title="Facebook">
										<div class="table-cell-middle pl-55 pos-relative">
											<div class="channel-bgd-facebook">
												<span class="d-md-none d-lg-none d-xl-none d-sm-none">
													<i class="fab fa-facebook-f" style="font-size: 24px !important; margin-top: -4px !important;margin-left: -9px; box-shadow: none;"></i>
												</span>
												<span class="hidden-xs" style="color: white;">
													<i class="fab fa-facebook-f" style="font-size: 24px !important; margin-top: -4px !important;margin-left: -2px; box-shadow: none;"></i>
												</span>												
											</div>
										</div>
									</a>
									<?php } ?>
									<?php if(!empty($emp->linkedin)){ ?>
									<a href="<?php echo $emp->linkedin; ?>" target="_blank" class="channel-container ng-scope" data-toggle="tooltip" data-placement="top" title="Linkedin">
										<div class="table-cell-middle pl-55 pos-relative">
											<div class="channel-bgd-linkedin">
												<span class="d-md-none d-lg-none d-xl-none d-sm-none">
													<i class="fab fa-linkedin-in" style="font-size: 24px !important; margin-top: -4px !important;margin-left: -9px; box-shadow: none;"></i>
												</span>
												<span class="hidden-xs" style="color: white;">
													<i class="fab fa-linkedin-in" style="font-size: 24px !important; margin-top: -4px !important;margin-left: -2px; box-shadow: none;"></i>
												</span>												
											</div>
										</div>
									</a>
									<?php } ?>									
								</div>
							</div>
						</div>
					</div>
					<?php } ?>	
					<div class="vcard-row follow-scroll contactData-container fixed-button">
						<div class="fabs" id="saveContact">
							<div class="fixed-blur-bgd">
								<div class="chat">
									<div class="fab-body fab-step1">
										<style>.icon-fab-close:before{display:none !important;}</style>
										<div class="iconFab icon-fab-close" style="cursor: pointer; position: absolute; right: 39px; font-size: 35px; top: -21px; color: rgba(0,0,0,0.37);">
											<i class="fas fa-times"></i>
										</div>
										<div class="fab-header" style="color: rgb(232, 87, 119);">
											Save Contact Data                
										</div>
										<div class="fab-header text-regular">How would you like to save contact data?</div>
										<ul>
											<li class="addContactAction" style="color: #b3b4bb;">
												<i class="iconFab fas fa-envelope"></i>
												<a href="mailto:<?php echo $emp->email; ?>?subject=From my vCard(QRcode)&amp;body=" target="_newEmail"> 
													Send Email 
												</a>
											</li>
											<li class="addContactAction" style="color: #b3b4bb;">
												<i class="iconFab fas fa-mobile-alt"></i>
												<a href="<?php echo base_url('assets/ajax/vcf_generator.php?user_id='.$emp->id.''); ?>" class="ng-scope">
													Save to My Phone 
												</a> 
											</li>
										</ul>

									</div>
									<!--
									<div class="fab-body" style="display:block;">
										<div class="fab-header text-regular" style="color: #b3b4bb;">
											<i class="iconFab fas fa-envelope"></i>
											<span class="emailText1">Or Subscribe Newslatter.</span>
										</div>
										<form action="<?php echo current_url(); ?>" method="post" class="ng-pristine ng-valid ng-valid-email">
											<input class="fab-email-input ng-pristine ng-untouched ng-valid ng-valid-email" name="email" type="email" id="email" placeholder="Enter Email Address" required="required">
											<div class="btn green block" style="float: left;margin-top: 20px;">
												Send 
											</div>
										</form>
									</div>-->
								</div>
							</div>
							<a id="prime" class="fab"style="background: rgb(232, 87, 119);">							
								<span class="hidden-xs" style="color: white;font-family: system-ui;">
									<i class="fas fa-user-plus" style="position: absolute;left:-17px; top: 17px; font-size: 20px; color: #f7f7f7;"></i>
									Download vCard        
								</span>
								<span class="d-md-none d-lg-none d-xl-none d-sm-none">
									<i class="fas fa-user-plus" style="position: absolute;left:17px; top: 17px; font-size: 20px; color: #f7f7f7;"></i>
								</span>
							</a>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
<style>
#onesignal-bell-container{
	display:none !important; 
}
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/card/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/card/js/angular.rendering.min.js"></script>
<script type="text/javascript">
    function toggleFab(id) {
        $(id + ' .prime').toggleClass('is-active');
        $(id + ' #prime').toggleClass('is-float');
        $($(id).parent()).toggleClass('fabOnTop');
        $('#prime.fab').toggleClass('disabledClick');
        $(id + ' .fixed-blur-bgd').toggle();
        $(id + ' .chat').toggleClass('is-visible');
    }
    $(document).ready(function () {
        $('#prime, .icon-fab-close').click(function () {
            var id = $($(this).closest('.fabs')).attr('id');
            toggleFab('#' + id);
        });
    });
</script>

