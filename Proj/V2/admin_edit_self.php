<?php 
session_name('PHPADMINID');
session_start(); // Access the existing session.
$page_title = 'Edit Administrator';
include ('includes/admin.html');//admin header

//include validator script
?>
<script type="text/javascript" src="includes/validator.js"></script>
<?php
#Check for Cust ID
if((isset($_SESSION['admin_id'])) && (is_numeric($_SESSION['admin_id']))){
	$admin_id = $_SESSION['admin_id'];
}else{
	echo '<p class="error">This page has been accessed in error.</p>
	<p>You will be <a href="admin_index.php">redirected</a> to the homepage in 5 secs.</p>';
	header( "refresh:5;url=admin_index.php" ); 

	include ('includes/footer.html'); 
	exit();
}

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
			$e_query = "SELECT admin_id FROM bw1780661_entity_administrators WHERE email = '$e' && admin_id != $admin_id;";
			//out_var($e_query);
			$e_check = @mysqli_query($dbc, $e_query); 
			if(mysqli_num_rows($e_check)>0){
				$errors[] = "Email already registered";
			}
			$e_check->free();
		}else{
			$errors[]= "Please inter a Valid Email Address (name@user.domain)";
		}
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "UPDATE bw1780661_entity_administrators SET `first_name` = '$fn', `last_name` = '$ln', `email` =  '$e' WHERE `bw1780661_entity_administrators`.`admin_id` = $admin_id;";	
		
		//out_var($q);
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
			$_SESSION['admin_fn'] = $fn;
			$_SESSION['admin_ln'] = $ln;
		
			// Print a message:
			echo "<h1>Confirmed</h1>
			<p>Administrator <strong>".stripcslashes($fn)." ".stripcslashes($ln)."</strong> sucessfully Updated</p>
			<p><a href='admin_index.php'>Redirecting</a> in 5 secs.</p>";
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

$q = "SELECT * FROM `bw1780661_entity_administrators` WHERE `admin_id` = $admin_id;";
$r = @mysqli_query($dbc, $q);

if ($r->num_rows == 1){
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);

	#Output Form
	echo '
	<h1>Edit Administrator Info</h1>
	<form name="admin_edit_self" action="admin_edit_self.php" method="post">
		<p> First Name: <input type="text" name="first_name" id="first_name" required="required" size="30" maxlength="25" value="'.$row['first_name'].'" /><label for="first_name"></label></p><br/>
		<p> Last Name: <input type="text" name="last_name" id="last_name" required="required" size="45" maxlength="40" value="'.$row['last_name'].'" /><label for="last_name"></label></p><br/> 
		<p> Email Address: <input type="text" name="email" id="email" required="required" pattern="\b[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b" size="40" maxlength="60" value="'. $row['email'].'"  /><label for="email"></label></p><br/>
	<p> <input type="submit" name="submit" value="Save Changes" /> </p><br/>
	<input type = "hidden" name="edit" value="1" />
</form>';
}else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p>
	<p>You will be <a href="index.php">redirected</a> to the homepage in 5 secs.</p>';
	header( "refresh:5;url=index.php" ); 
}

mysqli_close($dbc);
		
include ('includes/footer.html');

?>