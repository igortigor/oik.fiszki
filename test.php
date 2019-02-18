<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
if(!isset($_GET['email'])){exit();}

exit();

include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__, __FILE__ ); exit();}
$mysqli->query("SET NAMES utf8");



$sql = "SELECT * FROM `tb_tmp_poczta`";

    if(!$result = $mysqli->query($sql)) { echo $sql."\r\n".$mysqli->error; exit();}

    while ($row = $result->fetch_object()) {
    	
    	$address = $row->adres;
    	if($ulica = preg_replace("/ od .*$/", "", $address)){
    		$ulica = preg_replace("/ [0-9].*$/", "", $ulica);
    		$ulica = trim(addslashes(stripslashes($ulica)));
    		fm_update($row->id, $ulica);
    	}


    ///\&time=.*$/
    }


exit();

function fm_update($id, $ulica)
{
	global $mysqli;
	
	$sql = "UPDATE `tb_tmp_poczta` SET `ulica` = '$ulica' WHERE `id` = '$id' LIMIT 1";
	if(!$mysqli->query($sql)) { echo $sql."\r\n".$mysqli->error; exit();}
}



?>