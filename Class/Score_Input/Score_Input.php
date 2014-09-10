<?php
	/*
	Brian Warfield
	CIS 12 PHP
	27 August 2014
	Purpose: Script 1.1
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Page Title</title>
</head>
<body>
	<h1>Input Test Score</h1>
	<form action="inputgrade.php" method="get">
        <input name="score" type="text" value="100" maxlength="15" />
        <input type="submit" value="calculate" />
	</form>
</body>
</html>