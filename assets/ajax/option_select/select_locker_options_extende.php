<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['locker_type'])){ 
unset($_SESSION["cart_locker"]);
?>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
<?php
$sql = $mysqli->query("select * from manage_locker where locker_type = '".$_POST['locker_type']."'");
while($row = mysqli_fetch_assoc($sql)){
	$in_session = "0";
	if(!empty($_SESSION["cart_locker"])) {
		$session_code_array = array_keys($_SESSION["cart_locker"]);
		if(in_array($row['id'],$session_code_array)) {
			$in_session = "1";
		}
	}
?>		
			<div class="col-sm-4">
				<?php
				if($row['uses'] == '2'){ ?>
					<a href="javascript:void(0)" type="button" class="btn btn-default btn-sm" style="width:100%;margin-bottom:5px;"><?php echo $row['locker_number']; ?> &nbsp;<i class="fas fa-user-lock"></i></a>
				<?php }else if($row['uses'] == '3'){ ?>
					<a href="javascript:void(0)" type="button" class="btn btn-warning btn-sm" style="width:100%;margin-bottom:5px;"><?php echo $row['locker_number']; ?> &nbsp;<i class="fas fa-user-lock"></i></a>
				<?php }else if($row['uses'] == '4'){ ?>
					<a href="javascript:void(0)" type="button" class="btn btn-danger btn-sm" style="width:100%;margin-bottom:5px;"><?php echo $row['locker_number']; ?> &nbsp;<i class="fas fa-user-lock"></i></a>
				<?php }else{ ?>
				<a href="javascript:void(0)" id="add_add_<?php echo $row['id']; ?>" onclick="return cartAction('add','add_<?php echo $row['id']; ?>')" type="button" class="btnAddAction btn btn-info btn-sm" style="width:100%;margin-bottom:5px;<?php if($in_session != "0") { ?>display:none;<?php } ?>"><?php echo $row['locker_number']; ?> &nbsp;<i class="fas fa-user-lock"></i></a>
				<a href="javascript:void(0)" id="added_add_<?php echo $row['id']; ?>" onClick="return cartAction('remove','add_<?php echo $row["id"]; ?>')" type="button" class="btnAdded btnRemoveAction cart-action btn btn-dark btn-sm" style="width:100%;margin-bottom:5px;<?php if($in_session != "1") { ?>display:none;<?php } ?>" disable><?php echo $row['locker_number']; ?> &nbsp;<i class="fas fa-user-lock"></i></a>
				<?php } ?>
			</div>
<?php } ?>		
		</div>
	</div>
	
</div>

<?php } ?>