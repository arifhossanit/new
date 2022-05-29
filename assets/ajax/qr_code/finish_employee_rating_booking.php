<?php
include("../../../application/config/ajax_config.php");
function getBrowser() { 
  $u_agent = $_SERVER['HTTP_USER_AGENT'];
  $bname = 'Unknown';
  $platform = 'Unknown';
  $version= "";

  //First get the platform?
  if (preg_match('/linux/i', $u_agent)) {
    $platform = 'linux';
  }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    $platform = 'mac';
  }elseif (preg_match('/windows|win32/i', $u_agent)) {
    $platform = 'windows';
  }

  // Next get the name of the useragent yes seperately and for good reason
  if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }elseif(preg_match('/Firefox/i',$u_agent)){
    $bname = 'Mozilla Firefox';
    $ub = "Firefox";
  }elseif(preg_match('/OPR/i',$u_agent)){
    $bname = 'Opera';
    $ub = "Opera";
  }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Google Chrome';
    $ub = "Chrome";
  }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
    $bname = 'Apple Safari';
    $ub = "Safari";
  }elseif(preg_match('/Netscape/i',$u_agent)){
    $bname = 'Netscape';
    $ub = "Netscape";
  }elseif(preg_match('/Edge/i',$u_agent)){
    $bname = 'Edge';
    $ub = "Edge";
  }elseif(preg_match('/Trident/i',$u_agent)){
    $bname = 'Internet Explorer';
    $ub = "MSIE";
  }

  // finally get the correct version number
  $known = array('Version', $ub, 'other');
  $pattern = '#(?<browser>' . join('|', $known) .
')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
  if (!preg_match_all($pattern, $u_agent, $matches)) {
    // we have no matching number just continue
  }
  // see how many we have
  $i = count($matches['browser']);
  if ($i != 1) {
    //we will have two since we are not using 'other' argument yet
    //see if version is before or after the name
    if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
        $version= $matches['version'][0];
    }else {
        $version= $matches['version'][1];
    }
  }else {
    $version= $matches['version'][0];
  }
  if ($version==null || $version=="") {$version="?";}

  return array(
    'userAgent' => $u_agent,
    'name'      => $bname,
    'version'   => $version,
    'platform'  => $platform,
    'pattern'    => $pattern
  );
}

$base_dir = 'E:/xampp/htdocs/super_home/';
// $base_dir = '/opt/lampp/htdocs/super_home/';
$ua=getBrowser();
$yourbrowser = "Browser Info: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" . $ua['userAgent'];
if(isset($_POST['user_type'])){
  if($_POST['user_type'] == '1'){
    $row = mysqli_fetch_assoc($mysqli->query("select * from employee where personal_Phone = '".$_POST['phone_number']."' or Company_phone = '".$_POST['phone_number']."'"));
    $branch_id = $row['branch'];
    $employee_id = $row['id'];
    $user = 'Employee';
  }else if($_POST['user_type'] == '2'){
    $row = mysqli_fetch_assoc($mysqli->query("select * from member_directory where phone_number = '".$_POST['phone_number']."' or card_number = '".$_POST['phone_number']."'"));
    $branch_id = $row['branch_id'];
    $employee_id = $row['id'];
    $user = 'Member';
  }

  if($_POST['receiver_id'] == $employee_id){
    echo '2';
    return;
  }

  $newfilename = '';
  if(!empty($_FILES['attachment']["name"])){
    $filename = $_FILES['attachment']["name"];
    $file_tmp = $_FILES['attachment']["tmp_name"];
    $file_ext = substr($filename, strripos($filename, '.'));
    $avater_name = 'EMPLOYEE_RATING_'.date('d_m_Y').'_'. rand() * time() . '_' . time() * rand() ;
    $newfilenameup = 'assets/uploads/other_document/rating_files/'.$avater_name. $file_ext;	
    $newfilename = 'assets/uploads/other_document/rating_files/'.$avater_name. $file_ext;	
    move_uploaded_file($file_tmp, $base_dir . $newfilenameup);
  }
  $review_time = new DateTime(date('Y-m-d H:i:s'));
  $review_time->sub(new DateInterval('PT1H'));
  $validate = mysqli_fetch_assoc($mysqli->query("SELECT count(id) as validate from employee_rating where receiver_id = '".$_POST['receiver_id']."' AND employee_id = '$employee_id' AND created_at > '".$review_time->format('Y-m-d H:i:s')."'"));
  if($validate['validate'] > 0){
    echo '3';
    return;
  }
  
  if($mysqli->query("insert into employee_rating values(
    '',
    '".$mysqli->real_escape_string($branch_id)."',
    '".$mysqli->real_escape_string($_POST['receiver_id'])."',
    '".$mysqli->real_escape_string($_POST['phone_number'])."',
    '".$mysqli->real_escape_string($_POST['stars'])."',
    '".$mysqli->real_escape_string($employee_id)."',
    '".$mysqli->real_escape_string($user)."',
    '".$mysqli->real_escape_string(date('d'))."',
    '".$mysqli->real_escape_string(date('m'))."',
    '".$mysqli->real_escape_string(date('Y'))."',
    '".$mysqli->real_escape_string($_POST['note'])."',
    '1',
    '".$mysqli->real_escape_string($yourbrowser)."',
    '".$mysqli->real_escape_string(date('d/m/Y'))."',
    '".$mysqli->real_escape_string(date('Y-m-d H:i:s'))."',
    '$newfilename'
  )")){
    echo '1';
  }else{
    echo $mysqli->error;
    echo '0';
  }
}
?>