<?php
if(!empty($_SESSION['super_admin']['user_type']) AND $_SESSION['super_admin']['user_type'] == 'Super Admin'){
	if($_SESSION['super_admin']['employee_ids'] == '00002'){
		$check_date = $this->Dashboard_model->mysqlii("select * from booking_target_adding_logs where target_month = '".date('m/Y')."'");
		if(empty($check_date)){
			if(!empty($_SESSION['target_setup_warning'])){ }else{
				$_SESSION['target_setup_warning'] = 'ok';
				echo "
					<script>
					$('document').ready(function(){
						$('#occupency_target_modal').modal('show');
					})
					</script>
				";
			}				
		}
	}
	if(!empty($notification_popup)){
		if($notification_popup == 1){ 
?>
<script>
$('document').ready(function(){
	$("#home_notice_board_modal").modal('show');
})
</script>
<?php		
		}
	}
}
?>
<script>
function view_calculator_modal(){
	$("#view_calculator_modal").modal('show');	
}
$(document).ready(function(){
	$('#view_calculator_modal').on('hidden.bs.modal', function () {
		$("#view_calculator_modal_result").html('');
	});
})

<?php if(!empty($_SESSION['user_info']['employee_id'])){ ?>
function view_my_life_history(){
	var employee_id = "<?php echo $_SESSION['user_info']['employee_id']; ?>";
	if(employee_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/employee_life_history_chart.php');?>",  
			method:"POST",  
			data:{ employee_id:employee_id },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#life_history_modal_result').html(data); 
				$('#life_history_modal').modal('show'); 
				setTimeout(function(){ 
					return render_chart_history();
				}, 300);				
			}
		});
	}
}
<?php } ?>
function view_branch_wise_up_down(){
	var book_id = $("#month_value").val();
	$.ajax({  
		url:"<?=base_url('assets/ajax/option_select/view_branch_wise_up_down_modal_result.php');?>",  
		method:"POST",  
		data:{book_id:book_id},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#view_branch_wise_up_down_modal_result').html(data); 
			$('#view_branch_wise_up_down_modal').modal('show'); 
		}  
	});
}
function view_profile_from_booking(id){
	var book_id = id;
	if(book_id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/booking_details_information.php');?>",  
			method:"POST",  
			data:{book_id:book_id},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);					 
			},
			success:function(data){	
				$('#data-loading').html('');
				$('#members_result_global').html(data); 
				$('#member_prifile_model_global').modal('show'); 
			}  
		});  
	}
}
function trigger_alert(){
	window.setTimeout(function() {
		$(".alert").fadeTo(1500, 0).slideUp(1500, function(){
			$(this).remove(); 
		});
	}, 3000);
}

$(function () {
	$('.datepicker.date-only-year').datepicker({
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
		autoclose: true,
	});
	$('.datepicker').datepicker({
		format: 'yyyy/mm/dd',
		todayHighlight:'TRUE',
		autoclose: true,
	});
	$('.datepicker-multiple').datepicker({
		format: 'yyyy/mm/dd',
		todayHighlight:'TRUE',
		multidate: true,
		endDate: new Date(),
	});
	$("#video_tutorials").on("change",function(){
		var vurl = $(this).val();
		if(vurl != ''){
			if($('#video_frame').attr('src', vurl)){
				$("#video_tutorials_modal").modal('show');
			}
		}		
	})
	$('#video_tutorials_modal').on('hidden.bs.modal', function () {
		$('#video_frame').attr('src', '');
		$("#video_tutorials").val("").trigger( "change" );
	});	
	$("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
	
	$('.select2').select2();
	$('.select2-readonly').select2(
		"readonly", true
	);
	$('#employ_date_of_birth').datetimepicker({
        format: 'DD/MM/YYYY'
    });
	$('#employ_date_of_joining').datetimepicker({
        format: 'DD/MM/YYYY'
    });	

	$('#ta_da_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"scrollX": true,
		"columnDefs": [
			{ "visible": false, "targets": 0 },
			{ "width": "2%", "targets": 9 }
		]
	});

	$('#ta_da_table_boss').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"order": [[ 14, "asc" ]],
		"info": true,
		"autoWidth": false,
		"responsive": false,
		"scrollX": true,
		"columnDefs": [
			{ "visible": false, "targets": [0, 14] },
			{ "width": "2%", "targets": 9 }
		]
	});
	
	$('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
	  "scrollX": true,
    });
	$('#ta_da_approval_table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
	  "order": [[ 8, "desc" ]],
      "info": true,
      "autoWidth": false,
      "responsive": false,
	  "scrollX": true,
    });
	$('#example3').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
	  "scrollX": true,
    });	
	$('#example4').DataTable({
	  "fixedHeader": true,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
	  "scrollX": true,
	  "pageLength": 5
    });
	$('#example5').DataTable({
	  "fixedHeader": true,
      "paging": false,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": false,
	  "scrollX": true,
	  "pageLength": 5
    });
	$('.duallistbox').bootstrapDualListbox();
	var threeMonthsAgo = moment().subtract(3, 'months');
	var currentMonth = moment();
	$('.date_range').daterangepicker({
		locale: {
            format: 'DD/MM/YYYY'
        },
		<?php if($_SESSION['super_admin']['user_type'] != 'Super Admin'){ 
		echo "dateLimit: {
			'months': 1,
			'days': -1
		},
		minDate: threeMonthsAgo.format('DD/MM/YYYY'),
		maxDate: moment().endOf('month').format('DD/MM/YYYY'),";
		} ?>
	});
	$('.date_range_default').daterangepicker({
		locale: {
            format: 'DD/MM/YYYY'
        },
	});
	$('.date_range_tmp').daterangepicker({
		startDate: '<?= (!isset($from_date)) ? date('d/m/Y') : $from_date?>',
		endDate: '<?= (!isset($to_date)) ? date('d/m/Y') : $to_date?>',
		locale: {
            format: 'DD/MM/YYYY'
        }
	});
	$('.number_int').on("input",function(){
		this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
	})
	$('[data-toggle="tooltip"]').tooltip();
	
	$('img[alt="Google Translate"]').css({"display":"none"});
	/* setTimeout(function(){ 
		$('.goog-te-banner-frame').css({"display":"none"});
	}, 1000); */
	
 })
<?php if(!empty($_SESSION['super_admin'])){ ?> 
/*
var refresh_rate = 600;
var last_user_action = 0;
var has_focus = false;
var lost_focus_count = 0;   
var focus_margin = 1000; 
function reset() {
    last_user_action = 0;
    console.log("Reset");
}
function windowHasFocus() {
    has_focus = true;
}
function windowLostFocus() {
    has_focus = false;
    lost_focus_count++;
    console.log(lost_focus_count + " <~ Lost Focus");
}
setInterval(function () {
    last_user_action++;
    refreshCheck();
}, 1000);
function refreshCheck() {
    var focus = window.onfocus;
    if ((last_user_action >= refresh_rate && !has_focus && document.readyState == "complete") || lost_focus_count > focus_margin) {
        screenLock_button();
        reset();
    }
}
window.addEventListener("focus", windowHasFocus, false);
window.addEventListener("blur", windowLostFocus, false);
window.addEventListener("click", reset, false);
window.addEventListener("mousemove", reset, false);
window.addEventListener("keypress", reset, false);
window.addEventListener("scroll", reset, false);
document.addEventListener("touchMove", reset, false);
document.addEventListener("touchEnd", reset, false);
*/
function screenLock_button(){
	var employee_id = "<?php echo rahat_encode($_SESSION['super_admin']['employee_id']); ?>";
	if( employee_id != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/dashboard/get_employee_lockscreen_session.php');?>",  
			method:"POST",
			data:{ employee_id:employee_id },
			success:function(data){	
				window.open("<?php echo base_url('admin/login'); ?>","_self");
			}  
		});  
	}
}
/*
$( document ).ready(function() {
	page_loader(105)
});
function page_loader(per){
	$({property: 0}).animate({property: per}, {
		duration: 1000,
		step: function() {
			var _percent = Math.round(this.property);
			$('#progress').css('width',  _percent+"%");
			if(_percent == per) {
				if(per == 105){
					$("#progress").addClass("done");
				}				
			}
		},
		complete: function() {
			
		}
	});
}
*/
<?php } ?>
</script>
<?php if(!empty($_SESSION['super_admin']['role_id']) AND $_SESSION['super_admin']['role_id'] != '2805597208697462328' ){ ?>
<div style="display:none;"></div><canvas id="image-canvas" style="display:none;"></canvas></div>
<script type="text/javascript" src="<?php echo base_url('assets/js/screenshot/js/html2canvas/html2canvas.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/screenshot/js/html2canvas/jquery.plugin.html2canvas.js'); ?>"></script>
<script>
$(document).ready(function(){
	var TrackUserActivity = {
		CaptureScreen : function($event_name){
			if($("#image-canvas").length>0) {
				$("#image-canvas").height($('body').height());
				$("#image-canvas").width($('body').width());
				$('body').html2canvas({
					onrendered: function (canvas) {
						var formdata = {
		              		event_name : $event_name,
		                    image_code:canvas.toDataURL("image/png")
		                };
		              //console.log(formdata);
		              $.post("<?php echo base_url('assets/ajax/form_submit/camera/screenshot.php'); ?>", formdata, function(msg) {
		                //console.log(msg);
		              });
					}
				});
			}		
		}
	}
	// window.addEventListener("click", function(){TrackUserActivity.CaptureScreen('click')});
	//  window.addEventListener("dblclick", function(){TrackUserActivity.CaptureScreen('click')});
	//window.addEventListener("submit", function(){TrackUserActivity.CaptureScreen('form-submit')});
	//window.addEventListener("reset", function(){TrackUserActivity.CaptureScreen('form-clear')});
	//window.addEventListener("copy", function(){TrackUserActivity.CaptureScreen('copy')});
	//window.addEventListener("beforeprint", function(){TrackUserActivity.CaptureScreen('print')});
	//window.addEventListener("contextmenu", function(){TrackUserActivity.CaptureScreen('right-click')});
});
</script>
<script type="text/javascript">
	/* var Tawk_API = Tawk_API||{}, Tawk_LoadStart = new Date();
	(function(){
		var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/5fc5eef2a1d54c18d8ef1973/default';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
	})();*/
</script>
<?php } ?>
<?php /* ?>
<?php 
if(isset($_SESSION['member_panel']['email'])){ ?>
<script type="text/javascript">
	var Tawk_API = Tawk_API||{}, Tawk_LoadStart = new Date();
	(function(){
		var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/5fc5eef2a1d54c18d8ef1973/default';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
	})();
</script>
<?php } ?>
<?php 
if(empty($_SESSION['super_admin'])){
	if(empty($live_chat)){
?>
<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/5fc5eef2a1d54c18d8ef1973/default';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
</script>	
<?php 
	} 
} 
?>

<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
  window.OneSignal = window.OneSignal || [];
  OneSignal.push(function() {
    OneSignal.init({
      appId: "879c62b6-20ee-42b3-a499-195c3c73d21c",
      notifyButton: {
        enable: true,
      },
      subdomainName: "neways",
    });
  });
</script>
<?php */ ?>

<script>
	// setInterval(function(){ 
	// 	$.ajax({
	// 		type: "POST",
	// 		enctype: 'multipart/form-data',
	// 		url:"<?=base_url('admin/demo_notification');?>",  
	// 		processData: false,
	// 		contentType: false,
	// 		cache: false,
	// 		timeout: 600000,
	// 		success: function(data) {
	// 			let info = JSON.parse(data);
	// 			if(info.total_notification != '0'){
	// 				$('#total_notification').html(info.total_notification);
	// 			}
	// 		}
	// 	}); 
	// }, 1000);
	/*
	$(document).ready(function(){
		notifyMe();
	})*/
function notifyMe(header,message) {
	var do_notification = 0;
	if (!("Notification" in window)) {
		alert("This browser does not support desktop notification");
		var do_notification = 0;
	} else if (Notification.permission === "granted") {		
		var do_notification = 1;
	} else if (Notification.permission !== "denied") {
		Notification.requestPermission().then(function (permission) {
			if (permission === "granted") {
				var do_notification = 1;
			}
		});
	}
	if( do_notification == 1 ){
		var notification = new Notification(header,{
			body: message,
			icon: 'http://erp.superhostelbd.com/super_home/assets/img/notification_neways.png'
		});	
	}	
}
function notification_open_link(id){
	if(id != ''){
		$.ajax({  
			url:"<?=base_url('assets/ajax/notification/software_notification.php');?>",  
			method:"POST",  
			data:{open_link_id:id},
			beforeSend:function(){ $('#data-loading').html(data_loading); },
			success:function(data){
				$('#data-loading').html('');	
				window.open(data,'_self');
			}  
		});  
	}
}
// setInterval(function(){ 
// 	var user_id = "<?php echo $_SESSION['super_admin']['employee_ids']; ?>";
// 	var notify_swssion = $("#notify_swssion").val();
// 	if(user_id != ''){
// 		$.ajax({  
// 			url:"<?=base_url('assets/ajax/notification/software_notification.php');?>",  
// 			method:"POST",  
// 			data:{user_id:user_id, notify_session: notify_swssion},
// 			success:function(data){
// 				var value = data.split('________');
// 				$("#notification_dropdown").html(value[0]);
// 				$("#notification_counter").html(value[1]);
// 				$("#notification_counter_header").html(value[1]);
// 				if(value[2] == 1){
// 					$("#notify_swssion").val(value[5]);
// 					notifyMe(value[3], value[4]);
// 				}
// 			}  
// 		});  
// 	}
// }, 10000);
</script>
<input type="hidden" id="notify_swssion" value="<?php if(!empty($_SESSION['push_notify'])){ echo $_SESSION['push_notify']; }else{ echo '0'; } ?>"/>
</body>
</html>