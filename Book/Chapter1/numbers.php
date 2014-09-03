<?php
	/*
	Brian Warfield
	CIS 12 PHP
	27 August 2014
	Purpose: Script 1.8
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Numbers</title>
</head>
<body>
	<!-- Script 1.8 - numbers.php -->

	<?PHP

	// Set the variables:
	$quantity = 30; // Buying 30 widgets.
	$price = 119.95;//Price per widget
	$taxrate = .05; // 5% sales tax.

	// Calculate the total:
	$total = $quantity * $price;
	$total = $total + ($total * $taxrate);

	// Calculate and add the tax.

	// Format the total:
	$total = number_format ($total, 2);

	// Print the results:
	echo '<p>You are purchasing <b>'.$quantity.'</b> widget(s) at a cost of <b>$'.$price.'</b> each. With tax, the total comes to <b>$'.$total.'</b>.</p>';

	?>
</body>
</html>