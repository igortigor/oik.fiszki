<?php
if(!defined("MAIN_FILE")) die;
if(!isset($_POST['edit_dog_id'])){ exit();}

if(!$arr_dog_details = fn_get_dog_details($_POST['edit_dog_id'])){ exit(); }
if(!$arr_user_details = fn_get_user_details_from_id($arr_dog_details['owner_id'])){ exit(); }

//$arr_dog_details['is_confirmed'] = 1;

if($arr_dog_details['is_confirmed'] == 1){$readonly_confirmed = "readonly"; $disabled_confirmed = "disabled"; $hr_comment = "Dane potwierdzone. Edycja jest wyłączona.";}else{$readonly_confirmed = ""; $disabled_confirmed = ""; $hr_comment = "Tryb edycji.";}

if($arr_dog_details['rodowod_preparing'] == 1){$rodowod_preparing_chb = "checked"; $rodowod_disabled = "disabled";}else{$rodowod_preparing_chb = ""; $rodowod_disabled = "";}
if($arr_dog_details['sex'] == "P"){$plec_p = "checked"; $plec_s = "";}else{$plec_p = ""; $plec_s = "checked";}
?>


<link rel="stylesheet" type="text/css" href="libs/chosen/chosen.min.css"/>
<link rel="stylesheet" type="text/css" href="libs/tigra_calendar/tcal.css"/>
    <script type="text/javascript" src="libs/tigra_calendar/tcal.js"></script>

<div align="center" style='max-width: 800px; margin: 20px;'>
        <form id="addDogForm" action="?action=dogs&sub=mydogs" method="post" name="form" enctype="multipart/form-data">

            <input id='dog_id' type='hidden' name='dog_id' value="<?=$arr_dog_details['id']?>">
            <input id='confirmed_flag' type='hidden' value="<?=$arr_dog_details['is_confirmed']?>">

            <table class="standartTable">
                <thead><tr>
                    <th colspan="3"><?=$hr_comment?></th>
                </tr></thead>

                <tr>
                    <td align="right">Pełny numer rodowodu<br />PKR lub KW<br /><span class="tabela_przypis">(np. PKR.II-12345)</span></td>
                    <td><input id="rodowod" name="rodowod" value="<?=$arr_dog_details['rodowod']?>" <?=$rodowod_disabled?> maxlength="35" size='35' onchange="toUpperCase(this);" required <?=$readonly_confirmed?> ></td>
                    <td><input type="checkbox" name="preparing" onchange="setPrepairing(this); allowSubmit();" <?=$rodowod_preparing_chb?> <?=$disabled_confirmed?> > W przygotowaniu</td>
                </tr>

                <tr>
                    <td align="right">Tytuły</td>
                    <td colspan="2">
                        <select name="tytuly[]" style="width:100%;" data-placeholder="Wybrać iz listy" multiple class="chosen-select" tabindex="8" <?=$disabled_confirmed?>>
                            <?=fn_select_tytuly_selected($arr_dog_details['tytuly'])?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td align="right">Nazwa i przydomek hodowlany</td>
                    <td><input name="nazwa_przydomek" value="<?=$arr_dog_details['nazwa_przydomek']?>" maxlength="35" size='35' required <?=$readonly_confirmed?> ></td>
                    <td></td>
                </tr>

                <tr>
                    <input id='inputRasaID' type='hidden' name='rasa_id' size='35' value="<?=$arr_dog_details['rasa_id']?>">

                    <td align="right">Rasa</td>
                    <td><input id='inputRasa' type='text' name='rasa_name' size='35' value="<?=fn_get_rasa_from_id($arr_dog_details['rasa_id'])?>" readonly required></td>
                    <td align="center" style="padding: 0px;"><?php if ($arr_dog_details['is_confirmed'] == 0): ?><img src="/img/list.png" onclick="window_rasy();" <?=$readonly_confirmed?> ><?php endif; ?></td>
                </tr>

                <tr>
                    <input id='inputColorID' type='hidden' name='color_id' size='35' value="<?=$arr_dog_details['color_id']?>">

                    <td align="right">Umaszczenie</td>
                    <td><input id='inputColor' onkeyup="allowSubmit()" type='text' name='color_name' size='35' value="<?=fn_get_color_from_id($arr_dog_details['color_id'])?>" readonly required></td>
                    <td align="center" style="padding: 0px;"><?php if ($arr_dog_details['is_confirmed'] == 0): ?><img src="/img/list.png" onclick="window_colors();"><?php endif; ?></td>
                </tr>

                <tr>
                    <td align="right">Data urodzenia<br /><span>(np. YYYY-MM-DD)</span></td>
                    <td><input id="data_urodzenia" name="data_urodzenia" value="<?=$arr_dog_details['birthday']?>" class="tcal" required <?=$disabled_confirmed?> ></td>
                    <td></td>
                </tr>

                <tr>
                     <td align="right">Płeć</td>
                    <td style="font-size: 11pt;">
                        <label><input name="plec" type="radio" value="P" <?=$plec_p?> required onchange="allowSubmit();" <?=$disabled_confirmed?>/><b>PIES</b></label>
                        <label><input name="plec" type="radio" value="S" <?=$plec_s?> onchange="allowSubmit();" <?=$disabled_confirmed?> /><b>SUKA</b></label>
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Nr tatuażu lub chip</td>
                    <td><input name="tatuaz_chip" value="<?=$arr_dog_details['chip_nr']?>" maxlength="35" size='35' required <?=$readonly_confirmed?> ></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Ojciec</td>
                    <td><input name="ojciec" value="<?=$arr_dog_details['tata_name']?>" maxlength="100" size='35' required <?=$readonly_confirmed?> ></td>
                    <td  style="font-size: 9pt;">Należy podać tylko nazwę<br />i przydomek hodowlany<br />(Regulamin Wystaw ZKwP)</td>
                </tr>

                <tr>
                    <td align="right">Matka</td>
                    <td><input name="matka" value="<?=$arr_dog_details['mama_name']?>" maxlength="100" size='35' required <?=$readonly_confirmed?> ></td>
                    <td  style="font-size: 9pt;">Należy podać tylko nazwę<br />i przydomek hodowlany<br />(Regulamin Wystaw ZKwP)</td>
                </tr>

                <tr>
                    <td align="right">Hodowca - imię i nazwisko</td>
                    <td><input name="hodowca" value="<?=$arr_dog_details['hodowca']?>" maxlength="100" size='35' required <?=$readonly_confirmed?> ></td>
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
                    <td><input name="wspolwlasciciel" value="<?=$arr_dog_details['coowner']?>" maxlength="100" size='35' <?=$readonly_confirmed?> ></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Data rejestracji</td>
                    <td><input value="<?=$arr_dog_details['reg_datetime']?>" maxlength="100" size='35' readonly></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td><?php if ($arr_dog_details['is_confirmed'] == 0): ?><input id="addDogSubmit" type="submit" value="Zapisz" name="edit_dog" disabled><?php endif; ?></td>
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
function fn_select_tytuly_selected($json_tytuly)
{
    global $mysqli;
    $res = "";

    if(!$arr_dog_tytuls = json_decode($json_tytuly)){$arr_dog_tytuls[]="";}
    $arr_dog_tytuls   = array_flip($arr_dog_tytuls);

    $sql = "SELECT * FROM `tb_list_tytuly` WHERE `grupa_id` = 1 ORDER BY `grupa_id`";
    if(!$result = $mysqli->query($sql)) { return $res;}

    $res .= "<optgroup label=\"Tytuły\">";

    while ($row = $result->fetch_object()) {
        if(isset($arr_dog_tytuls[$row->id])){$selected = "selected";}else{$selected = "";}
        $res .= "<option value=\"$row->id\" $selected>$row->tytulname</option>";
    }
    $res .= "</optgroup>";

    $sql = "SELECT * FROM `tb_list_tytuly` WHERE `grupa_id` = 2 ORDER BY `grupa_id`";
    if(!$result = $mysqli->query($sql)) { return $res;}

    $res .= "<optgroup label=\"Wyszkolenie\">";

    while ($row = $result->fetch_object()) {
        if(isset($arr_dog_tytuls[$row->id])){$selected = "selected";}else{$selected = "";}
        $res .= "<option value=\"$row->id\" $selected>$row->tytulname</option>";
    }
    $res .= "</optgroup>";

    return $res;
}
?>