
<style>
    input:read-only{
        border-width:0px;
        width:100%;
        border:none;
        outline:none;
        background-color:unset;
    }
    select{
        width:150px;
    }
</style>
<!-- table 3 -->
<div class="col-sm-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Transaction Approval Form</h3>
        </div>
        <div class="m-4" style="font-size: 18px;">
            <div style="display: grid;float:left;">
                <div style="grid-column-start: auto">
                    Trx ID: <?= $exp_info->trx_id ?>
                </div>
                <div style="grid-column-start: auto">
                    Ref#: <?= $exp_info->ref ?>
                </div>
                <div style="grid-column-start: auto">
                    Bill Date: <?= !empty($exp_info->bill_date)?date("d-m-Y",strtotime($exp_info->bill_date)):'' ?>
                </div>
                <div style="grid-column-start: auto">
                    Vendor: <?= $exp_info->company_name ?>
                </div>
                <div style="grid-column-start: auto">
                    Due Date: <?= !empty($exp_data->due_date)?date("Y-m-d",strtotime($exp_info->due_date)):'' ?>
                </div>
                <div style="grid-column-start: auto">
                    Employee Name: <?= $exp_info->emp_name ?>
                </div>
                <div style="grid-column-start: auto">
                    Employee ID & Designation: <?= $exp_info->created_by ?>
                </div>
                <div style="grid-column-start: auto">
                    Branch: <b style="color: blue;"><?= $exp_info->branch_name ?></b></p>
                </div>
            </div>
            <div style="width:30%;float:right;" class="mt-5">
                <img class="logo" src="<?php echo base_url(); ?>assets/img/neways.png" alt="" style="width:180px;">
            </div>
        </div>
        
        <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
            <form action="<?=current_url(); ?>" method="post" >
                <input type="hidden" name="trx_id" value="<?=$exp_info->trx_id?>">
                <input type="hidden" name="br_id" value="<?=$exp_info->branch_id?>">
                <input type="hidden" name="transit_ac" value="<?=$exp_info->transit_fee?>">
                <input type="hidden" name="care_of" value="<?=$exp_info->created_by?>">
                <input type="hidden" name="grand_tk" value="<?=$exp_info->grand_amount?>">
                <input type="hidden" name="vendor_nam" value="<?=$exp_info->company_name?>">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Account Type</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Cost center</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Unit Type</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Sub Total</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Tax</th>
                            <th scope="col">Net Amount</th>
                            <th scope="col">Dr.</th>
                            <th scope="col">Cr.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($items_info)) {
                            $subTotal=0;
                            $disTotal=0;
                            $taxTotal=0;
                            $netTotal=0;
                            foreach ($items_info as $key => $item) {
                               $pid=$item->item_id;
                               $subTotal+=$item->sub_total; 
                               $disTotal+=$item->discount_amount; 
                               $taxTotal+=$item->tax_amount; 
                               $netTotal+=$item->net_amount; 
                        ?>
                        <tr class="table-active">
                            <th scope="col"><?=$key+1?></th>
                            <td>
                                <select class="ac_approval" name="acount_head[<?=$key?>]" required>
                                    <option value=""></option>
                                    <?php
                                    // foreach ($account_type as $ac_head) {
                                    //     echo "<option value='$ac_head->id'>$ac_head->ac_name</option>";
                                    // }
                                    ?>
                                </select>  
                            </td>
                            <td>
                                <?=$item->item_name?>
                                <input type="hidden" name="item_s[<?=$key?>]" value='<?=$item->item_id?>' readonly>
                            </td>
                            <td>
                            <?php
                                $pro_id=array();
                                foreach ($branch_items as $ke => $branch_item) {
                                $pro_id[] = $branch_item->purchese_item_id;
                                }
                                if (!in_array($pid, $pro_id)) {
                                    echo "<input type='hidden' name='cost_center[$key][]' value='$exp_info->branch_id' >";
                                    echo "<input type='hidden' name='sub_tk[$key][]' value='$item->sub_total' >";
                                    echo "<input type='hidden' name='dis_tk[$key][]' value='$item->discount_amount' >";
                                    echo "<input type='hidden' name='tax_tk[$key][]' value='$item->tax_amount' >";
                                    echo "<input type='hidden' name='net_tk[$key][]' value='$item->net_amount' >";
                                }
                            ?>
                            </td>
                            <td><input type="text" value='<?=$item->unit_price?>' readonly></td>
                            <td><input type="text" value='<?=$item->unit_name?>' readonly></td>
                            <td><input type="text" value='<?=$item->qty?>' readonly></td>
                            <td><input type="text" value='<?=$item->sub_total?>' readonly></td>
                            <td><input type="text" value='<?=$item->discount_amount?>' readonly></td>
                            <td><input type="text" value='<?=$item->tax_amount?>' readonly></td>
                            <td><input type="text" value='<?=$item->net_amount?>' readonly></td>
                            <td><input type="text" value='<?=$item->net_amount?>' class="dtk" readonly></td>
                            <td></td>
                        </tr>
                        <?php
                                foreach ($branch_items as $i => $branch_item  ) {
                                    if ($pid==$branch_item->purchese_item_id) {
                        ?>
                                        <tr>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <input type="hidden" name="cost_center[<?=$key?>][]" value='<?=$branch_item->dis_branch_id?>'>
                                                <input type="text" name="" value='<?=$branch_item->br_name?>' readonly>
                                            </td>
                                            <td><input type="text" name="" value='<?=$branch_item->unit_price?>' readonly></td>
                                            <td><input type="text" name="" value='<?=$branch_item->unit_name?>' readonly></td>
                                            <td><input type="text" name="" value='<?=$branch_item->qty?>' readonly></td>
                                            <td><input type="text" name="sub_tk[<?=$key?>][]" value='<?=$branch_item->sub_total?>' readonly></td>
                                            <td><input type="text" name="dis_tk[<?=$key?>][]" value='<?=$branch_item->discount_amount?>' readonly></td>
                                            <td><input type="text" name="tax_tk[<?=$key?>][]" value='<?=$branch_item->tax_amount?>' readonly></td>
                                            <td><input type="text" name="net_tk[<?=$key?>][]" value='<?=$branch_item->net_amount?>' readonly></td>
                                        </tr>
                        <?php
                                    } 
                                }

                            }
                            echo "<tr><td colspan='6'></td><td>Total=</td><td>$subTotal</td><td>$disTotal</td><td>$taxTotal</td><td>$netTotal</td></tr>";
                        }
                        ?>
                    
                    </tbody>
                    <tr>
                        <td colspan="4">Other transaction info:</td>
                    </tr>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Account Type</th>
                            <th scope="col" colspan="8">Expense/income Name</th>
                            <th scope="col"></th>
                            <th scope="col">Dr.</th>
                            <th scope="col">Cr.</th>
                        </tr>
                    </thead>
                    <tbody class="thead-dark">
                        <?php if (!empty($exp_info->transit_fee) && $exp_info->transit_fee !=0) { ?>
                            <tr class="table-active">
                                <td scope="col"></td>
                                <td>
                                    <select name="transit_ac" class="ac_approval" required></select> 
                                </td>
                                <td scope="col" colspan="9">Transportaion Expense</td>
                                <td scope="col">
                                    <input type="text" name="transit_tk" value='<?=$exp_info->transit_fee?>' class="dtk" readonly>
                                </td>
                                <td scope="col"></td>
                            </tr>
                        <?php } ?>
                        <?php if (!empty($exp_info->fixed_tax) && $exp_info->fixed_tax !=0) { ?>
                            <tr class="table-active">
                                <td scope="col"></td>
                                <td>
                                    <select name="fixed_tax_ac" class="ac_approval" required></select> 
                                </td>
                                <td scope="col" colspan="9">Fixed Tax</td>
                                <td scope="col">
                                    <input type="text" name="fixed_tax_tk" value='<?=$exp_info->fixed_tax?>' class="dtk" readonly>
                                </td>
                                <td scope="col"></td>
                            </tr>
                        <?php } ?>
                        <?php if (!empty($exp_info->fixed_discount) && $exp_info->fixed_discount !=0) { ?>
                            <tr class="table-active">
                                <td scope="col"></td>
                                <td>
                                    <select name="fixed_discount_ac" class="ac_approval" required></select> 
                                </td>
                                <td scope="col" colspan="9">Fixed Discount</td>
                                <td scope="col"></td>
                                <td scope="col">
                                    <input type="text" name="fixed_discount_tk" value='<?=$exp_info->fixed_discount?>' class="ctk" readonly>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tr>
                        <td colspan="4">Payment information:</td>
                    </tr>
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Account Type</th>
                            <th scope="col" colspan="8">Payment Method</th>
                            <th scope="col"></th>
                            <th scope="col">Dr.</th>
                            <th scope="col">Cr.</th>
                        </tr>
                    </thead>
                    <tbody class="thead-dark">
                        <?php
                        if (!empty($payment_info)) {
                            foreach ($payment_info as $sl=> $payment) {
                        ?>
                        <tr>
                            <td scope="col"></td>
                            <td>
                                <select name="payment_ac[]" class="ac_approval" required>
                                    <?php
                                    // foreach ($account_type as $ac_head) {
                                    //     echo "<option value='$ac_head->id'>$ac_head->ac_name</option>";
                                    // }
                                    ?>
                                </select> 
                            </td>
                            <td scope="col" colspan="8"><input type="text" name="pay_method[]" value='<?=$payment->payment_method?>' readonly></td>
                            <td scope="col"></td>
                            <td scope="col"></td>
                            <?php
                            if (!empty($payment->card_amount)) {
                                echo "<td scope='col'><input type='text' name='payment_tk[]' value='$payment->card_amount' class='ctk' readonly></td>";
                            }elseif (!empty($payment->cash_amount)) {
                                echo "<td scope='col'><input type='text' name='payment_tk[]' value='$payment->cash_amount' class='ctk' readonly></td>";
                            }elseif (!empty($payment->mobile_amount)) {
                                echo "<td scope='col'><input type='text' name='payment_tk[]' value='$payment->mobile_amount' class='ctk' readonly></td>";
                            }elseif (!empty($payment->check_amount)) {
                                echo "<td scope='col'><input type='text' name='payment_tk[]' value='$payment->check_amount' class='ctk' readonly></td>";
                            }
                            ?>
                        </tr>
                        <?php }
                        }
                        if (!empty($exp_info->due_amount) &&  $exp_info->due_amount != 0) { 
                        ?>
                        <tr>
                            <td scope="col"></td>
                            <td>
                                <select name="due_ac" class="ac_approval" required>
                                    <?php
                                    // foreach ($account_type as $ac_head) {
                                    //     echo "<option value='$ac_head->id'>$ac_head->ac_name</option>";
                                    // }
                                    ?>
                                </select> 
                            </td>
                            <td scope="col" colspan="9">Payable Amount</td>
                            <td scope="col"></td>
                            <td scope="col">
                                <input type="text" name="due_tk" value='<?=$exp_info->due_amount?>' class="ctk" readonly>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php
                        if (!empty($exp_info->adjust_status) && $exp_info->adjust_status != '0') { 
                        ?>
                        <tr>
                            <td scope="col"></td>
                            <td>
                                <select name="adjust_ac" class="ac_approval" required>
                                    <?php
                                    // foreach ($account_type as $ac_head) {
                                    //     echo "<option value='$ac_head->id'>$ac_head->ac_name</option>";
                                    // }
                                    ?>
                                </select> 
                            </td>
                            <td scope="col" colspan="9"><?=$exp_info->adjust_status == '1'?'Advance cash ('.$exp_info->emp_name.')':'Petty cash ('.$exp_info->branch_name.')';?></td>
                            <td scope="col"><input type="hidden" name="adjust_type" value="<?=$exp_info->adjust_status?>"></td>
                            <td scope="col">
                                <input type="text" name="adjust_tk" value='<?=$exp_info->grand_amount?>' class="ctk" readonly>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr class="font-weight-bolder">
                            <td colspan="10"></td>
                            <td >Balance</td>
                            <td id="dtotal"></td>
                            <td id="ctotal"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="mx-auto" style="width: 200px;">
                    <button type="submit" class="btn btn-primary mr-2" name="approve" onclick="return confirm('Are you confirm to approve?')">Approve</button>
                    <button type="submit" class="btn btn-danger" name="reject" onclick="return confirm('Are you confirm to reject?')">Reject</button>
                </div> 
            </form>
        </div>
    </div>
</div>	
