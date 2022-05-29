<?php 
	include("include/dashboard.elements/css.elements.php");
	if (isset($_SESSION['message_time']) && (time() - $_SESSION['message_time'] > 03)) {unset($_SESSION['alert_message']);}
	if(!empty($_SESSION['alert_message'])){echo $_SESSION['alert_message'];}
	echo '<div id="toast"></div>';
	echo '<div class="wrapper animate-bottom" id="myDiv___iiijjggg____uujikj">';
	if(!empty($header)){ echo $header; }
	if(!empty($nav)){ echo $nav; }
	if(!empty($nav1)){ echo $nav1; }
	if(!empty($article)){ echo $article; }
	if(!empty($footer)){ echo $footer; }	
	echo '</div>';
	include("include/dashboard.elements/modals.php");
	include("include/dashboard.elements/js.php");
	include("include/dashboard.elements/scripts.php");	
?>

