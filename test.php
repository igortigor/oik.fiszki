<?php

$date = "0000-00-00";
if(isValidDate($date)){echo $date." valid<BR>";}else{echo $date." Invalid<BR>";}

$date = "2019-01-24";
if(isValidDate($date)){echo $date." valid<BR>";}else{echo $date." Invalid<BR>";}

$date = "2019-02-13";
if(isValidDate($date)){echo $date." valid<BR>";}else{echo $date." Invalid<BR>";}

function isValidDate($date, $format= 'Y-m-d'){
    return $date == date($format, strtotime($date));
}

?>