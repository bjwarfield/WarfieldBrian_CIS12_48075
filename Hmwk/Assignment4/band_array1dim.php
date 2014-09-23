<?php
	/*
	Brian Warfield
	CIS 12 PHP
	17 September 2014
	Purpose: Calculate electromagnetic band based on wavelength part 2
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html" charset="UTF-8" />
	<title>Electromagnetic Band</title>
	<style type="text/css">
	table{
		border-collapse: collapse;
	}
	td, th{
		border:1px solid #999;
		padding:5px;
	}
	</style>
</head>

<body>
	<img src="spectrum.png"></img>
	<table><thead>
	<tr>
		<th>Row Num</th>
		<th>Wavelength (m)</th>
		<th>Band</th>
	</tr>
	</thead>
	<tbody>
	<?PHP
		//initialize arrays
		$rowNum = array();//array for Row Numberss
		$wavelengthArray = array ();//array for wavelengts
		$band = array();//array for band ranges
		$row = 0;//initialize for array indexing
		
		//calculate the array values
		for($power=3;$power>=-12;$power--){
			$row++;
			$rowNum[$row]=$row;
			$wavelengthArray[$row]="10<sup>".$power."</sup>";
			$wavelength = pow(10,$power);
			if($wavelength>=5) $band[$row] = "Radio";
			elseif($wavelength>=10e-4) $band[$row] = "Microwave";
			elseif($wavelength>=10e-5) $band[$row] = "Infrared";
			elseif($wavelength>=10e-7) $band[$row] = "Visable";
			elseif($wavelength>=10e-9) $band[$row] = "Ultraviolet";
			elseif($wavelength>=10e-11) $band[$row] = "X-Ray";
			else $band[$row] = "Gamma Ray";
			};//endloop
			
		//output the arrays to the table	
		for ($i=1; $i<=count($rowNum); $i++ ) {
			echo "<tr><td>".$rowNum[$i]."</td><td>".$wavelengthArray[$i]."</td><td>".$band[$i]."</td></tr>";
		}
	?>
	</tbody>
	</table>

</body>
</html>