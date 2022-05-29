<style>
    /* vertical scrollbar for table */
	.my-custom-scrollbar {
	position: relative;
	max-height: 70vh;
	overflow: auto;
	}
	.table-wrapper-scroll-y {
	display: block;
	}
</style>
<div class="content-wrapper">
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Urgent Transaction (Buy Something)</h1>
				</div> 
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Front Office</a></li>
						<li class="breadcrumb-item active">Urgent Transaction (Buy Something)</li>
					</ol>
				</div> 
			</div> 
		</div> 
    </div>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#taxModal" style="float:right;">
                    <i class="far fa-money-bill-alt"></i> &nbsp;Add Tax
                </button>
			</div>
			<div class="col-md-6">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#discountModal">
                    <i class="fas fa-receipt"></i> &nbsp;Add Discount
                </button>
			</div>

            <!-- table 1 -->
            <div class="col-sm-6 mt-5">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Tax list</h3>
                    </div>
                    <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-striped table-bordered table-sm small display">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            
                            <tbody id='tdata'>
                                <?php foreach($taxes as $key=>$tax): ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $tax->tax_name; ?></td>
                                        <td><?php echo $tax->tax_rate; ?></td>
                                        <td class="d-flex">
                                            <!-- Button trigger modal for veiw -->
                                            <form action="<?=current_url();?>" method="post">
                                                <input type="hidden" name="tax_del" value="<?php echo $tax->id; ?>">
                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- table 2 -->
            <div class="col-sm-6 mt-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Discount chart</h3>
                    </div>
                    <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-striped table-bordered table-sm small display">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Rate/Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id='tdata'>
                                <?php foreach($discounts as $key=>$discount): ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $discount->discount_name; ?></td>
                                        <td><?php echo $discount->discount_type; ?></td>
                                        <td><?php echo $discount->discount_value; ?></td>
                                        <td class="d-flex">
                                            <!-- Button trigger modal for veiw -->
                                            <form action="<?=current_url();?>" method="post">
                                                <input type="hidden" name="discount_del" value="<?php echo $discount->id; ?>">
                                                <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

		</div>
        <div class="col-md-12 mt-5" id="form_body"></div>
	</div>
</div>

<!-- Vertically centered tax modal -->
<div class="modal fade" id="taxModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="<?= current_url();?>" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Tax Name<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="tax_name" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Tax rate<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="tax_rate" required>
            <small id="emailHelp" class="form-text text-muted">Insert rate without percetage sing.</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="tax" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Vertically centered discount modal -->
<div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content" action="<?= current_url();?>" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Discount Name<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="discount_name" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Discount Type<small class="text-danger">*</small></label>
            <select name="discount_type" class="form-control" required>
                <option value="fixed">Fixed</option>
                <option value="rate">Rate</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Discount Rate/Amount<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="discount_rate" required>
            <small id="emailHelp" class="form-text text-muted">Insert rate without percetage sing.</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="discount" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
    $(document).ready(function() {
    $('table.display').DataTable();
} );
</script>