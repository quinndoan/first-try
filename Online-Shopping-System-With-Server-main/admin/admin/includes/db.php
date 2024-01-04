<?php

$serverName = "LAPTOP-86MF1K51";
$connectionOptions = array(
    "Database" => "apricot-store",
    "Uid" => "",
    "PWD" => ""
);

// Establishes the connection
$con = sqlsrv_connect($serverName, $connectionOptions);

// Check the connection
if (!$con)
    die(print_r(sqlsrv_errors(), true));

else 
echo'connection established';
?>
