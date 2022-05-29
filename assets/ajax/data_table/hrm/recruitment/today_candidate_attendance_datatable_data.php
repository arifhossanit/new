<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");
if(!empty($_GET['check_date'])){
	$dt = explode('-',$_GET['check_date']);
	$chk_date = $dt[2].'/'.$dt[1].'/'.$dt[0];
	$condition_date = "and data = '".$chk_date."'";
}else{
	$condition_date = "";
}
$table = 'visitor_book';
$primaryKey = 'id';
$where = "reason  = 'Candidate' $condition_date";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'name',   'dt' => 1 ),
	array( 
		'db' => 'phone', 
		'dt' => 2,
		'formatter' => function($d,$row){			
			return '<a href="tel:'.$d.'">'.$d.'</a>';
		}
	),
    array( 'db' => 'department',   'dt' => 3 ),
    array( 'db' => 'designation',   'dt' => 4 ),
    array( 'db' => 'In_time',   'dt' => 5 ),
    array( 'db' => 'data',   'dt' => 6 ),	
    array( 
		'db' => 'id', 
		'dt' => 7,
		'formatter' => function($d,$row){
			global $home;
			global $mysqli;
			$check_can = mysqli_fetch_assoc($mysqli->query("select * from visitor_book where id = '".$d."'"));
			if($check_can['status'] == '1'){
				return '
					<form name="candiadate_form_'.$d.'" action="#" method="post">
						<input type="hidden" name="hidden_id" value="'.$d.'"/>
						<input type="text" name="note" class="form-control" placeholder="Note" autocomplete="off" style="margin-bottom:3px;padding: 0px; font-size: 12px; line-height: 12px; height: 22px;padding-left:5px;padding-right:5px;"/>
						<ul class="star_list">
							<li><label>Decline&nbsp;<input type="radio" name="star_mark" value="0" required/></label></li>
							<li><label>1&nbsp;<input type="radio" name="star_mark" value="1" required/></label></li>
							<li><label>2&nbsp;<input type="radio" name="star_mark" value="2" required/></label></li>
							<li><label>3&nbsp;<input type="radio" name="star_mark" value="3" required/></label></li>
							<li><label>4&nbsp;<input type="radio" name="star_mark" value="4" required/></label></li>
							<li><label>5&nbsp;<input type="radio" name="star_mark" value="5" required/></label></li>
							<li style="padding:0px;"><button onclick="return accept_function('.$d.')" class="btn btn-xs btn-success candidate_submit" type="button" style="margin-top: -4px;">Submit</button></li>						
						</ul>						
					</form>
				';
			}else{
				return '
					<button class="btn btn-xs btn-info" type="button">Checked</button>
				';
			}
			
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>