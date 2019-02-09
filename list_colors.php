<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <script type="text/javascript" src="JS/admin_katalog_colors.js"></script>
</head>

<body>
<?php
if(!isset($_GET['rasa_id'])){ fn_show_report("Trzeba najpierw wybrać rasę"); exit();}

include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__, __FILE__ ); exit();}
$mysqli->query("SET NAMES utf8");

if( isset($_GET['show']) AND $arr_colorIds = fn_get_colors_for_this_rasa($_GET['rasa_id'])){
    $sql = "SELECT `id`, `name` FROM `tb_list_kolory` 
            WHERE `id` IN (".implode(',',$arr_colorIds).")
            ORDER BY `id`";
}else{
    $sql = "SELECT `id`, `name` FROM `tb_list_kolory` ORDER BY `id`";
}

if($result = $mysqli->query($sql)) {
    if($result->num_rows > 0){
        echo ("<div style='max-width: 800px; margin: 20px;'><table id=\"colorsTable\" class=\"cell-border compact stripe\">
<thead><tr><th>Nazwa umaszczenia</th><th></th></tr></thead><tbody>");

        while ($row = $result->fetch_object()) {

            echo ("<tr>
                    <td>$row->name</td>
                      <td align=\"right\">
                        <a onclick=\"window.opener.select_color('$row->id','$row->name');\" style=\"cursor: pointer;\">
                            <img border=\"0\" src=\"/img/add.png\" />
                        </a>
                    </td>
                  </tr>");
        }

        echo ("</tbody>
            </table></div>");
    }else{fn_show_report("Nie ma danych");}
}else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

function fn_get_colors_for_this_rasa($rasa_id)
{
    global $mysqli;

    $sql = "SELECT `id_kolory` FROM `tb_list_sets` WHERE `id_rasy` = '$rasa_id'";
        if($result = $mysqli->query($sql)) {
            if($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    $arr_colors[] = $row->id_kolory;
                }
                return $arr_colors;
            }
        }
return false;
}
?>
</body>
</html>