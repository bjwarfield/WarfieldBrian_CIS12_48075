<?php
	/*
	Brian Warfield
	CIS 12 PHP
	DATE
	Purpose: Script 1.1
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>All about Functions</title>
</head>
<body>
	<?php 
	//Functions calline other functions
	function fValue1($p, $i, $n){
		return $p*pow((1+$i/100),$n);
	}
	//Functuns utilizing control Functions
	function fValue2($p, $i, $n){
		$fValue = $p;
		for($year=1;$year<=$n;$year++){
			$fValue*=(1+$i/100);
		}
		return $fValue;
	}
	//Functions calling other functions
	function fValue3($p, $i, $n){
		return $p*exp($n*log(1+$i/100));
	}
	//Functions calling themselves
	function fValue4($p, $i, $n){
		if($n==0) return $p;
		else return fValue4($p, $i, $n-1)*(1+$i/100);
	}
	//Defference between pass by value and pass by reference
	//$ represents pass by reference
	//allows the valiable to be utilized as an input
	//as well and an output to be returned
	function fValue5($p, $i, $n,&$fValue){
		$fValue = $p;
		for($year=1;$year<=$n;$year++){
			$fValue*=(1+$i/100);
		}
		return $fValue;
	}
	//Defaulted parameters
	//To prevent ambiguity, these parameters 
	//must be to the far right of the argument list
	function fValue6($p, $i, $n=9){
		return $p*pow((1+$i/100),$n);
	}
	//declare and initialize variables
	$pValue=100;//Present value in $
	$iRate=8;/// interest rate in % per year
	$cPeriods=8;//Number of compounding periods

	//Utilize the function and output the results
	$fValue1= number_format(fValue1($pValue,$iRate,$cPeriods),2);
	$fValue2= number_format(fValue2($pValue,$iRate,$cPeriods),2);
	$fValue3= number_format(fValue3($pValue,$iRate,$cPeriods),2);
	$fValue4= number_format(fValue4($pValue,$iRate,$cPeriods),2);
	fValue5($pValue,$iRate,$cPeriods,$fValue5);
	$fValue5 = number_format($fValue5,2);
	$fValue6= number_format(fValue6($pValue,$iRate),2);
	$fValue6a= number_format(fValue6($pValue,$iRate,$cPeriods),2);
	echo "<p>Present Value = $$pValue</p>";
	echo "<p>Investment Rate = $iRate %</p>";
	echo "<p>Compounding periods = $cPeriods (Years)</p>";
	echo "<p>Future Value 1 = $$fValue1</p>";
	echo "<p>Future Value 2 = $$fValue2</p>";
	echo "<p>Future Value 3 = $$fValue3</p>";
	echo "<p>Future Value 4 = $$fValue4</p>";
	echo "<p>Future Value 5 = $$fValue5</p>";
	echo "<p>Future Value 6 = $$fValue6, Periods Defaulted to 9 Years</p>";
	echo "<p>Future Value 6a = $$fValue6a</p>";
	 ?>
</body>
</html>