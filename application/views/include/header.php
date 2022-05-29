<?php
function check_permission($menu_id){
	$CI =& get_instance();
	$CI->load->database();
	$mysqli = new mysqli($CI->db->hostname, $CI->db->username, $CI->db->password, $CI->db->database);
	$role_id = $_SESSION['super_admin']['role_id'];
	$check = mysqli_fetch_assoc($mysqli->query("select field_code from role_fields where field_code = '".$menu_id."'"));
	if(!empty($check['field_code'])){
		if($role_id == '2805597208697462328'){
			return true;
		}else{	
			$get_permission = mysqli_fetch_assoc($mysqli->query("select ".$menu_id." from role_peermission where role_id = '".$role_id."' and ".$menu_id." = '1'"));
			if(!empty($get_permission[$menu_id]) AND $get_permission[$menu_id] == 1){
				return true;
			}else{
				return false;
			}
		}
	}else{
		return true;
	}
}

	if($_SESSION['super_admin']['user_type'] == 'Super Admin'){
		$branch_id = "";
		$button_view = '<button onclick="return view_branch_wise_up_down();" type="button" class="btn btn-dark btn-xs" style="background-color: rgba(0,0,0,0.1); border: none;"><i class="far fa-eye"></i></button>';
	}else{
		$branch_id = "branch_id = '".$_SESSION['super_admin']['branch']."' and ";
		$button_view = '';
	}
	$today = date('Y-m-d');
	$_days_before = date('Y-m-d', strtotime(date('Y/m/d'). ' - 30 days'));
	$today_booking = $this->Dashboard_model->mysqlii("select count(*) as total_checkin from booking_info where $branch_id id != '' and STR_TO_DATE(checkin_date,'%d/%m/%Y') BETWEEN '$_days_before' AND '$today'");
	$today_checkout = $this->Dashboard_model->mysqlii("select count(*) as total_checkout from booking_info where $branch_id id != '' and STR_TO_DATE(checkout_date,'%d/%m/%Y') BETWEEN '$_days_before' AND '$today'");
	$comming = $today_booking[0]->total_checkin;
	$going = $today_checkout[0]->total_checkout;
	if($comming > $going){
		$dell__plus = $comming - $going;
		$sell_info = '<div style="position: absolute; top: 0.8%; right: 26%; color: #28a745; text-shadow: 0 0 black; font-size: 25px;"> SALE: <i class="fas fa-long-arrow-alt-up"></i> + '.$dell__plus.' '.$button_view.'</div>';
	}else if($comming < $going){
		$dell__plus = $going - $comming;
		$sell_info = '<div style="position: absolute; top: 0.8%; right: 26%; color: #dc3545; text-shadow: 0 0 black; font-size: 25px;"> SALE: <i class="fas fa-long-arrow-alt-down"></i> - '.$dell__plus.'  '.$button_view.'</div>';
	}else if($comming == $going){
		$dell__plus = 0;
		$sell_info = '<div style="position: absolute; top: 0.8%; right: 26%; color: #fd7e14; text-shadow: 0 0 black; font-size: 25px;"> SALE: <i class="fas fa-arrows-alt-v"></i> '.$dell__plus.'  '.$button_view.'</div>';
	}
?>

<div class="header" style="height:auto;">
	<div class="container-flud">
		<span id="timer_interval" style="position: absolute; right: 1%;line-height:20px;"></span>
		<a href="<?=base_url('admin'); ?>">
			<img src="<?=base_url('assets/img/neways.png');?>" style="width: 175px;padding: 15px;" alt="Neways" title="Neways"/>
		</a>
			<!-------------------------------------------->
			<!-- Right navbar links -->
		<?php  ?>
		<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto" style="float:right;position: absolute;top: 0.7%;right: 14%;">
		<?php /* ?>				
			<!-- Messages Dropdown Menu -->
			<li class="nav-item dropdown">
			  <a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fas fa-comments"></i>
				<span class="badge badge-danger navbar-badge">3</span>
			  </a>
			  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<a href="#" class="dropdown-item">
				  <!-- Message Start -->
				  <div class="media">
					<img src="<?php echo base_url('assets/'); ?>dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
					<div class="media-body">
					  <h3 class="dropdown-item-title">
						Brad Diesel
						<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
					  </h3>
					  <p class="text-sm">Call me whenever you can...</p>
					  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
					</div>
				  </div>
				  <!-- Message End -->
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
				  <!-- Message Start -->
				  <div class="media">
					<img src="<?php echo base_url('assets/'); ?>dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
					<div class="media-body">
					  <h3 class="dropdown-item-title">
						John Pierce
						<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
					  </h3>
					  <p class="text-sm">I got your message bro</p>
					  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
					</div>
				  </div>
				  <!-- Message End -->
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
				  <!-- Message Start -->
				  <div class="media">
					<img src="<?php echo base_url('assets/'); ?>dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
					<div class="media-body">
					  <h3 class="dropdown-item-title">
						Nora Silvester
						<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
					  </h3>
					  <p class="text-sm">The subject goes here</p>
					  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
					</div>
				  </div>
				  <!-- Message End -->
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
			  </div>
			</li>-->
			<?php */ ?>
			<!-- Notifications Dropdown Menu -->
		</ul>
				<!-------------------------------------------->
		<button class="btn btn-sm btn-success">User: <b><?=$_SESSION['user_info']['user']; ?></b></button>
		<button class="btn btn-sm btn-success">Branch: <b><?=$_SESSION['user_info']['branch_name']; ?></b></button>
		<!-- <button onclick="return view_my_life_history()" class="btn btn-sm btn-success" style="padding:2px;height:30.8px;padding-left:10px;padding-right:10px;"> <i class="fas fa-chart-line"></i>&nbsp;&nbsp; My History </button> -->
		<!--start wallet-->
		<div class="btn-group">
			<?php 
				$award_wallet = $this->Dashboard_model->mysqlii("select * from employee_award_wallet where employee_id = '".$_SESSION['super_admin']['employee_ids']."'");
			?>
			<button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownmenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:2px 15px;height:30.8px;">
				<i class="fas fa-wallet"></i>&nbsp; My Wallet:&nbsp;&nbsp;&nbsp; <span style="font-weight:bolder;color:#ffeb00;"> <?php
				$money = !empty($award_wallet[0]->balance) ? $award_wallet[0]->balance : 0;
				echo money($money); ?> </span> &nbsp;&nbsp;&nbsp;
			</button>
			<div class="dropdown-menu" aria-labelledby="dropdownmenu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 35px, 0px); top: 0px; left: 0px; will-change: transform;">
				<a class="dropdown-item" href="<?php echo base_url('admin/profile/award-money-widthdraw'); ?>">Widthdraw</a>
				<a class="dropdown-item" href="#">Diposit</a>
				<a class="dropdown-item" href="<?php echo base_url('admin/profile/employee-award-money-transfer'); ?>">Transfer</a>
				<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
				<a class="dropdown-item" href="<?=base_url('admin/report/hrm-report/employee-wallet-report');?>">View All</a>
				<?php } ?>
			</div>					
		</div>
		<!--end wallet-->
		<!-- <button class="btn btn-sm btn-success dashboard_select" style="padding:2px;height:30.8px;">
			<div class="form-group" style="width:200px;">
				<select class="form-control select2" id="video_tutorials">
					<option value="">View Tutorials</option>
					<optgroup label="Software">
						<?php
							if(!empty($_SESSION['software_video_tutorials'])){
								foreach($_SESSION['software_video_tutorials'] as $row){
									echo '<option value="'.$row->tutorials_url.'" title="'.$row->note.'">'.$row->title.'</option>';
								}
							}
						?>
					</optgroup>							
					<optgroup label="Dingtalk">
						<?php
							if(!empty($_SESSION['dingtalk_video_tutorials'])){
								foreach($_SESSION['dingtalk_video_tutorials'] as $row){
									echo '<option value="'.$row->tutorials_url.'" title="'.$row->note.'">'.$row->title.'</option>';
								}
							}
						?>
					</optgroup>
				</select>
			</div>
		</button> -->
		<button class="btn btn-sm btn-success" style="padding:2px;height:30.8px;">
			<div>
				<div id="google_translate_element"></div>				
			</div>
		</button>
		<a href="<?php echo base_url("admin/anyversary_report"); ?>" class="btn btn-sm btn-success anniversary" style="padding:2px;height:30.8px;">
			<div>
				Anniversary				
			</div>
		</a>
		<a href="<?php echo base_url("admin/s_it/tasks"); ?>" class="btn btn btn-primary" >
			<div>
			<i class="fas fa-tasks"></i> Task/Todo List				
			</div>
		</a>
		<?php if(($_SESSION['user_info']['employee_id'] == 1) && $_SESSION['user_info']['user'] == 'Md. Ibrahim Khalil' ){ ?>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#IbrahimSirModal">
			Options
		</button>
		<!-- Modal -->
		<div class="modal fade" id="IbrahimSirModal" tabindex="-1" role="dialog" aria-labelledby="IbrahimSirModal" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Options</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<a href="<?php print base_url('contacts'); ?>">
							<button class="btn btn-success">Contacts</button>
						</a>
						<button class="btn btn-success contacts_download">Download All</button>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		
		
		
		
		
		
		<?php 
			echo $sell_info;			
		?>
		
		
		
	</div>
</div>

<script>
$(document).on("click", ".contacts_download", function(){
	console.log("downloading");
	var url = "<?php echo base_url();?>"+"admin/download/contacts";   
    window.open(url);
});
</script>