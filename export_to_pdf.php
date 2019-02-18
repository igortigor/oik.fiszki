<?php
session_start();
if(!isset($_SESSION["role"])){exit();}
if(!isset($_GET['type'])){exit();}

include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_log_write("mysql_error ".$mysqli->connect_error, __LINE__, __FILE__ ); exit();}
$mysqli->query("SET NAMES utf8");

require('libs/fpdf/fpdf.php');

if($_GET['type'] == "katalog"){
	
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	    // Logo
	    $this->Image('img/logo.png',10,6,50);
	    $this->AddFont('DejaVu','','DejaVuSansCondensed.php',true);
	    $this->AddFont('DejaVuBold','','DejaVuSansCondensed-Bold.php',true);
		$this->SetFont('DejaVu','',14);
	    
	    $title= iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Lista psów - katalog");
		$w = $this->GetStringWidth($title)+6;
	    $this->SetX((210-$w)/2);
	
	    $this->Cell(40,0,$title,0,0,'C');
	    // Line break
	    $this->Ln(20);
	}
	
	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    $this->SetFont('DejaVu','',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}
	
	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFont('DejaVu','',14);
	    
	if(!$arr_dane = fn_get_katalog($show_id)){$pdf->Cell(0,10,'Nie ma danych',0,1);$pdf->Output(); exit();}
	
	$arr_dane = $arr_dane['katalog'];
	
	$nr = 0;
	    
	    
	foreach ($arr_dane as $rasa => $sex_arr){
		
		$pdf->SetFont('DejaVuBold','',18);
		$rasa = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $rasa);
		$w = $pdf->GetStringWidth($rasa)+6;
	    $pdf->SetX((214-$w)/2);
		$pdf->Cell(0,10,$rasa,0,1);
		
		
		foreach ($sex_arr as $sex => $klasa_arr){
			
			$pdf->SetFont('DejaVuBold','',16);
			$pdf->SetX(99);
	
			$pdf->Cell(0,20,$sex,0,1);
			
			
			foreach ($klasa_arr as $klasa => $psy_arr){
				
				$pdf->SetFont('DejaVuBold','',14);
				$klasa = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $klasa);
				$pdf->SetX((214-($pdf->GetStringWidth($klasa)+6))/2);
				$pdf->Cell(0,20,$klasa,0,1);
				
				foreach ($psy_arr as $key => $dog_arr){
					
					$name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['name']);
					$color = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['color']);
					$msg = $dog_arr['NR']." ".$name." ".$color." ".$dog_arr['birthday'];
					
					$pdf->SetFont('DejaVu','',12);
					$pdf->Cell(0,10,$msg,0,1);
				}
			}
			$pdf->Ln();
		}
	}
	$pdf->Output();
	//$pdf->Output("katalog.pdf", "D");
}


if($_GET['type'] == "wystawcy"){
	

	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	    // Logo
	    $this->Image('img/logo.png',10,6,50);
	    $this->AddFont('DejaVu','','DejaVuSansCondensed.php',true);
	    $this->AddFont('DejaVuBold','','DejaVuSansCondensed-Bold.php',true);
		$this->SetFont('DejaVu','',14);
	    
	    $title= iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Lista wystawców - katalog");
		$w = $this->GetStringWidth($title)+6;
	    $this->SetX((210-$w)/2);
	
	    $this->Cell(40,0,$title,0,0,'C');
	    // Line break
	    $this->Ln(20);
	}
	
	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    $this->SetFont('DejaVu','',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}
	
	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	$pdf->SetFont('DejaVu','',14);
	    
	if(!$arr_dane = fn_get_katalog($show_id)){$pdf->Cell(0,10,'Nie ma danych',0,1);$pdf->Output(); exit();}
	
	$arr_dane = $arr_dane['wystawcy'];
	
	$nr = 0;
	    
	    
	foreach ($arr_dane as $owner_id => $dogs_arr){
		
		$text = $dogs_arr['name'].":";
		
		foreach ($dogs_arr['psy'] as $key => $dog_arr){
			$text .= " ".$dog_arr['NR'].", ";
		}
		$text = mb_substr ($text, 0, -2, 'UTF-8');
		
		$tmp_arr[] = $text;
	}
	
	if(!isset($tmp_arr)){exit();}
	
	asort($tmp_arr);
	
	$pdf->SetFont('DejaVu','',12);
	
	$nr = 1;
	
	foreach ($tmp_arr as $key => $value){
		$text = $nr.". ".iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $value);
		$pdf->Cell(0,10,$text,0,1);
		$nr++;
	}
	
	$pdf->Output();
	//$pdf->Output("katalog.pdf", "D");
}

function fn_get_katalog($show_id)
{
	global $mysqli;
	
	$nr = 0;
	
	$sql = "SELECT `P`.`nazwa_przydomek`, `CL`.`name` AS `color`,  `RL`.`name` AS `rasa`, `P`.`birthday`, `P`.`sex`, `P`.`owner_id`, `KL`.`name` AS `klasa`, `tb_users`.`name` AS `ownername`, `tb_users`.`surname` AS `ownersurname`
FROM `tb_wystawy_uczestnicy` AS `W` INNER JOIN `tb_psy` AS `P`
ON `W`.`dog_id` = `P`.`id`
INNER JOIN `tb_list_kolory` AS `CL`
ON `P`.`color_id` = `CL`.`id`
INNER JOIN `tb_list_rasy` AS `RL`
ON `P`.`rasa_id` = `RL`.`id`
INNER JOIN `tb_list_klasy` AS `KL`
ON `klasa_id` = `KL`.`id`
INNER JOIN `tb_users`
ON `P`.`owner_id` = `tb_users`.`id`
WHERE `W`.`show_id` = 2 AND `W`.`is_payed` = 1
ORDER BY `P`.`rasa_id`, `P`.`sex`, `W`.`klasa_id`";
	
	if(!$result = $mysqli->query($sql)){echo $mysqli->error."<BR>".$sql; exit();}
	while ($row = $result->fetch_object()){
		if($row->sex == "P"){$sex = "PSY";}else{$sex = "SUKI";}
		$nr++;
		$arr['katalog'][$row->rasa][$sex][$row->klasa][] = array("name"  => $row->nazwa_przydomek, "color" => $row->color, "birthday" => $row->birthday, "NR" => $nr);
		$arr['wystawcy'][$row->owner_id]['name'] = $row->ownersurname." ".$row->ownername;
		$arr['wystawcy'][$row->owner_id]['psy'][] = array("name"  => $row->nazwa_przydomek, "color" => $row->color, "birthday" => $row->birthday, "NR" => $nr);
	}
	
	if(isset($arr)){return $arr;}
	
	return false;
	
}

?>