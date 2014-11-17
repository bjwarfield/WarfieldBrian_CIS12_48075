<?php 
	$page_title = 'View Product';
	 include('includes/header.html'); 

	 @require("project_DBconnect.php");

	 $q = 'SELECT `name`, `short_description`, `price` FROM entity_Products;';
	 $r = mysqli_query($dbc, $q);

	 echo '<div class="products_block">';
	 while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	 	echo '<div class="item_block"><div class="product_thumbnail"><a href= "#"><img src="http://placehold.it/120x120"></a></div><div class="product_info"><a href="#"><h2>'.$row['name'].'</h2></a><p>'.substr($row['short_description'],0,80).'<a href="#">...<br /> See More</a></p></div><div class="price_block"><h3>$'.$row['price'].'</h3><button style="button">Add to Cart</button></div></div>';
	 } 
	 echo '</div>';

?>
