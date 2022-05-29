<div class="notification_base">
	<div class="notification_open">
		<i class="far fa-bell"></i>
		<span id="notification_counter" class="badge badge-danger navbar-badge" style="font-size:13px;top:5px;">0</span>
	</div>	
	<div class="notification_boxi" style="display:none;">
		<div class="notification_header">
			<span class="dropdown-header">
				<span id="notification_counter_header">0</span> New Notifications
				<a href="javascript:void(0);" class="notification_close_btn">
					<i class="fas fa-times notification_close"></i>
				</a>
			</span>			
		</div>
		<div id="notification_dropdown" class="" style="overflow-y: scroll; max-height: 500px;"> </div>
	</div>
</div>

<footer class="main-footer">
	<div class="container-fluid">
		<div class="float-right d-none d-sm-inline">
		  Software Version 2.9.5
		</div>
		<strong>&copy; 2016-<?=date('Y'); ?>. <a href="#">Neways S & IT Department</a>.</strong> All rights reserved.
	</div>
</footer>
<script>
	$(document).ready(function(){		
		$('.notification_close_btn').on('click',function(){
			$('.notification_boxi').fadeOut();
		})
		$('.notification_open').on('click',function(){
			$('.notification_boxi').fadeIn();
		})
	})
</script>
<style>
.notification_base{
	position: fixed;
    width: 40px;
    height: 40px;
    left: 0%;
    top: 19%;
    background: #fff;
	border-radius:50px;
	border: solid 1px #6c757d;
	z-index: 999;
	cursor: pointer;
}
.notification_base .fa-bell{
	font-size: 28px; 
	margin-left: 6.4px; 
	line-height: 36px;
}
.notification_boxi{
	width: 350px;

    background-color: #fff;
    left: 105%;
    position: absolute;
    top: 6%;	
	box-shadow: 0px 0px 5px 0px #333;
	border-radius: 3px;
}
.notification_header{
	width: 100%;
    height: 33px;
    background: #fff;
	border-radius: 3px;
}
.notification_close{
	float: right;
    font-size: 26px;
    color: #f00;
	margin-top: -3px;
    margin-right: -10px;
}
#notification_dropdown{
	width:100%;
}
.notification_base .dropdown-divider{
	margin:0px;
}
</style>