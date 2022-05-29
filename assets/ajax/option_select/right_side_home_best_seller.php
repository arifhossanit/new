<?php
// error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['date_filter'])){
	$selected_month = new DateTime($_POST['date_filter']);
	$selected_month->modify('first day of previous month'); 
}else{
	$selected_month = new DateTime("first day of last month");
}
$validate = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as id_count from branches_revenue_rank where month = '".$selected_month->format('Y-m')."'"));

if($validate['id_count'] == 0){ ?>
	<center>
		<h4>Ranking For <span style="font-style: italic"><?= $selected_month->format('F')?></span> Not Published Yet!</h4>
	</center>
<?php exit(); } ?>
<?php
	$ranks = $mysqli->query("SELECT branches_revenue_rank.*, employee.full_name, employee.photo, branches.branch_name, branches.branch_id from branches_revenue_rank INNER JOIN employee on employee.employee_id = branches_revenue_rank.branch_in_charge INNER JOIN branches using(branch_id) where month = '".$selected_month->format('Y-m')."' ORDER BY month_revenue DESC");
	$count = $ranks->num_rows;
?>
<div>
	<div class="row">
		<div class="col-sm-12" style="padding-bottom:29px;padding-top: 20px !important;">
			<center>
				<span style="font-size:28px;text-transform: uppercase;color:#fff;box-shadow: 0px 0px 11px 0px rgba(0,0,0,1);padding: 0px 10px;border-radius: 3px;background-color: rgb(0 184 255 / 31%);">Last Month Best Branch</span>
			</center>							
		</div>
		<div class="col-sm-12" style=""><!--min-height:900px;max-height:900px;overflow-y:scroll;-->
			<div class="row">
			<?php
				$number_count = 1;
				while($rank = mysqli_fetch_assoc($ranks)){ 
					$get_target = mysqli_fetch_assoc($mysqli->query("SELECT `target` from booking_monthly_target where branch_id = '".$rank['branch_id']."' and status = '1' and month like '%".$selected_month->format('m')."%' and year like '%".$selected_month->format('Y')."%'"));
					$oppupency_avg = mysqli_fetch_assoc($mysqli->query("SELECT AVG(occupency_number) as occupency_value from daily_ocupide_number where branch_id = '".$rank['branch_id']."' and data like '%".$selected_month->format('m/Y')."'"));

			?>				
				<div class="col-sm-12">
					<div class="our-team-main-right">	
						<?php
						if($number_count == $count){
							$style_variable = "background:#f00;color:#fff;";
						}else{
							$style_variable = "";
						}
						?>
						<div class="team-front-right" id="box1" style="float:left;<?= $style_variable; ?>">
							<span class="numbering1"><?= $number_count++; ?></span>
							<div style="width:50%;float:left;padding-top: 20px;">
								<h3 style="width:100%;overflow:hidden;"><?= $rank['full_name']; ?></h3>
								<p style="width:100%;overflow:hidden;"><?= $rank['branch_name']; ?></p>
								<p style="width:100%;overflow:hidden;">
									<span title="Target Booking">OT:</span> <b><?php echo (int)$get_target['target']; ?></b> | 
									<span title="Reached Booking">RO:</span> <b><?php echo (int)$oppupency_avg['occupency_value']; ?></b> | 
									<?php
										$target_result = $oppupency_avg['occupency_value'] / ($get_target['target'] / 100);
										if($target_result > 100){
											$target_result = 100;
										} 
									?>
									<span title="Reached Percentage">ROP:</span> <b><?php echo round($target_result,2); ?>%</b>
									<?php									
										if(80 < $target_result AND $target_result < 90 ){ // 80 - 90
											$background = '';
										} else if(60 < $target_result AND $target_result < 80 ){ // 60 - 80
											$background = 'bg-info';
										} else if(40 < $target_result AND $target_result < 60){  // 40 - 60
											$background = 'bg-warning';
										} else if(20 < $target_result AND $target_result < 40){  // 20 - 40+
											$background = 'bg-danger';
										} else { // 80 - 100+
											$background = 'bg-success';
										}
									?>
									<?php //echo $target_result; ?>
									<div class="progress" style="margin-top:15px;">
										<div class="progress-bar progress-bar-striped progress-bar-animated <?php if(!empty($background)){ echo $background; } ?>" role="progressbar" style="width: <?php echo round($target_result,2); ?>%" aria-valuenow="<?php echo round($target_result,2); ?>" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
								</p>
							</div>
							<div style="width:50%;float:left;">
								<img src="<?php echo $home.$rank['photo']; ?>" style="width: 150px; height: 150px;" class="img-fluid" />							
							</div>
						</div>
						
						<!-- <div class="team-back" id="box12">
							
						</div> -->
		
					</div>
				</div>
			<?php } ?>		
			</div>		
		</div>
	</div>
</div>



<style>
.numbering1{
	position: absolute;
    right: 20px;
    top: 129px;
    z-index: 99;
    color: #fff;
    font-size: 50px;
    font-weight: bolder;
}

.numbering23{
	position: absolute;
    left: 10px;
    bottom: 100px;
    color: #fff;
    font-weight: bolder;
	z-index:1;
}

#box1 {
    position: relative;
}

#box1::before,
#box1::after {
    content: '';
    position: absolute;
    bottom: 0;
    right: 0;
    border-color: transparent;
    border-style: solid;
}

#box1::before {
    border-width: 2.5em;
    border-right-color: #ccc;
    border-bottom-color: #ccc;
}

#box1::after {
    border-radius: 0.4em;
    border-width: 3.35em;
    border-right-color: #0c0;
    border-bottom-color: #0c0;
}



#box12::before,
#box12::after {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    border-color: transparent;
    border-style: solid;
}


#box12::after {
    border-radius: 0.4em;
    border-width: 5.35em;
    border-left-color: #ffc107;
    border-top-color: #ffc107;
}





.our-team-main-right
{
	width:100%;
	height:auto;
	border-bottom:5px #323233 solid;
	background:#fff;
	text-align:center;
	border-radius:10px;
	overflow:hidden;
	position:relative;
	transition:0.5s;
	margin-bottom:28px;
}


.our-team-main-right img
{
	border-radius:50%;
	margin-bottom:20px;
	width: 90px;
}

.our-team-main-right h3
{
	font-size:20px;
	font-weight:700;
}

.our-team-main-right p
{
	margin-bottom:0;
}

.team-back
{
	width:100%;
	height:auto;
	position:absolute;
	top:0;
	left:0;
	padding:5px 15px 0 15px;
	text-align:left;
	background:#fff;
	
}

.team-front-right
{
	width:100%;
	height:auto;
	position:relative;
	z-index:10;
	background:#fff;
	padding:15px;
	bottom:0px;
	transition: all 0.5s ease;
}

/* .our-team-main-right:hover .team-front-right
{
	bottom:-200px;
	transition: all 0.5s ease;
} */

/* .our-team-main-right:hover
{
	border-color:#777;
	transition:0.5s;
} */

/*our-team-main-right*/


</style>