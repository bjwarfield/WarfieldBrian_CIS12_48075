<?php
	/*
	Brian Warfield
	CIS 12 PHP
	01 Oct 2014
	Purpose: Lab Codecademy PHP Lesson 7: Functions, Part I
	*/
?>
<!DOCTYPE html>
<html>
    <p>
	<?php
	// Create an array and push on the names
    // of your closest family and friends
    $fav_bands = array("Chemical Brothers", "4Hero", "RJD2", "The Prodigy", "Daft Punk", "Basement Jaxx", "Fatboy Slim", "Gorillaz", "DJ Shadow" );
    array_push($fav_bands, "Sneaker Pimps");
	// Sort the list
    sort($fav_bands);
	// Randomly select a winner!
    $winner = $fav_bands[rand(0, count($fav_bands)-1)];

	// Print the winner's name in ALL CAPS
    print strtoupper($winner);
	?>
	</p>
</html>