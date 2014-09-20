<?php
	/*
	Brian Warfield
	CIS 12 PHP
	DATE
	Purpose: Lab Codecademy PHP Lesson 6: While Loops in PHP
	*/
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Your own do-while</title>
        <link type='text/css' rel='stylesheet' href='style.css'/>
	</head>
	<body>
    <?php
        //write your do-while loop below
        $count = 0;
        do{
            $i = rand(1,100);
            echo "$i <br />";
            $count ++;
        }while($i != 50);
        echo "It took $count rolls to get 50";
    ?>
    </body>
</html>