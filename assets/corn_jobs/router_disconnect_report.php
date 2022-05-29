<?php 
include("../../application/config/ajax_config.php");
include("../../assets/router_configuration/engine/mikrotik/routeros_api.class.php");
ob_start();
$router_api = new routeros_api();
$sql = $mysqli->query("select * from router_configuration order by id desc");
while( $row = mysqli_fetch_assoc($sql)){
	$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$row['branch_id']."'"));
	$router_connection = $router_api->connect($row['router_id_address'], $row['router_name'], $row['router_password']);
	if($router_connection){ }else{
		$branch_name = $branch['branch_name'];
		$ip_address = $row['router_id_address'];
		$router_name = $row['router_name'];
		$number = '01719372034';
		$message = 'ALERT!: Router Disconnected! Info: Branch: '.$branch_name.', Router Name: '.$router_name.', IP Address: '.$ip_address.', Time: '.date('d/m/Y - h:i:sA').'';
		//sendsms($number, $message);
	}
}
?>