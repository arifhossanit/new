<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
$sql = $mysqli->query("select * from member_directory where status = '1'");
$book_id = '';
while($row = mysqli_fetch_assoc($sql)){
	$rent_info = mysqli_fetch_array($mysqli->query("select count(*) from rent_info where booking_id = '".$row['booking_id']."' order by id desc"));
	if($rent_info[0] > 1 ){
		$book_id .= "'".$row['booking_id']."',";
	}
}
$booking_id = rtrim($book_id,',');

$table = 'rent_info';
$primaryKey = 'id';
if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin')){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND ";
	}
}else{
	$branch_user = "";
}
$where = "booking_id IN (".$booking_id.") AND data_three = 'renew' AND status = '1' AND rent_status = 'Paid' AND data = '".date('d/m/Y')."'";
$columns = array(
    array( 'db' => 'm_name',   'dt' => 0 ),
    array( 'db' => 'data',   'dt' => 1 ),
	array( 
		'db' => 'booking_id',
		'dt' => 2,
		'formatter' => function($d, $row){
			global $mysqli;
            $mem = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$d."'"));
			if(!empty($mem['checkin_date'])){
				return $mem['checkin_date'];
			}else{
				return '';
			}
			
		} 
	),
	array( 'db' => 'package_category_name',     'dt' => 3 ),
    array( 'db' => 'package_name',     'dt' => 4 ),
	array( 'db' => 'branch_name',   'dt' => 5 ),
	array( 
		'db' => 'booking_id',
		'dt' => 6,
		'formatter' => function($d, $row){
			global $mysqli;
            $mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			if(!empty($mem['h_t_f_u'])){
				return $mem['h_t_f_u'];
			}else{
				return '';
			}
			
		} 
	),
	array( 
		'db' => 'booking_id',
		'dt' => 7,
		'formatter' => function($d, $row){
			global $mysqli;
            $mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			if(!empty($mem['occupation'])){
				return $mem['occupation'];
			}else{
				return '';
			}
			
		} 
	),	
	array(
        'db'        => 'id',
        'dt'        => 8,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
            $data = '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>';
					$data .= '<button onclick="return view_rental_recipt('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>';
				$data .= '</form>';
			return $data;
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>