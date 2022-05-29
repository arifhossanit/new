<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");

$table = 'ipo_member_directory_pre';
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
	array( 'db' => 'bank_name', 'dt' => 7 ),
	array( 'db' => 'account_number', 'dt' => 8 ),
	array(
        'db'        => 'id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
            global $mysqli;
			$member_info = mysqli_fetch_assoc($mysqli->query("SELECT * from ipo_member_directory_pre where id = '".$d."'"));
            if($member_info['card_number'] == 'unauthorized'){
                return '
                    <button type="button" data-toggle="modal" data-target="#authorize_ipo" class="btn btn-xs btn-primary" onclick="authorize(\''.$d.'\')"><i class="fas fa-user-check"></i></button>
                ';
            }else{
                return '-';
            }			
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>