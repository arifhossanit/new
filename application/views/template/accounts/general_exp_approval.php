
<style>  
    /* ul{  
        background-color:#eee;  
        cursor:pointer;  
    }  
    li{  
        padding:12px;  
    }   */
</style>

<!----End edit product type modal-->
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h2 class="m-0 text-dark">General Expense Approval</h2>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Accounts</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Approval</a></li>
						<li class="breadcrumb-item active">Expense aprroval</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>

	<div class="content">
		<div class="container">
            <div class="mx-5 pb-3">
                <form action="" method="post" class="row px-3" id="findInvoice">
                    <!-- <input type="text" name="trx_id" id="trxId" class="form-control col-10" placeholder="Enter Country Name"/> -->
                    <select class="trx_find form-control col-10" name="find_trx" id="trxId" required>
                        <option value="">select</option>
                    </select> 
                    <button type="submit" class="btn btn-primary col-2" onclick="sumOfDc()">Find</button>
                    <div id="countryList" class="col-10"></div>
                </form>
            </div>
        </div>
    </div>

    <section class="footer-class py-3 m-auto" style="width:90%;">
        <div class="containe trx_rexult">
        </div>
    </section>
</div>



  <script>

    function select2fun () {
        $('.ac_approval').select2({
            // allowClear: true,
            placeholder: 'Select AC Type',
            minimumInputLength:2,
            ajax: {
                url: "<?= current_url()?>",
                dataType: 'json',
                type: "GET",
                delay:250,
                data: function (params) {
                    return{
                        select_query:params.term,
                    };
                },
                processResults:function (data) {
                    return{
                        results:data,
                    };
                },
                cache:true 
                // Additional AJAX parameters go here;
            }
        });
    };

    //sum of all debit/credit class name in jquery
    function sumOfDc() {
        var dsum = 0;
        var csum = 0;
        setTimeout(function() {
            $('.dtk').each(function() {
                dsum += parseFloat($(this).val());
            });
            $('#dtotal').text(dsum+' Tk');
            $('.ctk').each(function() {
                csum += parseFloat($(this).val());
            });
            $('#ctotal').text(csum+' Tk');
        }, 3000);
    }

    //   $(document).ready(function(){  
    //     $('#trxId').keyup(function(){  
    //         var query = $(this).val();  
    //         if(query != '')  
    //         {  
    //             $.ajax({  
    //                 url: "<?= base_url("admin/general-expense-approval")?>",  
    //                 method:"POST",  
    //                 data:{query:query},  
    //                 success:function(data)  
    //                 {  
    //                     $('#countryList').fadeIn();  
    //                     $('#countryList').html(data);  
    //                 }  
    //             });  
    //         }  
    //     });  
    //     $(document).on('click', 'li', function(){  
    //         $('#trxId').val($(this).text());  
    //         $('#countryList').fadeOut();  
    //     });  
    //  });  

    // function findTrx(){
    //     var query=$('#trxId').val();
    //     $.ajax({  
    //             url: "<?= base_url("admin/general-expense-approval")?>",  
    //             method:"POST",  
    //             data:{find_trx:query},  
    //             success:function(data)  
    //             {  
    //                 $('#countryList').fadeOut();  
    //                 $('.trx_rexult').html(data);
    //                 // select2fun ();  
    //             }  
    //         });  
    // }

      $("#findInvoice").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
        url: "<?= base_url('admin/general-expense-approval')?>",
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(result)
		    {
				$('#countryList').fadeOut();  
                $('.trx_rexult').html(result);
				select2fun ();
		    },
		  	error: function() 
	    	{
				window.location.reload();
	    	} 	        
	   	});
	}));

    window.onpageshow = function () {
        $('.trx_find').select2({
            // allowClear: true,
            placeholder: 'Select a Trx Id',
            minimumInputLength:2,
            ajax: {
                url: "<?= current_url()?>",
                dataType: 'json',
                type: "POST",
                delay:200,
                data: function (params) {
                    return{
                        query:params.term,
                    };
                },
                processResults:function (data) {
                    return{
                        results:data,
                    };
                },
                cache:true 
                // Additional AJAX parameters go here;  see the end of this chapter for the full code of this example
            }
        });
    };
  </script>    

<script>
    // $(document).ready( function () {
    //     $('#myTable').DataTable();
    // } );
    // function exp_detail(trxId) {
    //     $.ajax({
    //         url: "<?=current_url()?>",
    //         dataType: "HTML",
    //         type: "POST",
    //         async: true,
    //         data: {"exp_id":trxId},
    //         success: function (data) {
    //             $("#modalData").html(data);
    //         }
    //     })
    // }

    
</script>
<script type="text/javascript" src="<?= base_url('/assets/js/accounts/ac_scripts.js'); ?>"></script>
<script type="text/javascript" src="<?= base_url('/assets/js/accounts/single_scripts.js'); ?>"></script>