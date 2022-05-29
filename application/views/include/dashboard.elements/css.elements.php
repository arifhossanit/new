<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<?php if(empty($logout_timer)){ ?>
	<meta http-equiv="refresh" content="7200;url=<?php echo current_url(); ?>" />
	<script> var counter = 7200; var interval = setInterval(function() { var d = new Date(); var hours = d.getHours() % 12; hours = hours ? hours : 12; var watch = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'][(d.getMonth() + 0)] + " " + ("00" + d.getDate()).slice(-2) + " " + d.getFullYear() + " " + ("00" + hours).slice(-2) + ":" + ("00" + d.getMinutes()).slice(-2) + ":" + ("00" + d.getSeconds()).slice(-2) + ' ' + (d.getHours() >= 12 ? 'PM' : 'AM'); counter--; if (counter <= 0) { clearInterval(interval); }else{ $('#timer_interval').html('Time Remaining <b>'+counter+'s</b> to Refresh<br />NET IP: <b><?php echo get_client_ip(); ?></b><br />Time: <b>'+watch+'</b>'); } }, 1000); </script>
	<?php } ?>
	<title> <?php if(!empty($title_info)){ echo $title_info; } ?> - SUPER HOME ERP (Neways)</title>	
	<link rel="icon" href="<?=base_url('assets/img/favicon.png');?>" type="image/gif" sizes="16x16">	
	<script type="text/javascript" src="<?=base_url('assets/js/jquery/jquery-3.3.1.js');?>"></script>
	<link rel="stylesheet" href="<?=base_url('assets/plugins/fontawesome-free/css/all.min.css');?>">	
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">	
	<link rel="stylesheet" href="<?=base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/plugins/jqvmap/jqvmap.min.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/plugins/daterangepicker/daterangepicker.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/plugins/summernote/summernote-bs4.css');?>">  	
	<link rel="stylesheet" href="<?=base_url('assets/css/google/fonts_1.css');?>">	
	<link rel="stylesheet" href="<?=base_url('assets/plugins/select2/css/select2.min.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css');?>">	
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">	
	<link rel="stylesheet" href="<?=base_url('assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/dist/css/adminlte.min.css');?>">
	<link rel="stylesheet" href="<?=base_url('assets/css/my_style.css');?>">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.min.js" integrity="sha512-i8ERcP8p05PTFQr/s0AZJEtUwLBl18SKlTOZTH0yK5jVU0qL8AIQYbbG5LU+68bdmEqJ6ltBRtCxnmybTbIYpw==" crossorigin="anonymous"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-8774CL8YB4"></script>
	<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-8774CL8YB4'); </script>
	<!-- Google Languahes -->
	
	<script type="text/javascript">
	/*
	function googleTranslateElementInit() { new google.translate.TranslateElement({ pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE }, 'google_translate_element'); } 
	*/
	</script>
	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<script>
	/*
	$(document).ready(function(){ $('#google_translate_element').bind('DOMNodeInserted', function(event) { $('.goog-te-menu-value span:first').html('Language'); $('.goog-te-menu-frame.skiptranslate').load(function(){ setTimeout(function(){ $('.goog-te-menu-frame.skiptranslate').contents().find('.goog-te-menu2-item-selected .text').html('Translate'); }, 1); }); }); }); 
	*/
	</script>
	
	<!-- Loader -->
	<style> .card-body form label{ margin-bottom:0px; } .card-body form .form-group{ margin-bottom:10px; } .card-body form span{ color:#f00; } @-webkit-keyframes spin { 0% { -webkit-transform: rotate(0deg); } 100% { -webkit-transform: rotate(360deg); } } @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } } .animate-bottom { position: relative; -webkit-animation-name: animatebottom; -webkit-animation-duration: 1s; animation-name: animatebottom; animation-duration: 1s; } @-webkit-keyframes animatebottom { from { bottom:-100px; opacity:0 } to { bottom:0px; opacity:1 } } @keyframes animatebottom { from{ bottom:-100px; opacity:0 } to{ bottom:0; opacity:1 } } #myDiv___iiijjggg____uujikj {  visibility: hidden; } </style>
	<script> $('document').ready(function(){ setTimeout(function(){ $("#loader").css({"display":"none"});  $("#myDiv___iiijjggg____uujikj").css({"visibility":"visible"});  }, 500); }) </script>
	<script> var data_loading = '<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>'; </script>
	<script> var data_loading_super_home = '<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?=base_url("assets/img/loading.gif");?>" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>'; </script>
</head>
<?php
	if(!empty($_SESSION['super_admin']['branch'])){
		if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
			$branch_id = "";
		}else{
			$branch_id = "branch_id = '".$_SESSION['super_admin']['branch']."' and ";
		}
		$today = date('Y-m-d');
		$_days_before = date('Y-m-d', strtotime(date('Y/m/d'). ' - 30 days'));
		$today_booking = $this->Dashboard_model->mysqlii("select count(*) as total_checkin from booking_info where $branch_id id != '' and STR_TO_DATE(checkin_date,'%d/%m/%Y') BETWEEN '$_days_before' AND '$today'");
		$today_checkout = $this->Dashboard_model->mysqlii("select count(*) as total_checkout from booking_info where $branch_id id != '' and STR_TO_DATE(checkout_date,'%d/%m/%Y') BETWEEN '$_days_before' AND '$today'");
		$comming = $today_booking[0]->total_checkin;
		$going = $today_checkout[0]->total_checkout;
		if($comming > $going){
			$background_color = 'style="background-color: #bdffcc !important;"';
		}else if($comming < $going){
			$background_color = 'style="background-color: #ffbdbd !important;"';
		}else if($comming == $going){
			$background_color = 'style="background-color: #fff4bd !important;"';
		}else{
			$background_color = '';
		}
	}else{
		$background_color = '';
	}
?>
<body class="hold-transition <?php if(!empty($b_class)){ echo $b_class; }else{ echo 'layout-top-nav';} ?> sidebar-mini" <?php echo $background_color; ?>>
<?php /* ?><div id="progress" class="waiting"> <dt></dt> <dd></dd></div><?php */ ?>
<?php if($title_info != 'Pre Booking & Police Verification Form'){ ?>
	<?php  if(!empty($dining_link) AND $dining_link == '1'){ } else{ 
		if(strpos($title_info, 'Employee Rating & Feedback Form QR:Code') !== false ){ ?>
		<div id="loader" style=" margin-top: 15%; padding-top: 48px; background: #fff; position: absolute; width: 100%;"> <center> <div style="width:311px;"> <img src="<?php echo base_url('assets/img/load_pre.png'); ?>" style="width:311px;"> <img src="<?php echo base_url('assets/img/loader.gif'); ?>" style="width:311px;"> </div> </center> </div>
	<?php }else{ ?>		
		<div id="loader" style=" margin-top: 15%; padding-top: 48px; background: #fff; position: absolute; width: 100%;"> <center> <div style="width:311px;"> <img src="<?php echo base_url('assets/img/neways.png'); ?>" style="width:311px;"> <img src="<?php echo base_url('assets/img/loader.gif'); ?>" style="width:311px;"> </div> </center> </div>
	<?php } }  ?>
<?php }?>
<div id="data-loading"></div>