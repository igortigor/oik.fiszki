<title>GEN_CODE</Title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
if (!isset($_GET['start'])){exit();}

date_default_timezone_set('Asia/Almaty');

include("config.inc.php");
$mysqli = new mysqli($server, $user, $passw, $dbasename);
if ($mysqli->connect_errno){fn_send_err(__FILE__,__LINE__,"Не удалось подключиться к MySQL: ",$mysqli->connect_error,1);}
$mysqli->query("SET NAMES utf8");


$datetime_to_break = date("Y-m-d H:i:s", time()+(60*20));
exit();
/*
echo date("Y-m-d H:i:s")." <-now, break->".$datetime_to_break."<BR>";

IF(date("Y-m-d H:i:s") > $datetime_to_break){echo "now > break";}
ELSE{echo "now < break";}
exit();
*/

$except=array(".htpasswd","index.php","index1.php","1212_stat.php",".htaccess");
	$file_list = scandir('.');
	$count = count($file_list); // посчитали кол-во эл. массива
	$i = 0;
	while( $i < $count) 
	{
		
		//$file_list[$i] = substr($file_list[$i], 1);
		
		//------------
		/*
		if ($file_list[$i][0] == "r"){
			
			//unset($file_list[$i][0]);
			
			echo $file_list[$i]."<br>";
			
			rename($file_list[$i], substr($file_list[$i], 1));
		}
		*/
		//--------------+
		
		if ($file_list[$i][0] == "t"){
			
			//unset($file_list[$i][0]);
			
			fn_insert_from_fiile($file_list[$i]);
			
			rename($file_list[$i], "r".$file_list[$i]);
		}
		
		
		$i++;
		IF(date("Y-m-d H:i:s") > $datetime_to_break){$fp = fopen("logs/gen_codes.txt","a");fputs($fp,date("Y-m-d H:i:s")."\tdatetime to break exceeded\r\n");fclose($fp); exit();}
		IF(!file_exists("stop.txt")){$fp = fopen("logs/gen_codes.txt","a");fputs($fp,date("Y-m-d H:i:s")."\tstop.txt not exists\r\n");fclose($fp); exit();}
	}


exit();

function fn_insert_from_fiile($filename)
{
	global $mysqli;
	
	$fp = fopen("logs/gen_codes.txt","a");fputs($fp,date("Y-m-d H:i:s")."\t".$filename."\tstart\r\n");fclose($fp);
	
	$i=0; $err=0;
	$handle = @fopen($filename, "r");
	if ($handle) {
	    	while (	($code = fgets($handle, 4096)) !== false AND (file_exists("stop.txt"))	)
	    	{
	        
	    		IF($code[$i][0] == "N"){
		    		$sql="INSERT INTO `tb_codes` (`code`) VALUES ('$code')";
					if(!$mysqli->query($sql)){$fp = fopen("logs/gen_codes.txt","a");fputs($fp,"error=".$mysqli->error."\r\n");fclose($fp); $err++; if($err > 10){$fp = fopen("logs/gen_codes.txt","a");fputs($fp,"errors limit exceeded = ".$err."\r\n");fclose($fp);}}	    		
				}
		        //$i++;
		        //if($i > 10){$fp = fopen("logs/gen_codes.txt","a");fputs($fp,"exit"."\r\n");fclose($fp); exit();}
	    	}
	    
	    IF($code[0] != "N"){$fp = fopen("logs/gen_codes.txt","a");fputs($fp,date("Y-m-d H:i:s")."\t code[0]!=N\r\n");fclose($fp);}
	    

	    
	    if (!feof($handle)) {
	        echo "Ошибка: fgets() неожиданно потерпел неудачу\n";
	    }
	    fclose($handle);
	}
	$fp = fopen("logs/gen_codes.txt","a");fputs($fp,date("Y-m-d H:i:s")."\t".$filename."\tfinish\r\n");fclose($fp);
	
	
}

?>