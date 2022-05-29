<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?=base_url('member'); ?>" class="brand-link">
		<img src="<?=base_url('assets/img/logo.png'); ?>" alt="Neways" class="member_logo brand-image elevation-3" style="width:50px;width: 50px; margin-left: 3px; margin-top: 3px;">
		<span class="brand-text font-weight-light">Member Panel</span>
    </a>
    <div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">		
				<img src="<?php if(!empty($profile_picture)){ echo base_url($profile_picture->photo_avater); }else{ echo base_url('assets/img/photo_avatar.png'); } ?>" class="img-circle elevation-2" alt="User Image" style="height: 2.1rem; width: 2.1rem;">
			</div>
			<div class="info">
				<a href="<?=base_url('member'); ?>" class="d-block"><?php if(!empty($profile_picture)){ echo $profile_picture->full_name; } ?></a>
			</div>	
		</div>
		<div class="col-sm-12">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-money-check-alt"></i>
						SH Point: <span style="color:#f00;font-weight:bolder;font-size:15px;font-size: 25px;position: absolute; margin-top: -6px; margin-left: 10px;"><?php if(!empty($sh_point)){ echo $sh_point->balance; } ?></span>
					</a>
				</li>
				<li class="nav-item has-treeview">
					<a href="<?=base_url('member/logout'); ?>" class="nav-link">
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
					<a href="<?=base_url('member'); ?>" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>Dashboard</p>
					</a>
				</li>
				
				<?php
					if(!empty($profile_picture) AND $profile_picture->status == 1){
						if(!empty($cancel_data)){ 
				?>				
				<li class="nav-item has-treeview">
					<a href="<?=base_url('member/widthdraw-cancel-request'); ?>" class="nav-link">
						<i class="nav-icon fas fa-user-check" style="color:#00ff00;"></i>
						<p>Widthdraw Cancel</p>
					</a>
				</li>				
				<?php }else{ ?>
				<li class="nav-item has-treeview">
					<a href="<?=base_url('member/request-for-cancel'); ?>" class="nav-link">
						<i class="nav-icon fas fa-user-times" style="color:red;"></i>
						<p>Request For Cancel</p>
					</a>
				</li>
				<?php } } ?>
				<!--
				<li class="nav-item has-treeview">
					<a href="<?=base_url('member/get-free-award'); ?>" class="nav-link">
						<i class="nav-icon fas fa-coffee"></i>
						<p>Get Free Award</p>
					</a>
				</li>
				-->
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-user"></i>
						<p>
							My Profile
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url('member/view-profile'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>View Profile</p>
							</a>
						</li>
						<!--
						<li class="nav-item">
							<a href="<?=base_url('member/booking-info'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Booking Info</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="<?=base_url('member/recharge-renew-rental-info'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Rental/Renew Info</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="<?=base_url('member/recharge-shpoint'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Recharge SHpoint</p>
							</a>
						</li>-->
						
						<li class="nav-item">
							<a href="<?=base_url('member/change-password'); ?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Change Password</p>
							</a>
						</li>
						
					</ul>
				</li>
				<!--
				<li class="nav-item has-treeview">
					<a href="<?=base_url('member/tea-coffee/null/null/null'); ?>" class="nav-link">
						<i class="nav-icon fas fa-coffee"></i>
						<p>Tea / Coffee</p>
					</a>
				</li>-->
			</ul>
		</nav>

    </div>
</aside>