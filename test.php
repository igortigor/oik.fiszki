<?php

if(!$_POST['test'] = fn_test()){
	echo "Nie udalo sie func!<BR>";
	unset($_POST['test']);
}



if(isset($_POST['test'])){
	echo "ISSET!";
}else{
	echo "NOT ISSET!";
}


function fn_test()
{
	return false;
}
?>