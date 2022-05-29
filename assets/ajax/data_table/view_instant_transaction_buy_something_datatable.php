<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");
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
$table = '(
		SELECT 
			a.id,
			a.transaction_id,
			a.branch_id,
			a.recharge_amount,
			a.amount,
			a.balance,
			a.note,
			a.uploader_info,
			a.data,
			a.slip_id,
			a.status,
			c.phone_number,
			c.full_name
		from instant_transaction_logs a
		LEFT JOIN transaction b using(transaction_id)
		LEFT JOIN member_directory c on c.booking_id = b.booking_id
	) temp';
$primaryKey = 'id';
$where = "status = '1' $branch_id $date_filter";
$columns = array(
	array(
		'db' => 'id',
		'dt' => 0,
        'formatter' => function( $d, $row ) {global $branch_id;
			if(!is_null($row[11])){
				return '<i class="fas fa-check text-success"></i>';
			}
			if(empty($branch_id)){
				return '<i class="far fa-times-circle"></i>';
			}
			if(is_null($row[11]) && is_null($row[4]) && $row[5] > 0){
				return '<input onchange="create_slip()" class="regular-checkbox" type="checkbox" name="slip_id[]" value="'.$d.'">';
			}
			if($row[5] == '0' || !is_null($row[4])){
				return '';
			}
			return '<i class="fas fa-check"></i>';
        }
	),
	array(
        'db'        => 'transaction_id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {		
			return '<span style="font-weight:bolder;color:green;">'.$d.'</span>';
        }
    ),	
	array(
        'db'        => 'full_name',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {		
			return "<p class='m-0'>$d</p><p class='m-0'>".$row[12]."</p>";
        }
    ),
	array(
        'db'        => 'branch_id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {			
			global $mysqli;
			$branch = mysqli_fetch_assoc($mysqli->query("SELECT * FROM branches WHERE branch_id = '".$d."'"));
			return $branch['branch_name'];
        }
    ),
	array(
        'db'        => 'recharge_amount',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {		
			return (is_null($d)) ? 	'-' : money($d);
        }
    ),
	array(
        'db'        => 'amount',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
			if(is_null($d)){
				return '-';
			}else{
				return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>';
			}
        }
    ),
	array(
        'db'        => 'balance',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
			return (is_null($d)) ? 	'-' : money($d);
        }
    ),
	array(
        'db'        => 'note',
        'dt'        => 7,
        'formatter' => function( $d, $row ) {		
			return '<p style="width:220px;">'.$d.'</p>';
        }
    ),
    array(
		'db' => 'uploader_info',
		'dt' => 8,
		'formatter' => function( $d, $row ) {
			global $mysqli;			
			if(!empty($d)){
				$u = explode("___",$d);
				if(!empty($u[0]) AND !empty($u[1])){
					$emp = mysqli_fetch_assoc($mysqli->query("SELECT * FROM employee WHERE email = '".$u[1]."'"));
					return ''.$emp['full_name'].'';
				}
			}	
		}
	),
    array( 'db' => 'data',   'dt' => 9 ),	
    array(
        'db'        => 'transaction_id',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {
			$transaction_id = "'".$d."'";
			return '<button onclick="return view_buied_iteams('.$transaction_id .')" type="button" class="btn btn-xs btn-info">View Iteams</button>';
        }
	),
    array( 'db' => 'slip_id',   'dt' => 11 ),
    array( 'db' => 'phone_number',   'dt' => 12 ),
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>