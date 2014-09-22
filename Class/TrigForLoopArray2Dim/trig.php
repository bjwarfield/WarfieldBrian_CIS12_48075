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
	<title>Trig Table 2 dimentions</title>
</head>
<body>
	<?PHP
		//Input the Data from the form
		$angStart=$_GET['angStart'];
		$angEnd=$_GET['angEnd'];
		$angInc=$_GET['angInc'];
		//declare Arrays
		$trigTab = array();
		for($col=1;$col<=5;$col++){
			$trigTab[$col]=array();
		}

		for($angle=$angStart;$angle<=$angEnd;$angle+=$angInc){
			//calculations for each parallel display
			$trigTab[1][$angle]=$angle;
			$trigTab[2][$angle]=round($angle*atan(1)/45,4);
			$trigTab[3][$angle]=round(sin($trigTab[2][$angle]),4);
			$trigTab[4][$angle]=round(cos($trigTab[2][$angle]),4);
			$trigTab[5][$angle]=round(tan($trigTab[2][$angle]),4);
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
		for($cols=1;$cols<=5;$cols++){
			echo "<td>".$trigTab[$cols][$angle]."</td>";
		}
		echo "</tr>";
	};
	
	
	?>
	</table>
	<?php
		echo $trigTab
	?>
</body>
</html>