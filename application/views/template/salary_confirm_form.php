<!Doctype html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Salary Confirm Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>
  <body>
      <?php
        $get_data = $this->Dashboard_model->mysqlij("SELECT * FROM generate_forms ORDER BY id DESC LIMIT 1");
        $month_name = date('F', mktime(0, 0, 0, $get_data->month, 10)); 
      ?>
    <div class="container">
    <form role="form" action="<?=base_url('api/salary_confirm_emp'); ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <div class="form-group">
          <label for="employee_id">Write Your Employee ID</label>
          <input type="number" name="employee_id" class="form-control employee_id" id="employee_id" placeholder="Write Your Employee ID" required> 
      </div>

      <div>
        <img style="width: 80px; height: 60px; display:none;" class="img_dis" src="">
       </div>

      <div class="form-group">
          <label for="otp">Write Your Otp</label>
          <input type="number" name="otp" class="form-control otp" id="otp" placeholder="Write Your Otp" required> 
      </div>
      
      <div class="form-group">
          <label for="month">Month</label>
          <input type="text" name="month" class="form-control" id="month" placeholder="month" value="<?php echo $month_name;  ?>" readonly required>  
      </div>

      <div class="form-group">
          <label for="year">Year</label>
          <input type="number" name="year" class="form-control" id="year" placeholder="Year" value="<?php echo $get_data->year; ?>" readonly required>  
      </div>
      
      <div class="form-group">
         <button type="submit" class="btn btn-success" id="sub" style="display:none;">Submit</button>
      </div>
    </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
          $(document).on('input', '#employee_id', function(){
              var employee_id = $(this).val();
              if(employee_id == '')
              {
                $('.img_dis').css('display', 'none');
                $("#sub").css('display', 'none');
              }
              else
              {
                $.ajax({
                url: "<?=base_url('api/get_emp_image'); ?>", 

                    type:"GET",
                    data:{'employee_id':employee_id},
                    dataType:"html",
                    success:function(data) {
                       //alert(data);
                       if(data == 'wrong')
                       {
                          $("#sub").css('display', 'none');
                       }
                       else
                       {
                         $('.img_dis').css('display', 'inline-block');
                         $('.img_dis').attr('src',data);
                         $("#sub").css('display', 'inline-block');
                       }
                       
                    },
                                    
                });
              }
              
          });
      });
    </script>
  </body>
</html>