<?php
	/*
	Brian Warfield
	CIS 12 PHP
	3 September 2014
	Purpose: Classwork Truth Table
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Truth Table</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
		}

		table, th, td {
			border: 1px solid black;
		}
		td{
			width:75px;
			text-align: center;
		}
		th {
			background-color:#CCC;
		}
		.evenrow td{
			background-color:#F8F8F8;
		}
	</style>
</head>
<body>
	<?php
		//echo out a heading
		echo "<h1>Truth Table</h1>";
	?>
		<table border="1">
			<tr>
				<th>X</th>
				<th>Y</th>
				<th>!X</th>
				<th>!Y</th>
				<th>X&&Y</th>
				<th>X||Y</th>
				<th>X^Y</th>
				<th>X^Y^Y</th>
				<th>X^Y^X</th>
				<th>!(X&&Y)</th>
				<th>!X||!Y</th>
				<th>!(X||Y)</th>
				<th>!X&&!Y</th>
			</tr>
			<tr>
				<?php
					$x = true;
					$y = true;
					echo "<td>".($x?"T":"F")."</td>";
					echo "<td>".($y?"T":"F")."</td>";
					echo "<td>".(!$x?"T":"F")."</td>";
					echo "<td>".(!$y?"T":"F")."</td>";					
					echo "<td>".(($x&&$y)?"T":"F")."</td>";
					echo "<td>".(($x||$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y^$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y^$x)?"T":"F")."</td>";
					echo "<td>".(!($x&&$y)?"T":"F")."</td>";
					echo "<td>".(!$x||!$y?"T":"F")."</td>";
					echo "<td>".(!($x||$y)?"T":"F")."</td>";
					echo "<td>".(!$x&&!$y?"T":"F")."</td>";
				?>
			</tr>
			<tr class="evenrow">
				<?php
					$x = true;
					$y = false;
					echo "<td>".($x?"T":"F")."</td>";
					echo "<td>".($y?"T":"F")."</td>";
					echo "<td>".(!$x?"T":"F")."</td>";
					echo "<td>".(!$y?"T":"F")."</td>";					
					echo "<td>".(($x&&$y)?"T":"F")."</td>";
					echo "<td>".(($x||$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y^$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y^$x)?"T":"F")."</td>";
					echo "<td>".(!($x&&$y)?"T":"F")."</td>";
					echo "<td>".(!$x||!$y?"T":"F")."</td>";
					echo "<td>".(!($x||$y)?"T":"F")."</td>";
					echo "<td>".(!$x&&!$y?"T":"F")."</td>";
				?>
			</tr>
			<tr>
				<?php
					$x = false;
					$y = true;
					echo "<td>".($x?"T":"F")."</td>";
					echo "<td>".($y?"T":"F")."</td>";
					echo "<td>".(!$x?"T":"F")."</td>";
					echo "<td>".(!$y?"T":"F")."</td>";					
					echo "<td>".(($x&&$y)?"T":"F")."</td>";
					echo "<td>".(($x||$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y^$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y^$x)?"T":"F")."</td>";
					echo "<td>".(!($x&&$y)?"T":"F")."</td>";
					echo "<td>".(!$x||!$y?"T":"F")."</td>";
					echo "<td>".(!($x||$y)?"T":"F")."</td>";
					echo "<td>".(!$x&&!$y?"T":"F")."</td>";
				?>
			</tr>	
			<tr class="evenrow">
				<?php
					$x = false;
					$y = false;
					echo "<td>".($x?"T":"F")."</td>";
					echo "<td>".($y?"T":"F")."</td>";
					echo "<td>".(!$x?"T":"F")."</td>";
					echo "<td>".(!$y?"T":"F")."</td>";					
					echo "<td>".(($x&&$y)?"T":"F")."</td>";
					echo "<td>".(($x||$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y^$y)?"T":"F")."</td>";
					echo "<td>".(($x^$y^$x)?"T":"F")."</td>";
					echo "<td>".(!($x&&$y)?"T":"F")."</td>";
					echo "<td>".(!$x||!$y?"T":"F")."</td>";
					echo "<td>".(!($x||$y)?"T":"F")."</td>";
					echo "<td>".(!$x&&!$y?"T":"F")."</td>";
				?>
			</tr>				
		</table>
</body>
</html>