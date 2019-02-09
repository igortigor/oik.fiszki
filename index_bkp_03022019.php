<?php
session_start();
/*
echo ("<pre>");
print_r($_POST);
echo ("</pre>");
*/
define("MAIN_FILE", TRUE);


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

if($_SESSION["role"] == 3) {//admin
    $main_php_file = "panel_admin.php";

    $arr_menu['accounts'] = array("act_class" => "", "post_name" => "accounts", "menu_name" => "Konta");
    $arr_menu['admins'] = array("act_class" => "", "post_name" => "admins", "menu_name" => "Administratory");
    $arr_menu['waiting'] = array("act_class" => "", "post_name" => "waiting", "menu_name" => "Oczekujące organizatory ".fn_waiting_orgs_cnt_span());
    $arr_menu['katalog'] = array("act_class" => "", "post_name" => "katalog", "menu_name" => "Katalog");

}elseif($_SESSION["role"] == 2){//organizer
    $main_php_file = "panel_organizer.php";

}else{//role=1 - user
    $main_php_file = "panel_user.php";

    $arr_menu['dogs'] = array("act_class" => "", "post_name" => "dogs", "menu_name" => "Psy");
    $arr_menu['shows'] = array("act_class" => "", "post_name" => "shows", "menu_name" => "Wystawy");
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
<body>

<div class="topnav">
    <?php
    foreach ($arr_menu as $key => $arr_value){
        echo ("<a ".$arr_value['act_class']." href=\"?action=$key\">".$arr_value['menu_name']."</a>");
    }

    ?>
    
  <div class="subnav">
    <button class="subnavbtn">About :</button>
    <div class="subnav-content">
      <a href="#company">Company</a>
      <a href="#team">Team</a>
      <a href="#careers">Careers</a>
    </div>
  </div> 

    <div class="login-container">
        <form action="action.php" method="post">
            <input type="hidden" name="action" value="logout">
            <button type="submit">Logout</button>
        </form>
    </div>
</div>



<?php

if(isset($main_php_file) AND file_exists($main_php_file)){include($main_php_file);}
?>
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

function fn_show_report($msg)
{
    echo "<div style=\"padding-left:16px\">
                <h2>Raport:</h2>
                    <p>$msg</p></div>";
}

function fn_waiting_orgs_cnt_span()
{
    global $mysqli;

    $sql = "SELECT count(*) as `cnt` FROM `tb_users` WHERE `role` = 2 AND `org_comfirmed` = 0";
    if($result = $mysqli->query($sql)){
        $cnt = $result->fetch_object()->cnt;
        if($cnt > 0){
        	
        		if( $_GET['action'] == "waiting" AND isset($_POST['user_id'])){$cnt--;}

            return "<span class=\"w3-badge w3-red\">$cnt</span>";
        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    //return "<span class=\"w3-badge w3-red\">5</span>";//tmp test

    return "";
}
?>