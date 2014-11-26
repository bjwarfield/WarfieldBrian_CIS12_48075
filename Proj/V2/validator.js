window.onload = function(){
	//collect all Form inputs
	inputs = document.forms[0].getElementsByTagName("input");
	// console.log(inputs);

	//loop through collected input fields
	for (var i in inputs){
		
		//assign validators for required fields
		if(inputs[i].required){
			required(inputs[i]);
		}
		//assign validators for email field
		if(inputs[i].name === "email"){
			email(inputs[i]);
		}

		//assign validators for phone numbers
		if(inputs[i].name === "phone_1" || inputs[i].name === "phone_2"){
			phoneMask(inputs[i]);
		}

		//assign validators for zip code
		if (inputs[i].name === "zip_code" ){
			zipMask(inputs[i]);
		}
		if (inputs[i].name === "pass2" ){
			passCheck(inputs[i]);
		}	}
};

//validate required fields
function required(item){
	item.addEventListener("blur", function(event){//on field blur event
		//console.log(event);
		if(event.target.value === ""){//if field is empty
			event.target.nextSibling.classList.add("error");
			event.target.nextSibling.innerHTML = "This is a Required Field";//display error message next to field
			document.forms[0].submit.disabled = 1;//disable submit button
		}else{//if field is not empty
		event.target.nextSibling.innerHTML = "";//clear error message
		document.forms[0].submit.disabled = 0;//enable submit
		}
	});
}

//validate email fiels
function email(item){
	item.addEventListener("blur", function(event){
		//console.log("foo");
		var re = new RegExp(event.target.pattern);//collect RegExp pattern from input attributes
		if(event.target.value === ""){
			event.target.nextSibling.classList.add("error");
			event.target.nextSibling.innerHTML = "This is a Required Field";
			document.forms[0].submit.disabled = 1;
		}else if(!re.test(event.target.value)){//validate with RegExp
			event.target.nextSibling.classList.add("error");
			event.target.nextSibling.innerHTML = "Please enter a valid email (name@site.domain)";
			document.forms[0].submit.disabled = 1;
		}else{
			event.target.nextSibling.innerHTML = "";
			document.forms[0].submit.disabled = 0;
		}				
	});	
}

//mask and validate phone fields
function phoneMask(item){
	item.addEventListener("input", function(event){
		//console.log("foo");
		setTimeout(function(){
			var p_value = (event.target.value.replace(/[^\d]/g, ''));//strip non-digit fields
			if(p_value.length === 0 ){
				event.target.value = "";
			}else if(p_value.length > 0 && p_value.length <= 3){
				event.target.value = "("+p_value.substring(0,3);
			}else if(p_value.length > 3 && p_value.length <= 6){
				event.target.value = "("+p_value.substring(0,3)+")"+p_value.substring(3,6);
			}else{
				event.target.value = "("+p_value.substring(0,3)+")"+p_value.substring(3,6)+"-"+p_value.substring(6,10);
			}
		},75);//75ms delay
	});
	item.addEventListener("blur", function(event){
		//console.log("foo");
		var re = new RegExp(event.target.pattern);
		if(event.target.value === "" && event.target.name === "phone_1"){
			event.target.nextSibling.classList.add("error");
			event.target.nextSibling.innerHTML = "This is a Required Field";
			document.forms[0].submit.disabled = 1;
		}else if(!re.test(event.target.value)){
			event.target.nextSibling.classList.add("error");
			event.target.nextSibling.innerHTML = "Please enter 10-Digit Phone Number";
			document.forms[0].submit.disabled = 1;
		}else{
			document.forms[0].submit.disabled = 0;
			event.target.nextSibling.innerHTML = "";
		}				
	});	
} 
function zipMask(item){
	item.addEventListener("input", function(event){
		//console.log("foo");
		setTimeout(function(){
			var z_value = (event.target.value.replace(/[^\d]/g, ''));
			if(z_value.length === 0 ){
				event.target.value = "";
			}else if(z_value.length > 0 && z_value.length <= 5){
				event.target.value = z_value.substring(0,5);
			}else{
				event.target.value = z_value.substring(0,5)+"-"+z_value.substring(5,9);
			}
		},75);
	});
	item.addEventListener("blur", function(event){
		//console.log("foo");
		var re = new RegExp(event.target.pattern);
		if(event.target.value === ""){
			event.target.nextSibling.classList.add("error");
			event.target.nextSibling.innerHTML = "This is a Required Field";
			document.forms[0].submit.disabled = 1;
		}else if(!re.test(event.target.value)){
			event.target.nextSibling.classList.add("error");
			event.target.nextSibling.innerHTML = "Please enter a 5 or 9 Digit Zip Code";
			document.forms[0].submit.disabled = 1;
		}else{
			document.forms[0].submit.disabled = 0;
			event.target.nextSibling.innerHTML = "";
		}				
	});	
}

//Verify password field matches
function passCheck(item){
	item.addEventListener("input", function(event){
		setTimeout(function(){
			var pass1 = document.forms[0].elements.pass1.value;
			var pass2 = event.target.value;
			if(pass1 != pass2){
				event.target.nextSibling.classList.add("error");
				event.target.nextSibling.innerHTML = "Password Fields must match";
				document.forms[0].submit.disabled = 1;
			}else{
				document.forms[0].submit.disabled = 0;
				event.target.nextSibling.innerHTML = "";
			}	
		},200);//200ms delay
	});
} 