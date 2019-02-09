var okno = null;
var last_umaszczenie='';
function okno_umaszczenie(id)
{
    last_umaszczenie=id;
    if(okno && okno.open && !okno.closed)okno.close();
    if(id=='grupa_umaszczen')okno = window.open('grupa_umaszczen_lista.php?reset=1&rasa='+document.getElementById('rasa').value,'grupa_umaszczen','width=940,height=600,scrollbars=1');
    else okno = window.open('list_colors.php?reset=1&rasa='+document.getElementById('rasa').value,'umaszczenia','width=940,height=600,scrollbars=1');
    if(!okno || okno.height === 0 || !okno.top){window.alert('Otwarcie dodatkowego okienka nie jest możliwe. Proszę sprawdzić ustawienia przeglądarki.');return;}
    okno.focus();
}

function wybierz_umaszczenie(id,nazwa)
{
    document.getElementById(last_umaszczenie).value=id;
    document.getElementById(last_umaszczenie+'_nazwa').value=nazwa;
    okno.close();
}

function okno_rasa(tresc)
{
    if(okno && okno.open && !okno.closed)okno.close();
    okno = window.open('list_rasy.php?reset=1','rasy','width=940,height=600,scrollbars=1');
    if(!okno || okno.height === 0 || !okno.top){window.alert('Otwarcie dodatkowego okienka nie jest możliwe. Proszę sprawdzić ustawienia przeglądarki.');return;}
    okno.focus();
}

function wybierz_rase(id,nazwa,grupy,uszy_ciete,ogon_ciety)
{
    document.getElementById('rasa').value=id;
    document.getElementById('rasa_nazwa').value=nazwa;
    if(grupy=='T')document.getElementById('grupa_umaszczen_w').style.display='block';
    else document.getElementById('grupa_umaszczen_w').style.display='none';
    if(uszy_ciete=='T')document.getElementById('uszy_ciete_w').style.display='block';
    else document.getElementById('uszy_ciete_w').style.display='none';
    if(ogon_ciety=='T')document.getElementById('ogon_ciety_w').style.display='block';
    else document.getElementById('ogon_ciety_w').style.display='none';
    document.getElementById('uszy_ciete').checked=false;
    document.getElementById('ogon_ciety').checked=false;
    //zaswiadczenie_lekarskie_ustaw();
    okno.close();
}

function okno_kraj(id)
{
    last=id;
    if(okno && okno.open && !okno.closed)okno.close();
    okno = window.open('kraje_lista.php?reset=1','kraje','width=940,height=600,scrollbars=1');
    if(!okno || okno.height === 0 || !okno.top){window.alert('Otwarcie dodatkowego okienka nie jest możliwe. Proszę sprawdzić ustawienia przeglądarki.');return;}
    okno.focus();
}

function wybierz_kraj(id,nazwa)
{
    document.getElementById(last).value=id;
    document.getElementById(last+'_nazwa').value=nazwa;
    if(id!='' && id!='PL')document.getElementById('rodowod_org_div').style.display='block';
    else
    {
        document.getElementById('rodowod_org_div').style.display='none';
        document.getElementById('rodowod_org').value='';
    }
    //zaswiadczenie_lekarskie_ustaw();
}

function pokaz_plik(id)
{
    if(okno && okno.open && !okno.closed)okno.close();
    okno = window.open('psy_dodaj.php?plik='+id,'plik','width=940,height=600,scrollbars=1');
    if(!okno || okno.height === 0 || !okno.top){window.alert('Otwarcie dodatkowego okienka nie jest możliwe. Proszę sprawdzić ustawienia przeglądarki.');return;}
    okno.focus();
}

function numer_rodowodu(pole)
{
    pole.value=pole.value.toUpperCase();
}

filtr_tytuly=new Array();
filtr_tytuly.push(new Array('POLSKI','PL'));
filtr_tytuly.push(new Array('CHAMPION','Ch.'));
filtr_tytuly.push(new Array('MŁODZIEŻOWY','Mł.'));
filtr_tytuly.push(new Array('Mł. Ch. PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('NIEMIEC','D'));
filtr_tytuly.push(new Array('ZWYCIĘZCA','Zw.'));
filtr_tytuly.push(new Array('CZECH','CZ'));
filtr_tytuly.push(new Array('LITWY','LT'));
filtr_tytuly.push(new Array('ŁOTWY','LV'));
filtr_tytuly.push(new Array('ROSJI','RUS'));
filtr_tytuly.push(new Array('ESTONII','EST'));
filtr_tytuly.push(new Array('SZWECJI','S'));
filtr_tytuly.push(new Array('MŁODZ.','Mł.'));
filtr_tytuly.push(new Array('MLODZIEZOWY','Mł.'));
filtr_tytuly.push(new Array('CHPL','Ch.PL'));
filtr_tytuly.push(new Array('MŁ.CHPL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('CH.PL','Ch.PL'));
filtr_tytuly.push(new Array('MŁ.Zw.Kl.','Mł.Zw.KL'));
filtr_tytuly.push(new Array('CH PL','Ch.PL'));
filtr_tytuly.push(new Array('CZEMPION','Ch.'));
filtr_tytuly.push(new Array('MŁ CH PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('MŁ Ch.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('ML. Ch.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('CH. LT','Ch.LT'));
filtr_tytuly.push(new Array('Ch.PL.','Ch.PL'));
filtr_tytuly.push(new Array('CH. PL','Ch.PL'));
filtr_tytuly.push(new Array('MŁ. Ch.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('MŁODZIEZOWY','Mł.'));
filtr_tytuly.push(new Array('MLODZIEŻOWY','Mł.'));
filtr_tytuly.push(new Array('CHEMPION','Ch.'));
filtr_tytuly.push(new Array('MŁCh.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('CH.ML.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('ML.Ch.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('MŁ ZW PL','Mł.Zw.PL'));
filtr_tytuly.push(new Array('CH CZ','Ch.CZ'));
filtr_tytuly.push(new Array('ZWYC.','Zw.'));
filtr_tytuly.push(new Array('ML.CH','Mł.Ch.'));
filtr_tytuly.push(new Array('INTER','Int.'));
filtr_tytuly.push(new Array('ZW.PL','Zw.PL'));
filtr_tytuly.push(new Array('ZW.LV','Zw.LV'));
filtr_tytuly.push(new Array('MŁ.ZW.PL','Mł.Zw.PL'));
filtr_tytuly.push(new Array('MŁ.ZW.LV','Mł.Zw.LV'));
filtr_tytuly.push(new Array('ŚWIATA','Św.'));
filtr_tytuly.push(new Array('Mł. Zw. ŚWIATA','Mł.Zw.Św.'));
filtr_tytuly.push(new Array('Mł. Ch.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('Mł.Zw.Kl.','Mł.Zw.KL'));
filtr_tytuly.push(new Array('Zw.KL','Zw.KL'));
filtr_tytuly.push(new Array('CHRUS','Ch.RUS'));
filtr_tytuly.push(new Array('RUMUNII','ROM'));
filtr_tytuly.push(new Array('SŁOWACJI','SK'));
filtr_tytuly.push(new Array('SERBII','SRB'));
filtr_tytuly.push(new Array('AUSTRII','A'));
filtr_tytuly.push(new Array('I.CH.','Int.Ch.'));
filtr_tytuly.push(new Array('INT.','Int.'));
filtr_tytuly.push(new Array('CH.LT.','Ch.LT'));
filtr_tytuly.push(new Array('CH.RUS.','Ch.RUS'));
filtr_tytuly.push(new Array('CH.CS.','Ch.CS'));
filtr_tytuly.push(new Array('BUŁGARII','BG'));
filtr_tytuly.push(new Array('CH.ROM','Ch.ROM'));
filtr_tytuly.push(new Array('Mł.Ch.Pl','Mł.Ch.PL'));
filtr_tytuly.push(new Array('ML Ch.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('CAMPION','Ch.'));
filtr_tytuly.push(new Array('MŁ.Zw.PL','Mł.Zw.PL'));
filtr_tytuly.push(new Array('BUŁGARI','BG'));
filtr_tytuly.push(new Array('CHBG','Ch.BG'));
filtr_tytuly.push(new Array(';',','));
filtr_tytuly.push(new Array('Mł. Ch. Pl.','Mł.Ch.PL.'));
filtr_tytuly.push(new Array('CHAMP.','Ch.'));
filtr_tytuly.push(new Array('ML Ch.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('CH BG','Ch.BG'));
filtr_tytuly.push(new Array('INT CH','Int.Ch'));
filtr_tytuly.push(new Array('MŁ.CH.','Mł.Ch.'));
filtr_tytuly.push(new Array('CH.RO','Ch.RO'));
filtr_tytuly.push(new Array('MŁODZIEŻY','Mł.'));
filtr_tytuly.push(new Array('MLODZIEŻY','Mł.'));
filtr_tytuly.push(new Array('MLODZIEZY','Mł.'));
filtr_tytuly.push(new Array('MŁODZIEZY','Mł.'));
filtr_tytuly.push(new Array('ZW.','Zw.'));
filtr_tytuly.push(new Array('KLUBU','Kl.'));
filtr_tytuly.push(new Array('CH. USA','Ch.USA'));
filtr_tytuly.push(new Array('Mł.Ch.LV.','Mł.Ch.LV'));
filtr_tytuly.push(new Array('ML CH EST','Mł.Ch.EST'));
filtr_tytuly.push(new Array('MŁ.ZW.','Mł.Zw.'));
filtr_tytuly.push(new Array('ZW.KL','Zw.KL'));
filtr_tytuly.push(new Array('NIE DOTYCZT',''));
filtr_tytuly.push(new Array('Mł. Ch. PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('CH SK','Ch.SK'));
filtr_tytuly.push(new Array('BRAK',''));
filtr_tytuly.push(new Array('Ch. PL','Ch.PL'));
filtr_tytuly.push(new Array('MŁ. Zw. PL','MŁ.Zw.PL'));
filtr_tytuly.push(new Array('Ch. USA','Ch.USA'));
filtr_tytuly.push(new Array('INTCH','Int.Ch'));
filtr_tytuly.push(new Array('MŁ.Zw.KL','Mł.Zw.KL'));
filtr_tytuly.push(new Array('CH RUS','Ch.RUS'));
filtr_tytuly.push(new Array('MłChPl','Mł.Ch.PL'));
filtr_tytuly.push(new Array('J Ch Belarus','J.Ch.BLR'));
filtr_tytuly.push(new Array('J Ch Breed','J.Ch.Breed'));
filtr_tytuly.push(new Array('J Grand Ch Belarus','J.Grand Ch.BLR'));
filtr_tytuly.push(new Array('J Ch.RUS','J.Ch.RUS'));
filtr_tytuly.push(new Array('J Ch.LT','J.Ch.LT'));
filtr_tytuly.push(new Array('J Ch.LV','J.Ch.LV'));
filtr_tytuly.push(new Array('Danish Champion','Ch.DK'));
filtr_tytuly.push(new Array('International Champion','Int.Ch.'));
filtr_tytuly.push(new Array('Młodzieżowy Champion Polski','Mł.Ch.PL'));
filtr_tytuly.push(new Array('Młodzieżowy Zwycięzca Klubu','Mł.Zw.KL'));
filtr_tytuly.push(new Array('CH UA','Ch.UA'));
filtr_tytuly.push(new Array('Ch LV','Ch.LV'));
filtr_tytuly.push(new Array('CH LT','Ch.LT'));
filtr_tytuly.push(new Array('CH LTU','Ch.LT'));
filtr_tytuly.push(new Array('Ch EE','Ch.EE'));
filtr_tytuly.push(new Array('MŁ.Ch.PL','Mł.Ch.PL'));
filtr_tytuly.push(new Array('Ch. CZ','Ch.CZ'));
filtr_tytuly.push(new Array('Ch. SK','Ch.SK'));
filtr_tytuly.push(new Array('JCh. CZ','J.Ch.CZ'));
filtr_tytuly.push(new Array('JCh. SK','J.Ch.SK'));
filtr_tytuly.push(new Array('DK CH','Ch.DK'));
filtr_tytuly.push(new Array('LT CH','Ch.LT'));
filtr_tytuly.push(new Array('LV CH','Ch.LV'));
filtr_tytuly.push(new Array('EE CH','Ch.EE'));
filtr_tytuly.push(new Array('BALT CH','BALT Ch.'));
filtr_tytuly.push(new Array('VDH CH','Ch.VDH'));
filtr_tytuly.push(new Array('D CH','Ch.D'));
filtr_tytuly.push(new Array('LU CH','Ch.LUX'));
filtr_tytuly.push(new Array('Mł.Zw.PL.','Mł.Zw.PL'));
filtr_tytuly.push(new Array('Mł,Zw.pl','Mł.Zw.PL'));
filtr_tytuly.push(new Array('Ch. Pl.','Ch.PL'));
filtr_tytuly.push(new Array('Młodziezowy Champion Polski','Mł.Ch.PL'));
filtr_tytuly.push(new Array('Ch.PLMł.','Mł.Ch.PL'));
filtr_tytuly.push(new Array('CH. RUS','Ch.RUS'));
filtr_tytuly.push(new Array('Ch.Pl','Ch.PL'));
filtr_tytuly.push(new Array('CH','Ch.'));
filtr_tytuly.push(new Array('Champion Polski','Ch.PL'));


function tytuly_popraw(pole)
{
    return;
    for(i=0;i<filtr_tytuly.length;i++)
        if(pole.value.indexOf(filtr_tytuly[i][0])>=0)
            pole.value=pole.value.replace(filtr_tytuly[i][0],filtr_tytuly[i][1]);
}

function zaswiadczenie_lekarskie_ustaw()
{
    return;
    if(document.getElementById('data_urodzenia').value.split('-').reverse().join('-')>='2012-01-01' && document.getElementById('hodowca_kraj').value=='PL' && (document.getElementById('uszy_ciete_w').style.display=='block' || document.getElementById('ogon_ciety_w').style.display=='block'))
    {
        if((document.getElementById('uszy_ciete') && document.getElementById('uszy_ciete').checked) || (document.getElementById('ogon_ciety') && document.getElementById('ogon_ciety').checked)) document.getElementById('zaswiadczenie_lekarskie').style.display='block';
        else document.getElementById('zaswiadczenie_lekarskie').style.display='none';
    }
    else document.getElementById('zaswiadczenie_lekarskie').style.display='none';
}

$(document).ready(function(){
    $('input[name="rodowod"]').focus().select();
});