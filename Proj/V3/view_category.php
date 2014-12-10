<?php 
	session_start();
	$page_title = 'View Category';//name page
	

	 //check for paginator cookie
	if (isset($_COOKIE['i_page'])){
		$paginator = json_decode($_COOKIE['i_page'], TRUE);
		$display = $paginator['display'];
		$sort = $paginator['sort'];	
	} 
	// out_obj($paginator);
	//check $_GET for validity, set defaul if not 
	if(isset($_GET['display'])&& is_numeric($_GET['display'])){
		$paginator["display"] = $display = $_GET['display'];
	}else if(!isset($paginator["display"])){
		$paginator["display"] = $display = 10;
	}


	// Check $_GET and cookie data for sort validity, Default to Name ASC
	//check $_GET for validity, set defaul if not 
	if(isset($_GET['sort'])){
		$paginator["sort"] = $sort = $_GET['sort'];
	}else if(!isset($paginator["sort"])){
		$paginator["sort"] = $sort = 'namea';
	}

	// Determine the sorting order:
	//set variable for query
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
	case 'skua':
		$order_by = 'sku ASC';
		break;
	case 'skud':
		$order_by = 'sku DESC';
		break;
	case 'qtya':
		$order_by = 'on_hand_qty ASC';
		break;
	case 'qtyd':
		$order_by = 'on_hand_qty DESC';
		break;
	default:
		$order_by = 'name ASC';
		$sort = 'namea';
		break;
	}
	$paginator['sort'] = $sort;
	
	#check for View All and/or search in $_Get
	if(isset($_GET['view_all'])){//view all enabled product, regardless of category 
			$va = true;
			isset($_GET['search'])?$search=filter_input(INPUT_GET,'search'):$search = '';//Check for search String
		}

	include('includes/header.html'); 	

	//Check $_GET for validity and register category
	if(isset($_GET['category_id']) && is_numeric($_GET['category_id'] ) && array_key_exists($_GET['category_id'] , $data)){
		$cat_id=$_GET['category_id'];
	}

	//store pagination option in cookie for 30min
	setcookie("i_page", json_encode($paginator), time()+1800, '/');


	// Count how many products are in current category
	 @require("project_DBconnect.php");
	 if(!isset($va)){//if not View all, select category
	 	$q = 'SELECT COUNT( `bw1780661_xref_product_categories`.`product_id` ), `bw1780661_xref_product_categories`.`category_id` FROM `bw1780661_xref_product_categories`, `bw1780661_entity_products`, `bw1780661_entity_categories` WHERE `bw1780661_xref_product_categories`.`product_id` = `bw1780661_entity_products`.`product_id` AND `bw1780661_xref_product_categories`.`category_id` = `bw1780661_entity_categories`.`category_id` AND `bw1780661_entity_products`.`enabled` = TRUE AND `bw1780661_xref_product_categories`.`category_id` = '.$cat_id.';';
	 }else{//otherwise get all enabled products
	 	$q = 'SELECT COUNT( `product_id` ) FROM  `bw1780661_entity_products` WHERE `enabled` = TRUE AND `name` LIKE "%'.$search.'%";';
	 }
	$r = @mysqli_query ($dbc, $q);
		
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	
	// Calculate the number of pages...
	if ($records > $display) { 
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}

	// Determine where in the database to start returning results...
	$start = (isset($_GET['s']) && is_numeric($_GET['s']) && $_GET['s'] <= $records-1 && $_GET['s']>=0 ) ? $_GET['s'] : 0;


	// Check $_GET for sort validity, Default to Name ASC
	// Determine where in the database to start returning results...
	$start = (isset($_GET['s']) && is_numeric($_GET['s']) && $_GET['s'] <= $records-1 && $_GET['s']>=0 ) ? $_GET['s'] : 0;




	 //Recursive function traces branch path to root category, outputting the results in reverse 
	 function breadcrumbs($id){
		global $data;//Category data from header include
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


	//call breadcrumbs for link path to current category if not in view all mode
	if(!isset($va)){
		echo '<nav class="breadcrumbs">';
		breadcrumbs($cat_id);
		echo $data[$cat_id]['name'].'</nav>';
	}

	

	//Paginated links function
	function page_selector(){
		global $pages, $sort, $cat_id, $display, $start, $va, $search;//variables for pagination and sorting
		if ($pages > 1) {	 
	 	 echo '<br /><div class ="page_selector">';
			$current_page = ($start/$display) + 1;
			//set floor and celing for number of links in page selector
			$top = $current_page +5;
			$bottom = $current_page -5;
			//echo '<br/>'.$bottom.$current_page.$top.'<br/>';

			// If it's not the first page, make a Previous button:
			if ($current_page != 1) {
				echo '<a href="view_category.php?s=' . ($start - $display) .'&display='.$display.'&p=' . $pages . '&sort=' . $sort . (isset($va)?'&view_all=1&search='.$search:'&category_id='.$cat_id) . '">Previous</a> ';
			}//ternary operator detects between category view and view all 
			
			// Make all the numbered pages:
			for ($i = 1; $i <= $pages; $i++) {
				//regular links for less than 10 pages
				if($pages<10){
					if ($i != $current_page) {
						echo '<a href="view_category.php?s=' . (($display * ($i - 1))) .'&display='.$display.'&sort=' . $sort . (isset($va)?'&view_all=1&search='.$search:'&category_id='.$cat_id).'">' . $i . '</a> ';
					} else {
						echo $i . ' ';
					}
				}else{
					//Truncated links for more than 10 pages
					if ( $i != $current_page) {
						if($i > $bottom && $i < $top){//links adjascent to current page
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) .'&display='.$display.'&sort=' . $sort .(isset($va)?'&view_all=1&search='.$search:'&category_id='.$cat_id). '">' . $i . '</a> ';
						}elseif($i == 1 ){//set first link
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) .'&display='.$display.'&sort=' . $sort . (isset($va)?'&view_all=1&search='.$search:'&category_id='.$cat_id).'">First</a> ';
						}elseif($i == $pages){//set last link
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&display='.$display.'&sort=' . $sort . (isset($va)?'&view_all=1&search='.$search:'&category_id='.$cat_id).'">Last</a> ';
						}elseif($i == $bottom){//mark truncation points wil ellipses
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&display='.$display.'&sort=' . $sort . (isset($va)?'&view_all=1&search='.$search:'&category_id='.$cat_id).'">...' . $i . '</a> ';
						}elseif($i == $top){
							echo '<a href="view_category.php?s=' . (($display * ($i - 1))) . '&display='.$display.'&sort=' . $sort . (isset($va)?'&view_all=1&search='.$search:'&category_id='.$cat_id).'">' . $i . '...</a> ';
						}
					} elseif ($i = $current_page) {//current page, no link
						echo $i . ' ';
					}
				}
			} // End of FOR loop.
			
			// If it's not the last page, make a Next button:
			if ($current_page != $pages) {
				echo '<a href="view_category.php?s=' . ($start + $display) . '&display='.$display.'&sort=' . $sort . (isset($va)?'&view_all=1&search='.$search:'&category_id='.$cat_id).'">Next</a>';
			}
			echo '</div>'; // Close the div.
		}
	}	

	//Query for products within the qualified range
	if(!isset($va)){
		$q = 'SELECT `bw1780661_entity_products`.`product_id`, `bw1780661_entity_products`.`name`, `bw1780661_entity_products`.`short_description`, `bw1780661_entity_products`.`price`, `bw1780661_entity_products`.`on_hand_qty`,  `bw1780661_entity_products`.`image_url`, `bw1780661_entity_categories`.`category_id` FROM  `bw1780661_xref_product_categories`,   `bw1780661_entity_categories`,  `bw1780661_entity_products` WHERE `bw1780661_xref_product_categories`.`category_id` = `bw1780661_entity_categories`.`category_id` AND `bw1780661_xref_product_categories`.`product_id` = `bw1780661_entity_products`.`product_id` AND `bw1780661_entity_products`.`enabled` = TRUE AND `bw1780661_entity_categories`.`category_id`= '.$cat_id.' ORDER BY '.$order_by.' LIMIT '.$start.', '.$display.';';
	}else{//select all enabled products 
		$q = 'SELECT `product_id`, `name`, `short_description`, `price`, `on_hand_qty`, `image_url` FROM   `bw1780661_entity_products` WHERE `enabled` = TRUE AND `name` LIKE "%'.$search.'%" GROUP BY `product_id` ORDER BY '.$order_by.' LIMIT '.$start.', '.$display.';';
	}
	
	 $r = mysqli_query($dbc, $q);


	 echo '<form class="paginator" action="view_category.php" method="get">
	 			<label>Sort</label>
	 			<select name="sort">
	 				<option value="namea" '.(($sort=="namea")?'selected="selected"':'').'>Name, [A-Z]</option>
	 				<option value="named" '.(($sort=="named")?'selected="selected"':'').'>Name, [Z-A]</option>
	 				<option value="pricea" '.(($sort=="pricea")?'selected="selected"':'').'>Price, Lowest First</option>
	 				<option value="priced" '.(($sort=="priced")?'selected="selected"':'').'>Price, Highest First</option>
	 				<option value="skua" '.(($sort=="skua")?'selected="selected"':'').'>SKU [A-Z]</option>
	 				<option value="skud" '.(($sort=="skud")?'selected="selected"':'').'>SKU [Z-A]</option>
	 				<option value="qtya" '.(($sort=="qtya")?'selected="selected"':'').'>Quantity, Least First</option>
	 				<option value="qtyd" '.(($sort=="qtyd")?'selected="selected"':'').'>Quantity, Most First</option>
				</select>
				<label>Display</label>
				<select name=display>
 					<option value="5" '.(($display==5)?'selected="selected"':'').'>5</option>
					<option value="10" '.(($display==10)?'selected="selected"':'').'>10</option>
					<option value="15" '.(($display==15)?'selected="selected"':'').'>15</option>
					<option value="20" '.(($display==20)?'selected="selected"':'').'>20</option>
					<option value="25" '.(($display==25)?'selected="selected"':'').'>25</option>
					<option value="30" '.(($display==30)?'selected="selected"':'').'>30</option>
					<option value="35" '.(($display==35)?'selected="selected"':'').'>35</option>
					<option value="40" '.(($display==40)?'selected="selected"':'').'>40</option>
					<option value="45" '.(($display==45)?'selected="selected"':'').'>45</option>
					<option value="50" '.(($display==50)?'selected="selected"':'').'>50</option>
 				</select>
 				<input type="submit" value="Submit">
 				<input name="'.(isset($va)?"view_all":"category_id").'" type="hidden" value='.(isset($va)?"1":$cat_id).'>' 				
 				.'<input name="s" type="hidden" value="'.$start.'">
 				'.(isset($search)?"<input type='hidden' value='$search'>":'').'
			</form>';
	 if(mysqli_num_rows($r)>0){
	 	echo '<h1 class="cat_heading">'.(isset($va)?(isset($search)?'Search Results':'View all Products'):'Category: '.$data[$cat_id]['name']).'</h1>';
	 	
	 	
	 	page_selector();
	 	echo '<div class="products_block">';
	 	 while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	 		echo '
	 		<div class="item_block">
	 			<div class="product_thumbnail">
	 				<a href= "view_product.php?product_id='.$row['product_id'].'"> <img src="'.(isset($row['image_url'])?$row['image_url']:'http://placehold.it/120x120)').'" style="max-width:120px;max-height:120px;"></a>
	 			</div>
	 			<div class="product_info">
	 				<a href="view_product.php?product_id='.$row['product_id'].'"> <h2>'.$row['name'].'</h2> </a>
	 				<p> '.substr($row['short_description'],0,140).'<a href="view_product.php?product_id='.$row['product_id'].'"> ... <br />
 						See More </a> </p>
	 			</div>
	 			<div class="price_block">
	 				<h3>$'.$row['price']."</h3>
	 				<button type='button' onclick='addCart(".json_encode(array ('pid' => $row['product_id'], 'pn' => $row['name'], 'pp' => $row['price'], 'pmq' => $row['on_hand_qty']),JSON_HEX_APOS | JSON_HEX_QUOT).")'>Add to Cart</button>
	 			</div>
	 		</div>
				";
 	 } 

 	 echo '</div>';
	 page_selector();
	 	}elseif(isset($search)){
	 		echo "<h1>Search Results</h1><p>No Items Found</p>";
	 	}else{
	 		echo "<h1>Under Construction</h1><p>This category does not have any products yet. Please try again later</p>";
	 	}
	mysqli_free_result ($r);
	mysqli_close($dbc);
	include ('includes/footer.html');

?>
