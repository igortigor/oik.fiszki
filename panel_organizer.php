<?php
if(!defined("MAIN_FILE")) die;
if(defined("SHOW_FILENAME")) fn_show_report(basename(__FILE__));

if($_GET['action'] == "wystawy"){
	
	if(isset($_GET['sub']) AND $_GET['sub'] == "new"){
		include("panel_organizer_wystawy_new.php");
	}else{
		include("panel_organizer_wystawy.php");
	}
	
    
}

?>
