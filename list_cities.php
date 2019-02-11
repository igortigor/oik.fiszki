<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="libs/DataTables/datatables.min.css"/>
    <script type="text/javascript" src="libs/DataTables/datatables.min.js"></script>
    <!-- <script type="text/javascript" src="JS/window_list.js"></script> -->
    <script type="text/javascript" src="JS/window_list_cities.js"></script>
</head>

<body>
<?php
if(!isset($_GET['show'])){ exit();}
include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__, __FILE__ ); exit();}
$mysqli->query("SET NAMES utf8");



    $sql = "SELECT `M`.`id` AS `city_id`,`M`.`name` AS `city`,`W`.`name` AS `woj` FROM `tb_list_miasta` as `M` INNER JOIN `tb_list_wojewodstwa` AS `W` ON `M`.`woj_id` = `W`.`id` ORDER BY `M`.`name`";
    if($result = $mysqli->query($sql)) {
        if($result->num_rows > 0){

            echo ("<div style='max-width: 800px; margin: 20px;'><table id=\"citiesTable\" class=\"cell-border compact stripe\"><thead><tr>
            <th align='left' ><input id=\"citySearch\" placeholder=\"MIASTO\" class=\"form-control\" /></th>
            <th align='left' class='select-filter'>WOJEWODSTWO</th></tr></thead><tbody>");

            while ($row = $result->fetch_object()) {
                echo ("<tr ondblclick=\"window.opener.setCityValue('$row->city_id','$row->city');\" ><td>$row->city</td><td>$row->woj</td></tr>");
            }

            echo ("</tbody>
                    <tfoot><tr>
                    <th></th><th align='left'></th></tr></tfoot>
                    </table></div>");
        }else{fn_show_report("Nie ma danych");}
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}


?>
</body>
</html>
