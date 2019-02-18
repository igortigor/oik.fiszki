<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
if(!isset($_GET['start'])){exit();}

exit();

include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__, __FILE__ ); exit();}
$mysqli->query("SET NAMES utf8");

$i = 1;

while($i < 300){
	$arr_user = fn_generate_one();
	$name = $arr_user['name'];
	$surname = $arr_user['surname'];
	$adres = trim(addslashes(stripslashes(generate_adres())));
	$mail = "user_rand_".$i."@poczta.pl";
	$phone = "73153".rand(1000, 9999);
	//echo $i." ".$arr_user['name']." ".$arr_user['surname']." ".generate_adres()."<BR>";
	
	$sql = "INSERT INTO `tb_users` (`name`, `surname`, `adres`, `email`, `phone`,`reg_datetime`, `role`, `email_comfirmed`) VALUES
('$name', '$surname', '$adres', '$mail', '$phone','2019-02-18 11:00:00', 1, 1);";
	if(!$mysqli->query($sql)){
		echo $mysqli->error."<BR>".$sql;
		exit();
	}
	$i++;
}


exit();

function fn_generate_one()
{
	global $mysqli;
	
	$rand_gender_id = rand(1, 1000);
	$rand_name_id = rand(1, 50);
	$rand_lastname_id = rand(1, 94);
	
	if ($rand_gender_id%2 == 0){$gender = "f"; $tablename = "tb_tmp_name_first_female";}else{$gender = "m"; $tablename = "tb_tmp_name_first_male";}

	if(!$res['name'] = fn_get_name_from_list($tablename, $rand_name_id) ){echo "0 rows of from ".$tablename." with id ".$rand_name_id; exit();}
	
	if(!$res['surname'] = fn_get_name_from_list("tb_tmp_name_last_all", $rand_name_id) ){echo "0 rows of from tb_tmp_name_last_all with id ".$rand_name_id; exit();}
	
	if($gender == "f"){
		
		$length = strlen($res['surname']);
		
		$res['surname'] = preg_replace("/ski$/", "ska", $res['surname']);
		
		if(strlen($res['surname']) == $length){preg_replace("/cki$/", "cka", $res['surname']);}
		
		if(strlen($res['surname']) == $length){preg_replace("/dzki$/", "dzka", $res['surname']);}
	}
	
	return $res;
}

function fn_get_name_from_list($tablename, $id)
{
    global $mysqli;

    $sql = "SELECT `name` FROM `$tablename` WHERE `id` = '$id' LIMIT 1";
    if($result = $mysqli->query($sql)){
        if($result->num_rows == 1){
            return $result->fetch_object()->name;
        }
    }else{echo $mysqli->error."<BR>".$sql;}

    return false;
}

function generate_adres()
{
	global $mysqli;
	
	$rand_id = rand(1, 36886);
	
	$rand_dom = rand(1, 100);
	$rand_m = rand(1, 20);
	
	$sql = "SELECT * FROM `tb_tmp_poczta` WHERE `id` = '$rand_id' LIMIT 1";
    if($result = $mysqli->query($sql)){
        if($row = $result->fetch_object()){
            
            return $row->ulica." ".$rand_dom."/".$rand_m." ".$row->kod_pocztowy." ".$row->city;
            
        }
    }else{echo $mysqli->error."<BR>".$sql;}
	
    echo "some error. rows=0 ".$sql; exit();
}

?>