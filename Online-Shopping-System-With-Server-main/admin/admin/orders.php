<?php   //file php để xử lý order đặt hàng
session_start();
include("Online-Shopping-System-With-Server-main\admin\admin\includes\db.php");

error_reporting(0);

if (isset($_GET['action']) && $_GET['action'] != "" && $_GET['action'] == 'delete') {
    $order_id = $_GET['order_id'];

    $query = "DELETE FROM orders WHERE order_id = ?";
    $params = array($order_id);

    $stmt = sqlsrv_query($con, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Pagination
$page = $_GET['page'];

if ($page == "" || $page == "1") {
    $page1 = 0;
} else {
    $page1 = ($page * 10) - 10;
}

include "sidenav.php";
include "topheader.php";
?>

<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <!-- Your content here -->
        <div class="col-md-14">
            <div class="card ">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Orders  / Page <?php echo $page; ?> </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive ps">
                        <table class="table table-hover tablesorter " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Products</th>
                                    <th>Contact | Email</th>
                                    <th>Address</th>
                                    <th>Details</th>
                                    <th>Shipping</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT order_id, product_title, first_name, mobile, email, address1, address2, product_price, address2, qty 
                                          FROM orders, products, user_info 
                                          WHERE orders.product_id = products.product_id AND user_info.user_id = orders.user_id 
                                          ORDER BY order_id OFFSET ? ROWS FETCH NEXT 10 ROWS ONLY";

                                $params = array($page1);

                                $stmt = sqlsrv_query($con, $query, $params);

                                if ($stmt === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }

                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                    $order_id = $row['order_id'];
                                    $p_names = $row['product_title'];
                                    $cus_name = $row['first_name'];
                                    $contact_no = $row['mobile'];
                                    $email = $row['email'];
                                    $address = $row['address1'];
                                    $country = $row['address2'];
                                    $details = $row['product_price'];
                                    $zip_code = $row['address2'];
                                    $time = $row['qty'];
                                    $quantity = $row['qty'];

                                    echo "<tr>
                                            <td>$cus_name</td>
                                            <td>$p_names</td>
                                            <td>$email<br>$contact_no</td>
                                            <td>$address<br>ZIP: $zip_code<br>$country</td>
                                            <td>$details</td>
                                            <td>$quantity</td>
                                            <td>$time</td>
                                            <td>
                                                <a class='btn btn-danger' href='orders.php?order_id=$order_id&action=delete'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>
