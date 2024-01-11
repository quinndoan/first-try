<?php
$serverName = "NGUYEN-MY-DUYEN\SQLEXPRESS"; // Provide SQL Server name
$database = "CDQ"; // Provide database name

$connection = [
    "Database" => $database,
    "Encrypt" => "no",  // Disable connection encryption
    "TrustServerCertificate" => "yes"  // Trust the server certificate
]; 

$con = sqlsrv_connect($serverName, $connection);

if (!$con) {
    die(print_r(sqlsrv_errors(), true));
}

// Connection established successfully, you can proceed with your database operations

?>



<?php
sqlsrv_close($con);
?>
