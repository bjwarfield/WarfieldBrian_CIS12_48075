<?php 
	$page_title = 'View Category';
	 include('includes/header.html'); 
	 // echo '<pre>';
	 // print_r( $cat_id);
	 // echo "<br/>";
	 // print_r($data);
	 // echo '</pre>';
	if(isset($_GET['category_id']) && is_numeric($_GET['category_id'] ) && array_key_exists($_GET['category_id'] , $data)){
		$cat_id=$_GET['category_id'];
	}else{
	 	echo '<h1 class="error">ERROR!</h1><p>This page has been reached in error. <a href="index.php">Please try again</a></p>';
	 	include('includes/footer.html');
	 	exit();
	 }
	 function breadcrumbs($id){
		global $data;
		$current = $data[$id];
		$parent_id = $current["parent_category_id"];
		$parents = array();
		$parent_id = $current["parent_category_id"] === 0 ? null : $current["parent_category_id"];
		while (isset($data[$parent_id])) {
			$current = $data[$parent_id];
			$parent_id = $current["parent_category_id"];
			$parents[] = '<a href="view_category.php?category_id='.$current['category_id'].'">'.$current["name"].'</a> > ';
		}
		echo implode(" ", array_reverse($parents));
	}

	
	echo '<nav class="breadcrumbs">';
	breadcrumbs($cat_id);
	echo $data[$cat_id]['name'].'</nav>';

	 @require("project_DBconnect.php");


	 $q = 'SELECT `entity_products`.`product_id`, `entity_products`.`name`, `entity_products`.`short_description`, `entity_products`.`price`, `entity_categories`.`category_id` FROM `bladeshop`.`xref_product_categories` AS `xref_product_categories`, `bladeshop`.`entity_categories` AS `entity_categories`, `bladeshop`.`entity_products` AS `entity_products` WHERE `xref_product_categories`.`category_id` = `entity_categories`.`category_id` AND `xref_product_categories`.`product_id` = `entity_products`.`product_id` AND `entity_categories`.`category_id`= '.$cat_id.';';
	 $r = mysqli_query($dbc, $q);
	 
	 if($r->num_rows > 0){
	 	echo '<h1>Category: '.$data[$cat_id]['name'].'</h1>';
	 	echo '<div class="products_block">';
	 	 while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	 		echo '<div class="item_block"><div class="product_thumbnail"><a href= "view_product.php?product_id='.$row['product_id'].'"><img src="http://placehold.it/120x120"></a></div><div class="product_info"><a href="view_product.php?product_id='.$row['product_id'].'"><h2>'.$row['name'].'</h2></a><p>'.substr($row['short_description'],0,120).'<a href="view_product.php?product_id='.$row['product_id'].'">...<br /> See More</a></p></div><div class="price_block"><h3>$'.$row['price'].'</h3><button style="button">Add to Cart</button></div></div>';
	 	 } 
	 	 echo '</div>';
	 	}else{
	 		echo "<h1>Under Construction</h1><p>This category does not have any products yet. Please try again later</p>";
	 	}
	mysqli_free_result ($r);
	mysqli_close($dbc);
	include ('includes/footer.html');

?>
