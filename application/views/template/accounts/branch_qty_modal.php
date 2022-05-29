<?php //$branche=$mysqli->query("SELECT branch_id,branch_name FROM  branches");
//print_r($branche);
?>
<form class="" id="myform" action="" method="POST">
    <table id="branchTable" class="branchTable">
        <?php if (!empty($branch_data)) {
            $branch_data=json_decode($branch_data);  
            foreach($branch_data as $br_data):
        ?>
            <tr class="form-row" id="form_row">
                <td class="col">
                    <select name="branches[]" id="" class="form-control" onchange="check_branch(this.value,this)" required>
                        <option value="">-- select branch --</option>
                        <?php foreach ($branche as $branc): ?>
                            <option value="<?= $branc->branch_id ?>" <?= $br_data->bid==$branc->branch_id ? 'selected' : '' ?>><?= $branc->branch_name ?></option>
                        <?php endforeach; ?> 
                    </select>
                </td>
                <td class="col">
                    <input type="number" oninput="checkQty()"  class="bqty form-control shadow number_int" value="<?= $br_data->qt ? $br_data->qt : '' ?>" name="qtys[]" placeholder="quantity" required>
                </td>
                <td class="col"><button type="button" class="btn btn-danger deleteTr"><i class="fas fa-trash-alt"></i></button></td>
            </tr>
        <?php endforeach; }else{ ?>
            <tr class="form-row" id="">
                <td class="col">
                    <select name="branches[]" id="xyx[]" class="form-control" onchange="check_branch(this.value,this)" required>
                        <option value="">-- select branch --</option>
                        <?php foreach ($branche as $branc): ?>
                            <option value="<?= $branc->branch_id ?>"><?= $branc->branch_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class="col">
                    <input type="number" oninput="checkQty()"  class="bqty form-control shadow number_int" name="qtys[]" placeholder="quantity" required>
                </td>
                <td class="col">
                <button type="button" id="add" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                </td>
            </tr>
        <?php } ?>
    </table>
    
    <small id="emailHelp" class="form-text text-muted mt-2">Branch item quntity must be equal to total qty.</small>
    <input type="hidden" id="branchid" value="<?=$ids?>">
    <input type="hidden" name="branch_qt" id="branch_qt" value="<?=$bqty ?>">
    <div class="modal-footer mt-3">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" id="branch_qty" class="btn btn-primary" disabled>Save</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $("#add").click(function(e){
            var x =`<tr class="form-row" id="form_row">
                <td class="col">
                    <select name="branches[]" id="xyx[]" class="form-control" onchange="check_branch(this.value,this)" required>
                        <option value="">-- select branch --</option>
                        <?php foreach ($branche as $branc): ?>
                            <option value="<?= $branc->branch_id ?>"><?= $branc->branch_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td class="col">
                    <input type="number" oninput="checkQty()"  class="bqty form-control shadow number_int" name="qtys[]" placeholder="quantity" required>
                </td>
                <td class="col">
                <button type="button" class="btn btn-danger deleteTr"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>`;
            $(x).clone().find("select").val("").end().appendTo("#branchTable");
            checkQty();
        });
    });

    var checkQty = function () {
        var qty = Number($('#branch_qt').val());

        var sum = 0;
        $('.bqty').each(function() {
            sum += Number($(this).val());
        });
        if (sum== qty) {
            $( "#branch_qty" ).prop( "disabled", false );
        }else{
            $( "#branch_qty" ).prop( "disabled", true );
        }
    };
    //  remove item row
    $('.branchTable').on('click','.deleteTr',function(){
        $(this).closest('tr').remove();
        checkQty();
    });
    //  for submit form with ajax
	$("#myform").on('submit',(function(e) {
		e.preventDefault();
        var branchid = $('#branchid').val();
        $("#"+branchid).prop('readonly', true);
        var qty = Number($('#branch_qt').val());
		$.ajax({
        	url: "<?= current_url();?>",
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(result)
		    {
				$("#myform")[0].reset();
                $("#branch_"+branchid).empty();
                $("#branch_"+branchid).append(result);
                $('.toast').toast('show');
                $('#myModal').modal('hide');
				// window.location.reload();
		    },
		  	error: function() 
	    	{
				window.location.reload();
	    	} 	        
	   	});
	}));

    // var check_val= [];
    function check_branch (val,thes) {
        // alert(xy);
        var check_val=[];
         var count=0;
        $('select[name="branches[]"]').each(function () {
            check_val.push($(this).val());
        })

        check_val.map(function(vals){
            vals==val ? ++count : '';
        })

        if (count>=2) {
            alert("Branch is alrady selected!");
            $(thes).prop('selectedIndex',0);  
        } 
    }
        
</script>