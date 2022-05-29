<?php
	if(isset($_POST['add_router'])){
		$check_ip_address = mysqli_fetch_assoc($mysqli->query("select * from router_configuration where router_id_address = '".$_POST['router_id_address']."'"));
		if(!empty($check_ip_address['router_id_address'])){
			echo "<script>alert('Router Ip Address All ready exixt! Please try again!')</script>";
		}else{
			$check_router_name = mysqli_fetch_assoc($mysqli->query("select * from router_configuration where router_name = '".$_POST['router_name']."'"));
			if(!empty($check_router_name['router_name'])){
				echo "<script>alert('Router Name All ready exixt! Please try again!')</script>";
			}else{
				if($mysqli->query("insert into router_configuration values(
					'',
					'".$_POST['branch_id']."',
					'".$_POST['router_id_address']."',
					'".$_POST['router_password']."',
					'".$_POST['router_name']."',					
					'".$_POST['note']."',
					'".$_POST['status']."',
					'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
					'".date('d/m/Y')."'
				)")){
					echo "<script>alert('Router Added Successfully')</script>";
					echo "<script>window.open('index.php','_self')</script>";
				}else{
					echo "<script>alert('Something wrong! Please Try again')</script>";
					echo "<script>window.open('index.php','_self')</script>";
				}
			}
		}
	}
	//delete router_configuration
	if(isset($_GET['delete_router'])){
		$id = $_GET['delete_router'];
		if($mysqli->query("delete from router_configuration where id = '".$id."'")){
			echo "<script>alert('Router Delete Successfully')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}else{
			echo "<script>alert('Something wrong! Please Try again')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}	
	}
	//edit informtion
	if(isset($_GET['edit_router'])){
		$id = $_GET['edit_router'];
		$edit = mysqli_fetch_assoc($mysqli->query("select * from router_configuration where id = '".$id."'"));
	}
	//update information
	if(isset($_POST['update_router'])){
		if($mysqli->query("update router_configuration set
			branch_id = '".$_POST['branch_id']."',
			router_id_address = '".$_POST['router_id_address']."',
			router_password = '".$_POST['router_password']."',
			router_name = '".$_POST['router_name']."',
			note = '".$_POST['note']."',
			status = '".$_POST['status']."'
			where id = '".$_POST['update_id']."'
		")){
			echo "<script>alert('Router Update Successfully')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}else{
			echo "<script>alert('Something wrong! Please Try again')</script>";
			echo "<script>window.open('index.php','_self')</script>";
		}
	}
?>





















