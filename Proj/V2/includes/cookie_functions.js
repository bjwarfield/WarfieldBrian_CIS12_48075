//create cookie function
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

function readCookie(name) {
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