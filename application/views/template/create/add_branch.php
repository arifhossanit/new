
<div class="content-wrapper">
	    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Branches</h1>
          </div> 
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
              <li class="breadcrumb-item active">Manage Branches</li>
            </ol>
          </div> 
        </div> 
      </div> 
    </div>
	
<?php
if(!empty($edit)){
	$button = '
		<button type="submit" name="update" class="btn btn-warning">Update</button>
		<a href="'.current_url().'" class="btn btn-danger">Close</a>
	';
}else{
	$button = '<button type="submit" name="save" class="btn btn-primary">Save</button>';
}
?>	
	<div class="content">
		<div class="container-flud">
			<div class="row">
				<div class="col-sm-3">
					<div class="card card-primary">
						<div class="card-header">
							<h3 class="card-title">Input Branch information</h3>
						</div>
						<form role="form" action="<?=current_url(); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="update_id" value="<?php if(!empty($edit)){ echo $edit->id; } ?>"/>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Country</label>
											<select id="country" name="country" class="select2 form-control" required>
												<?php if(!empty($edit)){ echo '<option value="'.$edit->country.'">'.$edit->country.'</option>';}else{ echo '<option value="">--select country--</option>';} ?>
												<option value="Afghanistan">Afghanistan</option> <option value="Åland Islands">Åland Islands</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antarctica">Antarctica</option> <option value="Antigua and Barbuda">Antigua and Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Bouvet Island">Bouvet Island</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Territory">British Indian Ocean Territory</option> <option value="Brunei Darussalam">Brunei Darussalam</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D'ivoire">Cote D'ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Territories">French Southern Territories</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guernsey">Guernsey</option> <option value="Guinea">Guinea</option> <option value="Guinea-bissau">Guinea-bissau</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jersey">Jersey</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> <option value="Korea, Republic of">Korea, Republic of</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macao">Macao</option> <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> <option value="Madagascar">Madagascar</option> <option value="Malawi">Malawi</option> <option value="Malaysia">Malaysia</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Micronesia, Federated States of">Micronesia, Federated States of</option> <option value="Moldova, Republic of">Moldova, Republic of</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montenegro">Montenegro</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Namibia">Namibia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherlands">Netherlands</option> <option value="Netherlands Antilles">Netherlands Antilles</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Northern Mariana Islands">Northern Mariana Islands</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau">Palau</option> <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Philippines">Philippines</option> <option value="Pitcairn">Pitcairn</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russian Federation">Russian Federation</option> <option value="Rwanda">Rwanda</option> <option value="Saint Helena">Saint Helena</option> <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> <option value="Saint Lucia">Saint Lucia</option> <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> <option value="Samoa">Samoa</option> <option value="San Marino">San Marino</option> <option value="Sao Tome and Principe">Sao Tome and Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syrian Arab Republic">Syrian Arab Republic</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania, United Republic of">Tanzania, United Republic of</option> <option value="Thailand">Thailand</option> <option value="Timor-leste">Timor-leste</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad and Tobago">Trinidad and Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks and Caicos Islands">Turks and Caicos Islands</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States">United States</option> <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Venezuela">Venezuela</option> <option value="Viet Nam">Viet Nam</option> <option value="Virgin Islands, British">Virgin Islands, British</option> <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> <option value="Wallis and Futuna">Wallis and Futuna</option> <option value="Western Sahara">Western Sahara</option> <option value="Yemen">Yemen</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option>
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Branch ID</label>
											<input type="text" name="branch_id" value="<?php if(!empty($edit)){ echo $edit->branch_id;}else{ echo 'BAR_'.date('dmy').'_'.rand()*rand().'_'.time();} ?>" class="form-control" placeholder="Branch ID" readonly>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Branch Name</label>
											<input name="branch_name" value="<?php if(!empty($edit)){ echo $edit->branch_name; } ?>" type="text" class="form-control" placeholder="Branch Name" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Branch Type</label>
											<input name="branch_type" value="<?php if(!empty($edit)){ echo $edit->branch_type; } ?>" type="text" class="form-control" placeholder="Branch Type" required>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Branch Code</label>
											<input name="branch_code" value="<?php if(!empty($edit)){ echo $edit->branch_code; } ?>" type="text" class="form-control" placeholder="Branch Code Ex: SHx" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Branch Rent</label>
											<input name="branch_rent" value="<?php if(!empty($edit)){ echo $edit->branch_rent; } ?>" type="text" class="number_int form-control" placeholder="000000000" required>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Petty Cash Limit</label>
											<input name="petty_cash_limit" value="<?php if(!empty($edit)){ echo $edit->petty_cash_limit; } ?>" type="number" class="number_int form-control" placeholder="000000000" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Agreement Attachment</label>
											<input type="file" name="agreement_attachment[]" multiple class="form-control" style="padding-top: 3px;"/>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>Images Files</label>
											<input type="file" name="image_files[]" multiple class="form-control" style="padding-top: 3px;"/>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>Branch Enable/Disable</label>
											&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="checkbox" name="branch_satatus" <?php if(!empty($edit)){ if($edit->status == '1'){ echo 'checked'; }else{ echo ''; } }else{ echo 'checked'; } ?> data-bootstrap-switch data-off-color="danger" data-on-color="success">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-6">
									
									</div>
									<div class="col-sm-6">
									
									</div>
								</div>
								
								
								<div class="form-group">
									<label>Branch Phone Number</label>
									<input name="branch_phone_number" value="<?php if(!empty($edit)){ echo $edit->branch_phone_number; } ?>" type="number" class="form-control" placeholder="Branch Phone Number" required>
								</div>
								
								
								<div class="form-group">
									<label>Branch Location</label>
									<textarea name="branch_location" class="form-control" placeholder="Branch Location" required><?php if(!empty($edit)){ echo $edit->branch_location; } ?></textarea>
								</div>
								
								
								<div class="form-group">
									<label>Owner Details</label>
									<textarea name="owner_details" class="form-control" placeholder="Owner Details" required><?php if(!empty($edit)){ echo $edit->branch_owner; } ?></textarea>
								</div>
								
								
								
							</div>
							<div class="card-footer">
								<?php echo $button; ?>
							</div>
						</form>
					</div>
				</div>				
				
				<div class="col-sm-9">
					<div class="card card-success">
						<div class="card-header">
							<h3 class="card-title">Branch List</h3>
						</div>
						<div class="card-body">
							<table class="table table-sm" id="example2">
								<thead>
									<tr>
										<th></th>
										<th>ID</th>
										<th>Country</th>
										<th>Name</th>
										<th>Petty Cash Limit</th>
										<th>Type</th>
										<th>Location</th>
										<th>Owners Info</th>
										<th>Attachedted File</th>
										<th>Entry Date</th>
										<th>Status</th>
										<th>Option</th>
									</tr>
								</thead>
								<tbody>
<?php 
if(!empty($table)){
	foreach($table as $row){
?>								
									<tr>
										<td><input type="checkbox" value="<?=$row->id;?>" /></td>
										<td><?=$row->id;?></td>
										<td><?=$row->country;?></td>
										<td><?=$row->branch_name;?></td>
										<td><?=$row->petty_cash_limit;?></td>
										<td><?=$row->branch_type;?></td>
										<td style="width: 20%;"><?=$row->branch_location;?></td>
										<td><?=$row->branch_owner;?></td>
										<td>
											<div style="width:70px;float:left;">
												<p style="margin:0px;">Files:</p>
												<?php
												if(!empty($row->file_attachment)){
													$newarraynama = rtrim($row->file_attachment,", ");
													$file = explode(',',$newarraynama);
													$i = 1;
													foreach($file as $f){
														echo '<a href="'.base_url($f).'" target="_blank" title="'.base_url($f).'">File-'.$i++.'</a><br />';
													}
												}else{
													echo '--';
												}
												?>
											</div>
											<div style="width:70px;float:left;"><!--max-height:50px;overflow-y:scroll;-->
												<p style="margin:0px;">Images:</p>
												<?php
												if(!empty($row->image_attachment)){
													$newarraynamas = rtrim($row->image_attachment,", ");
													$file = explode(',',$newarraynamas);
													$j = 1;
													foreach($file as $q){
														echo '<a href="'.base_url($q).'" target="_blank" title="'.base_url($q).'">File-'.$j++.'</a><br />';
													}
												}else{
													echo '--';
												}
												?>
											</div>											
										</td>
										<td><?=$row->data;?></td>
										<td>
											<?php if($row->status == '1'){ ?>
												<button class="btn btn-xs btn-success">Active</button>
											<?php }else{ ?>
												<button class="btn btn-xs btn-danger">Deactive</button>
											<?php } ?>
										</td>
										<td>
											<form action="<?=current_url(); ?>" method="post">
												<input type="hidden" value="<?=$row->id;?>" name="hidden_id"/>
												<button name="edit" type="submit" class="btn btn-xs btn-success">Edit</button>
												<button name="delete" type="submit" onclick="return confirm('are you sure?');" class="btn btn-sm btn-danger">Delete</button>
											</form>
										</td>
									</tr>
<?php } } ?>									
								</tbody>
							</table>
							<div align="left" style="margin-bottom:10px;">
								<button type="button" id="select" class="btn btn-xs btn-warning" style="margin-left:15px;"><i class="fa fa-list-ul" aria-hidden="true"></i></button>
								<button type="button" id="unselect" class="btn btn-xs btn-success"><i class="fa fa-bars" aria-hidden="true"></i></button>
								<button type="button" id="btn_delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
							</div>
						</div>					
					</div>
				</div>
	

			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){ 
	$("#select").click(function(){
			$('input:checkbox').prop('checked',true);     
	});
	$("#unselect").click(function(){
			$('input:checkbox').prop('checked',false);     
	});
	$('#btn_delete').click(function(){  
		if(confirm("Are you sure you want to delete selected Iteam?")){
			var id = [];   
			$(':checkbox:checked').each(function(i){
				id[i] = $(this).val();
			});   
			if(id.length === 0) {
				alert("Please Select atleast one checkbox");
			} else {
				$.ajax({
					 url:'<?= current_url(); ?>',
					 method:'POST',
					 data:{delete_id:id},
					 success:function() {
						window.open('<?= current_url(); ?>','_self');
					}     
				});
			}   
		} else {
			return false;
		}
	});
 
});
</script>