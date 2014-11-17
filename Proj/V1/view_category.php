<?php 
	if(isset($_GET['category_id']) && is_numeric($_GET['category_id'] )){
		$cat=$_GET['category_id'];
	}
	$page_title = 'View Category';
	 include('includes/header.html'); 

	 @require("project_DBconnect.php");

	 $q = 'SELECT `entity_products`.`product_id`, `entity_products`.`name`, `entity_products`.`short_description`, `entity_products`.`price`, `entity_categories`.`category_id` FROM `bladeshop`.`xref_product_categories` AS `xref_product_categories`, `bladeshop`.`entity_categories` AS `entity_categories`, `bladeshop`.`entity_products` AS `entity_products` WHERE `xref_product_categories`.`category_id` = `entity_categories`.`category_id` AND `xref_product_categories`.`product_id` = `entity_products`.`product_id` AND `entity_categories`.`category_id`= '.$cat.';';
	 $r = mysqli_query($dbc, $q);

	 echo '<div class="products_block">';
	 while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	 	echo '<div class="item_block"><div class="product_thumbnail"><a href= "view_product.php?product_id='.$row['product_id'].'"><img src="http://placehold.it/120x120"></a></div><div class="product_info"><a href="view_product.php?product_id='.$row['product_id'].'"><h2>'.$row['name'].'</h2></a><p>'.substr($row['short_description'],0,80).'<a href="view_product.php?product_id='.$row['product_id'].'">...<br /> See More</a></p></div><div class="price_block"><h3>$'.$row['price'].'</h3><button style="button">Add to Cart</button></div></div>';
	 } 
	 echo '</div>';
 	mysqli_free_result ($r);
	mysqli_close($dbc);
	include ('includes/footer.html');

?>
