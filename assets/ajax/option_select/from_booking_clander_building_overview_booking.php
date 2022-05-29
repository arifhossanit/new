<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['bed_id'])){ 
	$beds =  mysqli_fetch_assoc($mysqli->query("SELECT * FROM beds WHERE id = '".$_POST['bed_id']."'"));
$in = explode('/',rahat_decode($_POST['in_date']));
$out = explode('/',rahat_decode($_POST['out_date']));
$sel = explode('/',rahat_decode($_POST['checkin_date']));
?>
<style>
	.fc-day-number{
		font-size:30px;
		font-weight:500;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<span id="calender_booking_erroe_message" style="float:right;color:#f00;font-weight:bolder;"></span>
	</div>
	<div class="col-sm-12">
		<button onclick="return get_bet_info(<?php echo $beds['id']; ?>)" class="btn btn-danger" type="button">Use This Bed</button>
<?php
$mql = $mysqli->query("SELECT * FROM member_directory WHERE bed_id = '".$beds['id']."'");
$i = 1;
while($mow = mysqli_fetch_assoc($mql)){
?>		
		<button onclick="return view_member_profile(<?php echo $mow['id']; ?>)" class="btn btn-success" type="button"><?php echo $i++; ?>. View Exiting</button>
<?php } ?>		
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div id="calendar_booking"></div>
	</div>
</div>
<script> 
function booking_calender_fuc(){
	var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var Calendar = FullCalendar.Calendar;
    var calendarEl = document.getElementById('calendar_booking');
    var calendar = new Calendar(calendarEl, {
		plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
		dateClick: function(info){
			//alert('Clicked on: ' + info.dateStr);
			//alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
			//alert('Current view: ' + info.view.type);
			//change the day's background color just for fun
			//info.dayEl.style.backgroundColor = 'red';
			
			var in_year = '<?php echo $in['2']; ?>';
			var in_month = '<?php echo $in['1']; ?>';
			var in_days = '<?php echo $in['0']; ?>';
			
			var out_year = '<?php echo $out['2']; ?>';
			var out_month = '<?php echo $out['1']; ?>';
			var out_days = '<?php echo $out['0'] - 1; ?>';
			var calendar_date = info.dateStr;
			var chk_cal = calendar_date.split('-');			
			var timeStamp = function(str) { return new Date(str.replace(/^(\d{2}\-)(\d{2}\-)(\d{4})$/, '$2$1$3')).getTime(); };
			var click_date = parseInt(timeStamp(chk_cal[2] + '-' + chk_cal[1] + '-' + chk_cal[0]));
			var checkin_date = parseInt(timeStamp(in_days + '-' + in_month + '-' + in_year));
			var checkout_date = parseInt(timeStamp(out_days + '-' + out_month + '-' + out_year));
			var select_date = chk_cal[2] + '' + chk_cal[1] + '' + chk_cal[0];			
			var message_date = chk_cal[2] + '/' + chk_cal[1] + '/' + chk_cal[0];			
			var bed_id = <?php echo $beds['id']; ?>;
			var today = <?php echo date('dmY'); ?>;
			if (<?php echo date('Y'); ?> <= chk_cal[0] && <?php echo date('m'); ?> <= chk_cal[1] && <?php echo date('d'); ?> <= chk_cal[2]) {
				if( checkin_date <= click_date && checkout_date >= click_date){
					$("#calender_booking_erroe_message").html('Something wrong! ('+ message_date +') All ready Booked.');
				}else{
					if(bed_id != ''){
						$.ajax({  
							url:"<?php echo $home.'assets/ajax/select_beds_information_from_at_a_glance.php'; ?>",  
							method:"POST",  
							data:{bed_id:bed_id},
							beforeSend:function(){					
								$('#data-loading').html(data_loading);
							},
							success:function(data){
								$('#data-loading').html('');
								$("#checkin_date").val(calendar_date);
								var value = data.split('_');
								$("#bed_id_script").val(value[0]);
								$("#selected_bed").val(value[1]);						
								$("#bet_type").html(value[2]);						
								$('#bed_selecting_model_clender').modal('hide'); 
								$('#bed_selecting_model').modal('hide');						
								$('#add-booking').modal('show');
							}
						});  
					}else{
						$("#calender_booking_erroe_message").html('Something wrong! Please contact with IT Department.');
					}					
				}
			}else{
				$("#calender_booking_erroe_message").html('Something wrong! ('+ message_date +') Not Selectable.');
			}
		},
		header : {
			left : 'prev,next',
			center : 'title',
			right : 'today' //dayGridMonth
		},
		'themeSystem': 'bootstrap',
		events : [
			{
			  title          : '   Booked, CeckIn Date: <?php echo rahat_decode($_POST['in_date']); ?> & CheckOut Date: <?php echo rahat_decode($_POST['out_date']); ?>)',
			  start          : new Date(<?php echo $in['2']; ?>, <?php echo $in['1'] - 1; ?>, <?php echo $in['0']; ?>),  //+ 1, 19, 0
			  end            : new Date(<?php echo $out['2']; ?>, <?php echo $out['1']  - 1; ?>, <?php echo $out['0']; ?>), // + 1, 22, 30
			  allDay         : true,
			  //backgroundColor: '#00a65a',
			  //borderColor    : '#00a65a'
			},
			{
			  title          : 'Selected Date',
			  start          : new Date(<?php echo $sel['2']; ?>, <?php echo $sel['1']  - 1; ?>, <?php echo $sel['0']; ?>),  //+ 1, 19, 0
			  allDay         : true,
			  backgroundColor: '#fd7e14',
			  borderColor    : '#fd7e14'
			}
		],
		editable  : false,
		droppable : false,
		selectable: false		
    });
	calendar.render();
}
$('document').ready(function(){
    //return booking_calender_fuc();
})
</script>
<?php } ?>