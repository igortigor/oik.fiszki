<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <!-- <script type="text/javascript" src="JS/window_list.js"></script> -->
    <script type="text/javascript" src="JS/admin_katalog_rasy.js"></script>
</head>

<body>
<?php
include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__, __FILE__ ); exit();}
$mysqli->query("SET NAMES utf8");

$sql = "SELECT `id`, `name`, `grupa` FROM `tb_list_rasy` ORDER BY `id`";
if($result = $mysqli->query($sql)) {
    if($result->num_rows > 0){
        echo ("<div style='max-width: 800px; margin: 20px;'><table id=\"rasyTable\" class=\"cell-border compact stripe\">
<thead><tr><th>Nazwa</th><th>Grupa</th><th></th></tr></thead><tbody>");

            while ($row = $result->fetch_object()) {
                if($row->grupa == 0){$grupa = "Rasy nieuznane przez FCI";}else{$grupa = "Grupa ".$row->grupa;}
                echo ("<tr>
                        <td>$row->name</td>
                        <td>$grupa</td>
                        <td align=\"right\">
                            <a onclick=\"window.opener.select_rasa('$row->id','$row->name');\" style=\"cursor: pointer;\">
                                <img border=\"0\" src=\"/img/add.png\" />
                            </a>
                        </td>
                      </tr>");
            }

            echo ("</tbody>
            <tfoot><tr><th align='left'></th><th>Grupa</th><th></th></tr></tfoot>
            </table></div>");
    }else{fn_show_report("Nie ma danych");}
}else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
?>
</body>
</html>
