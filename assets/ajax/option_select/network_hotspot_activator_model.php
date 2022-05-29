<?php
if(isset($_POST['booking_id'])){
	include("../../../application/config/ajax_config.php");
	include("../../../assets/router_configuration/engine/mikrotik/routeros_api.class.php");
	ob_start();
	$api = new routeros_api();
	$booking_id = $_POST['booking_id'];
	$mem_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$booking_id."'"));
	$branch_id = $mem_info['branch_id'];
	$router_db = mysqli_fetch_assoc($mysqli->query("select * from router_configuration where branch_id = '".$branch_id."'"));
	if(empty($router_db['router_id_address'])){
		echo '
			<center>
				<h2>Router not configure yet! Please contact with IT Department</h2>
			</center>
		';
	}else{
		$conn = $api->connect($router_db['router_id_address'], $router_db['router_name'], $router_db['router_password']);
		if(!$conn){
			echo '
				<center>
					<h2>Router ('.$router_db['router_id_address'].') not Disconnected! Please contact with IT Department</h2>
				</center>
			';
		}else{
			$profile = $api->comm("/ip/hotspot/user/profile/print");
			if($mem_info['card_number'] == 'Unauthorized'){
				echo '
					<center>
						<h2>Member is Unauthorized!</h2>
					</center>
				';
			}else{
				$check_member_status = mysqli_fetch_assoc($mysqli->query("select * from member_network_manage where booking_id = '".$booking_id."'"));
				if(!empty($check_member_status['username'])){
		
?>
<div class="row">
	<div class="col-sm-12">
		<center>
			<button onclick="return get_this_member_deactive('<?php echo $mem_info['booking_id']; ?>')" type="button" class="btn btn-danger">Deactive User</button>
		</center>
	</div>
</div>
<?php 			}else{ ?>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6 custom_css_network">
				<div class="form-group">
					<label>Name</label>
					<input type="text" id="router_name" value="<?php echo $mem_info['full_name']; ?>" class="form-control" readonly />
				</div>
				<div class="form-group">
					<label>Username</label>
					<input type="text" id="router_username" value="<?php echo $mem_info['phone_number']; ?>" class="form-control" readonly />
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="text" id="router_password" value="<?php echo $mem_info['card_number']; ?>" class="form-control" readonly />
				</div>
				<div class="form-group">
					<label>User Profile</label>
					<select id="router_user_profile" class="form-control select2">
						<option value="">--select--</option>
						<?php
							foreach($profile as $row){
								echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
							}
						?>					
					</select>
				</div>
				<div class="form-group">
					<label>Note</label>
					<textarea id="router_note" class="form-control" placeholder="Note"></textarea>
				</div>
				<div class="form-group" style="margin-top:20px;">
					<center>
						<button onclick="return get_this_member_active('<?php echo $mem_info['booking_id']; ?>')" type="button" class="btn btn-success">Active User</button>
					</center>					
				</div>
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>
</div>		
<?php 
				}
			}
		} 
	}
?>
<style>
.custom_css_network label{
	margin-bottom:0px;
}
.custom_css_network .form-group{
	margin-bottom:3px;
}	
</style>
<script>
$(function(){
	$(".select2").select2();
})
</script>
<?php
}
if(isset($_POST['booking_id_active'])){
	include("../../../application/config/ajax_config.php");
	include("../../../assets/router_configuration/engine/mikrotik/routeros_api.class.php");
	ob_start();
	$api = new routeros_api();
	$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$_POST['booking_id_active']."'"));
	$branch_id = $member['branch_id'];
	$router = mysqli_fetch_assoc($mysqli->query("select * from router_configuration where branch_id = '".$branch_id."'"));
	$conn = $api->connect($router['router_id_address'], $router['router_name'], $router['router_password']);
	$name = $member['full_name'];
	$username = $member['phone_number'];
	$password = $member['card_number'];
	$profile = $_POST['profile'];
	$note = $_POST['note'];
	if(!$conn){
		echo 'Router Not Connected Correctly! Please try again';
	}else{
		if($api->comm("/ip/hotspot/user/add", array(
			"name"     => $username,
			"password" => $password,	
			"profile"  => $profile,
			"comment"  => $note	
		))){
			if($mysqli->query("insert into member_network_manage values(
				'',
				'".$branch_id."',
				'".$member['booking_id']."',
				'".$name."',
				'".$username."',
				'".$password."',
				'".$profile."',
				'".$note."',
				'1',
				'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
				'".date('d/m/Y')."'
			)")){
				echo 'Member Hotspot Active successfully';
			}else{
				echo 'Something Wrong! Please Try again';
			}
		}else{
			echo 'Something Wrong In Router! Please Try again';
		}
	}
}
if(isset($_POST['booking_id_deactive'])){
	include("../../../application/config/ajax_config.php");
	include("../../../assets/router_configuration/engine/mikrotik/routeros_api.class.php");
	ob_start();
	$api = new routeros_api();
	$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$_POST['booking_id_deactive']."'"));
	$branch_id = $member['branch_id'];
	$router = mysqli_fetch_assoc($mysqli->query("select * from router_configuration where branch_id = '".$branch_id."'"));
	$conn = $api->connect($router['router_id_address'], $router['router_name'], $router['router_password']);
	$username = $member['phone_number'];
	if(!$conn){
		echo 'Router Not Connected Correctly! Please try again';
	}else{
		if($mysqli->query("delete from member_network_manage where booking_id = '".$member['booking_id']."'")){
			$api->comm("/ip/hotspot/user/remove", array(
				"numbers" => $username
			));
			echo 'Member Hotspot Deactive successfully';
		}else{
			echo 'Something Wrong! Please Try again';
		}
	}
}
?>