<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Update Building Information</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item active">Update Building Information</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	 
	<div class="content">
		<div class="container-fluid">
			<div class="row justify-content-center">
             
             <div class="col-md-8">
              <div class="card card-primary"> 
                 <div class="card-header">
                   <h3 class="card-title">Update Buliding Information</h3> 
                 </div>
                 <div class="card-body">
                 <form role="form" action="<?=base_url('admin/update_building_info'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
               <div class="row">
               <div class="col-md-4">
                <div class="form-group">
                    <label for="owner_name">Owner Name</label>
                    <input type="text" name="owner_name" class="form-control" id="owner_name" placeholder="Owner Name" value="<?php echo $building->owner_name; ?>" required>
                </div>
              </div>
              <input type="hidden" name="rand" value="<?php echo $building->building_rand_id; ?>"> 
              <input type="hidden" name="id" value="<?php echo $building->id; ?>">
              <input type="hidden" name="employee_id" value="<?php echo $building->uploader_info; ?>">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="owner_phone">Owner Phone</label>
                    <input type="number" name="owner_phone" class="form-control" id="owner_phone" placeholder="Owner Phone" required value="<?php echo $building->owner_phone; ?>">
                </div>
              </div>

               <div class="col-md-4">
                  <div class="form-group">
                     <label for="area">Area</label>
                     <input type="text" name="area" class="form-control area" id="area" placeholder="Area" required value="<?php echo $building->area; ?>">
                  </div>
               </div>

               <div class="col-md-12">
                   <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" name="address" id="address" class="form-control address" id="address" placeholder="Address" required value="<?php echo $building->address; ?>">
                   </div>
               </div>

               <div class="col-md-6">
                   <div class="form-group">
                       <label for="building_type">Building Type</label>
                       <select class="form-control" name="building_type" id="building_type" class="form-control" required>
                          <option value="" selected disabled>Select Building Type</option>
                          <option value="new" <?php if($building->building_type == 'new'){echo "selected";} ?>>New</option>
                          <option value="old" <?php if($building->building_type == 'old'){echo "selected";} ?>>Old</option>
                          <option value="under_construction" <?php if($building->building_type == 'under_construction'){echo "selected";} ?>>Under Construction</option>
                       </select>
                   </div>
               </div>

               <div class="col-md-6">
                   <div class="form-group">
                       <label for="height">Height</label>
                       <input type="text" name="height" class="form-control" id="height" placeholder="Height" value="<?php echo $building->height; ?>" required>
                   </div>
               </div>

               <div class="col-md-6">
                 <div class="form-group">
                   <label for="substation">Substation</label>
                   <input type="text" name="substation" id="substation" class="form-control" placeholder="Substation" value="<?php echo $building->substation; ?>">
                 </div>
               </div>

               <div class="col-md-6">
                 <label for="servant_washroom">Servant & Washroom</label>
                <select class="form-control" name="servant_washroom" required>
                  <option value="" selected disabled>Choose Option</option>
                  <option value="yes" <?php if($building->servant_washroom == 'yes'){echo "selected";} ?>>Yes</option>
                  <option value="no" <?php if($building->servant_washroom == 'no'){echo "selected";} ?>>No</option>
                </select>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                   <label for="room_per_unit">Room Per Unit</label>
                   <input type="number" name="room_per_unit" id="room_per_unit" class="form-control" placeholder="Room Per Unit" required value="<?php echo $building->room_per_unit; ?>">
                 </div>
               </div>

               <div class="col-md-6">
                 <label for="total_room">Total Room</label>
                 <input type="number" name="total_room" class="form-control" id="total_room" placeholder="Total Room" required value="<?php echo $building->total_room; ?>">
               </div>

               

               <div class="col-md-6">
                   <div class="form-group">
                       <label for="bulding_floor">Building Floor</label>
                       <input type="text" name="bulding_floor" id="bulding_floor" class="form-control bulding_floor" placeholder="Building Floor" required value="<?php echo $building->bulding_floor; ?>">
                   </div>
               </div>
             
               <?php if($building->building_age == ''): ?>
                <div class="col-md-12 type_age" style="display:none;">
                    <div class="form-group">
                        <label for="building_age">Building Age</label>
                        <input type="text" name="building_age" class="form-control" id="building_age" placeholder="building_age">
                    </div>
                </div>
              <?php else: ?>
                <div class="col-md-12 type_age">
                    <div class="form-group">
                        <label for="building_age">Building Age</label>
                        <input type="text" name="building_age" class="form-control" id="building_age" placeholder="building_age" value="<?php echo $building->building_age; ?>">
                    </div>
                </div>
               <?php endif; ?>

               <div class="col-md-6">
                 <div class="form-group">
                     <label for="rent_per_sqft">Rent Per Square Fit</label>
                     <input type="text" name="rent_per_sqft" class="form-control" id="rent_per_sqft" placeholder="Rent Per Square Fit" required value="<?php echo $building->rent_per_sqft; ?>">
                 </div>
               </div>

               <div class="col-md-6">
                 <div class="form-group">
                     <label for="full_unit_size">Full Unit Size</label>
                     <input type="text" name="full_unit_size" class="form-control" id="full_unit_size" placeholder="Full Unit Size" required value="<?php echo $building->full_unit_size; ?>">
                 </div>
               </div>

               <div class="col-md-6">
                 <div class="form-group">
                     <label for="rent">Rent</label>
                     <input type="text" name="rent" class="form-control" id="rent" placeholder="Rent" readonly required  value="<?php echo $building->rent; ?>">
                 </div>
               </div>

              <div class="col-md-6">
                 <div class="form-group">
                     <label for="bed">Bed</label>
                     <input type="text" name="bed" class="form-control" id="bed" placeholder="Bed" required value="<?php echo $building->bed; ?>">
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="toilet">Toilet</label>
                     <input type="text" name="toilet" class="form-control" id="toilet" placeholder="Toilet" required value="<?php echo $building->toilet; ?>">
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="living_room">Living Room</label>
                     <input type="text" name="living_room" class="form-control" id="living_room" placeholder="Living Room" required value="<?php echo $building->living_room; ?>">
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="dining">Dining</label>
                     <input type="text" name="dining" class="form-control" id="dining" placeholder="Dining" required value="<?php echo $building->dining; ?>">
                 </div>
               </div>

               <div class="col-md-6">
                 <div class="form-group">
                     <label for="belcony">Belcony</label>
                     <input type="text" name="belcony" class="form-control" id="belcony" placeholder="Belcony" required value="<?php echo $building->belcony; ?>">
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="basement_parking">Basement/Parking</label>
                     <input type="text" name="basement_parking" class="form-control" id="basement_parking" placeholder="Basement/Parking" required value="<?php echo $building->basement_parking; ?>">
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="generator">Generator</label>
                     <input type="text" name="generator" class="form-control" id="generator" placeholder="Generator" required value="<?php echo $building->generator; ?>">
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="elevator">Elevator</label>
                     <input type="text" name="elevator" class="form-control" id="elevator" placeholder="Elevator" required value="<?php echo $building->elevator; ?>">
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="electric_bill">Electric Bill</label>
                     <select class="form-control" name="electric_bill" id="electric_bill" required>
                     <option value="" selected disabled>Select</option>
                        <option value="prepaid" <?php if($building->electric_bill == 'prepaid'){echo "selected";} ?>>Pre-paid</option>
                        <option value="postpaid" <?php if($building->electric_bill == 'postpaid'){echo "selected";} ?>>Post-Paid</option>
                     </select>
                 </div>
               </div>

               <div class="col-md-6">
                 <div class="form-group">
                     <label for="water_bill">Water Bill</label>
                     <select class="form-control" name="water_bill" id="water_bill" required>
                       <option value="" selected disabled>Select</option>
                        <option value="prepaid" <?php if($building->water_bill == 'prepaid'){echo "selected";} ?>>Pre-paid</option>
                        <option value="postpaid" <?php if($building->water_bill == 'postpaid'){echo "selected";} ?>>Post-Paid</option>
                     </select>
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="gas_bill">Gas Bill</label>
                     <select name="gas_bill" class="form-control" id="gas_bill" required> 
                         <option value="" selected disabled>Select</option>
                        <option value="prepaid" <?php if($building->gas_bill == 'prepaid'){echo "selected";} ?>>Pre-paid</option>
                        <option value="postpaid" <?php if($building->gas_bill == 'postpaid'){echo "selected";} ?>>Post-Paid</option>
                     </select>
                 </div>
               </div>

               <div class="col-md-6">
                 <div class="form-group">
                     <label for="service_charge">Service Charge</label>
                     <input type="text" name="service_charge" class="form-control" id="service_charge" placeholder="Service Charge" required value="<?php echo $building->service_charge; ?>">
                 </div>
               </div>


               <div class="col-md-6">
                 <div class="form-group">
                     <label for="have_furniture">Have Furniture?</label>
                     <input type="text" name="have_furniture" class="form-control" id="have_furniture" placeholder="Have Furniture?" required value="<?php echo $building->have_furniture; ?>">
                 </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_person">Contact Person</label>
                    <input type="text" name="contact_person" class="form-control" id="contact_person" placeholder="Contact Person" required value="<?php echo $building->contact_person; ?>">
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_no">Contact No</label>
                    <input type="text" name="contact_no" class="form-control" id="contact_no" placeholder="Contact No" value="<?php echo $building->contact_no; ?>">
                  </div>
               </div>

               <div class="col-md-6">
                  <div class="form-group"> 
                    <label for="found_by">Found By</label>
                    <input type="text" name="found_by" class="form-control" id="found_by" placeholder="Found By" value="<?php echo $building->found_by; ?>" required>
                  </div>
               </div>

               <div class="col-md-12">
                  <div class="form-group">
                    <label for="location_code">Location Code</label>
                    <input type="text" name="location_code" class="form-control" id="location_code" placeholder="Location Code" value="<?php echo $building->location_code; ?>" required>
                  </div>
               </div>

               <div class="col-md-12">
                 <div class="form-group">
                     <label for="google_map">Google Map Link</label>
                     <input type="text" name="google_map" class="form-control" id="google_map" placeholder="Google Map Link" required value="<?php echo $building->google_map; ?>">
                 </div>
               </div>

               <div class="col-md-12">
                 <div class="form-group">
                    <label for="file">Building Gallery Images</label>
                    <input type='file' name='files[]' multiple="" id="file">
                 </div>
               </div>  


               <div class="col-md-12">
                <?php
                    $images = $this->Dashboard_model->mysqlii("SELECT * FROM building_images WHERE random_id={$building->building_rand_id}");
                  foreach($images as $image):
                ?>
                
                 <img style="width: 100px; height: 100px; margin-left: 5px;" src="<?=base_url('/'.'building_images/'.$image->image); ?>">
                <a style="cursor: pointer; color: white;" class="btn btn-danger btn-sm image_data" data-id="<?php echo $image->id ?>">X</a>
                <?php endforeach; ?>
               </div>

                
               <div class="col-md-12" style="margin-top: 20px;">
                 <div class="form-group">
                    <label for="front_image">Front Image</label>
                    <input type='file' name='front_image'  id="front_image">
                 </div>
               </div> 

               <div class="col-md-12">
                  
                 <img style="width: 100px; height: 100px; margin-left: 5px;" src="<?=base_url('/'.$building->front_image); ?>">
               </div>


               <div class="col-md-12" style="margin-top: 20px;">
                 <div class="form-group">
                    <label for="map_image">Map Image</label>
                    <input type='file' name='map_image'  id="map_image">
                 </div>
               </div> 

               <div class="col-md-12">
                  
                 <img style="width: 100px; height: 100px; margin-left: 5px;" src="<?=base_url('/'.$building->map_image); ?>">
               </div>

               <div class="col-md-12" style="margin-top: 10px;">
                  <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Update">
                  </div>
               </div>
               </div>
            
            
            
            
            </div>
               
              </form>
                 </div>
              </div>
             
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
      $(document).on('change', '#building_type', function(){
          var data = $('#building_type').val();
          if(data == 'old')
          {
              $(".type_age").css('display', 'inline-block');
          }
          else
          {
            $(".type_age").css('display', 'none');
          }
      });

      // $(document).on("input", "#paid", function(){
      //     var paid = parseInt($("#paid").val());
      //     if($("#paid").val() == ""){
      //         $("#due").val("");
      //     }else{
      //       var total = parseInt($(".total").html());
      //       var result = total - paid;
      //       $("#due").val(result);
      //     }
          
      //   });
      
      $(document).on('input', '#full_unit_size', function(){
           var rent_per_sqft = $("#rent_per_sqft").val();
           var full_unit_size = $('#full_unit_size').val();
           if(rent_per_sqft == '')
           {
             alert('please enter rent per square first');
           }
           else
           {   
              if(full_unit_size == '')
              {
                $("#rent").val(rent_per_sqft);
              }
              else
              {
                var rent = parseInt($("#rent_per_sqft").val());
                var unit = parseInt($("#full_unit_size").val());
                var result = rent*unit;
                $("#rent").val(result);
              }
              
           }
      });

      $(document).on('input', '#rent_per_sqft', function(){
          var rent_per_sqft = $("#rent_per_sqft").val();
          if(rent_per_sqft == '')
          {
            $("#rent").val('0');
          }
      });

      $(document).on('click', '.image_data', function(e){
          e.preventDefault();
          var id = $(this).data('id');
          e.preventDefault();
          var id = $(this).data('id');
          if(confirm('Are you want to delete this?'))
          {
                    $.ajax({
                        url: "<?=base_url('admin/delete_building_image/'); ?>"+id,

                    type:"GET",
                    //data:{'id':id},
                    dataType:"html",
                    success:function(data) {
                      window.location.reload();
                    },
                            
                });

          }
      });
  });
</script>