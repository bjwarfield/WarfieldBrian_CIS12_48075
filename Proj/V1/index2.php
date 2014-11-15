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

	//Query DB for Category Data
	$q = 'SELECT category_id, parent_category_id, name FROM entity_categories ORDER BY parent_category_id, position;';
	$r= @mysqli_query($dbc, $q);

	$data = array();//all category data
	$index = array();//parent category index
	
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		$category_id = $row['category_id'];
		$parent_category_id = $row['parent_category_id'];
		$data[$category_id] = $row;
		$index[$parent_category_id][] = $category_id;
	}
/*	echo"<pre>Data:\n";
	print_r($data);
	echo "\nIndex:\n";
	print_r($index);
	echo '</pre>';*/

	//Recursive function for navbar output
	function display_nav($parent_id = 0){
		global $data, $index;
		$parent_id = $parent_id;
		if(isset($index[$parent_id])){
			echo '<ul>';
			foreach ($index[$parent_id] as $id) {
				echo '<li><a href="view_product.php?category_id='.$data[$id]['category_id'].'">'.$data[$id]['name']."</a></li>";
				display_nav($id);
			}
			echo '</ul>';
		}
	}
	echo "<nav>";
	display_nav();//build navbar 
	echo"</nav>";

	mysqli_close($dbc);


?>
<div class="content">
	<!--Individial Page contented Inserted After here  -->
	<!--  -->
</div>
<footer>
	<ul>
		<li><a href="#">Words</a></li>
		<li><a href="#">Words</a></li>
		<li><a href="#">Words</a></li>
		<li><a href="#">Words</a></li>
		<li><a href="#">Words</a></li>
	</ul>
</footer>
<body>
	
</body>
</html>