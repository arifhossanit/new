<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['year'])){
	echo date('Y-m-d', strtotime( date('Y-m-d') . ' + ' . (int)$_POST['year'] . ' Years' ));
}
?>