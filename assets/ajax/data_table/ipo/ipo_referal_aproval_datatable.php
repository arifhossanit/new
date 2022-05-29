<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$ipo_id = $_SESSION['ipo_member_panel']['ipo_id'];
$table = 'ipo_referal_approval';
$primaryKey = 'id';
$where = "ipo_id = '".$ipo_id."' and status = '1' and aproval = '0'";
$columns = array(
    array('db' => 'id','dt' => 0 ),
	array(
        'db'        => 'booking_id',
        'dt'        => 1
        ,
        'formatter' => function( $d, $row ) { global $mysqli;
			$get_data = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return $get_data['full_name']; 
        }
    ),
	array(
        'db'        => 'booking_id',
        'dt'        => 2
        ,
        'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$get_data = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return '<a href="'.$home.$get_data['photo_avater'].'" target="_blank"><img src="'.$home.$get_data['photo_avater'].'" style="width:50px;height:50px;"/></a>'; 
        }
    ),
	array(
        'db'        => 'booking_id',
        'dt'        => 3
        ,
        'formatter' => function( $d, $row ) { global $mysqli; global $home;
			$get_data = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$d."'"));
			return '<a href="tel:'.$get_data['phone_number'].'" target="_self">'.$get_data['phone_number'].'</a>'; 
        }
    ),	
	array('db' => 'note','dt' => 4 ),
	array(
        'db'        => 'id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) { global $mysqli;
            $get_info = mysqli_fetch_assoc($mysqli->query("select * from ipo_referal_approval where id = '".$d."'"));
			if($get_info['aproval'] == '1'){
				return '<button type="button" class="btn btn-xs btn-info">Approved</button>';
			}else{
				return '<button onclick="return ipo_referal_approvaal_member('.$get_info['id'].')" type="button" class="btn btn-xs btn-success">Approve</button>';
			}
			
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>