
 
 <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Complain Submit</title>
	<style>
	 /* Style inputs with type="text", select elements and textareas */
		input[type=text], input[type=file],input[type=number] ,select, textarea {
		  width: 100%; /* Full width */
		  padding: 12px; /* Some padding */ 
		  border: 1px solid #ccc; /* Gray border */
		  border-radius: 4px; /* Rounded borders */
		  box-sizing: border-box; /* Make sure that padding and width stays in place */
		  margin-top: 6px; /* Add a top margin */
		  margin-bottom: 16px; /* Bottom margin */
		  resize: vertical /* Allow the user to vertically resize the textarea (not horizontally) */
		}

		/* Style the submit button with a specific background color etc */
		input[type=submit] {
		  background-color: #04AA6D;
		  color: white;
		  padding: 12px 20px;
		  border: none;
		  border-radius: 4px;
		  cursor: pointer;
		}

		/* When moving the mouse over the submit button, add a darker green color */
		input[type=submit]:hover {
		  background-color: #45a049;
		}

		/* Add a background color and some padding around the form */
		.container {
		 
		  color: white;
		  opacity: 0.7;
		  border-radius: 5px;
		  background-color: #4f3434;
		  padding: 20px;
		  position: absolute;
		  top: 50%;
		  left: 50%;
		  -ms-transform: translate(-50%, -50%);
		  transform: translate(-50%, -50%);
		  
		}  
		
		#complain_images {
		  padding: 7px;
		}
		
		@media only screen and (max-width: 576px) {
		  .col-md-4.col-sm-4 {
			  position: absolute;
			  padding-right: 26px;
			}
		}
		
		
		</style>
  </head>
  <body style="background-image: url('http://erp.superhostelbd.com/super_home/assets/uploads/complain/sky.jpeg');">
    <div class="container col-md-6 ">
		<h3 class="text-center">COMPLAIN SUBMISSION FORM</h3><hr>
		<?php if(isset($error)){ ?>
		
		<div class="alert alert-danger"><?php echo $error; ?></div>
		<?php } ?>
		
		<?php if(isset($success)){ ?>
		
		<div class="alert alert-success succ"><?php  echo $success; ?></div>
		<?php  } ?>
	  <form  role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
		
			<label for="card_phone">Phone Number / Card Number: <span class="msg text-danger" style="visibility: hidden;" ><?php echo "Invalid Card or Phone Number!"; ?></span></label>
			<input type="number" pattern="[0-9]" id="card_phone" name="card_phone" placeholder="Enter Card Number Or Phone Number" required>
			<span class="text-danger"><?php echo form_error('card_phone');?> </span>
		
		<div class="main">
			<div class="row append">
				<div class="col-md-6">
					<label for="category">Problem Category: </label>
					<select id="category" name="category[]" required>
					  <option value="">Select </option>
					  <?php foreach($result as $r) { ?>
					   <option value="<?php echo $r->id; ?>"><?php echo $r->name; ?></option>
					  <?php } ?>
					</select>
					<span class="text-danger"><?php echo form_error('category[]');?> </span>
				</div>
				<div class="col-md-6">
					<label for="complain_images">Images: </label>
					<input class="complain_images" type="file" id="complain_images" name="complain_images_0[]" multiple> 
				</div>
				
			</div>
			<label for="note">Note: </label>
			<textarea id="note" name="note[]" placeholder="Please write as much as details" required></textarea>
			<span class="text-danger"><?php echo form_error('note[]');?> </span><hr>
		</div>
		
		<div class="row d-flex">
			<div class=" col-md-8 col-sm-8">
				<input type="submit" id="submit" name="submit" value="Submit">
			</div>
			<div class=" col-md-4 col-sm-4" style="text-align: right;">
				<button type="button" class="btn btn-lg btn-primary add">+MORE</button>
			</div>
		</div>
		
		
	  </form>
		
	</div> 

	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$(document).on('keyup', '#card_phone', function(e) {
				e.preventDefault();
				var card_phone = $("#card_phone").val();
				
			    $.ajax({
					url: "<?=base_url('admin/create/complain/check-member'); ?>",

					type:"post",
					data:{'card_phone':card_phone},
					dataType:"JSON",
					success:function(data) {
					  if(data.result){
						  $(".msg").css({"visibility": "hidden"});
						  $("#card_phone").css({"border-color": "", "border": ""});
					  }else{
						  $(".msg").css({"visibility": "visible"});
						  $("#card_phone").css({"border-color": "red", "border": "2px solid red"});
					  }
					},	
				});
			});
			
			$(document).on('click', '.add', function() {
				var main = $(".main").first();
				$(".main").last().after(main[0].outerHTML);
				var count = $(".complain_images");
				for(i=0; i < count.length; i++){
					$($(".complain_images")[i]).attr('name', 'complain_images_' + i+"[]");
				}
				
			});
			
			
			var is_visible = $(".succ").is(":visible");
			if(is_visible){
				
				window.location.href = "https://superhomebd.com/";
			}
			
		});
		
		
	</script>
  </body>
</html>

 