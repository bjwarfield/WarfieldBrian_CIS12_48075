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
		$initDep = 100;
		$tableArray = array(array(0),array($initDep),array($initDep),array($initDep),array($initDep),array($initDep),array($initDep));//[0]Year,[1]5%,[2]6%,[3]7%,[4]8%,[5]9%,[6]10% 
		$year;
//		$tableArray[0][0]=0;//year column
//		$tableArray[1][0]=$initDep;//5% Savings Rate
//		$tableArray[2][0]=$initDep;//6% Savings Rate
//		$tableArray[3][0]=$initDep;//7% Savings Rate
//		$tableArray[4][0]=$initDep;//8% Savings Rate
//		$tableArray[5][0]=$initDep;//9% Savings Rate
//		$tableArray[6][0]=$initDep;//10% Savings Rate
	//	echo "<pre".print_r($tableArray)."</pre>";//for debugging
		function populateTable($array){
			for($i=1;$i<=60;$i++){
	//			echo print_r($i)."<br />";
				$array[0][$i]=$i;
				$array[1][$i]=$array[1][$i-1]*1.05;
				$array[2][$i]=$array[2][$i-1]*1.06;
				$array[3][$i]=$array[3][$i-1]*1.07;
				$array[4][$i]=$array[4][$i-1]*1.08;
				$array[5][$i]=$array[5][$i-1]*1.09;
				$array[6][$i]=$array[6][$i-1]*1.1;
			}
	//		echo print_r($array)."<br />";//for debugging
			return $array;
		}
		function displayTable($arrayInput){
			echo  "<h1>Savings Table</h1><table><thead><tr><th>Year</th><th>Savings at 5%</th><th>Savings at 6%</th><th>Savings at 7%</th><th>Savings at 8%</th><th>Savings at 9%</th><th>Savings at 10%</th></tr></thead><tbody>";
			for($row=0;$row<count($arrayInput[0]);$row++){
				echo "<tr>";
	//			echo "Row = ".$row."<br />";//for debugging
				for($cols=0;$cols<count($arrayInput);$cols++){
					if($cols==0){
						echo "<td>".$arrayInput[$cols][$row]."</td>";
					}else{
						echo "<td>$".number_format($arrayInput[$cols][$row], 2, ".", "," )."</td>";
					}//end if-else
	//				echo "cols = ".$cols."<br />";//for debugging
				}//end col loop
				echo "</tr>";
			}//end Row loop
			echo "</tbody></table>";
		}//end Function
		displayTable(populateTable($tableArray));//run both functions
	?>
</body>
</html>