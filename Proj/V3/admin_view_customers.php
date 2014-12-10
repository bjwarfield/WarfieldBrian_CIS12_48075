<?php 
session_name('PHPADMINID');
session_start();

$page_title = 'View Registered Customers';
include('includes/admin.html'); 
include ('convert_state.php');

echo '<h1 class="users_heading">Registered Users</h1>';

@require ('project_DBconnect.php'); 

//check $_GET for validity, set defaul if not 
if(isset($_GET['display'])&& is_numeric($_GET['display'])){
	$display = $_GET['display'];
}else{
	$display = 10;
}

// Determine how many pages there are...
// Count the number of records:
$q = "SELECT COUNT(customer_id) FROM bw1780661_entity_customers";
$r = @mysqli_query ($dbc, $q);
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
// Default is by registration date.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'rd';

// Determine the sorting order:
switch ($sort) {
	case 'ln':
		$order_by = 'last_name ASC';
		break;
	case 'fn':
		$order_by = 'first_name ASC';
		break;
	case 'rd':
		$order_by = 'registration_date ASC';
		break;
	case 'state':
		$order_by = 'state ASC';
		break;
	case 'status':
		$order_by = 'customer_status ASC';
		break;
	default:
		$order_by = 'registration_date ASC';
		$sort = 'rd';
		break;
}
	
// Define the query:
$q = 'SELECT `bw1780661_entity_customers`.`customer_id`, `bw1780661_entity_customers`.`last_name`, `bw1780661_entity_customers`.`first_name`, `bw1780661_entity_customers`.`phone_1`, `bw1780661_entity_customers`.`state`, `bw1780661_entity_customers`.`zip_code`, DATE_FORMAT(`bw1780661_entity_customers`.`registration_date`, "%d %b %Y") AS `registration_date` , `bw1780661_enum_customer_status`.`customer_status` FROM `bw1780661_entity_customers`, `bw1780661_enum_customer_status` WHERE `bw1780661_entity_customers`.`customer_status_id` = `bw1780661_enum_customer_status`.`customer_status_id` ORDER BY '.$order_by.' LIMIT '.$start.', '.$display.';';		
$r = @mysqli_query ($dbc, $q); // Run the query.

//Display Pagination options
 echo '<form class="paginator" action="admin_view_customers.php" method="get">
 			<label>Sort</label>
 			<select name="sort">
 				<option value="ln" '.(($sort=="ln")?'selected="selected"':'').'>Last Name</option>
 				<option value="fn" '.(($sort=="fn")?'selected="selected"':'').'>First Name</option>
 				<option value="rd" '.(($sort=="rd")?'selected="selected"':'').'">Registration Date</option>
 				<option value="state" '.(($sort=="state")?'selected="selected"':'').'">State</option>
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
// Table header:
echo '<table class="customer_list">
<thead>
<tr>
		<th>Action</th>
		<th>Last Name</th>
		<th>First Name</th>
		<th>Phone</th>
		<th>State</th>
		<th>ZIP code</th>
		<th>Date Registered</th>
		<th>Status</th>
</tr>
</thead><tbody>
';

// Fetch and print all the records.... 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	//out_obj($row);
		echo '<tr>
		<td><form action="admin_edit_customer.php" method="post"><input type="hidden" name="customer_id" value="'.$row['customer_id'].'" ><input type="submit" value="Edit"></form></td>
		<td>'.$row['last_name'].'</td>
		<td>'.$row['first_name'].'</td>
		<td>('.substr($row['phone_1'],0,3).')'.substr($row['phone_1'],3,3).'-'.substr($row['phone_1'],6,4).'</td>
		<td>'.convert_state($row['state']).'</td>
		<td>'.$row['zip_code'].'</td>
		<td>'.$row['registration_date'].'</td>
		<td>'.$row['customer_status'].'</td>
	</tr>
	';
} // End of WHILE loop.

echo '</tbody></table>';
mysqli_free_result ($r);
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
		echo '<a href="admin_view_customers.php?s=' . ($start - $display) . '&display=' . $display . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		//regular links for less than 10 pages
		if($pages<10){
			if ($i != $current_page) {
				echo '<a href="admin_view_customers.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '</a> ';
			} else {//current page, no link
				echo $i . ' ';
			}
		}else{
			//truncated links for more than 10 pages
			if ( $i != $current_page) {
				if($i > $bottom && $i < $top){//links adjasent to currrent page
					echo '<a href="admin_view_customers.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '</a> ';
				}elseif($i == 1 ){//set first link
					echo '<a href="admin_view_customers.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">First</a> ';
				}elseif($i == $pages){//set last link
					echo '<a href="admin_view_customers.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">Last</a> ';
				}elseif($i == $bottom){//mark truncation points with elipses
					echo '<a href="admin_view_customers.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">...' . $i . '</a> ';
				}elseif($i == $top){
					echo '<a href="admin_view_customers.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '...</a> ';
				}
			} elseif ($i = $current_page) {//current page, no link
				echo $i . ' ';
			}
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="admin_view_customers.php?s=' . ($start + $display) . '&display=' . $display . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</div>'; // Close the div.
	
} // End of links section.
	
include ('includes/footer.html');
?>