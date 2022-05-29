<style>
    /* .img-size{
        width: 700px;
        background-size: cover;
        overflow: hidden;
    } */
    /* .modal-content {
        width: 700px;
        border:none;
    } */
    .modal {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .img-size{
        width: 100%;
        background-size: cover;
        overflow: hidden;
    }
    .modal-body {
        padding: 0;
    }
    .card-header{
        height: auto;
    }

    
    .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
        width: 30px;
        height: 48px;
    }
    .carousel-control-next-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23009be1' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
        width: 30px;
        height: 48px;
    }    
</style>

<head>
<link rel="stylesheet" href="assets/css/package_plan_custom.css">
</head>
<!-- show pacakge pics -->
<div class="modal fade modal-lg" id="pkg_bed_pic" role="dialog" tabindex="-1" role="dialog" aria-labelledby="packagePics" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="float: left;" class="modal-title">Bed Images</h4>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                 <!-- carousel -->
          <div
               id='carouselExampleIndicators'
               class='carousel slide'
               data-ride='carousel'
               >
            <ol class='carousel-indicators'>
              <li
                  data-target='#carouselExampleIndicators'
                  data-slide-to='0'
                  class='active'
                  ></li>
              <li
                  data-target='#carouselExampleIndicators'
                  data-slide-to='1'
                  ></li>
              <li
                  data-target='#carouselExampleIndicators'
                  data-slide-to='2'
                  ></li>
            </ol>
            <div class='carousel-inner' id="carousel-inner">
              
            </div>
            <a
               class='carousel-control-prev'
               href='#carouselExampleIndicators'
               role='button'
               data-slide='prev'
               >
              <span class='carousel-control-prev-icon'
                    aria-hidden='true'
                    ></span>
              <span class='sr-only'>Previous</span>
            </a>
            <a
               class='carousel-control-next'
               href='#carouselExampleIndicators'
               role='button'
               data-slide='next'
               >
              <span
                    class='carousel-control-next-icon'
                    aria-hidden='true'
                    ></span>
              <span class='sr-only'>Next</span>
            </a>
          </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>

    </div>
</div>

<div class="content-wrapper">	
	<div class="container pt-5">
        <form action="pre-book-and-pre-booking-form" method="post">
            <input type="hidden" name="from_pkg_pln">
            <div class="card text-center">
                <div class="card-header text-wrap">
                    <h3>Super Home Package Details <span style="float: right;"><a href="<?= base_url()?>pre-book-and-pre-booking-form"><button type="button" class="btn btn-warning btn-sm" style="color: black">Skip</button></a></span></h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" id="branchName">
                                <div class="col-md-3">
                                    <label style="float: left;" for="exampleInputEmail1"><h4>Branches</h4></label>
                                    <div id="selected_dropdown_toggle" style="float: right; display: none;"><i class="fa fa-bars" aria-hidden="true"></i></div>                                      
                                </div>
                                <div id="selected_dropdown" style="display: none;" class="col-md-9">
                                </div>
                                <div class="col-md-9" id="hide_dropdown">
                                    <?php
                                    if(!empty($branches)){
                                        foreach($branches as $branch){
                                            ?>
                                            <button type="button" id="branch_btn" class="button branch" value="<?php echo $branch->branch_id; ?>"><?php echo $branch->branch_name; ?><br>
                                                <small><?php
                                                    $branchLocal = '';
                                                    if(strtolower($branch->branch_name) === 'super home 4'){
                                                        $branchLocal = $branch->branch_location.' (Female)';
                                                    }else{
                                                        $branchLocal = $branch->branch_location.' (Male)';
                                                    }
                                                    echo $branchLocal;
                                                    ?></small></button>
                                        <?php } }?>
                                </div>
                            </div>
                            <div class="row" id="package">

                            </div>
                            <div class="row" id="packageName">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group" id="packageDetails">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?=base_url('assets/js/package_plan.js');?>"></script>

<script>

// $('document').ready(function(){
// 	$("#package_plan").on("submit",function(){
//         event.preventDefault();
//         var form = $('#booking_form')[0];
//         var data = new FormData(form);
//         $.ajax({
//             type: 'post',

//         })
//     })
// })
</script>