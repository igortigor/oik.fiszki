<?php
if(!defined("MAIN_FILE")) die;
if(defined("SHOW_FILENAME")) fn_show_report(basename(__FILE__));


if(isset($_POST['user_id']) AND isset($_POST['select_new_role'])){
    fn_new_role_fore_id($_POST['user_id'], $_POST['select_new_role']);
}

if(isset($_POST['user_id']) AND isset($_POST['new_pass'])){
    fn_new_password_fore_id($_POST['user_id'], $_POST['new_pass']);
}


//Show user info by row click at accounts list
if(isset($_POST['user_id']))
{
    $sql = "SELECT * FROM `tb_users` WHERE `id` = '".$_POST['user_id']."' LIMIT 1";
    if($result = $mysqli->query($sql))
    {
        if($row = $result->fetch_object())
        {
            echo ("<div style=\"overflow-x:auto;\">
  			<table class=\"accountInfo\">
    		<tr><th style=\"width: 30%;\">Imię:</th><td style=\"width: 70%;\">$row->name</td></tr>
    		<tr><th>Nazwisko:</th><td>$row->surname</td></tr>
    		<tr><th>Email:</th><td>$row->email</td></tr>
    		<tr><th>Telefon:</th><td>$row->phone</td></tr>
    		<tr><th>Rejestracja:</th><td>$row->reg_datetime</td></tr>
    		<tr><th>Rola:</th><td onDblclick=\"showMoreOptions('hidden_tr_rola')\">".fn_get_role_from_id($row->role)."</td>
                ".fn_get_block_tr($row->id, $row->is_blocked)."
    		<tr><td id='moreOptions' colspan='2' onDblclick=\"showMoreOptions('hidden_tr_haslo')\">Zmiana hasła</td></tr>
    		
    		<tr id=\"hidden_tr_rola\" style=\"display: none;\">
    		    <td id='moreOptions' colspan='2'>
                    <form action=\"?action=showUserInfo\" method=\"POST\">
                        <input type=hidden name=user_id value=$row->id>
                        <select name='select_new_role'>
                         <option value=\"1\">Uczestnik</option>
                         <option value=\"2\">Organizator</option>
                         <option value=\"3\">Administrator</option>
                        </select>
                        <input type='submit' value='zatwierdz'>
                    </form>
    		    </td>
    		</tr>
    		
    		<tr id=\"hidden_tr_haslo\" style=\"display: none;\">
    		    <td id='moreOptions' colspan='2'>
                    <form action=\"?action=showUserInfo\" method=\"POST\">
                        <input type='hidden' name='user_id' value='$row->id'>
                        <input type='text' name='new_pass' value='".fn_generate_password(12)."'>
                        <input type='submit' value='zatwierdz'>
                    </form>
                </td>
    		</tr>
    		
    		</table></div>");

        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
}

function fn_get_block_tr($user_id, $is_blocked)
{
    $form_id = "formToSubmit_".$user_id;

    if($is_blocked == 1){
        $th_text = "Odblokować"; $td_text = "Zablokowany"; $bgcolor = "#ff3300";
    }else{
        $th_text = "Zablokować"; $td_text = "OK"; $bgcolor = "#99ff99";
    }

    $tr = ("<tr>
            <th onDblclick=\"submitFormId('$form_id')\">$th_text
                <form id = $form_id action=\"?action=showUserInfo\" method=\"POST\">
			    <input type=hidden name=user_id_to_block value=$user_id>
			    <input type=hidden name=is_blocked value=$is_blocked>
			    </form></th>
			<td bgcolor=\"$bgcolor\" >$td_text</td>
    		</tr>");

    return $tr;
}
?>