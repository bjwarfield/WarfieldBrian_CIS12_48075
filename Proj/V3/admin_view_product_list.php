<?php 
	session_name('PHPADMINID');
	session_start();
	$page_title = 'Product List Administration';//name page
	include('debug.php');

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

	// Count how many products are in current category
	 @require("project_DBconnect.php");
	$q = 'SELECT count(product_id) FROM bw1780661_entity_products;';
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


	//store pagination option in cookie for 30min
	setcookie("i_page", json_encode($paginator), time()+1800, '/');

	//Paginated links function
	function page_selector(){
		global $pages, $sort, $display, $start;//variables for pagination and sorting
		if ($pages > 1) {	 
	 	 echo '<br /><div class ="page_selector">';
			$current_page = ($start/$display) + 1;
			//set floor and celing for number of links in page selector
			$top = $current_page +5;
			$bottom = $current_page -5;
			//echo '<br/>'.$bottom.$current_page.$top.'<br/>';

			// If it's not the first page, make a Previous button:
			if ($current_page != 1) {
				echo '<a href="admin_view_product_list.php?s=' . ($start - $display) .'&display='.$display.'&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
			}
			
			// Make all the numbered pages:
			for ($i = 1; $i <= $pages; $i++) {
				//regular links for less than 10 pages
				if($pages<10){
					if ($i != $current_page) {
						echo '<a href="admin_view_product_list.php?s=' . (($display * ($i - 1))) .'&display='.$display.'&sort=' . $sort . '">' . $i . '</a> ';
					} else {
						echo $i . ' ';
					}
				}else{
					//Truncated links for more than 10 pages
					if ( $i != $current_page) {
						if($i > $bottom && $i < $top){//links adjascent to current page
							echo '<a href="admin_view_product_list.php?s=' . (($display * ($i - 1))) .'&display='.$display.'&sort=' . $sort . '">' . $i . '</a> ';
						}elseif($i == 1 ){//set first link
							echo '<a href="admin_view_product_list.php?s=' . (($display * ($i - 1))) .'&display='.$display.'&sort=' . $sort . '">First</a> ';
						}elseif($i == $pages){//set last link
							echo '<a href="admin_view_product_list.php?s=' . (($display * ($i - 1))) . '&display='.$display.'&sort=' . $sort . '">Last</a> ';
						}elseif($i == $bottom){//mark truncation points wil ellipses
							echo '<a href="admin_view_product_list.php?s=' . (($display * ($i - 1))) . '&display='.$display.'&sort=' . $sort . '">...' . $i . '</a> ';
						}elseif($i == $top){
							echo '<a href="admin_view_product_list.php?s=' . (($display * ($i - 1))) . '&display='.$display.'&sort=' . $sort . '">' . $i . '...</a> ';
						}
					} elseif ($i = $current_page) {//current page, no link
						echo $i . ' ';
					}
				}
			} // End of FOR loop.
			
			// If it's not the last page, make a Next button:
			if ($current_page != $pages) {
				echo '<a href="admin_view_product_list.php?s=' . ($start + $display) . '&display='.$display.'&sort=' . $sort . '">Next</a>';
			}
			echo '</div>'; // Close the div.
		}
	}	
	include('includes/admin.html'); 
	#create pagination options
	 echo '<form class="paginator" action="admin_view_product_list.php" method="get">
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
 				<input name="s" type="hidden" value="'.$start.'">
			</form>';

	#Query for products within the qualified range
	$q = 'SELECT `bw1780661_entity_products`.`product_id`, `bw1780661_entity_products`.`name`, `bw1780661_entity_products`.`sku`, `bw1780661_entity_products`.`on_hand_qty`, `bw1780661_entity_products`.`price`, `bw1780661_enum_manufacturer`.`manufacturer_name`, `bw1780661_entity_products`.`shipping_weight`, `bw1780661_enum_country`.`country`, DATE_FORMAT( `date_added`, "%d %b %Y" ) AS `date_added` FROM { OJ  `bw1780661_entity_products` LEFT OUTER JOIN  `bw1780661_enum_country` ON `bw1780661_entity_products`.`country_id` = `bw1780661_enum_country`.`country_id` LEFT OUTER JOIN `bw1780661_enum_manufacturer` ON `bw1780661_entity_products`.`manufacturer_id` = `bw1780661_enum_manufacturer`.`manufacturer_id` }, `bw1780661_entity_atribute_set` WHERE `bw1780661_entity_products`.`atribute_set_id` = `bw1780661_entity_atribute_set`.`atribute_set_id` ORDER BY '.$order_by.' LIMIT '.$start.', '.$display.';';
	//echo $q;
	 $r = mysqli_query($dbc, $q);

	# Table header:
echo '<table class="admin_product_list">
	<thead>
	<tr>
		<th>Action</th>
		<th>Name</th>
		<th>SKU</th>
		<th>Qty</th>
		<th>Price</th>
		<th>Manufacturer</th>
		<th>Country</th>
		<th>Creation Date</th>
	</tr>
	</thead><tbody>
	';
	 if(mysqli_num_rows($r)>0){
	 	echo '<h1 class="admin_product_list_heading">Product List Administration</h1>';
	 	page_selector();
	 	 while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
	 		echo '
	 		<tr>
	 			<td class="action_column"><form action="admin_edit_item.php" method="post"><input type="hidden" name="product_id" value="'.$row['product_id'].'" ><input type="submit" value="Edit"></form></td>
	 			<td>'.$row['name'].'</td>
	 			<td>'.$row['sku'].'</td>
	 			<td>'.$row['on_hand_qty'].'</td>
	 			<td>$'.$row['price'].'</td>
	 			<td>'.$row['manufacturer_name'].'</td>
	 			<td>'.$row['country'].'</td>
	 			<td>'.$row['date_added'].'</td>
	 		</tr>
				';
 	 } 
 	 echo '</tbody></table>';
	 page_selector();
	 	}
	mysqli_free_result ($r);
	mysqli_close($dbc);
	include ('includes/footer.html');

?>
