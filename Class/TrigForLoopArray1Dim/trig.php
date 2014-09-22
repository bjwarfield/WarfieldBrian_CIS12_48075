<?php
	/*
	Brian Warfield
	CIS 12 PHP
	22 September 2014
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
		//declare Arrays
		$degree = array();
		$radians = array();
		$sine = array();
		$cosine = array();
		$tangent = array();
		for($angle=$angStart;$angle<=$angEnd;$angle+=$angInc){
			//calculations for each parallel display
			$degree[$angle]=$angle;
			$radian[$angle]=round($angle*atan(1)/45,4);
			$sine[$angle]=round(sin($radian[$angle]),4);
			$cosine[$angle]=round(cos($radian[$angle]),4);
			$tangent[$angle]=round(tan($radian[$angle]),4);
		}
	?>
	<h1 >Trig table</h1>
	<table width="300" border="1">
		<tr>
			<th>Degrees</th>
			<th>Radians</th>
			<th>Sine</th>
			<th>Cosine</th>
			<th>Tangent</th>
		</tr>

	<?PHP
	//For Loop
	for($angle=$angStart;$angle<=$angEnd;$angle+=$angInc){
		echo "<tr>";
		echo "<td>".$degree[$angle]."</td>";
		echo "<td>".$radian[$angle]."</td>";
		echo "<td>".$sine[$angle]."</td>";
		echo "<td>".$cosine[$angle]."</td>";
		echo "<td>".$tangent[$angle]."</td>";
		echo "</tr>";
	};
	
	
	?>
	</table>
	<?php
		echo "The number of elements in the columns are ".count($degree)."</p>";
	?>
</body>
</html>