<?php
	/*
	Brian Warfield
	CIS 12 PHP
	08 Oct 2014
	Purpose: Lab Codecademy PHP Lesson 9: Objects in PHP
	*/
?>
<!DOCTYPE html>
<html>
    <head>
	  <title> Challenge Time! </title>
      <link type='text/css' rel='stylesheet' href='style.css'/>
	</head>
	<body>
      <p>
        <?php
          class cat{
              public $isAlive = true;
              public $numLegs = 4;
              public $name;
              
              public function __construct($name){
                  $this->name=$name;
             }
             public function meow(){
                 return "Meow meow";
             }
          }
             $cat1 = new cat("CodeCat");
             echo $cat1->meow();
?>
      </p>
    </body>
</html>