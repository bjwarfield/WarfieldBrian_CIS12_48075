<?php
	/*
	Brian Warfield
	CIS 12 PHP
	27 August 2014
	Purpose: Comments/Variables/Strings
	*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Strings and Variables</title>
</head>
<body>
	<?php
		//Declare Variables
		$hours=40;//Worked 40 hours
		$payRate=9;//$'s/hour
		
		//Calculate Paycheck
		$grossPay=$hours*$payRate;
		//Output the result
		echo "<p>Hours worked = $hours (hrs)</p>";
		echo '<p>Pay Rate = $$payRate per hour</p>';
		echo "<p>Pay Check = $".$grossPay.'</p>';
	?>
</body>
</html>