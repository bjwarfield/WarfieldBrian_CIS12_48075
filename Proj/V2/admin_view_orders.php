<?php
session_name('PHPADMINID');
session_start();
$page_title = 'Customer Orders';


include('includes/admin.html');

include("debug.php");//debuggin scripts
@require('project_DBconnect.php');
//check $_GET for validity, set defaul if not 
if(isset($_GET['display'])&& is_numeric($_GET['display'])){
	$display = $_GET['display'];
}else{
	$display = 10;
}

// Determine how many pages there are...
// Count the number of records:
$q = "SELECT COUNT(order_id) FROM bw1780661_entity_orders";
$r = @mysqli_query ($dbc, $q);
unset($q);
$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
$records = $row[0];
// Calculate the number of pages...
if ($records > $display) { // More than 1 page.
	$pages = ceil ($records/$display);
} else {
	$pages = 1;
}
// Determine where in the database to start returning results...
$start = (isset($_GET['s']) && is_numeric($_GET['s']) && $_GET['s'] <= $records-1 && $_GET['s']>=0 ) ? $_GET['s'] : 0;

// Determine the sort...
// Default is by order date DESCENDING.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'odd';

// Determine the sorting order:
switch ($sort) {
	case 'lna':
		$order_by = 'last_name ASC';
		break;
	case 'fnd':
		$order_by = 'first_name ASC';
		break;
	case 'lnd':
		$order_by = 'last_name DESC';
		break;
	case 'fnd':
		$order_by = 'first_name DESC';
		break;
	case 'oda':
		$order_by = 'order_date ASC';
		break;
	case 'os':
		$order_by = 'order_status';
		break;				
	default:
		$order_by = 'order_date DESC';
		$sort = 'odd';
		break;
}

//get list of customer orders

$q = "SELECT `bw1780661_entity_orders`.`order_id`, `bw1780661_entity_customers`.`last_name`, `bw1780661_entity_customers`.`first_name`, `bw1780661_entity_orders`.`order_date`, `bw1780661_entity_orders`.`shipping_method_id`, `bw1780661_entity_orders`.`order_status_id`, `bw1780661_entity_orders`.`order_total` FROM `bw1780661_entity_orders`, `bw1780661_entity_customers` WHERE `bw1780661_entity_orders`.`customer_id` = `bw1780661_entity_customers`.`customer_id` ORDER BY $order_by LIMIT $start, $display;";

$r = mysqli_query($dbc, $q);
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
if(is_object($r))$r = mysqli_query($dbc, $q);
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
$q = 'SELECT shipping_method_id, shipping_method FROM bw1780661_enum_shipping_method;';
$r = mysqli_query($dbc, $q);
unset($q);

//append data to order array
while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	foreach ($orders as $key => $value) {
		if($row['shipping_method_id']==$value['shipping_method_id']){
			$orders[$key]['shipping_method_id'] = $row['shipping_method'];
		}
	}
}
if(is_object($r))$r -> free();
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

//Display Pagination options
 echo '<form class="paginator" action="admin_view_orders.php" method="get">
 			<label>Sort</label>
 			<select name="sort">
 				<option value="lna" '.(($sort=="lna")?'selected="selected"':'').'>Last Name (A-Z)</option>
 				<option value="lnd" '.(($sort=="lnd")?'selected="selected"':'').'>Last Name (Z-A)</option>
 				<option value="fna" '.(($sort=="fna")?'selected="selected"':'').'>First Name (A-Z)</option>
 				<option value="fnd" '.(($sort=="fnd")?'selected="selected"':'').'>First Name (Z-A)</option>
 				<option value="oda" '.(($sort=="oda")?'selected="selected"':'').'>Order Date (oldest First)</option>
 				<option value="odd" '.(($sort=="odd")?'selected="selected"':'').'>Order Date (Newest First)</option>
 				<option value="os" '.(($sort=="os")?'selected="selected"':'').'>Order Status</option>
				</select>
				<label>Display</label>
				<select name=display>
 				<option value="5" '.(($display==5)?'selected="selected"':'').'>5</option>
					<option value="10" '.(($display==10)?'selected="selected"':'').'>10</option>
					<option value="15" '.(($display==15)?'selected="selected"':'').'>15</option>
					<option value="20" '.(($display==20)?'selected="selected"':'').'>20</option>
					<option value="25" '.(($display==25)?'selected="selected"':'').'>25</option>
					<option value="30" '.(($display==30)?'selected="selected"':'').'>30</option>
					<option value="35" '.(($display==35)?'selected="selected"':'').'>35</option>
					<option value="40" '.(($display==40)?'selected="selected"':'').'>40</option>
					<option value="45" '.(($display==45)?'selected="selected"':'').'>45</option>
					<option value="50" '.(($display==50)?'selected="selected"':'').'>50</option>

				</select>
				<input type="submit" value="Submit">
				<input name="s" type="hidden" value="'.$start.'">
		</form>';

// output order detail tables
echo '<br/><h1>Order History</h1><br/>';
foreach ($orders as $ord) {
	echo "<table class='order_list'>
	<tr><td> <strong>Order:</strong> #".$ord['order_id']." <strong>Customer Name:</strong> ".$ord['first_name']." ".$ord['last_name']."</td><td> <strong>Date:</strong> ".date("h:i A m/d/y", strtotime($ord['order_date']))."</td></tr>
	<tr><td> <strong>Shipping Method:</strong> ".$ord['shipping_method_id']."</td><td> <strong>Status:</strong> ".$ord['order_status_id']."</td></tr>";
	echo '<tr><td colspan="2"><form action="admin_edit_order.php" method="post"><input type="hidden" name="order_id" value="'.intval($ord['order_id']).'" ><input type="submit" value="View Order"></form><span><strong>Total:</strong> $'.number_format($ord['order_total'],2).'</span></td></tr>
	</table>';
}

mysqli_close($dbc);

// Make the links to other pages, if necessary.
if ($pages > 1) {
	
	echo '<br /><div class ="page_selector">';
	$current_page = ($start/$display) + 1;
	//set floor and celing for number of links in page selector
	$top = $current_page +5;
	$bottom = $current_page -5;

	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="admin_view_orders.php?s=' . ($start - $display) . '&display=' . $display . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		//regular links for less than 10 pages
		if($pages<10){
			if ($i != $current_page) {
				echo '<a href="admin_view_orders.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '</a> ';
			} else {//current page, no link
				echo $i . ' ';
			}
		}else{
			//truncated links for more than 10 pages
			if ( $i != $current_page) {
				if($i > $bottom && $i < $top){//links adjasent to currrent page
					echo '<a href="admin_view_orders.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '</a> ';
				}elseif($i == 1 ){//set first link
					echo '<a href="admin_view_orders.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">First</a> ';
				}elseif($i == $pages){//set last link
					echo '<a href="admin_view_orders.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">Last</a> ';
				}elseif($i == $bottom){//mark truncation points with elipses
					echo '<a href="admin_view_orders.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">...' . $i . '</a> ';
				}elseif($i == $top){
					echo '<a href="admin_view_orders.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '...</a> ';
				}
			} elseif ($i = $current_page) {//current page, no link
				echo $i . ' ';
			}
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="admin_view_orders.php?s=' . ($start + $display) . '&display=' . $display . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</div>'; // Close the div.
	
} // End of links section.
include('includes/footer.html');
?>