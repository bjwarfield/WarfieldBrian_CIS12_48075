<?php 
session_name('PHPADMINID');
session_start();

$page_title = 'Edit User';
include ('includes/admin.html');//admin header
include('debug.php');//debug scripts

#Check for Cust ID
if((isset($_POST['customer_id'])) && (is_numeric($_POST['customer_id']))){
	$customer_id = $_POST['customer_id'];
}else{
	echo '<p class="error">This page has been accessed in error.</p>';
	include ('includes/footer.html'); 
	exit();
}

?>
<script type="text/javascript" src="includes/validator.js" ></script><!-- Javascript validator -->
<?php

@require ('project_DBconnect.php'); // Connect to the db.





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
			$e_query = "SELECT customer_id FROM bw1780661_entity_customers WHERE email = '$e' && customer_id != $customer_id;";
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
	$csid = mysqli_real_escape_string($dbc, trim($_POST['customer_status_id']));
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "UPDATE bw1780661_entity_customers SET `first_name` = '$fn', `last_name` = '$ln', `email` =  '$e', `company` = '$co', `address_1` = '$ad1', `address_2` = '$ad2' , `city` = '$city', `state` = '$state', `zip_code` = '$zip', `phone_1` = '$p1', `phone_2` = '$p2', `customer_status_id`= $csid WHERE `bw1780661_entity_customers`.`customer_id` = $customer_id;";	
		
		//out_var($q);
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo "<h1>Confirmed</h1>
			<p>Customer <strong>$fn $ln</strong> sucessfully Updated</p>
			<p>You will be <a href='admin_view_customers.php'>redirected</a> in 5 secs.</p>";
			header( "refresh:5;url=admin_view_customers.php" ); 
		
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

}

#get enumerated list of Status IDs
$q = 'SELECT * FROM `bw1780661_enum_customer_status`';
$r = @mysqli_query($dbc, $q);
$enum_status = array();
while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC)){
	$enum_status[$row['customer_status_id']]=$row['customer_status'];
}	 
if(is_object($r))$r->free();#Free query result


$q = "SELECT * FROM `bw1780661_entity_customers` WHERE `customer_id` = $customer_id;";
$r = @mysqli_query($dbc, $q);

if ($r->num_rows == 1){
	$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);

	#Output Form
	echo '
	<h1>Edit Customer Info</h1>
	<form name="admin_edit_customer" action="admin_edit_customer.php" method="post">
		<p> First Name: <input type="text" name="first_name" id="first_name" required="required" size="30" maxlength="25" value="'.$row['first_name'].'" /><label for="first_name"></label></p><br/>
		<p> Last Name: <input type="text" name="last_name" id="last_name" required="required" size="45" maxlength="40" value="'.$row['last_name'].'" /><label for="last_name"></label></p><br/> 
		<p> Company: <input type="text" name="company" size="50" maxlength="45" value="'.$row['company'].'"  /><label for="company"></label></p><br/>
		<p> Email Address: <input type="text" name="email" id="email" required="required" pattern="\b[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b" size="40" maxlength="60" value="'. $row['email'].'"  /><label for="email"></label></p><br/>
		<p> Address 1: <input type="text" name="address_1" id="address_1" required="required" size="50" maxlength="45" value="'.$row['address_1'].'"  /><label for="address_1"></label></p><br/>
		<p> Address 2: <input type="text" name="address_2" size="50" maxlength="45" value="'.$row['address_2'].'"  /><label for="first_name"></label></p><br/>
		<p> City: <input type="text" name="city" id="city" required="required"  size="30" maxlength="52" value="'. $row['city'].'"  /><label for="address_2"></label></p><br/>
		<p> State <select name="state" id="state">
			<option value="">Select State</option>
			<option value="AL" '.($row['state'] == "AL" ? 'selected': '').'>Alabama</option>
			<option value="AK" '.($row['state'] == "AK" ? 'selected': '').'>Alaska</option>
			<option value="AZ" '.($row['state'] == "AZ" ? 'selected': '').'>Arizona</option>
			<option value="AR" '.($row['state'] == "AR" ? 'selected': '').'>Arkansas</option>
			<option value="CA" '.($row['state'] == "CA" ? 'selected': '').'>California</option>
			<option value="CO" '.($row['state'] == "CO" ? 'selected': '').'>Colorado</option>
			<option value="CT" '.($row['state'] == "CT" ? 'selected': '').'>Connecticut</option>
			<option value="DE" '.($row['state'] == "DE" ? 'selected': '').'>Delaware</option>
			<option value="FL" '.($row['state'] == "FL" ? 'selected': '').'>Florida</option>
			<option value="GA" '.($row['state'] == "GA" ? 'selected': '').'>Georgia</option>
			<option value="HI" '.($row['state'] == "HI" ? 'selected': '').'>Hawaii</option>
			<option value="ID" '.($row['state'] == "ID" ? 'selected': '').'>Idaho</option>
			<option value="IL" '.($row['state'] == "IL" ? 'selected': '').'>Illinois</option>
			<option value="IN" '.($row['state'] == "IN" ? 'selected': '').'>Indiana</option>
			<option value="IA" '.($row['state'] == "IA" ? 'selected': '').'>Iowa</option>
			<option value="KS" '.($row['state'] == "KS" ? 'selected': '').'>Kansas</option>
			<option value="KY" '.($row['state'] == "KY" ? 'selected': '').'>Kentucky</option>
			<option value="LA" '.($row['state'] == "LA" ? 'selected': '').'>Louisiana</option>
			<option value="ME" '.($row['state'] == "ME" ? 'selected': '').'>Maine</option>
			<option value="MD" '.($row['state'] == "MD" ? 'selected': '').'>Maryland</option>
			<option value="MA" '.($row['state'] == "MA" ? 'selected': '').'>Massachusetts</option>
			<option value="MI" '.($row['state'] == "MI" ? 'selected': '').'>Michigan</option>
			<option value="MN" '.($row['state'] == "MN" ? 'selected': '').'>Minnesota</option>
			<option value="MS" '.($row['state'] == "MS" ? 'selected': '').'>Mississippi</option>
			<option value="MO" '.($row['state'] == "MO" ? 'selected': '').'>Missouri</option>
			<option value="MT" '.($row['state'] == "MT" ? 'selected': '').'>Montana</option>
			<option value="NE" '.($row['state'] == "NE" ? 'selected': '').'>Nebraska</option>
			<option value="NV" '.($row['state'] == "NV" ? 'selected': '').'>Nevada</option>
			<option value="NH" '.($row['state'] == "NH" ? 'selected': '').'>New Hampshire</option>
			<option value="NJ" '.($row['state'] == "NJ" ? 'selected': '').'>New Jersey</option>
			<option value="NM" '.($row['state'] == "NM" ? 'selected': '').'>New Mexico</option>
			<option value="NY" '.($row['state'] == "NY" ? 'selected': '').'>New York</option>
			<option value="NC" '.($row['state'] == "NC" ? 'selected': '').'>North Carolina</option>
			<option value="ND" '.($row['state'] == "ND" ? 'selected': '').'>North Dakota</option>
			<option value="OH" '.($row['state'] == "OH" ? 'selected': '').'>Ohio</option>
			<option value="OK" '.($row['state'] == "OK" ? 'selected': '').'>Oklahoma</option>
			<option value="OR" '.($row['state'] == "OR" ? 'selected': '').'>Oregon</option>
			<option value="PA" '.($row['state'] == "PA" ? 'selected': '').'>Pennsylvania</option>
			<option value="RI" '.($row['state'] == "RI" ? 'selected': '').'>Rhode Island</option>
			<option value="SC" '.($row['state'] == "SC" ? 'selected': '').'>South Carolina</option>
			<option value="SD" '.($row['state'] == "SD" ? 'selected': '').'>South Dakota</option>
			<option value="TN" '.($row['state'] == "TN" ? 'selected': '').'>Tennessee</option>
			<option value="TX" '.($row['state'] == "TX" ? 'selected': '').'>Texas</option>
			<option value="UT" '.($row['state'] == "UT" ? 'selected': '').'>Utah</option>
			<option value="VT" '.($row['state'] == "VT" ? 'selected': '').'>Vermont</option>
			<option value="VA" '.($row['state'] == "VA" ? 'selected': '').'>Virginia</option>
			<option value="WA" '.($row['state'] == "WA" ? 'selected': '').'>Washington</option>
			<option value="WV" '.($row['state'] == "WV" ? 'selected': '').'>West Virginia</option>
			<option value="WI" '.($row['state'] == "WI" ? 'selected': '').'>Wisconsin</option>
			<option value="WY" '.($row['state'] == "WY" ? 'selected': '').'>Wyoming</option>
		</select>
	</p><br/>
	<p> ZIP Code: <input type="text" name="zip_code" id="zip_code" required="required" pattern="^\d{5}(?:-\d{4})?$" size="15" maxlength="10" value="'.(strlen($row['zip_code'])==9?substr($row['zip_code'],0,5).'-'.substr($row['zip_code'],5,4):$row['zip_code']).'"  /><label for="first_name"></label></p><br/>
	<p> Sequrity Question: <input type="text" name="security_question" id="security_question" required="required" size="50" maxlength="45" value="'.$row['security_question'].'"  disabled/><label for="first_name"></label></p><br/>
	<p> Sequrity Answer: <input type="text" name="security_answer" id="security_answer" required="required" size="50" maxlength="45" value="'.$row['security_answer'].'"  disabled/><label for="first_name"></label></p><br/>
	<p> Primary Phone: <input type="text" name="phone_1" id="phone_1" required="required" pattern="^\(\d{3}\)\d{3}-\d{4}$" size="15" maxlength="15" value="('.substr($row['phone_1'],0,3).')'.substr($row['phone_1'],3,3).'-'.substr($row['phone_1'],6,4).'"  /><label for="first_name"></label></p><br/>
	<p> Secondary Phone: <input type="text" name="phone_2" id="phone_2" pattern="^\(\d{3}\)\d{3}-\d{4}$|^$" size="15" maxlength="15" value="'.(strlen($row['phone_2'])==10?'('.substr($row['phone_2'],0,3).')'.substr($row['phone_2'],3,3).'-'.substr($row['phone_2'],6,4):'').'"  /><label for="first_name"></label></p><br/>
		<p> Customer Status <select name="customer_status_id" id="customer_status_id">';
			foreach ($enum_status as $key => $value) {
			echo '<option value="'.$key.'" '.($row['customer_status_id']==$key?'selected':'').'>'.$value.'</option>';
		}
		echo'
		</select>	
		<br /><br />
	<p> <input type="submit" name="submit" value="Save Changes" /> </p><br/>
	<input type = "hidden" name="customer_id" value="'.$customer_id.'" />
	<input type = "hidden" name="edit" value="1" />
</form>';
}else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p>';
}

mysqli_close($dbc);
		
include ('includes/footer.html');

?>