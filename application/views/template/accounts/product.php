<tr>
    <td class="p-1">
        <input type="hidden" name="items_id[]" class="form-control shadow-sm" id="selectItem_<?= $exp_type->items_id ?>" value="<?= $exp_type->items_id ?>">
        <input type="text" name="items_name[]" class="form-control shadow-sm" id="" value="<?= $exp_type->items_name ?>" readonly>
    </td>
    <td class="p-1"><input type="number" name='amount[]' id="price_<?= $exp_type->items_id ?>" class="number_int form-control shadow-sm" oninput="calculate()" required></td>
    <td class="p-1">
        <select name="unit_type[]" id="unit_type_<?= $exp_type->items_id ?>" class="form-control shadow-sm unit_type_class">
            <option value="">-- select one --</option>
            <?php if ($_SESSION['user_info'] ['department'] == '2270968637477766714') :?>
                <option value="" data-toggle="modal" data-target="#myModal" onclick="unitButton(this.parentNode.options.selectedIndex = 0)" class="bg-light" style="color:blue!important;">+ Add New</option>
            <?php endif; ?>
            <?php foreach ($unit_types as $unit_type): ?>
                <option value="<?= $unit_type->id ?>"><?= $unit_type->name ?></option>
            <?php endforeach; ?>
        </select>
    </td>
    <td class="p-1"><input type="number" name="qty[]" id="qty_<?= $exp_type->items_id ?>" class="form-control shadow-sm number_int" oninput="calculate()" required></td>
    <td class="p-1"><input type="number" name="sub_total[]" id="subtotal_<?= $exp_type->items_id ?>" class="form-control shadow-sm" id="singletotal" readonly></td>
    <td class="p-1">
        <div class="row border-0">
            <div class="col-sm-6">
                <select name="dis_rate[]" id="discountId_<?= $exp_type->items_id ?>" class="form-control shadow-sm dis_class" onchange="calculate()">
                    <option value="">-- select one --</option>
                    <?php if ($_SESSION['user_info'] ['department'] == '2270968637477766714') :?>
                        <option value="" data-toggle="modal" data-target="#myModal" onclick="discountButton(this.parentNode.options.selectedIndex = 0)" class="bg-light" style="color:blue!important;">+ Add New</option>
                    <?php endif; ?>
                    <?php foreach ($discount_rate as $dis_item): ?>
                        <option value="<?= $dis_item->discount_value.','.$dis_item->discount_type ?>"><?= $dis_item->discount_name ." "."($dis_item->discount_value)" ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-sm-6">
                <input type="number" id="disAmount_<?= $exp_type->items_id ?>" name="dis_amount[]" class="form-control" readonly>
            </div>
        </div>
        
    </td>
    <td class="p-1">
        <div class="row border-0">
            <div class="col-sm-6">
                <select name="tax_rate[]" id="taxId_<?= $exp_type->items_id ?>" class="form-control shadow-sm tax_class" onchange="calculate()">
                    <option value="">-- select one --</option>
                    <?php if ($_SESSION['user_info'] ['department'] == '2270968637477766714') :?>
                        <option value="gfg" data-toggle="modal" data-target="#myModal" onclick="taxButton(this.parentNode.options.selectedIndex = 0)" class="bg-light" style="color:blue!important;">+ Add New</option>
                    <?php endif; ?>
                    <?php foreach ($tax_rate as $tax_item): ?>
                        <option value="<?= $tax_item->tax_rate ?>"><?= "$tax_item->tax_name "."($tax_item->tax_rate %)"  ?></option>
                    <?php endforeach; ?>
                </select>
            </div>  
            <div class="col-sm-6">
                <input type="number"  id="taxAmount_<?= $exp_type->items_id ?>" name="tax_amount[]" class="form-control" readonly>
            </div>
        </div>
    </td>
    <td class="p-1">
        <input type="number" name="item_total[]" id="itemTotal_<?= $exp_type->items_id ?>" class="form-control shadow-sm" readonly>
    </td>
    <td class="p-1">
        <button type="button" onclick="branchButton('qty_<?= $exp_type->items_id ?>')" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fas fa-share-alt"></i></button>
    </td>
    <td class="p-1"><button type="button" onclick="setTimeout(calculate,200)" class="btn btn-danger removeTr"><i class="fas fa-trash-alt"></i></button></td>
    <td style="display:none;" id="branch_qty_<?= $exp_type->items_id ?>">
        <input type='hidden' name='branches[]'>
    </td>
</tr>

