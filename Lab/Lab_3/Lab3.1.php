<?php
	/*
	Brian Warfield
	CIS 12 PHP
	DATE
	Purpose: Lab Codecademy PHP Lesson 5: For Loops in PHP
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
        $yardlines = array("The 50... ", "the 40... ",
        "the 30... ", "the 20... ", "the 10... ");
        // Write your foreach loop below this line
        foreach ($yardlines as $yards){
            echo $yards;
        }
        
        // Write your foreach loop above this line
        echo "touchdown!";
      ?>
    </p>
  </body>
</html>