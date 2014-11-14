<?php 

$page_title = 'View the Current Users';
include ('includes/header.html');

echo '<h1>Registered Users</h1>';

@require ('../../../../mysqli_connect.php'); 

$q = "SELECT last_name, first_name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr, user_id FROM users ORDER BY registration_date ASC";//build query		
$r = @mysqli_query ($dbc, $q);// run query

$num = mysqli_num_rows($r);


if ($num > 0) { // If successfull
	echo "<p>Registered Users: ".$num."</p>";
	//print_r($r);

	//table header
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	<tr>
		<td align="left"> <b>Edit</b> </td>
		<td align="left"> <b>Delete</b> </td>
		<td align="left"> <b>Last Name</b> </td>
		<td align="left"> <b>First Name</b> </td>
		<td align="left"> <b>Date Registered</b> </td>
	</tr>
';
	// loop through records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '
		<tr>
			<td align="left">
				<form action="edit_user.php" method="post">
					<input type="hidden" name="id" value="' .$row['user_id']. '" />	
					<input type="submit" name="submit" value="Edit" />	
				</form>
			</td>
			<td align="left">
				<form action="delete_user.php" method="post">
					<input type="hidden" name="id" value="' .$row['user_id']. '" />	
					<input type="submit" name="submit" value="Delete" />	
				</form>
			</td>
			<td align="left">' . $row['last_name'] . '</td>
			<td align="left">' . $row['first_name'] . '</td>
			<td align="left">' . $row['dr'] . '</td>
		</tr>
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