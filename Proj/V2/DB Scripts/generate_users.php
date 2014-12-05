<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Random Users</title>
</head>
<body>
<?php
	include("../convert_state.php");
	function geddem($count = 1){
		for($i =1; $i<=$count;$i++){
			//for every count, get rondom user data from api
			$api_get = file_get_contents('http://api.randomuser.me/?results=40');
			
			//decode json strong into data object
			$jsonobj  = json_decode($api_get);

			//Generate random company suffixes list
			$co = array("Tech Enterprises", " Industries", "Corps International", "Co, Ltd.", " Foundation", " Fund", " Union", " Manufacturing", " Business Solutions", " & Sons", " & Associates", " Shrimp Co.", "'s Roadside BBQ", " Brothers Publishing", " Communications");//for random company suffixes
		
			//print_r ($jsonobj->results);
			foreach ($jsonobj->results as $entry) {
				echo 'INSERT INTO `entity_customers` VALUES (NULL, "'.ucfirst($entry->user->name->first).'", "'.ucfirst($entry->user->name->last).'", "'.$entry->user->email.'", SHA1("'.$entry->user->password.'"), NOW() - INTERVAL FLOOR(RAND() * 3650) DAY, "'.ucfirst($entry->user->name->last).$co[array_rand($co,1)].'", "'.ucwords($entry->user->location->street).'", NULL, "'.ucwords($entry->user->location->city).'", "'.convert_state($entry->user->location->state, "abbrev").'", "'.$entry->user->location->zip.'", NOW(), "What is your favorite Username?", "'.$entry->user->username.'", "'.preg_replace("/[^0-9]/", "", $entry->user->phone).'", "'.preg_replace("/[^0-9]/", "", $entry->user->cell).'", '.mt_rand(2,4).');';
				echo '<br />';
			}
		}
	}
	geddem();
?>
	
</body>
</html>