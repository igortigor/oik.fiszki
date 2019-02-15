<?php
if(!defined("MAIN_FILE")) die;

fn_show_report("user_details.php ".$_SESSION["email"]);

if(isset($_POST['update_user_info']) AND isset($_POST['user_id']) AND is_numeric($_POST['user_id']))
{
    if(isset($_POST['name'])){$name = trim(addslashes(stripslashes($_POST['name'])));}else{$name="";}
    if(isset($_POST['surname'])){$surname = trim(addslashes(stripslashes($_POST['surname'])));}else{$surname="";}
    if(isset($_POST['phone'])){$phone = trim(addslashes(stripslashes($_POST['phone'])));}else{$phone="";}
    if(isset($_POST['adres'])){$adres = trim(addslashes(stripslashes($_POST['adres'])));}else{$adres="";}
    if(isset($_POST['www'])){$www = trim(addslashes(stripslashes($_POST['www'])));}else{$www="";}

    $user_id = $_POST['user_id'];

    $sql = "UPDATE `tb_users` SET `name` = '$name', `surname` = '$surname', `phone` = '$phone', `adres` = '$adres', `www` = '$www' WHERE `id` = '$user_id' LIMIT 1";

    if(!$mysqli->query($sql)){
        fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
        fn_show_report("Database Error.");
    }
    else{fn_show_report("Wszystkie zmiane zostały wprowadzone do bazy.");}

}

if(isset($_POST['user_id']) AND isset($_POST['new_pass'])){
    fn_new_password_fore_id($_POST['user_id'], $_POST['new_pass']);
    fn_show_report("Hasło zostało zmienione");
}



$sql = "SELECT * FROM `tb_users` WHERE `email` = '".$_SESSION["email"]."' LIMIT 1";
if($result = $mysqli->query($sql))
{
    if($row = $result->fetch_object())
    {
        echo ("<div style=\"overflow-x:auto;\">
        <table class=\"accountInfo\">
        <form action=\"?action=home\" method=\"POST\">
        <tr><th style=\"width: 30%;\">Imie:</th><td style=\"width: 70%;\">
            <input id='infoName' type='text' name='name' value='$row->name' readonly size='50'>
        </td></tr>
        <tr><th>Nazwisko:</th><td>
            <input id='infoSurame' type='text' name='surname' value='$row->surname' readonly size='50'>
        </td></tr>
        <tr><th>Email:</th><td>
            <input type='text' name='email' value='$row->email' readonly size='50'>
        </td></tr>
        <tr><th>Telefon:</th><td>
            <input id='infoPhone' type='text' name='phone' value='$row->phone' readonly size='50'>
        </td></tr>
        <tr><th>Adres:</th><td>
            <input id='infoAdres' type='text' name='adres' value='$row->adres' readonly size='50'>
        </td></tr>
        <tr><th>WWW:</th><td>
            <input id='infoWeb' type='text' name='www' value='$row->www' readonly size='50'>
        </td></tr>
        <tr><th>Rejestracja:</th><td>
            <input type='text' name='reg_datetime' value='$row->reg_datetime' readonly size='50'>
        </td></tr>
        <tr>
            <td id='tdInfoEdit' onDblclick=\"letEditInfo()\">Edit</td>
            <td onDblclick=\"showMoreOptions('hidden_tr_haslo')\">Hasło</td>
        </tr>
        
        <tr id=\"hidden_tr_submit\" style=\"display: none;\">
            <td colspan='2'><input type='submit' name='update_user_info' value='zatwierdz zmiany'></td>
            <input type='hidden' name='user_id' value='$row->id'>
        </tr>
        </form>
        
        <tr id=\"hidden_tr_haslo\" style=\"display: none;\">
            <td colspan='2'>
                <form action=\"?action=home\" method=\"POST\">
                    <input type='hidden' name='user_id' value='$row->id'>
                    <input type='text' name='new_pass' value='".fn_generate_password(12)."'>
                    <input type='submit' class=\"button\" value='zatwierdz'>
                </form>
            </td>
    	</tr>
       
        </table></div>");

    }else{unset($_SESSION["role"]);}
}else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

?>