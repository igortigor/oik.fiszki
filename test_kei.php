<?php
$to      = 'i.andrievsky@mail.ru';
$subject = 'Test';
$message = 'testing';
$headers = 'From: webmaster@example.com' . "\r\n" .
'Reply-To: webmaster@example.com' . "\r\n" .
'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?>
