<link rel="stylesheet" type="text/css" href="<?=base_url('assets/aside/');?>css/icons.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/aside/');?>css/component.css" />
<script src="<?=base_url('assets/aside/');?>js/modernizr.custom.js"></script>
<div class="mp-pusher" id="mp-pusher" style="z-index:9999;position:absolute;top:0%;">
	<div id="mp-menu" class="mp-menu">
		<div class="mp-level">
			<h2 class="icon icon-world" style="padding-bottom:10px;padding-top:10px;">
				<a href="http://erp.superhostelbd.com/super_home/admin">
					<img src="http://erp.superhostelbd.com/super_home/assets/img/neways.png" style="width: 175px;" alt="Neways" title="Neways">
				</a>
			</h2>
			<ul class="navbar-nav aside_menue">
				<li class="">
					<a class="" href="<?=base_url('admin/');?>">
						<i class="fas fa-home">&nbsp;&nbsp;&nbsp;</i>
						Home
					</a>
				</li>
				<li class="">
					<a class="" href="<?=base_url('admin/dashboard');?>">
						<i class="fas fa-tachometer-alt">&nbsp;&nbsp;&nbsp;</i>
						Dashboard
					</a>
				</li>
				<?php if(check_permission('role_1606369891_33')){ ?>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-building">&nbsp;&nbsp;&nbsp;</i>
						Front Office
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">Front Office</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Front Work Area</a>
								<div class="mp-level">
									<h2>Front Work Area</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="<?=base_url('admin/front-office/booking-enquery');?>">Booking Enquiry</a></li>
										<li><a href="#">Visitor Book</a></li>
										<li><a href="#">Phone Call Logs</a></li>
										<li><a href="#">Postal Dispatch</a></li>
										<li><a href="#">Postal Receive</a></li>
										<li><a href="#">Complain</a></li>
										<li><a href="#">Front Office Setup</a></li>
									</ul>
								</div>
							</li>
							<li class=""> <a class="" href="#">PreBook Form</a> </li>
							<li class=""> <a class="" href="#">Package Plane</a> </li>
							<li class=""> <a class="" href="#">Shop</a> </li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Instant Transaction</a>
								<div class="mp-level">
									<h2>Instant Transaction</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Buy Something</a></li>
										<li><a href="#">Other Transaction</a></li>
									</ul>
								</div>
							</li>
							<li class=""> <a class="" href="#">Dining Table</a> </li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Front Door Lock</a>
								<div class="mp-level">
									<h2>Front Door Lock</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Lock 1</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<?php } ?>
				<li class="">
					<a class="" href="#">
						<i class="nav-icon fas fa-edit">&nbsp;&nbsp;&nbsp;</i>
						Booking
					</a>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Inventory
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">Inventory</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Items Manager</a>
								<div class="mp-level">
									<h2>Items Manager</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">New Product</a></li>
										<li><a href="#">Manage Products</a></li>
									</ul>
								</div>
							</li>
							<li class=""> <a class="" href="#">Product Categories</a> </li>
							<li class=""> <a class="" href="#">Warehouses</a> </li>
							<li class=""> <a class="" href="#">Stock Transfer</a> </li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Purchase Order</a>
								<div class="mp-level">
									<h2>Purchase Order</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">New Order</a></li>
										<li><a href="#">Manage Order</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Stock Return</a>
								<div class="mp-level">
									<h2>Stock Return</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Suppliers Records</a></li>
										<li><a href="#">Customers Records</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Suppliers</a>
								<div class="mp-level">
									<h2>Suppliers</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">New Supplier</a></li>
										<li><a href="#">Manage Suppliers</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Suppliers</a>
								<div class="mp-level">
									<h2>Suppliers</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">New Supplier</a></li>
										<li><a href="#">Manage Suppliers</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Products Label</a>
								<div class="mp-level">
									<h2>Products Label</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Custom Label</a></li>
										<li><a href="#">Standard Label</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-users">&nbsp;&nbsp;&nbsp;</i>
						C R M
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">C R M</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class=""> <a class="" href="#">Member Directory</a> </li>
							<li class=""> <a class="" href="#">Rental Information</a> </li>
							<li class=""> <a class="" href="#">CheckOut Members</a> </li>
							<li class=""> <a class="" href="#">CheckOut Booking</a> </li>
							<li class=""> <a class="" href="#">Old Member Directory</a> </li>
							<li class=""> <a class="" href="#">PreBook Member Directory</a> </li>
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						HRM
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">HRM</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Employee Directory</a>
								<div class="mp-level">
									<h2>Employee Directory</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Employee List</a></li>
										<li><a href="#">Employee Add Request</a></li>
										<li><a href="#">Employee Add Form</a></li>
										<li><a href="#">Employee Add Request</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">DPT: & Designatiion</a>
								<div class="mp-level">
									<h2>DPT: & Designatiion</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Department Management</a></li>
										<li><a href="#">Designation Management</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Payroll</a>
								<div class="mp-level">
									<h2>Payroll</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Salary Type Setup</a></li>
										<li><a href="#">Salary Setup</a></li>
										<li><a href="#">Salary Generate</a></li>
										<li><a href="#">Manage Employee Salary</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Attendants</a>
								<div class="mp-level">
									<h2>Attendants</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Attendance Form</a></li>
										<li><a href="#">Monthly Attendance</a></li>
										<li><a href="#">Missing Attendance</a></li>
										<li><a href="#">Attendance Log</a></li>
										<li><a href="#">Attendance Overview</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Recruitment</a>
								<div class="mp-level">
									<h2>Recruitment</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Add New Candidate</a></li>
										<li><a href="#">Manage Candidate</a></li>
										<li><a href="#">Manage Candidate</a></li>
										<li><a href="#">Interview</a></li>
										<li><a href="#">Candidate Selection</a></li>
										<li><a href="#">Today Candidate Attendance</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Loan</a>
								<div class="mp-level">
									<h2>Loan</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Grant Loan</a></li>
										<li><a href="#">Loan Installment</a></li>
										<li><a href="#">Loan Report</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Leave</a>
								<div class="mp-level">
									<h2>Leave</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Weekly Holiday</a></li>
										<li><a href="#">Holiday</a></li>
										<li><a href="#">Add Leave Type</a></li>
										<li><a href="#">Leave Application</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Award</a>
								<div class="mp-level">
									<h2>Award</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Employee Performance</a></li>
										<li><a href="#">Award</a></li>
										<li><a href="#">Add Award Type</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Accounting
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">Accounting</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Accounts</a>
								<div class="mp-level">
									<h2>Accounts</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Manage Accounts</a></li>
										<li><a href="#">Balance Sheet</a></li>
										<li><a href="#">Accounts Statements</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Transaction</a>
								<div class="mp-level">
									<h2>Transaction</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">View Transactions</a></li>
										<li><a href="#">New Transactions</a></li>
										<li><a href="#">New Transfer</a></li>
										<li><a href="#">Client Transaction</a></li>
										<li class="icon icon-arrow-left">
											<a class="" href="#">Petty Cash Sec.</a>
											<div class="mp-level">
												<h2>Petty Cash Section</h2>
												<a class="mp-back" href="#">back</a>
												<ul>
													<li><a href="#">Petty cash</a></li>
													<li><a href="#">Instant (Buy Something)</a></li>
													<li><a href="#">Advance Money</a></li>
													<li><a href="#">Advance Money Logs & Approval</a></li>
													<!--<li><a href="#">Advance Money Approval Logs</a></li>-->
												</ul>
											</div>
										</li>
										<li><a href="#">Checkout Member List</a></li>
										<li><a href="#">Check Print</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Income</a>
								<div class="mp-level">
									<h2>Income</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">View Income</a></li>
										<li><a href="#">Add Income Category</a></li>
										<li><a href="#">Add Income</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Expence</a>
								<div class="mp-level">
									<h2>Expence</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">View Expence</a></li>
										<li><a href="#">Add Expence Category</a></li>
										<li><a href="#">Add Expence</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Advance Acounts</a>
								<div class="mp-level">
									<h2>Advance Acounts</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Chart of Account</a></li>
										<li><a href="#">Balance Adjustment</a></li>
										<li><a href="#">Cash Adjustment</a></li>
										<li><a href="#">Bank Adjustment</a></li>
										<li><a href="#">Payment Type</a></li>
										<li><a href="#">Debit Voucher</a></li>
										<li><a href="#">Credit Voucher</a></li>
										<li><a href="#">Contra Voucher</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Loan</a>
								<div class="mp-level">
									<h2>Loan</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Grant Loan</a></li>
										<li><a href="#">Loan Installment</a></li>
										<li><a href="#">Loan Report</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Account Report</a>
								<div class="mp-level">
									<h2>Account Report</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Cash Book</a></li>
										<li><a href="#">Bank Book</a></li>
										<li><a href="#">General Ledger</a></li>
										<li><a href="#">Trial Balance</a></li>
										<li><a href="#">Profit Loss</a></li>
										<li><a href="#">Cash Flow</a></li>
										<li><a href="#">Coa Print</a></li>
									</ul>
								</div>
							</li>
							
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Reports
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">Reports</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Booking</a>
								<div class="mp-level">
									<h2>Accounts</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Booking Report</a></li>
										<li><a href="#">Rental Report</a></li>
										<li><a href="#">Renew Report</a></li>
										<li><a href="#">CheckIn Today</a></li>
										<li><a href="#">CheckOut Today</a></li>
										<li><a href="#">Calcel Request Report</a></li>
										<li><a href="#">Package Change Report</a></li>
										<li><a href="#">Bed Change Report</a></li>
										<li><a href="#">Discount Report</a></li>
										<li><a href="#">Cancel Reminder</a></li>
										<li><a href="#">Live Occupide Report</a></li>
										<li><a href="#">Live Cancel Report</a></li>
										<li><a href="#">Live Booked Report</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Collection Report</a>
								<div class="mp-level">
									<h2>Collection Report</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Trasaction Report</a></li>
										<li><a href="#">Locker Report</a></li>
										<li><a href="#">Electric-Bill Report</a></li>
										<li><a href="#">CashBack Report</a></li>
										<li><a href="#">All Collection Report</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">CRM Report</a>
								<div class="mp-level">
									<h2>CRM Report</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Checkout Member List</a></li>
										<li><a href="#">Refunded Member List</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Front Office</a>
								<div class="mp-level">
									<h2>Front Office</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Shop Report</a></li>
										<li><a href="#">Dinning Report</a></li>
										<li><a href="#">Visitor Book Report</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Communicate</a>
								<div class="mp-level">
									<h2>Communicate</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">All & All SMS Log</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Other Report</a>
								<div class="mp-level">
									<h2>Other Report</h2>
									<a class="mp-back" href="#">back</a>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Tracing Report</a>
								<div class="mp-level">
									<h2>Tracing Report</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Screenshots</a></li>
									</ul>
								</div>
							</li>
						
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Communicate
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">Communicate</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="">
								<a class="" href="#">Notice Board</a>
							</li>
							<li class="">
								<a class="" href="#">Notice History</a>
							</li>
							<li class="">
								<a class="" href="#">Send SMS</a>
							</li>
							<li class=>
								<a class="" href="#">SMS History</a>
							</li>
							<li class=>
								<a class="" href="#">Send Email</a>
							</li>
							<li class="">
								<a class="" href="#">Email History</a>
							</li>
							<li class="">
								<a class="" href="#">Call History</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Front End
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">Front End</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="">
								<a class="" href="#">Add Item</a>
							</li>
							<li class="">
								<a class="" href="#">Remove Item</a>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Static Pages</a>
								<div class="mp-level">
									<h2>Static Pages</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Terms & Conditions</a></li>
										<li><a href="#">Privacy Policy</a></li>
										<li><a href="#">FAQ</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Create
					</a>
					<div class="mp-level">
						<h2 class="icon icon-display">Create</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Branch,Bed etc.</a>
								<div class="mp-level">
									<h2>Branch,Bed etc.</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Manage Branch</a></li>
										<li><a href="#">Manage Floor*</a></li>
										<li><a href="#">Manage Unit</a></li>
										<li><a href="#">Manage Rooms</a></li>
										<li><a href="#">Manage Column</a></li>
										<li><a href="#">Manage Beds</a></li>
										<li><a href="#">Manage Room Types</a></li>
										<li><a href="#">Manage Locker Types</a></li>
										<li><a href="#">Manage Locker</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">HRM</a>
								<div class="mp-level">
									<h2>HRM</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Manage Roles</a></li>
										<li><a href="#">Manage Department</a></li>
										<li><a href="#">Manage Designatiion</a></li>
										<li><a href="#">Manage Grade</a></li>
										<li><a href="#">Leave Types</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Booking</a>
								<div class="mp-level">
									<h2>Booking</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Manage Package Category</a></li>
										<li><a href="#">Manage Sub-Category</a></li>
										<li><a href="#">Manage Package</a></li>
										<li><a href="#">Manage Services</a></li>
										<li><a href="#">Manage Document Type</a></li>
										<li><a href="#">Manage Payment Type</a></li>
										<li><a href="#">CheckOut Iteams</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Front Office</a>
								<div class="mp-level">
									<h2>Front Office</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Add Products (shop)</a></li>
										<li><a href="#">Add Audio</a></li>
										<li><a href="#">Add Video</a></li>
										<li><a href="#">Add Door Ips</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Software Learning</a>
								<div class="mp-level">
									<h2>Software Learning</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Add Tutorials</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Application
					</a>
					<div class="mp-level">
						<h2 class="">Application</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="">
								<a class="" href="#">File Manager</a>
							</li>
							<li class="">
								<a class="" href="#" target="_blank">bkash</a>
								<div class="mp-level">
									<h2>bkash</h2>
									<a class="mp-back" href="#">back</a>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Document Verify</a>
								<div class="mp-level">
									<h2>Document Verify</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#" target="_blank">Brith Certificate</a></li>
										<li><a href="#" target="_blank">NID Card</a></li>
									</ul>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Mobile Recharge</a>
								<div class="mp-level">
									<h2>Mobile Recharge</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#" target="_blank">GrmeenPhone</a></li>
									</ul>
								</div>
							</li>
							<li class="">
								<a class="" href="#">Photoshop</a>
							</li>
							<li class="">
								<a class="" href="#">Illustrator</a>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">Music Player</a>
								<div class="mp-level">
									<h2>Music Player</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Audio Player</a></li>
										<li><a href="#">Video Player</a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Settings
					</a>
					<div class="mp-level">
						<h2 class="">Settings</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="">
								<a class="" href="#">General Setting</a>
							</li>
							<li class="">
								<a class="" href="#">Notification Setting</a>
								<div class="mp-level">
									<h2>Notification Settings</h2>
									<a class="mp-back" href="#">back</a>
								</div>
							</li>
							<li class="icon icon-arrow-left">
								<a class="" href="#">SMS</a>
								<div class="mp-level">
									<h2>SMS</h2>
									<a class="mp-back" href="#">back</a>
									<ul>
										<li><a href="#">Configure SMS</a></li>
										<li><a href="#">SMS Purpose</a></li>
										<li><a href="#">SMS Template</a></li>
									</ul>
								</div>
							</li>
							<li class="">
								<a class="" href="#">Email Setting</a>
							</li>
							<li class="">
								<a class="" href="#">Backup/ Restore</a>
							</li>
							<li class="">
								<a class="" href="#">Language</a>
							</li>
							<li class="">
								<a class="" href="#">Modules</a>
							</li>
						</ul>
					</div>
				</li>
				<li class="icon icon-arrow-left">
					<a class="" href="#">
						<i class="fas fa-layer-group">&nbsp;&nbsp;&nbsp;</i>
						Profile
					</a>
					<div class="mp-level">
						<h2 class="">Profile</h2>
						<a class="mp-back" href="#">back</a>
						<ul>
							<li class="">
								<a class="" href="#">Advance Money Request</a>
							</li>
							<li class="">
								<a class="" href="#">Urgent Expenses</a>
							</li>
							<li class="">
								<a class="" href="#">My Profile</a>
							</li>
							<li class="">
								<a class="" href="#">Visiting Card</a>
							</li>
							<li class="">
								<a class="" href="#">ID Card</a>
							</li>
							<li class="">
								<a class="" href="#">Joining Letter</a>
							</li>
							<li class="">
								<a class="" href="#">My Attendents</a>
							</li>
							<li class="">
								<a class="" href="#">Change Password</a>
							</li>
							<li class="">
								<a class="" href="#">Change Profile Picture</a>
							</li>
							<li class="">
								<a class="" href="#">Logout</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>	
		</div>
	</div>
</div>
<script src="<?=base_url('assets/aside/');?>js/classie.js"></script>
<script src="<?=base_url('assets/aside/');?>js/mlpushmenu.js"></script>
<script>
	new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ) );
</script>