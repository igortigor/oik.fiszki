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

if(isset($_POST['update_show_id'])){
	if(!fn_update_show()){fn_show_report("Nie udało się zmienić wystawę.");}
	$_POST['show_id'] = $_POST['update_show_id'];
}

if(isset($_POST['show_id_to_delete'])){
	fn_show_report(fn_delete_show($_POST['show_id_to_delete']));
}

if(isset($_POST['priceNew']) AND isset($_POST['klasa_id']) AND isset($_POST['price_show_id'])){
	if(!fn_add_price_to_show($_POST['price_show_id'], $_POST['klasa_id'], $_POST['priceNew'])){fn_show_report("Nie udało się dodać cenę.");}
}

if(isset($_POST['price_show_id']) AND isset($_POST['del_klasa_id'])){
	if(!fn_del_price_from_show($_POST['price_show_id'], $_POST['del_klasa_id'])){fn_show_report("Nie udało się usunąć cenę.");}
}


if(isset($_POST['to_arch_show_id']) AND is_numeric($_POST['to_arch_show_id'])){
	if(!fn_move_to_arch_show($_POST['to_arch_show_id'])){fn_show_report("Nie udało się przenieść wystawę do archiwum.");}
}

if(isset($_POST['from_arch_show_id']) AND is_numeric($_POST['from_arch_show_id'])){
	if(!fn_move_from_arch_show($_POST['from_arch_show_id'])){fn_show_report("Nie udało się przenieść wystawę Z archiwum.");}
}

if(isset($_POST['users_show_id']) AND is_numeric($_POST['users_show_id'])){
	if(fn_show_users_from_show($_POST['users_show_id'])){
		exit();
	}else{fn_show_report("Nie można wybrać uczęstników.");}
}

if (isset($_POST['info_member_id']) AND file_exists("panel_organizer_member_info.php")){
	include_once("panel_organizer_member_info.php");
}



if (isset($_POST['price_show_id'])):
?>
<!-- CENY OPLAT FORMA-->
<script type="text/javascript" src="JS/panel_organizer_wystawy_edit.js"></script>

<form action="?action=wystawy" method="POST" id="delPriceForm">
<input type='hidden' name='price_show_id' value='<?=$_POST['price_show_id']?>'>
<input type='hidden' id='del_klasa_id' name='del_klasa_id'>
</form>

<table class="standartTable">

<form action="?action=wystawy" method="POST" id="addPriceForm">
<thead><tr>
		<input type='hidden' name='price_show_id' value='<?=$_POST['price_show_id']?>'>
		<th><?=fn_get_klasy_select()?></th>
		<th> <input placeholder='Cena' id="priceNew" type='text' name='priceNew' size='40'> </th>
		<th style="padding: 0px; text-align: center; height: 58px; width: 280px"><input class="button" value="DODAJ" onclick="submitAddPriceForm();"/></th>
</tr></thead>
</form>

<form action="?action=wystawy" method="POST" id="addPriceForm">
<?=fn_get_price_rows($_POST['price_show_id'])?>
</form>

</table>
<?php
exit();
endif;









if (!isset($_POST['show_id'])):
//-----------------<DODAJ WYSTAWE BUTTON + FORM------------------------------------------------
?>
<div style="padding-left:16px;"><img id="newWystBtn" ondblclick="toggle_visibility('newForm');" src='img/add_dodaj.png' title='Dodaj nową wystawę'></img></div>
<div id='newForm' hidden>
    <table>
        <form action="?action=wystawy" method="POST">
        <tr><td> <input placeholder='Nazwa nowej wystawy' id='newName' type='text' name='newName' size='40'> </td><td> <input type='submit' value='Utwórz i przejdź do edycji'> </td></tr>
        </form>
    </table>
</div>
<?php
//-----------------DODAJ WYSTAWE BUTTON + FORM>------------------------------------------------
else:

if(!$arr_show_details = fn_get_row_with_id("tb_wystawy", $_POST['show_id'])){
	fn_show_report("Wystawa nie istnieje");
	exit();
}

if($arr_show_details['is_public'] == 1){$ispub_bgcolor = "green"; $ispub_text = "TAK";}else{$ispub_bgcolor = "red"; $ispub_text = "NIE";}
if($arr_show_details['arc_datetime'] == "0000-00-00 00:00:00"){$arch_form_name = "toArchForm"; $arch_icon_name = "archive_white.png"; $arch_title = "Przeniesienie do archiwum";}else{$arch_form_name = "fromArchForm"; $arch_icon_name = "from_archive_white.png";$arch_title = "Przeniesienie Z archiwum";}

//id 	name 	city_id 	show_date 	enter_to_date 	cancel_to_date 	change_class_to_date 	org_id 	ogr_info 	remarks 	rank_id 	adres 	add_datetime 	arc_datetime 	is_public
//-----------------<EDYCJA WYSTAWY FORM----------------------------------------
?>
<link rel="stylesheet" type="text/css" href="libs/tigra_calendar/tcal.css"/>
    <script type="text/javascript" src="libs/tigra_calendar/tcal.js"></script>
    <script type="text/javascript" src="JS/panel_organizer_wystawy_edit.js"></script>
    <script type="text/javascript" src="JS/window_list.js"></script>
    
    <form hidden action="?action=wystawy" method="POST" id="delShowForm"><input type="hidden" name="show_id_to_delete" value="<?=$_POST['show_id']?>"></form>
    <form hidden action="?action=wystawy" method="POST" id="toArchForm"><input type="hidden" name="to_arch_show_id" value="<?=$_POST['show_id']?>"></form>
    <form hidden action="?action=wystawy" method="POST" id="fromArchForm"><input type="hidden" name="from_arch_show_id" value="<?=$_POST['show_id']?>"></form>
    
<form action="?action=wystawy" method="POST" id="editShowForm">
<input type="hidden" name="flagaFormActive" id="flagaFormActive" value="0">
<input type="hidden" name="update_show_id" value="<?=$_POST['show_id']?>">
<table class="standartTable">
<thead><tr>
	<th style="padding: 0px; text-align: center; height: 58px; width: 280px">
	
		<div style="display:inline-block;">
			<img onclick="submitFormID('<?=$arch_form_name?>');" src='img/<?=$arch_icon_name?>' title='<?=$arch_title?>'></img>
		</div>
			
		<div id="delBtnDiv" style="padding-left:16px; display:inline-block;"><img id="delWystBtn" ondblclick="deleteShowActivate();" src='img/del-button.png' title='USUŃ WYSTAWĘ'></img></div>
		
		<div id="ConfDelBtnDiv" hidden style="padding-left:16px;"><img id="delWystBtn" onclick="submitFormID('delShowForm');" src='img/tak_red.png' title='NAPEWNO?'></img></div>
	
	</th>
    <th><div id="headText" ondblclick="activate_edit_form();">Dwukrotnie kliknij tutaj, aby edytować</div><div hidden id="headTextNapewno">??? NAPEWNO ???</div></th>
</tr></thead>

<tr>
    <td align="right">Nazwa wystawy</td>
    <td><input id="showName" name="showname" value="<?=$arr_show_details['name']?>" maxlength="35" size='35' readonly></td>
</tr>

<tr id="trCity">
	<input id="showCityID" type="hidden" name="city_id" value="<?=$arr_show_details['city_id']?>">
    <td align="right">Miasto</td>
    <td align="left" id="showCityTD" ondblclick="window_cities();"><?=fn_get_city_from_id($arr_show_details['city_id'])?> (Dwukrotnie kliknij)</td>
</tr>

<tr>
    <td align="right">Data wystawy</td>
    <td><input class="tcal" id="showDate" name="showdate" value="<?=$arr_show_details['show_date']?>" readonly></td>
</tr>

<tr>
    <td align="right">enter_to_date</td>
    <td><input class="tcal" id="enterToDate" name="enter_to_date" value="<?=$arr_show_details['enter_to_date']?>" readonly></td>
</tr>

<tr>
    <td align="right">cancel_to_date</td>
    <td><input class="tcal" id="cancelToDate" name="cancel_to_date" value="<?=$arr_show_details['cancel_to_date']?>" readonly></td>
</tr>

<tr>
    <td align="right">change_class_to_date</td>
    <td><input class="tcal" id="schangeClassToDate" name="change_class_to_date" value="<?=$arr_show_details['change_class_to_date']?>" readonly></td>
</tr>

<tr>
    <td align="right">org_info</td>
    <td><textarea id="orgInfo" name="org_info" cols="50" rows="5" readonly><?=$arr_show_details['org_info']?></textarea></td>
</tr>

<tr>
    <td align="right">remarks</td>
    <td><textarea id="remarks" name="remarks" cols="50" rows="5" readonly><?=$arr_show_details['remarks']?></textarea></td>
</tr>

<tr>
    <td align="right">ranga</td>
    <td><?=fn_get_rangi_select($arr_show_details['rank_id'])?></td>
</tr>

<tr>
    <td align="right">adres</td>
    <td><textarea id="adres" cols="50" rows="5" readonly><?=$arr_show_details['adres']?></textarea></td>
</tr>

<tr>
    <td align="right">Opublikowana</td>
    <input id="is_public" type="hidden" name="is_public" value="<?=$arr_show_details['is_public']?>"/>
    <td id="isPublicTD" ondblclick="is_public_toggle();" style="background-color: <?=$ispub_bgcolor?>; color: #fff;"><?=$ispub_text?></td>
</tr>
</form>
<tr>
    <td colspan="2" align="center">
    
    <div id="submitBtnDiv" hidden style="padding:0; margin:0;"><input class="button" value="SAVE" onclick="submitShowForm();"/></div>
    	<div id="afterSaveBlock">
	    	<div style="display:inline-block;">
		    	<form action="?action=wystawy" method="POST" id="editShowForm">
				<input type="hidden" name="price_show_id" value="<?=$_POST['show_id']?>">
				<input id="priceEditBtn" class="button" type="submit" value="EDYTUJ CENY" />
				</form>
			</div>
			<div style="display:inline-block;">	
				<form action="?action=wystawy" method="POST">
				<input type="hidden" name="users_show_id" value="<?=$_POST['show_id']?>">
				<input id="membersBtn" class="button" type="submit" value="UCZĘSTNIKI (<?=fn_show_users_cnt($_POST['show_id'])?>)" />
				</form>
			</div>
		</div>
	</td>
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

if(isset($_POST['show_archiwum']) AND isset($_POST['arc_cbx'])){$sql_add = "AND `W`.`arc_datetime` != '0000-00-00 00:00:00'"; $arc_checked = "checked";}else{$sql_add = "AND `W`.`arc_datetime` = '0000-00-00 00:00:00'"; $arc_checked = "";}


	$sql = "SELECT `W`.`id`, `W`.`name`, `M`.`name` AS `city`, `W`.`show_date`, `W`.`is_public`, `W`.`arc_datetime`,  `R`.`name` AS `rang`
	FROM `tb_wystawy` as `W` 
    LEFT JOIN `tb_list_miasta` AS `M` 
    ON `W`.`city_id` = `M`.`id`
    LEFT JOIN `tb_list_rangi` AS `R` 
    ON `W`.`rank_id` = `R`.`id`

    WHERE `W`.`org_id` = '".$arr_user_details['id']."' $sql_add ORDER BY `W`.`show_date`";
	
/*
    $sql = "SELECT `W`.`id`, `W`.`name`, `M`.`name` AS `city`, `W`.`show_date`, `W`.`is_public`, `W`.`arc_datetime` FROM `tb_wystawy` as `W` 
    LEFT JOIN `tb_list_miasta` AS `M` 
    ON `W`.`city_id` = `M`.`id` 
    WHERE `W`.`org_id` = '".$arr_user_details['id']."' ORDER BY `W`.`show_date`";
    */
    if($result = $mysqli->query($sql)) {
    	
    	
        if($result->num_rows > 0){

            echo ("<table id=\"wystawyTable\" class=\"cell-border compact stripe\">
	            <thead><tr>
	            <th align='left' >ID</th>
	            <th align='left' ><input id=\"nameSearch\" placeholder=\"WYSTAWA\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"citySearch\" placeholder=\"MIASTO\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"dataSearch\" placeholder=\"DATA\" class=\"form-control\" /></th>
	            <th align='left' class = 'select-filter'></th>
	            <th align='left' class = 'select-filter'></th>
	            </tr></thead>
	            <tbody>");

            while ($row = $result->fetch_object()) {
            	if($row->is_public == 1){$is_public = "OPUBLIKOWANA"; $style = "";}else{$is_public = "NIEOPUBLIKOWANA"; $style = "style='color: white; background-color: red;'";}
                echo ("<tr ondblclick='selectShow($row->id)'><td>$row->id</td><td>$row->name</td><td>$row->city</td><td>$row->show_date</td><td>$row->rang</td><td $style>$is_public</td></tr>");
            }

            echo ("</tbody>
                    <tfoot><tr> <th>
                    				<form action=\"?action=wystawy\" method=\"POST\" id=\"showArchiwumForm\">
	                    				<input type=\"hidden\" name=\"show_archiwum\" value=\"1\">
	                    				<input type='checkbox' $arc_checked name='arc_cbx' onchange=\"document.getElementById('showArchiwumForm').submit();\" />
                    				</form>
                    			</th> <th align='left'>Archiwum</th> <th></th> <th align='left'></th> <th align='left'></th> <th align='left'></th> </tr></tfoot>
                    </table>");
        }else{fn_show_report("Nie ma danych");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

//--------------------LISTA WYSTAW ORGANIZATORA>-----------------------------------

function fn_create_show($newName, $org_id)
{
    global $mysqli;
    
    if(!is_numeric($org_id)){return false;}

    $sql = "INSERT INTO `tb_wystawy` (`name`,`org_id`)VALUES('".trim(addslashes(stripslashes($newName)))."', '$org_id')";
    
    if($mysqli->query($sql)) {
        return $mysqli->insert_id;
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return false;
}

function fn_update_show()
{
	global $mysqli;
	
	if(!isset($_POST['flagaFormActive'])){return false;}
	
	if(isset($_POST['update_show_id']) AND is_numeric($_POST['update_show_id'])){$show_id = $_POST['update_show_id'];}else{fn_err_write("error update_show_id", __LINE__, __FILE__); return false;}
	if(isset($_POST['city_id']) AND is_numeric($_POST['city_id'])){$city_id = $_POST['city_id'];}else{fn_err_write("error city_id", __LINE__, __FILE__); return false;}
	if(isset($_POST['showname'])){$showname = trim(addslashes(stripslashes($_POST['showname'])));}else{fn_err_write("error showname", __LINE__, __FILE__); return false;}
	if(isset($_POST['is_public']) AND is_numeric($_POST['is_public'])){$is_public = $_POST['is_public'];}else{fn_err_write("error is_public", __LINE__, __FILE__); return false;}
	if(isset($_POST['showdate']) AND isValidDate($_POST['showdate'])){$showdate = $_POST['showdate'];}else{fn_err_write("error showdate", __LINE__, __FILE__); return false;}
	if(isset($_POST['enter_to_date']) AND isValidDate($_POST['enter_to_date'])){$enter_to_date = $_POST['enter_to_date'];}else{fn_err_write("error enter_to_date", __LINE__, __FILE__); return false;}
	if(isset($_POST['cancel_to_date']) AND isValidDate($_POST['cancel_to_date'])){$cancel_to_date = $_POST['cancel_to_date'];}else{fn_err_write("error cancel_to_date", __LINE__, __FILE__); return false;}
	if(isset($_POST['change_class_to_date']) AND isValidDate($_POST['change_class_to_date'])){$change_class_to_date = $_POST['change_class_to_date'];}else{fn_err_write("error change_class_to_date", __LINE__, __FILE__); return false;}
	
	if(isset($_POST['remarks'])){$remarks = trim(addslashes(stripslashes($_POST['remarks'])));}else{fn_err_write("error remarks", __LINE__, __FILE__); return false;}
	if(isset($_POST['org_info'])){$org_info = trim(addslashes(stripslashes($_POST['org_info'])));}else{fn_err_write("error org_info", __LINE__, __FILE__); return false;}
	if(isset($_POST['rank_id']) AND is_numeric($_POST['rank_id'])){$rank_id = $_POST['rank_id'];}else{fn_err_write("error rank_id", __LINE__, __FILE__); return false;}
	
	if($_POST['flagaFormActive'] == 1){

		$sql = "UPDATE `tb_wystawy` SET 
		`name` = '$showname',
		`city_id` = '$city_id',
		`show_date` = '$showdate',
		`enter_to_date` = '$enter_to_date',
		`cancel_to_date` = '$cancel_to_date',
		`change_class_to_date` = '$change_class_to_date',
		`org_info` = '$org_info',
		`remarks` = '$remarks',
		`rank_id` = '$rank_id',
		`is_public` = '$is_public'
		WHERE `id` = '$show_id' LIMIT 1";
	}else{

		$sql = "UPDATE `tb_wystawy` SET `is_public` = '$is_public' WHERE `id` = '$show_id' LIMIT 1";
	}
	

    if(!$mysqli->query($sql)){fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

return true;
}

function fn_delete_show($show_id)
{
    global $mysqli;
    
    if(!is_numeric($show_id)){return false;}
    
    if( ($show_users_cnt = fn_show_users_cnt($show_id)) === false){fn_show_report("Database error. Contact with administrator."); return false;}
    
    if( $show_users_cnt != 0){fn_show_report("Nie można usuwać wystawy z uczęstnikami ($show_users_cnt szt.)<BR>Tylko przenieść do archiwum."); return false;}  
    
    if(($sp_cnt = fn_delete_show_pricing($show_id))===false){fn_show_report("Database error. Contact with administrator."); return false;} 
    	
  	if($sp_cnt > 0){$msg = $sp_cnt." Cen dla klas usunięto.";}else{$msg = "";}
    

    $sql = "DELETE FROM `tb_wystawy` WHERE `id` = '$show_id' LIMIT 1";

    if($mysqli->query($sql)) {
        if($mysqli->affected_rows == 1){return "Została usunięta Wystawa<BR>".$msg;}
    	return "Nie udało się usunąć wystawy.<BR>".$msg;
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return "Database Error!";
}

function fn_show_users_cnt($show_id)
{
	global $mysqli;
    
    if(!is_numeric($show_id)){fn_err_write("error. not numeric show_id", __LINE__, __FILE__); return true;}
    
    $sql = "SELECT count(*) as `cnt` FROM `tb_wystawy_uczestnicy` WHERE `show_id` = '$show_id'";
    if($result = $mysqli->query($sql)) {
    	return $result->fetch_object()->cnt;
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
    
    return false;
}

function fn_delete_show_pricing($show_id)
{
	global $mysqli;
    
    if(!is_numeric($show_id)){return false;}
    
    $sql = "DELETE FROM `tb_wystawy_pricing` WHERE `id` = '$show_id'";
    if($mysqli->query($sql)) {
    	return $mysqli->affected_rows;
    }else{n_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return false;	
}

function fn_get_klasy_select()
{
	global $mysqli;
	
	if(isset($_POST['klasa_id']) AND is_numeric($_POST['klasa_id'])){$klasa_selected = $_POST['klasa_id'];}else{$klasa_selected = 1;}
	
	$res = "<select name='klasa_id'>";
    if(isset($_POST['price_show_id']) AND is_numeric($_POST['price_show_id'])){
    	$sql = "SELECT * FROM `tb_list_klasy` WHERE `id` NOT IN (SELECT `klasa_id` FROM `tb_wystawy_pricing` WHERE `id` = '".$_POST['price_show_id']."')  ORDER BY `id`";
    }else{
    	$sql = "SELECT * FROM `tb_list_klasy` WHERE  ORDER BY `id`";
    }
    
    if($result = $mysqli->query($sql)) {
    	while($row = $result->fetch_object()){
    		if($klasa_selected == $row->id){$sel = "selected";}else{$sel = "";}
    		$res .= "<option $sel value='$row->id'>$row->name</option>";
    	}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
	
    $res .= "</select>";
    
    return $res;
}

function fn_get_rangi_select($rank_id)
{
	global $mysqli;
	
	if(is_numeric($rank_id)){$rank_selected = $rank_id;}else{$rank_selected = 1;}
	
	$res = "<select id='rankSelect' name='rank_id' disabled>";

    $sql = "SELECT * FROM `tb_list_rangi` ORDER BY `id`";

    if($result = $mysqli->query($sql)) {
    	while($row = $result->fetch_object()){
    		if($rank_selected == $row->id){$sel = "selected";}else{$sel = "";}
    		$res .= "<option $sel value='$row->id'>$row->name</option>";
    	}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
	
    $res .= "</select>";
    
    return $res;
}


function fn_get_price_rows($show_id)
{
	global $mysqli;
	
	if(!is_numeric($show_id)){return "";}
	
	$sql = "SELECT `tb_wystawy_pricing`.`klasa_id`, `tb_wystawy_pricing`.`price`, `tb_list_klasy`.`name` 
	FROM `tb_wystawy_pricing` JOIN `tb_list_klasy` ON `tb_wystawy_pricing`.`klasa_id` = `tb_list_klasy`.`id` 
	WHERE `tb_wystawy_pricing`.`id` = '$show_id' ORDER BY `klasa_id`";
	
	$tr_res ="";
	
	if($result = $mysqli->query($sql)) {
    	while($row = $result->fetch_object()){
    		$tr_res .= "<tr><td align='right'>$row->name</td> <td align='right'>$row->price</td>	<td align='center'><img ondblclick='deleteOnePrice($row->klasa_id);' src='img/del-button.png' title='USUŃ CENĘ'></img></td></tr>";
    	}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
	return $tr_res;
}

function fn_add_price_to_show($show_id, $klasa_id, $priceNew)
{
	global $mysqli;
	
	if(!is_numeric($show_id) OR !is_numeric($klasa_id) OR !is_numeric($priceNew)){fn_err_write("err: not numeric: ".$show_id.";".$klasa_id.";".$priceNew, __LINE__, __FILE__); return false;}
	
	$sql = "INSERT INTO `tb_wystawy_pricing` (`id`,`klasa_id`,`price`) VALUES ('$show_id','$klasa_id','$priceNew')";
	
	if(!$mysqli->query($sql)) {fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__); return false;}
	
	return true;
}

function fn_del_price_from_show($show_id, $klasa_id)
{
	global $mysqli;
	if(!is_numeric($show_id) OR !is_numeric($klasa_id)){fn_err_write("err: not numeric: ".$show_id.";".$klasa_id, __LINE__, __FILE__); return false;}
	$sql = "DELETE FROM `tb_wystawy_pricing` WHERE `id` = '$show_id' AND `klasa_id` = '$klasa_id' LIMIT 1";
	
	if(!$mysqli->query($sql)) {fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__); return false;}
	return true;
}

function fn_move_to_arch_show($show_id)
{
	global $mysqli;

	$sql = "UPDATE `tb_wystawy` SET `arc_datetime` = '".date("Y-m-d H:i:s")."' WHERE `id` = '$show_id' LIMIT 1";
	
	if(!$mysqli->query($sql)) {fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__); return false;}
	return true;
}

function fn_move_from_arch_show($show_id)
{
	global $mysqli;

	$sql = "UPDATE `tb_wystawy` SET `arc_datetime` = '0000-00-00 00:00:00' WHERE `id` = '$show_id' LIMIT 1";
	
	if(!$mysqli->query($sql)) {fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__); return false;}
	return true;
}

function fn_show_users_from_show($show_id)
{
	global $mysqli;

	$sql = "SELECT `P`.`nazwa_przydomek`, `P`.`birthday`, `P`.`sex`, `P`.`birthday`, `P`.`id` AS `dog_id`,
	`R`.`name` AS `rasa`, `C`.`name` AS `color`, `K`.`name` AS `klasa`, `U`.`is_payed`,`U`.`in_datetime`,
	`O`.`name` AS `ownername`, `O`.`surname` AS `ownersurname`, `O`.`email`
	FROM 
	`tb_wystawy_uczestnicy` AS `U` INNER JOIN `tb_psy` AS `P`
	ON `U`.`dog_id` = `P`.`id`
	INNER JOIN `tb_list_klasy` AS `K`
	ON `U`.`klasa_id` = `K`.`id`
	INNER JOIN `tb_users` AS `O`
	ON `P`.`owner_id` = `O`.`id`
	INNER JOIN `tb_list_rasy` AS `R`
	ON `P`.`rasa_id` = `R`.`id`
	INNER JOIN `tb_list_kolory` AS `C`
	ON `P`.`color_id` = `C`.`id`
	WHERE `U`.`show_id` = '$show_id' ORDER BY `P`.`id`";
	
	$header = "<link rel=\"stylesheet\" type=\"text/css\" href=\"libs/DataTables/datatables.min.css\"/>
    <script type=\"text/javascript\" src=\"libs/DataTables/datatables.min.js\"></script>
    <script type=\"text/javascript\" src=\"JS/organizator_dt_psy.js\"></script>";
	

    if($result = $mysqli->query($sql)) {
    	
    	//<th align='left' ><input id=\"sexSearch\" placeholder=\"PLEC\" class=\"form-control\" /></th>
        if($result->num_rows > 0){

            $tb = ("<table id=\"psyTable\" class=\"cell-border compact stripe\">
	            <thead><tr>
	            <th align='left' ><input id=\"nameSearch\" placeholder=\"NAZWA PSA\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"emailSearch\" placeholder=\"EMAIL WŁAŚCICIELA\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"birthSearch\" placeholder=\"URODZONY\" class=\"form-control\" /></th>
	            <th align='left' class = 'select-filter'></th>
	            <th align='left' ><input id=\"rasaSearch\" placeholder=\"RASA\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"colorSearch\" placeholder=\"UMASZCZENIE\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"inDatetimeSearch\" placeholder=\"CZAS ZGŁOSZENIA\" class=\"form-control\" /></th>
	            <th align='left' class = 'select-filter'></th>
	            <th align='left' class = 'select-filter'></th>
	            </tr></thead>
	            <tbody>");

            while ($row = $result->fetch_object()) {
            	if($row->is_payed == 1){$is_payed = "OPŁACONE"; $paystyle = "style='color: green; background-color: red;'";}else{$is_payed = "NIEOPŁACONE"; $paystyle = "style='color: white; background-color: red;'";}
                $tb .= ("<tr ondblclick='selectMemberDetails($show_id, $row->dog_id)'><td>$row->nazwa_przydomek</td><td>$row->email</td><td>$row->birthday</td><td>$row->sex</td><td>$row->rasa</td><td>$row->color</td><td>$row->in_datetime</td><td>$row->klasa</td><td $paystyle>$is_payed</td></tr>");
            }

            $tb .= ("</tbody>
                    <tfoot><tr> <th>PIES</th> <th>EMAIL WŁAŚCICIELA</th> <th align='left'>URODZONY</th> <th>PŁEC</th> <th align='left'>RASA</th> <th align='left'>UMASZCZENIE</th> <th align='left'>CZAS ZGŁOSZENIA</th> <th align='left'>KLASA</th> <th align='left'>OPŁACONE?</th> </tr></tfoot>
                    </table>");
            
            echo $header.$tb;
            return true;
        }else{fn_show_report("Nie ma danych");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
return false;
}
?>
</div>