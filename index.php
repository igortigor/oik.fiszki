<?php
session_start();
/*
echo ("<pre>");
print_r($_POST);
echo ("</pre>");
*/
define("MAIN_FILE", TRUE);
//define("SHOW_FILENAME", TRUE);

if(!isset($_SESSION["role"])){
    include("login.php");
    exit();
}

date_default_timezone_set('Europe/Warsaw');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__, __FILE__ ); exit();}
$mysqli->query("SET NAMES utf8");

$arr_menu['home'] = array("act_class" => "", "post_name" => "home", "menu_name" => "Dane");

$js_scripts = "";

if($_SESSION["role"] == 3) {
	$role_name = "admin";
    $main_php_file = "panel_admin.php";

    $arr_menu['accounts'] = array("act_class" => "", "post_name" => "accounts", "menu_name" => "Konta");
    $arr_menu['admins'] = array("act_class" => "", "post_name" => "admins", "menu_name" => "Administratorze");
    $arr_menu['waiting'] = array("act_class" => "", "post_name" => "waiting", "menu_name" => "Oczekujące organizatory ".fn_waiting_orgs_cnt_span());
    //$arr_menu['katalog'] = array("act_class" => "", "post_name" => "katalog", "menu_name" => "Katalog");
    $arr_menu['katalog'] = array("act_class" => "", "post_name" => "katalog", "sub_menu_name" => "Katalog :", "sub_menu_arr" => array("Rasy" => "action=katalog&sel=rasy", "Umaszczenia" => "action=katalog&sel=colors", "Miasta" => "action=katalog&sel=cities", "Sety" => "action=katalog&sel=sety"));
    $arr_menu['dogs'] = array("act_class" => "", "post_name" => "dogs", "menu_name" => "Psy");

}elseif($_SESSION["role"] == 2){
	$role_name = "organizator";
    $main_php_file = "panel_organizer.php";
    
    $arr_menu['wystawy'] = array("act_class" => "", "post_name" => "wystawy", "menu_name" => "Wystawy");

}else{//role=1 - user
	$role_name = "uczestnik";
    $main_php_file = "panel_user.php";

    //$arr_menu['dogs'] = array("act_class" => "", "post_name" => "dogs", "menu_name" => "Psy");
    $arr_menu['dogs'] = array("act_class" => "", "post_name" => "dogs", "sub_menu_name" => "Psy :", "sub_menu_arr" => array("Moje psy" => "action=dogs&sub=mydogs", "Nowy pies" => "action=dogs&sub=newdog"));
    
    $arr_menu['wystawy'] = array("act_class" => "", "post_name" => "wystawy", "menu_name" => "Wystawy");
}

if(!isset($_GET['action'])){$_GET['action'] = "home";}

if(isset($arr_menu[$_GET['action']])){
    $arr_menu[$_GET['action']]['act_class'] = "class=\"active\"";
}else{
    $arr_menu['home']['act_class'] = "class=\"active\"";
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <?=$js_scripts?>
    <link rel="stylesheet" href="CSS/topnav.css">
    <link rel="stylesheet" href="CSS/account_tables.css">
    <script type="text/javascript" src="/JS/general.js"></script>
</head>
<body onload="showErrMsgs()">

<div class="navbar">
    <?php
    foreach ($arr_menu as $key => $arr_value){
    	
    	if(isset($arr_value['menu_name']))
    	{
    		echo ("<a ".$arr_value['act_class']." href=\"?action=$key\">".$arr_value['menu_name']."</a>");
    	}
    	elseif(isset($arr_value['sub_menu_name']))
    	{
    		if(empty($arr_value['act_class'])){$class_add = "";}else{$class_add = " active";}
    		
    		//echo ("<div class=\"subnav\"><button class=\"subnavbtn".$class_add."\">".$arr_value['sub_menu_name']."</button><div class=\"subnav-content\">");
            echo ("<div class=\"dropdown\"><button class=\"dropbtn".$class_add."\">".$arr_value['sub_menu_name']."</button>
                    <div class=\"dropdown-content\">");

    		foreach ($arr_value['sub_menu_arr'] as $name => $href)
    		{
    			echo ("<a href=\"?$href\">$name</a>");
    		}
    		echo ("</div></div>");
    	}
    }

    ?>

    


    
    <div class="login-container">
        <form action="action.php" method="post">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Logout (<?=$role_name?>)</button>
        </form>
    </div>
</div>
<hr />


<?php
if($_GET['action'] == "home"){
    include("user_details.php");
    exit();
}

if(isset($main_php_file) AND file_exists($main_php_file)){include($main_php_file);}
?>
<ul id="errList"></ul>
</body>
</html>
<?php
exit();

function fn_log_write($msg, $line = "no_line", $file = "")
{
	if(!empty($file)){$file = basename($file);}
    $fp = fopen("logs/action.txt","a");
    fputs($fp,date("Y-m-d H:i:s")."\t".$msg." line: $line file: $file\r\n");
    fclose($fp);
}

function fn_err_write($msg, $line = "no_line", $file = "")
{
	if(!empty($file)){$file = basename($file);}
    $fp = fopen("logs/errors.txt","a");
    fputs($fp,date("Y-m-d H:i:s")."\t".$msg." line: $line file: $file\r\n");
    fclose($fp);
}

function fn_new_password_fore_id($user_id, $new_pass)
{
    global $mysqli;

    $hash = password_hash($new_pass, PASSWORD_DEFAULT);

    $sql = "UPDATE `tb_users` SET `hash` = '$hash', `email_comfirmed` = 1 WHERE `id` = '$user_id' LIMIT 1";
    if($mysqli->query($sql)){
        fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
    }
}

function fn_generate_password($number)
{
    $arr = array('a','b','c','d','e','f',
        'g','h','i','j','k','l',
        'm','n','o','p','r','s',
        't','u','v','x','y','z',
        'A','B','C','D','E','F',
        'G','H','I','J','K','L',
        'M','N','O','P','R','S',
        'T','U','V','X','Y','Z',
        '1','2','3','4','5','6',
        '7','8','9','0');
    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
        $index = rand(0, count($arr) - 1);
        $pass .= $arr[$index];
    }
    return $pass;
}

function fn_show_report_old($msg)
{
    echo "<div class=\"error_msg\">
                    <p>$msg</p></div>";
}

function fn_show_report($msg)
{
    echo "<input hidden class=\"errMsgInput\" value=\"$msg\">";
}


function fn_waiting_orgs_cnt_span()
{
    global $mysqli;

    $sql = "SELECT count(*) as `cnt` FROM `tb_users` WHERE `role` = 2 AND `org_comfirmed` = 0";
    if($result = $mysqli->query($sql)){
        $cnt = $result->fetch_object()->cnt;
        if($cnt > 0){
        	
        		if(isset($_GET['action']) AND $_GET['action'] == "waiting" AND isset($_POST['user_id'])){$cnt--;}

            return "<span class=\"w3-badge w3-red\">$cnt</span>";
        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    //return "<span class=\"w3-badge w3-red\">5</span>";//tmp test

    return "";
}

function fn_get_user_details()
{
    global $mysqli;
    if(isset($_SESSION["email"])){
        $sql = "SELECT * FROM `tb_users` WHERE `email` = '".$_SESSION["email"]."' LIMIT 1";
        if($result = $mysqli->query($sql)){
            if($result->num_rows == 1){
                return $result->fetch_assoc();
            }
        }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
    }
    return false;
}

function fn_get_user_details_from_id($user_id)
{
    global $mysqli;
    if(is_numeric($user_id)){
        $sql = "SELECT * FROM `tb_users` WHERE `id` = '$user_id' LIMIT 1";
        if($result = $mysqli->query($sql)){
            if($result->num_rows == 1){
                return $result->fetch_assoc();
            }
        }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
    }
    return false;
}

function fn_get_row_with_id($tablename, $id)
{
    global $mysqli;
    if(is_numeric($id)){
        $sql = "SELECT * FROM `".trim(addslashes(stripslashes($tablename)))."` WHERE `id` = '$id' LIMIT 1";
        if($result = $mysqli->query($sql)){
            if($result->num_rows == 1){
                return $result->fetch_assoc();
            }
        }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
    }
    return false;
}

function fn_get_color_from_id($color_id)
{
    global $mysqli;

    $sql = "SELECT `name` FROM `tb_list_kolory` WHERE `id` = '$color_id' LIMIT 1";
    if($result = $mysqli->query($sql)){
        if($result->num_rows == 1){
            return $result->fetch_object()->name;
        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return "";
}

function fn_get_rasa_from_id($rasa_id)
{
    global $mysqli;

    $sql = "SELECT `name` FROM `tb_list_rasy` WHERE `id` = '$rasa_id' LIMIT 1";
    if($result = $mysqli->query($sql)){
        if($result->num_rows == 1){
            return $result->fetch_object()->name;
        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return "";
}

function fn_get_city_from_id($city_id)
{
    global $mysqli;

    $sql = "SELECT `name` FROM `tb_list_miasta` WHERE `id` = '$city_id' LIMIT 1";
    if($result = $mysqli->query($sql)){
        if($result->num_rows == 1){
            return $result->fetch_object()->name;
        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return "";
}

function fn_get_name_from_list($tablename, $id)
{
    global $mysqli;

    $sql = "SELECT `name` FROM `$tablename` WHERE `id` = '$id' LIMIT 1";
    if($result = $mysqli->query($sql)){
        if($result->num_rows == 1){
            return $result->fetch_object()->name;
        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return "";
}

function fn_get_dog_details($dog_id)
{
    global $mysqli;

    $sql = "SELECT * FROM `tb_psy` WHERE `id` = '$dog_id' LIMIT 1";
    if($result = $mysqli->query($sql)){
        if($result->num_rows == 1){
            return $result->fetch_assoc();
        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return false;
}

function isValidDate($date, $format= 'Y-m-d'){
	if($date == "0000-00-00"){return true;}
    return $date == date($format, strtotime($date));
}

function fn_select_tytuly_lista($json_tytuly)
{
    global $mysqli;
    $res = "";

    if(!$arr_dog_tytuls = json_decode($json_tytuly)){$arr_dog_tytuls[]="";}
    $arr_dog_tytuls   = array_flip($arr_dog_tytuls);

    $sql = "SELECT * FROM `tb_list_tytuly` WHERE `grupa_id` = 1 ORDER BY `grupa_id`";
    if(!$result = $mysqli->query($sql)) { return $res;}

    $res .= "<td align='center' valign='top'><b>Tytuły:</b>";

    while ($row = $result->fetch_object()) {
    if(isset($arr_dog_tytuls[$row->id])){$res .= "<BR>".$row->tytulname; }
}

    $sql = "SELECT * FROM `tb_list_tytuly` WHERE `grupa_id` = 2 ORDER BY `grupa_id`";
    if(!$result = $mysqli->query($sql)) { return $res;}

    $res .= "</td><td align='center' valign='top'><b>Wyszkolenie:</b>";

    while ($row = $result->fetch_object()) {
        if(isset($arr_dog_tytuls[$row->id])){$res .= "<BR>".$row->tytulname; }
    }

    $res .= "</td>";

    return $res;
}

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
/*
function fn_get_wystawy_details($show_id, $org_id)
{
	global $mysqli;
    if(is_numeric($id) AND is_numeric($org_id)){
        $sql = "SELECT * FROM `tb_wystawy` WHERE `id` = '$id' AND `org_id` = '$org_id' LIMIT 1";
        echo $sql;
        if($result = $mysqli->query($sql)){
            if($result->num_rows == 1){
                return $result->fetch_assoc();
            }
        }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
    }
    return false;
}
*/
?>