<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['branch_id'])){
	$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$_POST['branch_id']."' and status = '1'"));
	if($_POST['room_type'] == '1'){
		$room_type = "";
	}else{
		$room_type = " and note = '".$_POST['room_type']."'";
	}
?>
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
		<center>
			<h1><i class="far fa-building"></i> Branch: <b><?php echo $branch_info['branch_name']; ?></b></h1>
			<?php if($_POST['room_type'] != 1 ){ ?><h3><?php echo $_POST['room_type']; ?></h3><?php } ?>
		</center>
<?php
$ful = $mysqli->query("select * from floors where branch_id = '".$branch_info['branch_id']."' and status = '1' order by floor_name desc");
while($floor_info = mysqli_fetch_assoc($ful)){
	$rom = mysqli_fetch_assoc($mysqli->query("select * from rooms where floor_id = '".$floor_info['id']."' $room_type"));
	$bed_check = mysqli_fetch_array($mysqli->query("select count(*) from beds where status = '1' and floor_id = '".$floor_info['id']."' and room_id = '".$rom['id']."' and uses not in('5','6') "));
	if($bed_check[0] > 0 ){
?>
		<div class="card card-primary" style="border:solid 1px #333;">
            <div class="row">
				<div class="col-sm-1" style="">
					<div class="card-header">
						<h3 class="card-title"><b><?php echo $floor_info['floor_name']; ?></b> <?php if(!empty($floor_info['note'])){ echo '- '.$floor_info['note']; } ?></h3>
					</div> 
					<div class="row">
						<div class="col-sm-12">
							<ul class="bed_color_info">
<?php
$Available = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND ipo_uses = '0' AND status = '1'"));
$Sold = mysqli_fetch_array($mysqli->query("SELECT COUNT(*) FROM beds WHERE floor_id = '".$floor_info['id']."' AND ipo_uses = '1' AND status = '1'"));
?>							
								<?php if( $Available[0] > 0){ ?><li><div class="badge badge-success">Available (<?php echo $Available[0]; ?>)</div></li><?php } ?>
								<?php if( $Sold[0] > 0){ ?><li><div class="badge badge-danger" style="border: solid 1px #cecece;">Sold (<?php echo $Sold[0]; ?>)</div></li><?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-11">         
					<form role="form" style="padding:0px;">
						<div class="card-body" style="padding:0px;">
							<div class="row">
<?php
$unt = $mysqli->query("select * from units where floor_id = '".$floor_info['id']."' and status = '1'");
while($unit_info = mysqli_fetch_assoc($unt)){
?>
								<div class="col-sm-6">								
									<div class="card card-warning">
										<div class="row">
											<div class="col-sm-1">
												<div class="card-header">
													<h3 class="card-title"><b><?php echo $unit_info['unit_name']; ?></b> <?php if(!empty($unit_info['note'])){ echo '- '.$unit_info['note']; } ?></h3>
												</div>  
											</div>
											<div class="col-sm-11">														
												<form role="form">
													<div class="card-body" style="padding:0px;">
														<div class="row">
<?php
$sql3 = $mysqli->query("select * from rooms where unit_id = '".$unit_info['id']."' $room_type");
while($room = mysqli_fetch_assoc($sql3)){
?>
														<div class="col-sm-6">
															<div class="card card-dark">
																<div class="card-header">
																	<h3 class="card-title" style="font-size:14px;">Room:- <?php echo $room['room_name']; ?><?php if(!empty($room['note'])){ echo ' - '.$room['note']; } ?></h3>
																</div>
																<div class="card-body" style="padding-left:1px;padding-right:1px;">
																	<div class="row">
																	
																	
<?php
$sq_com = $mysqli->query("select * from column_list where room_id = '".$room['id']."'");
while($col = mysqli_fetch_assoc($sq_com)){
?>													
																	<div class="col-sm-2" style="">
<?php
$sql4 = $mysqli->query("select * from beds where uses not in('5','6') and room_id = '".$room['id']."' and coloumn_id = '".$col['id']."'");
while($bed = mysqli_fetch_assoc($sql4)){
	if($bed['ipo_uses'] == '1'){
?>		
																		<button onclick="return view_member_profile()" class="btn btn-danger btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;height:23px;">
																			<marquee>
																				Sold-<?php echo $bed['bed_name']; ?>
																			</marquee>
																		</button>
<?php }else{ ?>
																		<button onclick="return bed_add_quantity_form(<?php echo $bed['id']; ?>)" class="btn btn-success btn-xs" id="" type="button" style="width:100%;margin-bottom:10px;"><?php echo substr($bed['bed_name'],4); ?></button>
<?php	}

} ?>
																	</div>
<?php } ?>
																</div>
																			
<?php
$msg = mysqli_fetch_assoc($mysqli->query("select * from beds where room_id = '".$room['id']."'"));
if(empty($msg['id'])){
	echo '<h3 class="" style="text-align:center;">Bed Not Available!</h3>';
}
?>												
																</div>
															</div>
														</div>
<?php } ?>
														</div>
													</div>
												</form>
											</div>
										</div>
										
									</div>
									
									
									
								</div>
<?php } ?>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>		
<?php } } ?>
	</div>
</div>
<?php } ?>