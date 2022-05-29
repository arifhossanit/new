<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'ipo_member_directory';
$primaryKey = 'id';
$where = "status = '1'";
$columns = array(
    array( 'db' => 'id',   'dt' => 0 ),
	array(
		'db' => 'personal_images',
		'dt' => 1,
		'formatter' => function( $d, $row ){ global $home; 
			if(!empty($d)){
				return '<img src="'.$home.$d.'" style="width:40px;height:40px;"/>';
			}else{
				return '<div style="width:40px;height:40px;"><i class="far fa-image"></i></div>';
			}
			
		}
	),
	array( 'db' => 'card_number', 'dt' => 2 ),
	array( 'db' => 'personal_full_name', 'dt' => 3 ),
	array( 'db' => 'personal_phone_number', 'dt' => 4 ),
	array( 'db' => 'personal_email', 'dt' => 5 ),
	array( 'db' => 'personal_nid_card', 'dt' => 6 ),
	array(
		'db' => 'ipo_id',
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$aggrements = $mysqli->query("SELECT agreement_type from ipo_agreement_information where ipo_id = '".$d."'");
			if($aggrements->num_rows > 1){
				return 'Multiple';
			}else{
				$aggrement = mysqli_fetch_assoc($aggrements);
				return $aggrement['agreement_type'];
			}
		}
	),
	array(
		'db' => 'id',
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $mysqli;
			return '';
		}
	),
	array( 'db' => 'bank_name', 'dt' => 9 ),
	array(
		'db' => 'ipo_id',
		'dt' => 10,
		'formatter' => function( $d, $row ) { global $mysqli;
			$aggrements = $mysqli->query("SELECT bed_name from ipo_agreement_information where ipo_id = '".$d."'");
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
	array( 'db' => 'account_number', 'dt' => 11 ),	
    array(
        'db'        => 'uploader_info',
        'dt'        => 12,
        'formatter' => function( $d, $row ) { global $mysqli;
			$email = explode("___",$d);
			$emp_info = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$email[1]."'"));
			return $emp_info['full_name'].' | '.$emp_info['employee_id'];
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
			return '
				<button onclick="return ipo_member_card_change_form('.$d.')" type="button" class="btn btn-xs btn-info" title="Card Change"><i class="fas fa-credit-card"></i></button>				
				<button onclick="return ipo_member_edit_form('.$d.')" type="button" class="btn btn-xs btn-success" title="Edit Information"><i class="far fa-edit"></i></button>
				<button onclick="return ipo_member_remove_form('.$d.')" type="button" class="btn btn-xs btn-danger" title="Remove IPO User"><i class="fas fa-trash"></i></button>
				<button onclick="return ipo_member_information('.$d.')" type="button" class="btn btn-xs btn-warning" title="View Information"><i class="far fa-eye"></i></button>
			';
			//<button onclick="return ipo_member_shifting_form('.$d.')"type="button" class="btn btn-xs btn-primary" title="IPO Sifting"><i class="fas fa-random"></i></button>
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>