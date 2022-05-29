<div class="content-wrapper" style="background-color:#fff;">
	<div class="container">
        <form id="pre_ipo_form" action="<?php echo current_url(); ?>" method="POST" enctype="multipart/form-data">
            <div class="row pt-5">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            Pre Registration
                        </div>
                        <div class="card-body">
                            <div class="" id="error_message"></div>
                            <div class="row animate-bottom" id="myDiv">
                                <div class="col-sm-4">
                                    <h5 style="text-decoration:underline;">Personal Info</h5>
                                    <input type="hidden" name="ipo_registration_token" value="<?php echo md5(time()); ?>"/>
                                    <div class="form-group">
                                        <input type="text" name="personal_full_name" class="form-control" placeholder="Full Name/Company Name" required="required"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" name="personal_phone_number" class="form-control" placeholder="Phone Number" required="required"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="date" name="personal_date_of_birth" class="form-control" title="Date of Birth" required="required"/>
                                            </div>
                                        </div>
                                    </div>				
                                    <div class="form-group">
                                        <input type="email" name="personal_email" class="form-control" placeholder="Email" required="required"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>NID/Trade Licence</label>
                                                <input type="text" name="personal_nid_card" class="form-control" placeholder="NID/Trade Licence" required="required"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Attachment</label>
                                                <input type="file" name="personal_nid_attachment" class="form-control" style="padding-top:3px;padding-left: 3px;" required="required"/>
                                            </div>	
                                        </div>
                                    </div>				
                                    <div class="form-group">
                                        <label>Choose Image</label>
                                        <input type="file" name="personal_images" class="form-control" style="padding-top:3px;padding-left: 3px;" required />
                                    </div>	
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="personal_address" class="form-control" placeholder="Address" required></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <h5 style="text-decoration:underline;">Bank Info</h5>
                                    <div class="form-group">
                                        <input type="text" name="ipo_bank_name" class="form-control" placeholder="Bank Name" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="account_holder_name" class="form-control" placeholder="Account Holder Name" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="account_number" class="form-control" placeholder="Account Number" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="routing_number" class="form-control" placeholder="Routing Number" required="required"/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="bank_branch_name" class="form-control" placeholder="Bank Branch Name"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Cheque Attachment</label>
                                        <input type="file" name="bank_attachment[]" multiple class="form-control" style="padding-top:3px;padding-left: 3px;"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="bank_address" class="form-control" placeholder="Bank Address"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <h5 style="text-decoration:underline;">Nominee</h5>
                                    <div class="form-group">
                                        <input type="text" name="nominee_name" class="form-control" placeholder="Nominee Name">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" name="nominee_phone_number" class="form-control" placeholder="Phone Number"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="date" name="nominee_date_of_birth" class="form-control" title="Date of Birth"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="email" name="nominee_email" class="form-control" placeholder="Email"/>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>NID</label>
                                                <input type="text" name="nominee_nid_card" class="form-control" placeholder="NID Number"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Attachment</label>
                                                <input type="file" name="nominee_nid_attachment" class="form-control" style="padding-top:3px;padding-left: 3px;"/>
                                            </div>	
                                        </div>
                                    </div>	
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Relation</label>
                                                <select name="nominee_relation" class="form-control select2">
                                                    <option value="">select</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Brother">Brother</option>
                                                    <option value="Sister">Sister</option>
                                                    <option value="Cousin">Cousin</option>
                                                    <option value="Friends">Friends</option>
                                                    <option value="Husband">Husband</option>
                                                    <option value="Wife">Wife</option>
                                                    <option value="Uncle">Uncle</option>
                                                    <option value="Aunti">Aunti</option>
                                                    <option value="Daughter">Daughter</option>
                                                    <option value="Son">Son</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Choose Image</label>
                                                <input type="file" name="nominee_images" class="form-control" style="padding-top:3px;padding-left: 3px;"/>
                                            </div>	
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="nominee_address" class="form-control" placeholder="Address"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12"><button class="btn btn-primary">Submit</button></div>
                            </div>
                        </div>
                    </div>            
                </div> 
            </div>
        </form>		
    </div>
</div>
<script>
    $('#pre_ipo_form').on('submit', function(){
        event.preventDefault();
		var form = $('#pre_ipo_form')[0];
		var data = new FormData(form);
        $.ajax({
            type: "POST",
			enctype: 'multipart/form-data',
			url:"<?=base_url('assets/ajax/form_submit/ipo_registration_form_pre_submit.php');?>",  
			data: data,            
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
            beforeSend:function(){
				$('#data-loading').html(data_loading);
			},
			success:function(data){
				$('#data-loading').html('');
                if(data != 'success'){
                    $('#error_message').addClass('text-danger');
                    $('#error_message').html(data);
                }else{
                    $('#error_message').addClass('text-primary');
                    $('#error_message').html('Your Pre Registration is successfully done');
                }
			}
        })
    });
</script>