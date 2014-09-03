<?php
	/*
	Brian Warfield
	CIS 12 PHP
	27 August 2014
	Purpose: Script 1.7
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Concatenation</title>
</head>
<body>
	<!-- Script 1.7 - concat.php -->

	<?PHP
	
	// Create the variables:
	$first_name = 'Melissa';
	$last_name = 'Bank';
	$author = $first_name . ' ' .$last_name;

	$book = 'The Girls\' Guide to Hunting and Fishing';

	//Print the values:
	echo "<p>The book <em>$book</em> was written by $author.</p>";

	?>
</body>
</html>