<?php 
	session_name('PHPADMINID');
	session_start();
	$page_title = 'Product Administration';
	include('includes/admin.html'); 
	include('convert_state.php');
	
	#validate product ID, exit if invalid
	if($_SERVER['REQUEST_METHOD']=='POST' && !isset($_POST_["product_id"])){
		if(isset($_POST['product_id']) && is_numeric($_POST['product_id'] )){
			$pro_id=$_POST['product_id'];
			@require("project_DBconnect.php");
		}else{
		 	echo '<h1 class="error">ERROR!</h1><p>This page has been reached in error. <a href="admin_index.php">Please try again</a></p>';
		 	include('includes/footer.html');
		 	exit();
		}
	}else{
		 	echo '<h1 class="error">ERROR!</h1><p>This page has been reached in error. <a href="admin_index.php">Please try again</a></p>';
		 	include('includes/footer.html');
		 	exit();
		 }

	#validate posted form values
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["edit"])){
		
		$errors = array();
		if(empty($_POST['name'])){
			$errors[] = "Missing Name.";
		}else{
			$name = mysqli_real_escape_string($dbc, trim($_POST['name']));
		}
		if(empty($_POST['sku'])){
			$errors[] = "Missing SKU.";
		}else{
			$sku = mysqli_real_escape_string($dbc, trim($_POST['sku']));
		}
		if(empty($_POST['short_description'])){
			$errors[] = "Missing Short Description.";
		}else{
			$sd = mysqli_real_escape_string($dbc, trim($_POST['short_description']));
		}
		if(empty($_POST['long_description'])){
			$errors[] = "Missing Long Description.";
		}else{
			$ld = mysqli_real_escape_string($dbc, trim($_POST['long_description']));
		}
		if(empty($_POST['on_hand_qty'])){
			$errors[] = "Missing On Hand Quantity.";
		}else{
			$oh_qty = mysqli_real_escape_string($dbc, trim($_POST['on_hand_qty']));
			if(!preg_match("/^\d+$/",$oh_qty)){
				$errors[] = "Positive integers only for On-Hand Quantity.";
			}
		}
		if(isset($_POST['taxable'])){#form input checkbox
			$tax = 1;
		}else{
			$tax = 0;
		}

		if(empty($_POST['price'])){
			$errors[] = "Missing Price.";
		}else{
			$price = mysqli_real_escape_string($dbc, trim($_POST['price']));
			if(!is_numeric($price)){
				$errors[] = "Price must be numeric value.";
			}else if(!preg_match("/^(\d*(\.\d{1,2})?)$/",$oh_qty)){
				$errors[] = "Price must be positive Decimal (2 or 3.50).";
			}
		}

		if(empty($_POST['cost'])){
			$cost = '';
		}else{
			$cost = mysqli_real_escape_string($dbc, trim($_POST['cost']));
			if(!is_numeric($cost)){
				$errors[] = "Cost must be numeric value.";
			}else if(!preg_match("/^(\d*(\.\d{1,2})?)$/",$cost)){
				$errors[] = "Cost must be positive Decimal (2 or 3.50).";
			}
		}

		if(empty($_POST['manufacturer_id'])){
			$man_id = "";
		}else{
			$man_id = mysqli_real_escape_string($dbc, trim($_POST['manufacturer_id']));
			if(!is_numeric($man_id)){
				$errors[] = "Manufacturer assignment error: Contact administrator.";
			}
		}
		if(empty($_POST['upc'])){
			$upc = '';
		}else{
			$upc = mysqli_real_escape_string($dbc, trim($_POST['upc']));
			if(!is_numeric($upc)){
				$errors[] = "UPC must be numeric value.";
			}
		}
		if(empty($_POST['shipping_weight'])){
			$sw = '';
		}else{
			$sw = mysqli_real_escape_string($dbc, trim($_POST['shipping_weight']));
			if(!is_numeric($sw)){
				$errors[] = "Shipping weight must be numeric value.";
			}else if(!preg_match("/^\d+$/",$sw)){
				$errors[] = "Shipping weight must be positive integer.";
			}
		}
		if(empty($_POST['image_url'])){
			$iu = "";
		}else{
			$iu = mysqli_real_escape_string($dbc, trim($_POST['image_url']));
			if(!preg_match('/^([a-zA-Z\-_0-9\/\:\.%]*)$/', $iu)){
				$errors[] = "Please enter a valid image URL";
			}
		}
		if(empty($_POST['country_id'])){
			$country_id = "NULL";
		}else{
			$country_id = mysqli_real_escape_string($dbc, trim($_POST['country_id']));
			if(!is_numeric($country_id)){
				$errors[] = "Country assignment error: Contact administrator.";
			}
		}
		if(isset($_POST['enabled'])){#form input checkbox
			$en = TRUE;
		}else{
			$en = FALSE;
		}
		if(empty($errors)){#if no errors
			@require('project_DBconnect.php');
			#update DB record with validated values
			$q = "UPDATE bw1780661_entity_products SET `name` = '$name', `sku` = '$sku', `short_description` = '$sd', `long_description` = '$ld', `on_hand_qty` = '$oh_qty', `taxable`= $tax, `price` = $price, `cost` = $cost, `manufacturer_id` = $man_id, `upc` = '$upc', `shipping_weight` = $sw, `country_id` = $country_id, `image_url` = '$iu' WHERE `product_id` = $pro_id;";
			$r= @mysqli_query($dbc,$q);


			if($r){#successful query
				echo '<p class="confirm">Item Successfully Updated</p>';
			} else { #unsuccessful query
				echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
				if(is_object($r))$r->free();
				mysqli_close();
				include('includes/footer.html');
				exit();
			}

		}else{#Report all the errors
			echo '<h1 class="error">ERROR!ERROR!ERROR!ERROR!</h1>
			<p class="error">The following errors occured at the form validation<br /><br />';
			foreach($errors as $msg){
				echo ' - '.$msg.'<br />';
			}
			echo "</p><p>Please check the required fields and sumbit again.</p><p>&nbsp;</p>";
		}#end if (empty($errors)) check
	}#end if($_SERVER['REQUEST_METHOD']=='POST' && $_POST_["edit"])

	#JS ValidationScript
	?>
	<script type="text/javascript" src="includes/validator.js"></script>
	<?PHP

	#get enumerated list of Coutry IDs
	$q = 'SELECT `country_id`, `country` FROM `bw1780661_enum_country`';
	$r = @mysqli_query($dbc, $q);
	$enum_country = array();
	while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC)){
		$enum_country[$row['country_id']]=$row['country'];
	}
	if(is_object($r))$r->free();#Free query result
	
	#get enumerated list of manufacturer IDs
	$q = 'SELECT `manufacturer_id`, `manufacturer_name` FROM `bw1780661_enum_manufacturer`';
	$r = @mysqli_query($dbc, $q);
	$enum_manufacturer = array();
	while ($row = @mysqli_fetch_array($r, MYSQLI_ASSOC)){
		$enum_manufacturer[$row['manufacturer_id']]=$row['manufacturer_name'];
	}	 
	if(is_object($r))$r->free();#Free query result

	$q = 'SELECT `bw1780661_entity_products`.`product_id`, `bw1780661_entity_products`.`name`, `bw1780661_entity_products`.`sku`, `bw1780661_entity_products`.`short_description`, `bw1780661_entity_products`.`long_description`, `bw1780661_entity_products`.`on_hand_qty`, `bw1780661_entity_products`.`taxable`, `bw1780661_entity_products`.`price`, `bw1780661_entity_products`.`cost`, `bw1780661_entity_products`.`manufacturer_id`, `bw1780661_enum_manufacturer`.`manufacturer_name`, `bw1780661_entity_products`.`upc`, `bw1780661_entity_products`.`shipping_weight`, `bw1780661_entity_products`.`country_id`, `bw1780661_enum_country`.`country`, `bw1780661_entity_products`.`enabled`, `bw1780661_entity_products`.`image_url` FROM { OJ `bw1780661_entity_products` LEFT OUTER JOIN `bw1780661_enum_country` ON `bw1780661_entity_products`.`country_id` = `bw1780661_enum_country`.`country_id` LEFT OUTER JOIN  `bw1780661_enum_manufacturer` ON `bw1780661_entity_products`.`manufacturer_id` = `bw1780661_enum_manufacturer`.`manufacturer_id` }, `bw1780661_entity_atribute_set` WHERE `bw1780661_entity_products`.`atribute_set_id` = `bw1780661_entity_atribute_set`.`atribute_set_id` AND `bw1780661_entity_products`.`product_id` = '.$pro_id.';';

	$r = @mysqli_query($dbc, $q);

	echo '<h1>Edit Item</h1>
	<form name="edit_form" action="admin_edit_item.php" method="POST">';
	$row = @mysqli_fetch_array($r, MYSQLI_ASSOC);
	if(is_object($r))$r->free();#Free query result
	echo '
	<p><label for="name">Name *:</label><input id="input_name" name="name" maxlength="50" size="85" type="text" required="required" value="'.htmlspecialchars($row['name']).'"><br /><label></label></p><br />
	
	<p><label for="sku">SKU *:</label><input name="sku" id="input_sku" type="text" required="required" size="55" maxlength="45" value="'.htmlspecialchars($row['sku']).'"><label></label></p><br />
	
	<p><label for="short_description">Short Description *</label><textarea name="short_description" id="input_short_description" required="required" style="resize:none" maxlength="254" rows="3" cols="85" >'.htmlspecialchars($row['short_description']).'</textarea><br /><label></label></p><br />
	
	<p><label for="long_description">Long Description *:</label><textarea name="long_description" id="input_long_description" required="required" style="resize:none" maxlength="60000" rows="7" cols="85">'.htmlspecialchars($row['long_description']).'</textarea><br /><label></label></p><br />
	
	<p><label for="on_hand_qty">On Hand Quantity *:</label><input name="on_hand_qty" id="input_on_hand_qty" pattern="^\d*$" type="text" required="required" value="'.$row['on_hand_qty'].'"><label></label></p><br />
	
	<p><label for="price">Price *:</label><input name="price" id="input_price" type="text" pattern="^(\d*(\.\d{1,2})?)$" required="required" value="'.$row['price'].'"><label></label></p><br />
	
	<p><label for="taxable">Taxable :</label><input name="taxable" type="checkbox" value="1" '.($row['taxable']?"checked":"").'></p><br />
	
	<p><label for="cost">Cost :</label><input name="cost" id="input_cost" type="text" pattern="^(\d*(\.\d{1,2})?)$" value="'.$row['cost'].'"><label></label></p><br />
	
	<p><label for="manufacturer_id">Manufacturer :</label><select name="manufacturer_id">
	
	<option value="" '.(is_null($row['manufacturer_id'])?'selected':'').'></option>';
		foreach ($enum_manufacturer as $key => $value) {
			//echo "<p>DEBUG: Key: $key Value: $value Row[id]: ".$row['manufacturer_id']."</p>";
			echo '<option value="'.$key.'" '.($row['manufacturer_id']==$key?'selected':'').'>'.$value.'</option>';
		}
	
		echo'
		</select></p><br />
	
	<p><label for="upc">UPC: </label><input name="upc" pattern="^\d*$" id="input_upc" type="text" value="'.$row['upc'].'"><label></label></p><br />
	
	<p><label for="shipping_weight">Shipping Weight :</label><input name="shipping_weight" pattern="^\d*$" type="text" value="'.$row['shipping_weight'].'"><label></label></p><br />
	
	<p><label for="image_url">Image Url :</label><input id="image_url" name="image_url" maxlength="50" size="85" type="text" value="'.htmlspecialchars($row['image_url']).'"><br /><label></label></p><br />

	<p><label for="country_id">country :</label><select name="country_id">
	<option value="" '.(is_null($row['country_id'])?'selected':'').'></option>';
		foreach ($enum_country as $key => $value) {
			//echo "<p>DEBUG: Key: $key Value: $value Row[id]: ".$row['manufacturer_id']."</p>";
			echo '<option value="'.$key.'" '.($row['country_id']==$key?'selected':'').'>'.$value.'</option>';
		}
	
		echo'
		</select></p><br />
		<p><label for="enabled">Enabled :</label><input name="enabled" type="checkbox" value="1" '.($row['enabled']?"checked":"").'></p><br />

		<input type="submit" value="Submit">
		<input type="hidden" name="edit" value="1">
		<input type="hidden" name="product_id" value="'.$pro_id.'">
	 ';
	 	
	 echo '</form>';#end edit_item form


	@mysqli_close();
	include ('includes/footer.html');

?>
