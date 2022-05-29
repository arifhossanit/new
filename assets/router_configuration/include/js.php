<script type="text/javascript">
var data_loading = '<div style="position: fixed; z-index: 99999; top: 0%; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);"><center><img src="<?php echo $home; ?>assets/img/loading.gif" style="margin-top:16%;border-radius:50px 5px 50px 5px;"/></center></div>';
function view_router_dashboard(id){
	$.ajax({  
		url:"<?php echo $home; ?>assets/router_configuration/ajax/router_dashboard.php",  
		method:"POST",  
		data:{router_id:id},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#router_dashboard_result').html(data); 
			$('#router_dashboard_modal').modal('show'); 
		}  
	});
}
function view_router_information(id){
	$.ajax({  
		url:"<?php echo $home; ?>assets/router_configuration/ajax/router_information.php",  
		method:"POST",  
		data:{router_id:id},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#router_information_result').html(data); 
			$('#router_information_modal').modal('show'); 
		}  
	});  
}
$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true, "lengthChange": true, "lengthMenu": [ [10, 25, 50, 100, 500], [10, 25, 50, 100, 500] ], "searching": true, "ordering": true, "order": [[ 0, "asc" ]], "ScrollX": true, "processing": true, "serverSide": false, dom: 'lBfrtip', buttons: [ { extend: 'copy', text: '<i class="fas fa-copy"></i> Copy', titleAttr: 'Copy', exportOptions: { columns: ':visible' } }, { extend: 'excel', text: '<i class="fas fa-file-excel"></i> Excel', titleAttr: 'Excel', exportOptions: { columns: ':visible' } }, { extend: 'csv', text: '<i class="fas fa-file-csv"></i> CSV', titleAttr: 'CSV', exportOptions: { columns: ':visible' } }, { extend: 'pdf', exportOptions: { columns: ':visible' }, orientation: 'landscape', pageSize: "LEGAL", text: '<i class="fas fa-file-pdf"></i> PDF', titleAttr: 'PDF' }, { extend: 'print', text: '<i class="fas fa-print"></i> Print', titleAttr: 'Print', exportOptions: { columns: ':visible' } }, { extend: 'colvis', text: '<i class="fas fa-list"></i> Column Visibility', titleAttr: 'Column Visibility' } ]
    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
})
$(function (){
	$('.select2').select2();
})
	$.widget.bridge('uibutton', $.ui.button)
</script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assetss/plugins/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/chart.js/Chart.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/sparklines/sparkline.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/moment/moment.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>	
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>	
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>	
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-buttons/js/aditional/jszip.min.js"></script>	
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-buttons/js/aditional/pdfmake.min.js"></script>	
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-buttons/js/aditional/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/js/vfs_fonts.js"></script>	
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-buttons/js/buttons.print.js"></script>	
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>	
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>	
<script src="<?php echo $home; ?>assets/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?php echo $home; ?>assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>