<?php // file for activity for the user
session_start();
include("db.php");

error_reporting(0);
if(isset($_GET['action']) && $_GET['action']!="" && $_GET['action']=='delete')
{
    $order_id=$_GET['order_id'];

    /*this is delete query*/
    $sql_delete = "DELETE FROM orders WHERE order_id='$order_id'";
    sqlsrv_query($con, $sql_delete) or die("Delete query is incorrect...");
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
                                <tr>
                                    <th>User_id</th>
                                    <th>User_Email</th>
                                    <th>Mobile</th>
                                    <th>Logged_in</th>
                                    <th>Logout</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql_select = "SELECT user_id, email, mobile, last_login, last_logout FROM user_info ORDER BY user_id OFFSET $page1 ROWS FETCH NEXT 10 ROWS ONLY";
                                    $result = sqlsrv_query($con, $sql_select) or die ("Query incorrect.....");

                                    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                                    { //display user activity in table rows
                                        echo "<tr><td>{$row['user_id']}</td><td>{$row['email']}</td><td>{$row['mobile']}</td><td>{$row['last_login']}</td><td>{$row['last_logout']}</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>

                        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                        </div>
                        <div class="ps__rail-y" style="top: 0px; right: 0px;">
                            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Repeat the same structure for other cards with different queries -->
    </div>
</div>

<?php
sqlsrv_close($con);
include "footer.php";
?>
