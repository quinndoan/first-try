<?php
$serverName = "LAPTOP-86MF1K51"; // Provide SQL Server name
$connectionOptions = array(
    "Database" => "PetManaDemo", // Provide database name
    "Uid" => "", 
    "PWD" => "" 
);
$con = sqlsrv_connect($serverName, $connectionOptions);

if (!$con) {
    die(print_r(sqlsrv_errors(), true));
}

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
    $row_count = sqlsrv_num_rows($result);

    // Check if any rows were returned
    if ($row_count > 0) {
        echo "Number of rows: " . $row_count;
    } else {
        echo "No rows found.";
    }
} else {
    // Handle the case where the query execution failed
    die(print_r(sqlsrv_errors(), true));
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
