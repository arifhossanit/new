<?php
include("../../../application/config/ajax_config.php");
include("../engine/mikrotik/routeros_api.class.php");
if(isset($_POST['router_id'])){
	ob_start();
	$router_api = new routeros_api();
	$row = mysqli_fetch_assoc($mysqli->query("select * from router_configuration where id = '".$_POST['router_id']."'"));
	$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch_id']."'"));
	$router_conn = $router_api->connect($row['router_id_address'], $row['router_name'], $row['router_password']);
	if(!$router_conn){
		echo 'Router Is not Connected';
	}else{
?>
<div class="row">
	<div class="col-sm-12">
		<iframe src="<?php echo $home; ?>assets/router_configuration/ajax/router_auto_login_webfig_home.php?ip=<?php echo $row['router_id_address']; ?>&user=<?php echo $row['router_name']; ?>&pass=<?php echo $row['router_password']; ?>" style="border:none;width:100%;height:750px;" scrolling="no">
		</iframe>
	</div>
</div>
<?php } } ?>