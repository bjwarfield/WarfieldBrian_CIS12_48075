<?php
	/*
	Brian Warfield
	CIS 12 PHP
	08 Oct 2014
	Purpose: Lab Codecademy PHP Lesson 11: Advances Arrays
	*/
?>
<html>
  <head>
    <title>I am the King of Arrays!</title>
  </head>
  <body>
    <p>
      <?php
      // On the line below, create your own associative array:
      $myArray = array("Bacon", "Burger", "Sausage", "Ham", "Turkey", "Drumstick", "Tri-tip", "Rib-eye");


      // On the line below, output one of the values to the page:
     
          echo $myArray[3].'<br>';
      // On the line below, loop through the array and output
      // *all* of the values to the page:
     foreach($myArray as $i){
         echo $i."<br>";
     }
     
      ?>
    </p>
  </body>
</html>