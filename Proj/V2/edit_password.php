<?php 
session_start(); // Access the existing session.

function show_confirmation($type){#check get for comfimation message
	return isset($_GET["showmsg"]) && $_GET["showmsg"] == $type; 
}

$page_title = 'Change User Password';
include ('includes/header.html');//admin header
//out_obj($_POST);

#Check for Cust ID
if((isset($_SESSION['customer_id'])) && (is_numeric($_SESSION['customer_id']))){
	$customer_id = $_SESSION['customer_id'];
}else{
	echo '<p class="error">This page has been accessed in error.</p>
	<p>You will be <a href="index.php">redirected</a> to the homepage in 5 secs.</p>';
	header( "refresh:5;url=index.php" ); 

	include ('includes/footer.html'); 
	exit();
}

?>
<script type="text/javascript" src="includes/validator.js" ></script><!-- Javascript validator -->
<?php

@require ('project_DBconnect.php'); // Connect to the db.

if(show_confirmation("confirm")){
	echo '<div class="confirm"><h1>Confirmed</h1>
		<p>Password Updated</p></div>';
}else if(show_confirmation("error")){
	echo '<div class="error">
		<h1>ERROR</h1>
		<p>Password update failed due to system error. Please contact system administrator.</p>
	</div>';
}else if(show_confirmation("badpass")){
	echo '<div class="error">
		<h1>ERROR!</h1>
		<p>Old Password does not match password on record</p>
	</div>';
}

if($_SERVER["REQUEST_METHOD"]=="POST"){

	$errors = array(); // Initialize an error array.

	// Check for the current password:
	if (empty($_POST['pass'])) {
		$errors[] = 'Please enter current password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
	}

	// Check for a new password and match 
	// against the confirmed password:
	if (!empty($_POST['pass1'])) {
		if ($_POST['pass1'] != $_POST['pass2']) {
			$errors[] = 'Your new password did not match the confirmed password.';
		} else {
			$np = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	} else {
		$errors[] = 'You forgot to enter your new password.';
	}
	

	if (empty($errors)) { // If everything's OK.
	
		// Check old password
		
		// Make the query:
		$q = "SELECT `customer_id` FROM `bw1780661_entity_customers` WHERE (customer_id = $customer_id AND pass = SHA1('$p'))";	
		
		//out_var($q);
		$r = @mysqli_query ($dbc, $q); // Run the query.

		if ($r->num_rows == 1) { //if old Password matches
			$r->free;//clear results
			$q="UPDATE `bw1780661_entity_customers` SET `pass` = SHA1('$np') WHERE `customer_id` = $customer_id";
			$r = @mysqli_query($dbc, $q);//update with new password
			if(mysqli_affected_rows($dbc)==1){//successful update
				header( "Location:".$_SERVER["PHP_SELF"].'?showmsg=confirm' ); 
				include('includes/footer.html');
				$r->free;//clear results
				mysqli_close($dbc);//close connection
				exit();

			}else{
				header( "Location:".$_SERVER["PHP_SELF"].'?showmsg=error' ); 
				include('includes/footer.html');
				$r->free;//clear results
				mysqli_close($dbc);//close connection
				exit();
			}
		} else { // Old Password Check Fail
			
			header( "Location:".$_SERVER["PHP_SELF"].'?showmsg=badpass' ); 
			include('includes/footer.html');
			exit();
						
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

$q = "SELECT * FROM `bw1780661_entity_customers` WHERE `customer_id` = $customer_id;";
$r = @mysqli_query($dbc, $q);

if ($r->num_rows == 1){
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);

	#Output Form
	echo '
	<h1>Edit Password</h1>
	<form name="edit_password" action="edit_password.php" method="post">
		<p> Old Password: <input type="password" name="pass" id="pass" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>
		<p> New Password: <input type="password" name="pass1" id="pass1" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>
		<p> Confirm New Password: <input type="password" name="pass2" id="pass2" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>

	<p> <input type="submit" name="submit" value="Save Changes" /> </p><br/>
</form>';
}else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p>
	<p>You will be <a href="index.php">redirected</a> to the homepage in 5 secs.</p>';
	header( "refresh:5;url=index.php" ); 
}

mysqli_close($dbc);
		
include ('includes/footer.html');

?>