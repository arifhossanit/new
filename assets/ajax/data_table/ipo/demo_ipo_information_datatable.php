<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'demo_ipo_purses_information';
$primaryKey = 'id';
$where = "";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array(
		'db' => 'ipo_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_member_directory where ipo_id = '".$d."'"));
			return $ipo_info['card_number'];
		}
	),
	array(
		'db' => 'ipo_id',
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_member_directory where ipo_id = '".$d."'"));
			return '<span style="color:#f00;">'.$ipo_info['password'].'</span>';
		}
	),
	array(
		'db' => 'ipo_id',
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_member_directory where ipo_id = '".$d."'"));
			return $ipo_info['personal_full_name'];
		}
	),
	array(
		'db' => 'ipo_id',
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_member_directory where ipo_id = '".$d."'"));
			return $ipo_info['personal_phone_number'];
		}
	),
	array(
		'db' => 'ipo_id',
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_member_directory where ipo_id = '".$d."'"));
			return $ipo_info['personal_email'];
		}
	),
	array(
        'db'        => 'payed_amount',
        'dt'        => 6,
        'formatter' => function( $d, $row ) { global $mysqli;
			return money($d);
        }
    ),
	array(
        'db'        => 'ipo_id',
        'dt'        => 7,
        'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from demo_ipo_agreement_information where ipo_id = '".$d."'"));
			return $info['agreement_type'];
        }
    ),
	array(
		'db' => 'purses_code',
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $mysqli;
			$aggrements = $mysqli->query("SELECT bed_name from demo_ipo_agreement_information where purses_code = '".$d."'");
			if($aggrements->num_rows > 1){
				return 'Multiple';
			}else if($aggrements->num_rows == 1){
				$aggrement = mysqli_fetch_assoc($aggrements);
				switch($aggrement['bed_name']){
					case '1':
						return 'Only Profit';
						break;
					case '2':
						return 'Only Principle';
						break;
					case '3':
						return 'Principle + Profit';
						break;
					default:
						return ' - ';
						break;
				}
			}else{
				return ' - ';
			}
		}
	),
    array( 'db' => 'data',   'dt' => 9 )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>