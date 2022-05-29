<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'employee_wallet_money_widthdraw_request';
$primaryKey = 'id';
$where = "status = '1' and aproval = '1'";
$columns = array(
    array('db' => 'id','dt' => 0 ),
	array(
        'db'        => 'id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_wallet_money_widthdraw_request where id = '".$d."'"));
			$emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$info['employee_id']."'"));
			return '<span style="font-weight:bolder;color:#f00;">'.$emp_info['full_name'].' | '.$emp_info['employee_id'].'</span>';
        }
    ),	
	array(
        'db'        => 'amount',
        'dt'        => 2,
        'formatter' => function( $d, $row ) { global $mysqli;
			return '<span style="font-weight:bolder;color:green;">'.money($d).'</span>'; 
        }
    ),
	array('db' => 'note','dt' => 3 ),	
	array('db' => 'data','dt' => 4 ),
	array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_wallet_money_widthdraw_request where id = '".$d."'"));
			if($info['aproval'] == 1){
				return '<button type="button" class="btn btn-success btn-xs">Aproved</button>';
			}else{
				return '<button type="button" class="btn btn-info btn-xs">Pending...</button>';
			}
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 6,
        'formatter' => function( $d, $row ) { global $mysqli;
			return '<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-success" title=""><i class="fas fa-money-check-alt"></i>&nbsp;&nbsp;&nbsp;View</button>';
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>