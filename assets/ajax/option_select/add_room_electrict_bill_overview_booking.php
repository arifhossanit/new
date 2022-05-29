<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['room_id'])){ ?>
<span style="text-align:center;text-decoration:underline;">
	<?php echo $_POST['room_name']; ?>
</span>
<div class="row">
	<input type="hidden" name="rooms_id" value="<?php echo $_POST['room_id']; ?>"/>
	<input type="hidden" name="room_id_electrict_token" value="<?php echo md5(rand()); ?>"/>
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<div class="form-group">
			<label>Select Month</label>
			<input type="month" name="selected_month" value="<?php echo date('Y-m'); ?>" class="form-control" required />
		</div>
		<div class="form-group">
			<label>Write Amount</label>
			<input type="text" name="amount" placeholder="Amount" autocomplete="off" class="number_int_electricity form-control" required />
		</div>
		<div class="form-group">
			<label>Note</label>
			<textarea name="note" class="form-control" placeholder="Note"></textarea>
		</div>
		<div class="form-group">
			<button type="submit" name="add_electricity_bill_button" id="add_electricity_bill_button" class="btn btn-success" style="float:right;">Submit</button>
		</div>
	</div>
	<div class="col-sm-3"></div>
</div>
<div class="row">
	<div class="col-sm-12" style="margin-top:20px;">
		<table class="table table-sm table-bordered" id="electrict_bill_data_table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Session</th>
					<th>Amount</th>
					<th>Uploader</th>
					<th>Date</th>
					<th>OP</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<script>
function delete_electricity_bill(id){
	if( id != ''){
		if(confirm('Are you sure want to delete the data?')){
			$.ajax({  
				url:"<?php echo $home.'assets/ajax/option_select/add_room_electrict_bill_overview_booking.php'; ?>",  
				method:"POST",
				data:{ bill_id:id },
				beforeSend:function(){					
					$('#data-loading').html(data_loading);
				},
				success:function(data){	
					$('#data-loading').html('');											
					alert(data);
					$('#electrict_bill_data_table').DataTable().ajax.reload( null , false);	
				}
			}); 
		}
	}else{
		alert('Something wrong! Please try again.');
	}
}
$(document).ready(function() {
	var table_infoi = "?room_id=<?php echo $_POST['room_id']; ?>";
    var electrict_booking = $('#electrict_bill_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100],
			[10, 25, 50, 100]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": false,
		"autoWidth": false,
		"responsive": false,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?php echo $home; ?>assets/ajax/data_table/electrict_bill_data_table.php"+table_infoi
    });
})
$('.number_int_electricity').on("input",function(){
	this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
})
</script>
<?php } ?>

<?php
if(isset($_POST['room_id_electrict_token'])){
	$room_id = $_POST['rooms_id'];
	$d = explode('-',$_POST['selected_month']);
	$month = $d[1];
	$year = $d[0];
	$month_year = $month.'/'.$year;
	$room = mysqli_fetch_assoc($mysqli->query("select * from rooms where id = '".$room_id."'"));
	$check_month_year = mysqli_fetch_assoc($mysqli->query("select * from electicity_bill where month_year = '".$month_year."' and room_id = '".$room_id."'"));
	if(!empty($check_month_year['month_year'])){
		echo 'This Month, Year already Exixt! Please delete fast & Try again';
	}else{
		if($mysqli->query("insert into electicity_bill values(
			'',
			'".$room['branch_id']."',
			'".$room['floor_id']."',
			'".$room['unit_id']."',
			'".$room['id']."',
			'".$month."',
			'".$year."',
			'".$_POST['amount']."',
			'".$month_year."',
			'".$_POST['note']."',
			'1',
			'".$_SESSION['super_admin']['user_type'].'___'.$_SESSION['super_admin']['email'].'___'.$_SESSION['super_admin']['branch']."',
			'".date('d/m/Y')."'
		)")){
			echo 'Submitted successfully!';
		}else{
			echo 'Something wrong! Please try again.';
		}
	}
}
if(isset($_POST['bill_id'])){
	if($mysqli->query("delete from electicity_bill where id = '".$_POST['bill_id']."'")){
		echo 'Deleted successfully!';
	}else{
		echo 'Something wrong! Please try again.';
	}
}
?>