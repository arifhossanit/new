<?php
include("../../../application/config/ajax_config.php");
function time_elapsed_string($ptime) { $etime = time() - $ptime; if ($etime < 1) { return '0 seconds'; } $a = array( 365 * 24 * 60 * 60  =>  'year', 30 * 24 * 60 * 60  =>  'month',  24 * 60 * 60  =>  'day',  60 * 60  =>  'hour',  60  =>  'minute',  1  =>  'second' ); $a_plural = array( 'year'   => 'years', 'month'  => 'months', 'day'    => 'days', 'hour'   => 'hours', 'minute' => 'minutes', 'second' => 'seconds' ); foreach ($a as $secs => $str) { $d = $etime / $secs;  if ($d >= 1) { $r = round($d); return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago'; } } }
if(isset($_POST['user_id'])){
	$total_notification = 0;
	$sql = $mysqli_notification->query("SELECT * from notification where user_id = '".$_POST['user_id']."' and user_type = '1' order by id desc limit 50");
	$number_of_unseen_notification = mysqli_fetch_assoc($mysqli_notification->query("SELECT count(id) as unseen_notificatin from notification where user_id = '".$_POST['user_id']."' and user_type = '1' AND is_read = 1"));
	while( $row = mysqli_fetch_assoc($sql) ){
		$n_info[] = array(
			'id'			=> $row['id'],
			'user_id' 		=> $row['user_id'],
			'user_type' 	=> $row['user_type'],
			'n_header' 		=> $row['n_header'],
			'n_message'		=> $row['n_message'],
			'n_links' 		=> $row['n_links'],
			'time' 			=> $row['time'],
			'data' 			=> $row['data'],
			'time_stamp' 	=> $row['time_stamp'],
			'is_read' 		=> $row['is_read'],
			'uploader_info' => $row['uploader_info']
		);
	}
	if(empty($n_info)){
?>
	<span class="dropdown-header">0 Notifications</span>________0________0
<?php }else{ ?>						
<?php
	foreach($n_info as $data){
		if($data['is_read'] == 1){ 
			$background = '';
		}else{
			$background = 'style="background:#eee;color:#333;"';
		}
?>	
	<div class="dropdown-divider"></div>
	<a onclick="notification_open_link(<?php echo $data['id']; ?>)" href="javascript:void(0);" class="dropdown-item" <?php echo $background; ?>>
		<div class="media">
			<i class="fas fa-envelope" style="width: 24px; margin-top: 4px; color: #cdcdcd;"></i>
			<div class="media-body" title="<?php echo $data['n_header']; ?> :: <?php echo $data['n_message']; ?>">
				<h3 class="dropdown-item-title">
					<p style="width: 180px; height: 20px; float: left; overflow: hidden;margin:0px;font-weight:600;"><?php echo $data['n_header']; ?></p>
					<span style="float:right;font-size:10px;"><i class="far fa-clock mr-1"></i> <?php echo time_elapsed_string($data['time_stamp']); ?></span>
				</h3><br />								
				<p class="text-sm" style="margin-top: -20px;">
					<p style="float: left; width: 220px; height: 23px; overflow: hidden;margin:0px;"><?php echo $data['n_message']; ?></p>
					<?php if($data['is_read'] == 1){ ?>
					<span class="float-right text-sm text-danger">
						<i class="fas fa-circle" style="font-size:10px;"></i>
					</span>
					<?php } ?>
				</p>								
			</div>
		</div>
	</a>
<?php } ?>
	<div class="dropdown-divider"></div>
	<a href="<?php echo $home; ?>admin/all-notification" class="dropdown-item dropdown-footer">See All Notifications</a>________<?php echo $number_of_unseen_notification['unseen_notificatin']; ?>	
<?php 
	if($_POST['notify_session'] != $total_notification){
		$_SESSION['push_notify'] = $total_notification;
		$row = mysqli_fetch_assoc($mysqli_notification->query("select * from notification where user_id = '".$_POST['user_id']."' and user_type = '1' order by id desc limit 01"));
		echo '________1________'.$row['n_header'].'________'.$row['n_message'].'________'.$total_notification.'';
	}else{
		echo '________0';
	}
}  } ?>
<?php 
if(isset($_POST['open_link_id'])){
	if($mysqli_notification->query("UPDATE notification set is_read = '0' where id = '".$_POST['open_link_id']."'")){
		$row = mysqli_fetch_assoc($mysqli_notification->query("select * from notification where id = '".$_POST['open_link_id']."'"));
		echo $row['n_links'];
	}else{
		echo $home;
	}
}
?>