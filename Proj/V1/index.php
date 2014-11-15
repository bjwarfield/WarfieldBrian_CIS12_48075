<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Bladeshop - </title>
</head>
<header>
	<h1>The Blade Shop</h1>
	<h2>Never a Dull Moment</h2>
</header>
<?php
	//Get DB COnnection
	@require("project_DBconnect.php");

	//Get IDs of categories that have Dropdowns
	$q = 'SELECT parent_category_id FROM entity_categories WHERE is_active = 1 GROUP BY parent_category_id ORDER BY parent_category_id ASC;';
	$r= @mysqli_query($dbc, $q);
	$parents = array();
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		$parents[]=$row['parent_category_id'];
	}

	echo "<pre>";
	print_r($parents);
	echo "</pre>";
	
	//Get full list of Categories
	$groups= array(array());
/*	foreach ($parents as $dropdown) {
		$q = 'SELECT category_id, name, position FROM entity_categories WHERE parent_category_id = '.$dropdown.' AND is_active = 1 ORDER BY position;';
		$r= @mysqli_query($dbc, $q);
		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			$groups[$dropdown][$row['category_id']]=$row['name'];
		}
	}*/
	function navList($arr, $cat, $par, $pos){
		if($arr){
			return;
		}
		foreach($a as $v){
			navList();
		}
	}
	foreach ($parents as $dropdown) {
		$q = 'SELECT category_id, parent_category_id, position, name FROM entity_categories WHERE parent_category_id = '.$dropdown.' AND is_active = 1 ORDER BY position;';
		$r= @mysqli_query($dbc, $q);
		while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
			$groups[$dropdown][$row['category_id']]=$row['name'];
		}
	}


	echo "<pre>";
	print_r($groups);
	echo "</pre>";

	//Print out menu in list form
	echo '<nav><ul>';
		foreach ($groups[0] as $key => $value) {
			//echo "Key = ".$key." : Value = ".$value."<br/>";
			echo '<li><a href="view_items.php?category_id='.$key.'" >'.$value.'</a>';
			if(in_array($key, $parents)){
				echo "<ul>";
				foreach($groups[$key] as $k => $i){
					echo '<li><a href="view_items.php?category_id='.$k.'" >'.$i.'</a></li>';
				}
				echo "</ul>";
			}
			echo "</li>";
	}
	echo "</ul></nav>";
	mysqli_close($dbc);


?>
<body>
	
</body>
</html>