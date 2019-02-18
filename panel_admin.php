<?php
if(!defined("MAIN_FILE")) die;
if(defined("SHOW_FILENAME")) fn_show_report(basename(__FILE__));

/*
echo ("<pre>");
print_r($_POST);
echo ("</pre>");

echo ("<pre>");
print_r($_GET);
echo ("</pre>");
*/

if(isset($_POST['user_id_to_block']) AND isset($_POST['is_blocked'])){
    fn_block_user_id($_POST['user_id_to_block'], $_POST['is_blocked']);
    $_POST['user_id'] = $_POST['user_id_to_block'];
}

if($_GET['action'] == "showUserInfo"){
    include_once "panel_admin_user_info.php";
}

//KATALOG
if($_GET['action'] == "katalog"){
    include_once("panel_admin_katalog.php");
}

//PSY
if($_GET['action'] == "dogs"){
    include_once("panel_admin_dogs.php");
}

//accounts list
if($_GET['action'] == "accounts")
{

	echo ("<div style=\"overflow-x:auto;\">
  			<table class=\"standartTable\">
    		<tr><th>Imie</th><th>Nazwisko</th><th>Email</th><th>Telefon</th><th>Rejestracja</th><th>Rola</th></tr>");
	
	$sql = "SELECT * FROM `tb_users` WHERE `role` != 3 ORDER BY `id` DESC";
	if($result = $mysqli->query($sql)){
		while($row = $result->fetch_object())
		{
			echo ("<form id=\"accountRow_$row->id\" action=\"?action=showUserInfo\" method=\"POST\">
			      	<input type=\"hidden\" name=\"user_id\" value = \"$row->id\">
                <tr onDblclick=\"submitFormId('accountRow_$row->id')\">
		      <td>$row->name</td>
		      <td>$row->surname</td>
		      <td>$row->email</td>
		      <td>$row->phone</td>
		      <td>$row->reg_datetime</td>
		      <td>".fn_get_role_from_id($row->role)."</td></tr></form>");
		}
		
		
	}else{
		fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
	}
	

	echo ("</table></div>");
}

//-----------------------------Administratory---------------------------------
if($_GET['action'] == "admins")
{

	echo ("<div style=\"overflow-x:auto;\">
  			<table class=\"standartTable\">
    		<tr><th>Imie</th><th>Nazwisko</th><th>Email</th><th>Telefon</th><th>Rejestracja</th><th>Rola</th></tr>");
	
	$sql = "SELECT * FROM `tb_users` WHERE `role` = 3 ORDER BY `id` DESC";
	if($result = $mysqli->query($sql)){
		while($row = $result->fetch_object())
		{
			echo ("<tr>
		      <td>$row->name</td>
		      <td>$row->surname</td>
		      <td>$row->email</td>
		      <td>$row->phone</td>
		      <td>$row->reg_datetime</td>
		      <td>".fn_get_role_from_id($row->role)."</td></tr>");
		}
		
		
	}else{
		fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
	}
	

	echo ("</table></div>");
}

//---------------------------Oczekujące organizatory------------------------
if($_GET['action'] == "waiting")
{

	if(isset($_POST['user_id']) AND is_numeric($_POST['user_id'])){
		fn_confirm_org_with_id($_POST['user_id']);
		fn_show_report("Organizator został potwierdzony.");
	}
	
	echo ("<div style=\"overflow-x:auto;\">
  			<table id=\"adminTable\" class=\"standartTable\">
    		<tr><th>Imie</th><th>Nazwisko</th><th>Email</th><th>Telefon</th><th>Rejestracja</th><th>Rola</th><th></th></tr>");
	
	$sql = "SELECT * FROM `tb_users` WHERE `role` = 2 AND `org_comfirmed` = 0 ORDER BY `id` DESC";
	if($result = $mysqli->query($sql)){
		while($row = $result->fetch_object())
		{
			echo ("<tr>
		      <td>$row->name</td>
		      <td>$row->surname</td>
		      <td>$row->email</td>
		      <td>$row->phone</td>
		      <td>$row->reg_datetime</td>
		      <td>".fn_get_role_from_id($row->role)."</td>
			      <form id=\"confOrgForm\" action=\"?action=waiting\" method=\"POST\">
			      	<input type=\"hidden\" name=\"user_id\" value = \"$row->id\">
			      	<td bgcolor=\"#FF0000\" id=\"confOrgBtn\" onDblclick=\"submitform()\">Doubleclick to confirm</td>
			      </form>
		      </tr>");
			//<td><form action=\"?action=waiting\"><button class=\"button button5\">Confirm</button></form></td>
		}
		
		
	}else{
		fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
	}
	

	echo ("</table></div>");
}

exit();
function fn_confirm_org_with_id($org_id)
{
	global $mysqli;
	
	$sql = "UPDATE `tb_users` SET `org_comfirmed` = 1 WHERE `id` = '$org_id' LIMIT 1";
	if(!$mysqli->query($sql)){
		fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
	}
}

function fn_get_role_from_id($role_id)
{
	if($role_id== 3){return "Admin";}
	if($role_id== 2){return "Organizator";}
	if($role_id== 1){return "Uczestnik";}
	return "-";
}

function fn_block_user_id($user_id_to_block, $is_blocked)
{
    global $mysqli;

    if($is_blocked == 1){$is_blocked = 0;}else{$is_blocked = 1;}

    $sql = "UPDATE `tb_users` SET `is_blocked` = '$is_blocked' WHERE `id` = '$user_id_to_block' LIMIT 1";
    if($mysqli->query($sql)){
        fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
    }
}

function fn_new_role_fore_id($user_id, $select_new_role)
{
    global $mysqli;
    $sql = "UPDATE `tb_users` SET `role` = '$select_new_role' WHERE `id` = '$user_id' LIMIT 1";
    if($mysqli->query($sql)){
        fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);
    }
}
?>