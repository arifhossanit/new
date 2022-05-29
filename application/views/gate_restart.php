<?php header('HTTP/1.0 404 Not Found'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Super Home | Restart Gate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="http://localhost/super_home/assets/img/favicon.png" type="image/gif" sizes="16x16">
  <link rel="stylesheet" href="<?=base_url('assets/');?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=base_url('assets/');?>dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <div class="content-wrapper" style="margin-left:0px;padding-top:225px;">
    <section class="content">
		<center>
			<img src="<?=base_url('assets/img/logo.png');?>" style="width:300px;opacity: 0.5;"/>
		</center>		
      <div class="error-page">		
        <!-- <h2 class="headline text-warning"> 404</h2> -->
        <div class="error-content">
            <?php if($status == 'false'){ ?>
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Gate did not restart properly.</h3>
                <p>
                    Click link to open gate again. <a href="<?=base_url('restrat_gate');?>">Open gate again.</a>
                </p>
            <?php }else{ ?>
                <h3><i class="far fa-check-circle text-success"></i> Gate Opened Successfully.</h3>
                <p>Click link to open gate again. <a href="<?=base_url('restrat_gate');?>">Open gate again.</a></p>
                
                <p>
                    You may <a href="<?=base_url('admin');?>">return to dashboard</a>.
                </p>
            <?php } ?>

          <!-- <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-append">
                <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </form> -->
        </div>
      </div>
    </section>
  </div>
 
</div>

<script src="<?=base_url('assets/');?>plugins/jquery/jquery.min.js"></script>
<script src="<?=base_url('assets/');?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?=base_url('assets/');?>dist/js/adminlte.min.js"></script>
<script src="<?=base_url('assets/');?>dist/js/demo.js"></script>
</body>
</html>
