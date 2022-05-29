<?php
//error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['view_id'])){ 
	$login = mysqli_fetch_assoc($mysqli->query("select * from login_info where id = '".$_POST['view_id']."'"));
	$employee = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id like '%".$login['employee_id']."'"));

?>
<div class="row">
	<div class="col-sm-12">
		<div style="text-align:left;padding:15px;">	
			Time: <b> <?php echo $login['time']; ?></b><br />
			IP Address: <b><?php echo $login['ip_address']; ?></b> <br />
			Name: <b><?php if(!empty($employee['full_name'])){ echo $employee['full_name']; } else{ echo 'Not found!';} ?></b> <br />		
				
		</div>
	</div>
	<hr style="margin:0px;padding:0px;border:solid 0.5px #eee;width:100%;"/>
	<div class="col-sm-12">			
		<blockquote>
			<?php
				echo find_link($login['device_info']);
			?>
		</blockquote>
		</div>
	</div>
</div>
<?php } ?>