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
</head>

<body>
	<img src="spectrum.png"></img>
	<?PHP
		//Input the Data from the form
		$wavelength=$_GET['wavelength'];
		$unit=$_GET['unit'];//Unit factor to meters
//		echo $unit.<br />; //Debugging
		$wavelength*=$unit;//Convert to Meters
//		echo $wavelength."<br/>;//Debugging
		//Echo out prefix text
		echo "<h3>The wavelength is $wavelength Meters which falls within the ";
		
		//select suffix rext based on calculated wavelength
		if($wavelength>5){
			echo "Radio band</h3>";
		}elseif($wavelength>10e-4){
			echo "Microwave band</h3>";
		}elseif($wavelength>((10e-5+10e-6)/2)){//calculate halfway between the bands
			echo "Infrared band</h3>";
		}elseif($wavelength>10e-7){
			echo "Visible band</h3>";
		}elseif($wavelength>10e-9){
			echo "Ultraviolet band</h3>";
		}elseif($wavelength>10e-11){
			echo "X-Ray band</h3>";
		}else{
			echo "Gamma Ray band</h3>";
		};
	?>
	<form action="elecromagneticcalculator.html">
	<input type="submit" value="Try Again"></input>
	</form>
</body>
</html>