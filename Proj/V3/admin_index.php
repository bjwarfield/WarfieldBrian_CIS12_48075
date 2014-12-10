<?php  
session_name('PHPADMINID');
session_start();
//check for form submittion
include('debug.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	#include login functions
	require ('project_DBconnect.php');#connect to db
	require ('includes/login_functions.inc.php');

	// Check the login for administrators:
	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass'], true);

	if ($check) { // OK!
		//out_obj($data);
		// Set the session data:
		
		$_SESSION['admin_id'] = $data['admin_id'];
		$_SESSION['admin_fn'] = $data['first_name'];
		$_SESSION['admin_ln'] = $data['last_name'];
		
		// Store the HTTP_USER_AGENT:
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);

		// Redirect:
		redirect_user('admin_index.php');

			
	} else { // Unsuccessful!

		// Assign $data to $errors for login_page.inc.php:
		$errors = $data;
	}
		
	mysqli_close($dbc); // Close the database connection.

	}
$page_title = 'AdministratorHome Page'; 
include('includes/admin.html');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
	echo '<h1>Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

?>
<script type="text/javascript" src="includes/validator.js"></script>
<div style="display:<?php echo (isset($_SESSION['admin_id'])? 'none':'block') ?>;">
	<h1>Administrator Login</h1><br />
	<form action="admin_index.php" method="post">
		<p> Email Address: <input type="text" name="email" size="20" required="required" pattern="\b[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b" maxlength="60" /><label></label> </p>
		<br/>
		<p> Password: <input type="password" name="pass" size="20" required="required" maxlength="20" /><label></label> </p> <br/>
		<p> <input type="submit" name="submit" value="Login" /> </p>
	</form>
</div>
<div style="display:<?php echo (isset($_SESSION['admin_id'])? 'block':'none') ?>;" >
	<h1>Welcome to the Blade Shop Administrator View</h1>
	<p> Bacon ipsum dolor amet enim frankfurter non exercitation. Leberkas minim elit frankfurter, fatback strip steak ball tip jowl aliqua flank ham hock pork. Cow minim qui sirloin alcatra adipisicing. Consectetur pancetta drumstick kielbasa t-bone cillum aliqua duis et laboris lorem in tail meatloaf. </p>
</div>
<?php include('includes/footer.html'); ?>