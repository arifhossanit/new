<?php
include("../../application/config/ajax_config.php");
if(isset($_POST['bed_type'])){ 
	$sql = $mysqli->query("select * from floors where branch_id = '".$_POST['branch_id']."' order by floor_name asc"); 
		$i = 0;
?>
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/fullcalendar/main.min.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/fullcalendar-daygrid/main.min.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/fullcalendar-timegrid/main.min.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/plugins/fullcalendar-bootstrap/main.min.css">
<style>
	.color_code_bed{
		width: 7px;
		height:7px;
	}
	.bed_color_info{
		padding-left: 20px;
	}
	.p_b_b{
		width:7px;
		height:7px;
		border-radius:20px;
		display:block !important;
		float:left;
	}
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
					<li class="pt-2 px-3"><h3 class="card-title">Floors</h3></li>
<?php while($row = mysqli_fetch_assoc($sql)){ ?>					
					<li class="nav-item">
						<a class="nav-link <?php if($i++ == 0 ){ echo 'active'; }?>" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home__<?php echo $row['id']; ?>" role="tab" aria-controls="custom-tabs-one-home__<?php echo $row['id']; ?>" aria-selected="true"><?php echo $row['floor_name']; ?></a>
					</li>
<?php } ?>					
                </ul>
            </div>			
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
<?php
$sql = $mysqli->query("select * from floors where branch_id = '".$_POST['branch_id']."' order by floor_name asc"); 
$j = 0;
while($row = mysqli_fetch_assoc($sql)){
?>
					<div class="tab-pane fade <?php if($j++ == 0 ){ echo 'show active'; }?>" id="custom-tabs-one-home__<?php echo $row['id']; ?>" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
						<div class="row">
							<div class="card card-warning card-tabs" style="width: 100%;">
							  <div class="card-header p-0 pt-1">
								<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
								  <li class="pt-2 px-3"><h3 class="card-title">Units</h3></li>
<?php
$sql2 = $mysqli->query("select * from units where floor_id = '".$row['id']."'");
$k = 0;
while($unit = mysqli_fetch_assoc($sql2)){ ?>								  
								  <li class="nav-item">
									<a class="nav-link <?php if($k++ == 0 ){ echo 'active'; }?>" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two<?php echo $row['id']; ?>-home<?php echo $unit['id']; ?>" role="tab" aria-controls="custom-tabs-two<?php echo $row['id']; ?>-home<?php echo $unit['id']; ?>" aria-selected="true"><?php echo $unit['unit_name']; ?></a>
								  </li>
<?php } ?>
								</ul>
							  </div>
							  <div class="card-body">
								<div class="tab-content" id="custom-tabs-two-tabContent">
<?php
$sql2 = $mysqli->query("select * from units where floor_id = '".$row['id']."'");
$l = 0;
while($unit = mysqli_fetch_assoc($sql2)){ ?>
								  
								  <div class="tab-pane fade <?php if($l++ == 0 ){ echo 'show active'; }?>" id="custom-tabs-two<?php echo $row['id']; ?>-home<?php echo $unit['id']; ?>" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
									<div class="row">
<?php
$sql3 = $mysqli->query("select * from rooms where unit_id = '".$unit['id']."' and room_type = '".$_POST['bed_type']."'");
while($room = mysqli_fetch_assoc($sql3)){
?>
										<div class="col-sm-6">
											<div class="card card-info">
												<div class="card-header">
													<h3 class="card-title">Room:- <?php echo $room['room_name']; ?></h3>
												</div>
												<div class="card-body">
													<div class="row">
													<!--<div class="col-sm-1"></div>-->
<?php												
$sq_com = $mysqli->query("select * from column_list where room_id = '".$room['id']."'");
while($col = mysqli_fetch_assoc($sq_com)){
?>
													<div class="col-sm-2" style="padding-right:2px;padding-left;2px;">
<?php
$sql4 = $mysqli->query("select * from beds where room_id = '".$room['id']."' and coloumn_id = '".$col['id']."'");
while($bed = mysqli_fetch_assoc($sql4)){
	if($bed['uses'] == 2 ){
		$member_information = mysqli_fetch_assoc($mysqli->query("SELECT * FROM member_directory WHERE bed_id = '".$bed['id']."' AND status = '1' ORDER BY id DESC"));
	if(!empty($member_information['id'])){
		$package = mysqli_fetch_assoc($mysqli->query("SELECT * FROM packages WHERE id = '".$member_information['package']."'"));
		if($package['try_us'] == 0){
			$check_in = explode('/',$member_information['check_in_date']);
			if($member_information['check_out_date'] == 'Not Confirm Yet'){
				$pad = explode('/',$member_information['check_in_date']);
				$pao = $pad[2].'-'.$pad[1].'-'.$pad[0];
				$check_outt = date('d/m/Y', strtotime($pao. ' + 180 days')); //membership days variable				
				$check_out = explode('/',$check_outt);			
			}else{
				$check_out = explode('/',$member_information['check_out_date']);
			}
		}else{
			$check_in = explode('/',$member_information['check_in_date']);
			$check_out = explode('/',$member_information['check_out_date']);			
		}
		$in_year = $check_in[2];
		$in_month = $check_in[1];
		$in_day = $check_in[0];
		
		$out_year = $check_out[2];
		$out_month = $check_out[1];
		$out_day = $check_out[0];
		
		$run_year = date('Y');
		$run_month = date('m');
		$run_day = date('d');
		
		$send_in_date = rahat_encode($in_day.'/'.$in_month.'/'.$in_year);
		$send_out_date = rahat_encode($out_day.'/'.$out_month.'/'.$out_year);
		if(!empty($_POST['checkin_date'])){
			$ct_date = explode('-',$_POST['checkin_date']);
		}else{
			$ct_date = explode('-',date('Y-m-d'));
		}
		$today_in = rahat_encode($ct_date[2].'/'.$ct_date[1].'/'.$ct_date[0]);
		
		/* if( $ct_date[2] <= $in_day AND  $ct_date[1] <= $in_month AND $ct_date[0] <= $in_year){ */
?>
													<button onclick="return boked_clander('<?php echo $bed['id']; ?>', '<?php echo $send_in_date; ?>', '<?php echo $send_out_date; ?>', '<?php echo $today_in; ?>')" class="btn btn-info" id="" type="button" style="width:100%;margin-bottom:10px;">
														<div class="badge badge-danger p_b_b"></div>
														<?php echo $bed['bed_name']; ?>
													</button>

<?php /* }else{ */ ?>	
													<!--<button class="btn btn-default" id="" type="button" style="width:100%;margin-bottom:10px;height:38px;"><marquee>Booked-<?php echo $bed['bed_name']; ?></marquee></button>-->
<?php  
	 /* } */ }  }else if($bed['uses'] == 3 ){ 
?>
													<button class="btn btn-warning" id="" type="button" style="width:100%;margin-bottom:10px;height:38px;"><marquee>Ocapide-<?php echo $bed['bed_name']; ?></marquee></button>
<?php 
	}else if($bed['uses'] == 4 ){ 
?>
													<button class="btn btn-danger" id="" type="button" style="width:100%;margin-bottom:10px;height:38px;" title="Request For Cencel-<?php echo $bed['bed_name']; ?>"><marquee>RFC-<?php echo $bed['bed_name']; ?></marquee></button>
<?php 
	}else{ 
		if($bed['status'] == 1){
			if($bed['uses'] == 0 ){
?>
													<button onclick="return get_bet_info_accept_branch(<?php echo $bed['id']; ?>)" class="btn btn-info" id="" type="button" style="width:100%;margin-bottom:10px;"><?php echo $bed['bed_name']; ?></button>
<?php
			}
		}else{
?>
													<button class="btn btn-dark" id="" type="button" style="width:100%;margin-bottom:10px;" title="Disable"><?php echo $bed['bed_name']; ?></button>
<?php 
		}
	} 
} 
?>
													</div>
<?php } ?>
													</div>
<?php
$msg = mysqli_fetch_assoc($mysqli->query("select * from beds where room_id = '".$room['id']."'"));
if(empty($msg['id'])){
	echo '<h3 class="card-title" style="text-align:center;">Bed Not Abaible!</h3>';
}
?>												
												</div>
											</div>
										</div>
<?php } ?>
									</div>
								  </div>
<?php } ?> 
								</div>
							  </div>
							</div>
						</div>	
					</div>
<?php } ?>				
                </div>
            </div>
              
        </div>
    </div>          
</div>	
<div class="modal fade" id="bed_selecting_model_clender"> 
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-info">
					<h4 class="modal-title">Bed booked information</h4>
					<button onclick="return clender_close()" type="button" class="btn btn-danger">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="bed_result_clander"></div>
			</form>
		</div>
	</div>
</div>
<!----End bed model-->
<script>
function clender_close(){
	$("#bed_selecting_model_clender").modal('hide');
}
function boked_clander(id, in_date, out_date, checkin_date){
	if( id != ''){
		$.ajax({  
			url:"<?php echo $home.'assets/ajax/option_select/from_booking_clander_building_overview_booking.php'; ?>",  
			method:"POST",
			data:{
				bed_id:id,
				in_date:in_date,
				out_date:out_date,
				checkin_date:checkin_date
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');								
				$('#bed_result_clander').html(data);
				$("#bed_selecting_model_clender").modal('show');
				setTimeout(function(){ 
					return booking_calender_fuc();
				}, 500);
			}  
		});  
	}	
}
</script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar/main.min.js"></script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar-interaction/main.min.js"></script>
<script src="<?php echo $home; ?>assets/plugins/fullcalendar-bootstrap/main.min.js"></script>
<?php } ?>