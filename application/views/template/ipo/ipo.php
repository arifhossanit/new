<?php
	if(empty($_SESSION['cart_gen_code'])){
		$_SESSION['cart_gen_code'] = time() * rand() . '_' . rand() * time();
		echo "<script>window.open('".current_url()."','_self')</script>";
	}
?>
<div class="content-wrapper">
	<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Investment</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Investment</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<span id="athorization_message"></span>
					<div class="row">					
						<div class="col-sm-12" style="margin-bottom:20px;">							
							<button type="button" onclick="return investor_registration()" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="fas fa-align-justify"></i> &nbsp;&nbsp;Investor Registration</button>
							<!--button type="button" onclick="return building_overview()" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="far fa-building"></i> &nbsp;&nbsp;Building Overview</button-->
							<button type="button" onclick="window.open('<?php echo base_url('admin/ipo/ipo-member-directory'); ?>','_self')" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="far fa-user"></i> &nbsp;&nbsp;Investment Member Directory</button>
							<button type="button" onclick="window.open('<?php echo base_url('admin/ipo/ipo-member-directory-pre'); ?>','_self')" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="fas fa-user-clock"></i> &nbsp;&nbsp;Pre-registered Member Directory</button>
							<button type="button" onclick="window.open('<?php echo base_url('admin/ipo/demo-ipo-member-directory'); ?>','_self')" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="fas fa-id-card-alt"></i> &nbsp;&nbsp;Demo Member Directory</button>
							<button type="button" onclick="window.open('<?php echo base_url('admin/ipo/investment_inquery'); ?>','_self')" class="btn btn-dark" style="float:right;margin-right:15px;"><i class="fas fa-phone-slash"></i> &nbsp;&nbsp;Investment Inquery</button>
						</div>
					</div>
					
					<div class="row">
						<div class="col-sm-12">
							<div class="card card-dark">
								<div class="card-header">
									<h3 class="card-title"> Investment Purses Information</h3>
									<div id="export_buttons" style="float: right;"></div>
								</div>
								<div class="card-body">
									<style>#booking_data_table td{text-align:center;vertical-align: middle;}#booking_data_table th{text-align:center;vertical-align: middle;}#booking_data_table td:last-child{text-align:left;}</style>
									<table id="booking_data_table" class="display table table-sm table-bordered table table-striped" style="width:100%;font-size: 16px;white-space: nowrap;">
										<thead>
											<tr>
												<th>Id</th>
												<th>Card No</th>
												<th>Name</th>
												<th>Phone Number</th>
												<th>Email</th>
												<th>Amount</th>
												<th>Type</th>
												<th>TRXN Type</th>
												<th>Date</th>
												<th>Uploader</th>
												<th>Status</th>
												<th>Option</th>
											</tr>
										</thead>
										<tbody>	
										</tbody>
										<tfoot>	
											<tr>
												<th>Id</th>
												<th>Card No</th>
												<th>Name</th>
												<th>Phone Number</th>
												<th>Email</th>
												<th>Amount</th>
												<th>Type</th>
												<th>Date</th>
												<th>Uploader</th>
												<th>Status</th>
												<th>Option</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>

<!----vaiw building overview-->
	<div class="modal fade" id="building_overview">
		<div class="modal-dialog modal-xl" style="min-width:100%;min-height:100%;margin:0px;">
			<div class="modal-content">
				<form action="<?=current_url(); ?>" method="post">
					<div class="modal-header btn-dark">					
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-2">
									<div class="form-group" style="margin-bottom:0px;">
										<select id="branch_iid_building" class="branch_iid_building form-control select2" onchange="return building_overview()">
											<?php
												if(!empty($banches)){
													foreach($banches as $row){
														echo '<option value="'.$row->branch_id.'">'.$row->branch_name.'</option>';																										
													}
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group" style="margin-bottom:0px;">
										<select id="room_type" class="form-control select2" onchange="return building_overview()">
											
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<h4 class="modal-title" id="bed_info_header"> Building Overview</h4>	
								</div>
								<div class="col-sm-2">
									<div class="btn-group">
										<button type="button" id="ipo_cart_dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span class="badge badge-danger navbar-badge" id="cart_count" style="font-size: 15px;">0</span>
											<i class="fas fa-shopping-cart"></i> 
										</button>
										<div class="dropdown-menu" style="min-width:400px;">
											<div id="cart_result" class="col-sm-12">
												<div class="row">
													<div class="col-sm-12">
														<center>
															<b>Investment Cart is Emplty!</b>
														</center>
													</div>
												</div>
											</div>
										</div>										
									</div>
								</div>
								<div class="col-sm-2">
									<button type="button" onclick="return refresh_building_overview()" class="close" data-dismiss="modal" aria-label="Close" style="background-color:#f00;color:#fff;padding: 0px 15px;border-radius: 1px;    position: absolute; right: 0;">
										<span aria-hidden="true" style="font-size:39px;line-height: 49px;">&times;</span>
									</button>
								</div>
							</div>							
						</div>						
					</div>
					<script>
					$('document').ready(function(){
						var building_overview_height = $(window).height() - 73;
						$("#building_overview_result").css({"height":building_overview_height});
					})
					</script>
					<div class="modal-body" id="building_overview_result" style="min-height:100px;overflow-y:scroll;"> </div>
				</form>
			</div>
		</div>
	</div>
<!----End building overview-->

<div class="modal fade" id="ipo_registration_form">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form id="ipo_registration_submit_form" action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
				<div class="modal-header btn-dark">
					<h4 class="modal-title">Investment Registration Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="ipo_registration_form_result" style="max-height:780px;overflow-y:scroll;">
					
				</div>
				
			</form>
		</div>
	</div>
</div>



<!----bed cart- model-->
<div class="modal fade" id="bed_cart_model">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
				<div class="modal-header btn-infi">
					<h4 class="modal-title">Aggreement Info</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="bed_cart_model_result"> </div>
			</form>
		</div>
	</div>
</div>
<!----bed end cart- model-->





<!-- IPO receipt -->
<div class="modal fade" id="ipo_receipt">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<form action="<?=current_url(); ?>" method="post">
				<div class="modal-header btn-success">
					<h4 class="modal-title" style="font-size:23px;">Investment invoice</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="ipo_receipt_body"></div>
			</form>
		</div>
	</div>
</div>
<!-- End IPO receipt -->




<script>
function go_to_save_js(){
	if($('#sent_otp').val() === $('#confirm_otp').val()){
		$('#test_otp').html('<button type="submit" id="finish_booking" class="btn btn-primary">Save</button>');
		var written_amount = 0;
		$('input[placeholder="Amount"]').each(function(){
			if($(this).val() != ''){
				written_amount += parseInt($(this).val());
			}		
		})
		var due_result_amount_booking = written_amount - parseInt($('input[name="booking_total_amount"]').val());
		$("#due_result_amount_booking").html('Calculation: ' + due_result_amount_booking);	
		if(parseInt($('input[name="booking_total_amount"]').val()) <= written_amount){
			$("#finish_booking").prop("disabled", false);
		}else{
			$("#finish_booking").prop("disabled", true);
		}
	}
}
function get_investment_otp(){
	let personal_phone_number = $('#personal_phone_number').val();
	console.log(personal_phone_number);
	if(personal_phone_number != ''){
		$.ajax({
			type: "POST",
			url:"<?=base_url('assets/ajax/option_select/send_otp_investment.php');?>",  
			data: {otp_phn: personal_phone_number},
			beforeSend:function(){
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				let info = JSON.parse(data);
				$('#test_otp').html(info.html);
				console.log(info.html);
				// if(info.status[1] == '1'){
				// 	alert(value[0]);
				// 	$("#finish_booking").prop("disabled", false);
				// 	$('#booking_data_table').DataTable().ajax.reload( null , false);
				// }else{
				// 	alert(value[0]);					
				// 	$('#ipo_registration_form').modal('hide');
				// 	$("#finish_booking").prop("disabled", false);
				// 	reset_ipo_registration_form();
				// 	get_ipo_receipt(value[2], value[3], value[4]);
				// 	$('#booking_data_table').DataTable().ajax.reload( null , false);
				// 	//return view_profile_from_booking_1(value[2]);						
				// }				
			}
		});
	}else{
		$('#error_msg').html('Enter Phone Number');
	}
};
var cart_generate_code = '<?php echo $_SESSION['cart_gen_code']; ?>';
function add_to_shopping_cart(bed_id, ipo_price, quantity, price, category, commission, aggrement_type, tenure, expirity_date){
		var direct_ipo_registration = 'NO';
		$.ajax({  
		url:"<?php echo base_url(); ?>assets/ajax/form_model/ipo_registration_form.php",
		method:"POST",
		data:{ 
			cart_generate_code_submit:cart_generate_code, 
			bed_id_to_cart:bed_id,
			ipo_price:ipo_price,
			quantity:quantity,
			price:price,
			category:category,
			commission:commission,
			aggrement_type:aggrement_type,
			tenure:tenure,
			expirity_date:expirity_date,
			direct_ipo_registration:direct_ipo_registration
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');								
			var value = data.split('__________');
			$('#cart_result').html(value[0]);
			$('#cart_count').html(value[1]);
			$('#bed_cart_model_result').html('');
			$('#bed_cart_model').modal('hide');
		}  
	});
}
function add_to_shopping_cart_v2(category, client_type, ipo_price, qty, ipo_rate, ipo_commission, agreement_type, tenure, expirity_date, transaction_type){
		var direct_ipo_registration = 'YES';
		$.ajax({  
		url:"<?php echo base_url(); ?>assets/ajax/form_model/ipo_registration_form.php",
		method:"POST",
		data:{ 
			cart_generate_code_submit:cart_generate_code, 
			category:category,
			client_type:client_type,
			ipo_price:ipo_price,
			qty:qty,
			ipo_rate:ipo_rate,
			ipo_commission:ipo_commission,
			agreement_type:agreement_type,
			tenure:tenure,
			expirity_date:expirity_date,
			transaction_type:transaction_type,
			direct_ipo_registration:direct_ipo_registration
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');
			if(data == 1){
				$('#bed_cart_model_result').html('');
				$('#bed_cart_model').modal('hide');			
				get_bet_and_open_form('YES');
			}else{
				alert('Something wrong! Please try again.');
			}
			
		}  
	});
}


$('body').on('click', "input[type='radio']", function(){
	let member_type = $("input[name='member_type']:checked").val();
	$.ajax({  
		url:"<?=base_url('assets/ajax/ipo/ipo_registration_form_member_type.php'); ?>",
		method:"POST",
		data:{ member_type:member_type },
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');	
			$('#member_personal_information').html(data);
			$('.select2').select2();
			if(member_type === 'existing'){
				$('#card_number_div').hide();
				$('#card_number').prop('required', false);
			}else{
				$('#card_number_div').show();
				$('#card_number').prop('required', true);
				$('#card_number').val('');
			}
		}  
	});
});
function get_card_number(existing_member){
	existing_member = existing_member.split('~');
	ipo_id = existing_member[0];
	$.ajax({  
		url:"<?=base_url('assets/ajax/ipo/get_ipo_card_number.php'); ?>",
		method:"POST",
		data:{ ipo_id:ipo_id },
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){
			let info = JSON.parse(data);
			console.log(data);
			$('#data-loading').html('');	
			$('#card_number').val(info.card_number);
			$('#personal_phone_number').val(info.personal_phone_number);
		}  
	});
}
function investor_registration(){
	var bed_id = 'NaN';
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/ipo_registration_form.php'); ?>",
		method:"POST",
		data:{ add_qty_bed_cart:bed_id },
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');	
			$('#bed_cart_model_result').html('');
			$('#bed_cart_model_result').html(data);			
			$('#bed_cart_model').modal('show');
		}  
	});	
}

function bed_add_quantity_form(bed_id){
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/ipo_registration_form.php'); ?>",
		method:"POST",
		data:{ add_qty_bed_cart:bed_id },
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');	
			$('#bed_cart_model_result').html('');
			$('#bed_cart_model_result').html(data);			
			$('#bed_cart_model').modal('show');
		}  
	});	
}

function get_cart_information(){
	var cart_info = 1;
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/ipo_registration_form.php'); ?>",
		method:"POST",
		data:{ get_cart_info:cart_info },
		success:function(data){	
			var value = data.split('__________');
			$('#cart_result').html(value[0]);
			$('#cart_count').html(value[1]);
		}  
	});
}
function remove_ipo_cart_item(id){
	var cart_info = id;
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/ipo_registration_form.php'); ?>",
		method:"POST",
		data:{ ipo_cart_clear_single:cart_info },
		success:function(data){	
			var value = data.split('__________');
			$('#cart_result').html(value[0]);
			$('#cart_count').html(value[1]);
			$('#bed_cart_model_result').html('');
			$('#ipo_cart_dropdown').click();
		}  
	});
}
function ipo_cart_clear(){
	var cart_info = 1;
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/ipo_registration_form.php'); ?>",
		method:"POST",
		data:{ ipo_cart_clear:cart_info },
		success:function(data){	
			var value = data.split('__________');
			$('#cart_result').html(value[0]);
			$('#cart_count').html(value[1]);
			$('#bed_cart_model_result').html('');
			$('#ipo_cart_dropdown').click();
		}  
	});
}
function reset_ipo_registration_form(){
	$("#ipo_registration_submit_form").trigger("reset");
	ipo_cart_clear();
	//building_overview();
}
function get_ipo_receipt(ipo_id, purchase_code, transaction_id){
	console.log(transaction_id);
	$.ajax({  
		url:"<?=base_url('assets/ajax/receipt/ipo_receipt.php');?>",  
		method:"POST",  
		data:{ipo_id: ipo_id, purchase_code: purchase_code, transaction_id: transaction_id},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);					 
		},
		success:function(data){	
			$('#data-loading').html('');
			$('#ipo_receipt_body').html(data);
			$('#ipo_receipt').modal('show');
			console.log(data);
		}  
	});
}
$(document).ready(function(){
	$("#ipo_registration_submit_form").on("submit", function(){
		event.preventDefault();
		var form = $('#ipo_registration_submit_form')[0];
		var data = new FormData(form);
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/ipo_registration_form.php');?>",  
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			beforeSend:function(){
				$("#finish_booking").prop("disabled", true);
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
				var value = data.split('____');
				if(value[1] == '1'){
					alert(value[0]);
					$("#finish_booking").prop("disabled", false);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
				}else{
					alert(value[0]);					
					$('#ipo_registration_form').modal('hide');
					$("#finish_booking").prop("disabled", false);
					reset_ipo_registration_form();
					get_ipo_receipt(value[2], value[3], value[4]);
					$('#booking_data_table').DataTable().ajax.reload( null , false);
					//return view_profile_from_booking_1(value[2]);						
				}				
			}
		});		
		return false;
	})
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$('#ipo_registration_form').on('hidden.bs.modal', function () {
		var ipo_cart_clear = '<?php echo $_SESSION['cart_gen_code']; ?>';
		$.ajax({  
			url:"<?=base_url('assets/ajax/form_model/ipo_registration_form.php');?>",
			method:"POST",
			data:{ ipo_cart_clear:ipo_cart_clear },
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');								
				$('#ipo_registration_form_result').html('');
			}  
		});	
		
	});
	$('#bed_cart_model').on('hidden.bs.modal', function () {
		$('#bed_cart_model_result').html('');
	});
	$('#building_overview').on('hidden.bs.modal', function () {
		$('#building_overview_result').html('');
	});
	get_cart_information();
})
function get_bet_and_open_form(condition){
	var form_oprn = 1;
	$.ajax({  
		url:"<?=base_url('assets/ajax/form_model/ipo_registration_form.php');?>",
		method:"POST",
		data:{ 
			bed_id_registration_form:form_oprn,
			condition:condition
		},
		beforeSend:function(){					
			$('#data-loading').html(data_loading);
		},
		success:function(data){	
			$('#data-loading').html('');								
			$('#ipo_registration_form_result').html(data);
			$('#ipo_registration_form').modal('show');
			$('#building_overview_result').html('');
			$('#building_overview').modal('hide');
		}  
	});	
}

function building_overview(){
	var branch_id = $("#branch_iid_building").val();	
	var room_type = $("#room_type").val();	
	if( branch_id != '' ){
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/get_room_type_ipo_overview.php');?>",  
			method:"POST",
			data:{ branch_id:branch_id },
			success:function(data){									
				$('#room_type').html(data);
			}  
		});
		$.ajax({  
			url:"<?=base_url('assets/ajax/option_select/building_overview_ipo.php');?>",
			method:"POST",
			data:{ 
				branch_id:branch_id,
				room_type:room_type
			},
			beforeSend:function(){					
				$('#data-loading').html(data_loading);
			},
			success:function(data){	
				$('#data-loading').html('');								
				$('#building_overview_result').html(data);
				$('#building_overview').modal('show');
			}  
		});	  
	}
}
$(document).ready(function() {
    var table_booking = $('#booking_data_table').DataTable({
		"paging": true,
		"lengthChange": true,
		"lengthMenu": [
			[10, 25, 50, 100, 500],
			[10, 25, 50, 100, 500]
		],
		"searching": true,
		"ordering": true,
		"order": [[ 0, "desc" ]],
		"info": true,
		//"autoWidth": true,
		//"responsive": true,
		"ScrollX": true,
		"processing": true,
        "serverSide": true,
        "ajax": "<?=base_url(); ?>assets/ajax/data_table/ipo/ipo_information_datatable.php",
		initComplete: function(){
            var api = this.api();
            api.columns().every(function(){
                var that = this;
                $('input', this.footer()).on('keyup change', function(){
                    if (that.search() !== this.value){
                        that.search(this.value).draw();
                    }
                });
            });
        },
		/*
		"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			if (aData[0] == "28") {
				$('td', nRow).css('background-color', 'Orange');
			} else if (aData[0] == "37") {
				$('td', nRow).css('background-color', 'Orange');
			} else if (aData[0] == "38") {
				$('td', nRow).css('background-color', 'Orange');
			}else if (aData[0] == "39") {
				$('td', nRow).css('background-color', 'Orange');
			}
		}, */
		dom: 'lBfrtip',
        buttons: [			
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy',
                titleAttr: 'Copy',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
				exportOptions: {
					columns: ':visible'
				}
            },
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv"></i> CSV',
                titleAttr: 'CSV',
				exportOptions: {
					columns: ':visible'
				}
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
                titleAttr: 'Print',
				exportOptions: {
					columns: ':visible'
				}
            },
			{
                extend: 'colvis',
                text: '<i class="fas fa-list"></i> Column Visibility',
                titleAttr: 'Column Visibility'
            }
        ]

    });
	table_booking.buttons().container().appendTo($('#export_buttons'));	
	$('#booking_data_table tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input style="border:none;" type="text" class="form-control" title="Search By ' + title + '" placeholder="Search ' + title + '" />');
    });
})
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>