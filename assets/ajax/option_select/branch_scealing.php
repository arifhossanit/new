<?php
error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['branch_info'])){ 
	$serial = array();
	$sale = array();
	$occupency = array();
	$food = array();
	$service = array();
	$house_keeper = array();
	$month = date('m/Y');
	$total_sale_value = 0;
	$house_keep_value = 0;
	$banch = $mysqli->query("select * from branches");	
	while($row = mysqli_fetch_assoc($banch)){
		if($row['id'] == '1'){}else{
			$total_sale_value = 0;
			$booking_info = $mysqli->query("select * from booking_info where branch_id = '".$row['branch_id']."' and count_reword = '' and data like '%".$month."%'");
			while($booked = mysqli_fetch_assoc($booking_info)){
				$package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$booked['package']."'"));
				$get_value = mysqli_fetch_assoc($mysqli->query("select * from sub_package_category where id = '".$package['sub_category_id']."'"));
				$total_sale_value = $total_sale_value + $get_value['booking_value'];
			}
			$bed_number = mysqli_fetch_array($mysqli->query("select  count(*) from beds where branch_id = '".$row['branch_id']."'"));
			$occupide_number = mysqli_fetch_array($mysqli->query("select count(*) from beds where uses in ('3','4') and branch_id = '".$row['branch_id']."'"));
			$bed_math = (float)$bed_number[0];
			$occupice_math = (float)$occupide_number[0];
			$occupide_percentage = round(($occupice_math * 100) / $bed_math, 2);
			$f_f_value = mysqli_fetch_assoc($mysqli->query("select AVG(feedback_value) as food_value from member_food_feedback where branch_id = '".$row['branch_id']."' and data like '%".$month."%'"));
			if($f_f_value['food_value'] > 0){
				$f_f_value = round($f_f_value['food_value'],2);
			}else{
				$f_f_value = 0;
			}
			$service_value = mysqli_fetch_assoc($mysqli->query("select AVG(rating_value) as service_value from whole_service_rating where branch_id = '".$row['branch_id']."' and data like '%".$month."%'"));
			if($service_value['service_value'] > 0){
				$service_value = round($service_value['service_value'],2);
			}else{
				$service_value = 0;
			}
			$house_keep_value = 0;
			$gt_house_k = $mysqli->query("select * from employee where role = '407277242147262618' and branch = '".$row['branch_id']."'");
			while($hkeep = mysqli_fetch_assoc($gt_house_k)){
				$rating_value = mysqli_fetch_assoc($mysqli->query("select AVG(value) as total_rating , count(*) as total_keeps from employee_rating where receiver_id = '".$hkeep['id']."' and data like '%".$month."%'"));
				$house_keep_value = $house_keep_value + ((float)$rating_value['total_rating'] / (float)$rating_value['total_keeps']);
			}
			if($house_keep_value > 0){
				$house_keep_value = round($house_keep_value,3);
			}else{
				$house_keep_value = 0;
			}
			
			$house_keeper[] = array('value' => $house_keep_value, 'name' => $row['branch_code']);
			$service[] = array('value' => $service_value, 'name' => $row['branch_code']);
			$food[] = array('value' => $f_f_value, 'name' => $row['branch_code']);
			$occupency[] = array('value' => $occupide_percentage, 'name' => $row['branch_code']);
			$sale[] = array('value' => $total_sale_value, 'name' => $row['branch_code']);
			$serial[] = array('serial' => $row['id']);
		}
	}

?>
<div class="row">
	<div class="col-sm-12 custom_table" style="font-weight: bold;">
		<div style="width:14.2857%;float:left;">
			<div style="width:100%;float:left;font-size: 19px;">Position</div>
			<?php
				$one = 1;
				foreach($serial as $row){
			?>
			<div style="width:100%;float:left;"><?php echo ordinal($one++); ?></div>
			<?php } ?>
		</div>
		
		<div style="width:14.2857%;float:left;">
			<div style="width:100%;float:left;font-size: 19px;">Sale</div>
			<?php
				rsort($sale);
				foreach($sale as $row){
			?>
			<div style="width:100%;float:left;"><?php echo $row['name']; ?> - <?php echo $row['value']; ?></div>
			<?php } ?>
		</div>
		<div style="width:14.2857%;float:left;">
			<div style="width:100%;float:left;font-size: 19px;">Occupency</div>
			<?php
				rsort($occupency);
				foreach($occupency as $row){
			?>
			<div style="width:100%;float:left;"><?php echo $row['name']; ?> - <?php echo $row['value']; ?></div>
			<?php } ?>
		</div>
		<div style="width:14.2857%;float:left;">
			<div style="width:100%;float:left;font-size: 19px;">Food</div>
			<?php
				rsort($food);
				foreach($food as $row){
			?>
			<div style="width:100%;float:left;"><?php echo $row['name']; ?> - <?php echo $row['value']; ?></div>
			<?php } ?>
		</div>
		<div style="width:14.2857%;float:left;">
			<div style="width:100%;float:left;font-size: 19px;">House Keeper</div>
			<?php
				rsort($house_keeper);
				foreach($house_keeper as $row){
			?>
			<div style="width:100%;float:left;"><?php echo $row['name']; ?> - <?php echo $row['value']; ?></div>
			<?php } ?>
		</div>
		<div style="width:14.2857%;float:left;">
			<div style="width:100%;float:left;font-size: 19px;">Service Rate</div>
			<?php
				rsort($service);
				foreach($service as $row){
			?>
			<div style="width:100%;float:left;"><?php echo $row['name']; ?> - <?php echo $row['value']; ?></div>
			<?php } ?>
		</div>
		<div style="width:14.2857%;float:left;font-size: 19px;">Cost Control</div>


	</div>
</div>
<style>
.custom_table div div{
	border:solid 1px #ccc;
	padding:5px;
}
</style>
<?php } ?>