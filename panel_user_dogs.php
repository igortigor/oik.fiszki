<?php
if(!defined("MAIN_FILE")) die;

if(isset($_POST['add_dog'])){
    if(!fn_add_dog_to_db()){
        fn_show_report("Nie udało się dodać psa");
    }
}

if(isset($_POST['edit_dog_id'])){
    if(file_exists("panel_user_edit_dog.php")){include_once ("panel_user_edit_dog.php");}
    exit();
}

if(isset($_POST['edit_dog'])) {
    if(!fn_update_dog_in_db()){
        fn_show_report("Nie udało się dodać psa");
    }
}





?>
<div align="center" style='max-width: 800px; margin: 20px;'>
    <table class="standartTable">
        <tr><th>Nazwa</th><th>Hodowca</th><th>Urodzony</th><th>Potwierdzony</th><th>Dodany</th></tr>
        <?=fn_show_my_dogs()?>
    </table>
</div>

<?php
function fn_update_dog_in_db()
{
    if(!$arr_user = fn_get_user_details()){return false;}

    if(isset($_POST['dog_id']) AND is_numeric($_POST['dog_id'])){$dog_id = $_POST['dog_id'];}else{return false;}

    $preparing = 0;
    if(isset($_POST['nazwa_przydomek'])){$nazwa_przydomek = trim(addslashes(stripslashes($_POST['nazwa_przydomek'])));}else{return false;}
    if(isset($_POST['rasa_id']) AND is_numeric($_POST['rasa_id'])){$rasa_id = $_POST['rasa_id'];}else{return false;}
    if(isset($_POST['color_id']) AND is_numeric($_POST['color_id'])){$color_id = $_POST['color_id'];}else{return false;}
    if(isset($_POST['data_urodzenia'])){$data_urodzenia = trim(addslashes(stripslashes($_POST['data_urodzenia'])));}else{return false;}
    if(isset($_POST['plec'])){$plec = trim(addslashes(stripslashes($_POST['plec'])));}else{return false;}
    if(isset($_POST['tatuaz_chip'])){$tatuaz_chip = trim(addslashes(stripslashes($_POST['tatuaz_chip'])));}else{return false;}
    if(isset($_POST['ojciec'])){$ojciec = trim(addslashes(stripslashes($_POST['ojciec'])));}else{return false;}
    if(isset($_POST['matka'])){$matka = trim(addslashes(stripslashes($_POST['matka'])));}else{return false;}
    if(isset($_POST['hodowca'])){$hodowca = trim(addslashes(stripslashes($_POST['hodowca'])));}else{return false;}
    if(isset($_POST['wspolwlasciciel'])){$wspolwlasciciel = trim(addslashes(stripslashes($_POST['wspolwlasciciel'])));}else{return false;}

    if(isset($_POST['rodowod'])){$rodowod = trim(addslashes(stripslashes($_POST['rodowod'])));}else{
        if(!isset($_POST['preparing'])){return false;}
        $preparing = 1;
        $rodowod = "";
    }

    if(isset($_POST['tytuly']) AND is_array($_POST['tytuly'])){$tytuly = json_encode($_POST['tytuly']);}else{$tytuly = "";}

    global $mysqli;

    $sql = "UPDATE `tb_psy`
     SET `rodowod`='$rodowod',`rodowod_preparing`='$preparing',`tytuly`='$tytuly',`nazwa_przydomek`='$nazwa_przydomek',`rasa_id`='$rasa_id',
     `color_id`='$color_id',`birthday`='$data_urodzenia',`sex`='$plec',`chip_nr`='$tatuaz_chip',`tata_name`='$ojciec',`mama_name`='$matka',
     `hodowca`='$hodowca',`coowner`='$wspolwlasciciel' WHERE `id` = '$dog_id' LIMIT 1";

    if(!$mysqli->query($sql)){fn_err_write($sql."-".$mysqli->error, $line = "no_line", $file = ""); return false;}

    return true;
}

function fn_add_dog_to_db()
{
    if(!$arr_user = fn_get_user_details()){return false;}

    $owner_id = $arr_user['id'];
    $preparing = 0;
    if(isset($_POST['nazwa_przydomek'])){$nazwa_przydomek = trim(addslashes(stripslashes($_POST['nazwa_przydomek'])));}else{return false;}
    if(isset($_POST['rasa_id']) AND is_numeric($_POST['rasa_id'])){$rasa_id = $_POST['rasa_id'];}else{return false;}
    if(isset($_POST['color_id']) AND is_numeric($_POST['color_id'])){$color_id = $_POST['color_id'];}else{return false;}
    if(isset($_POST['data_urodzenia'])){$data_urodzenia = trim(addslashes(stripslashes($_POST['data_urodzenia'])));}else{return false;}
    if(isset($_POST['plec'])){$plec = trim(addslashes(stripslashes($_POST['plec'])));}else{return false;}
    if(isset($_POST['tatuaz_chip'])){$tatuaz_chip = trim(addslashes(stripslashes($_POST['tatuaz_chip'])));}else{return false;}
    if(isset($_POST['ojciec'])){$ojciec = trim(addslashes(stripslashes($_POST['ojciec'])));}else{return false;}
    if(isset($_POST['matka'])){$matka = trim(addslashes(stripslashes($_POST['matka'])));}else{return false;}
    if(isset($_POST['hodowca'])){$hodowca = trim(addslashes(stripslashes($_POST['hodowca'])));}else{return false;}
    if(isset($_POST['wspolwlasciciel'])){$wspolwlasciciel = trim(addslashes(stripslashes($_POST['wspolwlasciciel'])));}else{return false;}

    if(isset($_POST['rodowod'])){$rodowod = trim(addslashes(stripslashes($_POST['rodowod'])));}else{
        if(!isset($_POST['preparing'])){return false;}
        $preparing = 1;
        $rodowod = "";
    }

    if(isset($_POST['tytuly']) AND is_array($_POST['tytuly'])){$tytuly = json_encode($_POST['tytuly']);}else{$tytuly = "";}

    global $mysqli;

$sql = "INSERT INTO `tb_psy` (`owner_id`,`rodowod`,`rodowod_preparing`,`tytuly`,`nazwa_przydomek`,`rasa_id`,
`color_id`,`birthday`,`sex`,`chip_nr`,`tata_name`,`mama_name`,`hodowca`,`coowner`,`reg_datetime`)
VALUES('$owner_id','$rodowod','$preparing','$tytuly','$nazwa_przydomek','$rasa_id',
'$color_id','$data_urodzenia','$plec','$tatuaz_chip','$ojciec',
'$matka','$hodowca','$wspolwlasciciel','".date("Y-m-d H:i:s")."')";

    if(!$mysqli->query($sql)){fn_err_write($sql."-".$mysqli->error, $line = "no_line", $file = ""); return false;}

    return true;
}
function fn_show_my_dogs()
{
    global $mysqli;
    if(!$arr_user = fn_get_user_details()){return "";}

    $sql = "SELECT * FROM `tb_psy` WHERE `owner_id` = '".$arr_user['id']."' ORDER BY `id` DESC";
    if($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_object()) {
            if($row->is_confirmed == 1){$td = "<td bgcolor='#7fff00'>TAK</td>";}else{$td = "<td bgcolor='#dc143c'>NIE</td>";}
            echo ("<form id=\"formRow_$row->id\" action=\"?action=dogs&sub=mydogs\" method=\"POST\">
			      	<input type=\"hidden\" name=\"edit_dog_id\" value = \"$row->id\">
                <tr onDblclick=\"submitFormId('formRow_$row->id')\">
		      <td>$row->nazwa_przydomek</td>
		      <td>$row->hodowca</td>
		      <td>$row->birthday</td>
		      $td
		      <td>$row->reg_datetime</td>
		      </tr></form>");
        }
    }else { fn_err_write("mysql_error: " . $mysqli->error . "($sql)", __LINE__, __FILE__); }
    return "";
}
?>