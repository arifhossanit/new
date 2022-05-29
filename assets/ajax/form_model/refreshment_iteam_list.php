<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['card_number'])){ 
unset($_SESSION["cart_item"]);
$member_info = mysqli_fetch_assoc($mysqli->query("select * from member_directory where card_number = '".$_POST['card_number']."' or phone_number = '".$_POST['card_number']."'"));
$enquery_info = mysqli_fetch_assoc($mysqli->query("select * from booking_enquery where generate_id = '".$_POST['card_number']."' or phone = '".$_POST['card_number']."'"));
$employee_info = mysqli_fetch_assoc($mysqli->query("select * from employee where employee_id = '".$_POST['card_number']."' or personal_Phone = '".$_POST['card_number']."'"));
$visitor_info = mysqli_fetch_assoc($mysqli->query("select * from visitor_book where generate_id = '".$_POST['card_number']."' or phone = '".$_POST['card_number']."'"));

if(!empty($member_info['id'])){
	$card_number = $member_info['card_number'];
	$buyer_type = 'Member';
	$name = $member_info['full_name'];
	$phone_number = $member_info['phone_number'];
	$booking_id = $member_info['booking_id'];
}else if(!empty($enquery_info['id'])){
	$card_number = $enquery_info['generate_id'];
	$buyer_type = 'Visitor';
	$name = $enquery_info['name'];
	$phone_number = $enquery_info['phone'];
	$booking_id = '';
}else if(!empty($employee_info['id'])){
	$card_number = $employee_info['employee_id'];
	$buyer_type = 'Employee';
	$name = $employee_info['full_name'];
	$phone_number = $employee_info['personal_Phone'];
	$booking_id = '';
}else if(!empty($visitor_info['id'])){
	$card_number = $visitor_info['generate_id'];
	$buyer_type = 'Visitor ('.$visitor_info['reason'].')';
	$name = $visitor_info['name'];
	$phone_number = $visitor_info['phone'];
	$booking_id = '';
}
if(empty($card_number)){ ?>
<div class="row">
	<div class="col-sm-12">
		<h1 style="text-align:center;color:#f00;margin-top: 169px;">No result found by "<?php echo $_POST['card_number']; ?>"</h1>
	</div>	
</div>		
<?php }else{ ?>
<div class="row">
	<div class="col-sm-12">
		<h4 style="text-align:center;color:green;">Buyer Type: <?php echo $buyer_type; ?> | Name: <?php echo $name; ?></h4>
		<input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>"/>
		<input type="hidden" name="buyer_type" value="<?php echo $buyer_type; ?>"/>
		<input type="hidden" name="card_number" value="<?php echo $card_number; ?>"/>
		<input type="hidden" name="branch_id" value="<?php echo $_POST['branch_id']; ?>"/>
		<input type="hidden" name="buyer_name" value="<?php echo $name; ?>"/>
		<input type="hidden" name="phone_number" value="<?php echo $phone_number; ?>"/>
	</div>	
</div>	
<style>
.focuaable_css:focus img{
	border:solid 1px #f00;
}
.focuaable_css span p{
	margin:0px;
	font-size:10px;
}
</style>
<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-6"> 
				<div class="row">
<?php
$iteam_sql = $mysqli->query("select * from refreshment_item where branch_id = '".$_POST['branch_id']."'"); // where branch_id = '".$_POST['branch_id']."'
while($iow = mysqli_fetch_assoc($iteam_sql)){
	$in_session = "0";
	if(!empty($_SESSION["cart_item"])) {
		$session_code_array = array_keys($_SESSION["cart_item"]);
		if(in_array($iow['code'],$session_code_array)) {
			$in_session = "1";
		}
	}
?>
					<div class="col-sm-3 focuaable_css">
						<button type="button" class="btn btn-default my-cart-btn" style="padding:0px;margin-bottom: 10px;padding-bottom:2px;">
							<input type="number" id="qty_<?php echo $iow['code']; ?>" name="quantity" value="1" min="1" style="width:90%;margin-left:5%;margin-right:5%;margin-top:5%;line-height: 17px;height:17px;padding:2px;text-align:center;font-weight:bolder;" class="form-control"/>
							<img src="<?php echo $home.$iow['item_picture']; ?>" style="width:100%;border-bottom: solid 1px #ece7e7;border-radius:3px;padding:4px;" class="image-responsive"/>
							<center>
								<span>
									<p style="font-weight:bolder;"><?php echo $iow['item_name']; ?></p>
									<p style="line-height: 10px;color:#f00;"><?php echo money($iow['price']); ?></p>									
								</span>
							</center>
							<a href="javascript:void(0)" id="add_<?php echo $iow['code']; ?>" onclick="return cartAction('add','<?php echo $iow['code']; ?>')" type="button" class="btnAddAction btn btn-success btn-xs" style="width:92%<?php if($in_session != "0") { ?>display:none;<?php } ?>">Add</a>
							<a href="javascript:void(0)" id="added_<?php echo $iow['code']; ?>" type="button" class="btnAdded btn btn-warning btn-xs" style="width:92%;<?php if($in_session != "1") { ?>display:none;<?php } ?>" disable>Added</a>
						</button>
					</div>
<?php } ?>			
				</div>
			</div>
			<div class="col-sm-6" id="add_to_cart_result">
			</div>
		</div>
	</div>
</div>
<script>
function cartAction(action,product_code) {
	var queryString = "";
	if(action != "") {
		if(action == 'add'){
			queryString = 'action='+action+'&code='+ product_code+'&quantity='+$("#qty_"+product_code).val();
		}else if(action == 'remove'){
			queryString = 'action='+action+'&code='+ product_code;
		}else{
			queryString = 'action='+action;
		}	 
	}
	jQuery.ajax({
	url: "<?php echo $home.'assets/ajax/form_model/refreshment_list_add_to_cart.php'; ?>",
	data:queryString,
	type: "POST",
	beforeSend:function(){					
		$('#data-loading').html(data_loading);
	},
	success:function(data){
		$('#data-loading').html('');
		$("#add_to_cart_result").html(data);
		if(action != "") {
			switch(action) {
				case "add":
					$("#add_"+product_code).hide();
					$("#added_"+product_code).show();
				break;
				case "remove":
					$("#add_"+product_code).show();
					$("#added_"+product_code).hide();
					
				break;
				case "empty":
					$(".btnAddAction").show();
					$(".btnAdded").hide();
				break;
			}	 
		}
	},
	error:function (){}
	});
}

$(document).ready(function () {
	cartAction('','');
})
</script>		
<?php 
	}
}
?>
