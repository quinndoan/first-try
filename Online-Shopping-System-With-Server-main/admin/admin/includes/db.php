<?php

$serverName = "LAPTOP-86MF1K51";
$connectionOptions = array(
    "Database" => "Book Management",
    "Uid" => "",
    "PWD" => ""
);

// Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check the connection
if (!$conn)
    die(print_r(sqlsrv_errors(), true));

else 
echo'connection established';
?>
