<?php
	/*
	Brian Warfield
	CIS 12 PHP
	01 Oct 2014
	Purpose: Lab Codecademy PHP Lesson 8: Functions, Part II
	*/
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
      <p>
        <?php
        function aboutme($name,$age){
            echo "Hello! My name is " . $name . " and I am " . $age . " years old.";
        }
        aboutme("Gary",12);
      
        ?>
      </p>
    </body>
</html>