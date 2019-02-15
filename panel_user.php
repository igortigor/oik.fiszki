<?php
if(!defined("MAIN_FILE")) die;
if(defined("SHOW_FILENAME")) fn_show_report(basename(__FILE__));


if($_GET['action'] == "dogs"){
	
	if(isset($_GET['sub']) AND $_GET['sub'] == "newdog"){
		include("panel_user_new_dog.php");
	}else{
		include("panel_user_dogs.php");
	}
	
    
}

if($_GET['action'] == "wystawy"){
	include("panel_user_wystawy.php");
}

?>
