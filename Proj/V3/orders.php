<?php
session_start();
$page_title = 'Your Orders';

if(isset($_SESSION['customer_id']) && is_numeric($_SESSION['customer_id'])){
		$customer_id = $_SESSION['customer_id'];
}else{
	//redirect if not logged in
	redirect_user('login.php');
}


include('includes/header.html');

//get list of customer orders
@require('project_DBconnect.php');
$q = "SELECT order_id, order_date, order_status_id, shipping_method_id, order_total FROM bw1780661_entity_orders WHERE customer_id = $customer_id ORDER BY order_date;";

$r = mysqli_query($dbc, $q);

//display msg if no orders available
if( $r->num_rows < 1){
	echo "<br/><h1>Order History</h1><br/>
	<p>You do not have any orders.</p>";
	if(is_object($r))$r -> free();
	mysqli_close($dbc);
	include('includes/footer.html');
	exit();
}
unset($q);


$orders = mysqli_fetch_all($r, MYSQLI_ASSOC);
if(is_object($r))$r -> free();
//collect data in $order_id_list
$order_id_list = array();
foreach ($orders as $key) {
	$order_id_list[]= $key['order_id'];
}
unset($key);

//get list of order line items
$q = 'SELECT line_item_id, order_id, product_id, qty, price FROM `bw1780661_entity_order_line_item` where order_id in ('.substr(json_encode($order_id_list),1,-1).');';
$r = mysqli_query($dbc, $q);
unset($q);

$orders_lines = mysqli_fetch_all($r, MYSQLI_ASSOC);
if(is_object($r))$r -> free();

//collect list of product IDs for which to get names
$product_id_list = array();

foreach ($orders_lines as $key) {
	$product_id_list[]= intval($key['product_id']);
}
unset($key);

//get product names
$q = 'SELECT product_id, name FROM bw1780661_entity_products WHERE product_id IN ('.substr(json_encode($product_id_list),1,-1).') GROUP BY product_id;';
$r = mysqli_query($dbc, $q);
unset($q);

//append names to $order_lines array
while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	foreach ($orders_lines as $key => $value) {
		if($row['product_id']==$value['product_id']){
			$orders_lines[$key]['name']=$row['name'];
		}
	}
}
if(is_object($r))$r -> free();
unset($key);
unset($value);


//get shipping method per order
$q = 'SELECT * FROM bw1780661_enum_shipping_method;';
if(is_object($r))$r = mysqli_query($dbc, $q);
unset($q);

//append data to order array
while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	foreach ($orders as $key => $value) {
		if($row['shipping_method_id']==$value['shipping_method_id']){
			$orders[$key]['shipping_method_id'] = $row['shipping_method'];
		}
	}
}
$r -> free();
unset($key);
unset($value);

//get order status
$q = 'SELECT * FROM bw1780661_enum_order_status;';
$r = mysqli_query($dbc, $q);
unset($q);

//append data to order array
while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	foreach ($orders as $key => $value) {
		if($row['order_status_id']==$value['order_status_id']){
			$orders[$key]['order_status_id'] = $row['order_status'];
		}
	}
}

// output order detail tables
echo '<br/><h1>Order History</h1><br/>';
foreach ($orders as $ord) {
	echo "<table class='order_list'><thead>
	<tr><td colspan='2'> <strong>Order:</strong> #".$ord['order_id']."</td><td colspan='2'> <strong>Date:</strong> ".date("h:i A m/d/y", strtotime($ord['order_date']))."</td></tr>
	<tr><td colspan='2'> <strong>Shipping Method:</strong> ".$ord['shipping_method_id']."</td><td colspan='2'> <strong>Status:</strong> ".$ord['order_status_id']."</td></tr>
	<tr><td><strong>Name</strong></td><td><strong>Price</strong></td><td><strong>Qty</strong></td><td><strong>Total</strong></td></tr></thead><tbody>";
	foreach ($orders_lines as $line) {
		if($ord['order_id'] == $line['order_id']){
			echo '<tr><td>'.$line['name'].'</td><td>'.$line['price'].'</td><td>'.$line['qty'].'</td><td>$'.number_format(($line['price']*$line['qty']),2).'</td></tr>';
		}
	}
	echo '<tr><td colspan="4"><strong>Grand Total:</strong> $'.number_format($ord['order_total'],2).'</td></tr>
	</tbody></table>';
}

mysqli_close($dbc);
include('includes/footer.html');
?>