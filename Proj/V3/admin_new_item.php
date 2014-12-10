<?php 
	session_name('PHPADMINID');
	session_start();
	$page_title = 'Product Administration';
	include('includes/admin.html'); 
	include('convert_state.php');
	include('debug.php');
	@require('project_DBconnect.php');

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
			$cost = "";
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
			$upc='';
		}else{
			$upc = mysqli_real_escape_string($dbc, trim($_POST['upc']));
			if(!is_numeric($upc)){
				$errors[] = "UPC must be numeric value.";
			}
		}
		if(empty($_POST['shipping_weight'])){
			$sw='';
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
			
			#update DB record with validated values
			$q = "INSERT INTO bw1780661_entity_products  VALUES (NULL, '$name', 1, '$sku', '$sd', '$ld', '$oh_qty', $tax, $price, $cost, $man_id, '$upc', $sw, $country_id, NOW(), '$iu', $en);";
			$r= @mysqli_query($dbc,$q);

			if(mysqli_affected_rows($dbc)==1){#successful query
				echo '<p class="confirm">Item Successfully Updated</p>';
				$oid = mysqli_insert_id($dbc);
				echo '<form action="admin_edit_item.php" method="post"><input type="hidden" name="product_id" value="'.$oid .'" ><input type="submit" value="Edit Item"></form>';
				include('includes/footer.html');
				exit();

			} else { #unsuccessful query
				echo '<p class="error">The user could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message.
				echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
				include('includes/footer.html');
				exit();
			}

		}else{#Report all the errors
			echo '<div class="error"><h1>ERROR!ERROR!ERROR!ERROR!</h1>
					<p >The following errors occured at the form validation<br /><br />';
				foreach($errors as $msg){
					echo ' - '.$msg.'<br />';
				}
			echo "</p></div><p>Please check the required fields and sumbit again.</p><p>&nbsp;</p>";
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

//outout form
	echo '<h1> Create New Item</h1>
<form name="new_item" action="admin_new_item.php" method="post">
	<p><label for="name">Name *:</label><input id="input_name" name="name" maxlength="50" size="85" type="text" required="required" value="'.(isset($name)?htmlspecialchars($name):'').'"><br /><label></label></p><br />
	
	<p><label for="sku">SKU *:</label><input name="sku" id="input_sku" type="text" required="required" size="55" maxlength="45" value="'.(isset($sku)?htmlspecialchars($sku):'').'"><label></label></p><br />
	
	<p><label for="short_description">Short Description *</label><textarea name="short_description" id="input_short_description" required="required" style="resize:none" maxlength="254" rows="3" cols="85" >'.(isset($sd)?htmlspecialchars($sd):'').'</textarea><br /><label></label></p><br />
	
	<p><label for="long_description">Long Description *:</label><textarea name="long_description" id="input_long_description" required="required" style="resize:none" maxlength="60000" rows="7" cols="85">'.(isset($ld)?htmlspecialchars($ld):'').'</textarea><br /><label></label></p><br />
	
	<p><label for="on_hand_qty">On Hand Quantity *:</label><input name="on_hand_qty" id="input_on_hand_qty" type="text" pattern="^\d+$" required="required" value="'.(isset($oh_qty)?htmlspecialchars($oh_qty):'').'"><label></label></p><br />
	
	<p><label for="price">Price *:</label><input name="price" id="input_price" type="text" required="required" pattern="^(\d*(\.\d{1,2})?)$" value="'.(isset($price)?htmlspecialchars($price):'').'"><label></label></p><br />
	
	<p><label for="taxable">Taxable :</label><input name="taxable" type="checkbox" value="1" '.(isset($tax)?($tax?'selected':''):'').'></p><br />
	
	<p><label for="cost">Cost :</label><input name="cost" id="input_cost" type="text" pattern="^(\d*(\.\d{1,2})?)$" value="'.(isset($cost)?htmlspecialchars($cost):'').'"><label></label></p><br />
	
	<p><label for="manufacturer_id">Manufacturer :</label><select name="manufacturer_id">
	
	<option value="" '.(isset($man_id)?(empty($man_id)?'selected':''):'').'></option>';

		foreach ($enum_manufacturer as $key => $value) {
			echo '<option value="'.$key.'" '.(isset($man_id)?($man_id==$key?'selected':''):'').'>'.$value.'</option>';
		}
	
		echo'
		</select></p><br />
	
	<p><label for="upc">UPC: </label><input pattern="^\d+$" name="upc" id="input_upc" type="text" value="'.(isset($upc)?htmlspecialchars($upc):'').'"><label></label></p><br />
	
	<p><label for="shipping_weight">Shipping Weight :</label><input name="shipping_weight" pattern="^\d+$" type="text" value="'.(isset($sw)?htmlspecialchars($sw):'').'"><label></label></p><br />
	
	<p><label for="image_url">Image Url :</label><input id="image_url" name="image_url" maxlength="50" size="85" pattern="^([a-zA-Z\-_0-9\/\:\.%]*)$" type="text" value="'.(isset($iu)?htmlspecialchars($iu):'').'"><br /><label></label></p><br />

	<p><label for="country_id">country :</label><select name="country_id">
	<option value="" '.(isset($country_id)?(empty($country_id)?'selected':''):'').'></option>';
		foreach ($enum_country as $key => $value) {
			//echo "<p>DEBUG: Key: $key Value: $value Row[id]: ".$row['manufacturer_id']."</p>";
			echo '<option value="'.$key.'" '.(isset($country_id)?($country_id==$key?'selected':''):'').'>'.$value.'</option>';
		}
	
		echo'
		</select></p><br />
		
		<p><label for="enabled">Enabled :</label><input name="enabled" type="checkbox" value="1" '.(isset($enabled)?($enabled?'selected':''):'').'></p><br />

		<input type="submit" value="Submit">
		<input type="hidden" name="edit" value="1">
	 ';
	 	
	 echo '</form>';#end edit_item form

	 
	@mysqli_close($dbc);
	include ('includes/footer.html');

?>
