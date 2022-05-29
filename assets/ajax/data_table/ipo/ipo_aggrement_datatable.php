<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$purchaseCode = $_GET['purchaseCode'];
$ipo_id = $_GET['ipo_id'];
$table = 'ipo_agreement_information';
$primaryKey = 'id';
$where = "status in ('1','0') AND purses_code = '".$purchaseCode."' AND ipo_id = '".$ipo_id."'";
$columns = array(
    array('db' => 'id','dt' => 0 ),
	array('db' => 'branch_name','dt' => 1 ),
	array('db' => 'bet_type','dt' => 2 ),
	array('db' => 'agreement_type','dt' => 3 ),
	array('db' => 'ipo_commission','dt' => 4 ),
	array('db' => 'ipo_rate','dt' => 5 ),
    array(
        'db'        => 'expirity_date',
        'dt'        => 6
        ,
        'formatter' => function( $d, $row ) {
            $today = new DateTime(date('Y-m-d'));
            $date = str_replace('/','-', $d);
            $newDate = date("Y-m-d", strtotime($date));
            $expiry_date = new DateTime($newDate);
            $validity = $expiry_date->diff($today);
            $validity_html = '';
            if($validity->y != 0){
                $validity_html .= $validity->y.' Years, ';
            }
            if($validity->m != 0){
                $validity_html .= $validity->m.' Months, ';
            }
            if($validity->d != 0){
                $validity_html .= $validity->d.' Days.';
            }
			return $validity_html;
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 7,
        'formatter' => function( $d, $row ) { global $mysqli;
            $aggrement = mysqli_fetch_assoc($mysqli->query("SELECT id, status, note from ipo_agreement_information where id = '$d'"));
            if($aggrement['status'] == 0){
				return '<span class="text-success">Agreement Completed!</span>';
			}else{
				if($aggrement['note'] == 'transferred'){
					return '<span class="text-danger">Transferred</span>';
				}else{
					return '
						<abbr title="Cancel Agreement"><button type="button" data-toggle="modal" data-target="#cancel_ipo" class="btn btn-xs btn-danger" onclick="cancel_id(\''.$d.'\')"><i class="fas fa-user-times"></i></button></abbr>
						<abbr title="Transfer Agreement"><button type="button" data-toggle="modal" data-target="#exchange_ipo" class="btn btn-xs btn-primary" onclick="exchange_id(\''.$d.'\')"><i class="fas fa-random"></i></button></abbr>
					';
				}			
			}
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>