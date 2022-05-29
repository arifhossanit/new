<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'employee_attendence';
$primaryKey = 'id';
$where = "";
$columns = array(
    array(
		'db' => 'id',
		'dt' => 0,
		'formatter' => function( $d, $row ) {
			return '<input type="checkbox" value="'.$d.'" />';
		}
	),
	array( 'db' => 'id',   'dt' => 1 ),
    array( 'db' => 'employee_id',   'dt' => 2 ),
	array(
        'db'        => 'e_db_id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            global $mysqli;
			$e_n = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".$d."'"));
			return $e_n['full_name'];
        }
    ),
	array(
        'db'        => 'attendance',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            if($d == '1'){
				return '<span style="color:green;font-weight:bolder;">Present</span>';
			}else{
				return '<span style="color:red;font-weight:bolder;">Absent</span>';
			}			
        }
    ),
	array(
        'db'        => 'checkin',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            if(!empty($d)){
				$date = $d.':00'; 
				return date('h:i:s a', strtotime($date));
			}else{
				return '--';
			}
        }
    ),
	array(
        'db'        => 'checkout',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
            if(!empty($d)){
				$date = $d.':00'; 
				return date('h:i:s a', strtotime($date));
			}else{
				return '--';
			}
        }
    ),
	array(
        'db'        => 'note',
        'dt'        => 7,
        'formatter' => function( $d, $row ) {
            if(!empty($d)){
				return $d;
			}else{
				return '--';
			}
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 8,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$dayi = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where id = '".$d."'"));
            $data = explode("/",$dayi['data']);
			$date = $dayi['days'].'-'.$dayi['month'].'-'.$data[2];
			return $date;			
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
			global $mysqli;
			$dayi = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where id = '".$d."'"));
            $data = explode("/",$dayi['data']);
			$date = $dayi['days'].'-'.$dayi['month'].'-'.$data[2];
			$nameOfDay = date('l', strtotime($date));
			return $nameOfDay;			
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {
            global $mysqli;
			$dayi = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where id = '".$d."'"));
            $data = explode("/",$dayi['data']);
			$date = $dayi['days'].'-'.$dayi['month'].'-'.$data[2];
			$nameOfDay = date('F', strtotime($date));
			return $nameOfDay;
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 11,
        'formatter' => function( $d, $row ) {
            global $mysqli;
			$dayi = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where id = '".$d."'"));
            $data = explode("/",$dayi['data']);
			$date = $dayi['days'].'-'.$dayi['month'].'-'.$data[2];
			$nameOfDay = date('Y', strtotime($date));
			return $nameOfDay;			
        }
    ),
	array(
        'db'        => 'uploader_info',
        'dt'        => 12,
        'formatter' => function( $d, $row ) {
            if(!empty($d)){
				$na = explode("___",$d);
				if(!empty($na[1])){
					return $na[1];
				}else{
					return '--';
				}
			}						
        }
    ),
	array(
        'db'        => 'data',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
            return $d;			
        }
    ),
	array(
        'db'        => 'id',
        'dt'        => 14,
        'formatter' => function( $d, $row ) {
            global $mysqli;
            global $home;
			$status = mysqli_fetch_assoc($mysqli->query("select * from employee_attendence where id = '".$d."'"));
			$message = "'are you sure?'";
			$data = '
				<form action="'.$home.'admin/hrm/attendance/attencance-log" method="post">
				<input type="hidden" value="'.$d.'" name="hidden_id"/>
			';
			$data .= '<button name="delete" type="submit" onclick="return confirm('.$message.');" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>';
			$data .= '</form>';
			return $data;
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>