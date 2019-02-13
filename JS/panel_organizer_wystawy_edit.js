
function is_public_toggle()
{
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
   document.getElementById("submitBtnDiv").hidden = false;
}

function activate_inputssss(el)
{
	//document.getElementById("showCity").readonly = false;
	document.getElementById(el.id).removeAttribute('readonly');
	window.getSelection().empty();
}

function activate_edit_form()
{
	var arrIdToEdit = ["showName", "orgInfo", "remarks", "adres"];
	
	arrIdToEdit.forEach(readonly_clear);
	document.getElementById("submitBtnDiv").hidden = false;
	document.getElementById("flagaFormActive").value = "1";
	
	document.getElementById("showDate").style.borderColor = "red";
	document.getElementById("enterToDate").style.borderColor = "red";
	document.getElementById("cancelToDate").style.borderColor = "red";
	document.getElementById("schangeClassToDate").style.borderColor = "red";
	
	document.getElementById("rankSelect").disabled = false;
	document.getElementById("rankSelect").style.borderColor = "red";
	
	document.getElementById("delBtnDiv").hidden = true;
	
	
	document.getElementById("afterSaveBlock").hidden = true;
}

function readonly_clear(item, index)
{
  document.getElementById(item).readOnly = false;
  document.getElementById(item).style.bgColor = "red";


}

function submitShowForm()
{
	var form = document.getElementById("editShowForm");
	
	if (form.checkValidity() === true) {
		if(document.getElementById("showCityID").value != 0 || document.getElementById("flagaFormActive").value == 0){
			form.submit();
		}else{document.getElementById("trCity").style.border = "dashed red";}
		
	}
}

function deleteShowActivate()
{
	document.getElementById("delBtnDiv").hidden = true;
	document.getElementById("headText").hidden = true;
	document.getElementById("ConfDelBtnDiv").hidden = false;
	document.getElementById("headTextNapewno").hidden = false;
	
}

function submitFormID(form_id)
{
	console.log(form_id);
	document.getElementById(form_id).submit();	
}

function submitAddPriceForm()
{
	if(isNaN(document.getElementById("priceNew").value)){
		document.getElementById("priceNew").style.borderColor = "red";
	}else{
		document.getElementById("addPriceForm").submit();
	}
}

function deleteOnePrice(klasa_id)
{
	document.getElementById("del_klasa_id").value = klasa_id;
	document.getElementById("delPriceForm").submit();
}