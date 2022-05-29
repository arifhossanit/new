<?php
include("../../../application/config/ajax_config.php");
if(!empty($_POST["action"])) {	
	if($_POST["action"] == 'add'){
		if(!empty($_POST["quantity"])){
			$da = explode('_',$_POST['code']);
			$id = $da[1];
			$productByCode = mysqli_fetch_assoc($mysqli->query("select * from manage_locker where id = '".$id."'"));
			$itemArray = array(
				'add_'.$productByCode['id'] => array(
					'name' => $productByCode["locker_number"],
					'code' => $_POST['code'],
					'id' => $productByCode['id'],
					'quantity' => $_POST["quantity"],
					'price'=> $productByCode['price']
				)
			);
			
			if(!empty($_SESSION["cart_locker"])){
				if(in_array($productByCode['id'],$_SESSION["cart_locker"])) {
					foreach($_SESSION["cart_locker"] as $k => $v) {
						if($productByCode['id'] == $k){
							$_SESSION["cart_locker"][$k]["quantity"] = $_POST["quantity"];
						}
					}
				} else {
					$_SESSION["cart_locker"] = array_merge($_SESSION["cart_locker"],$itemArray);
				}
			} else {
				$_SESSION["cart_locker"] = $itemArray;
			}
		}
	}else if($_POST["action"] == 'remove'){
		if(!empty($_SESSION["cart_locker"])) {
			foreach($_SESSION["cart_locker"] as $k => $v) {
				if($_POST["code"] == $k){
					unset($_SESSION["cart_locker"][$k]);
				}
				if(empty($_SESSION["cart_locker"])){
					unset($_SESSION["cart_locker"]);
				}
			}
		}
	}else{
		unset($_SESSION["cart_locker"]);
	}
}
if(isset($_SESSION["cart_locker"])){
    $item_total = 0;
	$item_qty = 0;
	$id = '';
	$name = '';
    foreach ($_SESSION["cart_locker"] as $item){
		$name = $name.$item["name"].',';
		$id = $id.$item["id"].',';
		$item_total += ( $item["price"] * $item["quantity"] );
		$item_qty = $item_qty  + $item["quantity"];
	}
	echo rtrim($id,',').'||'.rtrim($name,',').'||'.$item_qty.'||'.$item_total;
}
?>