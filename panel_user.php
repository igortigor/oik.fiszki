<?php
if(!defined("MAIN_FILE")) die;

if($_GET['action'] == "dogs"){
	
	if(isset($_GET['sub']) AND $_GET['sub'] == "newdog"){
		include("panel_user_new_dog.php");
	}else{
		include("panel_user_dogs.php");
	}
	
    
}

?>
