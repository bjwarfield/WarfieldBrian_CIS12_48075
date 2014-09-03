<?php
	/*
	Brian Warfield
	CIS 12 PHP
	27 August 2014
	Purpose: Script 1.9
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Constants</title>
</head>
<body>
	<!-- Script 1.9 - constants.php -->

	<?PHP

	// Set today's date as a constant:
	define ('TODAY', '27 August 2014');

	// Print a message, using predefined constants and the TODAY constant:
	echo '<p>Today is '.TODAY.'.<br /> This server is running version <b>'.PHP_VERSION.'</b> of PHP on the <b>'.PHP_OS.'</b> operating system.</p>';

	?>
</body>
</html>