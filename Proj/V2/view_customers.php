<?php 

$page_title = 'View the Current Users';
include ('includes/header.html');

echo '<h1>Registered Users</h1>';

@require ('project_DBconnect.php'); 

// Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
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
} // End of p IF.

// Determine where in the database to start returning results...
$start = (isset($_GET['s']) && is_numeric($_GET['s'])) ? $_GET['s'] : 0;

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
	default:
		$order_by = 'registration_date ASC';
		$sort = 'rd';
		break;
}
	
// Define the query:
$q = "SELECT last_name, first_name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, customer_id FROM bw1780661_entity_customers ORDER BY $order_by LIMIT $start, $display";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:
echo '<table align="center" cellspacing="0" cellpadding="5" width="75%">
<tr>
	<td align="left"><b>Edit</b></td>
	<td align="left"><b>Delete</b></td>
	<td align="left"><b><a href="view_customers.php?sort=ln">Last Name</a></b></td>
	<td align="left"><b><a href="view_customers.php?sort=fn">First Name</a></b></td>
	<td align="left"><b><a href="view_customers.php?sort=rd">Date Registered</a></b></td>
</tr>
';

// Fetch and print all the records....
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="edit_user.php?id=' . $row['customer_id'] . '">Edit</a></td>
		<td align="left"><a href="delete_user.php?id=' . $row['customer_id'] . '">Delete</a></td>
		<td align="left">' . $row['last_name'] . '</td>
		<td align="left">' . $row['first_name'] . '</td>
		<td align="left">' . $row['dr'] . '</td>
	</tr>
	';
} // End of WHILE loop.

echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbc);

// Make the links to other pages, if necessary.
if ($pages > 1) {
	
	echo '<br /><div class ="page_selector">';
	$current_page = ($start/$display) + 1;
	$top = $current_page +5;
	$bottom = $current_page -5;
	//echo '<br/>'.$bottom.$current_page.$top.'<br/>';
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="view_customers.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if($pages<10){
			if ($i != $current_page) {
				echo '<a href="view_customers.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
			} else {
				echo $i . ' ';
			}
		}else{

			if ( $i != $current_page) {
				if($i > $bottom && $i < $top){
					echo '<a href="view_customers.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
				}elseif($i == 1 ){
					echo '<a href="view_customers.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">First</a> ';
				}elseif($i == $pages){
					echo '<a href="view_customers.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">Last</a> ';
				}elseif($i == $bottom){
					echo '<a href="view_customers.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">...' . $i . '</a> ';
				}elseif($i == $top){
					echo '<a href="view_customers.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '...</a> ';
				}
			} elseif ($i = $current_page) {
				echo $i . ' ';
			}
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="view_customers.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</div>'; // Close the div.
	
} // End of links section.
	
include ('includes/footer.html');
?>