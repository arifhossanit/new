<?php 
include("../../../application/config/ajax_config.php");
if(isset($_POST['get_id'])){
	$row = mysqli_fetch_assoc($mysqli->query("select * from employee where id = '".rahat_decode($_POST['get_id'])."'"));
?>
<link href="<?php echo $home; ?>assets/css/style_employee_rating.css" rel="stylesheet" type="text/css" media="all" />

<form id="feed_back_form" action="" method="post" enctype="mutipart/form-data">
<input type="hidden" name="receiver_id" value="<?php echo $row['id']; ?>"/>
<div class="main" style="font-family: 'Open Sans', sans-serif !important; background: url(<?php echo $home; ?>assets/img/5.jpg) no-repeat center center fixed; background-size: cover;min-height: 100%;padding-bottom:30px;;">
	<div class="main-info w3l" style="margin-top:0px;">
		<div class="main-row">
			<div class="profile-grid logo wthree">
				<?php if(!empty($row['photo'])){ ?>
				<img src="<?php echo $home.$row['photo']; ?>" alt="" style="height:133px;width:133px;">
				<?php } else { ?>
				<img src="<?php echo $home.$row['photo']; ?>" alt="" style="height:133px;width:133px;">
				<?php } ?>				
				<h2><b><?php echo $row['full_name']; ?></b></h2>
				<p><?php echo $row['designation_name']; ?> - <?php echo $row['department_name']; ?></p>				
			</div>			
			<div class="social-icons agileits">				
				<span id="error_message"></span>
				<input type="hidden" id="user_type" name="user_type" value=""/>
				<input type="text" id="phone_number" onkeyup="return phone_number_check()" name="phone_number" class="form-control" autocomplete="off" placeholder="Phone Number / Card Number" style="box-sizing: border-box !important;padding:1.375rem .75rem;margin-bottom:30px;" required />
				<div id="form">					
					<fieldset class="stars">
						<input type="radio" name="stars" value="5" id="star1" ontouchstart="ontouchstart"  />
						<label class="fa fa-star" for="star1"></label>
						
						<input type="radio" name="stars" value="4" id="star2" ontouchstart="ontouchstart"  />
						<label class="fa fa-star" for="star2"></label>
						
						<input type="radio" name="stars" value="3" id="star3" ontouchstart="ontouchstart"  />
						<label class="fa fa-star" for="star3"></label>
						
						<input type="radio" name="stars" value="2" id="star4" ontouchstart="ontouchstart"  />
						<label class="fa fa-star" for="star4"></label>
						
						<input type="radio" name="stars" value="1" id="star5" ontouchstart="ontouchstart"  />
						<label class="fa fa-star" for="star5"></label>
						
						<figure class="face">
							<i></i><i></i>
							<u>
								<div class="cover"></div>
							</u>
						</figure>
					</fieldset>
				</div>
				<textarea name="note" class="form-control" placeholder="Comments" style="box-sizing: border-box !important;margin-bottom:15px;" ></textarea>
        <label for="attachment" class="text-left mb-2" style="color: white;">Attachment</label>
        <input type="file" name="attachment" class="form-control-file mb-3">
				<center>
					<button type="submit" id="submit_feed_back" name="submit" class="btn btn-lg btn-success">Submit</button>
				</center>
			</div>			
		</div>		
	</div>	
	<div class="copyright">
		<p> © <?php echo date("Y"); ?> Super Home . All rights reserved | Design by <a href="#" target="_blank">Neways IT</a></p>
	</div>
</div>
</form>
  

<script>
function phone_number_check(){
	var number = $("#phone_number").val();
	if(number != ''){
		$.ajax({  
			url:"<?php echo $home.'assets/ajax/qr_code/employee_member_number_check_qr_code.php';?>",  
			method:"POST",  
			data:{get_id:number},
			success:function(data){	
				var value = data.split('____');
				if(value[0] == '1'){
					if(value[1] == '1'){
						$("#user_type").val(value[1]);
					}else{
						$("#user_type").val(value[1]);
					}
					$("#submit_feed_back").prop("disabled", false);
					$("#error_message").html('<p style="color:green;background-color:#fff;">Number Matched</p>');
				}else{
					$("#submit_feed_back").prop("disabled", true);
					$("#error_message").html('<p style="color:#f00;background-color:#fff;">Number Not match witch any member or employee!</p>');
				}
			}  
		});
	}
}
$("#feed_back_form").on("submit",function(){
	if($('input[type="radio"]').is(":checked")){
		var number = $("#phone_number").val();
		if(number != ''){
			event.preventDefault();
			var form = $('#feed_back_form')[0];
			var data = new FormData(form);			
			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url:"<?php echo $home.'assets/ajax/qr_code/finish_employee_rating_booking.php'; ?>",  
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				beforeSend:function(){
					$("#submit_feed_back").prop("disabled", true);
					$('#data-loading').html(data_loading);
				},
				success:function(data){
					$('#data-loading').html('');
					$("#submit_feed_back").prop("disabled", false);
					if(data == '1'){
						$("#error_message").html('<p style="color:#f00;background-color:green;">Thank You!</p>');
						// setTimeout(
						// 	function(){
						// 		window.open('<?php echo 'https://superhomebd.com/'; ?>','_self');
						// 	},
						// 	2500
						// );
					}else if(data == '2'){
						$("#error_message").html('<p style="color:#f00;background-color:#fff;">Cannot give your own rating!</p>');
          }else if(data == '3'){
						$("#error_message").html('<p style="color:#f00;background-color:#fff;">Cannot give rating right now!</p>');
          }else{
						$("#error_message").html('<p style="color:#f00;background-color:#fff;">Something wrong! Please try again</p>');
					}
				}
			});	
		}
		$("#error_message").html('');
		return false;
	}else{
		$("#error_message").html('<p style="color:#f00;background-color:#fff;">Please Choose at list one star</p>');
		return false;		
	}	
})
</script>




<style>


*, ::after, ::before {
    box-sizing: content-box !important;
}
#form {
  display: -webkit-box;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: reverse;
          flex-direction: column-reverse;
  -webkit-box-pack: center;
          justify-content: center;
  -webkit-box-align: center;
          align-items: center;
  max-width: 800px;
  height: 100%;
  margin: auto;
}

[class*="fontawesome-"]:before {
  font-family: 'FontAwesome', sans-serif;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  margin: auto;
  width: 100%;
  height: 100%;
}

.reset {
  display: none;
  position: absolute;
  top: 100%;
  left: 50%;
  margin: auto;
  padding: 12px 24px;
  color: #3d3d3d;
  background: #f0f0f0;
  border: 4px solid #3d3d3d;
  border-radius: 60px;
  font-family: "Helvetica", sans-serif;
  font-size: 18px;
  font-weight: bold;
  text-transform: uppercase;
  text-shadow: rgba(255, 255, 255, 0.8) 1px 1px 0;
  cursor: pointer;
  box-shadow: inset rgba(0, 0, 0, 0.06) 0 -15px 0;
  outline: none;
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
}
.reset:hover {
  background: #FFFF4C;
}

input, label {
  -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
}

.stars {
  position: relative;
}
.stars input {
  display: none;
}
.stars input:checked ~ label:not(.reset) {
  -webkit-animation: wobble 0.8s ease-out;
          animation: wobble 0.8s ease-out;
  color: #FFDB19;
}
.stars input:checked:not(#star-reset) ~ label.reset {
  display: block;
}
.stars label:not(.reset) {
  display: inline-block;
  float: right;
  position: relative;
  width: 40px;
  height: 40px;
  font-size: 40px;
  padding: 2px;
  cursor: pointer;
  color: #3d3d3d;
  -webkit-transition: color 0.1s ease-out;
  transition: color 0.1s ease-out;
  z-index: 10;
}

.face {
position: relative;
    width: 130px;
    background: white;
    border: 6px solid #f0f0f0;
    border-radius: 100%;
    margin: 94px 0 65px;
    -webkit-transition: box-shadow 0.4s ease-out;
    transition: box-shadow 0.4s ease-out;
    margin-left: 38px;
}
.face:after {
  content: "";
  display: block;
  padding-bottom: 100%;
}

i {
  position: absolute;
  top: 50%;
  display: block;
  width: 14px;
  height: 14px;
  border-radius: 100%;
  background: #f0f0f0;
}
i:nth-child(1) {
  left: 30%;
}
i:nth-child(2) {
  right: 30%;
}

u {
  position: absolute;
  right: 0;
  bottom: 25%;
  left: 0;
  margin: auto;
  width: 24px;
  height: 24px;
  text-decoration: none;
  border: 6px solid #f0f0f0;
  border-radius: 100%;
}
u:before, u:after {
  content: "";
  position: absolute;
  top: 15px;
  width: 6px;
  height: 6px;
  background: #f0f0f0;
  border-radius: 60px 60px 0 0;
  z-index: 2;
}
u:before {
  left: -5px;
  -webkit-transform: rotate(-32deg);
          transform: rotate(-32deg);
}
u:after {
  right: -5px;
  -webkit-transform: rotate(32deg);
          transform: rotate(32deg);
}
u .cover {
  position: absolute;
  top: -6px;
  left: -6px;
  width: 100%;
  height: 100%;
  border: 6px solid white;
  background: white;
  -webkit-transform: translate(0, -12px);
          transform: translate(0, -12px);
}

input#star4:checked ~ .face u,
input#star2:checked ~ .face u {
  width: 36px;
}
input#star4:checked ~ .face u:before, input#star4:checked ~ .face u:after,
input#star2:checked ~ .face u:before,
input#star2:checked ~ .face u:after {
  top: 18px;
  height: 10px;
}
input#star4:checked ~ .face u:before,
input#star2:checked ~ .face u:before {
  left: 0px;
  -webkit-transform: rotate(-66deg);
          transform: rotate(-66deg);
}
input#star4:checked ~ .face u:after,
input#star2:checked ~ .face u:after {
  right: 0px;
  -webkit-transform: rotate(66deg);
          transform: rotate(66deg);
}
input#star4:checked ~ .face u .cover,
input#star2:checked ~ .face u .cover {
  -webkit-transform: translate(0, -8px);
          transform: translate(0, -8px);
}

input#star5:checked ~ .face u,
input#star4:checked ~ .face u {
  -webkit-transform: rotate(180deg) translateY(-20px);
          transform: rotate(180deg) translateY(-20px);
}

input#star3:checked ~ .face u {
  width: 42px;
  height: 6px;
  background: #3d3d3d;
  border: none;
  border-radius: 60px;
  -webkit-transform: translateY(-4px);
          transform: translateY(-4px);
}
input#star3:checked ~ .face u:before, input#star3:checked ~ .face u:after,
input#star3:checked ~ .face u .cover {
  display: none;
}

input:not(#star-reset):checked ~ .face {
  -webkit-animation: wobble 0.8s ease-out;
          animation: wobble 0.8s ease-out;
}
input:not(#star-reset):checked ~ .face,
input:not(#star-reset):checked ~ .face u {
  border-color: #3d3d3d;
}
input:not(#star-reset):checked ~ .face i,
input:not(#star-reset):checked ~ .face u:before,
input:not(#star-reset):checked ~ .face u:after {
  background: #3d3d3d;
}

input#star5:checked ~ .face {
  background-color: white;
  box-shadow: inset rgba(255, 255, 255, 0.5) 2px 2px 0 4px, inset rgba(0, 0, 0, 0.06) -6px -4px 0 4px;
}
input#star5:checked ~ .face u .cover {
  background: white;
  border-color: white;
}

input#star4:checked ~ .face {
  background-color: #ffffe5;
  box-shadow: inset rgba(255, 255, 255, 0.5) 2px 2px 0 4px, inset rgba(0, 0, 0, 0.06) -6px -4px 0 4px, rgba(255, 255, 76, 0.05) 0 0 0 20px;
}
input#star4:checked ~ .face u .cover {
  background: #ffffe5;
  border-color: #ffffe5;
}

input#star3:checked ~ .face {
  background-color: #ffffb2;
  box-shadow: inset rgba(255, 255, 255, 0.5) 2px 2px 0 4px, inset rgba(0, 0, 0, 0.06) -6px -4px 0 4px, rgba(255, 255, 76, 0.3) 0 0 0 15px, rgba(255, 255, 76, 0.1) 0 0 0 30px;
}

input#star2:checked ~ .face {
  background-color: #ffff7f;
  box-shadow: inset rgba(255, 255, 255, 0.5) 2px 2px 0 4px, inset rgba(0, 0, 0, 0.06) -6px -4px 0 4px, rgba(255, 255, 76, 0.4) 0 0 0 20px, rgba(255, 255, 76, 0.2) 0 0 0 40px;
}
input#star2:checked ~ .face u .cover {
  background: #ffff7f;
  border-color: #ffff7f;
}

input#star1:checked ~ .face {
  background-color: #FFFF4C;
  box-shadow: inset rgba(255, 255, 255, 0.5) 2px 2px 0 4px, inset rgba(0, 0, 0, 0.06) -6px -4px 0 4px, rgba(255, 255, 76, 0.4) 0 0 0 25px, rgba(255, 255, 76, 0.2) 0 0 0 50px;
}
input#star1:checked ~ .face u .cover {
  background: #FFFF4C;
  border-color: #FFFF4C;
}

@-webkit-keyframes wobble {
  0% {
    -webkit-transform: scale(0.8);
            transform: scale(0.8);
  }
  20% {
    -webkit-transform: scale(1.1);
            transform: scale(1.1);
  }
  40% {
    -webkit-transform: scale(0.9);
            transform: scale(0.9);
  }
  60% {
    -webkit-transform: scale(1.05);
            transform: scale(1.05);
  }
  80% {
    -webkit-transform: scale(0.96);
            transform: scale(0.96);
  }
  100% {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}

@keyframes wobble {
  0% {
    -webkit-transform: scale(0.8);
            transform: scale(0.8);
  }
  20% {
    -webkit-transform: scale(1.1);
            transform: scale(1.1);
  }
  40% {
    -webkit-transform: scale(0.9);
            transform: scale(0.9);
  }
  60% {
    -webkit-transform: scale(1.05);
            transform: scale(1.05);
  }
  80% {
    -webkit-transform: scale(0.96);
            transform: scale(0.96);
  }
  100% {
    -webkit-transform: scale(1);
            transform: scale(1);
  }
}
</style>








  


<?php } ?>