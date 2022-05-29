<style>
    .load-more-button{
        padding-bottom: 25px;
        padding-top: 25px;
        /* background-color: white; */
        background-image: linear-gradient(to bottom, transparent, rgba(224, 224, 224, 1));
    }
    .search {
        border-radius: 30px;
        border-color: #ffffff;
    }
    .round{
        border-radius: 50%;
    }
    /* .counter{
        width: 50%;
    } */
    .button-rounded-54 {
        height: 54px;
        width: 54px;
        line-height: 50px;
        vertical-align: middle;
        text-align: center;
        padding: 0;
        border-radius: 28px;
    }

    .button-rounded-36 {
        height: 36px;
        width: 36px;
        line-height: 32px;
        vertical-align: middle;
        text-align: center;
        padding: 0;
        border-radius: 28px;
    }

    .button-rounded-26 {
        height: 26px;
        width: 26px;
        line-height: 22px;
        vertical-align: middle;
        text-align: center;
        padding: 0;
        border-radius: 13px;
    }
    .cart-table{
        margin: 0;
        padding: 0;
    }
    .cart-dropdown{
        margin: 0;
        padding: 0;
        left: -350px;
    }
    .dropdown-table{
        width: 650px 
    }    
    .span-custom{
        color: black;
    }
    p{
        margin-top: 0;
        margin-bottom: 0;
    }
    .bought{
        background-color: #81c784;
        transition: 1s;
    }
    .card{
        transition: 1s;
        border-radius: 15px;
    }
    ul{
        list-style-type: none;
    }
    .show-department-filters{
        border: none;
        background-color: inherit;
        outline: none;
    }
    .show-department-filters:focus {
        outline: none;
    }
    .button-counter.left{
        border-radius: 5px 0px 0px 5px;
    }
    .button-counter.right{
        border-radius: 0px 5px 5px 0px;
    }
    .input-counter{
        border-left: 0;
        border-right: 0;
        border-radius: 0;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
    #hider
    {
        position:absolute;
        z-index: 0;
        top: 0%;
        left: 0%;
        width:100%;
        height:100%;
        background-color:Black;
        /* transition: opacity 0.3s; */
    }
    #hider.show-hider{
        background-color: rgba(0,0,0,0);
        /* opacity:0.0; */
        /* z-index: 0; */
    }
    #hider.blur-hider{
        background-color: rgba(0,0,0,0.5);
        z-index: 1000;
    }
    .cart-sepecification{
        border-radius: 3px;
        position: fixed;
        margin-top: -150px;
        right: 0%;
        width: 40%;
        background-color: white;
        z-index: 1001; 
        overflow: hidden !important;
        transform: translate(100%, 0px);
        transition: 1s ease;
    }
    .slider-image{
        border-radius: 3px;
    }
    
    .cart-sepecification.show{
        transform: translate(0px, 0px);
    }
    
    .regular-checkbox {
        -webkit-appearance: none;
        background-color: #fafafa;
        border: 1px solid #cacece;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
        padding: 9px !important;
        border-radius: 3px;
        display: inline-block;
        position: relative;
    }
    .regular-checkbox:active, .regular-checkbox:checked:active {
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
    }

    .regular-checkbox:checked {
        background-color: #a5d6a7;
        border: 1px solid #adb8c0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1);
        color: #99a1a7;
    }
    .regular-checkbox:checked:after {
        content: '\2714';
        font-size: 14px;
        position: absolute;
        top: -1px;
        left: 0px;
        color: #a5d6a7;
    }
    .cart-option-label{
        position: absolute;
        top: -2px;
        left: 35px;
        font-weight: 500 !important;
    }
    .regular-radio {
        -webkit-appearance: none;
        background-color: #fafafa;
        border: 1px solid #cacece;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05);
        padding: 9px !important;
        border-radius: 50px;
        display: inline-block;
        position: relative;
    }

    .regular-radio:checked:after {
        content: ' ';
        width: 12px;
        height: 12px;
        border-radius: 50px;
        position: absolute;
        top: 3px;
        background: #99a1a7;
        box-shadow: inset 0px 0px 10px rgba(0,0,0,0.3);
        text-shadow: 0px;
        left: 3px;
        font-size: 32px;
    }

    .regular-radio:checked {
        background-color: #e9ecee;
        color: #99a1a7;
        border: 1px solid #adb8c0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px -15px 10px -12px rgba(0,0,0,0.05), inset 15px 10px -12px rgba(255,255,255,0.1), inset 0px 0px 10px rgba(0,0,0,0.1);
    }

    .regular-radio:active, .regular-radio:checked:active {
        box-shadow: 0 1px 2px rgba(0,0,0,0.05), inset 0px 1px 3px rgba(0,0,0,0.1);
    }
    .cart-slider{
        /* display: none; */
        position: fixed;
        height: 100%;
        background-color: rgba(245, 245, 245, 0.8);
        /* opacity: 0.9; */
        width: 50%;
        transform: translateX(100%);
        top: 0;
        right: 0;
        z-index: 1001;
        transition: 700ms;
        /* overflow-x: hidden; */
    }
    .cart-slider .card-body{
        padding: 5px;
    }
    .cart-slider .card{
        border-radius: 3px;
        margin-top: 5%;
        margin-bottom: 5%;
        margin-left: 2%;
        margin-right: 1%;
        max-height: 600px;
        overflow-y: scroll;
    }
    .hr-custom{
        margin: 5px;
    }
    ul{
        margin-bottom: 0px;
    }
    .gray-text{
        color: gray;
    }
    .product-cart{
        padding: 5px;
        margin: 5px;
        border: 1px solid #c0c0c0;
        border-radius: 3px;
    }

    .cart-slider .card{
        z-index: 1002;
    }

    .cart-slider.show{
        transform: translateX(0%);
    }
    .cart-slider-header{
        height: 50px;
        background-color: white;
    }

    .btn-group{
        width: 40%;
    }

    .type-change{
        position: fixed;
        top: 40%;
        left: 45%;
        z-index: 1001;
        background-color: rgba(232, 245, 233, 0.9);
        border: 1px solid gray;
        border-radius: 10px;
        padding: 30px;
        transition: opacity 200ms;    
    }
    .type-change.show{
        z-index: 0;
        opacity: 0;
    }
    .type-text{
        margin-bottom: 30px;
        font-size: 35px;
    }
    .col-sm-xs{
        flex: 0 0 4.333333%;
        max-width: 4.333333%;
    }
    .products-div.slide{
        transform: translateX(-100%);
    }
    @media only screen and (max-width: 600px) {
        .cart-sepecification{
            overflow: scroll !important;
            max-height: 650px;
            bottom: 5%;
            width: 80%;
        }
        .cart-slider{
            width: 80%;
        }
        .btn-group{
            width: 60%;
        }
        .type-change{
            width: 350px;
            left: 3%;
        }
        .type-text{
            font-size: 25px;
        }
    }
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark"><?php echo (isset($purchase_order)) ? 'Product Order' : 'Product Requisition'; ?></h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">SCM</a></li>
						<li class="breadcrumb-item active"><?php echo (isset($purchase_order)) ? 'Product Order' : 'Product Requisition'; ?></li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	
	<div class="content">
        <input type="hidden" name="type" id="type" value="<?php echo $type?>">
        <div class="show-hider" id="hider"></div>
        <div class="type-change show">
            <!-- <form action="" id="type_change"> -->
                <div class="row justify-content-center">
                    <div class="col-md-12 col-12">
                        <p class="text-center type-text">Change Product Type!!!</p>
                    </div>
                    <div class="col-md-3 col-5">
                        <button style="width: 100px;" class="btn btn-sm btn-success shadow-sm" name="yes" id="yes" value="yes" onclick="change_type()">Yes</button>
                    </div>
                    <div class="col-md-3 col-5">
                        <button style="width: 100px;" class="btn btn-sm btn-danger shadow-sm" name="no" id="no" value="no" onclick="hide_cart_slider()">No</button>
                    </div>
                </div>
            <!-- </form> -->
        </div>
        <div class="cart-slider" id="cart_slider">
            <div class="cart-slider-header text-center"> <h4 class="pt-1">This is your Cart <span style="float: right;font-size: 1rem;padding-right: 5px;cursor: pointer;" onclick="hide_cart_slider()">Close</span> </h4></div>
            <form method="POST" id="cart_finalize_form">
                <div class="row">
                    <div class="col-lg-12 products-div">
                        <div class="card">
                            <div class="card-body" id="cart_slider_body">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div id="cart_slider_button">
                </div>
            </form>
        </div>
        <div class="cart-sepecification" id="cart_sepecification"></div>
        <input type="hidden" id="scm_purchase_order" value="<?php echo (isset($purchase_order)) ? 'yes' : 'no'; ?>">
        <div class="cart">
            <div class="row justify-content-center row-body">            
                <div class="col-md-10 col-8">
                    <form action="<?php base_url('admin/scm/product-requisition'); ?>">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-center">
                                <div class="col-md-5 col-8">
                                    <input name="product_name_search" id="product_name_search" type="search" class="form-control form-control-lg search my-3" placeholder="Type product name" value="<?php if(isset($search_text)){ echo $search_text; }?>">
                                </div>
                                <div class="col-md-1 col-2">
                                    <button name="product_search" type="submit" class="form-control form-control my-3 rounded-circle" style="height:47px;width:47px;"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-4 align-self-center">                
                    <div class="dropdown">
                        <button type="button" id="ipo_cart_dropdown" class="btn btn-default" onclick="show_cart_slider()">
                            <span class="text-default" id="cart_count" style="font-size: 20px;"></span>
                            <i class="fas fa-shopping-cart search"></i>
                        </button>
                        <div class="dropdown-menu cart-dropdown" aria-labelledby="ipo_cart_dropdown" id="cart_dropdown" style="max-height:400px;overflow-y:scroll;">
                        </div>
                    </div>
                </div>
                <div class="col-md-2 p-2">
                    <?php if(isset($department_filter)){ ?><button name="apply" class="btn btn-sm btn-info mb-2 mr-2">Apply Filter</button><button name="clear_department" value="clear_department" class="btn btn-sm btn-primary mb-2">Clear Filter</button><?php }else{ ?><button name="apply" class="btn btn-sm btn-info mb-2">Apply Filter</button><?php } ?>
                    <div class="row justify-content-between border">
                        <div class="col-sm-6 col-6">
                            <p class="font-weight-bold">Departments</p>
                        </div>
                        <div class="col-sm-2 col-2">
                            <button class="show-department-filters" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="true" aria-controls="multiCollapseExample1" id="department_filter_button"><i id="department_filter_icon" class="fa <?php echo (isset($department_filter)) ? 'fa-minus' : 'fa-plus'; ?>" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="row sub-filter border">
                        <div class="col">
                            <?php if(isset($department_filter)){ ?>
                            <div class="collapse show" id="multiCollapseExample1"><?php }else{ ?>
                                <div class="collapse" id="multiCollapseExample1"><?php } ?>                            
                                    <ul>
                                        <?php foreach($departments as $department){ ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-2 col-2">
                                                        <div class="form-check">
                                                            <?php if(isset($department_filter)){ ?>
                                                                <?php if(in_array($department->department_id, $department_filter)){ ?>
                                                                    <input name="department_id[]" class="form-check-input regular-checkbox" type="checkbox" value="<?php echo $department->department_id; ?>" checked>
                                                                <?php }else{ ?>
                                                                    <input name="department_id[]" class="form-check-input regular-checkbox" type="checkbox" value="<?php echo $department->department_id; ?>">
                                                                <?php } ?>
                                                            <?php }else{ ?>
                                                                <input name="department_id[]" class="form-check-input regular-checkbox" type="checkbox" value="<?php echo $department->department_id; ?>">
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10 col-10">
                                                        <?php echo $department->department_name; ?>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
</form>
                    </div>
                    <div class="col-md-10">
                        <?php if(empty($products)){ ?>
                            <p class="font-weight-bold text-center mt-4">No Product Found</p>
                        <?php }else{ ?>
                            <div class="row" id="product_div">
                                <?php foreach($products as $product){ ?>
                                    <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                                        <div class="card text-center product-div-<?php echo $product->id;?>" style="height: 280px;">
                                            <div class="card-body">
                                                <input type="hidden" id="product_department_<?php echo $product->id?>" value="<?php echo rahat_encode($product->department_id);?>">
                                                <img src="<?php echo base_url($product->product_image)?>" style="width:80px;height:80px;"/>
                                                <p id="product_info_<?php echo $product->id; ?>"><?php echo (is_null($product->brand_name)) ? $product->product_name : $product->brand_name . ' - ' .$product->product_name ; ?></p>
                                                <small> in <span id="scale_info_<?php echo $product->id; ?>"><?php echo $product->scale_name; ?></span> </small>
                                                <small> ( <?php echo $product->department_name; ?> ) </small>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-8">
                                                        <div class="row justify-content-center">
                                                            <div class="btn-group" role="group" aria-label="Basic example" style="width: 95% !important;">
                                                                <button style="height: 85% !important;" type="button" class="button-counter left btn btn-default btn-sm" onclick="minus_number(<?php echo $product->id; ?>)"><i class="fas fa-minus span-custom"></i></button>
                                                                <input style="height: 85% !important;" type="number" name="product_<?php echo $product->id;?>" id="product_<?php echo $product->id;?>" class="form-control input-counter counter" placeholder="0" value="0" min="0">
                                                                <button style="height: 85% !important;" type="button" class="button-counter right btn btn-default btn-sm" onclick="add_number(<?php echo $product->id; ?>)"><i class="fas fa-plus span-custom"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-10 mt-2">
                                                        <abbr title="Add to Cart"><button type="button" class="btn btn-default shadow-sm float-bottom-right" value="<?php echo $product->id;?>" onclick="show_slider(this.value)"><span class="mr-1">Add to cart</span><i class="fas fa-cart-plus"></i></button></abbr>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>                        
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row load-more-button">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    <div class="row justify-content-center">
                        <button id="product_offset" value="18" class="btn btn=lg btn-info" onclick="get_more_product(this.value)">LOAD MORE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->
<script>
    let get_more_product = (offset) => {
        let departments = $("input[name='department_id[]']:checked")
				.map(function(){return $(this).val();}).get();
        let product_name_search = $('#product_name_search').val();
        let type = $('#type').val();
        // console.log(departments);
        $.ajax({
            type: 'get',
            data: {offset, departments, product_name_search, type},
            url:"<?=base_url()?>assets/ajax/scm/load_more_product.php",
            success: function (data) {
                let info = JSON.parse(data);
                $('#product_div').append(info.html);
                $('#product_offset').val(info.offset);
            }
        });
    }
    $('#cart_finalize_form').submit( function (event) {
        if($("#recipient_type").length != 0) {            
            event.preventDefault();
            let branch_for_department = $('#branch_for_department').val();
            let recipient_type = $('#recipient_type').val();
            let recipient_type_desc = $('#recepient_type_desc').val();
            $.ajax({
                type: 'post',
                data: {recipient_type, recipient_type_desc, branch_for_department},
                url:"<?=base_url()?>assets/ajax/scm/validate_room_employee.php",
                success: function (data) {
                    let info = JSON.parse(data);
                    if(info.error === 'yes'){
                        $('#recepient_type_desc').addClass('border border-danger');
                        $('#recipient_type_error').show();
                        $('#error_message').html(info.error_msg);
                        return false;                        
                    }else{
                        event.currentTarget.submit();
                    }
                }
            });
        }
                
    })
    document.getElementById("product_name_search").addEventListener("search", function(event) {
        var current_url = location.href.split('?');

    //     // $(".resultingarticles").empty();
        // console.log($("#product_name_search").val());
        if($("#product_name_search").val() == ''){
            window.location.href = current_url[0];
        }
    });
    function get_recipient_type(type){
        if(type == 'own'){
            $('#recipient_type_div').html('');
        }else{
            var input = document.createElement("INPUT");
            input.setAttribute("class", "form-control");
            input.setAttribute("name", "recepient_type_desc");
            input.setAttribute("id", "recepient_type_desc");
            input.setAttribute("required", "true");
            if(type == 'room'){
                input.setAttribute("type", "text");
                input.setAttribute("placeholder", "Enter Room Number.");
            }else if(type == 'employee'){
                input.setAttribute("type", "number");
                input.setAttribute("placeholder", "Enter Employee Id.");
            }
            $('#recipient_type_div').html(input);
        }
    }
    function goToNextStepRequisition() {
        $.ajax({
            type: 'post',
            url:"<?=base_url()?>assets/ajax/scm/go_to_next_step_requisition.php",
            success: function (data) {
                let info = JSON.parse(data)
                $('#cart_slider_body').html(info.html);
                $('#cart_slider_button').html(info.button);
                $('#cart_finalize_form').attr('action', info.action);
                $('.select2').select2();
            }
        });
    }
    function goToPreviousStep() {
        let scm_purchase_order = $('#scm_purchase_order').val();
        $.ajax({
            type: 'post',
            data: { scm_purchase_order: scm_purchase_order},
            url:"<?=base_url()?>assets/ajax/scm/adjust_scm_cart.php",
            success: function (data) {
                info = JSON.parse(data);
                $('#cart_slider_body').html(info.html);
                $('#cart_slider_button').html(info.button);
                $('#cart_count').html(info.count);
            }
        });
    }
    function goToNextStep() {
        $.ajax({
            type: 'post',
            url:"<?=base_url()?>assets/ajax/scm/go_to_next_step.php",
            success: function (data) {
                let info = JSON.parse(data)
                $('#cart_slider_body').html(info.html);
                $('#cart_slider_button').html(info.button);
                $('#cart_finalize_form').attr('action', info.action);
                $('.select2').select2();
            }
        });
    }
    function bypass_warehouse_div() {
        let bypass = $("input[name='bypass_warehouse']:checked").val();
        if(bypass === 'bypass-warehouse'){
            $.ajax({
                type: 'post',
                url:"<?=base_url()?>assets/ajax/scm/get_sub_warehouse.php",
                success: function (data) {
                    $('#bypass_data').html(data);
                    $('.select2').select2();
                }
            });
        }else{
            $('#bypass_data').html('');
        }
    }

    function change_type() {
        $.ajax({
            type: 'post',
            url:"<?=base_url()?>assets/ajax/scm/change_product_type.php",
            success: function (data) {
                location.reload();
            }
        });
    }
    function update_cart_amount(idx) {
        let amount = $('#product_cart_' + idx).val();
        let scm_purchase_order = $('#scm_purchase_order').val();
        $.ajax({
            type: 'post',
            data: {updated_amount: amount, idx:idx, update_cart_amount:'yes', scm_purchase_order: scm_purchase_order},
            url:"<?=base_url()?>assets/ajax/scm/adjust_scm_cart.php",
            success: function (data) {
                info = JSON.parse(data);
                $('#cart_slider_body').html(info.html);
                $('#cart_slider_button').html(info.button);
                $('#cart_count').html(info.count);
			    $('#ipo_cart_dropdown').click();
            }
        });
    }

    function show_cart_slider() {
        $('#hider').addClass('blur-hider');
        $('#hider').removeClass('show-hider');
        $('#cart_slider').addClass('show');
        document.getElementById("hider").addEventListener("click", hide_cart_slider);
    }

    function hide_cart_slider() {
        document.getElementById("hider").removeEventListener("click", hide_cart_slider);
        console.log('hider');
        $('#hider').addClass('show-hider');
        $('#hider').removeClass('blur-hider');
        $('.cart-sepecification').removeClass('show');
        $('#cart_slider').removeClass('show');
        $('.type-change').addClass('show');
        // setTimeout(function () {
        //     $('#cart_sepecification').html('');
        // }, 50)
    }
    $('input[name="department_id"]').change(function () {
        if(this.checked) {
            console.log(this.value);
        }
    });
    function add_number(product_id) {
        // console.log(product_id);
        $('#product_' + product_id).val(parseInt($('#product_' + product_id).val()) + 1 );
        $('#product_' + product_id).change();
        // update_cart_amount();
    }
    function minus_number(product_id) {
        if($('#product_' + product_id).val() > 0){
            $('#product_' + product_id).val(parseInt($('#product_' + product_id).val()) - 1 );
            $('#product_' + product_id).change();
        }
    }
    function show_slider(product_id) {  
        product_amount = $('#product_' + product_id).val();
        if(product_amount != 0){
            $.ajax({
                type: 'post',
                data: {product_id, product_amount},
                url:"<?=base_url()?>assets/ajax/scm/get_cart_slider.php",
                success: function (data) {
                    data = JSON.parse(data);
                    if(data.html != 'no_options'){
                        $('#hider').removeClass('show-hider');
                        $('#hider').addClass('blur-hider');
                        $('#cart_sepecification').html(data.html);
                        $('.cart-sepecification').addClass('show');
                        document.getElementById("hider").addEventListener("click", hide_cart_slider);
                    }else{
                        add_to_cart(product_id, data.product_category, 'no_options');
                    }
                }
            });
        }else{            
            $('#toast').html(alert_body('warning', "Select atleast one amount"))
            trigger_alert();
        }
    }

    
    function add_to_cart(product_id, product_category = '', options) {
        if(options == 'no_options'){
			
		}else{
			 event.preventDefault();
		}
        let product_amount = $('#product_' + product_id).val();
        let type = $('#type').val();
        if(product_amount != 0){
            var form = $('#add_product_to_cart').serialize();
            console.log(form);
            let product_color = '';
            let product_size = '';
            let extra_measurement = '';
            if(options != 'no_options'){
                product_color = ( $("input[name='product_color']:checked").val() === undefined ) ? '' : $("input[name='product_color']:checked").val() ;
                product_size = ( $("input[name='product_size']:checked").val() === undefined ) ? '' : $("input[name='product_size']:checked").val() ;
            }else{
                form = 'product_id=' + product_id + '&cart_add=yes' + '&product_category=' + product_category;
            }
            let scm_purchase_order = $('#scm_purchase_order').val();
            let product_info = $('#product_info_' + product_id).html();
            let scale_info = $('#scale_info_' + product_id).html();
            let product_department = $('#product_department_' + product_id).val();
            let append_info = '&product_amount='+ product_amount + '&product_info=' + product_info + '&scale_info=' + scale_info + '&product_color=' + product_color + '&product_size=' + product_size + '&scm_purchase_order=' + scm_purchase_order + '&type=' + type + '&product_department=' + product_department;
            $.ajax({
                type: 'post',
                data: form + append_info,
                url:"<?=base_url()?>assets/ajax/scm/adjust_scm_cart.php",
                success: function (data) {
                    info = JSON.parse(data);
                    if(info.error === 'no'){
                        $('#cart_slider_body').html(info.html);
                        $('#cart_slider_button').html(info.button);
                        $('#cart_count').html(info.count);
                        $('#product_' + product_id).val('0')
                        $('.product-div-' + product_id).addClass('bought');
                        setTimeout(function () {
                            $('.product-div-' + product_id).removeClass('bought');
                        }, 700)
                    }else{
                        $('#hider').removeClass('show-hider');
                        $('#hider').addClass('blur-hider');
                        $('.type-change').removeClass('show');
                        document.getElementById("hider").addEventListener("click", hide_cart_slider);
                    }                    
                }
            });
            hide_cart_slider();
        }else{
            alert("Select atleast one amount");
        }        
    }
    function remove_from_cart(idx) {
        let scm_purchase_order = $('#scm_purchase_order').val();
        $.ajax({
            type: 'post',
            data: {idx:idx, remove_from_cart:'yes', scm_purchase_order: scm_purchase_order},
            url:"<?=base_url()?>assets/ajax/scm/adjust_scm_cart.php",
            success: function (data) {
                info = JSON.parse(data);
                $('#cart_slider_body').html(info.html);
                $('#cart_slider_button').html(info.button);
                $('#cart_count').html(info.count);
			    $('#ipo_cart_dropdown').click();
            }
        });
    }
    $('#department_filter_button').on('click', function () {
        if($('#department_filter_icon').hasClass('fa-plus')){
            $('#department_filter_icon').removeClass('fa-plus');
            $('#department_filter_icon').addClass('fa-minus');
        }else{            
            $('#department_filter_icon').addClass('fa-plus');
            $('#department_filter_icon').removeClass('fa-minus');
        }
    });
    $(document).ready(function () {
        let scm_purchase_order = $('#scm_purchase_order').val();
        $.ajax({
            type: 'post',
            data: { scm_purchase_order: scm_purchase_order},
            url:"<?=base_url()?>assets/ajax/scm/adjust_scm_cart.php",
            success: function (data) {
                info = JSON.parse(data);
                $('#cart_slider_body').html(info.html);
                $('#cart_slider_button').html(info.button);
                $('#cart_count').html(info.count);
            }
        });
    });
</script>