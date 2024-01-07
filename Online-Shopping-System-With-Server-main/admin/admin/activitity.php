<?php
$serverName = "NGUYEN-MY-DUYEN\SQLEXPRESS"; // Provide SQL Server name
$database = "Pet"; // Provide database name

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

<div class="row" style="padding-top: 10vh;">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                </div>
                <p class="card-category">Total users</p>
                <h3 class="card-title">
                    <?php
                    $query = "SELECT user_id FROM user_info";
                    $result = sqlsrv_query($con, $query);

                    if ($result) {
                        $row = sqlsrv_num_rows($result);
                        printf(" " . $row);
                    }
                    ?>
                </h3>
            </div>
        </div>
    </div>
    <!-- Repeat the same structure for other cards with different queries -->
</div>

<?php
sqlsrv_close($con);
?>
