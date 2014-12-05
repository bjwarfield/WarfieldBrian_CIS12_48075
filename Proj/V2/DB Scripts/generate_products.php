<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Random Products</title>
</head>
<body>
<?php
	include("word_generator.php");
	@require("../project_DBconnect.php");
	//INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) 
	$desc = bacon_ipsum(2);
	$s_desc = substr($desc,0,120);
	
	#Keen Edge
	/*for($i = 0; $i < 15; $i++ ){
		echo 'INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) VALUES ("KeenEdge - '.ucwords(rand_color()).' '.ucfirst(rand_animal()).'", 1, "KE'.substr(upc(),0,4).'", "'.$s_desc.'", "'.$desc.'", '.mt_rand(1,20).', 1, '.(mt_rand(20,60)*5).', '.(mt_rand(20,60)*2.5).', 1, "'.upc().'", 1, 36, NOW());<br />';
	}*/

/*	#Spec Warrior
	for($i = 0; $i < 15; $i++ ){
		echo 'INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) VALUES ("SpecWarrior - '.ucwords(rand_prefix()).' '.ucfirst(rand_warrior()).'", 1, "SW'.substr(upc(),0,4).'", "'.$s_desc.'", "'.$desc.'", '.mt_rand(1,20).', 1, '.(mt_rand(10,30)*5).', '.(mt_rand(10,30)*2.5).', 2, "'.upc().'", 1, 33, NOW());<br />';
	}*/

/*	#spartan Forge
	for($i = 0; $i < 15; $i++ ){
		echo 'INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) VALUES ("Spartan Forge - '.ucwords(rand_warrior()).' '.ucfirst(rand_blade()).'", 3, "SF'.substr(upc(),0,4).'", "'.$s_desc.'", "'.$desc.'", '.mt_rand(1,20).', 1, '.(mt_rand(20,80)*10).', '.(mt_rand(20,80)*2.5).', 5, "'.upc().'", '.mt_rand(3,10).', '.array(6,17,30,33)[mt_rand(0,3)].', NOW());<br />';
	}*/
	
	#Fantasy Replica
/*	for($i = 0; $i < 15; $i++ ){
		echo 'INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) VALUES ("Fantasy Replica - '.ucwords(jib_word(mt_rand(4,9))).' '.ucfirst(rand_blade()).'", 4, "FR'.substr(upc(),0,4).'", "'.$s_desc.'", "'.$desc.'", '.mt_rand(1,20).', 1, '.(mt_rand(20,80)*10).', '.(mt_rand(20,80)*2.5).', 8, "'.upc().'", '.mt_rand(3,10).', '.array(6,17,30,33)[mt_rand(0,3)].', NOW());<br />';
	}
	*/

	$cutlery = array("14\\\" Honing Steel", "10\\\" Chef's Knife", "9\\\" Carving Knife", "8\\\" Chef's Knife", "6\\\" Utility Knife", "6.5\\\" Santoku", "4\\\" Steak Knife", "3.5\\\" Paring Knife");
	$ktools = array('can opener', 'corkscrew', 'garlic press', 'grater', 'kitchen shears', 'ladle', 'lemon press', 'masher', 'peeler', 'peppermill', 'slotted spoon', 'spatula', 'tongs', 'whisk');

	#Kaine Cutlery
	#Classic
/*	foreach ($cutlery as $key => $value) {
		echo 'INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) VALUES ("Kaine Cutlery - Classic Series '.$value.'", 2, "KC10'.$key.'", "'.$s_desc.'", "'.$desc.'", '.mt_rand(1,20).', 1, '.strval(100-$key*10).', 0, 10, "'.upc().'", 1, 21, NOW());<br />';
	}*/

	#ElitePro
/*	foreach ($cutlery as $key => $value) {
		echo 'INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) VALUES ("Kaine Cutlery - ElitePro Series '.$value.'", 2, "KC30'.$key.'", "'.$s_desc.'", "'.$desc.'", '.mt_rand(1,20).', 1, '.strval(250-$key*15).', 0, 10, "'.upc().'", 1, 21, NOW());<br />';
	}*/

	#Swoofila Cutlery
/*	foreach ($cutlery as $key => $value) {
		echo 'INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) VALUES ("Swoofila Cutlery - Bamboo Series '.$value.'", 2, "SC7'.$key.'0", "'.$s_desc.'", "'.$desc.'", '.mt_rand(1,20).', 1, '.strval(300-$key*12).', 0, 9, "'.upc().'", 1, 31, NOW());<br />';

		echo 'INSERT INTO `bladeshop`.`entity_products` (`name`, `atribute_set_id`, `sku`, `short_description`, `long_description`, `on_hand_qty`, `taxable`, `price`, `cost`, `manufacturer_id`, `upc`, `shipping_weight`, `country_id`, `date_added`) VALUES ("Swoofila Cutlery - Blue Steel '.$value.'", 2, "SC5'.$key.'0", "'.$s_desc.'", "'.$desc.'", '.mt_rand(1,20).', 1, '.strval(350-$key*15).', 0, 9, "'.upc().'", 1, 16, NOW());<br />';
	}

*/
	#category assignment
	$q = 'SELECT product_id, name FROM  entity_products where manufacturer_id = 9 ';
	$r= @mysqli_query ($dbc, $q);

	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		echo 'INSERT INTO xref_product_categories (`category_id`, `product_id`) VALUES(9, '.$row['product_id'].');<br />';
		echo 'INSERT INTO xref_product_categories (`category_id`, `product_id`) VALUES(10, '.$row['product_id'].');<br />';
		echo 'INSERT INTO xref_product_categories (`category_id`, `product_id`) VALUES(24, '.$row['product_id'].');<br />';
	}
	mysqli_close($dbc);
?>
	
</body>
</html>