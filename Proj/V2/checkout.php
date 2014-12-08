<?php
session_start();
$page_title = 'Checkout';

if(isset($_SESSION['customer_id']) && is_numeric($_SESSION['customer_id'])){
		$customer_id = $_SESSION['customer_id'];
}else{
	//redirect if not logged in
	redirect_user('login.php');
}

//check for cookie, read contents if contains data
if (isset($_COOKIE["cart"]) && !empty(json_decode($_COOKIE["cart"], true))) {
	$cart_cookie = json_decode($_COOKIE["cart"], true);
	setcookie("cookie_name", "", time()-3600);//delete cookie after checkout

}else{//display error message and end script
	include('includes/header.html'); 
	echo '<h1>Shopping Cart</h1><p>There are no items in your shopping cart</p>';
	include('includes/footer.html');
	exit();
}
@require("project_DBconnect.php");


//get list of enabled product IDs
$q = 'SELECT `product_id` FROM `bw1780661_entity_products` WHERE `enabled` = true;';
$r = mysqli_query ($dbc, $q);
$product_id_list = array();
while ($row = mysqli_fetch_array($r,MYSQLI_ASSOC )){
	$product_id_list[] = $row['product_id'];
}
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
unset($pid);
unset($cart_line);

//get list of carts in cart
$qp = 'SELECT `product_id`, `name`, `on_hand_qty`, `price` FROM `bw1780661_entity_products` WHERE `product_id` IN ('.substr(json_encode($cart_id_list), 1, -1).');';

$rp = mysqli_query($dbc,$qp);
unset($qp);

$x = mysqli_fetch_all($rp,MYSQLI_ASSOC );
$rp->free();
mysqli_close($dbc);
unset($dbc);
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
			<td><a href="view_product.php?product_id='.$ikey.'">'.htmlspecialchars($value['name']).'</a></td>
			<td>$'.number_format($value['price'],2).'</td>
			<td>'.$ivalue['qty'].'</td>
			<td>$'.number_format($subtotal,2).'</td>
			</tr>';
		}
	}
}
echo "</table>";
echo "<p style='text-align: right;padding:5px 10px;border:1px solid #AAA;margin-bottom:15px;'><strong>Total Item Qty: </strong>".$qty."&nbsp;&nbsp;&nbsp;<strong>Grand Total:</strong> $".number_format($total,2)."</p>";

@require("project_DBconnect.php");
// Turn autocommit off:
mysqli_autocommit($dbc, false);

// Add the order to the orders table...
$q = "INSERT INTO bw1780661_entity_orders (customer_id, order_date, shipping_method_id, order_status_id, order_total) VALUES ($customer_id, NOW(), 1, 1, $total)";

$r = mysqli_query($dbc, $q);
if (mysqli_affected_rows($dbc) == 1){

	// Insert the specific order contents into the database...
	// Need the order ID:
	$oid = mysqli_insert_id($dbc);

	// Insert the specific order contents into the database...
	
	// Prepare the query:
	$q = "INSERT INTO bw1780661_entity_order_line_item (order_id, product_id, qty, price) VALUES (?, ?, ?, ?);";
	$stmt = mysqli_prepare($dbc, $q);
	mysqli_stmt_bind_param($stmt, 'iiid', $oid, $pid, $qty, $price);

	// Execute each query; count the total affected:
	$affected = 0;
	foreach ($cart_cookie as $pid => $item) {
		$qty = $item['qty'];
		$price = $item['price'];
		mysqli_stmt_execute($stmt);
		$affected += mysqli_stmt_affected_rows($stmt);
	}
	// Close this prepared statement:
	mysqli_stmt_close($stmt);

	// Report on the success....
	if ($affected == count($cart_cookie)) { // Whohoo!
	
		// Commit the transaction:
		mysqli_commit($dbc);
		
		// Clear the cart:
		//unset($cart_cookie);
		
		// Message to the customer:
		echo '<p>Thank you for your order. You will be notified when the items ship.</p>';
		
		// Send emails and do whatever else.
	}else { // Rollback and report the problem.
	
		mysqli_rollback($dbc);
		
		echo '<p>Your order could not be processed due to a system error. You will be contacted in order to have the problem fixed. We apologize for the inconvenience.</p>';
		// Send the order information to the administrator.
		
	}

} else { // Rollback and report the problem.

	mysqli_rollback($dbc);

	echo '<p>Your order could not be processed due to a system error. You will be contacted in order to have the problem fixed. We apologize for the inconvenience.</p>';
	
	// Send the order information to the administrator.
	
}
include('includes/footer.html');
?>