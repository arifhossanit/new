<?php
include("../../../application/config/ajax_config.php");
$branch_id = $_POST['branch_id'];
$petty_cash_limit = mysqli_fetch_assoc($mysqli->query("SELECT petty_cash_limit from branches where branch_id = '".$branch_id."'"));
echo $petty_cash_limit['petty_cash_limit'];