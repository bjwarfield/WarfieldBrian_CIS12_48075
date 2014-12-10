<?php 
session_start();
$page_title = 'Register New User';
include ('includes/header.html');
// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	@require ('project_DBconnect.php'); // Connect to the db.
		
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
			$e_query = "SELECT customer_id FROM bw1780661_entity_customers WHERE email = '$e'";
			$e_check = @mysqli_query($dbc, $e_query); 
			if(mysqli_num_rows($e_check)>0){
				$errors[] = "Email already registered";
			}
			$e_check->free();
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
	// Check for Company
	if (empty($_POST['company'])) {
	} else {
		$co = mysqli_real_escape_string($dbc, trim($_POST['company']));
	}	
	// Check for Adddress 1:
	if (empty($_POST['address_1'])) {
		$errors[] = "Missing Adddress 1";
	} else {
		$ad1 = mysqli_real_escape_string($dbc, trim($_POST['address_1']));
	}
	// Check for Adddress 2:
	if (empty($_POST['address_2'])) {
		$ad2='';
	} else {
		$ad2 = mysqli_real_escape_string($dbc, trim($_POST['address_2']));
	}	
	#check City
	if (empty($_POST['city'])) {
	} else {
		$city = mysqli_real_escape_string($dbc, trim($_POST['city']));
	}	
	#check state
	if (empty($_POST['state'])) {
		$errors[] = 'Please Select a State';
	} else {
		if(preg_match("/(^AL$|^AK$|^AZ$|^AR$|^CA$|^CO$|^CT$|^DE$|^FL$|^GA$|^HI$|^ID$|^IL$|^IN$|^IA$|^KS$|^KY$|^LA$|^ME$|^MD$|^MA$|^MI$|^MN$|^MS$|^MO$|^MT$|^NE$|^NV$|^NH$|^NJ$|^NM$|^NY$|^NC$|^ND$|^OH$|^OK$|^OR$|^PA$|^RI$|^SC$|^SD$|^TN$|^TX$|^UT$|^VT$|^VA$|^WA$|^WV$|^WI$|^WY$)/i", $_POST['state'])) {
			$state = mysqli_real_escape_string($dbc, trim($_POST['state']));
		}else{
			$errors[] = 'State entry error, pleae contact Administrator';
		}
	}
	#check ZIP CODE
	if (empty($_POST['zip_code'])) {
	} else {
		$zip_check = preg_replace("/[^0-9]/", "", $_POST['zip_code']);
		if(preg_match("/^\d{5}(?:\d{4})?$/", $zip_check)){
				$zip = mysqli_real_escape_string($dbc, trim($zip_check));
		}else{
			$errors[] = "Please enter valid 5 or 9 digit Zip Code";
		}
	}
	#check Phone 1
	if (empty($_POST['phone_1'])) {
	} else {
		$p_check = preg_replace("/[^0-9]/", "", $_POST['phone_1']);
		if(preg_match("/^\d{10}$/", $p_check)){
				$p1 = mysqli_real_escape_string($dbc, trim($p_check));
		}else{
			$errors[] = "Please enter valid 10 digit Primary Phone Number";
		}
	}
		#check Phone 2
	if (empty($_POST['phone_2'])) {
		$p2 = "";
	} else {
		$p_check = preg_replace("/[^0-9]/", "", $_POST['phone_2']);
		if(preg_match("/^\d{10}$/", $p_check)){
				$p2 = mysqli_real_escape_string($dbc, trim($p_check));
		}else{
			$errors[] = "Please enter valid 10 digit Secondary Phone Number";
		}
	}
	if (empty($_POST['security_question'])) {
		$errors[] = "Missing Security Question";
	} else {
		$sq = mysqli_real_escape_string($dbc, trim($_POST['security_question']));
	}	
	if (empty($_POST['security_answer'])) {
		$errors[] = "Missing Security Answer";
	} else {
		$sa = mysqli_real_escape_string($dbc, trim($_POST['security_answer']));
	}		
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO bw1780661_entity_customers (`first_name`, `last_name`, `email`, `pass`, `registration_date`, `company`, `address_1`, `address_2`, `city`, `state`, `zip_code`, `security_question`, `security_answer`, `phone_1`, `phone_2`, `customer_status_id`) 
		VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW(), '$co', '$ad1', '$ad2', '$city', '$state', '$zip', '$sq', '$sa', '$p1', '$p2', 1);";	
		
		//out_var($q);
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>Thank you!</h1>
			<p>You are now registered.</p>
			<p> <br /> </p> ';
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error"> You could not be registered due to a system error. We apologize for any inconvenience. </p> ';
			
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

} // End of the main Submit conditional.
?>
<script type="text/javascript" src="includes/validator.js"></script><!-- Javascript Validator -->
<h1>Register</h1>
<form name="register_form "action="register.php" method="post">
<p> First Name: <input type="text" name="first_name" id="first_name" required="required" size="30" maxlength="25" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /><label></label></p><br/>
<p> Last Name: <input type="text" name="last_name" id="last_name" required="required" size="45" maxlength="40" value="<?php if (isset($_POST['last_name'])) echo $_POST['last_name']; ?>" /><label></label></p><br/> 
<p> Company: <input type="text" name="company" id="company" size="50" maxlength="45" value="<?php if (isset($_POST['company'])) echo $_POST['company']; ?>"  /><label></label></p><br/>
<p> Email Address: <input type="text" name="email" id="email" required="required" pattern="\b[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b" size="45" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /><label></label></p><br/>
<p> Password: <input type="password" name="pass1" id="pass1" required="required" pattern="^([a-zA-Z0-9@#$%]{6,20})$" size="25" maxlength="20" value=""  /><label></label></p><br/>
<p> Confirm Password: <input type="password" name="pass2" id="pass2" required="required" size="25" maxlength="20" value=""  /><label></label></p><br/>
<p> Address 1: <input type="text" name="address_1" id="address_1" required="required" size="50" maxlength="45" value="<?php if (isset($_POST['address_1'])) echo $_POST['address_1']; ?>"  /><label></label></p><br/>
<p> Address 2: <input type="text" name="address_2" id="address_2" size="50" maxlength="45" value="<?php if (isset($_POST['address_2'])) echo $_POST['address_2']; ?>"  /><label></label></p><br/>
<p> City: <input type="text" name="city" id="city" size="30" required="required" maxlength="52" value="<?php if (isset($_POST['city'])) echo $_POST['city']; ?>"  /><label></label></p><br/>
<p> State <select name="state" id="state">
		<option value="">Select State</option>
		<option value="AL" <?PHP if(isset($_POST['state']) && $_POST['state'] == "AL")echo 'selected' ?>>Alabama</option>
		<option value="AK" <?PHP if(isset($_POST['state']) && $_POST['state'] == "AK")echo 'selected' ?>>Alaska</option>
		<option value="AZ" <?PHP if(isset($_POST['state']) && $_POST['state'] == "AZ")echo 'selected' ?>>Arizona</option>
		<option value="AR" <?PHP if(isset($_POST['state']) && $_POST['state'] == "AR")echo 'selected' ?>>Arkansas</option>
		<option value="CA" <?PHP if(isset($_POST['state']) && $_POST['state'] == "CA")echo 'selected' ?>>California</option>
		<option value="CO" <?PHP if(isset($_POST['state']) && $_POST['state'] == "CO")echo 'selected' ?>>Colorado</option>
		<option value="CT" <?PHP if(isset($_POST['state']) && $_POST['state'] == "CT")echo 'selected' ?>>Connecticut</option>
		<option value="DE" <?PHP if(isset($_POST['state']) && $_POST['state'] == "DE")echo 'selected' ?>>Delaware</option>
		<option value="FL" <?PHP if(isset($_POST['state']) && $_POST['state'] == "FL")echo 'selected' ?>>Florida</option>
		<option value="GA" <?PHP if(isset($_POST['state']) && $_POST['state'] == "GA")echo 'selected' ?>>Georgia</option>
		<option value="HI" <?PHP if(isset($_POST['state']) && $_POST['state'] == "HI")echo 'selected' ?>>Hawaii</option>
		<option value="ID" <?PHP if(isset($_POST['state']) && $_POST['state'] == "ID")echo 'selected' ?>>Idaho</option>
		<option value="IL" <?PHP if(isset($_POST['state']) && $_POST['state'] == "IL")echo 'selected' ?>>Illinois</option>
		<option value="IN" <?PHP if(isset($_POST['state']) && $_POST['state'] == "IN")echo 'selected' ?>>Indiana</option>
		<option value="IA" <?PHP if(isset($_POST['state']) && $_POST['state'] == "IA")echo 'selected' ?>>Iowa</option>
		<option value="KS" <?PHP if(isset($_POST['state']) && $_POST['state'] == "KS")echo 'selected' ?>>Kansas</option>
		<option value="KY" <?PHP if(isset($_POST['state']) && $_POST['state'] == "KY")echo 'selected' ?>>Kentucky</option>
		<option value="LA" <?PHP if(isset($_POST['state']) && $_POST['state'] == "LA")echo 'selected' ?>>Louisiana</option>
		<option value="ME" <?PHP if(isset($_POST['state']) && $_POST['state'] == "ME")echo 'selected' ?>>Maine</option>
		<option value="MD" <?PHP if(isset($_POST['state']) && $_POST['state'] == "MD")echo 'selected' ?>>Maryland</option>
		<option value="MA" <?PHP if(isset($_POST['state']) && $_POST['state'] == "MA")echo 'selected' ?>>Massachusetts</option>
		<option value="MI" <?PHP if(isset($_POST['state']) && $_POST['state'] == "MI")echo 'selected' ?>>Michigan</option>
		<option value="MN" <?PHP if(isset($_POST['state']) && $_POST['state'] == "MN")echo 'selected' ?>>Minnesota</option>
		<option value="MS" <?PHP if(isset($_POST['state']) && $_POST['state'] == "MS")echo 'selected' ?>>Mississippi</option>
		<option value="MO" <?PHP if(isset($_POST['state']) && $_POST['state'] == "MO")echo 'selected' ?>>Missouri</option>
		<option value="MT" <?PHP if(isset($_POST['state']) && $_POST['state'] == "MT")echo 'selected' ?>>Montana</option>
		<option value="NE" <?PHP if(isset($_POST['state']) && $_POST['state'] == "NE")echo 'selected' ?>>Nebraska</option>
		<option value="NV" <?PHP if(isset($_POST['state']) && $_POST['state'] == "NV")echo 'selected' ?>>Nevada</option>
		<option value="NH" <?PHP if(isset($_POST['state']) && $_POST['state'] == "NH")echo 'selected' ?>>New Hampshire</option>
		<option value="NJ" <?PHP if(isset($_POST['state']) && $_POST['state'] == "NJ")echo 'selected' ?>>New Jersey</option>
		<option value="NM" <?PHP if(isset($_POST['state']) && $_POST['state'] == "NM")echo 'selected' ?>>New Mexico</option>
		<option value="NY" <?PHP if(isset($_POST['state']) && $_POST['state'] == "NY")echo 'selected' ?>>New York</option>
		<option value="NC" <?PHP if(isset($_POST['state']) && $_POST['state'] == "NC")echo 'selected' ?>>North Carolina</option>
		<option value="ND" <?PHP if(isset($_POST['state']) && $_POST['state'] == "ND")echo 'selected' ?>>North Dakota</option>
		<option value="OH" <?PHP if(isset($_POST['state']) && $_POST['state'] == "OH")echo 'selected' ?>>Ohio</option>
		<option value="OK" <?PHP if(isset($_POST['state']) && $_POST['state'] == "OK")echo 'selected' ?>>Oklahoma</option>
		<option value="OR" <?PHP if(isset($_POST['state']) && $_POST['state'] == "OR")echo 'selected' ?>>Oregon</option>
		<option value="PA" <?PHP if(isset($_POST['state']) && $_POST['state'] == "PA")echo 'selected' ?>>Pennsylvania</option>
		<option value="RI" <?PHP if(isset($_POST['state']) && $_POST['state'] == "RI")echo 'selected' ?>>Rhode Island</option>
		<option value="SC" <?PHP if(isset($_POST['state']) && $_POST['state'] == "SC")echo 'selected' ?>>South Carolina</option>
		<option value="SD" <?PHP if(isset($_POST['state']) && $_POST['state'] == "SD")echo 'selected' ?>>South Dakota</option>
		<option value="TN" <?PHP if(isset($_POST['state']) && $_POST['state'] == "TN")echo 'selected' ?>>Tennessee</option>
		<option value="TX" <?PHP if(isset($_POST['state']) && $_POST['state'] == "TX")echo 'selected' ?>>Texas</option>
		<option value="UT" <?PHP if(isset($_POST['state']) && $_POST['state'] == "UT")echo 'selected' ?>>Utah</option>
		<option value="VT" <?PHP if(isset($_POST['state']) && $_POST['state'] == "VT")echo 'selected' ?>>Vermont</option>
		<option value="VA" <?PHP if(isset($_POST['state']) && $_POST['state'] == "VA")echo 'selected' ?>>Virginia</option>
		<option value="WA" <?PHP if(isset($_POST['state']) && $_POST['state'] == "WA")echo 'selected' ?>>Washington</option>
		<option value="WV" <?PHP if(isset($_POST['state']) && $_POST['state'] == "WV")echo 'selected' ?>>West Virginia</option>
		<option value="WI" <?PHP if(isset($_POST['state']) && $_POST['state'] == "WI")echo 'selected' ?>>Wisconsin</option>
		<option value="WY" <?PHP if(isset($_POST['state']) && $_POST['state'] == "WY")echo 'selected' ?>>Wyoming</option>
	</select>
</p><br/>
<p> ZIP Code: <input type="text" name="zip_code" id="zip_code" required="required" pattern="^\d{5}(?:-\d{4})?$" size="15" maxlength="10" value="<?php if (isset($_POST['zip_code'])) echo $_POST['zip_code']; ?>"  /><label></label></p><br/>
<p> Security Question: <input type="text" name="security_question" id="security_question" required="required" size="50" maxlength="45" value="<?php if (isset($_POST['security_question'])) echo $_POST['security_question']; ?>"  /><label></label></p><br/>
<p> Security Answer: <input type="text" name="security_answer" id="security_answer" required="required" size="50" maxlength="45" value="<?php if (isset($_POST['security_answer'])) echo $_POST['security_answer']; ?>"  /><label></label></p><br/>
<p> Primary Phone: <input type="text" name="phone_1" id="phone_1" required="required" pattern="^\(\d{3}\)\d{3}-\d{4}$" size="15" size="15" maxlength="15" value="<?php if (isset($_POST['phone_1'])) echo $_POST['phone_1']; ?>"  /><label></label></p><br/>
<p> Secondary Phone: <input type="text" name="phone_2" id="phone_2" pattern="^\(\d{3}\)\d{3}-\d{4}$|^$" size="15" maxlength="15" value="<?php if (isset($_POST['phone_2'])) echo $_POST['phone_2']; ?>"  /><label></label></p><br/>

<p> <input type="submit" id="submit" name="submit" value="Register" /> </p><br/>
</form>
<?php include ('includes/footer.html'); ?>