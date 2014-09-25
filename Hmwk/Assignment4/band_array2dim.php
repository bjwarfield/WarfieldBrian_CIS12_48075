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
	<img src="VisibleLightSpectrum-690x325.jpg"></img>
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
		$spectrum = array();
		$col = 0;
		for ($col=0; $col<3; $col++){
			$spectrum[$col]= array();
		}
		$spectrum[0][0]=0;//array for row numbers
		$spectrum[1][0]=0;//array for wavelengths
		$spectrum[2][0]=0;//array for band ranges
		//calculate the array values
		for($power=3;$power>=-12;$power--){
			$row++;
			$spectrum[0][$row]=$row;
			$spectrum[1][$row]="10<sup>".$power."</sup>";
			$wavelength = pow(10,$power);
			if($wavelength>=5) $spectrum[2][$row] = "Radio";
			elseif($wavelength>=10e-4) $spectrum[2][$row] = "Microwave";
			elseif($wavelength>=10e-5) $spectrum[2][$row] = "Infrared";
			elseif($wavelength>=10e-7) $spectrum[2][$row] = "Visable";
			elseif($wavelength>=10e-9) $spectrum[2][$row] = "Ultraviolet";
			elseif($wavelength>=10e-11) $spectrum[2][$row] = "X-Ray";
			else $spectrum[2][$row] = "Gamma Ray";
		};//endloop
			
		//output the arrays to the table
		for ($rows=1; $rows<count($spectrum[0]); $rows++){
			echo "<tr>";
			for ($col=0; $col<count($spectrum);$col++){
				echo "<td>".$spectrum[$col][$rows]."</td>";
			}//end col loop
			echo "</tr>";
		}//end Row Loop

		//for Debugging
		// echo print_r ($spectrum[0]);
		// echo print_r ($spectrum[1]);
		// echo print_r ($spectrum[2]);
	?>
	</tbody>
	</table>


</body>
</html>