<div style='max-width: 800px; margin: 20px;'>
<?php
if(!defined("MAIN_FILE")) die;
if(defined("SHOW_FILENAME")) fn_show_report(basename(__FILE__));

if(!isset($_GET['action']) OR $_GET['action'] != "wystawy"){exit();}
if(!$arr_user_details = fn_get_user_details()){fn_show_report("Nieznany użytkownik"); exit();}


/*
echo ("<pre>");
print_r($arr_rasy);
echo ("</pre>");
*/


//----------------------------<SHOW INFO---------------------------------------------
if (isset($_POST['show_id']) AND is_numeric($_POST['show_id'])):

if(!$arr_show_details = fn_get_row_with_id("tb_wystawy", $_POST['show_id'])){
	fn_show_report("Wystawa nie istnieje");
	exit();
}

if (isset($_POST['to_show_dog_id']) AND is_numeric($_POST['to_show_dog_id'])){
	fn_show_selected_dog($_POST['to_show_dog_id'], $_POST['show_id']);
}

if (isset($_POST['commit_dog_id']) AND is_numeric($_POST['commit_dog_id']) AND isset($_POST['klasa_id']) AND is_numeric($_POST['klasa_id'])){
	fn_add_dog_to_show($_POST['commit_dog_id'], $_POST['klasa_id'], $_POST['show_id']);
}




?>

<link rel="stylesheet" type="text/css" href="CSS/w3.css"/>
<form action="?action=wystawy" method="POST" id="editShowForm">
<input type="hidden" name="flagaFormActive" id="flagaFormActive" value="0">
<input type="hidden" name="update_show_id" value="<?=$_POST['show_id']?>">
<table class="standartTable">
<thead><tr>
	<th style="padding: 0px; text-align: center; height: 58px; width: 280px">
	</th>
    <th><div></div></th>
</tr></thead>

<tr>
    <td align="right">Nazwa wystawy</td>
    <td><?=$arr_show_details['name']?></td>
</tr>

<tr id="trCity">
    <td align="right">Miasto</td>
    <td align="left"><?=fn_get_city_from_id($arr_show_details['city_id'])?></td>
</tr>

<tr>
    <td align="right">Data wystawy</td>
    <td><?=$arr_show_details['show_date']?></td>
</tr>

<tr>
    <td align="right">enter_to_date</td>
    <td><?=$arr_show_details['enter_to_date']?></td>
</tr>

<tr>
    <td align="right">cancel_to_date</td>
    <td><?=$arr_show_details['cancel_to_date']?></td>
</tr>

<tr>
    <td align="right">change_class_to_date</td>
    <td><?=$arr_show_details['change_class_to_date']?></td>
</tr>

<tr>
    <td align="right">org_info</td>
    <td><?=$arr_show_details['org_info']?></td>
</tr>

<tr>
    <td align="right">remarks</td>
    <td><?=$arr_show_details['remarks']?></td>
</tr>

<tr>
    <td align="right">ranga</td>
    <td><?=fn_get_name_from_list("tb_list_rangi", $arr_show_details['rank_id'])?></td>
</tr>

<tr>
    <td align="right">adres</td>
    <td><?=$arr_show_details['adres']?></td>
</tr>

<tr>
    <td colspan="2" align="center">
		<?=fn_show_prices_for_this_show($_POST['show_id'])?>
	</td>
</tr>

<tr>
    <td colspan="2" align="center">
		<?=fn_show_my_dogs_for_this_show($_POST['show_id'])?>
	</td>
</tr>


</table>
</form>

<?php
if (isset($_POST['show_my_dogs'])):
?>
<div align="center" style='max-width: 800px; margin: 20px;'>
    <table class="standartTable">
        <tr><th>Nazwa</th><th>Hodowca</th><th>Urodzony</th><th>Dodany</th></tr>
        <?=fn_show_my_dogs()?>
    </table>
</div>

<?php
//----------------------------SHOW INFO>---------------------------------------------
endif;
exit();
endif;

//----------------------------<SHOW INFO---------------------------------------------




	//-------------------------<LISTA WYSTAW UCZESTNIKA-----------------------------------------------
?>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="JS/panel_user_wystawy.js"></script>
    
	<form hidden action="?action=wystawy" method="POST" id="myShowsForm"><input type="hidden" name="myShows" value="1"></form>
	
	
<?php //show_id 	dog_id 	klasa_id 	is_payed 

	if(isset($_POST['myShows'])){$sql_add = "AND `W`.`id` IN (SELECT `show_id` FROM `tb_wystawy_uczestnicy` WHERE `dog_id` IN (SELECT `id` FROM `tb_psy` WHERE `owner_id` = '".$arr_user_details['id']."'))";}else{$sql_add = "";}

	$sql = "SELECT `W`.`id`, `W`.`name`, `M`.`name` AS `city`, `W`.`show_date`, `W`.`is_public`, `W`.`arc_datetime`,  `R`.`name` AS `rang`
	FROM `tb_wystawy` as `W` 
    LEFT JOIN `tb_list_miasta` AS `M` 
    ON `W`.`city_id` = `M`.`id`
    LEFT JOIN `tb_list_rangi` AS `R` 
    ON `W`.`rank_id` = `R`.`id`

    WHERE  `W`.`is_public` = 1 AND `W`.`arc_datetime` = '0000-00-00 00:00:00' $sql_add ORDER BY `W`.`show_date`";
	
    if($result = $mysqli->query($sql)) {
    	
    	
        if($result->num_rows > 0){

            echo ("<table id=\"wystawyTable\" class=\"cell-border compact stripe\">
	            <thead><tr>
	            <th align='left' >ID</th>
	            <th align='left' ><input id=\"nameSearch\" placeholder=\"WYSTAWA\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"citySearch\" placeholder=\"MIASTO\" class=\"form-control\" /></th>
	            <th align='left' ><input id=\"dataSearch\" placeholder=\"DATA\" class=\"form-control\" /></th>
	            <th align='left' class = 'select-filter'></th>
	            </tr></thead>
	            <tbody>");

            while ($row = $result->fetch_object()) {
                echo ("<tr ondblclick='selectShow($row->id)'><td>$row->id</td><td>$row->name</td><td>$row->city</td><td>$row->show_date</td><td>$row->rang</td></tr>");
            }

            echo ("</tbody>
                    <tfoot><tr> <th>
                    				<input type='checkbox' onchange=\"document.getElementById('myShowsForm').submit();\" />
                    			</th> <th align='left'>Pokaż moje</th> <th></th> <th align='left'></th> <th align='left'></th> </tr></tfoot>
                    </table>");
        }else{fn_show_report("Nie ma danych");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

//--------------------LISTA WYSTAW UCZESTNIKA>-----------------------------------
function fn_show_selected_dog($dog_id, $show_id)
{
	if(!$arr_dog_details = fn_get_row_with_id("tb_psy", $dog_id)){return "";}
	
	echo ("<table class=\"standartTable\">
        <tr><th>Nazwa</th><th>Hodowca</th><th>Urodzony</th><th>Wybierz klasę</th><th>Dodaj</th></tr>
        
        <form action=\"?action=wystawy\" method=\"POST\">
			      	<input type=\"hidden\" name=\"commit_dog_id\" value = \"$dog_id\">
			      	<input type=\"hidden\" name=\"show_id\" value = \"$show_id\">
                <tr>
                
		      <td>".$arr_dog_details['nazwa_przydomek']."</td>
		      <td>".$arr_dog_details['hodowca']."</td>
		      <td>".$arr_dog_details['birthday']."</td>
		      <td>".fn_klasa_select($show_id)."</td>
		      <td><input class=\"button\" type=\"submit\" value=\"POTWIERDZAM\" /></td>
		      
		      </tr>
		      
		      </form>
        
        
    </table>");
	 
}

function fn_klasa_select($show_id)
{
	global $mysqli;
	
	$sel = "<select name=\"klasa_id\" >";
	$sql = "SELECT `P`.`klasa_id`, `K`.`name` FROM `tb_wystawy_pricing` AS `P` JOIN `tb_list_klasy` AS `K` ON `P`.`klasa_id` = `K`.`id`  WHERE `P`.`id` = '$show_id'";

	if($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_object()) {
        	$sel .= "<option value=\"$row->klasa_id\">$row->name</option>";
        }
	}
	$sel .= "</select>";
	
	return $sel;
}

function fn_show_my_dogs()
{
    global $mysqli;
    if(!$arr_user = fn_get_user_details()){return "";}
    
    if(isset($_POST['show_id']) AND is_numeric($_POST['show_id'])){$show_id = $_POST['show_id'];}else{return "";}

    $sql = "SELECT * FROM `tb_psy` WHERE `owner_id` = '".$arr_user['id']."' AND `is_confirmed` = 1 AND `id` NOT IN (SELECT `dog_id` FROM `tb_wystawy_uczestnicy` WHERE `show_id` = '$show_id' ) ORDER BY `id` DESC";
    if($result = $mysqli->query($sql)) {
    	if($result->num_rows == 0){return "<tr><td colspan=4>Nie ma dostępnych psów</td></tr>";}
        while ($row = $result->fetch_object()) {
            echo ("<form id=\"formRow_$row->id\" action=\"?action=wystawy\" method=\"POST\">
			      	<input type=\"hidden\" name=\"to_show_dog_id\" value = \"$row->id\">
			      	<input type=\"hidden\" name=\"show_id\" value = \"$show_id\">
                <tr onDblclick=\"submitFormId('formRow_$row->id')\">
		      <td>$row->nazwa_przydomek</td>
		      <td>$row->hodowca</td>
		      <td>$row->birthday</td>
		      <td>$row->reg_datetime</td>
		      </tr></form>");
        }
    }else { fn_err_write("mysql_error: " . $mysqli->error . "($sql)", __LINE__, __FILE__); }
    return "";
}

function fn_show_my_dogs_for_this_show_old($show_id)
{
	global $mysqli;
    if(!$arr_user = fn_get_user_details()){return "";}
    
    if(isset($_POST['show_id']) AND is_numeric($_POST['show_id'])){$show_id = $_POST['show_id'];}else{return "";}
    
    $table = "<table class=\"standartTable\"><tr><th colspan=4>Moje psy zgłoszone do tej wystawy:</th></tr>";

    $sql = "SELECT * FROM `tb_psy` WHERE `owner_id` = '".$arr_user['id']."' AND `id` IN (SELECT `dog_id` FROM `tb_wystawy_uczestnicy` WHERE `show_id` = '$show_id') ORDER BY `id` DESC";
    if($result = $mysqli->query($sql)) {
    	if($result->num_rows == 0){return "<div>Nie mam zgłoszonych do tej wystawy psów.</div>";}
        while ($row = $result->fetch_object()) {
            $table .= "<tr><td>$row->nazwa_przydomek</td><td>$row->hodowca</td><td>$row->birthday</td><td>$row->reg_datetime</td></tr>";
        }
    }else { fn_err_write("mysql_error: " . $mysqli->error . "($sql)", __LINE__, __FILE__); }
    
    $table .= "</table>";
    return $table;
}


function fn_show_my_dogs_for_this_show($show_id)
{
	global $mysqli;
    if(!$arr_user = fn_get_user_details()){return "";}
    
    if(isset($_POST['show_id']) AND is_numeric($_POST['show_id'])){$show_id = $_POST['show_id'];}else{return "";}
    
    $table = "<table class=\"standartTable\"><tr><th colspan=4>Moje psy zgłoszone do tej wystawy:</th><th>Data Zgłoszenia</th><th>Opłata</th></tr>";

    $sql = "SELECT `P`.`nazwa_przydomek`,`P`.`hodowca`,`P`.`birthday`,`U`.`klasa_id`,`U`.`is_payed`,`U`.`in_datetime`, `K`.`name` AS `klasa`
    FROM `tb_psy` AS `P` INNER JOIN `tb_wystawy_uczestnicy` AS `U`
	ON `P`.`id` = `U`.`dog_id`
	INNER JOIN `tb_list_klasy` AS `K`
	ON `U`.`klasa_id` = `K`.`id`
	WHERE `U`.`show_id` = '$show_id' AND `P`.`owner_id` = '".$arr_user['id']."' ORDER BY `nazwa_przydomek` DESC";
    
    
    
    if($result = $mysqli->query($sql)) {
    	if($result->num_rows == 0){return "<div>Nie mam zgłoszonych do tej wystawy psów.</div>";}
        $_SESSION["show_id"] = $show_id;
        while ($row = $result->fetch_object()) {
        	if($row->is_payed == 1){$pay_text = "OPŁĄCONE"; $pay_color = "green";}else{$pay_text = "NIEOPŁĄCONE"; $pay_color = "red";}
            $table .= "<tr><td>$row->nazwa_przydomek</td><td>$row->hodowca</td><td>$row->birthday</td><td>$row->klasa</td><td>$row->in_datetime</td><td bgcolor='$pay_color'>$pay_text</td></tr>";
        }
        //$table .= "<tr><td colspan='6'><p><a href=\"export_to_pdf.php?type=katalog\" target=\"_blank\">Katalog uczestników</a></p></td></tr>";
$table .= "<tr><td colspan='6'><p><a href=\"export_to_pdf.php?type=katalog&show_id=\" target=\"_blank\" class=\"w3-button w3-green w3-medium w3-round w3-hover-red\">Katalog uczestników (pdf)</a></p></td></tr>";
    }else { fn_err_write("mysql_error: " . $mysqli->error . "($sql)", __LINE__, __FILE__); }
    
    $table .= "</table>";
    return $table;
}

function fn_add_dog_to_show($dog_id, $klasa_id, $show_id)
{
	global $mysqli;
	$sql = "INSERT INTO `tb_wystawy_uczestnicy` (`show_id`, `dog_id`, `klasa_id`, `in_datetime`)VALUE('$show_id','$dog_id','$klasa_id','".date("Y-m-d H:i:s")."')";
	if(!$mysqli->query($sql)) {fn_err_write("mysql_error: " . $mysqli->error . "($sql)", __LINE__, __FILE__); return false;}
}

function fn_show_prices_for_this_show($show_id)
{
	global $mysqli;
	
	$submit_form = "";
	
	if(!$arr_show_details = fn_get_row_with_id("tb_wystawy", $show_id)){return "";}
	
	if(isset($arr_show_details['enter_to_date']) AND date("Y-m-d") <= $arr_show_details['enter_to_date'] ){
		$submit_form = '<div style="display:inline-block;">
	    	<form action="?action=wystawy" method="POST" id="editShowForm">
			<input type="hidden" name="show_id" value="'.$show_id.'">
			<input class="button" type="submit" name="show_my_dogs" value="ZGŁOŚ PSA DO TEJ WYSTAWY" />
			</form>
		</div>';
	}

	$td = "";
	$sql = "SELECT `P`.`klasa_id`, `P`.`price`, `K`.`name` FROM `tb_wystawy_pricing` AS `P` JOIN `tb_list_klasy` AS `K` ON `P`.`klasa_id` = `K`.`id`  WHERE `P`.`id` = '$show_id'";
	$table = "<table class=\"standartTable\"><tr><th colspan=2>Ceny dla klas:</th></tr>";
	if($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_object()) {
        	$td .= "<tr><td align=right>$row->name</td><td>$row->price PLN</td></tr>";
        }
	}
	
	if(empty($td)){$td = "<td>Nie ma cen dla tej wystawy. Skontaktuj sięz organizatorem.</td>"; $submit_form = "";}
	
	$table .= $td."</table>";
	
	return $submit_form.$table;
}

?>
</div>