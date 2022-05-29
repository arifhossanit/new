<?php
if(isset($_GET['ipo_id_daily_payment'])){ 
	$file = $_SERVER['DOCUMENT_ROOT'].'/datatables/pdo.php';
	if ( is_file( $file ) ) {
		include( $file );
	}
	include("../../../../application/config/ajax_config.php");
	
	$table = 'ipo_investment_daily_logs';
	$primaryKey = 'id';
	$where = "ipo_id = '".$_GET['ipo_id_daily_payment']."'";
	$columns = array(
		array('db' => 'id', 'dt' => 0 ),
		array(
			'db' => 'payment_date', 'dt' => 1, 'formatter' => 
			function( $d, $row ) {
				return date_converter($d);
			}
		),
		array('db' => 'aggreement_type', 'dt' => 2 ),
		array('db' => 'note', 'dt' => 3 ),
		array(
			'db' => 'commission_rate', 'dt' => 4, 'formatter' => 
			function( $d, $row ) {
				return $d.'<small>%<small>';
			}
		),
		array(
			'db' => 'payment_amount', 'dt' => 5, 'formatter' => 
			function( $d, $row ) {
				return money($d);
			}
		)
	);
	$sql_details = array( 'user' => $user, 'pass' => $pass, 'db'   => $db, 'host' => $host );
	echo json_encode(
		SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns , $where , null)
	);
}else{
?>
<div class="row">
	<div class="col-sm-12">
		<h5 style="text-decoration:underline;">Daily Payment Information</h5>
	</div>
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<div style="float:right;" id="export_buttons_Daily_payment"></div>
			</div>
			<div class="col-sm-12 body">
				<table class="table table-sm table-bordered" id="daily_payment_information">
					<thead>
						<tr>
							<th>ID</th>
							<th>Date</th>
							<th>Agreement Type</th>
							<th>Widthdraw Type</th>
							<th>Commission</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody></tbody>					
				</table>
			</div>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	var command = "?ipo_id_daily_payment=<?php echo $_MEMBER_INFO['ipo_id']; ?>";
    var table_booking = $('#daily_payment_information').DataTable({
		"paging": true, "lengthChange": true, "lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ], "searching": true, "ordering": true, "order": [[ 0, "desc" ]], "info": false, "autoWidth": false, "responsive": false, "ScrollX": true, "processing": true, "serverSide": true,
        "ajax": "<?php echo $home; ?>assets/ajax/ipo/profile/daily_payment.php"+command,
		dom: 'lBfrtip',
        buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons_Daily_payment'));	
})
</script>
<?php } ?>