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
                a.withdraw_status,
                b.date_of_joining
                
            from employee_monthly_sallary a
            INNER JOIN employee b on b.employee_id = a.employee_id
        ) temp';

$primaryKey = 'id';

if(!empty($_GET['date_filter'])){
	$d = explode("-",$_GET['date_filter']);
	$date = $d[1].'/'.$d[0];
	$date_filter = "date_full = '".$date."'";
}else{
	$date_filter = "";
}

$where = "$date_filter";

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
    array( 'db' => 'salary_pay_method',   'dt' => 9 ),
    array( 'db' => 'withdraw_status',   'dt' => 10 ),
	array(
        'db'        => 'id',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {	global $mysqli;	
			$info = mysqli_fetch_assoc($mysqli->query("select * from employee_monthly_sallary where id = '".$d."'"));
            if($row[10] == 0 && $row[9] == 'cash'):
			return '<button onclick="return view_rental_recipt('.$info['id'].');" type="button" class="btn btn-warning btn-xs ml-1"><i class="fas fa-receipt"></i></button><button  type="button" class="btn btn-info btn-xs ml-1 confirm" id="source_price_'.$row[1].'" data-id="'.$row[1].'"><i class="fas fa-phone"></i></button> <a style="cursor: pointer; color: white" class="btn btn-success btn-sm resend_again"  data-id="'.$row[1].'"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>';
            
            elseif($row[10] == 0 && $row[9] != 'cash'):
                return '<button onclick="return view_rental_recipt('.$info['id'].');" type="button" class="btn btn-warning btn-xs ml-1"><i class="fas fa-receipt"></i></button> <a style="cursor: pointer; color: white" class="btn btn-success btn-sm resend_again"  data-id="'.$row[1].'"><i class="fa fa-paper-plane" aria-hidden="true"></i></a>';
            else:
                return '<button onclick="return view_rental_recipt('.$info['id'].');" type="button" class="btn btn-warning btn-xs ml-1"><i class="fas fa-receipt"></i></button> <badge class="badge badge-primary badge-xs ml-1">Approved</badge>';
            endif;
            
        }
    ),
    
);
 
$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>