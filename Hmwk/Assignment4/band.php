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
		$row = 0;
		
		for($count=3;$count>=-12;$count--){
			$row++;
			$wavelength = pow(10,$count);
		if($wavelength>5) echo "<tr><td>".$row."</td><td>10<sup>".$count."</sup></td><td>Radio</td><tr>";
		elseif($wavelength>10e-4) echo "<tr><td>".$row."</td><td>10<sup>".$count."</sup></td><td>Microwave</td><tr>";
		elseif($wavelength>10e-5) echo "<tr><td>".$row."</td><td>10<sup>".$count."</sup></td><td>Infrared</td><tr>";
		elseif($wavelength>10e-7) echo "<tr><td>".$row."</td><td>10<sup>".$count."</sup></td><td>Visable</td><tr>";
		elseif($wavelength>10e-9) echo "<tr><td>".$row."</td><td>10<sup>".$count."</sup></td><td>Ultraviolet</td><tr>";
		elseif($wavelength>10e-11) echo "<tr><td>".$row."</td><td>10<sup>".$count."</sup></td><td>x-Ray</td><tr>";
		else echo "<tr><td>".$row."</td><td>10<sup>".$count."</sup></td><td>Gamma Ray</td><tr>";
		};//endloop
		

	?>
	</tbody>
	</table>

</body>
</html>