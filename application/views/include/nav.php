<nav class="main-header navbar navbar-expand-md navbar-light navbar-white c_i_w" style="z-index: 999;">
	<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="row" style="width: 100%;">
		<div class="collapse navbar-collapse order-3 justify-content-center col-auto" id="navbarCollapse">
			<ul class="navbar-nav button-group">
				<li data-toggle="tooltip" data-placement="top" title="Side Menu">
					<a id="trigger" class="btn btn-info btn_sdo">

						<i class="nav-icon fas fa-align-justify"></i>			
					</a>
				</li>
				<li data-toggle="tooltip" data-placement="top" title="Home">
					<a href="<?=base_url('admin/');?>" class="btn btn-info btn_sdo">
						<i class="nav-icon fas fa-home"></i>				
					</a>
				</li>		
				
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Dashboard">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-success btn_sdo btn-sm myButton">
						<i class="nav-icon fas fa-tachometer-alt"></i>
					</a>				
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li><a href="<?=base_url('admin/dashboard');?>" class="dropdown-item">Booking Dashboard</a></li>
						<li><a href="#" class="dropdown-item">HRM Dashboard</a></li>
						<li><a href="#" class="dropdown-item">Accounting Dashboard</a></li>
						<li><a href="#" class="dropdown-item">Inventory Dashboard</a></li>
					</ul>				
				</li>	
				<?php if(check_permission('role_1642758068_90')){ ?>
				
					<li class="nav-item dropdown">
						<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-info btn_sdo">
							<i class="fas fa-building"></i>
							BAR
						</a>				
						<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						
								<li><a href="<?=base_url('admin/add_building_info');?>" class="dropdown-item">Add Building Information</a></li>				
								<li><a href="<?=base_url('admin/all_building_info');?>" class="dropdown-item">All  Building Information</a></li>
												
							
						</ul>
					</li>

				<?php } ?>
				
				<?php if(check_permission('role_1606369891_33')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Front Office">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-success btn_sdo">
						<i class="fas fa-building"></i>
					</a>				
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Front Work Area</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
							<?php if(check_permission('role_1606369970_26')){ ?>
								<li><a href="<?=base_url('admin/front-office/booking-enquery');?>" class="dropdown-item">Booking Enquiry</a></li>
							<?php }if(check_permission('role_1606369970_92')){ ?>
								<li><a href="<?=base_url('front-office/visitor-book/visitor-book');?>" class="dropdown-item">Visitor Book</a></li>
							<?php } /* if(check_permission('role_1606369970_54')){ ?>
								<li><a href="<?=base_url('admin/front-office/phone-call-logs');?>" class="dropdown-item">Phone Call Logs</a></li>
							<?php } */ if(check_permission('role_1606369970_79')){ ?>
								<li><a href="<?=base_url('admin/front-office/postal-dispatch');?>" class="dropdown-item">Postal Dispatch</a></li>
							<?php } if(check_permission('role_1606369970_16')){ ?>
								<li><a href="<?=base_url('admin/front-office/postal-dispatch');?>" class="dropdown-item">Postal Receive</a></li>
							<?php } if(check_permission('role_1606369970_67')){ ?>
								<li><a href="<?=base_url('admin/front-office/complain');?>" class="dropdown-item">Complain</a></li>
							<?php } if(check_permission('role_1606369970_85')){ ?>
								<li><a href="<?=base_url('admin/front-office/front-office-setup');?>" class="dropdown-item">Front Office Setup</a></li>
							<?php } ?>
							</ul>
						</li>
							<li><a href="<?=base_url('ipo-pre-registration');?>" target="_blank" class="dropdown-item">Investor Pre-Book Form</a></li>
							<li><a href="<?=base_url('pre-book-and-pre-booking-form');?>" target="_blank" class="dropdown-item">PreBook Form</a></li>
							<li><a href="<?=base_url('package-plan');?>" target="_blank" class="dropdown-item">Package Plan</a></li>
						<?php if(check_permission('role_1606369970_55')){ ?>
							<li><a href="<?=base_url('admin/front-office/refreshment-iteam');?>" class="dropdown-item">Shop</a></li>
							<li class="dropdown-submenu dropdown-hover">
								<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Instant Transaction</a>
								<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
									<li><a href="<?=base_url('admin/front-office/instant-transaction/buy-something');?>" class="dropdown-item">Buy Something</a></li>
									<li><a href="<?=base_url('admin/front-office/instant-transaction/other-transaction');?>" class="dropdown-item">Other Transaction</a></li>
									<li><a href="<?=base_url('admin/accounting/transaction/view-instant-transaction-buy-something');?>" class="dropdown-item">Instant Transaction Report</a></li>
									<li><a href="<?=base_url('admin/accounting/transaction/view-instant-transaction-buy-something-slip'); ?>" class="dropdown-item">Instant (Buy Something) Slip</a></li>
									<!-- <li><a href="<?=base_url('admin/manage-expense'); ?>" class="dropdown-item">New Expense</a></li>
									<li><a href="<?=base_url('admin/view-expenses'); ?>" class="dropdown-item">View Expenses</a></li> -->
								</ul>
							</li>
						<?php } ?>					
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Member Meal</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<?php if(check_permission('role_1606369970_86')){ ?>
								<li class="dropdown-submenu dropdown-hover">
									<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Dining Table</a>
									<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
									<?php
										$branch_array = array();
										$dining_branches = $this->Dashboard_model->mysqlii("SELECT * FROM branches ORDER BY id DESC");
										foreach($dining_branches as $branch){
											$branch_array[] = array(
												'branch_id' => $branch->branch_id,
												'branch_name' => $branch->branch_name
											);
									?>
										<li><a href="<?=base_url('dining-table/member-status-check/'.rahat_encode($branch->branch_id).'/'.rahat_url($branch->branch_name).'');?>" target="_blank" class="dropdown-item"><?php echo $branch->branch_name;?></a></li>
									<?php } ?>
									</ul>
								</li>
								<?php } ?>
								<li class="dropdown-submenu dropdown-hover">
									<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Food Menu</a>
									<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
										<li><a href="<?=base_url('admin/front-office/add-food-menu');?>" class="dropdown-item">Add Food Menu</a></li>
										<li><a href="<?=base_url('admin/front-office/manage-food-menu');?>" class="dropdown-item">Manage Food Menu</a></li>
										<li><a href="<?=base_url('admin/front-office/add-feedback-emoji');?>" class="dropdown-item">Add Feedback Emoji</a></li>
										<li><a href="<?=base_url('admin/front-office/manage-feedback-emoji');?>" class="dropdown-item">Manage Feedback Emoji</a></li>
										<li><a href="<?=base_url('member-food-feedback');?>" target="_blank" class="dropdown-item">Food Feedback Page</a></li>
									</ul>
								</li>
							</ul>
						</li>
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:185px;">Front Door Lock</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<?php foreach($branch_array as $row){ ?>
								<li><a href="<?=base_url('dining-table/front-door-lock/'.rahat_encode($row['branch_id']).'/'.rahat_url($row['branch_name']).'');?>" target="_blank" class="dropdown-item">Entrance Gate (<?php echo $row['branch_name']; ?>)</a></li>
								<?php } ?>
							</ul>
						</li>					
					</ul>
				</li>
				<?php } if(check_permission('role_1606370617_73')){ if($_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
				<li class="nav-item dropdown">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-success btn_sdo">
						<i class="nav-icon fas fa-edit"></i>
						Booking
					</a>				
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li><a href="<?=base_url('admin/booking');?>" class="dropdown-item">Booking</a></li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Target Setup</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/booking/booking-target-setup'); ?>" class="dropdown-item">Occupency Target Setup</a></li>
								<li><a href="<?=base_url('admin/create/award/sales-award');?>" class="dropdown-item">Award Point Target Setup</a></li>
								<li><a href="<?=base_url('admin/create/award/investor_facilities_setup');?>" class="dropdown-item">Investor Facility Setup</a></li>
								<li><a href="<?=base_url('admin/create/award/employee-ipo-commission-setup');?>" class="dropdown-item">Employee Ipo Commission Setup</a></li>
								<li><a href="<?=base_url('admin/create/award/badge');?>" class="dropdown-item">Badge Setup</a></li>
							</ul>
						</li>
					</ul>					
				</li>
				<?php }else{ ?>
				<li class="nav-item dropdown">
					<a id="dropdownSubMenu1" href="<?=base_url('admin/booking');?>" class="nav-link btn btn-success btn_sdo btn-sm" style="width:114.63px !important;">
						<i class="nav-icon fas fa-edit"></i>
						Booking
					</a>
				</li>
				<?php } } if(check_permission('role_1621942604_55')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Investment">
					<a id="dropdownSubMenu1" href="<?=base_url('admin/ipo');?>" class="nav-link btn btn-dark btn_sdo">
						<i class="nav-icon fas fa-house-user"></i>
					</a>
				</li>
				<?php } if(check_permission('role_1606370779_67') || $_SESSION['super_admin']['employee_ids'] == '71167'){ ?> <!-- Manually added Ahasan Vai -->
					<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Inventory">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-info btn_sdo">
						<i class="fas fa-layer-group"></i>						
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Items Manager</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/scm/product-category');?>" class="dropdown-item">Add Product Name</a></li>
								<li><a href="<?=base_url('admin/scm/add-product');?>" class="dropdown-item">Add New Product Details</a></li>
								<li><a href="<?=base_url('admin/scm/products-list');?>" class="dropdown-item">Manage Products</a></li>
								<li><a href="<?=base_url('admin/scm/service-product');?>" class="dropdown-item">Add Service Product</a></li>
								<li><a href="<?=base_url('admin/scm/manage-service-product');?>" class="dropdown-item">Manage Services Products</a></li>
							</ul>
						</li>
						<!-- <li><a href="#" class="dropdown-item">Product Categories</a></li> -->
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Warehouse</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/scm/warehouses');?>" class="dropdown-item">Manage Warehouses</a></li>
								<li><a href="<?=base_url('admin/scm/warehouse-stock');?>" class="dropdown-item">Warehouse Stock</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Damaged/Stolen</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/scm/manage-damaged-product');?>" class="dropdown-item">Manage Damaged Product</a></li>
								<li><a href="<?=base_url('admin/scm/out-of-order');?>" class="dropdown-item">Out of Order Products</a></li>
								<li><a href="<?=base_url('admin/scm/stolen');?>" class="dropdown-item">Stolen Products</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Requisitions</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/scm/requisitions');?>" class="dropdown-item">Manage Requisitions</a></li>
								<li><a href="<?=base_url('admin/scm/department-requisitions');?>" class="dropdown-item">Department Requisitions</a></li>
							</ul>
						</li>
						<!-- <li><a href="#" class="dropdown-item">Stock Transfer</a></li> -->
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Purchase Order</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/scm/product-requisition/requisition-type/purchase-order')?>" class="dropdown-item">New Pre-Order</a></li>
								<li><a href="<?=base_url('admin/scm/manage-product-purchase')?>" class="dropdown-item">Manage Pre-Order</a></li>
								<li><a href="<?=base_url('admin/scm/manage-product-order')?>" class="dropdown-item">Manage Purchase Order</a></li>
								<li><a href="<?=base_url('admin/scm/manage-food-product-order')?>" class="dropdown-item">Manage Food Product Order</a></li>
							</ul>
						</li>
						<!-- <li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Stock Return</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="#" class="dropdown-item">Suppliers Records</a></li>
								<li><a href="#" class="dropdown-item">Customers Records</a></li>
							</ul>
						</li> -->
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Suppliers</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<!-- <li><a href="<?=base_url('admin/scm/manage-supplier');?>" class="dropdown-item">New Supplier</a></li> -->
								<li><a href="<?=base_url('admin/scm/manage-supplier');?>" class="dropdown-item">Manage Suppliers</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Products Label</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/scm/product-type');?>" class="dropdown-item">Add Product Scales</a></li>
								<li><a href="<?=base_url('admin/scm/product-type/extra-specification');?>" class="dropdown-item">Add Additional Product Configuration</a></li>
								<!-- <li><a href="" class="dropdown-item">Add Products</a></li> -->
								<!-- <li><a href="" class="dropdown-item">Products List</a></li> -->
								<li><a href="<?=base_url('admin/scm/product-brands');?>" class="dropdown-item">Add Product Brands</a></li>
								<li><a href="#" class="dropdown-item">Add Product Scales</a></li>
								<!-- <li><a href="#" class="dropdown-item">Custom Label</a></li> -->
								<!-- <li><a href="#" class="dropdown-item">Standard Label</a></li> -->
							</ul>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php if(check_permission('role_1606370938_63')){ ?> <!----CRM Department---->
				<li class="nav-item dropdown">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-info btn_sdo">
						<i class="fas fa-users"></i>
						C R M
					</a>				
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<?php if(check_permission('role_1606371009_29')){ ?>
							<li><a href="<?=base_url('admin/member-directory');?>" class="dropdown-item">Member Directory</a></li>				
							<li><a href="<?=base_url('admin/group-directory');?>" class="dropdown-item">Group Directory</a></li>				
						<?php } if(check_permission('role_1606371277_46')){ ?>
							<li><a href="<?=base_url('admin/rental-information');?>" class="dropdown-item">Rental Information</a></li>					
						<?php } if(check_permission('role_1606371514_25')){ ?>
							<li><a href="<?=base_url('admin/checkout-members-directory');?>" class="dropdown-item">CheckOut Members</a></li>				
						<?php } if(check_permission('role_1606371560_65')){ ?>
							<li><a href="<?=base_url('admin/checkout-booking-directory');?>" class="dropdown-item">CheckOut Booking</a></li>
						<?php } if(check_permission('role_1606371641_16')){ ?>
							<li><a href="<?=base_url('old-data/old-member-directory');?>" target="_blank" class="dropdown-item">Old Member Directory</a></li>
						<?php } ?>
						<li><a href="<?=base_url('admin/pre-book-member-directory');?>" class="dropdown-item">PreBook Member Directory</a></li>
						<li><a href="<?=base_url('admin/pre-book-member-directory-search');?>" class="dropdown-item">PreBook Member Search</a></li>
					</ul>
				</li>
				<?php } if(check_permission('role_1606372592_17')){ ?> <!---HRM Department--->
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="H R M Department">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-success btn_sdo">
						<small class="fas fa-users"> HR</small> 						
					</a>			
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="min-width: 185px !important;">
						<?php if(check_permission('role_1606372615_41')){ ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Employee Directory</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/employ-directory');?>" class="dropdown-item">Employee List</a></li>
								<li><a href="<?=base_url('employee-information-form/new-employee-details-form'); ?>" class="dropdown-item" target="_blank">Employee Add Request</a></li>
								<li><a href="<?=base_url('admin/hrm/employee-prebook-request'); ?>" class="dropdown-item">Employee Add Form</a></li>
								<li><a href="<?=base_url('admin/exit-employee-directory'); ?>" class="dropdown-item">Exit-Employee Directory</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">DPT: & Designatiion</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/manage-department');?>" class="dropdown-item">Department Management</a></li>
								<li><a href="<?=base_url('admin/manage-designation'); ?>" class="dropdown-item">Designation Management</a></li>
							</ul>
						</li>
						<?php } if(check_permission('role_1606372807_67')){ ?>
						<?php  ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Payroll</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<?php if(check_permission('role_1606372854_63')){ ?>								
									<li><a href="<?=base_url('admin/hrm/payroll/set-attendance-bonus'); ?>" class="dropdown-item">Set Attendance Bonus</a></li>
									<li><a href="<?=base_url('admin/hrm/payroll/set-department-head'); ?>" class="dropdown-item">Set Department Head</a></li>
								<?php } if(check_permission('role_1606372854_90')){ ?>
									<li><a href="<?=base_url('admin/hrm/payroll/employee-salary-deduction'); ?>" class="dropdown-item">Salary Deduction</a></li>
									<li><a href="<?=base_url('admin/hrm/payroll/employee-extra-salary'); ?>" class="dropdown-item">Extra Salary</a></li>
								<?php }  if(check_permission('role_1606372854_89')){ ?>
									<li><a href="<?=base_url('admin/hrm/payroll/employee-salary-generate'); ?>" class="dropdown-item">Salary Generate</a></li>
									<li><a href="<?=base_url('admin/accounting/transaction/employee-salary'); ?>" class="dropdown-item">Employee Salary</a></li>
									<li><a href="<?=base_url('admin/profile/employee-fired-request-aproval'); ?>" class="dropdown-item">Employee Fired Aproval</a></li>
								<?php } if(check_permission('role_1606372855_18')){ ?>
									<!--<li><a href="#" class="dropdown-item">Manage Employee Salary</a></li>-->
								<?php }  ?>
							</ul>
						</li>
						<?php  ?>
						<?php } if(check_permission('role_1606372879_35')){ ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Attendants</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<?php if( !empty($_SESSION['user_info']['department']) AND $_SESSION['user_info']['department'] == '816905694932688665' ){
									if(check_permission('role_1606372930_48')){ ?>
									<li><a href="<?=base_url('admin/hrm/attendance/attencance-form'); ?>" class="dropdown-item">Attendance Form</a></li>
								<?php } } ?> 
								
								<?php if(check_permission('role_1606372930_45')){ ?>
									<li><a href="<?=base_url('admin/hrm/attendance/yearly-attendance'); ?>" class="dropdown-item">Yearly Attendance</a></li>
								<?php } if(check_permission('role_1606372930_66')){ ?>
									<li><a href="<?=base_url('admin/hrm/attendance/missing-attencance-form'); ?>" class="dropdown-item">Missing Attendance</a></li>
								<?php } if(check_permission('role_1606372930_43')){ ?>
									<li><a href="<?=base_url('admin/hrm/attendance/attencance-log');?>" class="dropdown-item">Attendance Log</a></li>
								<?php } if(check_permission('role_1606372930_88')){ ?>
									<li><a href="<?=base_url('admin/hrm/attendance/attencance-overview');?>" class="dropdown-item">Attendance Overview</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php } if(check_permission('role_1606373024_73')){ ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Recruitment</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<?php if(check_permission('role_1606373024_48')){ ?>
									<li><a href="#" class="dropdown-item">Add New Candidate</a></li>
								<?php } if(check_permission('role_1606373024_55')){ ?>
									<li><a href="#" class="dropdown-item">Manage Candidate</a></li>
								<?php } if(check_permission('role_1606373024_21')){ ?>
									<li><a href="<?=base_url('admin/hrm/recruitment/candidate-shortlist');?>" class="dropdown-item">Candidate Shortlist</a></li>
								<?php } if(check_permission('role_1606373024_24')){ ?>
									<li><a href="#" class="dropdown-item">Interview</a></li>
								<?php } if(check_permission('role_1606373024_19')){ ?>
									<li><a href="#" class="dropdown-item">Candidate Selection</a></li>
								<?php } ?>
									<li><a href="<?=base_url('admin/hrm/recruitment/today-candidate-attendance'); ?>" class="dropdown-item">Today Candidate Attendance</a></li>
				
									<li><a href="<?=base_url('admin/hrm/recruitment/recruitment_approved_logs'); ?>" class="dropdown-item">Recruitment Approved Logs</a></li>
									<li><a href="<?=base_url('admin/hrm/recruitment/add_department'); ?>" class="dropdown-item">Add Department</a></li>   
							</ul>
						</li>

						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Job Post</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">

									<li><a href="<?=base_url('admin/hrm/add_circular'); ?>" class="dropdown-item">Add Circular</a></li>

									<li><a href="<?=base_url('admin/hrm/all_circular'); ?>" class="dropdown-item">All Circular</a></li>
							</ul>
						</li>
						<?php } if(check_permission('role_1606373088_61')){ ?>
						<?php  ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Advance Salary</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<?php if(check_permission('role_1606373088_41')){ ?>
									<li><a href="<?php echo base_url('admin/hrm/loan/grant-loan'); ?>" class="dropdown-item">Grant Advance Salary</a></li>
								<?php } if(check_permission('role_1606373088_94')){ ?>
									<!-- <li><a href="<?php echo base_url('admin/hrm/loan/loan-installment'); ?>" class="dropdown-item">Loan Installment</a></li> --off by Ibrahim khalil 18-04-2021-->
								<?php } if(check_permission('role_1606373088_14')){ ?>
									<li><a href="<?php echo base_url('admin/hrm/loan/loan-report'); ?>" class="dropdown-item">Advance Salary Report</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php  ?>
						<?php } if(check_permission('role_1606373088_53')){ ?>
						<?php  ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Leave</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<?php if(check_permission('role_1606373133_18')){ ?>

								<?php } if(check_permission('role_1606373133_57')){ ?>
									<li><a href="<?=base_url('admin/hrm/leave/hold-employee-logs'); ?>" class="dropdown-item">Hold Employee Logs</a></li>
									<li><a href="<?=base_url('admin/hrm/leave/employee-leave-request'); ?>" class="dropdown-item">Leave Application</a></li>
								<?php } ?>
								<li><a href="<?=base_url('admin/hrm/leave/lock-list'); ?>" class="dropdown-item">Leave Locked List</a></li>
							</ul>
						</li>
						<?php  ?>
						<?php } if(check_permission('role_1606373133_89')){ ?>
						<?php  ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Award</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<?php if(check_permission('role_1606373181_68')){ ?>
									<li><a href="<?=base_url('admin/hrm/award/employee-performance'); ?>" class="dropdown-item">Employee Performance</a></li>
								<?php } if(check_permission('role_1606373181_59')){ ?>
									<li><a href="<?=base_url('admin/hrm/award/performance-approval-hr'); ?>" class="dropdown-item">Approved Employee Performance</a></li>
									<li><a href="<?=base_url('admin/hrm/award/employee-festival-award'); ?>" class="dropdown-item">Festival Award</a></li>
									<li><a href="<?=base_url('admin/hrm/award/employee-festival-bonus'); ?>" class="dropdown-item">Employee Festival Bonus</a></li>
								<?php } ?>
							</ul>
						</li>
						<?php  ?>
						<?php } ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Print</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/hrm/employee-visiting-card');?>" class="dropdown-item">Employee Visiting Card</a></li>
								<li><a href="<?=base_url('admin/hrm/employee-qr-code');?>" class="dropdown-item">Employee QR Code</a></li>
								<li><a href="<?=base_url('admin/hrm/employee-id-card');?>" class="dropdown-item">Employee ID Card</a></li>
								<li><a href="<?=base_url('admin/hrm/ovserbation-id-card');?>" class="dropdown-item">Ovserbation ID Card</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">HRM Reports</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="#" class="dropdown-item">Department Head Report</a></li>
								<li><a href="#" class="dropdown-item">Attendance Bonus Report</a></li>
								<li><a href="#" class="dropdown-item">OverDuty Bonus Report</a></li>
								<li><a href="<?php echo base_url('admin/hrm/report/increament-report'); ?>" class="dropdown-item">Increament Report</a></li>
								<li><a href="<?php echo base_url('admin/hrm/report/decreament-report'); ?>" class="dropdown-item">Decreament Report</a></li>
								<li><a href="<?php echo base_url('admin/hrm/loan/loan-report'); ?>" class="dropdown-item">Advance Salary Report</a></li>
								<li><a href="<?=base_url('admin/hrm/leave/leave-application-logs'); ?>" class="dropdown-item">Leave Report</a></li>
							</ul>
						</li>
						<li><a href="<?=base_url('admin/hrm/document-managment');?>" class="dropdown-item">Documents Management</a></li>
					</ul>
				</li>			
				<?php } if(check_permission('role_1631452154_66')){ ?><!---Creative Department--->
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Creative Department">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-warning btn_sdo">
						<i class="fas fa-lightbulb" style="font-size: 20px;"></i>						
					</a>			
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="min-width: 185px !important;">
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Print</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/hrm/employee-visiting-card');?>" class="dropdown-item">Employee Visiting Card</a></li>
								<li><a href="<?=base_url('admin/hrm/employee-qr-code');?>" class="dropdown-item">Employee QR Code</a></li>
								<li><a href="<?=base_url('admin/hrm/employee-id-card');?>" class="dropdown-item">Employee ID Card</a></li>
								<li><a href="<?=base_url('admin/hrm/ovserbation-id-card');?>" class="dropdown-item">Ovsebation ID Card</a></li>
							</ul>
						</li>						
					</ul>
				</li>
				<?php } if(check_permission('role_1631452192_72')){ ?><!---Marketing Department--->
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Marketing Department">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-warning btn_sdo">
						<i class="fas fa-poll" style="font-size: 20px;"></i>						
					</a>			
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="min-width: 185px !important;">
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Digital Marketing</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="#" class="dropdown-item">Facebook Marketing</a></li>
								<li><a href="#" class="dropdown-item">Email Marketing</a></li>
								<li><a href="#" class="dropdown-item">SMS Marketing</a></li>
								<li><a href="#" class="dropdown-item">TVC Marketing</a></li>
								<li><a href="#" class="dropdown-item">Other Social Media</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Ofline Marketing</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="#" class="dropdown-item">Facebook Marketing</a></li>
								<li><a href="#" class="dropdown-item">Email Marketing</a></li>
								<li><a href="#" class="dropdown-item">SMS Marketing</a></li>
							</ul>
						</li>	
					</ul>
				</li>
				<?php } if(check_permission('role_1631452768_85')){ ?><!---Legal Department--->
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Legal Department">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-dark btn_sdo">
						<i class="fas fa-balance-scale"></i>						
					</a>			
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="min-width: 185px !important;">
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Appoinment</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="#" class="dropdown-item">-------</a></li>
							</ul>
						</li>	
					</ul>
				</li>
				<?php } if(check_permission('role_1606373238_25')){ ?> <!---accounting Department--->
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Accounting Department">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-info btn_sdo">
						<i class="fas fa-calculator"></i>						
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Acounts</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/accounting/accounts/manage-accounts'); ?>" class="dropdown-item">Manage Accounts</a></li>
								<li><a href="#" class="dropdown-item">BalanceSheet</a></li>
								<li><a href="#" class="dropdown-item">Account Statements</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Transactions</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="#" class="dropdown-item">View Transactions</a></li>
								<li><a href="#" class="dropdown-item">New Transactions</a></li>
								<li><a href="#" class="dropdown-item">New Transfer</a></li>
								<li><a href="#" class="dropdown-item">Clients Transactions</a></li>
								<li class="dropdown-submenu dropdown-hover">
									<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Petty cash Sec.</a>
									<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
										<li><a href="<?=base_url('admin/accounting/transaction/petty-cash'); ?>" class="dropdown-item">Petty cash</a></li>
										<li><a href="<?=base_url('admin/accounting/transaction/view-instant-transaction-buy-something'); ?>" class="dropdown-item">Instant (Buy Something)</a></li>
										<li><a href="<?=base_url('admin/accounting/transaction/view-instant-transaction-buy-something-slip'); ?>" class="dropdown-item">Instant (Buy Something) Slip</a></li>
										<li><hr style="margin:0px;padding:0pxx;"/></li>
										<li><a href="<?=base_url('admin/accounting/transaction/advance-petty-cash'); ?>" class="dropdown-item">Advance Money</a></li>
										<li><a href="<?=base_url('admin/accounting/transaction/advance-petty-cash-approval'); ?>" class="dropdown-item">Advance Money Logs & Approval</a></li>
										<li><a href="<?=base_url('admin/accounting/transaction/advance-petty-cash-return-approval'); ?>" class="dropdown-item">Advance Return Logs & Approval</a></li>
										<li><a href="<?=base_url('admin/accounting/transaction/advance-money-overview-log'); ?>" class="dropdown-item">Advance Money Overview Log</a></li>
										<!--<li><a href="<?=base_url('admin/accounting/transaction/advance-petty-cash-approval-logs'); ?>" class="dropdown-item">Advance Money Approval Logs</a></li>-->
										
										<!---<li><a href="#" class="dropdown-item">Other Transaction</a></li>-->
									</ul>
								</li>
								<li><a href="<?=base_url('admin/accounting/transaction/checkout-member-list'); ?>" class="dropdown-item">Checkout Member List</a></li>
								<li><a href="<?=base_url('admin/accounting/transaction/ipo-member-list'); ?>" class="dropdown-item">Investment Widthdraw List</a></li>
								<li><a href="<?=base_url('admin/accounting/transaction/employee-widthdraw-list'); ?>" class="dropdown-item">Employee Widthdraw List</a></li>
								<li><a href="<?=base_url('admin/accounting/transaction/check-print'); ?>" class="dropdown-item">Check print</a></li>
								<li><a href="<?=base_url('admin/accounting/transaction/envelope-print'); ?>" class="dropdown-item">Envelope print</a></li>
								<li><a href="<?=base_url('admin/accounting/transaction/employee-salary'); ?>" class="dropdown-item">Employee Salary</a></li>								
								<li><a href="<?=base_url('admin/accounting/transaction/checkout-old-member-list'); ?>" class="dropdown-item">Checkout Old Member List</a></li>
								<li><a href="<?=base_url('admin/accounting/transaction/ipo-member-list'); ?>" class="dropdown-item">IPO Withdraw Request</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Income</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="#" class="dropdown-item">View Income</a></li>
								<li><a href="#" class="dropdown-item">Add Income Category</a></li>
								<li><a href="#" class="dropdown-item">Add Income</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Expence</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/view-expenses')?>" class="dropdown-item">View Expence</a></li>
								<li><a href="<?=base_url('admin/accounting/expense/expense-category')?>" class="dropdown-item">Add Expence Category</a></li>
								<li><a href="<?=base_url('admin/manage-expense');?>" class="dropdown-item">Add Expence</a></li>
								<li><a href="<?=base_url('admin/create/front-office/add-house-rent');?>" class="dropdown-item">Add House Rent</a></li>
								<li><a href="<?=base_url('admin/create/front-office/add-internet-bill');?>" class="dropdown-item">Add Internet Bill</a></li>
								<li><a href="<?=base_url('admin/create/front-office/add-water-bill');?>" class="dropdown-item">Add Water Bill</a></li>
								<li><a href="<?=base_url('admin/create/front-office/add-electrict-bill');?>" class="dropdown-item">Add Electric Bill</a></li>
								<li><a href="<?=base_url('admin/create/front-office/add-food-cost');?>" class="dropdown-item">Add Food Cost</a></li>
								<li><a href="<?=base_url('admin/accounting/expence/ta_da_bill');?>" class="dropdown-item">TA/DA Bill</a></li>
								<li><a href="<?=base_url('admin/accounting/expence/employee_salary');?>" class="dropdown-item">Employee Salary</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Advance Acounts</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/accounting/accounts/chart-of-accounts'); ?>" class="dropdown-item">Chart of Account</a></li>
								<li><a href="#" class="dropdown-item">Balance Adjustment</a></li>
								<li><a href="#" class="dropdown-item">Cash Adjustment</a></li>
								<li><a href="#" class="dropdown-item">Bank Adjustment</a></li>
								<li><a href="#" class="dropdown-item">Payment Type</a></li>
								<li><a href="#" class="dropdown-item">Debit Voucher</a></li>
								<li><a href="#" class="dropdown-item">Credit Voucher</a></li>
								<li><a href="#" class="dropdown-item">Contra Voucher</a></li>
								<li><a href="#" class="dropdown-item">Journal Voucher</a></li>
								<li><a href="#" class="dropdown-item">Voucher Approval</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Account Report</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="#" class="dropdown-item">Cash Book</a></li>
								<li><a href="#" class="dropdown-item">Bank Book</a></li>
								<li><a href="#" class="dropdown-item">Mobile Book</a></li>
								<li><a href="#" class="dropdown-item">General Ledger</a></li>
								<li><a href="#" class="dropdown-item">Trial Balance</a></li>
								<li><a href="#" class="dropdown-item">Profit Loss</a></li>
								<li><a href="#" class="dropdown-item">Cash Flow</a></li>
								<li><a href="#" class="dropdown-item">Coa Print</a></li>
								<li><a href="<?=base_url('admin/accounting/accounts/account-report/employee-award-insert-logs'); ?>" class="dropdown-item">Emp: Award insert Report</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Aproval</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/general-expense-approval'); ?>" class="dropdown-item">General Expense Aproval</a></li>
								<li><a href="<?=base_url('admin/accounting/aproval/loan-aproval'); ?>" class="dropdown-item">Loan Aproval</a></li>
							</ul>
						</li>
					</ul>
				</li>
				<?php } if(check_permission('role_1606376720_99')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Reports">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-primary btn_sdo btn-sm">
						<i class="nav-icon fas fa-chart-pie"></i>
					</a>				
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="width: auto;">
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Booking</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/report/booking-report');?>" class="dropdown-item">Booking Report</a></li>
								<!--<li><a href="<?=base_url('admin/report/rental-report');?>" class="dropdown-item">Rental Report</a></li>-->
								
								<li><a href="<?=base_url('admin/report/auto-cancel-report');?>" class="dropdown-item">Auto Cancel</a></li>
								<li><a href="<?=base_url('admin/report/force-cancel-report');?>" class="dropdown-item">Force Cancel</a></li>
								<li><a href="<?=base_url('admin/report/salf-cancel-report');?>" class="dropdown-item">Self Cancel</a></li>
								
								<li><a href="<?=base_url('admin/report/request-cancel-report');?>" class="dropdown-item">Cancel Report</a></li>
								<li><a href="<?=base_url('admin/report/renew-report');?>" class="dropdown-item">Renew Report</a></li>							
								<li><a href="<?=base_url('admin/report/checkin-today');?>" class="dropdown-item">CheckIn Today</a></li>
								<li><a href="<?=base_url('admin/report/checkout-today');?>" class="dropdown-item">CheckOut Today</a></li>
								<!--<li><a href="<?=base_url('admin/report/panalty-report');?>" class="dropdown-item">Penalty Report</a></li>-->							
								<li><a href="<?=base_url('admin/report/package-change-report');?>" class="dropdown-item">Package Change Report</a></li>
								<li><a href="<?=base_url('admin/report/bed-change-report');?>" class="dropdown-item">Bed Change Report</a></li>
								<li><a href="<?=base_url('admin/report/discount-report');?>" class="dropdown-item">Discount Report</a></li>
								<li><a href="<?=base_url('admin/report/cancel-reminder');?>" class="dropdown-item">Cancel Reminder</a></li>
								<li><a href="<?=base_url('admin/report/crm-report/occupide-member-list');?>" class="dropdown-item">Live Occupide Report</a></li>
								<li><a href="<?=base_url('admin/report/crm-report/live-request-for-cancel-member-list');?>" class="dropdown-item">Live Cancel Report</a></li>
								<li><a href="<?=base_url('admin/report/crm-report/live-booked-member-list');?>" class="dropdown-item">Live Booked Report</a></li>
								<li><a href="<?=base_url('admin/report/crm-report/custom-report');?>" class="dropdown-item">Checkin Report</a></li>
								<li><a href="<?=base_url('package_wise_member_occupation_count');?>" class="dropdown-item">Package Wise Occupation</a></li>
								<li><a href="<?=base_url('package_wise_member_occupation_count_daily');?>" class="dropdown-item">Package/Occupation Daily Occupied</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Collection Report</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/report/today-collection-report');?>" class="dropdown-item">Transaction Report</a></li>							
								<li><a href="<?=base_url('admin/report/locker-report');?>" class="dropdown-item">Locker Report</a></li>
								<li><a href="<?=base_url('admin/report/electrict-bill-report');?>" class="dropdown-item">Income Report</a></li>
								<li><a href="<?=base_url('admin/report/security-deposit-report');?>" class="dropdown-item">Security Deposit Report</a></li>
								<li><a href="<?=base_url('admin/report/security-deposit-report-debit-credit');?>" class="dropdown-item">Security Deposit Report 2</a></li>
								<li><a href="<?=base_url('admin/report/discount-report');?>" class="dropdown-item">CashBack Report</a></li>
								<li><a href="<?=base_url('admin/report/payment-report');?>" class="dropdown-item">All Collection Report</a></li>
								
								<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['user_info']['department'] == '2270968637477766714'){ //Accounts department?>
									<li><a href="<?=base_url('admin/report/details-collection-report');?>" class="dropdown-item">Details Collection Report</a></li>
								<?php } ?>

								<li><a href="<?=base_url('admin/report/bkash-report');?>" class="dropdown-item">bKash Report</a></li>
								<li><a href="<?=base_url('admin/report/branch-revenue');?>" class="dropdown-item">Branch Revenue Report</a></li>

								
								<?php if(check_permission('role_1622098929_46')){ ?>
									<li><a href="<?=base_url('admin/report/ipo-payment-report');?>" class="dropdown-item">Investment Collection Report</a></li>
								<?php } ?>
								<!--<li><a href="<?=base_url('admin/report/all-collection-report');?>" class="dropdown-item">All Collection Report</a></li>-->
							</ul>
						</li>					
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">CRM Reports</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/report/crm-report/checkout-member-list');?>" class="dropdown-item">Checkout Member List</a></li>
								<li><a href="<?=base_url('admin/report/crm-report/refunded-member-list');?>" class="dropdown-item">Refunded Member List</a></li>
							</ul>
						</li>					
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Front Office</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/report/shop-report');?>" class="dropdown-item">Shop Report</a></li>
								<li><a href="<?=base_url('admin/report/dining-report');?>" class="dropdown-item">Dining Report</a></li>							
								<li><a href="<?=base_url('admin/report/visitor-book-report');?>" class="dropdown-item">Visitor Book Report</a></li>							
							</ul>
						</li>
						<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Communicate</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/report/communication/auto-sms-logs');?>" class="dropdown-item">All & Auto SMS Logs</a></li>						
								<li><a href="<?=base_url('admin/report/communication/member-corn-jobs');?>" class="dropdown-item">Member Corn Jobs</a></li>						
								<li><a href="<?=base_url('admin/report/communication/investor-corn-jobs');?>" class="dropdown-item">Investor Corn Jobs</a></li>						
								<li><a href="<?=base_url('admin/report/communication/demo-investor-corn-jobs');?>" class="dropdown-item">Demo Investor Corn Jobs</a></li>						
							</ul>
						</li>
						<?php } ?>
						<li><a href="#" class="dropdown-item">Other Report</a></li>
						<?php if(!empty($_SESSION['super_admin']['role_id']) AND $_SESSION['super_admin']['role_id'] == '2805597208697462328' ){ ?>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Tracing Report</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/report/tracing-report/all-employee-secreenshot');?>" class="dropdown-item">All Emplyee Screenshot</a></li>						
								<li><a href="<?=base_url('admin/report/tracing-report/employee-login-info');?>" class="dropdown-item">Emplyee Login info</a></li>						
								<li><a href="<?=base_url('admin/report/tracing-report/member-login-info');?>" class="dropdown-item">Member Login info</a></li>	
							</ul>
						</li>
						<?php } ?>
						<?php if(check_permission('role_1637038817_50')){ ?>
							<li><a href="<?=base_url('refreshment_items');?>" class="dropdown-item">Refreshment Items</a></li>	
						<?php } ?>
						<li><a href="<?=base_url('admin/scm/item-stock-managemet');?>" class="dropdown-item">Refreshment Item Management</a></li>				
						<li><a href="<?=base_url('admin/scm/employee-review');?>" class="dropdown-item">Employee Review</a></li>				
					</ul>
				</li>
				<?php } if(check_permission('role_1606377028_92')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Communicate">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-info btn_sdo">
						<i class="fas fa-tty"></i>					
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li><a href="<?=base_url('admin/communicate/notice-board'); ?>" class="dropdown-item">Notice Board</a></li>
						<li><a href="<?=base_url('admin/communicate/notice-history'); ?>" class="dropdown-item">Notice History</a></li>
						<li><a href="<?=base_url('admin/communicate/send-sms'); ?>" class="dropdown-item">Send SMS</a></li>
						<li><a href="<?=base_url('admin/communicate/sms-history'); ?>" class="dropdown-item">SMS History</a></li>
						<li><a href="<?=base_url('admin/communicate/send-email'); ?>" class="dropdown-item">Send Email</a></li>
						<li><a href="<?=base_url('admin/communicate/email-history'); ?>" class="dropdown-item">Email History</a></li>
						<li><a href="<?=base_url('admin/communicate/call-history'); ?>" class="dropdown-item">Call History</a></li>
						<?php if(check_permission('role_1629354577_61')){ ?>
						<li><a href="<?=base_url('admin/report/communication/auto-sms-logs');?>" class="dropdown-item">All & Auto SMS Logs</a></li>
						<?php } ?>
						
					</ul>
				</li>
				<?php } if(check_permission('role_1606377189_62')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Front End">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-primary btn_sdo btn-sm">
						<i class="nav-icon fas fa-tree"></i>
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li><a href="#" class="dropdown-item">Add Iteam</a></li>
						<li><a href="#" class="dropdown-item">Remove Iteam</a></li>
						<li class="dropdown-divider"></li>
						<li class="dropdown-submenu dropdown-hover">
						<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Static Pages</a>
						<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
							<li><a href="<?=base_url('admin/front-end/static-page/terms-condition'); ?>" class="dropdown-item">Terms & Conditions</a></li>
							<li><a href="<?=base_url('admin/front-end/static-page/privacy-policy'); ?>" class="dropdown-item">Privacy Policy</a></li>
							<li><a href="<?=base_url('admin/front-end/static-page/frequently-asked-question'); ?>" class="dropdown-item">FAQ</a></li>
							<li><a href="<?=base_url('admin/front-end/static-page/trems-and-condition-ipo-referal-approval'); ?>" class="dropdown-item">T & C Investor Referal Approval</a></li>
						</ul>
						</li>
					</ul>
				</li>		
				<?php } if(check_permission('role_1606377200_54')){ ?>
				<?php if( !empty($_SESSION['user_info']['department']) AND $_SESSION['user_info']['department'] == '816905694932688665' ){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Create">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-info btn_sdo">
						<i class="nav-icon fas fa-plus-square"></i>
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Branch,Bed e.t.c</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/add-branch'); ?>" class="dropdown-item">Manage Branch</a></li>
								<li><a href="<?=base_url('admin/add-floor'); ?>" class="dropdown-item">Manage Floor *</a></li>
								<li><a href="<?=base_url('admin/manage-units'); ?>" class="dropdown-item">Manage Unit</a></li>
								<li><a href="<?=base_url('admin/manage-rooms'); ?>" class="dropdown-item">Manage Rooms</a></li>
								<li><a href="<?=base_url('admin/manage-column'); ?>" class="dropdown-item">Manage Column</a></li>							
								<li><a href="<?=base_url('admin/manage-beds'); ?>" class="dropdown-item">Manage Beds</a></li>
								<li><a href="<?=base_url('admin/manage-room-types'); ?>" class="dropdown-item">Manage Room Types</a></li>
								<li><a href="<?=base_url('admin/manage-locker-types'); ?>" class="dropdown-item">Manage Locker Types</a></li>
								<li><a href="<?=base_url('admin/manage-locker'); ?>" class="dropdown-item">Manage Locker</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">HRM</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/manage-roles');?>" class="dropdown-item">Manage Roles</a></li>
								<li><a href="<?=base_url('admin/manage-department');?>" class="dropdown-item">Manage Department</a></li>
								<li><a href="<?=base_url('admin/manage-designation');?>" class="dropdown-item">Manage Designatiion</a></li>
								<li><a href="<?=base_url('admin/manage-grade');?>" class="dropdown-item">Manage Grade</a></li>
								<li><a href="<?=base_url('admin/leave-types');?>" class="dropdown-item">Leave Types</a></li>
								<li><a href="<?=base_url('admin/fingure-missing-reason');?>" class="dropdown-item">Fingure Missing Reason</a></li>
							</ul>
						</li>
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Booking</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/manage-package-category');?>" class="dropdown-item">Manage Package Category</a></li>
								<li><a href="<?=base_url('admin/manage-sub-category');?>" class="dropdown-item">Manage Sub-Category</a></li>
								<li><a href="<?=base_url('admin/manage-package');?>" class="dropdown-item">Manage Package</a></li>
								<li><a href="<?=base_url('admin/manage-services');?>" class="dropdown-item">Manage Services</a></li>
								<li><a href="<?=base_url('admin/manage-document-type');?>" class="dropdown-item">Manage Document Type</a></li>
								<li><a href="<?=base_url('admin/manage-payment-type');?>" class="dropdown-item">Manage Payment Type</a></li>
								<?php /* ?><li><a href="<?=base_url('admin/manage-Payment-method');?>" class="dropdown-item">Manage Payment Method</a></li>
								<li><a href="<?=base_url('admin/card-change-payment');?>" class="dropdown-item">Card Change Payment</a></li><?php */ ?>
								<li><a href="<?=base_url('admin/check-out-iteams'); ?>" class="dropdown-item">CheckOut Iteams</a></li>
							</ul>
						</li>
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Investment</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/manage-ipo-category');?>" class="dropdown-item">Manage Investor Category</a></li>
								<li><a href="<?=base_url('admin/manage-agreement-type');?>" class="dropdown-item">Agreement Type</a></li>
							</ul>
						</li>
						
						<?php /* ?><li><a href="<?=base_url('admin/api/json-api');?>" class="dropdown-item">Json API</a></li><?php */ ?>
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:185px;">Front Office</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/create/tea-coffee/add-refreshment-item');?>" class="dropdown-item">Add Products (shop)</a></li>
								<li><a href="<?=base_url('admin/create/music-player/add-audio-file');?>"class="dropdown-item">Add Audio</a></li>
								<li><a href="<?=base_url('admin/create/music-player/add-video-link');?>"class="dropdown-item">Add Video</a></li>
								<li><a href="<?=base_url('admin/create/music-player/add-door-ips');?>"class="dropdown-item">Add Door IP</a></li>
								<li><a href="<?=base_url('admin/create/front-office/add-electrict-bill');?>"class="dropdown-item">Add Elictric Bill</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:185px;">Software Learning</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/create/software-learning/add-tutorials');?>" class="dropdown-item">Add Tutorials</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:185px;">Award</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/create/award/sales-award');?>" class="dropdown-item">Sales Award</a></li>
								<li><a href="<?=base_url('admin/create/award/member-referal-award');?>" class="dropdown-item">Member Referal Award</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:185px;">Network</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/create/network/router-configuration');?>" class="dropdown-item">Router Configuration</a></li>
								<li><a href="<?=base_url('admin/create/network/network-graph-configuration');?>" class="dropdown-item">Net Graph Config</a></li>
							</ul>
						</li>

						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:185px;">Service Review</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/create/complain/complain-category');?>" class="dropdown-item">Complain Category</a></li>
								<li><a href="<?=base_url('admin/create/complain/complain-list');?>" class="dropdown-item">Complain List</a></li>
							</ul>
						</li>


					</ul>
				</li> 
				<?php } ?>
				<?php } if(check_permission('role_1606377219_61')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Application">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-danger btn_sdo">
						<i class="fas fa-rocket"></i>
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li><a href="<?=base_url('admin/file-manager'); ?>" class="dropdown-item"><i class="far fa-folder"></i> &nbsp;File Manager</a></li>
						<li><a href="<?=base_url('admin/bkash-link-open'); ?>" target="_blank" class="dropdown-item"><img src="<?=base_url('assets/img/bkash_favicon_0.ico'); ?>" style=""/> &nbsp;&nbsp;&nbsp;&nbsp;bKash</a></li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:200px;"><i class="far fa-file-alt"></i> &nbsp;Document Verify</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/application/document-verification/birth-certificate');?>" target="_blank" class="dropdown-item">Brith Certificate</a></li>
								<li><a href="<?=base_url('admin/application/document-verification/nid-card');?>" target="_blank" class="dropdown-item">NID Card</a></li>
							</ul>
						</li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:200px;"><i class="fas fa-file-invoice-dollar"></i> &nbsp;Mobile Recharge</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/mobile-recharge/grmeenphone');?>" target="_blank" class="dropdown-item">GrmeenPhone</a></li>
							</ul>
						</li>
						<li><a href="<?=base_url('admin/photo-shop'); ?>" class="dropdown-item"><i class="far fa-images"></i> &nbsp;PhotoShop</a></li>
						<li><a href="<?=base_url('admin/illustrator'); ?>" class="dropdown-item"><i class="fas fa-images"></i> &nbsp;Illustrator</a></li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle" style="width:200px;"><i class="fas fa-play-circle"></i> &nbsp;Music Player</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/front-office/video-music-player');?>" target="_blank" class="dropdown-item">Video Player</a></li>
								<li><a href="<?=base_url('admin/front-office/audio-music-player');?>" target="_blank" class="dropdown-item">Audio Player</a></li>
							</ul>
						</li>
						<li><a href="javascript:void(0);" onclick="return view_calculator_modal();" class="dropdown-item"><i class="fas fa-calculator"></i> &nbsp;Calculator</a></li>
					</ul>
				</li>
				<?php } if(check_permission('role_1606377224_79')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Settings">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-success btn_sdo btn-sm">
						<i class="nav-icon fas fa-cog"></i>
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li><a href="#" class="dropdown-item">General Setting</a></li>
						<li><a href="#" class="dropdown-item">Notification Setting</a></li>
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">SMS</a>
							<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/settings/sms/configure-sms'); ?>" class="dropdown-item">Configure SMS</a></li>
								<li><a href="<?=base_url('admin/settings/sms/sms-purpase'); ?>" class="dropdown-item">SMS Purpase</a></li>
								<li><a href="<?=base_url('admin/settings/sms/sms-template'); ?>" class="dropdown-item">SMS Template</a></li>
							</ul>
						</li>
						<li><a href="#" class="dropdown-item">Email Setting</a></li>
						<li><a href="#" class="dropdown-item">Backup / Restore</a></li>
						<li><a href="#" class="dropdown-item">Language</a></li>
						<li><a href="#" class="dropdown-item">Modules</a></li>
					</ul>
				</li>			
				<?php } ?>
				<?php include('notification.php'); ?>
				<?php if(check_permission('role_1606377230_46')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="My Profile">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-danger btn_sdo">
						<i class="nav-icon fas fa-user"></i>
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropleft dropdown-menu border-0 shadow dropdown-menu-righ">
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-check-square"></i> Request</a>
							<ul aria-labelledby="dropdownSubMenu2" style="left:-249px !important;width:249px;" class="dropdown-menu border-0 shadow">
								<li class="dropdown-submenu dropdown-hover">
									<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-chalkboard-teacher"></i> Leave Request</a>
									<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow" style="left: -161px;top: -8px;">
										<li><a href="<?=base_url('admin/profile/employee-own-leave-request'); ?>" class="dropdown-item">Get Leave</a></li>
										<li><a href="<?=base_url('admin/profile/employee-own-leave-withdraw-request'); ?>" class="dropdown-item">Withdraw Leave</a></li>
										<!--<li><a href="#" class="dropdown-item">Leave Deduction</a></li>-->
									</ul>
								</li>
								
								<li><a href="<?=base_url('admin/profile/attendance-adsjustment'); ?>" class="dropdown-item"><i class="fas fa-sliders-h"></i> Attendance Adjustment</a></li>
								<li><a href="<?=base_url('admin/profile/loan-money-request'); ?>" class="dropdown-item"><i class="fas fa-landmark"></i> Advance Salary Request</a></li>
								<li><a href="<?=base_url('admin/profile/ta_da_request'); ?>" class="dropdown-item"><i class="fas fa-shuttle-van"></i> TA/DA Request</a></li>
								
								<li><a href="<?=base_url('admin/profile/employee-own-resign-request'); ?>" class="dropdown-item"><i class="fas fa-user-minus"></i> Resign Request</a></li>						
								<li><a href="<?=base_url('admin/profile/increase-mobile-allowence'); ?>" class="dropdown-item"><i class="fas fa-mobile"></i> Increase Mobile Allowance</a></li>	
								<li><a href="<?=base_url('admin/scm/product-requisition/requisition-type'); ?>" class="dropdown-item"><i class="fas fa-shopping-cart"></i>Product requisition</a></li>	
								<li><a href="<?=base_url('admin/profile/advance-money-request'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Purchase Money Request</a></li>	
								<?php if(check_permission('role_1627388443_98')){ ?>
								<li><a href="<?=base_url('admin/profile/petty-cash-request'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Petty Cash Request</a></li>
								<?php } ?>
							</ul>
						</li>
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-check-square"></i> MY Expense</a>
							<ul aria-labelledby="dropdownSubMenu2" style="left:-230px !important;width:230px;" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/profile/urgent-expense'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Urgent Expense & Return</a></li>
								<li><a href="<?=base_url('admin/profile/urgent-expense-list'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Urgent Expense List</a></li>	
								<li><a href="<?=base_url('admin/profile/urgent-expense-return-list'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Urgent Return Logs</a></li>	
								<!-- <li><a href="<?=base_url('admin/manage-expense'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Add New Expense</a></li>
								<li><a href="<?=base_url('admin/view-expenses'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> View Expenses</a></li> -->
							</ul>
						</li>
						
						
						
						<li><a href="<?=base_url('admin/profile/my-attendents');?>" class="dropdown-item"><i class="far fa-clock"></i> My Attendents</a></li>
						<?php if($_SESSION['user_info']['d_head'] == '1'){ ?>
							<li><a href="<?=base_url('admin/profile/subordinate-attendents');?>" class="dropdown-item"><i class="far fa-clock"></i> Subordinate Attendence</a></li>
						<?php } ?>
						<li><a href="<?=base_url('admin/profile/change-password');?>" class="dropdown-item"><i class="fas fa-key"></i> Change Password</a></li>
						<li><a href="<?=base_url('admin/profile/change-profile-picture');?>" class="dropdown-item"><i class="fas fa-portrait"></i> Change Profile Picture</a></li>
						<li><a href="<?=base_url('admin/logout');?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> <b style="color:#f00;">Logout</b></a></li>					
					</ul>
				</li>
				<?php } ?>
				<?php if($_SESSION['user_info']['d_head'] == 1 OR $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Department Management">
					<a id="department" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-info btn_sdo btn-sm">
						<i class="fas fa-dungeon"></i>
					</a>
					<ul aria-labelledby="department" class="dropleft dropdown-menu border-0 shadow dropdown-menu-righ">
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-check-square"></i> Request</a>
							<ul aria-labelledby="dropdownSubMenu2" style="left:-249px !important;width:249px;" class="dropdown-menu border-0 shadow">
								
								<?php if($_SESSION['user_info']['d_head'] == 1 OR $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
								<li><a href="<?=base_url('admin/hrm/payroll/add-increament'); ?>" class="dropdown-item"><i class="fas fa-sort-amount-up"></i> Add Increament</a></li>
								<li><a href="<?=base_url('admin/hrm/payroll/add-decreament'); ?>" class="dropdown-item"><i class="fas fa-sort-amount-down"></i> Add Decreament</a></li>	
								
								<li><a href="<?=base_url('admin/scm/service-requisition'); ?>" class="dropdown-item"><i class="fas fa-car"></i>Service requisition</a></li>	
								<li><a href="<?=base_url('admin/profile/employee-performance-request'); ?>" class="dropdown-item"><i class="far fa-chart-bar"></i> Employee Performance</a></li>
								<?php } ?>							
								<?php if($_SESSION['user_info']['d_head'] == '1'){ ?>
								<li><a href="<?=base_url('admin/profile/employee-recruitment-request'); ?>" class="dropdown-item"><i class="fas fa-user-plus"></i> Recruitment Request</a></li>
								<?php } ?>
								<?php if($_SESSION['user_info']['d_head'] == 1 OR $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
								<li><a href="<?=base_url('admin/profile/request-fired-an-employee'); ?>" class="dropdown-item"><i class="fas fa-user-slash"></i> Fired An Employee</a></li> <?php  ?>
								<?php } ?>
															
								<li><a href="<?=base_url('admin/create/complain/complain-list');?>" class="dropdown-item"><i class="fas fa-list"></i> Complain List</a></li>						
								
								<?php if($_SESSION['user_info']['d_head'] == '1' OR $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
									<li><a href="<?=base_url('admin/profile/employee-subordinate-leave-request');?>" class="dropdown-item"><i class="fas fa-chalkboard-teacher"></i> Subordinate Leave Request</a></li>
								<?php } ?>					
							</ul>
						</li>
						<?php if($_SESSION['user_info']['d_head'] == '1' OR $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
							<li class="dropdown-submenu dropdown-hover">
								<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-check-square"></i> Approval</a>
								<ul aria-labelledby="dropdownSubMenu2" style="left:-250px !important;width:250px;" class="dropdown-menu border-0 shadow">							
									<?php if($_SESSION['user_info']['d_head'] == 1 OR $_SESSION['super_admin']['user_type'] == 'Super Admin'){ ?>
										<li><a href="<?=base_url('admin/hrm/payroll/missing-attendence-request-logs-hr'); ?>" class="dropdown-item"><i class="fas fa-clipboard-check"></i>Attandence Request Approval</a></li>
										<li><a href="<?=base_url('admin/scm/service-requisition-approval'); ?>" class="dropdown-item"><i class="fas fa-clipboard-check"></i>Service Requisition Approval</a></li>
										<li><a href="<?=base_url('admin/hrm/payroll/leave-approval'); ?>" class="dropdown-item"><i class="fas fa-chalkboard-teacher"></i> Leave Approval</a></li>	
										<?php } if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['user_info']['d_head'] == 1  ){ ?>
										<li><a href="<?=base_url('admin/hrm/payroll/increament-approval'); ?>" class="dropdown-item"><i class="fas fa-user-check"></i> <span title="Increament">Inc</span> / <span title="Decreament">Dec</span> Approval</a></li>
										<li><a href="<?=base_url('admin/hrm/loan/loan-approval'); ?>" class="dropdown-item"><i class="far fa-paper-plane"></i> Advance Salary Approval</a></li>
										<li><a href="<?=base_url('admin/hrm/award/performance-approval'); ?>" class="dropdown-item"><i class="far fa-chart-bar"></i> Performance Approval</a></li>
										<li><a href="<?=base_url('admin/notification/payroll/exit-employee-approval-admin'); ?>" class="dropdown-item"><i class="fas fa-user-times"></i> Employee Exit Aproval</a></li>
										<li><a href="<?=base_url('admin/profile/employee-fired-request-aproval'); ?>" class="dropdown-item"><i class="fas fa-user-slash"></i> Employee Fired Aproval</a></li>
										<li><a href="<?=base_url('admin/profile/increase-mobile-allowence-approval'); ?>" class="dropdown-item"><i class="fas fa-mobile"></i> Mobile Allowance Approval</a></li>
									<?php } ?>
								</ul>
							</li> 
						<?php } ?>
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-check-square"></i> MY Expense</a>
							<ul aria-labelledby="dropdownSubMenu2" style="left:-230px !important;width:230px;" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/profile/urgent-expense'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Urgent Expense & Return</a></li>
								<li><a href="<?=base_url('admin/profile/urgent-expense-list'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Urgent Expense List</a></li>	
								<li><a href="<?=base_url('admin/profile/urgent-expense-return-list'); ?>" class="dropdown-item"><span style="font-weight: bolder;font-family:none;margin-right: 10px;">৳</span> Urgent Return Logs</a></li>	

							</ul>
						</li>
						
						<li class="dropdown-submenu dropdown-hover">
							<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-check-square"></i>Department Inventory</a>
							<ul aria-labelledby="dropdownSubMenu2" style="left:-120% !important;width:280px;" class="dropdown-menu border-0 shadow">
								<li><a href="<?=base_url('admin/scm/department-requisitions');?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Department Requisitions</a></li>
								<li><a href="<?=base_url('admin/scm/department-product-stock');?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Department Product Stock</a></li>
								<li><a href="<?=base_url('admin/scm/department-product-transfer');?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Department Product Transfer</a></li>
								<li><a href="<?=base_url('admin/scm/department-product-status');?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Department Status</a></li>
								<li><a href="<?=base_url('admin/scm/manage-assigned-services');?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Manage Assigned Services</a></li>
								<li><a style="white-space: break-spaces !important;" href="<?=base_url('admin/scm/other-department-requisition');?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Manage Received Requisitions</a></li>
								<li><a href="<?=base_url('admin/scm/manage-other-department-requisition');?>" class="dropdown-item"><i class="fas fa-sign-out-alt"></i> Manage Sent Requisitions</a></li>
							</ul>
						</li>
										
					</ul>
				</li>
				<?php } ?>
				<li data-toggle="tooltip" data-placement="top" title="Neways Messenger">
					<a href="javascript:void(0);" class="btn btn-info btn_sdo">
						<i class="nav-icon fab fa-facebook-messenger"></i>
					</a>
				</li>	
				<?php if($_SESSION['super_admin']['user_type'] == 'Super Admin' OR $_SESSION['super_admin']['role_id'] == 'role_1644821373_60'){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="User Review">
					<!--
					<a href="<?=base_url('admin/scm/employee-review');?>" class="btn btn-dark btn_sdo myButton">
						<img src="<?= base_url('assets/img/user_rating.png')?>" alt="" width="28px">
					</a>
					-->
					
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-danger btn_sdo">
						<img src="<?= base_url('assets/img/user_rating.png')?>" alt="" width="28px">
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropleft dropdown-menu border-0 shadow dropdown-menu-righ">
						<li><a href="<?=base_url('admin/scm/employee-review');?>" class="dropdown-item"><i class="fas fa-list"></i> Employee Review</a></li>					
						<li><a href="<?=base_url('admin/create/complain/complain-lists');?>" class="dropdown-item"><i class="fas fa-list"></i> Complain List</a></li>					
					</ul>
				</li>
				
				<?php } ?>
				<?php if($_SESSION['super_admin']['role_id'] == '1122750275746428660' AND $_SESSION['user_info']['branch_name'] == 'Super Home 8'){ ?>
					<li data-toggle="tooltip" data-placement="top" title="Open Gate">
						<a target="_blank" href="<?= base_url('restrat_gate'); ?>" class="btn btn-primary btn_sdo btn-sm">
							<i class="fas fa-dungeon"></i>
						</a>
					</li>
				<?php } if(check_permission('role_1606377189_62')){ ?>
				<li class="nav-item dropdown" data-toggle="tooltip" data-placement="top" title="Front End">
					<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle btn btn-primary btn_sdo btn-sm">
						<i class="nav-icon fas fa-tree"></i>
					</a>
					<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
						<li><a href="#" class="dropdown-item">Add Iteam</a></li>
						<li><a href="#" class="dropdown-item">Remove Iteam</a></li>
						<li class="dropdown-divider"></li>
						<li class="dropdown-submenu dropdown-hover">
						<a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Static Pages</a>
						<ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
							<li><a href="<?=base_url('admin/front-end/static-page/terms-condition'); ?>" class="dropdown-item">Terms & Conditions</a></li>
							<li><a href="<?=base_url('admin/front-end/static-page/privacy-policy'); ?>" class="dropdown-item">Privacy Policy</a></li>
							<li><a href="<?=base_url('admin/front-end/static-page/frequently-asked-question'); ?>" class="dropdown-item">FAQ</a></li>
							<li><a href="<?=base_url('admin/front-end/static-page/trems-and-condition-ipo-referal-approval'); ?>" class="dropdown-item">T & C Investor Referal Approval</a></li>
						</ul>
						</li>
					</ul>
				</li>		
				<?php } ?>
			</ul>      
		</div>     
	</div>
</nav>
<?php
	include("nav_varticle.php");
?>
<script>
$(function(){
	$(window).on("load",function(){
		var nav_width = $('#actual_nav_width').width();
		var body_width = $(window).width();
		var nav_result = body_width - nav_width;
		var margen_left = nav_result / 2;
		$("#actual_nav_width").css({"margin-left":""+margen_left+"px","display":"block"});
	})
	$(window).on("resize",function(){
		var nav_width = $('#actual_nav_width').width();
		var body_width = $(window).width();
		var nav_result = body_width - nav_width;
		var margen_left = nav_result / 2;
		$("#actual_nav_width").css({"margin-left":""+margen_left+"px","display":"block"});
	})
})
</script>