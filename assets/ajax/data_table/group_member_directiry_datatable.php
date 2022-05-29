<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'member_directory';
$primaryKey = 'id';
if(!empty($_GET['branch_id'])){	
	if($_GET['branch_id'] == '1'){
		$branch_user = "";
	}else{
		$row_b = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".rahat_decode($_GET['branch_id'])."'"));
		if(!empty($row_b['branch_id'])){
			$branch_user = "branch_id = '".$row_b['branch_id']."' AND ";
		}else{
			$branch_user = "";
		}
	}
}else{
	$branch_user = "";
}
$where = "$branch_user member_type = 'GROUP' AND status = '1'"; // 	return type == 'export' ? meta.row + 1 : data;
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 
		'db' => 'photo_avater', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { 
			global $home;
			if(!empty($d)){
				if(url_check($home.$d)){
					return '<img src="'.$home.$d.'" style="width:35px;" class="image-responsive"/>';
				}else{
					return '<img src="'.$home.'assets/img/empty-user-xs.png" style="width:35px;" class="image-responsive"/>';
				}				
			}else{
				return '<img src="'.$home.'assets/img/empty-user-xs.png" style="width:35px;" class="image-responsive"/>';
			}
		}
	),
	array( 
		'db' => 'branch_name', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { 			
			if(!empty($d)){
				return $d;
			}else{
				return '';
			}			
		}
	),
    array( 'db' => 'card_number', 'dt' => 3 ),
    array( 'db' => 'full_name',  'dt' => 4 ),
    array( 'db' => 'phone_number',  'dt' => 5 ),
    array( 
		'db' => 'id',
		'dt' => 6,
		'formatter' => function( $d, $row ) {
			global $mysqli;
			$mem_inf = mysqli_fetch_assoc($mysqli->query("select * from member_directory where id = '".$d."'"));
			$group_inf = mysqli_fetch_assoc($mysqli->query("select * from group_member_directory where booking_id = '".$mem_inf['booking_id']."'"));
			if(!empty($group_inf['group_id'])){
				$group_id = "'".$group_inf['group_id']."'";
				return '
					<button onclick="return view_group_members('.$group_id.')" type="button" class="btn btn-xs btn-success"><i class="fas fa-users"></i>&nbsp;&nbsp;'.$group_inf['group_id'].'</button>
				';
			}else{
				return '
					<button type="button" class="btn btn-xs btn-danger"><i class="fas fa-users"></i>&nbsp;&nbsp;Group Not Create Yet!</button>
				';
			}
			
		}
	),	
    array( 'db' => 'bed_name',     'dt' => 7 ),
    array( 'db' => 'check_in_date',     'dt' => 8 ),
    array( 'db' => 'check_out_date',     'dt' => 9 ),
    array( 
		'db' => 'package_category', 
		'dt' => 10,
		'formatter' => function( $d, $row ) { 
			global $mysqli;
			$pc = mysqli_fetch_assoc($mysqli->query("select * from packages_category where id = '".$d."'"));
			if(!empty($pc['package_category_name'])){
				return $pc['package_category_name'];
			}else{
				return '';
			}
			
		}
	), 
	array( 'db' => 'package_name',     'dt' => 11 ),
    array( 
		'db' => 'security_deposit', 
		'dt' => 12,
		'formatter' => function( $d, $row ) {			
			return money($d);
		}
	),    
        
    array(
        'db'        => 'id',
        'dt'        => 13,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$cencel_button = '';			
			if(check_permission('role_1606371205_20')){
				$cencel_button .= '<button type="submit" name="edit" class="btn btn-xs btn-success" title="Edit Member information"><i class="fas fa-edit"></i></button>';
			}if(check_permission('role_1606371205_23')){
				$cencel_button .= '<button type="submit" name="delete" class="btn btn-xs btn-danger" title="Remove Member from system"><i class="fas fa-trash-alt"></i></button>';
			}			
			$data = '
				<form action="'.$home.'admin/member-directory/edit-delete-member" method="post" class="duallistbox">
				<input type="hidden" name="hidden_id" value="'.$d.'"/>
			';
			$data .= $cencel_button;
			if(check_permission('role_1606371205_51')){ 
				$data .= '<button onclick="return view_member_profile('.$d.')" type="button" class="btn btn-xs btn-warning" title="View member profile"><i class="fa fa-eye"></i></button>';		
			}
			$data .= '</form>';
			return $data;
        }
    )
);
 

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>