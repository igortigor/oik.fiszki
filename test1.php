<?php

$test = '["2","6","8"]';

$arr_dog_tytuls = json_decode($test);

echo ("<pre>");
print_r($arr_dog_tytuls);
echo ("</pre>");

$arr_dog_tytuls   = array_flip($arr_dog_tytuls);

echo ("<pre>");
print_r($arr_dog_tytuls);
echo ("</pre>");
?>