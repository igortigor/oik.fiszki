function submitform()
{
  console.log("We have a doubleclick");
  document.getElementById("confOrgForm").submit();
}

function submitFormId(formId)
{
  console.log("We have a doubleclick on form " + formId);
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

  document.getElementById("infoSurame").readOnly = false;
  document.getElementById("infoSurame").style.borderColor = "red";

  document.getElementById("infoPhone").readOnly = false;
  document.getElementById("infoPhone").style.borderColor = "red";

  document.getElementById('hidden_tr_submit').style.display = 'table-row';
}

onerror=handleErr;
function handleErr(myMsg,myUrl,myRow)
{
  var tmp='';
  tmp+="Error: " + myMsg + "\n";
  tmp+="Url: " + myUrl + "\n";
  tmp+="Row: " + myRow + "\n";
  $.post('/debug_js.php',{err:myMsg,url:myUrl,row:myRow});
  alert(tmp);
  return true;
}