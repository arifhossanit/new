<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['bed_type'])){ 
	$sql = $mysqli->query("select * from floors where branch_id = '".$_POST['branch_id']."' order by floor_name asc"); 
		$i = 0;
?>
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
	if($bed['ipo_uses'] == 1 ){		
?>
													<button class="btn btn-danger" id="" type="button" style="width:100%;margin-bottom:10px;">
														<?php echo $bed['bed_name']; ?>
													</button>

<?php  
   }else{ 
		if($bed['status'] == 1){
			if($bed['ipo_uses'] == 0 ){
?>
													<button onclick="return get_bet_info(<?php echo $bed['id']; ?>)" class="btn btn-info" id="" type="button" style="width:100%;margin-bottom:10px;"><?php echo $bed['bed_name']; ?></button>
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


<?php } ?>