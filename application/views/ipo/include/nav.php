<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?=base_url('ipo-member'); ?>" class="brand-link">
		<img src="<?=base_url('assets/img/logo.png'); ?>" alt="Neways" class="member_logo brand-image elevation-3" style="width:50px;width: 50px; margin-left: 3px; margin-top: 3px;">
		<span class="brand-text font-weight-light">Investor Panel</span>
    </a>
    <div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">		
				<img src="<?php if(!empty($ipo_member_information)){ echo base_url($ipo_member_information->personal_images); }else{ echo base_url('assets/img/photo_avatar.png'); } ?>" class="img-circle elevation-2" alt="User Image" style="height: 2.1rem; width: 2.1rem;">
			</div>
			<div class="info">
				<a href="<?=base_url('ipo-member'); ?>" class="d-block"><?php if(!empty($ipo_member_information)){ echo $ipo_member_information->personal_full_name; } ?></a>
			</div>	
		</div>
		<div class="col-sm-12">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-wallet"></i>						
						<span style="color:#f00;font-weight:bolder;font-size:15px;"><?php if(!empty($ipo_member_balance)){ echo money($ipo_member_balance->balance); } ?></span>
					</a>
				</li>
				<li class="nav-item has-treeview">
					<a href="<?=base_url('ipo-member/logout'); ?>" class="nav-link">
						<i class="nav-icon fas fa-sign-out-alt"></i>
						Logout
					</a>
				</li>
			</ul>
			<hr style="border: solid 0.5px #4f5962;"/>
		</div>		
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item has-treeview">
					<a href="<?=base_url('ipo-member'); ?>" id="dashboard_nav" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>
				
				<li class="nav-item has-treeview">
					<a href="<?=base_url('ipo-member/ipo-referal-aproval'); ?>" id="ipo_referal_aproval" class="nav-link">
						<i class="nav-icon fas fa-tasks"></i>
						<p>Investor Referal Aproval</p>
					</a>
				</li>
				
				<li class="nav-item has-treeview">
					<a href="<?=base_url('ipo-member/ipo-referal-member'); ?>" id="ipo_referal_member" class="nav-link">
						<i class="nav-icon fas fa-list-ul"></i>
						<p>Investor Referal Member</p>
					</a>
				</li>
				
				<li class="nav-item has-treeview">
					<a href="<?=base_url('ipo-member/ipo-member-balance-widthdraw'); ?>" id="ipo_widthdraw_member" class="nav-link">
						<i class="nav-icon fas fa-money-check-alt"></i>
						<p>Widthdraw Request</p>
					</a>
				</li>
				
				<li class="nav-item has-treeview">
					<a href="#" id="my_profile" class="nav-link">
						<i class="nav-icon fas fa-hand-holding-usd"></i>
						<p>
							My Profile
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url('ipo-member/view-profile'); ?>" id="view_profile" class="nav-link ">
								<i class="far fa-circle nav-icon"></i>
								<p>View Profile</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="<?=base_url('ipo-member/change-password'); ?>" class="nav-link" id="change_password_nav">
								<i class="far fa-circle nav-icon"></i>
								<p>Change Password</p>
							</a>
						</li>
						
					</ul>
				</li>
			</ul>
		</nav>
    </div>
</aside>