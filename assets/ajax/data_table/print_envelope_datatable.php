<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = '(
            SELECT 
                a.salary_pay_method,
                a.date_full,
                a.id,
                a.employee_id,
                a.total_sallary,
                a.data,
                b.date_of_joining
            from employee_monthly_sallary a
            INNER JOIN employee b on b.employee_id = a.employee_id
        ) temp';
$primaryKey = 'id';
if(!empty($_GET['date_filter'])){
	$d = explode("-",$_GET['date_filter']);
	$date = $d[1].'/'.$d[0];
	$date_filter = " AND date_full = '".$date."'";
}else{
	$date_filter = "";
}

$joining_date = DateTime::createFromFormat('d/m/Y', '01/' . $date);

if($_GET['employee_type'] == 'New'){
    $employee_filter = "AND STR_TO_DATE(date_of_joining, '%d/%m/%Y') between '".$joining_date->format('Y-m-01')."' AND '".$joining_date->format('Y-m-t')."'";
}else{
    $employee_filter = "AND STR_TO_DATE(date_of_joining, '%d/%m/%Y') not between '".$joining_date->format('Y-m-01')."' AND '".$joining_date->format('Y-m-t')."'";
}

$where = "salary_pay_method = 'cash' $employee_filter $date_filter";
$columns = array(
	array( 'db' => 'id',   'dt' => 0 ),
	array(
        'db'        => 'employee_id',
        'dt'        => 1,
        'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $info['full_name'];
        }
    ),
	array(
        'db'        => 'employee_id',
        'dt'        => 2,
        'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $info['employee_id'];
        }
    ),
	array(
        'db'        => 'employee_id',
        'dt'        => 3,
        'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $info['designation_name'];
        }
    ),
	array(
        'db'        => 'employee_id',
        'dt'        => 4,
        'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			return $info['department_name'];
        }
    ),
	array(
        'db'        => 'employee_id',
        'dt'        => 5,
        'formatter' => function( $d, $row ) { global $mysqli;
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$d."'"));
			$branch = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$info['branch']."'"));
			return $branch['branch_name'];
        }
    ),
	array(
        'db'        => 'total_sallary',
        'dt'        => 6,
        'formatter' => function( $d, $row ) { global $mysqli;			
			return money($d);
        }
    ),	
    array( 'db' => 'date_full',   'dt' => 7 ),
    array( 'db' => 'data',   'dt' => 8 ),
	array(
        'db'        => 'id',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {	global $mysqli;	
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_monthly_sallary where id = '".$d."'"));
			return '<button onclick="return check_print_modal('.$info['id'].');" type="button" class="btn btn-warning btn-xs"><i class="fa fa-eye"></i></button><button onclick="return view_rental_recipt('.$info['id'].');" type="button" class="btn btn-warning btn-xs ml-1"><i class="fas fa-receipt"></i></button>';
        }
    ),
    
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>