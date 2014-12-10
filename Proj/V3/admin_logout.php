<?php 
session_name('PHPADMINID');
session_start(); // Access the existing session.

// If no session variable exists, redirect the user:
if (!isset($_SESSION['admin_id'])) {

	// include login functions:
	require ('includes/login_functions.inc.php');
	redirect_user('admin_index.php');	
	
} else { // Cancel the session:

	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPADMINID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

}
header('refresh:5;url=admin_index.php');//redirect to adminling page after 5 secs
// Set the page title and include the HTML header:
$page_title = 'Logged Out!';
include ('includes/admin.html');

// Print a customized message:
echo "<h1>Logged Out!</h1>
<p>You are now logged out!</p>
<p>You wil be <a href='admin_index.php'>redirected</a> in 5 secs</p>";

include ('includes/footer.html');
?>