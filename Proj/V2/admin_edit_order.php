<?php
session_name('PHPADMINID');
session_start();
$page_title = 'Customer Orders';
include("debug.php");//debuggin scripts
include('includes/admin.html');

#validate product ID, exit if invalid
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["order_id"])  && is_numeric($_POST['order_id'])){
	$order_id = $_POST["order_id"];
	@require('project_DBconnect.php');
	if(isset($_POST['order_status_id']) && is_numeric($_POST['order_status_id'])){
		$order_status_id = mysqli_real_escape_string($dbc, trim($_POST['order_status_id']));

		$q = "UPDATE bw1780661_entity_orders SET order_status_id = $order_status_id WHERE order_id = $order_id;"; 
		$r = mysqli_query($dbc, $q);
		// unset($q);
		if($r){#successful query
			echo '<p class="confirm">Order Status Successfully Updated</p>';
		} else { #unsuccessful query
			echo '<p class="error">The order could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
			include('includes/footer.html');
			exit();
		}

	}
}else{
	echo '<h1 class="error">ERROR!</h1><p>This page has been reached in error. <a href="admin_index.php">Please try again</a></p>';
	include('includes/footer.html');
	exit();
}


//get list of customer orders

$q = "SELECT `bw1780661_entity_orders`.`order_id`, `bw1780661_entity_customers`.`last_name`, `bw1780661_entity_customers`.`first_name`, `bw1780661_entity_orders`.`order_date`, `bw1780661_enum_shipping_method`.`shipping_method`, `bw1780661_entity_orders`.`order_total`, `bw1780661_enum_order_status`.`order_status`, `bw1780661_entity_customers`.`company`, `bw1780661_entity_customers`.`address_1`, `bw1780661_entity_customers`.`address_2`, `bw1780661_entity_customers`.`city`, `bw1780661_entity_customers`.`state`, `bw1780661_entity_customers`.`zip_code`, `bw1780661_entity_customers`.`phone_1`, `bw1780661_entity_customers`.`phone_2` FROM `bw1780661_entity_orders`, `bw1780661_entity_customers`, `bw1780661_enum_order_status`, `bw1780661_enum_shipping_method` WHERE `bw1780661_entity_orders`.`customer_id` = `bw1780661_entity_customers`.`customer_id` AND `bw1780661_entity_orders`.`order_status_id` = `bw1780661_enum_order_status`.`order_status_id` AND `bw1780661_entity_orders`.`shipping_method_id` = `bw1780661_enum_shipping_method`.`shipping_method_id` AND order_id = $order_id;";
$r = mysqli_query($dbc, $q);
unset($q);


$orders = mysqli_fetch_all($r, MYSQLI_ASSOC)[0];
$r -> free();


//get list of order line items
$q = "SELECT `bw1780661_entity_products`.`name`, `bw1780661_entity_order_line_item`.`qty`, `bw1780661_entity_order_line_item`.`price` FROM `bw1780661_entity_order_line_item`, `bw1780661_entity_products` WHERE `bw1780661_entity_order_line_item`.`product_id` = `bw1780661_entity_products`.`product_id` AND order_id = $order_id;";
$r = mysqli_query($dbc, $q);
unset($q);

$orders_lines = mysqli_fetch_all($r, MYSQLI_ASSOC);
$r -> free();

//get orderstatus enumeration
$q = 'SELECT * FROM bw1780661_enum_order_status;';
$r = mysqli_query($dbc, $q);
unset($q);

$enum_order_status = mysqli_fetch_all($r, MYSQLI_ASSOC);
$r -> free();

// out_obj($orders);
// out_obj($enum_order_status);
if (count($orders == 1)){
	// output order detail tables
	echo '<h1>Customer Order</h1>';
	echo '<div class="customer_info"><h3>Shipping Info</h3>';
	echo"<p>".htmlspecialchars($orders["first_name"])." ".htmlspecialchars($orders["last_name"])."</p>";
	if(isset($orders["company"]))echo"<p>".htmlspecialchars($orders["company"])."</p>";
	echo"<p>".htmlspecialchars($orders["address_1"])."</p>";
	if(isset($orders["address_2"]))echo"<p>Address: ".htmlspecialchars($orders["address_2"])."</p>";
	echo"<p>".htmlspecialchars($orders["city"])." ".htmlspecialchars($orders["state"]).", ".(strlen($orders['zip_code'])==9?substr($orders['zip_code'],0,5).'-'.substr($orders['zip_code'],5,4):$orders['zip_code'])."</p></div>";

	echo "<table class='order_list'><thead>
	<tr><td colspan='2'> <strong>Order:</strong> #".$orders['order_id']."</td><td colspan='2'> <strong>Date:</strong> ".date("h:i A m/d/y", strtotime($orders['order_date']))."</td></tr>
	<tr><td colspan='2'> <strong>Shipping Method:</strong> ".$orders['shipping_method']."</td><td colspan='2'> <strong>Status:</strong> ";
	echo "<form action='admin_edit_order.php' method='post'><select name ='order_status_id'>";
	foreach ($enum_order_status as $key) {
			echo '<option value="'.$key['order_status_id'].'" '.($orders['order_status']==$key['order_status']?'selected':'').'>'.$key['order_status'].'</option>';
		}
		echo "</select>
		<input type='hidden' name='order_id' value='$order_id'/>
		<input type='submit' value='Update Status'/>
		</form>";
	echo "</td></tr>
	<tr><td><strong>Name</strong></td><td><strong>Price</strong></td><td><strong>Qty</strong></td><td><strong>Total</strong></td></tr></thead><tbody>";
	foreach ($orders_lines as $line) {
		echo '<tr><td>'.$line['name'].'</td><td>'.$line['price'].'</td><td>'.$line['qty'].'</td><td>$'.number_format(($line['price']*$line['qty']),2).'</td></tr>';
	}
	echo '<tr><td colspan="4"><strong>Grand Total:</strong> $'.number_format($orders['order_total'],2).'</td></tr>
	</tbody></table>';
}
mysqli_close($dbc);
include('includes/footer.html');
?>