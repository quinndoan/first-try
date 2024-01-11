<?php
session_start();
include("includes/db.php");

error_reporting(0);

if (isset($_GET['action']) && $_GET['action'] != "" && $_GET['action'] == 'delete') {
    $order_id = $_GET['order_id'];

    /* Đây là câu truy vấn xóa */
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $params = array($order_id);

    $run_query = sqlsrv_query($con, $sql, $params);

    if ($run_query === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Delete successful!";
    }
}
 

///pagination
$page=$_GET['page'];

if($page=="" || $page=="1")
{
$page1=0;	
}
else
{
$page1=($page*10)-10;	
}

include "sidenav.php";
include "topheader.php";

?>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="col-md-14">
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Activity  / Page <?php echo $page;?> </h4>
              </div>
              <div class="card-body">
                <div class="table-responsive ps">
                  <table class="table table-hover tablesorter " id="">
                    <thead class=" text-primary">
                      <tr><th>User_id</th><th>User_Email</th><th>Mobile</th><th>Logged_in</th><th>Logout</th><th></th>
                    </tr></thead>
                    <tbody>
                      <?php 
                        $sql = "SELECT user_id, email, mobile, last_login, last_logout FROM user_info OFFSET ? ROWS FETCH NEXT 10 ROWS ONLY";
                        $params = array($page1);
                        
                        $run_query = sqlsrv_query($con, $sql, $params);
                        
                        if ($run_query === false) {
                            die(print_r(sqlsrv_errors(), true));
                        }
                        
                        while ($row = sqlsrv_fetch_array($run_query, SQLSRV_FETCH_ASSOC)) {
                            echo "<tr><td>{$row['user_id']}</td><td>{$row['email']}</td><td>{$row['mobile']}</td><td>{$row['last_login']}</td><td>{$row['last_logout']}</td></tr>";
                        }
                        
                        ?>
                    </tbody>
                  </table >
                  
                  
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>

            </div>
          </div>
             <div class="col-md-14">
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">Activity  / Supplier</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive ps">
                  <table class="table table-hover tablesorter " id="">
                    <thead class=" text-primary">
                      <tr><th>User_id</th><th>User_Email</th><th>Mobile</th><th>Logged_in</th><th>Logout</th><th></th>
                    </tr></thead>
                        <tbody>
                            <?php
                            $sql = "SELECT user_id, email, mobile, login_time, logout_time FROM user_info OFFSET ? ROWS FETCH NEXT 10 ROWS ONLY";
                            $params = array($page1);

                            $run_query = sqlsrv_query($con, $sql, $params);

                            if ($run_query === false) {
                            die(print_r(sqlsrv_errors(), true));
                            }

                            while ($row = sqlsrv_fetch_array($run_query, SQLSRV_FETCH_ASSOC)) {
                            echo "<tr><td>{$row['user_id']}</td><td>{$row['email']}</td><td>{$row['mobile']}</td><td>{$row['login_time']}</td><td>{$row['logout_time']}</td></tr>";
                            }
                            ?>

                            ?>
                            </tbody>
                  </table >
                  
                  
                <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
              </div>
              
            </div>
          </div>

          
        </div>
      </div>

      <?php
include "footer.php";
?>