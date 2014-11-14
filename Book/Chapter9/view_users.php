<?php 

$page_title = 'View the Current Users';
include ('includes/header.html');

echo '<h1>Registered Users</h1>';

@require ('../../../../mysqli_connect.php'); 

$q = "SELECT CONCAT(last_name, ', ', first_name) AS name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr FROM users ORDER BY registration_date ASC";//build query		
$r = @mysqli_query ($dbc, $q);// run query

$num = mysqli_num_rows($r);


if ($num > 0) { // If successfull
	echo "<p>Registered Users: ".$num."</p>";
	//print_r($r);

	//table header
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	<tr><td align="left"><b>Name</b></td><td align="left"><b>Date Registered</b></td></tr>
';
	// loop through records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['name'] . '</td><td align="left">' . $row['dr'] . '</td></tr>
		';
	}
	echo '</table>'; //End Table
	mysqli_free_result ($r); // Free up the resources.	

} else { // If error
	// Error message
	echo '<p class="error">ERROR!ERROR!ERROR!ERROR!ERROR!ERROR!ERROR!ERROR!ERROR!.</p>';
	echo "<p>There are no users to display</p>";
	// Debugging
	//echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
} // End of if ($r).
mysqli_close($dbc);
include ('includes/footer.html');
?>