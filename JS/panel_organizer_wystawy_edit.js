function is_public_toggle()
{
	console.log("Here I am");
	var td = document.getElementById("isPublicTD");
	var isPubInput = document.getElementById("is_public");
	
   if(isPubInput.value == 1){
	   	isPubInput.value = 0;
	   	td.style.backgroundColor = "red";
	   	td.innerHTML = "NIE";
   }else{
   		isPubInput.value = 1;
	   	td.style.backgroundColor = "green";
	   	td.innerHTML = "TAK";
   }
}