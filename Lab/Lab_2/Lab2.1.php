<?php
	/*
	Brian Warfield
	CIS 12 PHP
	DATE
	Purpose: Lab Codecademy PHP Lesson 3: Control Flow Switch
	*/
?>
<!DOCTYPE html>
<html>
    <head>
		<title></title>
	</head>
	<body>
    <?php
     switch ("Bacon"){
         case ("Ham"):
             echo "That's not bacon!";
             break;
            case ("Chicken"):
                echo "That's definatley not bacon!";
                break;
            case ("Salmon"):
                echo "Ninja what?!";
                break;
            case ("Bacon"):
                echo "IT'S BACON!!";
                break;
            default:
                "is it bacon?";
                break;
     }
    ?>
	</body>
</html>