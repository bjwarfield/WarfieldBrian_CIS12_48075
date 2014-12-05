//Shopping carp scripts
function toMoney (money){//takes a number a returns a string in USD format ie: "$10,001.50"
	return Intl.NumberFormat("en-US",{ style: "currency", currency: "USD" }).format(money);
}//endFunction

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

function eraseCookie(name) {
	//call create cookie with blank value and negative expiry
	createCookie(name,"",-1);
}

//Displays shopping cart content on the userbar
function updateCart(){
	//get current cookie data
	var cartCookie = JSON.parse(getCookie('cart'));
	if(!cartCookie){
		return false;//exit if no cart items exists
	}

	//initialize vatiables
	var newList = '';//list items to be added
	var orderQty =0;//total items in cart
	var orderTotal =0; //grant total of prices

	//create dropdown menu items
	for (var item in cartCookie){
		newList += "<li><a href='view_product.php?product_id="+item+"'>"+cartCookie[item].pname+"<br/><small>Qty:"+cartCookie[item].qty+" Price:"+toMoney(cartCookie[item].price*cartCookie[item].qty)+"</small></a></li>";
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

	//get current cookie data
	var cartCookie = JSON.parse(getCookie('cart'));
	if(!cartCookie){
		cartCookie = {};
	}

	if(cartCookie[data.pid]){
		if(cartCookie[data.pid].qty<data.pmq){ 
			cartCookie[data.pid].qty++;
		}
		else {
			alert("No more Stock of this item.");return false;
		}
	}else{
		cartCookie[data.pid]={'qty':1, 'pname':data.pn, "price":data.pp};
	}
	// console.log(JSON.stringify(cartCookie));

	createCookie("cart",JSON.stringify(cartCookie));
	updateCart();	
	return true;
}

//check for shopping cart info in cookie on page load
window.onload = updateCart;
