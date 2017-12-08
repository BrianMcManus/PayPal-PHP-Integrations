<?php

$ipn_data = file_get_contents('php://input');
$file = fopen("IPN_data.txt", "w");

fwrite($file, $ipn_data . php_eol);
fclose($file);

?>