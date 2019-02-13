<?php
if(!defined("MAIN_FILE")) die;
if(!isset($_POST['info_member_id']) OR !is_numeric($_POST['info_member_id']) OR !isset($_POST['show_id']) OR !is_numeric($_POST['show_id'])){exit();}

$show_id = $_POST['show_id']; $dog_id = $_POST['info_member_id'];

if(isset($_POST['payment_state'])){
	fn_change_payment_state($show_id, $dog_id);
}

if(isset($_POST['comment'])){
	fn_change_comment($show_id, $dog_id, $_POST['comment']);
}

//dane zgłoszenia
if(!$arr_member_info = fn_get_member_info($show_id, $dog_id)){fn_err_write("error: Nie można pobrać member info dla show_id=$show_id AND dog_id=$dog_id", __LINE__, __FILE__); exit();}
if($arr_member_info['is_payed'] == 1){$oplata_text = "OPŁACONO"; $oplata_color = "green"; $sel_0=""; $sel_1="selected";}else{$oplata_text = "NIEOPŁACONO"; $oplata_color = "red"; $sel_0="selected"; $sel_1=""; $arr_member_info['payment_datetime']="";}

$comment = $arr_member_info['comment'];

$payment_form = "<form action=\"?action=wystawy\" method=\"POST\" id=\"paymentForm\">
<input type='hidden' name='show_id' value='$show_id'>
<input type='hidden' name='info_member_id' value='$dog_id'>
<select name='payment_state' onchange='submitFormId(\"paymentForm\");'><option value='0' $sel_0>NIEOPŁACONO</option><option value='1' $sel_1>OPŁACONO</option></select>
</form>";

$comment_form = "<form action=\"?action=wystawy\" method=\"POST\" id=\"commentForm\">
<input type='hidden' name='show_id' value='$show_id'>
<input type='hidden' name='info_member_id' value='$dog_id'>
<input type='text' name='comment' size='50' value='$comment'>
<input type='submit' name='save_comment' value='SAVE COMMENT'>
</form>";

?>
<table class="standartTable">
<thead><tr>
	<th colspan="2">Dane zgłoszenia</th>
</tr></thead>
<tr>
    <td align="right" width="50%">Data zgłoszenia: </td>
    <td><?=$arr_member_info['in_datetime']?></td>
</tr>
<tr>
    <td align="right" width="50%">Klasa: </td>
    <td><?=fn_get_name_from_list("tb_list_klasy", $arr_member_info['klasa_id'])?></td>
</tr>
<tr>
    <td align="right">Opłata: <?=$arr_member_info['payment_datetime']?></td>
    <td ondblclick="toggle_hidden('selectPaymentForm'); toggle_hidden('selectPaymentText');" bgcolor="<?=$oplata_color?>">
    	<div id='selectPaymentText'><?=$oplata_text?></div>
    	<div id='selectPaymentForm' hidden><?=$payment_form?></div>
    </td>
</tr>
<tr>
    <td align="right">Komentarz: </td>
    <td ondblclick="toggle_hidden('divCommentForm'); toggle_hidden('divCommentText');" >
    	<div id='divCommentText'><?=$arr_member_info['comment']?></div>
    	<div id='divCommentForm' hidden><?=$comment_form?></div>
    </td>
</tr>
</table>
<?php

//dane psa
if(!$arr_dog_details = fn_get_dog_details($dog_id)){fn_show_report("Nieznany pies"); exit();}
if($arr_dog_details['rodowod_preparing']){$rodowód = "W przygotowaniu";}else{$rodowód = $arr_dog_details['rodowod'];}
?>
<br>
<table class="standartTable">
<thead><tr>
	<th colspan="2">Dane psa</th>
</tr></thead>
<tr>
    <td align="right" width="50%">Nazwa_przydomek:</td>
    <td><?=$arr_dog_details['nazwa_przydomek']?></td>
</tr>
<tr>
    <td align="right">PŁEĆ:</td>
    <td><?=$arr_dog_details['sex']?></td>
</tr>
<tr>
    <td align="right">Rodowód:</td>
    <td><?=$rodowód?></td>
</tr>
<tr>
    <td align="right">Chip:</td>
    <td><?=$arr_dog_details['chip_nr']?></td>
</tr>
<tr>
    <td align="right">Rasa:</td>
    <td><?=fn_get_name_from_list("tb_list_rasy", $arr_dog_details['rasa_id'])?></td>
</tr>
<tr>
    <td align="right">Umaszczenie:</td>
    <td><?=fn_get_name_from_list("tb_list_kolory", $arr_dog_details['color_id'])?></td>
</tr>
<tr>
	<?=fn_select_tytuly_selected($arr_dog_details['tytuly'])?>
</tr>
<tr>
    <td align="right">Tata:</td>
    <td><?=$arr_dog_details['tata_name']?></td>
</tr>
<tr>
    <td align="right">Mama:</td>
    <td><?=$arr_dog_details['mama_name']?></td>
</tr>
<tr>
    <td align="right">Hodowca:</td>
    <td><?=$arr_dog_details['hodowca']?></td>
</tr>
<tr>
    <td align="right">Współwłaściciel:</td>
    <td><?=$arr_dog_details['coowner']?></td>
</tr>
</table>

<?php

//dane właściciela
if(!$arr_user_details = fn_get_user_details()){fn_show_report("Nieznany właściciel"); exit();}
?>
<br>
<table class="standartTable">
<thead><tr>
	<th colspan="2">Dane właściciela</th>
</tr></thead>
<tr>
    <td align="right" width="50%">Imie:</td>
    <td><?=$arr_user_details['name']?></td>
</tr>
<tr>
    <td align="right">Nazwisko:</td>
    <td><?=$arr_user_details['surname']?></td>
</tr>
<tr>
    <td align="right">Adres:</td>
    <td><?=$arr_user_details['adres']?></td>
</tr>

<tr>
    <td align="right">EMAIL:</td>
    <td><?=$arr_user_details['email']?></td>
</tr>
<tr>
    <td align="right">TELEFON:</td>
    <td><?=$arr_user_details['phone']?></td>
</tr>
<tr>
    <td align="right">WWW:</td>
    <td><?=$arr_user_details['www']?></td>
</tr>
</table>
<?php

exit();

if(isset($_POST['newName'])){
	if(!$_POST['show_id'] = fn_create_show($_POST['newName'], $arr_user_details['id'])){
		fn_show_report("Nie udało się stworzyć wystawę.");
		unset($_POST['show_id']);
	}
}

function fn_get_member_info($show_id, $dog_id)
{
	global $mysqli;

    $sql = "SELECT * FROM `tb_wystawy_uczestnicy` WHERE `show_id` = '$show_id' AND `dog_id` = '$dog_id' LIMIT 1";
    if($result = $mysqli->query($sql)){
        if($result->num_rows == 1){
            return $result->fetch_assoc();
        }
    }else{fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}

    return false;		
}

function fn_change_payment_state($show_id, $dog_id)
{
	global $mysqli;
	$sql = "UPDATE `tb_wystawy_uczestnicy` SET `is_payed` = !`is_payed`, `payment_datetime`='".date("Y-m-d H:i:s")."' WHERE `show_id`='$show_id' AND `dog_id`='$dog_id' LIMIT 1";
	
	if(!$mysqli->query($sql)){fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
}

function fn_change_comment($show_id, $dog_id, $comment)
{
	global $mysqli;
	$sql = "UPDATE `tb_wystawy_uczestnicy` SET `comment`='".trim(addslashes(stripslashes($comment)))."' WHERE `show_id`='$show_id' AND `dog_id`='$dog_id' LIMIT 1";
	
	if(!$mysqli->query($sql)){fn_err_write("mysql_error: ".$mysqli->error. "($sql)", __LINE__, __FILE__);}
}
?>