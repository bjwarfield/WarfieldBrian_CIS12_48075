<?php
	/*
	Brian Warfield
	CIS 12 PHP
	3 Oct 2014
	Purpose: Savings Tagle with 2DIm Arrays
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Savings Table</title>
	<style type="text/css">
		body{
			width: 750px;
			margin-right: auto;
			margin-left: auto;
		}
		table{
			border-collapse: collapse;
			width: 100%;
		}
		th, td{
			border:1px solid #AAA;
			text-align: center;
		}
		tbody tr:nth-child(odd){
			background-color: #DDD;
		}

	</style>
</head>
<body>
	<?php
		//Declare and Initialize Variables
		$initDep = 100;//initial deposit
		$tableArray = array(array(0),array($initDep),array($initDep),array($initDep),array($initDep),array($initDep),array($initDep));//[0]Year, [1]5%, [2]6%, [3]7%, [4]8%, [5]9%, [6]10% 
		$year;

		//set the valeus of the array
		function populateTable($array){
			for($year=1;$year<=60;$year++){
				$array[0][$year]=$year;
				$array[1][$year]=$array[1][$year-1]*1.05;
				$array[2][$year]=$array[2][$year-1]*1.06;
				$array[3][$year]=$array[3][$year-1]*1.07;
				$array[4][$year]=$array[4][$year-1]*1.08;
				$array[5][$year]=$array[5][$year-1]*1.09;
				$array[6][$year]=$array[6][$year-1]*1.1;
			}

			return $array;
		}
		//output values to html table
		function displayTable($arrayInput){
			echo  "<h1>Savings Table</h1><table><thead><tr><th>Year</th><th>Savings at 5%</th><th>Savings at 6%</th><th>Savings at 7%</th><th>Savings at 8%</th><th>Savings at 9%</th><th>Savings at 10%</th></tr></thead><tbody>";
			for($row=0;$row<count($arrayInput[0]);$row++){
				echo "<tr>";
				for($cols=0;$cols<count($arrayInput);$cols++){
					if($cols==0){
						echo "<td>".$arrayInput[$cols][$row]."</td>";
					}else{
						echo "<td>$".number_format($arrayInput[$cols][$row], 2, ".", "," )."</td>";
					}//end if-else
				}//end col loop
				echo "</tr>";
			}//end Row loop
			echo "</tbody></table>";
		}//end Function
		displayTable(populateTable($tableArray));//run both functions
	?>
</body>
</html>