<?php 
session_name('PHPADMINID');
session_start();

$page_title = 'View Registered administrators';
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
$q = "SELECT COUNT(admin_id) FROM bw1780661_entity_administrators";
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
	default:
		$order_by = 'last_name ASC';
		$sort = 'ln';
		break;
}
	
// Define the query:
$q = 'SELECT `admin_id`, `last_name`, `first_name`, `active` FROM `bw1780661_entity_administrators` ORDER BY '.$order_by.' LIMIT '.$start.', '.$display.';';		
$r = @mysqli_query ($dbc, $q); // Run the query.

//Display Pagination options
 echo '<form class="paginator" action="admin_view_administrators.php" method="get">
 			<label>Sort</label>
 			<select name="sort">
 				<option value="ln" '.(($sort=="ln")?'selected="selected"':'').'>Last Name</option>
 				<option value="fn" '.(($sort=="fn")?'selected="selected"':'').'>First Name</option>
 				</select>
				<label>Display</label>
				<select name=display>
 				<option value="5" '.(($display==5)?'selected="selected"':'').'>5</option>
					<option value="10" '.(($display==10)?'selected="selected"':'').'>10</option>
					<option value="20" '.(($display==20)?'selected="selected"':'').'>20</option>
				</select>
				<input type="submit" value="Submit">
				<input name="s" type="hidden" value="'.$start.'">
		</form>';
// Table header:
echo '<table class="administrator_list">
<thead>
<tr>
		<th>Action</th>
		<th>Last Name</th>
		<th>First Name</th>
		<th>Status</th>
</tr>
</thead><tbody>
';

// Fetch and print all the records.... 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	//out_obj($row);
		echo '<tr>
		<td><form action="admin_edit_admin.php" method="post">
		<input type="hidden" name="admin_id" value="'.$row['admin_id'].'" ><input type="submit" value="Edit" '.($row['admin_id']==$_SESSION['admin_id']?"disabled='disabled'":"").'></form></td>
		<td>'.$row['last_name'].'</td>
		<td>'.$row['first_name'].'</td>
		<td>'.($row['active']==TRUE?'Active':'Inactive').'</td>
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
		echo '<a href="admin_view_administrators.php?s=' . ($start - $display) . '&display=' . $display . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		//regular links for less than 10 pages
		if($pages<10){
			if ($i != $current_page) {
				echo '<a href="admin_view_administrators.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '</a> ';
			} else {//current page, no link
				echo $i . ' ';
			}
		}else{
			//truncated links for more than 10 pages
			if ( $i != $current_page) {
				if($i > $bottom && $i < $top){//links adjasent to currrent page
					echo '<a href="admin_view_administrators.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '</a> ';
				}elseif($i == 1 ){//set first link
					echo '<a href="admin_view_administrators.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">First</a> ';
				}elseif($i == $pages){//set last link
					echo '<a href="admin_view_administrators.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">Last</a> ';
				}elseif($i == $bottom){//mark truncation points with elipses
					echo '<a href="admin_view_administrators.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">...' . $i . '</a> ';
				}elseif($i == $top){
					echo '<a href="admin_view_administrators.php?s=' . (($display * ($i - 1))) . '&display=' . $display . '&sort=' . $sort . '">' . $i . '...</a> ';
				}
			} elseif ($i = $current_page) {//current page, no link
				echo $i . ' ';
			}
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="admin_view_administrators.php?s=' . ($start + $display) . '&display=' . $display . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</div>'; // Close the div.
	
} // End of links section.
	
include ('includes/footer.html');
?>