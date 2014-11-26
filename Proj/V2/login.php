<?php 
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	#include login functions
	require ('includes/login_functions.inc.php');
	require ('project_DBconnect.php');#connect to db
		
	// Check the login:
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);#pass email and password, get success/fail indicator and [customer_id, first_name] 
	
	if ($check) { // OK!
		
		// Set the session data:
		session_start();
		$_SESSION['customer_id'] = $data['customer_id'];
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['last_name'] = $data['last_name'];
		
		// Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);

		// Redirect:
		redirect_user('loggedin.php');
			
	} else { // Unsuccessful!

		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;

	}
		
	mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

// Create the page:
?>
<script type="text/javascript" src="validator.js"></script>
<?php
// Include the header:
$page_title = 'User Login';
include ('includes/header.html');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Display the form:
echo '
<h1>Login</h1>
<form action="login.php" method="post">
	<p>Email Address: <input type="text" name="email" size="20" required="required" maxlength="60" /><label></label> </p><br/>
	<p>Password: <input type="password" name="pass" size="20" required="required" maxlength="20" /><label></label></p><br/>
	<p><input type="submit" name="submit" value="Login" /> </p>
</form>';

include ('includes/footer.html');
?>