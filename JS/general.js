
function submitform()
{
  document.getElementById("confOrgForm").submit();
}

function submitFormId(formId)
{
  document.getElementById(formId).submit();
}

function showMoreOptions(tr_id)
{
  document.getElementById(tr_id).style.display = 'table-row';
}

function letEditInfo()
{
  document.getElementById("infoName").readOnly = false;
  document.getElementById("infoName").style.borderColor = "red";

  document.getElementById("infoAdres").readOnly = false;
  document.getElementById("infoAdres").style.borderColor = "red";
  
  document.getElementById("infoWeb").readOnly = false;
  document.getElementById("infoWeb").style.borderColor = "red";

  document.getElementById("infoSurame").readOnly = false;
  document.getElementById("infoSurame").style.borderColor = "red";

  document.getElementById("infoPhone").readOnly = false;
  document.getElementById("infoPhone").style.borderColor = "red";

  document.getElementById('hidden_tr_submit').style.display = 'table-row';
  
  
	 window.onkeyup = function (event) {
	  if (event.keyCode == 27) {
	    location.reload(); 
	  }
	 };
 
}

onerror=handleErr;
function handleErr(myMsg,myUrl,myRow)
{
  var tmp='';
  tmp+="Error: " + myMsg + "\n";
  tmp+="Url: " + myUrl + "\n";
  tmp+="Row: " + myRow + "\n";
  //$.post('/debug_js.php',{err:myMsg,url:myUrl,row:myRow});
  alert(tmp);
  return true;
}

function toggle_visibility(id)
{
   var e = document.getElementById(id);
   if(e.style.display == 'block')
      e.style.display = 'none';
   else
      e.style.display = 'block';
}

function toggle_hidden(id)
{
	var e = document.getElementById(id);
	e.hidden = !e.hidden;
}

function showErrMsgs()
{
	var ul = document.createElement('ul');
    ul.className = 'errListUl';

	var textnode;
	var node;
	
	Array.from(document.getElementsByClassName("errMsgInput")).forEach(el => {
		
		node = document.createElement("LI");
		textnode = document.createTextNode(el.value);
		node.appendChild(textnode);
		ul.appendChild(node);
	});
	
	document.body.appendChild(ul);
	
}