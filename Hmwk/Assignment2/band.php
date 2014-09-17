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
		$band = ""
		switch(true){
			case $wavelength<= pow(10,-11): $band = "Gamma Ray";break;
			case $wavelength<= pow(10,-9): $band = "X Ray";break;
			case $wavelength<= pow(10,-7): $band = "Ultraviolet";break;
			case $wavelength<= pow(10,-5.5): $band = "visible";break;
			case $wavelength<= pow(10,-3.5): $band = "X Ray";break;
			case $wavelength<= pow(10,-9): $band = "X Ray";break;
			case $wavelength<= pow(10,-9): $band = "X Ray";break;
			

		
			default: 
				$band = "radio";
				break;
		}
	?>

	</table>
</body>
</html>