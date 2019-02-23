<?php
session_start();
if(!isset($_SESSION["role"])){exit();}
if(!isset($_GET['type'])){exit();}
if(!isset($_SESSION["show_id"])){exit();}

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
	    
	if(!$arr_dane = fn_get_katalog($_SESSION["show_id"])){$pdf->Cell(0,10,'Nie ma danych',0,1);$pdf->Output(); exit();}
	
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
					$msg = $dog_arr['NR'].". ".$name." ".$color." ".$dog_arr['birthday'];
					
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

//-----------------------WYSTAWCY-----------------------------------
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
	    
	if(!$arr_dane = fn_get_katalog($_SESSION["show_id"])){$pdf->Cell(0,10,'Nie ma danych',0,1);$pdf->Output(); exit();}
	
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

//-----------------------KARTY OCEN-----------------------------------

if($_GET['type'] == "karty"){
	
	
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
		if(!$title = fn_get_name_from_list("tb_wystawy", $_SESSION["show_id"])){$title = "Wystawa";}
	    // Logo
	    $this->Image('img/logo.png',10,6,50);
	    $this->AddFont('DejaVu','','DejaVuSansCondensed.php',true);
	    $this->AddFont('DejaVuBold','','DejaVuSansCondensed-Bold.php',true);
		$this->SetFont('DejaVu','',14);
	    
	    $title= iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $title);
	    $this->SetX(85);
	
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
	//$pdf->AddPage();

	if(!$arr_dane = fn_get_katalog($_SESSION["show_id"])){$pdf->Cell(0,10,'Nie ma danych',0,1);$pdf->Output(); exit();}
	
	$arr_dane = $arr_dane['katalog'];
	    
	foreach ($arr_dane as $rasa => $sex_arr){
		foreach ($sex_arr as $sex => $klasa_arr){
			foreach ($klasa_arr as $klasa => $psy_arr){
				foreach ($psy_arr as $key => $dog_arr){
					
					$rasa = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $rasa);
					$klasa = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $klasa);
					$name = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['name']);
					$color = iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['color']);

					if($sex == "PSY"){$sexx = "PIES";}else{$sexx = "SUKA";}

					
					//-------------TABLE--------------------
					
					$pdf->AddPage();
					
					$pdf->SetFont('DejaVu','',18);
					$w = $pdf->GetStringWidth($rasa)+6;
				    $pdf->SetX((214-$w)/2);
					$pdf->Cell(0,10,$rasa,0,1);
					$pdf->Ln(10);				
					
					$pdf->SetFont('DejaVu','',14);
					    // Column widths
    $w = array(15,25, 120);
    // Header
    $pdf->SetFillColor(33, 150, 243);
    $pdf->SetTextColor(255);
    $pdf->SetDrawColor(221, 221, 221);
    $pdf->SetLineWidth(.3);

    $pdf->Cell($w[0],10,$dog_arr['NR'],1,0,'C',true);
    $pdf->Cell($w[1],10,$sexx,1,0,'C',true);
    $pdf->Cell($w[2],10,$name,1,0,'C',true);
    $pdf->Ln();
    
    // Data
    $w = array(40, 120);
    $pdf->SetFillColor(242, 242, 242);
    $pdf->SetTextColor(0);
    $pdf->SetFont('');
    // Data
    $fill = false;
        $pdf->Cell($w[0],8,"Klasa:",'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,$klasa,'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Rodowód:"),'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,$dog_arr['rodowod'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,"Urodzony:",'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,$dog_arr['birthday'],'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Maść:"),'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['color']),'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,"Ojciec:",'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['tata']),'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,"Matka:",'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['mama']),'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,"Hodowca:",'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['hodowca']),'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Właściciel:"),'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['owner']),'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,"Adres:",'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', $dog_arr['adres']),'LR',0,'L',$fill);
        $pdf->Ln();
        $fill = !$fill;
        $pdf->Cell($w[0],8,"Tytuly:",'LR',0,'R',$fill);
        $pdf->Cell($w[1],8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', fn_get_tytuly($dog_arr['tytuly'])),'LR',0,'L',$fill);
        $pdf->Ln();   
    // Closing line
    $pdf->Cell(array_sum($w),0,'','T');
					
				$pdf->Ln(10);
				//$pdf->Ln();
				
				
					
		$w = array(40, 40, 40, 40);
    // Header
        $pdf->SetFillColor(33, 150, 243);
	    $pdf->SetTextColor(255);
	    $pdf->SetDrawColor(221, 221, 221);
	    $pdf->SetLineWidth(.3);
	    $fill = true;
	    
        $pdf->Cell($w[0],10,"Lokata",1,0,'C',$fill);
        $pdf->Cell($w[1],10,"w konkurencji",1,0,'C',$fill);
        $pdf->Cell($w[2],10,"Ocena",1,0,'C',$fill);
        $pdf->Cell($w[3],10,"Medal",1,0,'C',$fill);
    $pdf->Ln();
    
        //$pdf->SetFillColor(242, 242, 242);
	    $pdf->SetTextColor(0);
	    $pdf->SetFont('');
	    $fill = false;
	    
    	$pdf->Cell($w[0],10,"",1,0,'C',$fill);
        $pdf->Cell($w[1],10,"",1,0,'C',$fill);
        $pdf->Cell($w[2],10,"",1,0,'C',$fill);
        $pdf->Cell($w[3],10,"",1,0,'C',$fill);
    $pdf->Ln();
    
    $pdf->Cell(array_sum($w),0,'','T');
					
$pdf->Ln(10);
    
    
    //
    // Header
        $pdf->SetFillColor(33, 150, 243);
	    $pdf->SetTextColor(255);
	    $pdf->SetDrawColor(221, 221, 221);
	    $pdf->SetLineWidth(.3);
	    $fill = true;
    	$pdf->Cell(160,10,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Cechy dodatnie i ujemne uzasadniające przyznaną ocenę:"),1,0,'C',$fill);
    $pdf->Ln();
    
    	$pdf->SetTextColor(0);
	    $pdf->SetFont('');
	    $fill = false;
    
	    $pdf->Cell(160,12,"",1,0,'C',$fill);
	    $pdf->Ln();
	    $pdf->Cell(160,12,"",1,0,'C',$fill);
	    $pdf->Ln();
	    $pdf->Cell(160,12,"",1,0,'C',$fill);
	    $pdf->Ln();
	    $pdf->Cell(160,12,"",1,0,'C',$fill);
	    $pdf->Ln();
    	$pdf->Cell(160,0,'','T');
    $pdf->Ln(25);
    

    $pdf->SetFont('DejaVu','',10);
    $pdf->SetX(130);
    $pdf->Cell(40,8,iconv('UTF-8', 'iso-8859-2//TRANSLIT//IGNORE', "Podpis sędziego"),'T',0,'C');
				}
			}
			$pdf->Ln();
		}
	}
	$pdf->Output();
	//$pdf->Output("katalog.pdf", "D");
}





function fn_get_katalog($show_id)
{
	global $mysqli;
	
	if(!is_numeric($show_id)){return false;}
	
	$nr = 0;
	
	$sql = "SELECT `P`.`nazwa_przydomek`, `CL`.`name` AS `color`,  `RL`.`name` AS `rasa`, `P`.`birthday`, `P`.`sex`, `P`.`owner_id`, `KL`.`name` AS `klasa`, `tb_users`.`name` AS `ownername`, `tb_users`.`surname` AS `ownersurname`,
	`P`.`tata_name`,`P`.`mama_name`,`P`.`rodowod`,`P`.`hodowca`,`tb_users`.`adres`, `P`.`tytuly`
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
WHERE `W`.`show_id` = '$show_id' AND `W`.`is_payed` = 1
ORDER BY `P`.`rasa_id`, `P`.`sex`, `W`.`klasa_id`";
	
	if(!$result = $mysqli->query($sql)){echo $mysqli->error."<BR>".$sql; exit();}
	while ($row = $result->fetch_object()){
		if($row->sex == "P"){$sex = "PSY";}else{$sex = "SUKI";}
		$nr++;
		$arr['katalog'][$row->rasa][$sex][$row->klasa][] = 
			array(
			"name"  => $row->nazwa_przydomek,
			"color" => $row->color,
			"birthday" => $row->birthday,
			"NR" => $nr,
			"rodowod" => $row->rodowod,
			"tata" => $row->tata_name,
			"mama" => $row->mama_name,
			"hodowca" => $row->hodowca,
			"adres" => $row->adres,
			"tytuly" => $row->tytuly,
			"owner" => $row->ownersurname." ".$row->ownername
			);
		
		$arr['wystawcy'][$row->owner_id]['name'] = $row->ownersurname." ".$row->ownername;
		$arr['wystawcy'][$row->owner_id]['psy'][] = array("name"  => $row->nazwa_przydomek, "color" => $row->color, "birthday" => $row->birthday, "NR" => $nr);
	}
	
	if(isset($arr)){return $arr;}
	
	return false;
	
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

function fn_get_tytuly($json_tytuly)
{
    global $mysqli;
    $res = "";

    if(!$arr_dog_tytuls = json_decode($json_tytuly)){$arr_dog_tytuls[]="";}
    
    $arr_dog_tytuls   = array_flip($arr_dog_tytuls);

    $sql = "SELECT * FROM `tb_list_tytuly` WHERE `id` IN (".implode(',',$arr_dog_tytuls).")";
    if(!$result = $mysqli->query($sql)) { return $res;}

    while ($row = $result->fetch_object()) {
    $res .= $row->tytulname."; ";
	}

    return $res;
}


?>