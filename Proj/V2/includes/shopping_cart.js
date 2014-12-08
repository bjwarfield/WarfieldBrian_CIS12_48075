//Shopping cart scripts


function toMoney (money){//takes a number a returns a string in USD format ie: "$10,001.50"
	return Intl.NumberFormat("en-US",{ style: "currency", currency: "USD" }).format(money);
}//endFunction

//JSON String Checker
function IsJsonString(str) {
	try {
		JSON.parse(str);
	} catch (e) {
		return false;
	}
	return true;
}

function createCookie(name,value,days) {
	var expires = "";
	//if days set, create new expiry date variable equal to value in function call
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		expires = "; expires="+date.toGMTString();
	}
	
	//write cookie
	document.cookie = name+"="+value+expires+"; path=/";
}


//return true if object is empty
function isEmpty(obj) {
	for(var key in obj) {
		if(obj.hasOwnProperty(key))
			return false;
	}
	return true;
}

//reads cookie and return its value
function getCookie(name) {
	var cname = name + "=";
	//split cookies into cookie arary
	var ca = document.cookie.split(';');
	//cycle through all cookies in array
	for(var i=0;i < ca.length;i++) {
		//create variable for current cookie
		var c = ca[i];
		//remove leading spaces
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		//if cokie name = name on function call, return substring containing cookie value
		if (c.indexOf(cname) === 0) return c.substring(cname.length,c.length);
	}
	//return null if cookie not found
	return null;
}


//delete a cookie
function eraseCookie(name) {
	//call create cookie with blank value and negative expiry
	createCookie(name,"",-1);
}

//Displays shopping cart content on the userbar
function updateCart(){
	//initialize vatiables
	var newList = '';//list items to be added
	var orderQty =0;//total items in cart
	var orderTotal =0; //grant total of prices
	var cartCookie;

	if(IsJsonString(getCookie('cart'))){//check for cookie vaidity
		//get current cookie data
		cartCookie = JSON.parse(getCookie('cart'));
	}else{
		//reset if bad cookie
		console.log("Invalid Cookie format, resetting Shopping Cart");
		createCookie('cart','');
		return;
	}
	

	if(!cartCookie || isEmpty(cartCookie)){
		
		//if no cart items exists output "Zero" data to header navbar
		document.getElementById('shopping_cart').childNodes[1].innerHTML = newList;
		document.getElementById('cart_qty').innerHTML = orderQty;
		document.getElementById('total').innerHTML = toMoney(orderTotal);
		return false;//exit 
	}

	//create dropdown menu items
	for (var item in cartCookie){
		newList += "<li><a href='view_product.php?product_id="+item+"'>"+cartCookie[item].pname+"<br/><small style='font-size:80%;'>Qty:"+cartCookie[item].qty+" Price:"+toMoney(cartCookie[item].price*cartCookie[item].qty)+"</small></a><div onclick='deleteCart("+item+")'><small style='font-size:80%;'>Delete</small></div></li>";
		orderQty+=cartCookie[item].qty;
		orderTotal+=cartCookie[item].price*cartCookie[item].qty;
	}
	//Add View Cart link at bottom of list
	newList+= "<li><a href='view_cart.php'>View Cart</a></li>";

	//output data to header navbar
	document.getElementById('shopping_cart').childNodes[1].innerHTML = newList;
	document.getElementById('cart_qty').innerHTML = orderQty;
	document.getElementById('total').innerHTML = toMoney(orderTotal);
}

//add item to shopping cart
function addCart(data) {//data { pid: "id", pn: "name", pp: "price", pmq: "oh_qty" }
	var cartCookie;
	if(IsJsonString(getCookie('cart'))){//check for cookie vaidity
		//get current cookie data
		cartCookie = JSON.parse(getCookie('cart'));
	}else{
		//reset if bad cookie
		console.log("Invalid Cookie format, resetting Shopping Cart");
		createCookie('cart','');
	}
	//get current cookie data
	if(!cartCookie){
		cartCookie = {};
	}

	//qty check
	if(cartCookie[data.pid]){
		if(cartCookie[data.pid].qty<data.pmq){ 
			cartCookie[data.pid].qty++;//increment qty id exists
		}
		else {
			alert("No more Stock of this item.");return false;//do not exceed maximum value
		}
	}else{
		cartCookie[data.pid]={'qty':1, 'pname':data.pn, "price":data.pp};//make new entery in doesnt exist
	}

	//update cookie
	createCookie("cart",JSON.stringify(cartCookie));
	//update display
	updateCart();
	//end function	
	return true;
}

function changeCart(pid, qty, pmq){
	//get current cookie data
	var cartCookie = JSON.parse(getCookie('cart'));
	if(!cartCookie && !cartCookie[pid] ){
		return false;//exit if no cart items exists
	}
	console.log(cartCookie);
	//edit the item qty value
	cartCookie[pid].qty= Number(qty);

	if(cartCookie[pid].qty<1){
		delete cartCookie[pid];//remove item if qty == 0
	}else if(cartCookie[pid].qty>pmq){//do not exceed maxumum qty
		cartCookie[pid].qty=pmq;
	}

	
	//update cookie
	createCookie("cart",JSON.stringify(cartCookie));
	//update cart display
	// updateCart();

	//refresh the page with new values
	location.reload(); 	
	return true;
}

//remove item from cart
function deleteCart(pid){

	//get current cookie data
	var cartCookie = JSON.parse(getCookie('cart'));
	if(!cartCookie && !cartCookie[pid] ){
		return false;//exit if no cart items exists
	}

	//decrement item qty
	if(cartCookie[pid].qty>0){
		cartCookie[pid].qty--;
		if(cartCookie[pid].qty===0){
			delete cartCookie[pid];//remove item if qty == 0
		}
	}
	//update cookie
	createCookie("cart",JSON.stringify(cartCookie));
	//update cart display
	updateCart();	
	return true;

}

//check for shopping cart info in cookie on page load
window.addEventListener("load", function(){
	// clear cookie on checout
	if(location.pathname.substring(location.pathname.lastIndexOf("/") + 1) ==="checkout.php"){
		eraseCookie('cart');
	}
	//update cart display
	updateCart();

});