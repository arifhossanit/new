<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['value'])){
	$emj = mysqli_fetch_assoc($mysqli->query("select * from food_feedback_emoji where status = '1' and id = '".$_POST['value']."'"));
?>
<form id="feed_back_sumit" action="#" method="post">
	<input type="hidden" name="value" value="<?php echo $emj['feed_back_value']; ?>"/>
	<input type="hidden" name="note" value="<?php echo $emj['feedback_title_english']; ?> - <?php echo $emj['feedback_title_bangla']; ?>"/>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<center>
				<img src="<?php echo $home.$emj['emoji_image']; ?>" style="" class="custom_moj_d image-responsive"/>
				<p style="margin-bottom:0px;"><?php echo $emj['feedback_title_english']; ?></p>
				<p><?php echo $emj['feedback_title_bangla']; ?></p>
			</center>
		</div>
		<div class="col-sm-4"></div>
	</div>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<div class="form-group">
				<input style="opacity:0;" type="text" name="card_number" class="number_int form-control" autocomplete="off" required />
			</div>
		</div>
		<div class="col-sm-4"></div>
	</div>
	<div class="row">
		<div class="col-sm-4"></div>
		<div class="col-sm-4">
			<center>
				<img src="<?php echo $home; ?>assets/img/card_holder.gif" style="width:300px;" class="image-responsive"/>
			</center>
		</div>
		<div class="col-sm-4"></div>
	</div>
</form>
<script>
$('document').ready(function(){
	var home = '<?php echo $home; ?>';
	setTimeout(function(){
		$('input[name="card_number"]').focus();
	}, 300);
	
	$("#feed_back_sumit").on("submit",function(){
		var card_number = $('input[name="card_number"]').val();
		if(card_number != '' && card_number > 7){
			event.preventDefault();
			var form = $('#feed_back_sumit')[0];
			var data = new FormData(form);	
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: ""+home+"assets/ajax/form_submit/input_food_feedback_data.php",  
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				beforeSend:function(){
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					var value = data.split('_____');
					if(value[1] == '1'){
						swal("Success!", value[0], "success");
					}else if(value[1] == '2'){
						swal("Warning!", value[0], "error");
					}else{
						swal("Danger!", value[0], "error");
					}
					setTimeout(function(){
						window.open('<?php echo $home; ?>member-food-feedback','_self');
					}, 3000);
				}
			});
		}else{
			swal("Something wrong In your card Number! Please try again ", "", "error");
		}
		return false;
	}) 
})
</script>
<?php
}
?>