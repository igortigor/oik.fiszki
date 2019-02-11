var okno = null;

function window_rasy(tresc)
{
    if(okno && okno.open && !okno.closed)okno.close();
    okno = window.open('list_rasy.php?show=1','Rasy','width=940,height=600,scrollbars=1');
    if(!okno || okno.height === 0 || !okno.top){window.alert('Otwarcie dodatkowego okienka nie jest możliwe. Proszę sprawdzić ustawienia przeglądarki.');return;}
    okno.focus();
}

function window_colors(show_all)
{
    var rasa_id = document.getElementById("inputRasaID");
    if(rasa_id.value.length != 0)
    {
        if(okno && okno.open && !okno.closed)okno.close();
        if(show_all === undefined){
        	okno = window.open('list_colors.php?show=1&rasa_id=' + rasa_id.value,'Umaszczenia','width=940,height=600,scrollbars=1');
        }else{//show all
        	okno = window.open('list_colors.php?rasa_id=' + rasa_id.value,'Umaszczenia','width=940,height=600,scrollbars=1');
        }
        
        if(!okno || okno.height === 0 || !okno.top){window.alert('Otwarcie dodatkowego okienka nie jest możliwe. Proszę sprawdzić ustawienia przeglądarki.');return;}
        okno.focus();
    }else{
        document.getElementById("inputRasa").style.borderColor = "red";
    }
}

function select_rasa(rasaId,rasaName)
{
    document.getElementById('inputRasaID').value=rasaId;
    document.getElementById('inputRasa').value=rasaName;
    if (typeof newDog === 'undefined'){
        document.getElementById("submitLista").disabled = false;
    }
    document.getElementById('inputColorID').value="";
    document.getElementById('inputColor').value="";

    if (typeof allowSubmit === "function") { allowSubmit(); }
    okno.close();
}

function select_color(colorId,colorName)
{
    document.getElementById('inputColorID').value=colorId;
    document.getElementById('inputColor').value=colorName;
    if (typeof newDog === 'undefined'){
        document.getElementById("submitAdd").disabled = false;
    }
    if (typeof allowSubmit() === "function") { allowSubmit(); }
    okno.close();
}

function setRasaValue(rasaId,rasaName)
{
    document.getElementById('inputRasaID').value=rasaId;
    document.getElementById('inputRasa').value=rasaName;
    document.getElementById("submitLista").disabled = false;
}

function window_cities()
{
	if(document.getElementById('flagaFormActive').value == 0){return;}
	if(okno && okno.open && !okno.closed)okno.close();
    okno = window.open('list_cities.php?show=1','Miasta','width=940,height=600,scrollbars=1');
    if(!okno || okno.height === 0 || !okno.top){window.alert('Otwarcie dodatkowego okienka nie jest możliwe. Proszę sprawdzić ustawienia przeglądarki.');return;}
    okno.focus();
}

function setCityValue(cityId,cityName)
{
    document.getElementById('showCityID').value=cityId;
    //document.getElementById('showCity').value=cityName;
    document.getElementById('showCityTD').innerHTML = cityName;

    //document.getElementById("submitLista").disabled = false;
    okno.close();
}