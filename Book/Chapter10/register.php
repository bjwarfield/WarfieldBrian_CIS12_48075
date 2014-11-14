<?php 

$page_title = 'Register';
include ('includes/header.html');
if ($_SERVER['REQUEST_METHOD']=='POST'){
	@require ('../../../../mysqli_connect.php');//DB COnnect
	$errors = array();
	if(empty($_POST['first_name'])){
		$errors[] = "Missing First Name.";
	}else{
		$fn = mysqli_real_escape_string($dbc, trim($_POST['first_name']));
	}
	if(empty($_POST['last_name'])){
		$errors[] = "Missing Last Name.";
	}else{
		$ln = mysqli_real_escape_string($dbc, trim($_POST['last_name']));
	}
	if(empty($_POST['email'])){
		$errors[] = "Missing email.";
	}else{
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
		$e_query = "SELECT user_id FROM users WHERE email = '$e'";
		$e_check = @mysqli_query($dbc, $e_query); 
		if(mysqli_num_rows($e_check)>0){
			$errors[] = "Email already regisetered";
		}
	}
	if(!empty($_POST['pass1'])){
		if ($_POST['pass1'] != $_POST['pass2']){
			$errors[] = "Unmatched Passwords";
		}else{
			$p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
		}
	}else{
		$errors[] = 'Missing Passwords';
	}
	if(empty($errors)){// If no errore
		//run this block
		@require ('../../../../mysqli_connect.php');//connect to the DB

		//make query
		$q = "INSERT INTO users (first_name, last_name, email, pass, registration_date) VALUES ('$fn', '$ln', '$e', SHA1('$p'), NOW())";
		
		$r = @mysqli_query($dbc, $q);//run query
		if($r){//successful?
			//Print a Message
			echo '<h1>Confirmed!</h1>
			<p>User <strong>'.$fn.' '.$ln.'</strong> registered</p><p>&nbsp;</p>';
		}else{//unsuccessful
			echo '<h1>Error</h1>
			<p class="error">Registration error! Please contact the system administrator.</p>';

			//debugging message
			echo '<p>'.mysqli_error($dbc).'<br /> <br />Query:'.$q.'</p>';
		}//end $r conditional
		mysqli_close($dbc);//close the db connection

		//include the footer and end the script
		include('includes/footer.html');
		exit();

	}else{//Report all the errors
		echo '<h1>ERROR!ERROR!ERROR!ERROR!</h1>
		<p class="error">An error, erred at the error.<br />Here be the error list:<br /><br />';
		foreach($errors as $msg){
			echo ' - '.$msg.'<br />';
		}
		echo "</p><p>Please fill out the required fields and sumbit again.</p><p>&nbsp;</p>";
	}//end if (empty($errors)) check
	mysqli_close($dbc);//close the db connection
}//end main submit conditional
?>
<h1>Register</h1>
<form action="register.php" method="post">
	<p>First Name<input type="text" name="first_name" size="15" maxlength="20" value="<?php if(ISSET($_POST['first_name'])) echo $_POST['first_name'] ?>"></p>
	<p>Last Name<input type="text" name="last_name" size="15" maxlength="40" value="<?php if(ISSET($_POST['last_name'])) echo $_POST['last_name'] ?>"></p>
	<p>Email address<input type="text" name="email" size="20" maxlength="60" value="<?php if(ISSET($_POST['email'])) echo $_POST['email'] ?>"></p>
	<p>Password:<input type="password" name="pass1" size="15" maxlength="20"></p>
	<p>Confirm Password<input type="password" name="pass2" size="15" maxlength="20"></p>
	<p>Submit<input type="submit" value="Register"></p>
</form>
<?php include('includes/footer.html'); ?>