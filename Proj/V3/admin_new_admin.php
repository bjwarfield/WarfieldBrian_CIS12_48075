<?php 
session_name('PHPADMINID');
session_start(); // Access the existing session.
$page_title = 'Edit Administrator';
include ('includes/admin.html');//admin header
include("debug.php")

//include validator script
?>
<script type="text/javascript" src="includes/validator.js"></script>
<?php
@require ('project_DBconnect.php'); // Connect to the db.



//process form validation post
if((isset($_POST['edit'])) && $_POST['edit'] ==1 ){

	$errors = array(); // Initialize an error array.
	
	// Check for a first name:
	if (empty($_POST['first_name'])) {
		$errors[] = 'Missing First Name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}
	
	// Check for a last name:
	if (empty($_POST['last_name'])) {
		$errors[] = 'Missing Last Name.';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}
	
	// Check for an email address:
	if(empty($_POST['email'])){
		$errors[] = "Missing email.";
	}else{
		if(preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $_POST['email'])){
			$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
			$e_query = "SELECT admin_id FROM bw1780661_entity_administrators WHERE email = '$e' ;";
			//out_var($e_query);
			$e_check = @mysqli_query($dbc, $e_query); 
			if(mysqli_num_rows($e_check)>0){
				$errors[] = "Email already registered";
			}
			if(is_object($e_check))$e_check->free();
		}else{
			$errors[]= "Please inter a Valid Email Address (name@user.domain)";
		}
	}
	// Check for a password and match against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			if(preg_match("/^([a-zA-Z0-9@#$%]{6,20})$/", $_POST['pass1'])){
				$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
			}else{
				$errors[]= 'Password must be 6-20 characters long, AlphaNumeric or @ # $ %';
			}
		}
	} else {
		$errors[] = 'Missing password.';
	}
	if (empty($errors)) { // If everything's OK.
		
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO bw1780661_entity_administrators VALUES (NULL, '$fn', '$ln', '$e', SHA1('$p'), 1);";	
		
		// out_var($q);
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo "<div class=\"confirm\">
				<h1>Confirmed</h1>
				<p>Administrator <strong>".stripcslashes($fn)." ".stripcslashes($ln)."</strong> sucessfully Registered</p>
			</div>
			<p><a href='admin_index.php.php'>Redirecting</a> in 5 secs.</p>";
			header( "refresh:5;url=admin_index.php" ); 
			include('includes/footer.html');
			exit();
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error"> Changes could not be registered due to a system error. We apologize for any inconvenience. </p> ';
			
			// Debugging message:
			echo '<p> ' . mysqli_error($dbc) . '<br /> <br /> Query: ' . $q . '</p> ';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer.html'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1> 
		<p class="error"> The following error(s) occurred: <br /> ';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg <br /> \n"; 
		}
		echo '</p> <p>Please try again.</p> <p> <br /> </p> ';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

}

#Output Form
echo '
<h1>Edit Administrator Info</h1>
<form name="admin_new_admin" action="admin_new_admin.php" method="post">
	<p> First Name: <input type="text" name="first_name" id="first_name" required="required" size="30" maxlength="25" value="'.(isset($fn)?$fn:'').'" /><label for="first_name"></label></p><br/>
	<p> Last Name: <input type="text" name="last_name" id="last_name" required="required" size="45" maxlength="40" value="'.(isset($ln)?$ln:'').'" /><label for="last_name"></label></p><br/> 
	<p> Email Address: <input type="text" name="email" id="email" required="required" pattern="\b[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b" size="40" maxlength="60" value="'.(isset($e)?$e:'').'"  /><label for="email"></label></p><br/>
	<p> Password: <input type="password" name="pass1" pattern="([a-zA-Z0-9@#$%]{6,20})" id="pass1" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>
	<p> Confirm Password: <input type="password" name="pass2" pattern="([a-zA-Z0-9@#$%]{6,20})" id="pass2" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>
	<p> <input type="submit" name="submit" value="Save Changes" /> </p><br/>
	<input type = "hidden" name="edit" value="1" />
</form>';


mysqli_close($dbc);
		
include ('includes/footer.html');

?>