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
	if(isset($_GET['display'])&& is_numeric($_GET['display'])){
		$display = $_GET['display'];
	}else{
		$display = 10;
	}
	//echo '<p>display = '.$display.'</p>';
	// echo '<p>IS P SET? = '.isset($_GET['p']).'</p>';
	// echo '<p>IS P NUMERIC? = '.is_numeric($_GET['p']).'</p>';
	 @require("project_DBconnect.php");
	// Determine how many pages there are...
	$q = 'SELECT COUNT( `xref_product_categories`.`product_id` ), `xref_product_categories`.`category_id` FROM `bladeshop`.`xref_product_categories` AS `xref_product_categories`, `bladeshop`.`entity_products` AS `entity_products`, `bladeshop`.`entity_categories` AS `entity_categories` WHERE `xref_product_categories`.`product_id` = `entity_products`.`product_id` AND `xref_product_categories`.`category_id` = `entity_categories`.`category_id` AND `xref_product_categories`.`category_id` = '.$cat_id.';';
	$r = @mysqli_query ($dbc, $q);
	/*echo '<pre>';
	print_r($r);
	echo "</pre>";*/
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	//echo '<p>records = '.$records.'</p>';
	// Calculate the number of pages...
	if ($records > $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
	echo '<p>Pages = '.$pages.'</p>';

	// Determine where in the database to start returning results...
	$start = (isset($_GET['s']) && is_numeric($_GET['s'])) ? $_GET['s'] : 0;

	// Determine the sort...
	// Default is by registration date.
	$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'name';

	// Determine the sorting order:
	switch ($sort) {
		case 'namea':
			$order_by = 'name ASC';
			break;
		case 'named':
			$order_by = 'name DESC';
			break;
		case 'pricea':
			$order_by = 'price ASC';
			break;
		case 'priced':
			$order_by = 'price DESC';
			break;
		default:
			$order_by = 'name ASC';
			$sort = 'namea';
			break;
	}

	function page_selector(){
		global $pages, $sort, $cat_id, $display, $start;
		if ($pages > 1) {	 
	 	 echo '<br /><div class ="page_selector">';
			$current_page = ($start/$display) + 1;
			$top = $current_page +5;
			$bottom = $current_page -5;
			//echo '<br/>'.$bottom.$current_page.$top.'<br/>';
			// If it's not the first page, make a Previous button:
			if ($current_page != 1) {
				echo '<a href="view_category.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '&category_id='.$cat_id.'">Previous</a> ';
			}
			
			// Make all the numbered pages:
			for ($i = 1; $i <= $pages; $i++) {
				if($pages<10){
					if ($i != $current_page) {
						echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '&category_id='.$cat_id.'">' . $i . '</a> ';
					} else {
						echo $i . ' ';
					}
				}else{

					if ( $i != $current_page) {
						if($i > $bottom && $i < $top){
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort .'&category_id='.$cat_id. '">' . $i . '</a> ';
						}elseif($i == 1 ){
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '&category_id='.$cat_id.'">First</a> ';
						}elseif($i == $pages){
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '&category_id='.$cat_id.'">Last</a> ';
						}elseif($i == $bottom){
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '&category_id='.$cat_id.'">...' . $i . '</a> ';
						}elseif($i == $top){
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '&category_id='.$cat_id.'">' . $i . '...</a> ';
						}
					} elseif ($i = $current_page) {
						echo $i . ' ';
					}
				}
			} // End of FOR loop.
			
			// If it's not the last page, make a Next button:
			if ($current_page != $pages) {
				echo '<a href="view_category.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '&category_id='.$cat_id.'">Next</a>';
			}
			
			echo '</div>'; // Close the div.
		}
	}	


	 $q = 'SELECT `entity_products`.`product_id`, `entity_products`.`name`, `entity_products`.`short_description`, `entity_products`.`price`, `entity_categories`.`category_id` FROM `bladeshop`.`xref_product_categories` AS `xref_product_categories`, `bladeshop`.`entity_categories` AS `entity_categories`, `bladeshop`.`entity_products` AS `entity_products` WHERE `xref_product_categories`.`category_id` = `entity_categories`.`category_id` AND `xref_product_categories`.`product_id` = `entity_products`.`product_id` AND `entity_categories`.`category_id`= '.$cat_id.' ORDER BY '.$order_by.' LIMIT '.$start.', '.$display.';';

	 $r = mysqli_query($dbc, $q);
/*	 echo '<pre>';
	 print_r($r);
	 echo '</pre>';*/

	 echo '<form class="paginator" action="view_category.php" method="get">
	 			<label>Sort</label>
	 			<select name="sort">
	 				<option value="namea" '.(($sort=="namea")?'selected="selected"':'').'>Name [A-Z]</option>
	 				<option value="named" '.(($sort=="named")?'selected="selected"':'').'>Name [Z-A]</option>
	 				<option value="pricea" '.(($sort=="pricea")?'selected="selected"':'').'">Price, Lowest First</option>
	 				<option value="priced" '.(($sort=="priced")?'selected="selected"':'').'">Price, Highest First</option>
 				</select>
 				<label>Display</label>
 				<select name=display>
	 				<option value="5" '.(($display==5)?'selected="selected"':'').'>5</option>
 					<option value="10" '.(($display==10)?'selected="selected"':'').'>10</option>
 					<option value="15" '.(($display==15)?'selected="selected"':'').'>15</option>
 					<option value="20" '.(($display==20)?'selected="selected"':'').'>20</option>
 					<option value="25" '.(($display==25)?'selected="selected"':'').'>25</option>
 					<option value="30" '.(($display==30)?'selected="selected"':'').'>30</option>
 				</select>
 				<input type="submit" value="Submit">
 				<input name="category_id" type="hidden" value='.$cat_id.'>
 				<input name="s" type="hidden" value="'.$start.'">
 				<input name="p" type="hidden" value="'.$pages.'">
			</form>';
	 if(mysqli_num_rows($r)>0){
	 	echo '<h1 class="cat_heading">Category: '.$data[$cat_id]['name'].'</h1>';
	 	page_selector();
	 	echo '<div class="products_block">';
	 	 while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	 		echo '
	 		<div class="item_block">
	 			<div class="product_thumbnail">
	 				<a href= "view_product.php?product_id='.$row['product_id'].'"> <img src="http://placehold.it/120x120"></a>
	 			</div>
	 			<div class="product_info">
	 				<a href="view_product.php?product_id='.$row['product_id'].'"> <h2>'.$row['name'].'</h2> </a>
	 				<p> '.substr($row['short_description'],0,140).'<a href="view_product.php?product_id='.$row['product_id'].'"> ... <br />
 						See More </a> </p>
	 			</div>
	 			<div class="price_block">
	 				<h3>$'.$row['price'].'</h3>
	 				<button style="button">Add to Cart</button>
	 			</div>
	 		</div>
				';
 	 } 
 	 echo '</div>';
	 page_selector();
	 	}else{
	 		echo "<h1>Under Construction</h1><p>This category does not have any products yet. Please try again later</p>";
	 	}
	mysqli_free_result ($r);
	mysqli_close($dbc);
	include ('includes/footer.html');

?>
