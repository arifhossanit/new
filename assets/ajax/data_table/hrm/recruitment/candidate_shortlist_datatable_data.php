<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../../application/config/ajax_config.php");

$table = 'candidate_short_list';
$primaryKey = 'id';
$where = "status = '1' AND mark != '0'";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
    array( 'db' => 'name',   'dt' => 1 ),
	array( 
		'db' => 'phone', 
		'dt' => 2,
		'formatter' => function($d,$row){			
			return '<a href="tel:'.$d.'">'.$d.'</a>';
		}
	),
    array( 'db' => 'department',   'dt' => 3 ),
    array( 'db' => 'designation',   'dt' => 4 ),
	array( 
		'db' => 'mark', 
		'dt' => 5,
		'formatter' => function($d,$row){			
			if($d == '5'){
				return ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> ';
			}else if($d == '4'){
				return ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> ';
			}else if($d == '3'){
				return ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> ';
			}else if($d == '2'){
				return ' <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> '; 
			}else if($d == '1'){
				return ' <i class="fas fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> ';
			}else if($d == '0'){
				return ' <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> <i class="far fa-star"></i> '; 
			}
		}
	),
    array( 'db' => 'data',   'dt' => 6 ),	
    array( 
		'db' => 'id', 
		'dt' => 7,
		'formatter' => function($d,$row){
			global $home;
			global $mysqli;
			$check_can = mysqli_fetch_assoc($mysqli->query("select * from candidate_short_list where id = '".$d."'"));
			if($check_can['status'] == '1'){
				return '

				';
			}else{
				return '
					
				';
			}
			
		}
	)
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>