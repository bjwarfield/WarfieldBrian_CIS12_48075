<?php 
session_name('PHPADMINID');
session_start(); // Access the existing session.

function show_confirmation($type){#check get for comfimation message
	return isset($_GET["showmsg"]) && $_GET["showmsg"] == $type; 
}

$page_title = 'Change User Password';
include ('includes/admin.html');//admin header
//out_obj($_POST);

#Check for Admin ID
if((isset($_SESSION['admin_id'])) && (is_numeric($_SESSION['admin_id']))){
	$admin_id = $_SESSION['admin_id'];
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

//display error or success message
if(show_confirmation("confirm")){
	echo '<div class="confirm"><h1>Confirmed</h1>
		<p>Password Updated</p></div>';
}else if(show_confirmation("error")){
	echo '<h1 class="error">ERROR</h1>
	<p>Password update failed due to system error. Please contact system administrator.</p>';
}else if(show_confirmation("badpass")){
	echo '<h1 class="error">ERROR!</h1>
	<p>Old Password does not match password on record</p>';
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
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			if(preg_match("/^([a-zA-Z0-9@#$%]{6,20})$/", $_POST['pass1'])){
				$np = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
			}else{
				$errors[]= 'Password must be 6-20 characters long, AlphaNumeric or @ # $ %';
			}
		}
	} else {
		$errors[] = 'Missing new password.';
	}
	

	if (empty($errors)) { // If everything's OK.
	
		// Check old password
		
		// Make the query:
		$q = "SELECT `admin_id` FROM `bw1780661_entity_administrators` WHERE (admin_id = $admin_id AND pass = SHA1('$p'))";	
		
		//out_var($q);
		$r = @mysqli_query ($dbc, $q); // Run the query.

		if ($r->num_rows == 1) { //if old Password matches
			$r->free;//clear results
			$q="UPDATE `bw1780661_entity_administrators` SET `pass` = SHA1('$np') WHERE `admin_id` = $admin_id";
			$r = @mysqli_query($dbc, $q);//update with new password
			if(mysqli_affected_rows($dbc)==1){//successful update
				header( "Location:".$_SERVER["PHP_SELF"].'?showmsg=confirm' ); 
				include('includes/footer.html');
				if(is_object($r))$r->free;//clear results
				mysqli_close($dbc);//close connection
				exit();

			}else{
				header( "Location:".$_SERVER["PHP_SELF"].'?showmsg=error' ); 
				include('includes/footer.html');
				if(is_object($r))$r->free;//clear results
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
	
		echo '<div class="error">
			<h1>Error!</h1> 
			<p> The following error(s) occurred: <br /> ';
			foreach ($errors as $msg) { // Print each error.
				echo " - $msg <br /> \n"; 
			}
			echo '</p> <p>Please try again.</p> <p> <br /> </p>
		</div> ';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

}

$q = "SELECT * FROM `bw1780661_entity_administrators` WHERE `admin_id` = $admin_id;";
$r = @mysqli_query($dbc, $q);

if ($r->num_rows == 1){
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);

	#Output Form
	echo '
	<h1>Edit Password</h1>
	<form name="edit_password" action="admin_edit_password.php" method="post">
		<p> Old Password: <input type="password" name="pass" id="pass" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>
		<p> New Password: <input type="password" name="pass1" pattern="([a-zA-Z0-9@#$%]{6,20})" id="pass1" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>
		<p> Confirm New Password: <input type="password" name="pass2" pattern="([a-zA-Z0-9@#$%]{6,20})" id="pass2" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>

	<p> <input type="submit" name="submit" value="Update Password" /> </p><br/>
</form>';
}else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p>
	<p>You will be <a href="admin_index.php">redirected</a> to the homepage in 5 secs.</p>';
	// header( "refresh:5;url=index.php" ); 
}
if(is_object($r))$r->free();
mysqli_close($dbc);
		
include ('includes/footer.html');

?>