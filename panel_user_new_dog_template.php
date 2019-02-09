<?php
if(!defined("MAIN_FILE")) die;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>System rejestracji zgłoszeń na Wystawy Psów Rasowych w Polsce</title>
    <link href="/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/libs/jQuery/jquery-1.5.min.js"></script>
    <script type="text/javascript" src="/libs/jQuery/jquery-ui-1.8.11.custom.min.js"></script>
    <script src="/libs/jQuery/cookies_baner_PL.js" type="text/javascript"></script>
    <script language="JavaScript" src="/libs/tigra_calendar/calendar_pl.js"></script>
    <link rel="stylesheet" href="/libs/tigra_calendar/calendar.css">
    <link rel="shortcut icon" href="/images/icon.png" />
    <script language="JavaScript">

        onerror=handleErr;
        function handleErr(msg,url,l)
        {
            var tmp='';
            tmp+="Blad: " + msg + "\n";
            tmp+="Adres: " + url + "\n";
            tmp+="Linia: " + l + "\n";
            $.post('/debug_js.php',{blad:msg,adres:url,linia:l});
            //alert(tmp);
            return true;
        }

    </script>
</head>
<body>	<div align="center" style="min-height: 100%; position: relative; height: 100%;">
    <center>
<script language="JavaScript">

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

        </script>
        <form action="/psy_dodaj.php" method="post" name="form" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="2500000"/>
            <table>
                <tr class="dzial">
                    <td width="25"></td>
                    <td width="850">Rejestracja nowego psa</td>
                    <td width="25"></td>
                </tr>
                <tr class="dzial_odstep">
                    <td colspan="3"></td>
                </tr>
            </table>
            <table>
                <tr class="tabela_formularz">
                    <td width="25"></td>
                    <td width="200"></td>
                    <td width="30"></td>
                    <td width="620" class="tabela_potwierdzenie">
                        <div style="color: #FF0000;"><b>UWAGA !</b></div>
                        <div style="color: #005198;">Prosimy o uważne, dokładne i zgodne z rodowodem wypełnienie formularza.</div>
                        <br />
                        <div style="color: #FF0000;"><b>Odpowiedzialność za prawdziwość podanych informacji ponosi właściciel psa.</b></div>
                        <br />
                    </td>
                    <td width="25"></td>
                </tr>
                <tr class="linia"><td></td><td colspan="3" class="linia"></td><td></td></tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Pełny numer rodowodu<br />PKR lub KW<br /><span class="tabela_przypis">(np. PKR.II-12345)</span></td>
                    <td></td>
                    <td><input name="rodowod" class="tabela_formularz" value="" maxlength="35" onchange="numer_rodowodu(this);"></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right" valign="top">Rodowód w przygotowaniu<br />lub nostryfikacji</td>
                    <td></td>
                    <td width="620"><label><input type="checkbox" id="rodowod_przygotowanie" name="rodowod_przygotowanie" value="T" style="float: left;"><span style="display: block; padding-left: 20px;">
		Należy zaznaczyć jeśli rodowód jest w przygotowaniu lub nostryfikacji, pod warunkiem, że pies jest zarejestrowany w oddziale ZKwP.
		<br />
		Jeśli rodowód jest złożony do nostryfikacji, w polu „Pełny numer rodowodu” należy wpisać:  PKR.W NOSTR.<br />i w nawiasie podać numer rodowodu eksportowego np. PKR.W NOSTR. (RKF 1234567)</span>
                        </label></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Rejestracja oddziałowa<br /><span class="tabela_przypis">(np. 00000/XXII/00)</span></td>
                    <td></td>
                    <td><input name="rejestracja_oddzialowa" class="tabela_formularz" value="" maxlength="30"></td>
                    <td></td>
                </tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td width="620"><b>Numer rejestracyjny w oddziale ZKwP jest bezwzględnie wymagany dla wszystkich psów będących w posiadaniu członków ZKwP.</b><br /></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Tytuły</td>
                    <td></td>
                    <td><input name="tytuly" class="tabela_formularz" style="width: 550px;" value="" maxlength="250" onchange="tytuly_popraw(this);"></td>
                    <td></td>
                </tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td width="620">Należy podać <b>TYLKO</b> tytuły zgodnie z Regulaminem Wystaw ZKwP: Ch.PL, Mł.Ch.PL, Ch.Pl.Wet. (lub innego kraju), CIB, CIE, Mł.Zw.Św., Zw.Św., Mł.Zw.EU, Zw.EU, Mł.Zw.PL, Zw.PL (lub innego kraju), Mł.Zw.KL, Zw.KL oraz wyszkolenie, np.: IPO-I, PT, KT-I, FT-II <b>- innych tytułów i wyróżnień nie należy umieszczać.</b></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Nazwa i przydomek hodowlany</td>
                    <td></td>
                    <td><input name="nazwa_przydomek" class="tabela_formularz" style="width: 550px;" value="" maxlength="120"></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Rasa</td>
                    <td></td>
                    <td>
                        <input id="rasa" name="rasa" type="hidden" value=""/><input id="rasa_nazwa" readonly="readolny" value="" class="tabela_formularz_ro" style="width: 480px;"/> <img src="/images/pl_wybierz.jpg" onclick="okno_rasa();"/>
                    </td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
            </table>
            okno_umaszczenie
            <div id="grupa_umaszczen_w" style="display: none;">
                <table>
                    <tr class="tabela_formularz">
                        <td width="25"></td>
                        <td width="200" align="right">Grupa umaszczeń</td>
                        <td width="30"></td>
                        <td width="620">
                            <input id="grupa_umaszczen" name="grupa_umaszczen" type="hidden" value=""/>
                            <input id="grupa_umaszczen_nazwa" readonly="readolny" value="" class="tabela_formularz_ro" style="width: 480px;"/>
                            <img src="/images/pl_wybierz.jpg" onclick="okno_umaszczenie('grupa_umaszczen');"/>
                        </td>
                        <td width="25"></td>
                    </tr>
                    <tr class="odstep"><td colspan="5"></td></tr>
                </table>
            </div>

            <table>
                <tr class="tabela_formularz">
                    <td width="25"></td>
                    <td width="200" align="right">Umaszczenie</td>
                    <td width="30"></td>
                    <td width="620">
                        <input id="umaszczenie" name="umaszczenie" type="hidden" value=""/>
                        <input id="umaszczenie_nazwa" readonly="readolny" value="" class="tabela_formularz_ro" style="width: 480px;"/>
                        <img src="/images/pl_wybierz.jpg" onclick="okno_umaszczenie('umaszczenie');"/>
                    </td>
                    <td width="25"></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Data urodzenia<br /><span class="tabela_przypis">(np. 00-00-0000)</span></td>
                    <td></td>
                    <td><input id="data_urodzenia" name="data_urodzenia" class="tabela_formularz" value=""> <script language="JavaScript">new tcal ({'formname':'form','controlname':'data_urodzenia'});</script></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Płeć</td>
                    <td></td>
                    <td style="font-size: 11pt;">
                        <label><input name="plec" type="radio" value="P"/><b>PIES</b></label>
                        <label><input name="plec" type="radio" value="S"/><b>SUKA</b></label>
                    </td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Nr tatuażu lub chip</td>
                    <td></td>
                    <td><input name="tatuaz_chip" class="tabela_formularz" value="" maxlength="25"></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
            </table>

            <div id="uszy_ciete_w" style="display: none;">
                <table>
                    <tr class="tabela_formularz">
                        <td width="25"></td>
                        <td width="200" align="right">Uszy cięte</td>
                        <td width="30"></td>
                        <td width="620">
                            <label><input id="uszy_ciete" name="uszy_ciete" type="radio" value="T" onchange="zaswiadczenie_lekarskie_ustaw();"	onclick="zaswiadczenie_lekarskie_ustaw();"/> TAK</label>
                            <label><input name="uszy_ciete" type="radio" value="N" onchange="zaswiadczenie_lekarskie_ustaw();"	onclick="zaswiadczenie_lekarskie_ustaw();"/> NIE</label>
                        </td>
                        <td width="25"></td>
                    </tr>
                    <tr class="odstep"><td colspan="5"></td></tr>
                </table>
            </div>

            <div id="ogon_ciety_w" style="display: none;">
                <table>
                    <tr class="tabela_formularz">
                        <td width="25"></td>
                        <td width="200" align="right">Ogon cięty</td>
                        <td width="30"></td>
                        <td width="620">
                            <label><input id="ogon_ciety" name="ogon_ciety" type="radio" value="T" onchange="zaswiadczenie_lekarskie_ustaw();"	onclick="zaswiadczenie_lekarskie_ustaw();"/> TAK</label>
                            <label><input name="ogon_ciety" type="radio" value="N" onchange="zaswiadczenie_lekarskie_ustaw();"	onclick="zaswiadczenie_lekarskie_ustaw();"/> NIE</label>
                        </td>
                        <td width="25"></td>
                    </tr>
                    <tr class="odstep"><td colspan="5"></td></tr>
                </table>
            </div>
            <!--<div id="zaswiadczenie_lekarskie" style="display: none;">-->
            <div id="zaswiadczenie_lekarskie" style="display: none;">
                <table>
                    <tr class="tabela_formularz">
                        <td width="25"></td>
                        <td width="200" align="right"></td>
                        <td width="30"></td>
                        <td width="620" style="color: red;"><b>Zgodnie z uchwałą Zarządu Głównego ZKwP z dnia 29.10.2011 r., wymagane jest dołączenie kopii zaświadczenia lekarskiego potwierdzającego zabieg kopiowania uszu i/lub ogona.</b></td>
                        <td width="25"></td>
                    </tr>
                    <tr class="tabela_formularz">
                        <td></td>
                        <td align="right"><b>Zaświadczenie lekarskie</b></td>
                        <td></td>
                        <td><input name="zaswiadczenie_lekarskie" type="file"/></td>
                        <td></td>
                    </tr>
                    <tr class="tabela_formularz">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="color: #FF0000;"><b>Należy dołączyć tylko JEDEN plik w formacie JPG lub PDF i nie większy niż 1MB.</b></td>
                        <td></td>
                    </tr>
                    <tr class="odstep"><td colspan="5"></td></tr>
                </table>
            </div>


            <table>
                <tr class="tabela_formularz">
                    <td width="25"></td>
                    <td width="200" align="right">Ojciec</td>
                    <td width="30"></td>
                    <td width="620"><input name="ojciec" class="tabela_formularz" style="width: 550px;" value="" maxlength="100"></td>
                    <td width="25"></td>
                </tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td valign="top">Należy podać tylko nazwę i przydomek hodowlany – Regulamin Wystaw ZKwP.</td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Matka</td>
                    <td></td>
                    <td><input name="matka" class="tabela_formularz" style="width: 550px;" value="" maxlength="100"></td>
                    <td></td>
                </tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td valign="top">Należy podać tylko nazwę i przydomek hodowlany – Regulamin Wystaw ZKwP.</td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Hodowca - imię i nazwisko</td>
                    <td></td>
                    <td><input name="hodowca" class="tabela_formularz" style="width: 550px;" value="" maxlength="60"></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
            </table>
            <table>
                <tr class="tabela_formularz">
                    <td width="25"></td>
                    <td width="200" align="right">Hodowca - kraj</td>
                    <td width="30"></td>
                    <td width="620">
                        <input id="hodowca_kraj" name="hodowca_kraj" type="hidden" value=""/>
                        <input id="hodowca_kraj_nazwa" readonly="readolny" value="" class="tabela_formularz_ro" style="width: 480px;"/>
                        <img src="/images/pl_wybierz.jpg" onclick="okno_kraj('hodowca_kraj');"/>
                    </td>
                    <td width="25"></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
            </table>
            <table>
                <tr class="odstep"><td width="900" colspan="5"></td></tr>
            </table>
            <table>
                <tr class="tabela_formularz">
                    <td width="25"></td>
                    <td width="200" align="right">Właściciel - imię i nazwisko</td>
                    <td width="30"></td>
                    <td width="620"><input class="tabela_formularz_ro" style="width: 550px;" value="Igor Andrzejewski" maxlength="100" readonly="readonly"></td>
                    <td width="25"></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Właściciel - adres</td>
                    <td></td>
                    <td><input class="tabela_formularz_ro" style="width: 550px;" value="Pilsudskiego 15, 41-902 Bytom" maxlength="100" readonly="readonly"></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right">Współwłaściciel - imię i nazwisko</td>
                    <td></td>
                    <td><input name="wspolwlasciciel" id="wspolwlasciciel" class="tabela_formularz" style="width: 550px;" value="" maxlength="100"></td>
                    <td></td>
                </tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td valign="top">Jeśli pies ma tylko jednego właściciela należy to pole pozostawić puste.</td>
                    <td></td>
                </tr>
            </table>
            <div id="rodowod_org_div" style="display: none;">
                <table>
                    <tr class="tabela_formularz">
                        <td width="25"></td>
                        <td width="200" align="right"><span style="color: red;"><b>Numer rodowodu oryginalnego</b></span></td>
                        <td width="30"></td>
                        <td width="620"><input id="rodowod_org" name="rodowod_org" class="tabela_formularz" style="border: solid 2px red;" value="" maxlength="30"></td>
                        <td width="25"></td>
                    </tr>
                    <tr></tr>
                    <td width="25"></td>
                    <td width="200"></td>
                    <td width="30"></td>
                    <td	width="620" style="font-size: 10pt;" width="850"><div style="color: #FF0000;"><b>W przypadku psów importowanych do Polski należy obowiązkowo podać pełny numer rodowodu oryginalnego np.: VDH/DWZB IW 1234</b></div></td>
                    <td width="25"></td>
                    </tr>
                    <tr class="odstep"><td colspan="5"></td></tr>
                </table>
            </div>
            <table>
                <tr class="odstep">
                    <td width="25"></td>
                    <td width="200"></td>
                    <td width="30"></td>
                    <td width="620"></td>
                    <td width="25"></td>
                </tr>
                <tr class="linia"><td width="25"></td><td width="850" colspan="3" class="linia"></td><td width="25"></td></tr>
                <tr class="dzial_odstep"><td colspan="5" width="900"></td></tr>
                <tr class="tabela_formularz">
                    <td width="25"></td>
                    <td	width="850" colspan="3" style="font-size: 10pt;">
                        <div style="color: #FF0000;"><b>UWAGA !	<span style="color: #005198;">Dotyczy wyłącznie zgłoszeń do klasy championów lub użytkowej.</span></b></div>
                        <div style="color: #005198;">Zgłoszenie psa/suki do klasy championów możliwe jest wyłącznie po dołączeniu kopii dyplomu championa krajowego lub międzynarodowego, a do klasy użytkowej, certyfikatu użytkowości FCI, zgodnie z Regulaminem Wystaw ZKwP i FCI.</div>
                    </td>
                    <td width="25"></td>
                </tr>
                <tr class="odstep"><td colspan="5" width="900"></td></tr>
                <tr class="tabela_formularz">
                    <td width="25"></td>
                    <td width="200" align="right"><b>Championat</b></td>
                    <td width="30"></td>
                    <td width="620"><input name="championat" type="file"/></td>
                    <td width="25"></td>
                </tr>
                <tr class="tabela_formularz">
                    <td width="25"></td>
                    <td></td>
                    <td></td>
                    <td style="color: #FF0000;" width="620"><b>Należy dołączyć tylko JEDEN plik w formacie JPG lub PDF i nie większy niż 1 MB, a następnie wybrać przycisk DALEJ >.</b></td>
                    <td width="25"></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right"><b>Certyfikat użytkowości</b></td>
                    <td></td>
                    <td><input name="certyfikat_uzytkowosci" type="file"/></td>
                    <td></td>
                </tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color: #FF0000;" width="620"><b>Należy dołączyć tylko JEDEN plik w formacie JPG lub PDF i nie większy niż 1 MB, a następnie wybrać przycisk DALEJ >.</b></td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="linia"><td></td><td colspan="3" class="linia"></td><td></td></tr>
                <tr class="dzial_odstep"><td colspan="3"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td colspan="3" style="font-size: 10pt;" width="850">
                        <div style="color: #FF0000;"><b>UWAGA !	<span style="color: #005198;">Dotyczy wyłącznie psów posiadających dyplom championa międzynarodowego (CIB, CIE)</span></b></div>
                        <div style="color: #005198;">Na niektórych wystawach psy/suki z zatwierdzonym tytułem championa międzynarodowego (CIB, CIE) są zwolnione z opłat lub opłaty za ich zgłoszenia są niższe. Prosimy dołączyć kopię jednego dyplomu wydanego przez FCI.</div>
                    </td>
                    <td></td>
                </tr>
                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td align="right"><b>Championat międzynarodowy</b></td>
                    <td></td>
                    <td><input name="championat_miedzynarodowy" type="file"/></td>
                    <td></td>
                </tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="color: #FF0000;" width="620"><b>Należy dołączyć tylko JEDEN plik w formacie JPG lub PDF i nie większy niż 1 MB, a następnie wybrać przycisk DALEJ >.</b></td>
                    <td></td>
                </tr>


                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="linia"><td></td><td colspan="3" class="linia"></td><td></td></tr>
                <tr class="dzial_odstep"><td colspan="3"></td></tr>
                <tr class="tabela_formularz">
                    <td></td>
                    <td colspan="3" style="font-size: 10pt;" width="850">
                        <div style="color: #FF0000;"><b>UWAGA !</b></div>
                        <div style="color: #005198;">Kopię championatu/certyfikatu użytkowości można przesłać e-mailem na adres: <a href="mailto:biuro@wystawy.net"><b>biuro@wystawy.net</b></a> lub faksem na nr <b>89-67-90-502</b><br />Po weryfikacji zostaną odnotowane w systemie i <b>dopiero wówczas będzie możliwe zgłoszenie</b> psa/suki do klasy championów lub użytkowej.</div><br />
                    </td>
                    <td></td>
                </tr>


                <tr class="odstep"><td colspan="5"></td></tr>
                <tr class="linia"><td></td><td colspan="3" class="linia"></td><td></td></tr>
                <tr class="przyciski_przed"><td colspan="5"></td></tr>
                <tr class="przyciski">
                    <td></td>
                    <td colspan="2"><a href="/psy_dodaj_potwierdzenie.php?zamknij=1"><img border="0" src="/images/pl_zamknij.jpg"></a></td>
                    <td align="right"><input type="image" name="zapisz" border="0" src="/images/pl_dalej.jpg"></td>
                    <td></td>
                </tr>
            </table>
        </form>			<div class="stopka">



            Code By <a href="http://softom.pl" target="_blank" class="stopka_link">Softom Tomasz Olencki</a></div>
    </center>
</div></body></html>