<?php
// kết nối database, khởi tạo biến $con
$serverName = "LAPTOP-86MF1K51";
$database = "PetManaDemo";
$uid = "";
$pass = "";

$connection = [
"Database" => $database,
"Uid" => $uid,
"PWD" => $pass
]; 

$con = sqlsrv_connect($serverName,$connection);
if(!$con)
die(print_r(sqlsrv_errors(),true));
//else 
//echo'connection established';
?>