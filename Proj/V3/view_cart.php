<?php
session_start();
$page_title = 'View Product';

//check for cookie, read contents if contains data
if (isset($_COOKIE["cart"]) && !empty(json_decode($_COOKIE["cart"], true))) {
	$cart_cookie = json_decode($_COOKIE["cart"], true);

}else{//display error message and end script
	include('includes/header.html'); 
	echo '<h1>Shopping Cart</h1><p>There are no items in your shopping cart</p>';
	include('includes/footer.html');
	exit();
}
//connect to db
@require("project_DBconnect.php");


//get list of enabled product IDs
$q = 'SELECT `product_id` FROM `bw1780661_entity_products` WHERE `enabled` = true;';
$r = mysqli_query ($dbc, $q);
$product_id_list = array();
while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC )){
	$product_id_list[] = $row['product_id'];
}
//free query vars
$r-> free();
unset($q);

//get list of IDs in cart
$cart_id_list = array();
foreach ($cart_cookie as $pid => $cart_line) {
	if(is_numeric($pid) && in_array($pid, $product_id_list)){//sanitize list for valid values
		$cart_id_list[] = $pid;
	}else{//invalid product ID
		unset($cart_cookie[$pid]);//delete bad value
		setcookie("cart", json_encode($cart_cookie), 0, '/');//fix cookie
	}
}

//free loop vars
unset($pid);
unset($cart_line);


//get list of carts in cart
$qp = 'SELECT `product_id`, `name`, `on_hand_qty`, `price` FROM  `bw1780661_entity_products` WHERE `product_id` IN ('.substr(json_encode($cart_id_list), 1, -1).');';
$rp = mysqli_query($dbc,$qp);
unset($qp);
$x = mysqli_fetch_all($rp,MYSQLI_ASSOC );

//free query vars
unset($qp);
$rp->free();
//close connections
mysqli_close($dbc);

//include ready lower in script to allow for cooki eupdate
include('includes/header.html'); 

echo "<h1>Shopping Cart</h1>";

// Create a form and a table:
	echo "<table class='cart_table'>
		<tr>
			<th>Name</th>
			<th>Price</th>
			<th>Qty</th>
			<th>Total</th>
		</tr> ";
//count total		
$total = 0;
$qty =0 ;
foreach ($x as $key => $value) {
	foreach ($cart_cookie as $ikey => $ivalue) {
		if($value["product_id"] == $ikey){
			//calculate subtotal and add value to grand total
			$subtotal = $value['price']*$ivalue['qty'];
			$total += $subtotal;
			$qty +=$ivalue['qty'];
			//output cart table row
			echo'<tr>
			<td><a href="view_product.php?product_id='.$ikey.'">'.htmlspecialchars($value['name']).'</a><br><small>Max Qty: '.$value['on_hand_qty'].'</small></td>
			<td>$'.number_format($value['price'],2).'</td>
			<td><input type="number" name="qty_'.$ikey.'" size="3" min="0" max="'.$value['on_hand_qty'] .'" value="'.$ivalue['qty'].'"><button type="button" step="1" onclick="changeCart('.$ikey.', this.previousSibling.value, '.$value['on_hand_qty'].')">Update Cart</button></td>
			<td>$'.number_format($subtotal,2).'</td>
			</tr>';
		}
	}
}
echo "</table>";
echo "<p style='text-align: right;padding:5px 10px;border:1px solid #AAA;margin-bottom:15px;'><strong>Total Item Qty: </strong>".$qty."&nbsp;&nbsp;&nbsp;<strong>Grand Total:</strong> $".number_format($total,2)."</p>";

if(!isset($_SESSION['customer_id'])){
	echo '<center style="clear:both;margin:20px 0 15px;"><a href="login.php"><h3>Login Required for Checkout</h3></a>';
	echo '<button type="button" disabled>Checkout</button></center>';
}else{
	echo '<center style="clear:both;margin:20px 0 15px;"><a href="checkout.php"><button type="button">Checkout</button></a></center>'; 
}


include('includes/footer.html');
?>