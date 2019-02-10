<?php
if(!defined("MAIN_FILE")) die;

if($_GET['action'] == "wystawy"){
	
	if(isset($_GET['sub']) AND $_GET['sub'] == "new"){
		include("panel_organizer_wystawy_new.php");
	}else{
		include("panel_organizer_wystawy.php");
	}
	
    
}

?>
