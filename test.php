<?php
if(!isset($_GET['email'])){exit();}


if (preg_match("/@poczta.pl$/i", $_GET['email'])) {

echo " nasza poczta";

}


exit();
 if (mail('i.andrievsky@mail.ru', 'Server test', 'Test message from server')) {
    echo "Sent";
  } else {
    echo "Error";
  }

?>