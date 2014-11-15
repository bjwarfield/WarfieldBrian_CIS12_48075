<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Bladeshop -</title>
	<link rel="stylesheet" type="text/css" href="includes/mo_styles.css">
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
	/*	echo"<pre>
		Data:\n";
		print_r($data);
		echo "\nIndex:\n";
		print_r($index);
		echo '
	</pre>
	';*/

	//Recursive function for navbar output
	function display_nav($parent_id = 0){
		global $data, $index;
		$parent_id = $parent_id;
		if(isset($index[$parent_id])){
			echo '<ul> ';
			foreach ($index[$parent_id] as $id) {
				echo '<li> <a href="view_product.php?category_id='.$data[$id]['category_id'].'">'.$data[$id]['name']."</a>";
				 display_nav($id);
				 echo "</li>";
			}
			echo '</ul> ';
		}
	}
	echo "<nav> ";
	display_nav();//build navbar 
	echo"</nav> ";

	mysqli_close($dbc);


?>
<div class="content">
	<!-- Individial page content starts here  -->
	<h1>Welcome to the Blade Shop</h1>
	<p> Bacon ipsum dolor amet enim frankfurter non exercitation. Leberkas minim elit frankfurter, fatback strip steak ball tip jowl aliqua flank ham hock pork. Cow minim qui sirloin alcatra adipisicing. Consectetur pancetta drumstick kielbasa t-bone cillum aliqua duis et laboris lorem in tail meatloaf. </p>
	<h2>We got what you need</h2>
	<p> Hamburger doner biltong tempor. Porchetta chicken leberkas consectetur mollit sausage boudin dolore duis. Officia excepteur chicken, flank venison pork loin esse ullamco aliquip bacon chuck dolore rump drumstick doner. Laboris jerky short loin, meatloaf pork nisi non exercitation turkey kevin frankfurter ground round shankle. Swine ground round fatback kevin pork loin elit brisket biltong magna consectetur officia fugiat prosciutto. </p>
	<h2>It's a Wonderful Knife</h2>
	<p> Ex venison jowl laboris shankle, nulla ullamco quis. Andouille ground round ut ut pariatur. Velit shank excepteur, in ground round flank biltong chicken labore in ball tip picanha tail qui. Picanha ea biltong jerky. Magna jerky anim in swine occaecat. Voluptate ball tip beef ribs, sunt excepteur shankle shank tri-tip brisket quis qui dolor fugiat magna short ribs. </p>
	<h2>Jack of all blades</h2>
	<p> Occaecat alcatra jowl nostrud, turkey shankle adipisicing in. Aute in sunt strip steak culpa labore brisket sirloin hamburger occaecat. Pancetta quis tail tri-tip. Sirloin fugiat alcatra labore tempor enim short loin ut non id venison. Velit elit aliquip, flank eu irure landjaeger ad sausage tail duis prosciutto jerky. Dolor ribeye labore dolore. </p>
	<h2>If you shop anywhere else, we'll have you killed.</h2>
	<p> In ball tip dolore short loin. Ham tenderloin reprehenderit, drumstick magna chicken prosciutto cillum dolore. Kevin et t-bone alcatra. Meatball consectetur t-bone esse dolore, reprehenderit swine prosciutto beef ribs tail qui doner jowl. Nisi labore pancetta cow venison cupidatat spare ribs, jerky incididunt laborum. Prosciutto bacon sirloin tenderloin ribeye picanha lorem. </p>
	<!-- Individial page content ends here -->
</div>
<footer>
	<ul>
		<li> <a href="#">Words</a> </li>
		<li> <a href="#">Words</a> </li>
		<li> <a href="#">Words</a> </li>
		<li> <a href="#">Words</a> </li>
		<li> <a href="#">Words</a> </li>
	</ul>
</footer>
<body></body>
</html>