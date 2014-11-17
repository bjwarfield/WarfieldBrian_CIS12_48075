<?php 
	$page_title = 'View Product';
	 include('includes/header.html'); 
	 	if(isset($_GET['product_id']) && is_numeric($_GET['product_id'] )){
		$pro_id=$_GET['product_id'];
	}else{
	 	echo '<h1 class="error">ERROR!</h1><p>This page has been reached in error. <a href="index.php">Please try again</a></p>';
	 	include('includes/footer.html');
	 	exit();
	 }

	 @require("project_DBconnect.php");

	 $q = 'SELECT `entity_products`.`name`, `entity_products`.`sku`, `entity_products`.`short_description`, `entity_products`.`long_description`, `entity_products`.`price`, `enum_manufacturer`.`manufacturer_name`, `entity_products`.`upc`, `enum_country`.`country` FROM `bladeshop`.`entity_products` AS `entity_products`, `bladeshop`.`enum_country` AS `enum_country`, `bladeshop`.`entity_atribute_set` AS `entity_atribute_set`, `bladeshop`.`enum_manufacturer` AS `enum_manufacturer` WHERE `entity_products`.`country_id` = `enum_country`.`country_id` AND `entity_products`.`atribute_set_id` = `entity_atribute_set`.`atribute_set_id` AND `entity_products`.`manufacturer_id` = `enum_manufacturer`.`manufacturer_id` AND `entity_products`.`product_id` = '.$pro_id.' ;';
	 $r = mysqli_query($dbc, $q);

	 echo '<div class="item_detail">';
	 while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	 	echo '<img src="http://placehold.it/320x320">';
	 	echo '<h1>'.$row['name'].'</h1>';
	 	echo '<p>Manufacturer: '.$row['manufacturer_name'].'</p>';
	 	echo '<p>SKU: '.$row['sku'].'</p>';
	 	echo '<p>Price: '.$row['price'].'</p>';
	 	echo '<p>'.$row['long_description'].'</p>';
	 	echo '<p>Made in: '.$row['country'].'</p>';
	 		 } 
	 echo '</div>';
	mysqli_free_result ($r);
	mysqli_close($dbc);
	include ('includes/footer.html');

?>
