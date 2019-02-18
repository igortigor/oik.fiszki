<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
if(!isset($_GET['start'])){exit();}


include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__, __FILE__ ); exit();}
$mysqli->query("SET NAMES utf8");

if(!$arr_pies_names = file('TMP/pies.txt')){echo "Something wrong with pies.txt file"; exit();}

if(!$arr_suka_names = file('TMP/suka.txt')){echo "Something wrong with suka.txt file"; exit();}

if(!$arr_przydomek_names = file('TMP/przydomek.txt')){echo "Something wrong with przydomek.txt file"; exit();}

if(!$arr_rasy = fn_get_arr_sety()){echo "Something wrong with get arr rasy"; exit();}

$confirmed_arr = array(1,1,0,1,1,0,1,1,1,1,1,1,0,1,1,0,1,1,0,1,1,1,1,1,0,1,1,1);

/*
echo ("<pre>");
print_r($arr_rasy);
echo ("</pre>");

echo ("<pre>");
print_r($arr_rasy[array_rand($arr_rasy, 1)]);
echo ("</pre>");
*/
$i = 1;
$err_cnt = 0;
while($i < 700){
	
	if ( rand(1, 1000) % 2 == 0){$gender = "S"; $arr_nazwy = $arr_suka_names;}else{$gender = "P"; $arr_nazwy = $arr_pies_names;}
	
	$nazwa_przydomek = $arr_nazwy[array_rand($arr_nazwy, 1)]." ".$arr_przydomek_names[array_rand($arr_przydomek_names, 1)];
	$nazwa_przydomek = trim(addslashes(stripslashes($nazwa_przydomek)));
	
	$rasa_id = array_rand($arr_rasy, 1);
	
	$kolor_id = $arr_rasy[$rasa_id][array_rand($arr_rasy[$rasa_id], 1)];
	
	$tytuly_json = fn_generate_tytuls();
	
	$owner_id = rand(9,307);
	
	$rodowod = fn_generate_rodowod($rasa_id, $owner_id);
	$rodowod = trim(addslashes(stripslashes($rodowod)));
	
	$tataname = $arr_pies_names[array_rand($arr_pies_names, 1)]." ".$arr_przydomek_names[array_rand($arr_przydomek_names, 1)];
	$tataname = trim(addslashes(stripslashes($tataname)));
	
	$mamaname = $arr_suka_names[array_rand($arr_suka_names, 1)]." ".$arr_przydomek_names[array_rand($arr_przydomek_names, 1)];
	$mamaname = trim(addslashes(stripslashes($mamaname)));
	
	$is_conf = $confirmed_arr[array_rand($confirmed_arr, 1)];
	
	$birstday = date("Y-m-d", time()-(60*60*24*(500 + rand(10,2000))));
	
	$chip_nr = rand(1000000000,99999999999);
	
	
	$arr_hodowca = fn_generate_one();
	$hodowca = $arr_hodowca['name']." ".$arr_hodowca['surname'];
	$hodowca = trim(addslashes(stripslashes($hodowca)));
	
	//echo fn_get_name_from_list("tb_list_rasy", $rasa_id)." ".fn_get_name_from_list("tb_list_kolory", $kolor_id)." ".$tytuly_json."<BR>";
	
	
	$sql = "INSERT INTO `tb_psy` (`owner_id`, `rodowod`, `tytuly`, `nazwa_przydomek`, `rasa_id`, `color_id`, `birthday`, `sex`, `chip_nr`, `tata_name`, `mama_name`, `hodowca`, `reg_datetime`, `is_confirmed`)VALUES
	('$owner_id','$rodowod','$tytuly_json','$nazwa_przydomek','$rasa_id','$kolor_id','$birstday','$gender','$chip_nr','$tataname','$mamaname','$hodowca','2019-02-18 18:00:00','$is_conf')";
	
	//echo $sql."<BR>";
	
	if(!$mysqli->query($sql)){
		echo $mysqli->error."<BR>".$sql;
		$err_cnt++;
		if($err_cnt > 9){exit();}
	}
	
	
	$i++;
}



exit();
$i = 1;

while($i < 500){
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

function fn_generate_rodowod($rasa_id, $owner_id)
{
	global $PKR,$OWNER;
	
	$arr[32] = "I";
	$arr[33] = "I";
	$arr[63] = "II";
	$arr[116] = "III";
	$arr[146] = "III";
	$arr[149] = "III";
	$arr[159] = "V";
	$arr[229] = "VI";
	
	if(isset($arr[$rasa_id])){$grupa = $arr[$rasa_id];}else{$grupa = "XVII";}
	
	while(!isset($num_PKR)){
		$tmp_nr = rand(1000,19999);
		if(!isset($PKR[$tmp_nr])){
			$num_PKR = $tmp_nr;
			$PKR[$tmp_nr] = 1;
		}
	}
	
	while(!isset($num_psa)){
		$tmp_nr = rand(1,40);
		if(!isset($OWNER[$owner_id][$tmp_nr])){
			$num_psa = $tmp_nr;
			$OWNER[$owner_id][$tmp_nr] = 1;
		}
	}
	
	return $num_PKR."/".$grupa."/".$num_psa;
}

function fn_generate_tytuls()
{
	for($i = 0; $i < rand(0,5); ++$i) {
		
		$tytul_id = rand(1,18);
		
		if(!isset($tmp_arr[$tytul_id])){
			$tmp_arr[$tytul_id] = 1;
			
			$arr_res[] = "$tytul_id";
		}
		
	}
	if(isset($arr_res)){return json_encode($arr_res);}
	return "";
	
}

function fn_get_one_dog($arr_rasy)
{
	global $mysqli;
	
	$arr_res['rasa_id'] = rand(0, count($arr_rasy)-1);
	
	if(!isset($arr_rasy[$arr_res['rasa_id']])){{echo "Something wrong with arr_rasy[".$arr_res['rasa_id']."] in row ".__LINE__; exit();}}else{$arr_kolors = $arr_rasy[$arr_res['rasa_id']];}
	
	$arr_res['kolor_id'] = rand(0, count($arr_kolors)-1);
	
	if(!isset($arr_kolors[$arr_res['kolor_id']])){{echo "Something wrong with arr_kolors[".$arr_res['rasa_id']."] in row ".__LINE__; exit();}}
	
	return $arr_res;
	
}

function fn_get_arr_sety()
{
	global $mysqli;
	
	$sql = "SELECT * FROM `tb_list_sets`";
	
	if(!$result = $mysqli->query($sql)){echo $mysqli->error."<BR>".$sql; exit();}
	while ($row = $result->fetch_object()){
		$arr[$row->id_rasy][] = $row->id_kolory;
		
	}
	if(isset($arr)){return $arr;}
return false;
}

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