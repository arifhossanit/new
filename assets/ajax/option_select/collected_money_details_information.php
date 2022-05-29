<?php
include("../../../application/config/ajax_config.php");
if(isset($_POST['collected_id'])){ 
	$ids = explode(',',rahat_decode($_POST['collected_id'])); 
?>
<div class="row">
	<div class="col-sm-12">
		<div id="export_buttons_dropbox_collection_details" style="float: right;color:#333 !important;margin-bottom:15px;"></div>
	</div>
	<div class="col-sm-12">
		<table id="collection_money_details" class="table table-sm table-bordered" style="width:100%;">
			<thead>
				<tr>
					<td>ID</td>
					<td>SL</td>
					<td>Purpose</td>
					<td>Transaction ID</td>
					<td>Payment Method</td>
					<td>Amount</td>
					<td>Date</td>
				</tr>
			</thead>
			<tbody>
<?php 
	$i = 1;
	$total = 0;
	foreach($ids as $row){
		$box = mysqli_fetch_assoc($mysqli->query("SELECT * FROM drop_box_data WHERE id = '".$row."'"));
		$transaction = mysqli_fetch_assoc($mysqli->query("SELECT * FROM transaction WHERE transaction_id = '".$box['transaction_id']."'"));
?>
				<tr>
					<td><?php echo $box['id']; ?></td>
					<td><?php echo $i++; ?></td>
					<td style="color:green;font-weight:bolder;"><?php if(!empty($transaction['note'])){ echo $transaction['note']; }else{ echo '<span style="color:#f00;">Something Wrong!</span>'; } ?></td>
					<td style="color:#9b0513;font-weight:bolder;"><?php echo $box['transaction_id']; ?></td>
					<td><?php echo $box['payment_method']; ?></td>
					<td style="font-weight:bolder;color:#f00;"><?php echo money($box['amount']); ?></td>
					<td><?php echo $box['data']; ?></td>
				</tr>
<?php 
	$total = (int)$total + (int)$box['amount'];
} ?> 
				<tr>
					<td> </td>
					<td> </td>
					<td> </td>
					<td> </td>
					<td>Total: </td>
					<td style="font-weight:bolder;color:#f00;font-family: cursive;"><?php echo money($total); ?></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script>
$(document).ready(function(){
	var table_booking3 = $('#collection_money_details').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": true,
		"ordering": false,
		"info": true,
		"autoWidth": true,
		"responsive": true,
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy'
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel'
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV'
            },
            {
                extend: 'pdf',
				exportOptions: {
					columns: ':visible'
				},
				orientation: 'landscape',
				pageSize: "LEGAL",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'PDF'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print',
                titleAttr: 'Print'
            }
        ]
    });
	table_booking3.buttons().container().appendTo($('#export_buttons_dropbox_collection_details'));
})
</script>
<?php } ?>
