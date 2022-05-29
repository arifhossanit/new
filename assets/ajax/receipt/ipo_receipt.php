<?php 
// error_reporting(0);
include("../../../application/config/ajax_config.php");
if(isset($_POST['ipo_id'])){
// $rowir = mysqli_fetch_assoc($mysqli->query("select * from booking_info where id = '".$_POST['book_id']."'"));
$row = $mysqli->query("select * from ipo_agreement_information where purses_code = '".$_POST['purchase_code']."'");
$aggrements = array();
while($aggrement = mysqli_fetch_assoc($row)){
    array_push($aggrements, $aggrement);
}
// $rent = mysqli_fetch_assoc($mysqli->query("select * from rent_info where booking_id = '".$row['booking_id']."' order by id ASC"));
$opt = explode("___",$aggrements[0]['uploader_info']);
$rentre = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$opt[1]."'"));
$member = mysqli_fetch_assoc($mysqli->query("select * from ipo_member_directory where ipo_id = '".$_POST['ipo_id']."'"));
include('../../../application/helpers/qrcode_helper.php');
$daaata = $home.'ipo-member-information/qr-code/'.$_POST['ipo_id'].'/'.$_POST['purchase_code'];
$file = '../../uploads/qrcode/ipo_member_information_'.$_POST['purchase_code'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2);
$branch_info = mysqli_fetch_assoc($mysqli->query("select * from branches where branch_id = '".$aggrements[0]['branch_id']."'"));
// $package = mysqli_fetch_assoc($mysqli->query("select * from packages where id = '".$row['package']."'"));
$subtotal = 0;
$purchase = mysqli_fetch_assoc($mysqli->query("select * from ipo_purses_information where purses_code = '".$_POST['purchase_code']."'"));
$p_sql_m = mysqli_fetch_assoc($mysqli->query("select * from ipo_payment_received_method where transaction_id = '".$purchase['data_two']."'"));
?>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta http-equiv="content-type" content="text-html; charset=utf-8">
<style>
	.col-print-1 {width:8%;  float:left;}
    .col-print-2 {width:16%; float:left;}
    .col-print-3 {width:25%; float:left;}
    .col-print-4 {width:33%; float:left;}
    .col-print-5 {width:42%; float:left;}
    .col-print-6 {width:50%; float:left;}
    .col-print-7 {width:58%; float:left;}
    .col-print-8 {width:66%; float:left;}
    .col-print-9 {width:75%; float:left;}
    .col-print-10{width:83%; float:left;}
    .col-print-11{width:92%; float:left;}
    .col-print-12{width:100%; float:left;}	
</style>
<div class="card bg-light">
	<div class="card-body">
        <div class="col-sm-12" style="margin-bottom:30px;">
            <button type="button" id="print_button_new" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
        </div>
        <div style="width:100%;margin-top:30px;float:left;"></div>
        <section id="print_area_new">
            <header class="clearfix" style="margin-bottom:30px;">
                <div class="container">
                    <figure>
                        <img class="logo" src="<?php echo $home; ?>assets/img/n_logo.png" alt="" style="width:90px;">
                    </figure>
                    <div class="company-address">
                        <h1 class="title" style="color:green;">SUPER HOME</h1>
                        <p style="font-size:18px;"> Investor </p>
                    </div>
                    <div class="company-contact" style="height:80px;">
                        <div class="phone left">
                            <span class="circle-new"><div style="height: 100%;" class="row align-items-center"> <div class="col-sm"><i class="fas fa-phone" style="color: black"></i></div></div></span>
                            <a href="tel:602-519-0450" style="text-decoration: none;font-size:20px;color:white;">(+880) 96386-66333</a>
                            <span class="helper"></span>
                        </div>
                        <div class="email right">
                            <span class="circle-new"><div style="height: 100%;" class="row align-items-center"> <div class="col-sm"><i class="far fa-envelope" style="color: black"></i></div></div></span>
                            <a href="mailto:info@superhomebd.com" style="text-decoration: none;font-size:20px;color:white;">info@superhomebd.com</a>
                            <span class="helper"></span>
                            <span style="width:80px;height:80px;margin-left:10px;">
                                <img src="<?php echo $home.'assets/uploads/qrcode/ipo_member_information_'.$_POST['purchase_code'].'.png'; ?>" style="width:81px;float:right;border: 1px #eee solid;" class="image-responsive"/>
                            </span>
                        </div>				
                    </div>
                    <div style="width:100%;float:left;margin-top:20px;">
                        <center>
                            <h1 style="font-size:3em;font-weight:600;"><u>Invoice</u></h1>
                        </center>
                    </div>
                </div>
            </header>
            
            <section>							
                <div class="container">
                    <div class="details clearfix">
                        <div class="client left" style="font-size:20px;line-height:30px;">
                            <p>INVOICE BY:</p>
                            <p class="name" style="color:green;font-weight:bolder;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php if(!empty($rentre['full_name'])){ echo $rentre['full_name'].' ('.$rentre['employee_id'].')'; }else{ echo 'Not Provided!';} ?></p>
                            <!--<a href="mailto:<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($rentre['email'])){ echo $rentre['email']; }else{ echo 'Not provided!'; } ?></a><br />-->
                            <!--<a href="callto:<?php echo $member['phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php if(!empty($rentre['personal_Phone'])){ echo $rentre['personal_Phone']; }else{ echo 'Not provided!'; }  ?></a>-->
                            <div style="width:100%;margin-top:10px;"></div>
                            <hr />					
                            <p>INVOICE TO:</p>
                            <p class="name" style="color:green;font-weight:bolder;margin: 0px;"><i class="far fa-user"></i> &nbsp;&nbsp;<?php echo $member['personal_full_name']; ?></p>
                            <p style="margin: 0px;"><i class="fas fa-map-marker-alt"></i> &nbsp;&nbsp;<?php echo $member['personal_address']; ?></p>
                            <a href="mailto:<?php if(!empty($member['personal_email'])){ echo $member['personal_email']; }else{ echo 'No email provided!'; } ?>" style="text-decoration: none;"><i class="far fa-envelope-open"></i> &nbsp;&nbsp;<?php if(!empty($member['personal_email'])){ echo $member['personal_email']; }else{ echo 'Not provided!'; } ?></a><br />
                            <a href="callto:<?php echo $member['personal_phone_number']; ?>" style="text-decoration: none;"><i class="fas fa-mobile-alt"></i> &nbsp;&nbsp;<?php echo $member['personal_phone_number']; ?></a>
                            <!-- <p style="margin: 0px;"><i class="fas fa-bed"></i> &nbsp;&nbsp; <strong style="font-weight:bolder;"><?php echo $member['bed_name']; ?></strong></p> -->
                        </div>
                        <div class="data right">
                            <?php
                                // $inv = explode('/',$row['data']);
                                // $invd = $inv[0].$inv[1].$inv[2];
                                // $id = mysqli_fetch_assoc($mysqli->query("select * from transaction where booking_id = '".$row['booking_id']."' and data = '".$row['data']."' and note = 'Booking Money Collection'"));
                            ?>
                            <div class="title" style="color:#000;font-size:35px;"><?php echo $p_sql_m['transaction_id']; ?> </div>
                            <div class="date" style="font-weight:bolder;line-height: 30px;">
                                <style>.right_cs_t tr{background-color:none;} .right_cs_t td{font-size:20px;color:#000;background:none;border:none;padding:2px;}</style>
                                <table class="table table-sm right_cs_t" style="width:80%;float:right;" border="0" border-spacing="0">
                                    <tr>
                                        <td>Date of Invoice</td>
                                        <td>:</td>
                                        <td><strong style="font-weight:bolder;"><?php /*echo $row['data'];*/ echo $aggrements[0]['data']; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Agreement End Date</td>
                                        <td>:</td>
                                        <?php 
                                            $expiry_date = DateTime::createFromFormat('d/m/Y', $aggrements[0]['expirity_date']);
                                            $expiry_date->sub(new DateInterval('P1D'));
                                        ?>
                                        <td><strong style="font-weight:bolder;"><?php echo $expiry_date->format('d/m/Y'); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Card Number</td>
                                        <td>:</td>
                                        <td><strong style="font-weight:bolder;"><?php echo $member['card_number']; ?></strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <table class="sub-total" border="0" cellspacing="0" cellpadding="0" style="font-size:20px;">
                        <thead>
                            <tr>
                                <div>
                                <th style="color:white;" class="desc">#</th>
                                <th style="color:white;font-weight:600" class="qty">Type</th>
                                <th style="color:white;font-weight:600" class="unit">Unit price</th>
                                <th style="color:white;font-weight:600" class="unit">Quantity</th>
                                <th style="color:white;font-weight:600" class="total">Total</th>
                                </div>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($aggrements as $aggrement){ ?>
                                <tr>
                                    <td class="desc"><h3 style="color:#000;"> Principle Amount </h3></td>
                                    <td class="qty"> <h3 style="color:#000;"><?php echo $aggrement['bet_type']; ?></h3> </td>
                                    <td class="unit" style="color:#000;"><?php echo money($aggrement['unit_price']); // $sd_m = $row['security_deposit']; ?></td>
                                    <td class="unit" style="color:#000;"><?php echo $aggrement['quantity']; // $sd_m = $row['security_deposit']; ?></td>
                                    <td class="unit" style="color:#000;">
                                        <?php 
                                            $total = $aggrement['quantity'] * $aggrement['unit_price'];
                                            echo money($total); // $sd_m = $row['security_deposit']; 
                                            $subtotal += $total
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="no-break">
                        <table class="grand-total" style="border-collapse: collapse; border-spacing: 0;font-size:20px;">
                            <tbody>
                                <tr>
                                    <td class="desc" style="color:#000;font-size:20px;font-weight:500;text-align:left;">
                                        <?php /* ?>Payment Method: <strong style="font-weight:bolder;"><?php echo rtrim($row['payment_method'],','); ?></strong><?php */ ?>
                                    </td>
                                    <td class="qty"></td>
                                    <td class="unit" style="font-size:18px;color:#000;"></td>
                                    <td class="unit" style="font-size:18px;color:#000;">GRAND TOTAL:</td> <!-- colspan="2"-->
                                    <td class="total" style="font-size:18px;color:#000;"><?php echo money($subtotal); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="width:100%;float:left;color: #000; font-size: 35px; font-weight: 500;">
                            <div style="float:left;width:45%;">
                                <?php
                                    if(!empty($p_sql_m)){
                                ?>
                                Payment Method: <br />
                                <ul>
                                    <?php
                                        $p_sql = $mysqli->query("select * from ipo_payment_received_method where transaction_id = '".$purchase['data_two']."'");
                                        while($pmw = mysqli_fetch_assoc($p_sql)){
                                            if($pmw['payment_method'] == 'Cash'){
                                                $amount = $pmw['cash_amount'];
                                            } else if($pmw['payment_method'] == 'Mobile Banking'){
                                                $amount = $pmw['mobile_amount'];
                                            } else if($pmw['payment_method'] == 'Credit / Debit Card'){
                                                $amount = $pmw['card_amount'];
                                            } else if($pmw['payment_method'] == 'Check'){
                                                $amount = $pmw['check_amount'];
                                            }
                                            echo '<li>'.$pmw['payment_method'].' - <b>'.money($amount).'</b></li>';
                                        }
                                    ?>
                                </ul>
                                <?php } ?>
                            </div>
                            <div style="float:left;width:100%;">
                                
                            </div>					
                        </div>
                    </div>
                </div>
            </section>

            <footer>
                <div class="container">
                    <div class="thanks">
                        Thank you!
                        
                    </div>
                    <div class="notice">
                        
                    </div>
                    <div class="end-new">
                        <div> <!-- redundent div for printing -->
                            <div>
                                <div class="row text-center">
                                    <div class="col-sm invoice-disclaimer-border">
                                        <p>Invoice was created on a computer and is valid without the signature and seal.</p>
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                        <div class="footer-div">
                            <div class="row justify-content-between">
                                <div class="col-print-1" style="margin-top: 10px;">
                                    <div>
                                        <div class="booking-form-tag ">
                                            <img src="<?php echo $home.'assets/uploads/qrcode/ipo_member_information_'.$_POST['purchase_code'].'.png'; ?>" style="width:81px;float:right;border: 1px #eee solid;" class="image-responsive"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-print-3">
                                    <div style="color: #000; font-size: 25px; font-weight: 500;">
                                    <div style="color: #000; font-size: 25px; font-weight: 500;">
                                            <?php
                                                if(!empty($p_sql_m)){
                                            ?>
                                            <ul style="list-style:none;">
                                                <?php
                                                    $p_sql = $mysqli->query("select * from ipo_payment_received_method where transaction_id = '".$purchase['data_two']."'");
                                                    while($pmw = mysqli_fetch_assoc($p_sql)){
														if($pmw['payment_method'] == 'Cash'){
															$amount = '<i class="far fa-money-bill-alt"></i> - <b style="font-size:30px;color:#f00;">'.money($pmw['cash_amount']).'</b>';
														} else if($pmw['payment_method'] == 'Mobile Banking'){
															$amount = '<i class="fas fa-mobile-alt"></i> - <b style="font-size:30px;">'.money($pmw['mobile_amount']).'</b>';
														} else if($pmw['payment_method'] == 'Credit / Debit Card'){
															$amount = '<i class="far fa-credit-card"></i> - <b style="font-size:30px;">'.money($pmw['card_amount']).'</b>';
														} else if($pmw['payment_method'] == 'Check'){
															$amount = '<i class="fas fa-money-check-alt"></i> - <b style="font-size:30px;">'.money($pmw['check_amount']).'</b>';
														}
														echo '<li>'.$amount.'</li>';
													}
                                                ?>
                                            </ul>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-print-7">
                                    <div class="title" style="color:#000;font-size: 45px;font-weight: 600;"><?php echo $p_sql_m['transaction_id']; ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <style type="text/css">
                #print_area_new table {
                    border-collapse: collapse; border-spacing: 0;
                }

                #print_area_new caption, th, td {
                    text-align: left;
                    font-weight: normal;
                    vertical-align: middle;
                }

                #print_area_new q, blockquote {
                    quotes: none;
                }
                #print_area_new q:before, q:after, blockquote:before, blockquote:after {
                    content: "";
                    content: none;
                }

                #print_area_new a img {
                    border: none;
                }

                #print_area_new article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
                    display: block;
                }
            /*
                body {
                    font-family: 'Source Sans Pro', sans-serif;
                    font-weight: 300;
                    font-size: 12px;
                    margin: 0;
                    padding: 0;
                }
                body a {
                    text-decoration: none;
                    color: inherit;
                }
                body a:hover {
                    color: inherit;
                    opacity: 0.7;
                }
                body .container {
                    min-width: 500px;
                    margin: 0 auto;
                    padding: 0 20px;
                } */
                body .clearfix:after {
                    content: "";
                    display: table;
                    clear: both;
                }
                body .left {
                    float: left;
                }
                body .right {
                    float: right;
                }
                body .helper {
                    display: inline-block;
                    height: 100%;
                    vertical-align: middle;
                }
                body .no-break {
                    page-break-inside: avoid;
                }

                #print_area_new header {
                    margin-top: 20px;
                    margin-bottom: 50px;
                }
                #print_area_new header figure {
                    float: left;
                    text-align: center;
                    margin:0px;
                    margin-right: 10px;
                }

                #print_area_new header .company-address {
                    float: left;
                    max-width: 150px;
                    line-height: 1.7em;
                    font-weight:bolder;
                }
                #print_area_new header .company-address .title {
                    color: #6c757d;
                    font-weight: bolder;
                    font-size: 25px;
                    margin-top:0px;
                    text-transform: uppercase;
                }
                #print_area_new header .company-contact {
                    float: right;
                    height: 60px;
                    padding: 0 10px;
                    background-color: #6c757d;
                    color: white;
                    padding-right:0px;
                    font-weight:bolder;
                }
                #print_area_new header .company-contact span {
                    display: inline-block;
                    vertical-align: middle;
                }
                #print_area_new .circle-new {
                    width: 30px;
                    height: 30px;
                    background-color: white;
                    border-radius: 50%;
                    text-align: center;
                    margin-right:10px;
                }
                #print_area_new header .company-contact .circle {
                    width: 30px;
                    height: 30px;
                    background-color: white;
                    border-radius: 50%;
                    text-align: center;
                    margin-right:10px;
                }
                #print_area_new header .company-contact .circle img {
                    vertical-align: middle;
                }
                #print_area_new header .company-contact .phone {
                    height: 100%;
                    margin-right: 20px;
                }
                #print_area_new header .company-contact .email {
                    height: 100%;
                    min-width: 100px;
                    text-align: right;
                }

                #print_area_new section .details {
                    margin-bottom: 10px;
                }
                #print_area_new section .details .client {
                    width: 50%;
                    line-height: 20px;
                    font-weight:bolder;
                }
                #print_area_new section .details .client .name {
                    color: #6c757d;
                }
                #print_area_new section .details .data {
                    width: 50%;
                    text-align: right;
                }
                #print_area_new section .details .title {
                    margin-bottom: 15px;
                    color: #6c757d;
                    font-size: 20px;
                    font-weight: 900;
                    text-transform: uppercase;
                }
                #print_area_new section table {
                    width: 100%;
                    border-collapse: collapse;
                    border-spacing: 0;
                    font-size: 0.9166em;
                }
                #print_area_new section table .qty, section table .unit, section table .total {
                    width: 20%;
                }
                #print_area_new section table .desc {
                    width: 25%;
                }
                #print_area_new section table thead {
                    display: table-header-group;
                    vertical-align: middle;
                    border-color: inherit;
                }
                #print_area_new section table thead th {
                    padding: 5px 10px;
                    background: #6c757d;
                    border-bottom: 5px solid #FFFFFF;
                    border-right: 4px solid #FFFFFF;
                    text-align: right;
                    color: white;
                    font-weight: 400;
                    text-transform: uppercase;
                }
                #print_area_new section table thead th:last-child {
                    border-right: none;
                }
                #print_area_new section table thead .desc {
                    text-align: left;
                }
                #print_area_new section table thead .qty {
                    text-align: center;
                }		
                
                #print_area_new section .sub-total tbody td {
                    padding: 5px;
                    background: rgba(108, 117, 125, 0.5);
                    color: #777777;
                    text-align: right;
                    border-bottom: 5px solid #FFFFFF;
                    border-right: 4px solid rgba(108, 117, 125, 0.5);
                }
                
                #print_area_new section .grand-total tbody td {
                    padding: 5px;
                    background: rgba(108, 117, 125, 0.5);
                    color: #777777;
                    text-align: right;
                    border-bottom: 5px solid #FFFFFF;
                    border-right: 4px solid rgba(108, 117, 125, 0.5);
                }
                #print_area_new section table tbody td:last-child {
                    border-right: none;
                }
                #print_area_new section table tbody h3 {
                    margin-bottom: 5px;
                    color: #6c757d;
                    font-weight: 600;
                }
                #print_area_new section table tbody .desc {
                    text-align: left;
                }
                #print_area_new section table tbody .qty {
                    text-align: center;
                }
                #print_area_new section table.grand-total {
                    margin-bottom: 45px;
                }
                #print_area_new section table.grand-total td {
                    padding: 5px 10px;
                    border: none;
                    color: #777777;
                    text-align: right;
                }
                #print_area_new section table.grand-total .desc {
                    background-color: transparent;
                }
                #print_area_new section table.grand-total tr:last-child td {
                    font-weight: 600;
                    color: #6c757d;
                    font-size: 1.18181818181818em;
                }
                #print_area_new footer {
                    margin-bottom: 20px;
                }
                #print_area_new footer .thanks {
                    margin-bottom: 40px;
                    color: #6c757d;
                    font-size: 1.16666666666667em;
                    font-weight: 600;
                }
                #print_area_new footer .notice {
                    margin-bottom: 25px;
                }						
                .rebonnn{
                    right: 18px;
                    top: 87px;
                    box-shadow: 0 0 3px rgb(0 0 0 / 30%);
                    font-size: .8rem;
                    line-height: 100%;
                    padding: .375rem 0;
                    position: relative;
                    text-align: center;
                    text-shadow: 0 -1px 0 rgb(0 0 0 / 40%);
                    text-transform: uppercase;
                    -webkit-transform: rotate( -45deg );
                    transform: rotate( -45deg );
                    width: 250px;
                }
                .rebin_wrapper{
                    overflow: hidden !important;
                    position: absolute;
                    right: 0px;
                    bottom: 0px;
                    width: 180px;
                    height: 180px;
                    z-index: 10;
                }
                footer .end-new {
                    padding-top: 5px;
                    text-align: center;
                }
                .invoice-disclaimer-border{
                    border-top: 2px solid #6c757d;							
                    margin-bottom: 5px;
                }
                .booking-form-tag{
                    display: grid;
                    justify-content: center;
                    align-content: center;
                    width: 100px;
                    height: 100px;
                    background-color: #6c757d;
                }
                @media print{
                    .footer-div{
                        position: absolute;
                        bottom: 0px;
                        margin-left: 0 !important;
                        margin-right: 0 !important;
                        width: 97%;
                    }
                }
                @media screen{
                    .footer-div{
                        position: static;
                    }
                }
            </style>
        </section>
	</div>
</div>	

<link rel="stylesheet" href="<?php echo $home; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php echo $home; ?>assets/css/skeletonc.css">
<script type="text/javascript" src="<?php echo $home; ?>assets/js/printThis.js"></script>
<script>
	$('#print_button_new').on("click", function () {
        $('#print_area_new').printThis({
        });
    });
</script>
<?php } ?>