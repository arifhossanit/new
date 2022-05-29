<?php
include("../../../application/config/ajax_config.php");
include("../engine/mikrotik/routeros_api.class.php");
?>
<html>
	<body oncontextmenu="return false;">
		<iframe src="<?php echo $home; ?>assets/router_configuration/ajax/router_auto_login_webfig.php?ip=<?php echo $_GET['ip']; ?>&user=<?php echo $_GET['user']; ?>&pass=<?php echo $_GET['pass']; ?>" style="border:none;width:100%;height:750px;">
		</iframe>
	</body>
</html>