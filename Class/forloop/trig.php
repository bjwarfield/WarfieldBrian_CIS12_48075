<?php
	/*
	Brian Warfield
	CIS 12 PHP
	15 September 2014
	Purpose: For loop Trigonometry table
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" charset="UTF-8" />
	<title>Trig Table</title>
</head>
<body>
	<?PHP
		//Input the Data from the form
		$angStart=$_GET['angStart'];
		$angEnd=$_GET['angEnd'];
		$angInc=$_GET['angInc'];
	?>
	<h1 >Trig table</h1>
	<table width="300" border="1">
		<tr>
			<th>Radians</th>
			<th>Degrees</th>
			<th>Sine</th>
			<th>Cosine</th>
			<th>Tangent</th>
		</tr>

	<?PHP
	//For Loop
	for($angle=$angStart;$angle<=$angEnd;$angle+=$angInc){
		echo "<tr>";
		echo "<td>$angle</td>";
		//calculate
		$rad=round($angle*atan(1)/54,4);
		$sine=round(sin($rad),4);
		$cosine=round(cos($rad),4);
		$tangent=round(tan($rad),4);
		echo "<td>$rad</td>";
		echo "<td>$sine</td>";
		echo "<td>$cosine</td>";
		echo "<td>$tangent</td>";
		echo "</tr>";
	};
	
	
	?>
	</table>
</body>
</html>