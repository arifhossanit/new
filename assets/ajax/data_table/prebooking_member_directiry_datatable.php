<?php 
$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
if ( is_file( $file ) ) {
	include( $file );
}
include("../../../application/config/ajax_config.php");

$table = 'pre_booking_directory';
$primaryKey = 'id';
if(!empty($_GET['branch_id'] AND isset($_GET['branch_id']))){
	if($_GET['branch_id'] == 1){
		$branch_id = "";
	}else{
		$branch_id = " AND branch_id = '".$_GET['branch_id']."'";
	}	
}else{
	$branch_id = " AND branch_id = '".$_SESSION['super_admin']['branch']."'";
}
if(isset($_GET['date_range'])){
	$one = explode(' - ',$_GET['date_range']);	
	$one_ymd = explode('/',$one[0]);
	$two_ymd = explode('/',$one[1]);
	$date_from = $one_ymd[2].'-'.$one_ymd[1].'-'.$one_ymd[0];
	$date_to = $two_ymd[2].'-'.$two_ymd[1].'-'.$two_ymd[0];	
	$date_filter = " AND STR_TO_DATE(data,'%d/%m/%Y') BETWEEN '$date_from' AND '$date_to'";
}else{
	$date_filter = "";
}


if(isset($_GET['booking'])){
	if($_GET['booking'] == 'X'){
		$booking = "status in ('0','1') ";
	}else{
		$booking = "status = '".$_GET['booking']."' ";
	}
}else{
	$booking = "status in ('0','1') ";	
}
$where = "$booking $branch_id $date_filter";
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
	array( 
		'db' => 'photo_avater', 
		'dt' => 1,
		'formatter' => function( $d, $row ) { global $home;			
				return '<img src="'.$home.$d.'" style="width:30px;"/>';
			}
	),
    array( 
		'db' => 'id', 
		'dt' => 2,
		'formatter' => function( $d, $row ) { global $home; global $mysqli;
			$ccn = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where id = '".$d."'"));
			$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$ccn['branch_id']."'"));
			if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
				if($ccn['status'] == '1'){				
					$variable = '
						<select id="branch_id_'.$d.'" onchange="return update_branch_from_prebook('.$d.')">
					';
					$sql = $mysqli->query("select * from branches where id not in ('1')");
					while($row = mysqli_fetch_assoc($sql)){
						if($row['branch_id'] == $ccn['branch_id']){
							$selected = 'selected';
						}else{
							$selected = '';
						}
						$variable .= '<option value="'.$row['branch_id'].'" '.$selected.'>'.$row['branch_name'].'</option>';
					}
					$variable .= '</select>';
					return $variable;
				}else{
					if(!is_null($branch_info)){
						return $branch_info['branch_name'];
					}else{
						return '';
					}
				}
			}else{
				if(!is_null($branch_info)){
					return $branch_info['branch_name'];
				}else{
					return '';
				}
			}			
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 3,
		'formatter' => function( $d, $row ) { global $home;	global $mysqli;		
			$info = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where id = '".$d."'"));
			$id = "'".$info['id']."'";
			$field = "'full_name'";
			$edit = 'contenteditable="true" onBlur="saveToDatabase(this,'.$field.','.$id.')" onClick="showEdit(this);"';
			if(!empty($info['full_name'])){
				$value = '<span '.$edit.' style="padding:2px 10px;">'.$info['full_name'].'</span>';
			}else{
				$value = '<span '.$edit.' style="padding:2px 10px;">---</span>';
			}
			return $value;
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 4,
		'formatter' => function( $d, $row ) { global $home;	global $mysqli;		
			$info = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where id = '".$d."'"));
			$id = "'".$info['id']."'";
			$field = "'phone'";
			$edit = 'contenteditable="true" onBlur="saveToDatabase(this,'.$field.','.$id.')" onClick="showEdit(this);"';
			if(!empty($info['phone'])){
				$value = '<span '.$edit.' style="padding:2px 10px;">'.$info['phone'].'</span>';
			}else{
				$value = '<span '.$edit.' style="padding:2px 10px;">---</span>';
			}
			return $value;
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 5,
		'formatter' => function( $d, $row ) { global $home;	global $mysqli;		
			$info = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where id = '".$d."'"));
			$id = "'".$info['id']."'";
			$field = "'email'";
			$edit = 'contenteditable="true" onBlur="saveToDatabase(this,'.$field.','.$id.')" onClick="showEdit(this);"';
			if(!empty($info['email'])){
				$value = '<span '.$edit.' style="padding:2px 10px;">'.$info['email'].'</span>';
			}else{
				$value = '<span '.$edit.' style="padding:2px 10px;">---</span>';
			}
			return $value;
		}
	),
	array( 
		'db' => 'id', 
		'dt' => 6,
		'formatter' => function( $d, $row ) { global $home;	global $mysqli;		
			$info = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where id = '".$d."'"));
			$id = "'".$info['id']."'";
			$field = "'nid'";
			$edit = 'contenteditable="true" onBlur="saveToDatabase(this,'.$field.','.$id.')" onClick="showEdit(this);"';
			if(!empty($info['nid'])){
				$value = '<span '.$edit.' style="padding:2px 10px;">'.$info['nid'].'</span>';
			}else{
				$value = '<span '.$edit.' style="padding:2px 10px;">---</span>';
			}
			return $value;
		}
	),
    
    array( 'db' => 'occupation',     'dt' => 7 ),
    array( 
		'db' => 'id', 
		'dt' => 8,
		'formatter' => function( $d, $row ) { global $home;	global $mysqli;		
			$info = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where id = '".$d."'"));
			$id = "'".$info['id']."'";
			$field = "'present_addrress'";
			$edit = 'contenteditable="true" onBlur="saveToDatabase(this,'.$field.','.$id.')" onClick="showEdit(this);"';
			if(!empty($info['present_addrress'])){
				$value = '<span '.$edit.' style="padding:2px 10px;">'.$info['present_addrress'].'</span>';
			}else{
				$value = '<span '.$edit.' style="padding:2px 10px;">---</span>';
			}
			return $value;
		}
	),
    array( 'db' => 'data',     'dt' => 9 ),
    array( 'db' => 'h_t_f_u',     'dt' => 10 ),
    array(
        'db'        => 'id',
        'dt'        => 11,
        'formatter' => function( $d, $row ) {
			global $home;
			global $mysqli;
			$ccn = mysqli_fetch_assoc($mysqli->query("select * from pre_booking_directory where id = '".$d."'"));
            $con_msg = "'Are you Sure want to booked this preBook Member? (".$ccn['full_name'].")'";
			$data = '
				<form action="'.$home.'admin/booking" method="post" class="duallistbox">
					<input type="hidden" name="hidden_id" value="'.$d.'"/> 
					<input type="hidden" name="hidden_id_pre_book" value="'.$d.'"/> 
					<button onclick="return reupload_member_image('.$d.', \''.$row[15].'\')" type="button" class="btn btn-xs btn-dark" title="Reupload Image"><i class="fas fa-image"></i></button> 
					<button onclick="return view_pre_book_infformation('.$d.')" type="button" class="btn btn-xs btn-info" title="View PreBook member profile"><i class="fa fa-eye"></i></button> 
					<button onclick="return print_police_verification_form('.$d.')" type="button" class="btn btn-xs btn-success" title="View Police Verification Print File"><i class="fa fa-print"></i></button> ';
			if($ccn['status'] == '1'){		
			$data .='<button name="go_to_booking" onclick="return confirm('.$con_msg.')" type="submit" class="btn btn-xs btn-info" title="Got To Booking"><i class="fa fa-pencil">Go to Booking</i></button>';
			}
			$data .='</form> ';
			return $data;
        }
    ),
    array( 'db' => 'phone',     'dt' => 12 ),
    array( 'db' => 'email',     'dt' => 13 ),
    array( 'db' => 'nid',     'dt' => 14 ),
    array( 'db' => 'full_name',     'dt' => 15 ),
);
 

$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where, null)
);
?>