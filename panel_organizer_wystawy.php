<div style='max-width: 800px; margin: 20px;'>
<?php
if(!defined("MAIN_FILE")) die;
if(!isset($_GET['action']) OR $_GET['action'] != "wystawy"){exit();}
if(!$arr_user_details = fn_get_user_details()){fn_show_report("Nieznany oranizator"); exit();}

if(isset($_POST['newName'])){
	if(!$_POST['show_id'] = fn_create_show($_POST['newName'], $arr_user_details['id'])){
		fn_show_report("Nie udało się stworzyć wystawę.");
		unset($_POST['show_id']);
	}
}

if (!isset($_POST['show_id'])):
//-----------------<DODAJ WYSTAWE BUTTON + FORM------------------------------------------------
?>
<div style=\"padding-left:16px;\"><img id="newWystBtn" ondblclick="toggle_visibility('newForm');" src='img/add_dodaj.png' title='Dodaj nową wystawę'></img></div>
<div id='newForm' hidden>
        <table>
        <form action="?action=wystawy" method="POST">
        <tr><td> <input placeholder='Nazwa nowej wystawy' id='newName' type='text' name='newName' size='40'> </td></tr>
        <tr><td> <input type='submit' class="button" value='   Utwórz i przejdź do edycji   '> </td></tr>
        </form>
        </table></div>
<?php
//-----------------DODAJ WYSTAWE BUTTON + FORM>------------------------------------------------
else:

if(!$arr_show_details = fn_get_row_with_id("tb_wystawy", $_POST['show_id'])){
	fn_show_report("Wystawa nie istnieje");
	exit();
}

if($arr_show_details['is_public'] == 1){$ispub_bgcolor = "green"; $ispub_text = "TAK";}else{$ispub_bgcolor = "red"; $ispub_text = "NIE";}
//id 	name 	city_id 	show_date 	enter_to_date 	cancel_to_date 	change_class_to_date 	org_id 	ogr_info 	remarks 	rank_id 	adres 	add_datetime 	arc_datetime 	is_public
//-----------------<EDYCJA WYSTAWY FORM----------------------------------------
?>
<link rel="stylesheet" type="text/css" href="libs/tigra_calendar/tcal.css"/>
    <script type="text/javascript" src="libs/tigra_calendar/tcal.js"></script>
    <script type="text/javascript" src="JS/panel_organizer_wystawy_edit.js"></script>
    
    
<table class="standartTable">
<thead><tr>
    <th colspan="3"></th>
</tr></thead>

<tr>
    <td align="right">Nazwa wystawy</td>
    <td><input id="showName" name="showname" value="<?=$arr_show_details['name']?>" maxlength="35" size='35'></td>
</tr>

<tr>
    <td align="right">Miasto</td>
    <td><input id="showCity" name="showcityId" value="<?=fn_get_city_from_id($arr_show_details['city_id'])?>" readonly></td>
</tr>

<tr>
    <td align="right">Data wystawy</td>
    <td><input class="tcal" id="showDate" name="showdate" value="<?=$arr_show_details['show_date']?>" readonly></td>
</tr>

<tr>
    <td align="right">enter_to_date</td>
    <td><input class="tcal" id="showDate" name="showdate" value="<?=$arr_show_details['enter_to_date']?>" readonly></td>
</tr>

<tr>
    <td align="right">cancel_to_date</td>
    <td><input class="tcal" id="showDate" name="showdate" value="<?=$arr_show_details['cancel_to_date']?>" readonly></td>
</tr>

<tr>
    <td align="right">change_class_to_date</td>
    <td><input class="tcal" id="showDate" name="showdate" value="<?=$arr_show_details['change_class_to_date']?>" readonly></td>
</tr>

<tr>
    <td align="right">ogr_info</td>
    <td><textarea cols="50" rows="5" readonly><?=$arr_show_details['ogr_info']?></textarea></td>
</tr>

<tr>
    <td align="right">remarks</td>
    <td><textarea cols="50" rows="5" readonly><?=$arr_show_details['remarks']?></textarea></td>
</tr>

<tr>
    <td align="right">rank_id</td>
    <td><?=$arr_show_details['rank_id']?></td>
</tr>

<tr>
    <td align="right">adres</td>
    <td><textarea cols="50" rows="5" readonly><?=$arr_show_details['adres']?></textarea></td>
</tr>

<tr>
    <td align="right">Opublikowana</td>
    <input id="is_public" type="hidden" name="is_public" value="<?=$arr_show_details['is_public']?>"/>
    <td id="isPublicTD" ondblclick="is_public_toggle();" style="background-color: <?=$ispub_bgcolor?>; color: #fff;"><?=$ispub_text?></td>
</tr>

<tr>
    <td align="right"><input class="button" value="SAVE"/></td>
    <td></td>
</tr>

</table>






<?php
//-----------------EDYCJA WYSTAWY FORM>----------------------------------------
exit();
endif;

//-------------------------<LISTA WYSTAW ORGANIZATORA-----------------------------------------------
?>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="JS/panel_organizer_wystawy.js"></script>
    

<?php



    $sql = "SELECT `W`.`id`, `W`.`name`, `M`.`name` AS `city`, `W`.`show_date`, `W`.`is_public`, `W`.`arc_datetime` FROM `tb_wystawy` as `W` LEFT JOIN `tb_list_miasta` AS `M` ON `W`.`city_id` = `M`.`id` WHERE `W`.`org_id` = '".$arr_user_details['id']."' ORDER BY `W`.`show_date`";
    if($result = $mysqli->query($sql)) {
    	
    	
        if($result->num_rows > 0){

            echo ("<table id=\"wystawyTable\" class=\"cell-border compact stripe\">
	            <thead><tr>
	            <th align='left' >ID</th>
	            <th align='left' ><input id=\"nameSearch\" placeholder=\"WYSTAWA\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"citySearch\" placeholder=\"MIASTO\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"dataSearch\" placeholder=\"DATA\" class=\"form-control\" /></th>
	            </tr></thead>
	            <tbody>");

            while ($row = $result->fetch_object()) {
                echo ("<tr ondblclick='selectShow($row->id)'><td>$row->id</td><td>$row->name</td><td>$row->city</td><td>$row->show_date</td></tr>");
            }

            echo ("</tbody>
                    <tfoot><tr> <th></th> <th></th> <th align='left'></th> <th align='left'></th> </tr></tfoot>
                    </table>");
        }else{fn_show_report("Nie ma danych");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

//--------------------WYSTAWY>-----------------------------------

function fn_create_show($newName, $org_id)
{
    global $mysqli;
    
    if(!is_numeric($org_id)){return false;}

    $sql = "INSERT INTO `tb_wystawy` (`name`,`org_id`)VALUES('".trim(addslashes(stripslashes($newName)))."', '$org_id')";
    
    echo $sql;
    
    if($mysqli->query($sql)) {
        return $mysqli->insert_id;
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return false;
}

?>
</div>