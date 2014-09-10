<?php
	/*
	Brian Warfield
	CIS 12 PHP
	8 September 2014
	Purpose: Illustrate Branching Constructs
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Grade</title>
</head>
<body>
	<?PHP
		//Initialize the built in capabillities of PHP to grab information passed from a form
		$score = $_GET["score"];
		$grade = "";
		
		//Determine the Grade
		$grade =($score>=90)?"A":(
			  ($score>=80)?"B":(
			  ($score>=70)?"C":(
			  ($score>=60)?"D":"F")));
		echo "<h1>A score of $score is a grade of: $grade</h1>";		
		?>
</body>
</html>