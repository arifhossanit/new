<?php
include("../../../application/config/ajax_config.php");
$get_warehouse_stocks = $mysqli->query("SELECT scm_warehouse_product_stock.id, scm_product_order_details.purchase_order_id, scm_product_order_details.pre_purchase_order_id, scm_warehouse_product_stock.stock_amount, scm_warehouses.name
from scm_warehouse_product_stock
INNER JOIN scm_product_order_details on scm_product_order_details.id = scm_warehouse_product_stock.scm_product_order_details_id
INNER JOIN scm_products on scm_products.id = scm_product_order_details.product_id
INNER JOIN scm_warehouses on scm_warehouses.id = scm_warehouse_product_stock.warehouse_id
where scm_products.id  = ".$_POST['id'] . " AND scm_product_order_details.product_size = " . $_POST['size']);
?>
<h5> <span class="text-secondary">Prodcut: </span> <?php echo $_POST['name']; ?> </h5>
<table class="table table-sm text-center table-bordered table-hover" id="warehouse_stock_details">
    <thead>
        <tr>
            <th>ID</th>
            <th>Purchase Order</th>
            <th>Order Date</th>
            <th>Amount</th>
            <th>Warehouse</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($get_warehouse_stocks as $stock){ ?>
            <tr>
                <td><?php echo $stock['id'] ?></td>
                <td><?php echo (is_null($stock['purchase_order_id'])) ? $stock['pre_purchase_order_id'] : $stock['purchase_order_id']; ?></td>
                <td><?php
                    if(is_null($stock['purchase_order_id'])){
                        $get_pre_purchase_order_date = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_pre_purchase_order where purchase_order_id = '".$stock['pre_purchase_order_id']."'"));
                        $receive_date = new DateTime($get_pre_purchase_order_date['received_date']);
                        echo $receive_date->format('F jS, Y');
                    }else{
                        $get_purchase_order_date = mysqli_fetch_assoc($mysqli->query("SELECT * from scm_purchase_order where purchase_order_id = '".$stock['purchase_order_id']."'"));
                        $receive_date = new DateTime($get_purchase_order_date['received_date']);
                        echo $receive_date->format('F jS, Y');
                    }
                ?></td>
                <td><?php echo $stock['stock_amount'] ?></td>
                <td><?php echo $stock['name'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>