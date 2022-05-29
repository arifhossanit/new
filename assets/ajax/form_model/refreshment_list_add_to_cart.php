<?php
include("../../../application/config/ajax_config.php");
if(!empty($_POST["action"])) {	
	if($_POST["action"] == 'add'){
		if(!empty($_POST["quantity"])){
			$productByCode = mysqli_fetch_assoc($mysqli->query("select * from refreshment_item where code = '".$_POST['code']."'"));
			$image = $home.$productByCode['item_picture'];
			$itemArray = array(
				$productByCode['code']=>array(
					'name' => $productByCode["item_name"],
					'code' => $productByCode['code'],
					'quantity' => $_POST["quantity"],
					'price'=> $productByCode['price'],
					'image'=>$image
				)
			);
			
			if(!empty($_SESSION["cart_item"])){
				if(in_array($productByCode['code'],$_SESSION["cart_item"])) {
					foreach($_SESSION["cart_item"] as $k => $v) {
						if($productByCode['code'] == $k){
							$_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];
						}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	}else if($_POST["action"] == 'remove'){
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
				if($_POST["code"] == $k){
					unset($_SESSION["cart_item"][$k]);
				}
				if(empty($_SESSION["cart_item"])){
					unset($_SESSION["cart_item"]);
				}
			}
		}
	}else{
		unset($_SESSION["cart_item"]);
	}
}
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>	
<table cellpadding="10" cellspacing="1" class="table table-sm table-bordered">
	<tbody>
		<tr>
			<th><strong>Name</strong></th>
			<th><strong>Image</strong></th>
			<th><strong>Quantity</strong></th>
			<th><strong>Price</strong></th>
			<th><strong>Action</strong></th>
		</tr>	
<?php
	$item_qty = '0';
    foreach ($_SESSION["cart_item"] as $item){
		?>
		<tr>
			<td><strong><?php echo $item["name"]; ?></strong></td>
			<td><img src="<?php echo $item["image"]; ?>" style="width:20px;"/></td>
			<td style="text-align:center;"><span style="color:#f00;"><?php echo $item["quantity"]; ?></span> piece</td>
			<td align=right><?php echo money($item["price"]); ?></td>
			<td style="text-align:right;">
				<button type="button" class="btn btn-danger btn-xs btnRemoveAction cart-action" onClick="return cartAction('remove','<?php echo $item["code"]; ?>')">
					<i class="fas fa-trash"></i>
				</button>
			</td>
		</tr>
<?php
		$item_total += ( $item["price"] * $item["quantity"] );
		$item_qty = $item_qty  + $item["quantity"];
	}
?>		<tr>
			<td colspan="5" align=right>
				<button type="button" id="btnEmpty" class="btn btn-xs btn-danger cart-action" style="float:left;" onClick="return cartAction('empty','');">Empty Cart</button>
				<span>Total: <strong><?php echo money($item_total); ?></strong></span>
				<input type="hidden" name="total_amount" value="<?php echo $item_total; ?>"/>
				<input type="hidden" name="total_qty" value="<?php echo $item_qty; ?>"/>
			</td>
		</tr>
	</tbody>
</table>
<?php
}
?>