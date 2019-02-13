window.onload = function() {
    activateButtons();
};

function activateButtons()
{

    if(document.getElementById("inputRasa").value.length != 0)
    {
        document.getElementById("submitLista").disabled = false;

        if(document.getElementById("inputColor").value.length != 0)
        {
            document.getElementById("submitAdd").disabled = false;
        }
    }
}

function allowSubmit()
{
	
}