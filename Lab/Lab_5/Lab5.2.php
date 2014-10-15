<?php
	/*
	Brian Warfield
	CIS 12 PHP
	08 Oct 2014
	Purpose: Lab Codecademy PHP Lesson 10: Object oriented PHP
	*/
?>
<html>
  <head>
    <title></title>
  </head>
  <body>
    <p>
      <?php
        class person{
             static public function say(){
                echo "Here are my thoughts!";
            }
        }
        class blogger extends person{
            const cats = 50;
        }
        blogger::say();
        echo blogger::cats;
      ?>
    </p>
  </body>
</html>