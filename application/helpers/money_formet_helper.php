<?php
function money($money, $curr = '1', $sym = 'BDT'){
	$money = number_format(($money / $curr), 0, '.', ',');
	$formetted = $sym.' '.$money;
	return $formetted;
}

function money_f($money, $curr = '1', $sym = 'BDT'){
	$money = number_format(($money / $curr), 2, '<span style="color:#f00;">.</span>', ',');
	$formetted = $sym.' '.$money;
	return $formetted;
}
?>