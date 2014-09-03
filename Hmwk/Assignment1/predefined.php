<?php
	/*
	Brian Warfield
	CIS 12 PHP
	27 August 2014
	Purpose: Script 1.5
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Predefined Variables</title>
</head>
<body>
	<!-- Script 1.5 - predefined.php -->
	<?PHP
	//Create shorthand versions of the variable names:
	$file = $_SERVER['SCRIPT_FILENAME'];
	$user = $_SERVER['HTTP_USER_AGENT'];
	$server = $_SERVER['SERVER_SOFTWARE'];
	
	//print the name of this script
	echo "<p>Your are running the file:<br /><b>$file</b>.</p>\n";
	
	//print the user's information:
	echo "<p>You are viewing this page using:<br /><b>$user</b></p>\n";
	
	//print the server's information:
	echo "<p>This server is running:<br /><b>$server</b>.</p>\n";
	?>
</body>
</html>