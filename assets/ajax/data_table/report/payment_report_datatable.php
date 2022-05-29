<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'payment_received_method';
$primaryKey = 'id';

if(!empty($_GET['user_type'])){
	if($_GET['user_type'] == rahat_encode('Super Admin')){
		$branch_user = "";
	}else{
		$branch_user = "branch_id = '".rahat_decode($_GET['branch_id'])."' AND";
	}
}else{
	$branch_user = "";
}
if(!empty($_GET['booking_from'])){
	$b_f = explode('-',$_GET['booking_from']);
	$booking_from = $b_f[2].'/'.$b_f[1].'/'.$b_f[0];
}else{
	$booking_from = '';
}

if(!empty($_GET['booking_to'])){
	$b_t = explode('-',$_GET['booking_to']);
	$booking_to = $b_t[2].'/'.$b_t[1].'/'.$b_t[0];
}else{
	$booking_to = '';
}


if($booking_from != '' AND $booking_to != ''){
	$booking = " AND data BETWEEN '".$booking_from."' AND '".$booking_to."' ";
}else{
	if($booking_from != ''){
		$booking = " AND data = '".$booking_from."' ";
	}else if($booking_to != ''){
		$booking = " AND data = '".$booking_to."' ";
	}else{
		$booking = "";
	}
}
$condition = "".$booking."";
$where = "".$branch_user." status = '1' ".$condition.""; //
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
    array(
		'db' => 'branch_id',
		'dt' => 1,
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
	array(
		'db' => 'invoice_number',
		'dt' => 2,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				return '<span style="color:#28a745;font-weight:bolder;">#'.$d.'</span>';
			}
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 3,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem['full_name'])){
					return $mem['full_name'];	
				}					
			}
		}
	),
	array(
		'db' => 'booking_id',
		'dt' => 4,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				global $mysqli;
				$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
				if(!empty($mem['card_number'])){
					return $mem['card_number'];	
				}					
			}
		}
	),
	array( 'db' => 'payment_method',   'dt' => 5 ),
	array(
		'db' => 'details',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				return $d;
			}else{
				return '';
			}
		}
	),
	array(
		'db' => 'amount',
		'dt' => 7,
		'formatter' => function( $d, $row ) {
			if(!empty($d)){
				return '<span style="color:#a50000;font-weight:bolder;">'.money($d).'</span>';
			}
		}
	),	
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
					<button onclick="return view________('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
				</form>
			';
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>