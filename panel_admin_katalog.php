<?php
if(!defined("MAIN_FILE")) die;
if(defined("SHOW_FILENAME")) fn_show_report(basename(__FILE__));

if($_GET['sel'] == "rasy"){

    if(isset($_POST['rasa_id']) AND isset($_POST['nazwaRasy']) AND isset($_POST['selectGrupa'])){
        fn_show_report( fn_update_rasa($_POST['rasa_id'],$_POST['nazwaRasy'], $_POST['selectGrupa']) );
    }

    if(isset($_POST['newRasaName']) AND isset($_POST['selectGrupa'])){
        fn_show_report( fn_insert_new_rasa($_POST['newRasaName'], $_POST['selectGrupa']) );
    }

    //---EDIT RASA FORM-----
    if(isset($_GET['edit_id']) AND is_numeric($_GET['edit_id'])){

        echo ("<div style='max-width: 800px; margin: 20px; display: inline-block;'>");

        $sel[0] = "";$sel[1] = "";$sel[2] = "";$sel[3] = "";$sel[4] = "";$sel[5] = "";
        $sel[6] = "";$sel[7] = "";$sel[8] = "";$sel[9] = "";$sel[10] = "";

        $sql = "SELECT `id`, `name`, `grupa` FROM `tb_list_rasy` WHERE `id` = '".$_GET['edit_id']."' LIMIT 1";
        if($result = $mysqli->query($sql)){
            if($row = $result->fetch_object())
            {
                if(isset($sel[$row->grupa])){$sel[$row->grupa] = "selected";}
                echo ("<table border=\"0\" class=\"standartTable\">
                        <form action=\"?action=katalog&sel=rasy\" method=\"POST\">
			      	    <input type=\"hidden\" name=\"rasa_id\" value = \"$row->id\">
                        <tr>
		                <td><input type='text' name='nazwaRasy' value='$row->name' size='35'></td>
		                <td>
		                <select name='selectGrupa'>
                         <option $sel[1] value=\"1\">Grupa 1</option>
                         <option $sel[2] value=\"2\">Grupa 2</option>
                         <option $sel[3] value=\"3\">Grupa 3</option>
                         <option $sel[4] value=\"4\">Grupa 4</option>
                         <option $sel[5] value=\"5\">Grupa 5</option>
                         <option $sel[6] value=\"6\">Grupa 6</option>
                         <option $sel[7] value=\"7\">Grupa 7</option>
                         <option $sel[8] value=\"8\">Grupa 8</option>
                         <option $sel[9] value=\"9\">Grupa 9</option>
                         <option $sel[10] value=\"10\">Grupa 10</option>
                         <option $sel[0] value=\"0\">Rasy nieuznane przez FCI</option>
                        </select>
                        </td>          
		      <td><input type='submit' value='Save'></td></tr>
		      </form>
		      </table>");
            }
        }else{
            fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
        }


        echo ("</div>");
        exit();
    }

    //---NOWA RASA FORM-----
    if(isset($_GET['add'])){

        echo ("<div style='max-width: 800px; margin: 20px; display: inline-block;'>");

        echo ("<table border=\"0\" class=\"standartTable\">
                        <form action=\"?action=katalog&sel=rasy\" method=\"POST\">
                        <tr>
		                <td><input type='text' name='newRasaName' size='35'></td>
		                <td>
		                <select name='selectGrupa'>
                         <option value=\"1\">Grupa 1</option>
                         <option value=\"2\">Grupa 2</option>
                         <option value=\"3\">Grupa 3</option>
                         <option value=\"4\">Grupa 4</option>
                         <option value=\"5\">Grupa 5</option>
                         <option value=\"6\">Grupa 6</option>
                         <option value=\"7\">Grupa 7</option>
                         <option value=\"8\">Grupa 8</option>
                         <option value=\"9\">Grupa 9</option>
                         <option value=\"10\">Grupa 10</option>
                         <option selected value=\"0\">Rasy nieuznane przez FCI</option>
                        </select>
                        </td>          
		      <td><input type='submit' value='Save'></td></tr>
		      </form>
		      </table>");

        echo ("</div>");
        exit();
    }


?>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="JS/admin_katalog_rasy.js"></script>
<style>
    div.container {
        width: 80%;
    }
    .button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 5px 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 0px 0px;
        cursor: pointer;
    }
    .button1 {font-size: 10px;}
</style>
    <?php

    $sql = "SELECT `id`, `name`, `grupa` FROM `tb_list_rasy` ORDER BY `id`";//<i class="fa fa-pencil-square" aria-hidden="true"></i>
    if($result = $mysqli->query($sql)) {
        if($result->num_rows > 0){
//display
//cell-border compact stripe
            echo ("<div style='max-width: 800px; margin: 20px;'><table id=\"rasyTable\" class=\"cell-border compact stripe\"><thead><tr><th>Nazwa</th><th>Grupa</th><th>ID</th></tr></thead><tbody>");

            while ($row = $result->fetch_object()) {
                if($row->grupa == 0){$grupa = "Rasy nieuznane przez FCI";}else{$grupa = "Grupa ".$row->grupa;}
                echo ("<tr onclick='setIdToHref($row->id);'><td>$row->name</td><td>$grupa</td><td>$row->id</td></tr>");
            }

            echo ("</tbody>
                    <tfoot><tr><th align='left'>
                                    <a id='hrefToEdit' href='#&edit_id=0'><img src='img/writing.png' title='Edytuj wybraną rasę'></img></a>
                                    <a href='?action=katalog&sel=rasy&add=1'><img src='img/add.png' title='Dodaj rasę'></img></a>
                               </th>
                    <th>Grupa</th><th></th></tr></tfoot>
                    </table></div>");
        }else{fn_show_report("Nie ma danych");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
}

if($_GET['sel'] == "colors"){

    if(isset($_POST['color_id']) AND isset($_POST['color_name']) ){
        fn_show_report( fn_update_color($_POST['color_id'],$_POST['color_name']) );
    }

    if(isset($_POST['newColorName'])){
        fn_show_report( fn_insert_new_color($_POST['newColorName']) );
    }

    //---EDIT COLOR FORM-----
    if(isset($_GET['edit_id']) AND is_numeric($_GET['edit_id'])){

        echo ("<div style='max-width: 800px; margin: 20px; display: inline-block;'>");

        $sql = "SELECT `id`, `name` FROM `tb_list_kolory` WHERE `id` = '".$_GET['edit_id']."' LIMIT 1";
        if($result = $mysqli->query($sql)){
            if($row = $result->fetch_object())
            {
                 echo ("<table border=\"0\" class=\"standartTable\">
                        <form action=\"?action=katalog&sel=colors\" method=\"POST\">
			      	    <input type=\"hidden\" name=\"color_id\" value = \"$row->id\">
                        <tr>
		                <td><input type='text' name='color_name' value='$row->name' size='35'></td>
		      <td><input type='submit' value='Save'></td></tr>
		      </form>
		      </table>");
            }
        }else{
            fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
        }


        echo ("</div>");
        exit();
    }

    //---NOWE UMASZCZENIE FORMA-----
    if(isset($_GET['add'])){

        echo ("<div style='max-width: 800px; margin: 20px; display: inline-block;'>");

        echo ("<table border=\"0\" class=\"standartTable\">
                        <form action=\"?action=katalog&sel=colors\" method=\"POST\">
                        <tr>
		                <td><input type='text' name='newColorName' size='35'></td>
		      <td><input type='submit' value='Save'></td></tr>
		      </form>
		      </table>");

        echo ("</div>");
        exit();
    }


    ?>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="JS/admin_katalog_colors.js"></script>
    <?php

    $sql = "SELECT `id`, `name` FROM `tb_list_kolory` ORDER BY `id`";
    if($result = $mysqli->query($sql)) {
        if($result->num_rows > 0){

            echo ("<div style='max-width: 800px; margin: 20px;'>
                <table id=\"colorsTable\" class=\"cell-border compact stripe\">
                <thead><tr><th>Nazwa umaszczenia</th><th>ID</th></tr></thead>
                <tbody>");

            while ($row = $result->fetch_object()) {
                echo ("<tr onclick='setIdToHref($row->id);'><td>$row->name</td><td>$row->id</td></tr>");
            }

            echo ("</tbody>
                    <tfoot><tr><th align='left'>
                                    <a id='hrefToEdit' href='#&edit_id=0'><img src='img/writing.png' title='Edytuj wybrane umaszczenie'></img></a>
                                    <a href='?action=katalog&sel=colors&add=1'><img src='img/add.png' title='Dodaj nowe umaszczenie'></img></a>
                               </th><th></th>
                    </tr></tfoot>
                    </table></div>");
        }else{fn_show_report("Nie ma danych");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
}

//--------------------<CITIES-----------------------------------
if($_GET['sel'] == "cities"){

    if(isset($_POST['city_id']) AND isset($_POST['nazwaRasy']) AND isset($_POST['selectGrupa'])){
       // fn_show_report( fn_update_rasa($_POST['rasa_id'],$_POST['nazwaRasy'], $_POST['selectGrupa']) );
    }

    if(isset($_POST['newRasaName']) AND isset($_POST['selectGrupa'])){
        //fn_show_report( fn_insert_new_rasa($_POST['newRasaName'], $_POST['selectGrupa']) );
    }

    //---EDIT CITY FORM-----
    if(isset($_GET['edit_id']) AND is_numeric($_GET['edit_id'])){

        echo ("<div style='max-width: 800px; margin: 20px; display: inline-block;'>");

        $sql = "SELECT `id`, `name`, `woj_id` FROM `tb_list_miasta` WHERE `id` = '".$_GET['edit_id']."' LIMIT 1";
        if($result = $mysqli->query($sql)){
            if($row = $result->fetch_object())
            {
                if(isset($sel[$row->grupa])){$sel[$row->grupa] = "selected";}
                echo ("<table border=\"0\" class=\"standartTable\">
                        <form action=\"?action=katalog&sel=cities\" method=\"POST\">
			      	    <input type=\"hidden\" name=\"city_id\" value = \"$row->id\">
                        <tr>
		                <td><input type='text' name='nazwaRasy' value='$row->name' size='35'></td>
		                <td>".fn_show_select_wojewodstwa ($woj_id)."</td>                                  
		      <td><input type='submit' value='Save'></td></tr>
		      </form>
		      </table>");
            }
        }else{
            fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
        }


        echo ("</div>");
        exit();
    }
    


?>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="JS/admin_katalog_cities.js"></script>

<?php

    $sql = "SELECT `M`.`id` AS `city_id`,`M`.`name` AS `city`,`W`.`name` AS `woj` FROM `tb_list_miasta` as `M` INNER JOIN `tb_list_wojewodstwa` AS `W` ON `M`.`woj_id` = `W`.`id` ORDER BY `M`.`name`";
    if($result = $mysqli->query($sql)) {
        if($result->num_rows > 0){

            echo ("<div style='max-width: 800px; margin: 20px;'><table id=\"citiesTable\" class=\"cell-border compact stripe\"><thead><tr><th align='left' >ID</th>
            <th align='left' ><input id=\"citySearch\" placeholder=\"MIASTO\" class=\"form-control\" /></th>
            <th align='left' class='select-filter'>WOJEWODSTWO</th></tr></thead><tbody>");

            while ($row = $result->fetch_object()) {
                echo ("<tr><td>$row->city_id</td><td>$row->city</td><td>$row->woj</td></tr>");
            }

            echo ("</tbody>
                    <tfoot><tr><th></th>
                    <th></th><th align='left'></th></tr></tfoot>
                    </table></div>");
        }else{fn_show_report("Nie ma danych");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
}
//--------------------CITIES>-----------------------------------

if($_GET['sel'] == "sety"){

?>
<script type="text/javascript" src="JS/admin_katalog_sety.js"></script>
<script type="text/javascript" src="JS/window_list.js"></script>
<?php
    //if(isset())
/*
    echo ("<pre>");
    print_r($_POST);
    echo ("</pre>");

    echo ("<pre>");
    print_r($_GET);
    echo ("</pre>");
*/

if(isset($_POST['rasa_id'])){
   $rasa_id_value = $_POST['rasa_id'];
   $rasa_name_value = fn_get_rasa_name($_POST['rasa_id']);
}else{
    $rasa_id_value = ""; $rasa_name_value = "";
}
    //echo ("<script type=\"text/javascript\" src=\"JS/admin_katalog_sety.js\"></script>");

    echo ("<div style='max-width: 800px; margin: 20px;'>");
    //ADD SET OF (RASA+COLOR) LINE FORM
    echo ("<table width=\"800px\" border=\"0\">
                        <form action=\"?action=katalog&sel=sety\" method=\"POST\">
                        <input id='inputRasaID' type='hidden' name='rasa_id' size='35' value='$rasa_id_value'>
                        <input id='inputColorID' type='hidden' name='color_id' size='35' value=''>
                        <tr align='center'>
                        <td><input id='submitLista' type='submit' value='POKAŻ' disabled></td>
		                
		                <td><input id='inputRasa' onkeyup=\"activateButtons()\" type='text' name='rasa_name' style=\"width:100%\" value='$rasa_name_value' readonly></td>
		                <td style=\"padding: 5px;\"><img src=\"/img/list.png\" onclick=\"window_rasy();\" disabled></td>
		                
		                <td><input id='inputColor' onkeyup=\"activateButtons()\" type='text' name='color_name' style=\"width:100%\" readonly></td>
		                <td style=\"padding: 5px;\"><img src=\"/img/list.png\" onclick=\"window_colors(1);\"></td>
		                
		                <td><input id='submitAdd' type='submit' value='DODAJ NOWY SET' name='add' disabled></td></tr>
		      </form>
		      </table><BR>");

    if(isset($_POST['rasa_id']))
    {
        if(is_numeric($_POST['rasa_id'])){

            if(isset($_POST['colors_to_delete'])){
                fn_delete_colors_from_set($_POST['rasa_id'], $_POST['colors_to_delete']);
            }

            if(isset($_POST['add']) AND isset($_POST['color_id'])){
                fn_insert_color_to_set($_POST['rasa_id'], $_POST['color_id']);
                //fn_show_report("FN INSERTED rasaID:".$_POST['rasa_id']." AND COLORID:".$_POST['color_id']);
            }




            $sql = "SELECT `tb_list_kolory`.`name` as `kolorname`, `tb_list_sets`.`id_kolory` as `kolorid`
                    FROM `tb_list_kolory`
                    INNER JOIN `tb_list_sets`
                    ON `tb_list_sets`.`id_kolory` = `tb_list_kolory`.`id`
                    WHERE `tb_list_sets`.`id_rasy` = '".$_POST['rasa_id']."'";

            if($result = $mysqli->query($sql)) {

                    echo ("<BR>
                        <form action=\"?action=katalog&sel=sety\" method=\"POST\">
                        <input type=\"hidden\" name=\"rasa_id\" value = '".$_POST['rasa_id']."'>
                        <table border=\"0\" class=\"standartTable\">
                        <tr><th>Umaszczenia dla tej rasy:</th><th><input type='submit' value='Usuń wybrane' name='delete'></th></tr>");

                    while ($row = $result->fetch_object()) {
                        echo ("<tr><td>$row->kolorname</td><td><input type=\"checkbox\" name='colors_to_delete[]' value=\"$row->kolorid\"></td></tr>");
                    }

                    echo ("</table></form>");

            }
        }
        exit();
    }
   

//-------<SETS LIST------------
?>
<link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
<script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
        $('#setsTable').DataTable();
    } );
</script>
<?php

    $sql = "SELECT DISTINCT(`id_rasy`) FROM `tb_list_sets` ORDER BY `id_rasy`";
    if($result = $mysqli->query($sql)) {
        if($result->num_rows > 0){
            echo ("<div style='max-width: 800px; margin: 0px;'><table id=\"setsTable\" class=\"cell-border compact stripe\">
                    <thead><tr><th>SETY</th></tr></thead><tbody>");
                while ($row = $result->fetch_object()) {
                    $rasa_name_value = fn_get_rasa_name($row->id_rasy);
                    echo ("<tr><td ondblclick=\"setRasaValue('$row->id_rasy', '$rasa_name_value')\">$rasa_name_value</td></tr>");
                }
            echo ("</tbody></table></div>");
        }else{fn_show_report("Nie ma SETÓW");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}


//-------SETS LIST>------------

 echo ("</div>");
}

function fn_delete_colors_from_set($rasa_id, $arr_kolors_to_delete)
{
    global $mysqli;

    if(!is_array($arr_kolors_to_delete) OR !is_numeric($rasa_id)){return false;}

    $sql = "DELETE FROM `tb_list_sets` WHERE `id_rasy` = '$rasa_id' AND `id_kolory` IN (". implode(',', $arr_kolors_to_delete) .")";

    if(!$mysqli->query($sql)) { echo $sql."<BR>".$mysqli->error;}

    //echo $sql;
}

function fn_insert_color_to_set($rasa_id, $colorId)
{
    global $mysqli;
    if(!is_numeric($rasa_id) OR !is_numeric($colorId)){return false;}

    $sql = "INSERT INTO `tb_list_sets` (`id_rasy`,`id_kolory`)VALUES('$rasa_id','$colorId')";
    if($mysqli->query($sql)) {
        return True;
    }

    return false;
}

function fn_get_rasa_name($rasa_id)
{
    global $mysqli;
    if(is_numeric($rasa_id)){
        $sql = "SELECT `name` FROM `tb_list_rasy` WHERE `id` = '$rasa_id' LIMIT 1";
        if($result = $mysqli->query($sql)) {
            return $result->fetch_object()->name;
        }
    }
    return "";
}

function fn_update_rasa($rasa_id,$nazwaRasy, $selectGrupa)
{
    global $mysqli;
    $nazwaRasy = trim(addslashes(stripslashes($nazwaRasy)));
    if(is_numeric($rasa_id) AND is_numeric($selectGrupa)){
        $sql = "UPDATE `tb_list_rasy` SET `name` = '$nazwaRasy', `grupa` = '$selectGrupa' WHERE `id` = '$rasa_id' LIMIT 1";
        if($mysqli->query($sql)) {
            return "Zmiany zostały zachowany";
        }
    }
    return "Zmiany nie udało się zachować.";
}

function fn_insert_new_rasa($nazwaRasy, $selectGrupa)
{
    global $mysqli;
    $nazwaRasy = trim(addslashes(stripslashes($nazwaRasy)));
    if(is_numeric($selectGrupa)){
        $sql = "INSERT INTO `tb_list_rasy` (`name`,`grupa`)VALUES('$nazwaRasy','$selectGrupa')";
        if($mysqli->query($sql)) {
            return "Nowa rasa została dodana";
        }
    }
    return "Zmiany nie udało się zachować.";
}

function fn_update_color($color_id,$color_name)
{
    global $mysqli;
    $color_name = trim(addslashes(stripslashes($color_name)));
    if(is_numeric($color_id)){
        $sql = "UPDATE `tb_list_kolory` SET `name` = '$color_name' WHERE `id` = '$color_id' LIMIT 1";
        if($mysqli->query($sql)) {
            return "Zmiany zostały zachowany";
        }
    }
    return "Zmiany nie udało się zachować.";
}

function fn_insert_new_color($newColorName)
{
    global $mysqli;
    $newColorName = trim(addslashes(stripslashes($newColorName)));

    $sql = "INSERT INTO `tb_list_kolory` (`name`)VALUES('$newColorName')";
    if($mysqli->query($sql)) {
        return "Nowe umaszczenie zostało dodane";
    }

    return "Zmiany nie udało się zachować.";
}

function fn_show_select_wojewodstwa ($woj_id)
{
	global $mysqli;
	
	$res = "<select name='selectWojedodstwo'>";
	
	$sql = "SELECT * FROM `tb_list_wojewodstwa` ORDER BY `id`";
	if($result = $mysqli->query($sql)) {
        while ($row = $result->fetch_object()) {
        	if($woj_id == $row->id){$selected = "selected";}else{$selected = "";}
        	$res .= "<option $selected value=\"$row->id\">$row->name</option>";
        }
    }
    $res = "</select>";
}
?>