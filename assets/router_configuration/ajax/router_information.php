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
		$info		 		= $router_api->comm("/system/resource/print");  
		$ram_free		 	= $info['0']['free-memory']/1048576;
		$total_ram	 		= $info['0']['total-memory']/1048576;
		$hdd		 		= $info['0']['free-hdd-space']/1048576;		
		$total_hdd   		= $info['0']['total-hdd-space']/1048576;
		$used_hdd    		= $total_hdd - $hdd;
		$cpu		 		= $info['0']['cpu-load'];
		$uptime		 		= $info['0']['uptime'];
		$device_name 		= $info['0']['platform'];
		$generation  		= $info['0']['board-name'];
		$version 	 		= $info['0']['version'];
		$generation_cpu  	= $info['0']['cpu'];
		$core		 		= $info['0']['cpu-count'];
		$frequency	 		= $info['0']['cpu-frequency'];
		$architecture	 	= $info['0']['architecture-name'];
		$build_time	 		= $info['0']['build-time'];

		  
		  

?>
<div class="row">
	<div class="col-sm-12">
		<table class="table table-sm table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Information</th>
					<th>#</th>
					<th>Information</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Branch</td>
					<td><?php echo $branch['branch_name']; ?></td>
					<td>Name</td>
					<td><?php echo $row['router_name']; ?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><?php echo $row['router_id_address']; ?></td>
					<td>Status</td>
					<td>
						<?php 
							if($row['status'] == 1){
								echo '<button type="button" class="btn btn-xs btn-success">Enabled</button>';
							}else{
								echo '<button type="button" class="btn btn-xs btn-danger">Disabled</button>';
							}
						?>
					</td>
				</tr>
				<tr>
					<td>Connection</td>
					<td>
						<?php
							if($router_conn){
								echo '<button type="button" class="btn btn-xs btn-success">Connected</button>';								
							}else{
								echo '<button type="button" class="btn btn-xs btn-danger">Disconnected</button>';
							}
						?>
					</td>
					<td>CPU</td>
					<td><?php echo round($cpu,2); ?>%</td>
				</tr>
				<tr>
					<td>Free RAM</td>
					<td><?php echo round($ram_free,2); ?> MB</td>
					<td>Total RAM</td>
					<td><?php echo round($total_ram,2); ?> MB</td>
					
				</tr>
				<tr>
					<td>Free HDD</td>
					<td><?php echo round($hdd,2); ?> MB</td>
					<td>Use HDD</td>
					<td><?php echo round($used_hdd,2); ?> MB</td>
				</tr>
				<tr>
					<td>Total HDD</td>
					<td><?php echo round($total_hdd,2); ?> MB</td>
					<td>Uptime</td>
					<td><?php echo $uptime; ?></td>
				</tr>
				<tr>
					<td>Device Name</td>
					<td><?php echo $device_name; ?></td>
					<td>Version</td>
					<td><?php echo $version; ?></td>
				</tr>
				<tr>					
					<td>Generation</td>
					<td><?php echo $generation; ?></td>
					<td>CPU Generation</td>
					<td><?php echo $generation_cpu; ?></td>
				</tr>
				<tr>					
					<td>CPU Core</td>
					<td><?php echo $core; ?></td>
					<td>Frequency</td>
					<td><?php echo $frequency; ?></td>
				</tr>
				<tr>					
					<td>Architecture</td>
					<td><?php echo $architecture; ?></td>
					<td>Build Time</td>
					<td><?php echo $build_time; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php } } ?>