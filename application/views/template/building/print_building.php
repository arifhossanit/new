<style>
  .title{
      color: red;
  }
  
</style>
<!Doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row justify-content-center">
              <div class="col-md-12 conts">
                  <div class="row">
                    <div class="col-sm-12" style="padding: 50px;">
                        <center><h1><?php echo $building->area; ?></h1></center>
                        
                        <div style="padding: 30px;">
                           <div class="row">
                             <div class="col-md-12">
                                <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered" style="width: 100%;">
                                        <tr>
                                            <td style="text-align: center;font-weight:600;font-size:14pt;" colspan="2">
                                                Details
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:30px;">Owner Name</td>
                                            <td><?php echo $building->owner_name; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:30px;">Owner Phone</td>
                                            <td><?php echo $building->owner_phone; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Building Type</td>
                                            <td><?php echo $building->building_type; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Floor</td>
                                            <td><?php echo $building->bulding_floor; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Unit</td>
                                            <td><?php echo $building->full_unit_size; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;"">Bed</td>
                                            <td><?php echo $building->bed; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Toilet</td>
                                            <td><?php echo $building->toilet; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Living Room</td>
                                            <td><?php echo $building->living_room; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Dining</td>
                                            <td><?php echo $building->dining; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Belcony</td>
                                            <td><?php echo $building->belcony; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Parking</td>
                                            <td><?php echo $building->basement_parking; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Generator</td>
                                            <td><?php echo $building->generator; ?></td>
                                        </tr>
                                    </table>
                                  </div>

                                  <div class="col-md-6">
                                  <table class="table table-bordered" style="width: 100%;">
                                        <tr>
                                            <td style="text-align: center;font-weight:600;font-size:14pt;" colspan="2">
                                                Details
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:30px;">Elevator</td>
                                            <td><?php echo $building->elevator; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width:30px;">Electric Bill</td>
                                            <td><?php echo $building->electric_bill; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Water Bill</td>
                                            <td><?php echo $building->water_bill; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Gas Bill</td>
                                            <td><?php echo $building->gas_bill; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Service Charge</td>
                                            <td><?php echo $building->service_charge; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;"">Height</td>
                                            <td><?php echo $building->height; ?></td>
                                        </tr>


                                        <tr>
                                            <td style="width:30px;">Room Per Unit</td>
                                            <td><?php echo $building->room_per_unit; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Found By</td>
                                            <td><?php echo $building->found_by; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Contact Person</td>
                                            <td><?php echo $building->contact_person; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Contact No</td>
                                            <td><?php echo $building->contact_no; ?></td>
                                        </tr>

                                        <tr>
                                            <td style="width:30px;">Substation</td>
                                            <td><?php echo $building->substation; ?></td>
                                        </tr>


                                    </table>
                                  </div>
                                </div>
                               
                             </div>

                             
                           </div>
                            
                            
                       
                     </div>
                    </div>

                    <div style="margin-top: 40px;" class="col-sm-12">
                      <div class="row">
                          <div class="col-sm-6">
                          <img style="height: 500px;" class="d-block w-100" src="<?=base_url('/'.$building->front_image); ?>" alt="First slide">
                          </div>
                          <div class="col-sm-6">
                          <img style="height: 500px;" class="d-block w-100" src="<?=base_url('/'.$building->map_image); ?>" alt="First slide">
                          </div>
                      </div>
                        
                        
                    </div>

                  </div>
              </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>

            
        $(document).ready(function(){
          
            $("body").css("background", "white");
            //$(".conts").css("display", "none");
        });
        </script>
        <script>
            myFunction();
            window.onafterprint = function(e){
                window.close()
            };
            function myFunction(){
                setTimeout(function(){
                    $(".conts").css("display", "block");
                    //$('#loader').css('display', 'none');
                    window.print();
                    
                }, 1000);

                
                
            }
            function closePrintView()
            {
                //window.location.href="all-product_super_show"; 
                window.close()
                
            }
          
            
        </script>
    </body>
</html>