<?php
function booking_mail_details($home,$mysqli,$id){ 
$row = mysqli_fetch_assoc($mysqli->query("select * from booking_info where booking_id = '".$id."'"));
$opt = explode("___",$row['uploader_info']);
$rentre = mysqli_fetch_assoc($mysqli->query("select * from employee where email = '".$opt[1]."'"));
$member = mysqli_fetch_assoc($mysqli->query("select * from member_directory where booking_id = '".$row['booking_id']."'"));
include( APPPATH.'third_party/qrcode/qrlib.php');
$daaata = $home.'member-booking-information/qr-code/'.$row['card_no'];
$file = 'assets/uploads/qrcode/rental_recipt_id_'.$row['card_no'].'.png'; QRcode::png($daaata,$file , 'L', '10', 2); 

$html = '<div class="row">
	<div class="col-sm-12" style="margin-bottom:30px;">
		<button type="button" id="print_button" class="btn btn-warning btn-sm" style="float:right"><i class="fas fa-print"></i> &nbsp;&nbsp;&nbsp;Print</button>
	</div>
	<div class="col-sm-12" style="padding:80px;padding: 80px; max-width: 550px; margin: 0px auto;" id="print_area">
		<div class="row" style="margin-bottom:20px;">
			<table style="width:100%;">
				<tr>
					<td><img src="<?php echo $home; ?>assets/img/logo.png" style="width:150px;" class="image-responsive"/></td>
					<td style="text-align:center;">
						<h1>Booking information</h1>
						<span>Email: <b>'.$member['email'].'</b></span><br />
						<span>Application date: <b>'.$row['data'].'</b></span>
					</td>
					<td>
						<img src="'.$home.'assets/uploads/qrcode/rental_recipt_id_'.$row['card_no'].'.png" style="width:120px;float:right;" class="image-responsive"/>
					</td>
				</tr>
			</table>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<style>.my_table{font-size:25px;} .my_table td{padding:5px; border:solid 1px #0000001a;padding-left:10px;}.my_table th{padding:5px; border:solid 1px #0000001a;padding-left:10px;}</style>
				<table border="1" class="my_table" style="background: url('.$home.'assets/img/logo_low_opacity.png); background-repeat: no-repeat;background-origin: content-box;background-position: center;width:100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Information</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Name</td>
							<td><b>'.$row['m_name'].'</b></td>
						</tr>
						<tr>
							<td>Number</td>
							<td><b>'.$member['phone_number'].'</b></td>
						</tr>
						<tr>
							<td>Occupation</td>
							<td><b>'.$member['occupation'].'</b></td>
						</tr>
						<tr>
							<td>Card NO</td>
							<td><b>'.$row['card_no'].'</b></td>
						</tr>
						<tr>
							<td>Branch Name</td>
							<td><b>'.$row['branch_name'].'</b></td>
						</tr>
						<tr>
							<td>Check in Date</td>
							<td><b>'.$row['checkin_date'].'</b></td>
						</tr>
						<tr>
							<td>Package</td>
							<td><b>'.$row['package_name'].'</b></td>
						</tr>
						<tr>
							<td>Security Deposit</td>
							<td><b>'.money($row['security_deposit']).'</b></td>
						</tr>
						<tr>
							<td>Payment Method</td>
							<td><b>'.$row['payment_method'].'</b></td>
						</tr>
						<tr>
							<td>Bed Number</td>
							<td><b>'.$member['bed_name'].'</b></td>
						</tr>
						<tr>
							<td>Parking</td>
							<td><b>'; if($member['parking'] == '0'){ $html .= 'No'; }else{ $html .= 'Yes'; } $html .= '</b></td>
						</tr>
						<tr>
							<td>Available days</td>
							<td><b>'.$row['available_days'].' Days</b></td>
						</tr>				
						<tr>
							<td>Rent By</td>
							<td> <b> '.$rentre['full_name'].' </b> </td>
						</tr>
					</tbody>
				</table>
				
			</div>			
		</div>
	</div>
</div>';
return $html;

 } ?>