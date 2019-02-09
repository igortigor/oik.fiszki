<?php
if(!defined("MAIN_FILE")) die;
if(!$arr_user_details = fn_get_user_details() OR empty($arr_user_details['name']) OR empty($arr_user_details['surname'])){
?>
<div align="center" style='max-width: 800px; margin: 20px; color: red;'>
    Proszę najpierw wprowadzić Imie i Nazwisko do systemu w zakładce "Dane".
</div>

<?php
exit();
}

if(isset($_POST['add_dog'])){
fn_show_report("Trying to add a dog");
}
?>


<link rel="stylesheet" type="text/css" href="libs/chosen/chosen.min.css"/>
<link rel="stylesheet" type="text/css" href="libs/tigra_calendar/tcal.css"/>
    <script type="text/javascript" src="libs/tigra_calendar/tcal.js"></script>

<div align="center" style='max-width: 800px; margin: 20px;'>
        <form id="addDogForm" action="?action=dogs&sub=mydogs" method="post" name="form" enctype="multipart/form-data">
            <table class="standartTable">
                <thead><tr>
                    <th colspan="3">Rejestracja nowego psa</th>
                </tr></thead>

                <tr>
                    <td align="right">Pełny numer rodowodu<br />PKR lub KW<br /><span class="tabela_przypis">(np. PKR.II-12345)</span></td>
                    <td><input id="rodowod" name="rodowod" value="" maxlength="35" size='35' onchange="toUpperCase(this);" required></td>
                    <td><input type="checkbox" name="preparing" onchange="setPrepairing(this); allowSubmit();"> W przygotowaniu</td>
                </tr>

                <tr>
                    <td align="right">Tytuły</td>
                    <td colspan="2">
                        <select name="tytuly[]" style="width:100%;" data-placeholder="Wybrać iz listy" multiple class="chosen-select" tabindex="8">
                            <?=fn_select_tytuly()?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td align="right">Nazwa i przydomek hodowlany</td>
                    <td><input name="nazwa_przydomek" value="" maxlength="35" size='35' required></td>
                    <td></td>
                </tr>

                <tr>
                    <input id='inputRasaID' type='hidden' name='rasa_id' size='35'>

                    <td align="right">Rasa</td>
                    <td><input id='inputRasa' type='text' name='rasa_name' size='35' readonly required></td>
                    <td align="center" style="padding: 0px;"><img src="/img/list.png" onclick="window_rasy();"></td>
                </tr>

                <tr>
                    <input id='inputColorID' type='hidden' name='color_id' size='35'>

                    <td align="right">Umaszczenie</td>
                    <td><input id='inputColor' onkeyup="allowSubmit()" type='text' name='color_name' size='35' readonly required></td>
                    <td align="center" style="padding: 0px;"><img src="/img/list.png" onclick="window_colors();"></td>
                </tr>

                <tr>
                    <td align="right">Data urodzenia<br /><span>(np. YYYY-MM-DD)</span></td>
                    <td><input id="data_urodzenia" name="data_urodzenia" value="" class="tcal" required></td>
                    <td></td>
                </tr>

                <tr>
                     <td align="right">Płeć</td>
                    <td style="font-size: 11pt;">
                        <label><input name="plec" type="radio" value="P" required onchange="allowSubmit();"/><b>PIES</b></label>
                        <label><input name="plec" type="radio" value="S" onchange="allowSubmit();"/><b>SUKA</b></label>
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Nr tatuażu lub chip</td>
                    <td><input name="tatuaz_chip" value="" maxlength="35" size='35' required></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Ojciec</td>
                    <td><input name="ojciec" value="" maxlength="100" size='35' required></td>
                    <td  style="font-size: 9pt;">Należy podać tylko nazwę<br />i przydomek hodowlany<br />(Regulamin Wystaw ZKwP)</td>
                </tr>

                <tr>
                    <td align="right">Matka</td>
                    <td><input name="matka" value="" maxlength="100" size='35' required></td>
                    <td  style="font-size: 9pt;">Należy podać tylko nazwę<br />i przydomek hodowlany<br />(Regulamin Wystaw ZKwP)</td>
                </tr>

                <tr>
                    <td align="right">Hodowca - imię i nazwisko</td>
                    <td><input name="hodowca" value="" maxlength="100" size='35' required></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Właściciel - imię i nazwisko</td>
                    <td><input value="<?=$arr_user_details['name']." ".$arr_user_details['surname']?>" maxlength="100" size='35' readonly></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Właściciel - adres</td>
                    <td><input value="<?=$arr_user_details['adres']?>" maxlength="100" size='35' readonly></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Współwłaściciel - imię i nazwisko</td>
                    <td><input name="wspolwlasciciel" value="" maxlength="100" size='35'></td>
                    <td  style="font-size: 9pt;">Jeśli pies ma tylko jednego<br />właściciela należy to pole<br />pozostawić puste.</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td><input id="addDogSubmit" type="submit" value="Zapisz" name="add_dog" disabled></td>
                </tr>

                <tr>
                    <td colspan="3">
                        <div style="color: red;"><b>UWAGA !</b></div>
                        <div style="color: red;">Kopię certyfikatu użytkowości należy przesłać e-mailem na adres: <a href="mailto:admin@oik.fiszki.net"><b>admin@oik.fiszki.net</b></a><br />Po weryfikacji dane zostaną potwierdzone w systemie i <b>dopiero wówczas będzie możliwe zgłoszenie</b> psa/suki do klasy championów lub użytkowej. <b>Edycja będzie zablokowana.</b></div>
                    </td>
                </tr>



            </table>

        </form>

</div>


<script type="text/javascript" src="libs/DataTables/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="libs/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="JS/user_new_dog.js"></script>
<script type="text/javascript" src="JS/window_list.js"></script>




<?php
function fn_select_tytuly()
{
    global $mysqli;
    $res = "";

    $sql = "SELECT * FROM `tb_list_tytuly` WHERE `grupa_id` = 1 ORDER BY `grupa_id`";
    if(!$result = $mysqli->query($sql)) { return $res;}

    $res .= "<optgroup label=\"Tytuły\">";

    while ($row = $result->fetch_object()) {
        $res .= "<option value=\"$row->id\">$row->tytulname</option>";
    }
    $res .= "</optgroup>";

    $sql = "SELECT * FROM `tb_list_tytuly` WHERE `grupa_id` = 2 ORDER BY `grupa_id`";
    if(!$result = $mysqli->query($sql)) { return $res;}

    $res .= "<optgroup label=\"Wyszkolenie\">";

    while ($row = $result->fetch_object()) {
        $res .= "<option value=\"$row->id\">$row->tytulname</option>";
    }
    $res .= "</optgroup>";

    return $res;
}
?>