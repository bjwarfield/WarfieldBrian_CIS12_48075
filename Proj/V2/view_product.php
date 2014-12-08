<?php 
	session_start();
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

	 $q = 'SELECT `entity_products`.`name`, `entity_products`.`sku`, `entity_products`.`short_description`, `entity_products`.`long_description`, `entity_products`.`price`, `entity_products`.`on_hand_qty`, `enum_manufacturer`.`manufacturer_name`, `entity_products`.`upc`, `enum_country`.`country`, `entity_products`.`image_url` FROM `bladeshop`.`entity_products` AS `entity_products`, `bladeshop`.`enum_country` AS `enum_country`, `bladeshop`.`entity_atribute_set` AS `entity_atribute_set`, `bladeshop`.`enum_manufacturer` AS `enum_manufacturer` WHERE `entity_products`.`country_id` = `enum_country`.`country_id` AND `entity_products`.`atribute_set_id` = `entity_atribute_set`.`atribute_set_id` AND `entity_products`.`manufacturer_id` = `enum_manufacturer`.`manufacturer_id` AND `entity_products`.`product_id` = '.$pro_id.' ;';
	 $r = mysqli_query($dbc, $q);

	 
	 if ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){

	 	echo '<div class="item_detail">';
	 	echo '<img src="'.(isset($row['image_url'])?$row['image_url']:'http://placehold.it/250x250)').'" style="max-width:250px;max-height:250px;margin:15px;float:left;">';
	 	echo '<h1>'.$row['name'].'</h1>';
	 	echo '<p><strong>Manufacturer</strong>: '.$row['manufacturer_name'].'</p>';
	 	echo '<p><strong>SKU</strong>: '.$row['sku'].'</p>';
	 	echo '<p><strong>Price</strong>: '.$row['price'].($row['on_hand_qty']>0?" <strong>Qty:</strong> ".$row['on_hand_qty']:"<strong>Out of Stock</strong>'" ).'</p>';
	 	echo "<button type='button' ".($row['on_hand_qty']>0?"":"disabled='disabled'" )." onclick='addCart(".json_encode(array ('pid' => $pro_id, 'pn' => $row['name'], 'pp' => $row['price'], 'pmq' => $row['on_hand_qty']  ), JSON_HEX_APOS | JSON_HEX_QUOT).")'>Add to Cart</button>";
	 	echo '<p><strong style="font-size:125%;">Description:</strong> <br/>'.$row['long_description'].'</p>';
	 	echo '<p>Made in: '.$row['country'].'</p>';
	 	echo '</div>';
	 }else{
	 	echo '<h1 class="error">Error</h1>
	 	<p>Item not found</p>';
	 	echo '<a href="javascript:history.back(1);">Go Back</a>';
	 }
	 
	mysqli_free_result ($r);
	mysqli_close($dbc);
	include ('includes/footer.html');

?>
