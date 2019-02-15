<?php
if(!defined("MAIN_FILE")) die;
if(defined("SHOW_FILENAME")) fn_show_report(basename(__FILE__));
?>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="libs/chosen/chosen.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="JS/admin_dogs.js"></script>


<?php

if(isset($_GET['dog_id']) AND is_numeric($_GET['dog_id']))
{
    if(isset($_POST['confirmed_id']) AND is_numeric($_POST['confirmed_id'])){
        fn_set_confirm_id($_GET['dog_id'], $_POST['confirmed_id']);
    }

    if(!$arr_dog_details = fn_get_dog_details($_GET['dog_id'])){ exit(); }
    if(!$arr_user_details = fn_get_user_details_from_id($arr_dog_details['owner_id'])){ exit(); }

    $hr_comment = "Pies NR ".$_GET['dog_id'];

    if($arr_dog_details['is_confirmed'] == 1){
        $confirmed_div = "<div style=\"color: green;\"><b>POTWIERDZONE</b></div>";
        $selected_0 = ""; $selected_1 = "selected";
     }else{
        $confirmed_div = "<div style=\"color: red;\"><b>CZEKA NA POTWIERDZENIE</b></div>";
        $selected_0 = "selected"; $selected_1 = "";
    }
    $confirmed_select = "<div id='confirmSelect' hidden><form action=\"?action=dogs&dog_id=".$_GET['dog_id']."\" method=\"post\">
                            <select name='confirmed_id'>
                                <option value='0' $selected_0>NIE POTWIERDZONE</option>
                                <option value='1' $selected_1>POTWIERDZONE</option>
                            </select>
                            <input type='submit' value='Zmień'>
                        </form></div>";

    //tmp
    if($arr_dog_details['rodowod_preparing'] == 1){$rodowod_preparing_chb = "checked"; $rodowod_disabled = "disabled";}else{$rodowod_preparing_chb = ""; $rodowod_disabled = "";}
    if($arr_dog_details['sex'] == "P"){$plec_p = "checked"; $plec_s = "";}else{$plec_p = ""; $plec_s = "checked";}
?>

    <div align="center" style='max-width: 800px; margin: 20px;'>

            <input id='dog_id' type='hidden' name='dog_id' value="<?=$arr_dog_details['id']?>">
            <input id='confirmed_flag' type='hidden' value="<?=$arr_dog_details['is_confirmed']?>">

            <table class="standartTable">
                <thead><tr>
                    <th colspan="3"><?=$hr_comment?></th>
                </tr></thead>

                <tr>
                    <td align="right">Pełny numer rodowodu<br />PKR lub KW<br /><span class="tabela_przypis">(np. PKR.II-12345)</span></td>
                    <td><input id="rodowod" name="rodowod" value="<?=$arr_dog_details['rodowod']?>" <?=$rodowod_disabled?> maxlength="35" size='35' onchange="toUpperCase(this);" readonly ></td>
                    <td><input type="checkbox" name="preparing" <?=$rodowod_preparing_chb?> disabled > W przygotowaniu</td>
                </tr>

                <tr>
                    <?=fn_select_tytuly_selected($arr_dog_details['tytuly'])?>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Nazwa i przydomek hodowlany</td>
                    <td><input name="nazwa_przydomek" value="<?=$arr_dog_details['nazwa_przydomek']?>" maxlength="35" size='35' readonly ></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Rasa</td>
                    <td><input id='inputRasa' type='text' name='rasa_name' size='35' value="<?=fn_get_rasa_from_id($arr_dog_details['rasa_id'])?>" readonly></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Umaszczenie</td>
                    <td><input id='inputColor' onkeyup="allowSubmit()" type='text' name='color_name' size='35' value="<?=fn_get_color_from_id($arr_dog_details['color_id'])?>" readonly></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Data urodzenia<br /><span>(np. YYYY-MM-DD)</span></td>
                    <td><input id="data_urodzenia" name="data_urodzenia" value="<?=$arr_dog_details['birthday']?>" readonly></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Płeć</td>
                    <td style="font-size: 11pt;">
                        <label><input name="plec" type="radio" value="P" <?=$plec_p?> required onchange="allowSubmit();" disabled/><b>PIES</b></label>
                        <label><input name="plec" type="radio" value="S" <?=$plec_s?> onchange="allowSubmit();" disabled /><b>SUKA</b></label>
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Nr tatuażu lub chip</td>
                    <td><input name="tatuaz_chip" value="<?=$arr_dog_details['chip_nr']?>" maxlength="35" size='35' disabled ></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Ojciec</td>
                    <td><input name="ojciec" value="<?=$arr_dog_details['tata_name']?>" maxlength="100" size='35' readonly ></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Matka</td>
                    <td><input name="matka" value="<?=$arr_dog_details['mama_name']?>" maxlength="100" size='35' readonly></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Hodowca - imię i nazwisko</td>
                    <td><input name="hodowca" value="<?=$arr_dog_details['hodowca']?>" maxlength="100" size='35' required readonly ></td>
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
                    <td><input name="wspolwlasciciel" value="<?=$arr_dog_details['coowner']?>" maxlength="100" size='35' readonly ></td>
                    <td></td>
                </tr>

                <tr>
                    <td align="right">Data rejestracji</td>
                    <td><input value="<?=$arr_dog_details['reg_datetime']?>" maxlength="100" size='35' readonly></td>
                    <td></td>
                </tr>

                <tr>
                    <td><?=$confirmed_select?></td>
                    <td ondblclick="showSelect();"><?=$confirmed_div?></td>
                    <td></td>
                </tr>


            </table>

        </form>

    </div>

<?php




    exit();
}





$sql = "SELECT * FROM `tb_psy` ORDER BY `id`";
if($result = $mysqli->query($sql)) {
    if($result->num_rows > 0){

        echo ("<div style='max-width: 800px; margin: 20px;'>
                <table id=\"dogsListTable\" class=\"cell-border compact stripe\">
                <thead><tr><th>ID</th><th>RASA_ID</th><th>OWNER_ID</th><th>NAZWA</th><th>URODZONY</th><th>CHIP</th><th>HODOWCA</th><th>PŁEC</th><th>POTW.</th></tr></thead>
                <tbody>");

        while ($row = $result->fetch_object()) {
            if($row->is_confirmed == 1){$conf_val = "TAK";}else{$conf_val = "NIE";}
            echo ("<tr ondblclick='submit_show_dog($row->id);'><td>$row->id</td><td>$row->rasa_id</td><td>$row->owner_id</td><td>$row->nazwa_przydomek</td>
                                                        <td>$row->birthday</td><td>$row->chip_nr</td><td>$row->hodowca</td><td>$row->sex</td><td>$conf_val</td></tr>");
        }

        echo ("</tbody>
                    <tfoot><tr>
                    <th align='left'><input type='text' id='dog_id_col' style='width: 30px'></th>
                    <th align='left'><input type='text' id='rasa_id_col' style='width: 40px'></th>
                    <th align='left'><input type='text' id='owner_id_col' style='width: 40px'></th>
                    <th align='left'><input type='text' id='nazwa_col' style='width: 80px'></th>
                    <th align='left'><input type='text' id='birthday_col' style='width: 80px'></th>
                    <th align='left'><input type='text' id='chip_col' style='width: 50px'></th>
                    <th align='left'><input type='text' id='hodowca_col' style='width: 50px'></th>
                    <th align='left'><select id='sex_sel'><option></option><option>P</option><option>S</option></th>
                    <th align='left'><select id='confirm_sel'><option></option><option>TAK</option><option>NIE</option></th>
                    </tr></tfoot>
                    </table></div>");
    }else{fn_show_report("Nie ma danych");}
}else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

exit();

function fn_set_confirm_id($dog_id, $confirmed_id)
{
    if($confirmed_id != 0 AND $confirmed_id != 1){return false;}
    global $mysqli;
    $sql = "UPDATE `tb_psy` SET `is_confirmed` = '$confirmed_id' WHERE `id` = '$dog_id' LIMIT 1";
    if(!$mysqli->query($sql))
    {fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
}

