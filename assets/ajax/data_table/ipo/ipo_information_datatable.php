<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'ipo_purses_information';
$primaryKey = 'id';
$where = "";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array(
		'db' => 'ipo_id',
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$d."'"));
			return $ipo_info['card_number'];
		}
	),
	array(
		'db' => 'ipo_id',
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$d."'"));
			return $ipo_info['personal_full_name'];
		}
	),
	array(
		'db' => 'ipo_id',
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$d."'"));
			return $ipo_info['personal_phone_number'];
		}
	),
	array(
		'db' => 'ipo_id',
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			$ipo_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$d."'"));
			return $ipo_info['personal_email'];
		}
	),
	array(
        'db'        => 'payed_amount',
        'dt'        => 5,
        'formatter' => function( $d, $row ) { global $mysqli;
			return money($d);
        }
    ),
	array(
        'db'        => 'ipo_id',
        'dt'        => 6,
        'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from ipo_agreement_information where ipo_id = '".$d."'"));
			return $info['agreement_type'];
        }
    ),
	array(
		'db' => 'purses_code',
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$aggrements = $mysqli->query("SELECT bed_name from ipo_agreement_information where purses_code = '".$d."'");
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
    array( 'db' => 'data',   'dt' => 8 ),	
    array(
        'db'        => 'uploader_info',
        'dt'        => 9,
        'formatter' => function( $d, $row ) { global $mysqli;
			$email = explode("___",$d);
			$emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$email[1]."'"));
			return $emp_info['full_name'].' | '.$emp_info['employee_id'];
        }
    ),
	array(
        'db'        => 'status',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {
			if($d == 1){
				return '<button type="button" class="btn btn-xs btn-success">Active</button>';
			}else{
				return '<button type="button" class="btn btn-xs btn-danger">Deactive</button>';
			}
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 11,
        'formatter' => function( $d, $row ) {global $mysqli; global $home;
			$purchase_code = mysqli_fetch_assoc($mysqli->query("SELECT purses_code, ipo_id from ipo_purses_information where id = '".$d."'"));
			return '<abbr title="Investment Invoice"><button type="button" data-toggle="modal" data-target="#exchange_ipo" class="btn btn-xs btn-primary" onclick="get_ipo_receipt(\''.$purchase_code['ipo_id'].'\', \''.$purchase_code['purses_code'].'\')"><i class="fas fa-eye"></i></button></abbr>
			<abbr title="Certificate"><a href="'.$home.'admin/ipo/ipo-member-certificate/'.$purchase_code['ipo_id'].'"><button type="button" class="btn btn-xs btn-primary"><i class="fas fa-certificate"></i></button></a></abbr>';
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>