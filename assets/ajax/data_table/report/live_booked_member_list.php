<?php 
error_reporting(0);
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../../application/config/ajax_config.php");
$table = 'member_directory';
$primaryKey = 'id';

if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
	$branch_user = "";
}else{
	$branch_user = "branch_id = '".$_SESSION['super_admin']['branch']."' AND ";
	
}

$where = "$branch_user card_number = 'Unauthorized' and bed_id in (select id from beds where status = '1') order by STR_TO_DATE(check_in_date,'%d/%m/%Y') asc";
// $where = "$branch_user card_number = 'Unauthorized' and bed_id in (select id from beds where uses = '2' and status = '1') order by STR_TO_DATE(check_in_date,'%d/%m/%Y') asc";
$columns = array(
	array(
		'db' => 'bed_id',
		'dt' => 0,
		'formatter' => function( $d, $row ) { global $home; global $mysqli;
			return $d;		
		}
	),
    array(
		'db' => 'id',
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$mem = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$d."'"));
			return '<img src="'.$home.$mem['photo_avater'].'" style="width:40px;height:40px;" class="image-responsive"/>';		
		}
	),
	array(
		'db' => 'card_number',
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;		
		}
	),
	array(
		'db' => 'branch_name',
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;		
		}
	),
	array(
		'db' => 'full_name',
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;		
		}
	),
	array(
		'db' => 'phone_number',
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;		
		}
	),
	array(
		'db' => 'email',
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;	
		}
	),
	array(
		'db' => 'bed_id',
		'dt' => 7,
		'formatter' => function( $d, $row ) { global $mysqli;
			$bed = mysqli_fetch_assoc($mysqli->query("select * from beds where id = '".$d."'"));
			return $bed['bed_name'];		
		}
	),
	array(
		'db' => 'package_category',
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $mysqli;
			$pc = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$d."'")); 
			return $pc['package_category_name'];		
		}
	),
	array(
		'db' => 'package',
		'dt' => 9,
		'formatter' => function( $d, $row ) { global $mysqli;
			$pc = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$d."'")); 
			return $pc['package_name'];			
		}
	),
	array(
		'db' => 'check_in_date',
		'dt' => 10,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;			
		}
	),
	array(
		'db' => 'check_out_date',
		'dt' => 11,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;			
		}
	),
	array(
		'db' => 'note',
		'dt' => 12,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;			
		}
	),
	array(
		'db' => 'uploader_info',
		'dt' => 13,
		'formatter' => function( $d, $row ) { global $mysqli;
			$info = explode('___',$d);
			if(!empty($info[1])){
				return $info[1];		
			}else{
				return '';		
			}				
		}
	),
	array(
		'db' => 'data',
		'dt' => 14,
		'formatter' => function( $d, $row ) { global $mysqli;
			return $d;				
		}
	),
	array(
        'db'        => 'id',
        'dt'        => 15,
        'formatter' => function( $d, $row ) { global $home; global $mysqli;
            return '
				<form action="#" method="post" class="navbar-form">
					<input type="hidden" name="hidden_id" value="'.$d.'"/>
					<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></button>
				</form>
			';
        }
    )
);

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
);
?>