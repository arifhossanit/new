<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['acval'])){
	$branch_id = $_POST['branch_id'];
?>
					<ul style="list-style:none;margin:0px;padding:0px;">
<?php
$r_date = date('d');
$r_month = date('m');
$r_year = date('Y');
$r_minute = date('i');
$r_hour = date('h');
$r_apm = date('a');
$hm = $r_hour.$r_minute;
if($hm >= '0700' AND $hm <= '1030' AND $r_apm == 'am'){
	$qql = $mysqli->query("select * from member_meal where dats = '".$r_date."' AND month = '".$r_month."' AND year = '".$r_year."' AND breakfast = '1' AND branch_id = '".$branch_id."' order by id desc");
}else if ($hm >= '0100' AND $hm <= '0400' AND $r_apm == 'pm'){
	$qql = $mysqli->query("select * from member_meal where dats = '".$r_date."' AND month = '".$r_month."' AND year = '".$r_year."' AND lunch = '1' AND branch_id = '".$branch_id."' order by id desc");
}else if ($hm >= '0800' AND $hm <= '1030' AND $r_apm == 'pm'){
	$qql = $mysqli->query("select * from member_meal where dats = '".$r_date."' AND month = '".$r_month."' AND year = '".$r_year."'  AND dinner = '1' AND branch_id = '".$branch_id."' order by id desc");
}else{
$qql = $mysqli->query("select * from member_meal where year = '1000'"); // 
}

while($row = mysqli_fetch_assoc($qql)){
$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."'"));
$package = mysqli_fetch_assoc($mysqli->query("SELECT count(*) as total from packages where package_category_name LIKE '%vip%' AND id = ".$mem['package']));
if($package['total'] > 0){
	$background = '#5e35b1';
	$color = 'color:#fff;';
}else{
	$background = '#eee';
	$color = 'color:#f00;';
}
?>					
						<li style="width:100%;padding-top:5px;padding-bottom:5px;border-bottom:solid 1px #e0e0e0;float:left;background-color:<?=$background?>;">
							<div style="width:100%;float:left;overflow:hidden">
								<div class="row">
									<div class="col-md-2">
										<img src="<?=$home.$mem['photo_avater']?>" alt="" width="50px">
										<?php if($package['total'] > 0){ ?>
											<img src="<?=$home.'assets/img/vip_food.jpg'?>" alt="" width="50px">
										<?php }?>
									</div>
									<div class="col-md-10">
										<h3 style="margin:0px;text-align:center;line-height:21px;font-size:22px;height:21px;overflow:hidden;font-weight: bolder;letter-spacing: -1px;<?=$package['total'] > 0 ? $color : '' ?>">
											<?php echo $mem['full_name']; ?>
										</h3>
										<h4 style="margin:0px;text-align:center;line-height:27px;font-size:20px;<?=$color?>;"><?php echo $mem['card_number']; ?></h4>
									</div>
								</div>
							</div>
						</li>
<?php } ?>
					</ul>

<?php
}
?>

<?php /* ?>
<div style="width:30%;float:left;">
	<?php if(!empty($mem['photo_avater'])){ ?>
		<?php if(url_check($home.$mem['photo_avater'])){ ?>
		<img src="<?php echo $home.$mem['photo_avater']; ?>" style="width:100%;" class="image-responsive"/>
		<?php }else{ ?>
		<img src="<?php echo $home.'assets/img/empty-user-xl.png'; ?>" style="width:100%;" class="image-responsive"/>
	<?php } }else{ ?>
		<img src="<?php echo $home.'assets/img/empty-user-xl.png'; ?>" style="width:100%;" class="image-responsive"/>
	<?php } ?>
</div>
<?php */ ?>