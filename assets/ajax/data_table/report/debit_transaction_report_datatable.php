<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'transaction';
$primaryKey = 'id';
if(isset($_GET['branch_id'])){
	if($_GET['branch_id'] == 1){
		$branch_id = "";
	}else{
		$branch_id = " AND branch_id = '".$_GET['branch_id']."'";
	}	
}else{
	$branch_id = "";
}
if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);	
	$one_ymd = explode('/',$one[0]);
	$two_ymd = explode('/',$one[1]);
	$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
	$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
	$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";	
}else{
	$date_filter = "";
}
$where = "status = '1' AND transaction_type = 'Debit' $branch_id $date_filter";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'transaction_id',   'dt' => 1 ),
	array(
		'db' => 'branch_id',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$d."'"));
				if(!empty($branch['branch_name'])){
					return $branch['branch_name'];	
				}					
			}
		}
	),
    array( 'db' => 'careof',    'dt' => 3 ),
	array(
		'db' => 'amount',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				return '<span style="color:#a50000;font-weight:bolder;">'.money($d).'</span>';
			}else{
				return '0';
			}
		}
	),	
    array( 'db' => 'date',    'dt' => 5 ),	
    array(
		'db' => 'transaction_type',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			if($d == 'Credit'){
				return '<button type="butoon" class="btn btn-xs btn-success">'.$d.'</button>';
			}else{
				return '<button type="butoon" class="btn btn-xs btn-danger">'.$d.'</button>';
			}
		}
	),
	array( 'db' => 'transaction_category',    'dt' => 7 ),	
	array(
		'db' => 'uploader_info',
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					return ''.$u[0].' ('.$u[1].')';
				}
			}	
		}
	),
	array( 'db' => 'data',    'dt' => 9 ),
	array(
        'db'        => 'id',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
            return '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button onclick="return view_transaction_report('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
				</form>
			';
        }
    ),
	array(
        'db'        => 'booking_id',
        'dt'        => 11,
		'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$profile_id = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			if(!empty($profile_id)){
            	return '<button onclick="return view_member_profile(\''.$profile_id['id'].'\')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>';
			}
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>