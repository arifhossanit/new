<?php
include("../../../application/config/ajax_config.php");
$member_type = $_POST['member_type'];
if($member_type == 'new'){
    $html = '<div class="col-sm-4">
                <h4 style="text-decoration:underline;">Personal Info</h4>
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
                <h4 style="text-decoration:underline;">Bank Info</h4>
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
                    <label>Attachment</label>
                    <input type="file" name="bank_attachment[]" multiple class="form-control" style="padding-top:3px;padding-left: 3px;"/>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="bank_address" class="form-control" placeholder="Bank Address"></textarea>
                </div>
                </div>
                <div class="col-sm-4">
                <h4 style="text-decoration:underline;">Nominee</h4>
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
            </div>';
}else{
    $members = $mysqli->query("SELECT ipo_id, personal_full_name, card_number from ipo_member_directory");
    $html = '<input type="hidden" id="personal_phone_number">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>IPO memebr card number</label>
                    <select name="existing_member" class="form-control select2" onchange="get_card_number(this.value)">
                        <option value="">Select card number</option>';
    while($member = mysqli_fetch_assoc($members)){
        $html .= '<option value="'.$member['ipo_id'].'~'.$member['personal_full_name'].'">'.$member['card_number'].'</option>';
    }
    $html .= '</select></div></div>';
}
echo $html;

