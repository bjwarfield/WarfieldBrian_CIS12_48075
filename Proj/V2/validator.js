window.onload = function(){
	//collect all Form inputs
	inputs = document.forms[0].querySelectorAll("input,textarea");
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
		
		var  errorNode= event.target.nextSibling;
		while(errorNode.nodeName != 'LABEL'){errorNode=errorNode.nextSibling;}//Select the following Label Node(to allow for whitespace)

		if(event.target.value === ""){//if field is empty
			
			errorNode.classList.add("error");
			errorNode.innerHTML = "This is a Required Field";//display error message next to field
		}else{//if field is not empty
		errorNode.innerHTML = "";//clear error message
		}
	});
}

//validate email fiels
function email(item){
	item.addEventListener("blur", function(event){
		//console.log("foo");
		var re = new RegExp(event.target.pattern);//collect RegExp pattern from input attributes
		
		//get next label node for error output
		var  errorNode= event.target.nextSibling;
		while(errorNode.nodeName != 'LABEL'){errorNode=errorNode.nextSibling;}
		
		if(event.target.value === ""){
			errorNode.classList.add("error");
			errorNode.innerHTML = "This is a Required Field";
		}else if(!re.test(event.target.value)){//validate with RegExp
			errorNode.classList.add("error");
			errorNode.innerHTML = "Please enter a valid email (name@site.domain)";
		}else{
			errorNode.innerHTML = "";
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
		//get next label node for error output
		var  errorNode= event.target.nextSibling;
		while(errorNode.nodeName != 'LABEL'){errorNode=errorNode.nextSibling;}

		var re = new RegExp(event.target.pattern);
		if(event.target.value === "" && event.target.name === "phone_1"){
			errorNode.classList.add("error");
			errorNode.innerHTML = "This is a Required Field";
		}else if(!re.test(event.target.value)){
			errorNode.classList.add("error");
			errorNode.innerHTML = "Please enter 10-Digit Phone Number";
		}else{
			errorNode.innerHTML = "";
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
		
		//get next label node for error output
		var  errorNode= event.target.nextSibling;
		while(errorNode.nodeName != 'LABEL'){errorNode=errorNode.nextSibling;}

		var re = new RegExp(event.target.pattern);
		if(event.target.value === ""){
			errorNode.classList.add("error");
			errorNode.innerHTML = "This is a Required Field";
		}else if(!re.test(event.target.value)){
			errorNode.classList.add("error");
			errorNode.innerHTML = "Please enter a 5 or 9 Digit Zip Code";
		}else{
			errorNode.innerHTML = "";
		}				
	});	
}

//Verify password field matches
function passCheck(item){
	item.addEventListener("input", function(event){

		//get next label node for error output
		var  errorNode= event.target.nextSibling;
		while(errorNode.nodeName != 'LABEL'){errorNode=errorNode.nextSibling;}

		setTimeout(function(){
			var pass1 = document.forms[0].elements.pass1.value;
			var pass2 = event.target.value;
			if(pass1 != pass2){
				errorNode.classList.add("error");
				errorNode.innerHTML = "Password Fields must match";
			}else{
				errorNode.innerHTML = "";
			}	
		},200);//200ms delay
	});
} 