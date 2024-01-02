<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php";

if(isset($_POST["categoryhome"])){
    $category_query = "SELECT * FROM categories WHERE cat_id!=1";
    
    $run_query = sqlsrv_query($conn, $category_query) or die(print_r(sqlsrv_errors(), true));
    echo "
        
            
            
                <!-- responsive-nav -->
                <div id='responsive-nav'>
                    <!-- NAV -->
                    <ul class='main-nav nav navbar-nav'>
                    <li class='active'><a href='index.php'>Home</a></li>
                    <li><a href='store.php'>Electronics</a></li>
    ";
    if(sqlsrv_has_rows($run_query)){
        while($row = sqlsrv_fetch_array($run_query, SQLSRV_FETCH_ASSOC)){
            $cid = $row["cat_id"];
            $cat_name = $row["cat_title"];
            
            $sql = "SELECT COUNT(*) AS count_items FROM products,categories WHERE product_cat=cat_id";
            $query = sqlsrv_query($conn, $sql);
            $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
            $count = $row["count_items"];
            
            echo "
                    
                    <li class='categoryhome' cid='$cid'><a href='store.php'>$cat_name</a></li>
                    
            ";
        }
        
        echo "</ul>
                    <!-- /NAV -->
                </div>
                <!-- /responsive-nav -->
               
            ";
    }
}

if(isset($_POST["page"])){
    $sql = "SELECT * FROM products";
    $run_query = sqlsrv_query($conn, $sql);
    $count = sqlsrv_num_rows($run_query);
    $pageno = ceil($count/2);
    for($i=1; $i<=$pageno; $i++){
        echo "
            <li><a href='#product-row' page='$i' id='page'>$i</a></li>
        ";
    }
}


if(isset($_POST["gethomeProduct"])){
    $limit = 9;
    if(isset($_POST["setPage"])){
        $pageno = $_POST["pageNumber"];
        $start = ($pageno * $limit) - $limit;
    } else {
        $start = 0;
    }
    
    $product_query = "SELECT * FROM products,categories WHERE product_cat=cat_id AND product_id BETWEEN 71 AND 74";
    $run_query = sqlsrv_query($conn, $product_query);
    if(sqlsrv_has_rows($run_query)){
        while($row = sqlsrv_fetch_array($run_query, SQLSRV_FETCH_ASSOC)){
            $pro_id    = $row['product_id'];
            $pro_cat   = $row['product_cat'];
            $pro_brand = $row['product_brand'];
            $pro_title = $row['product_title'];
            $pro_price = $row['product_price'];
            $pro_image = $row['product_image'];
            
            $cat_name = $row["cat_title"];
            
            echo "
                        
                                <div class='col-md-3 col-xs-6'>
                                <a href='product.php?p=$pro_id'><div class='product'>
                                    <div class='product-img'>
                                        <img src='product_images/$pro_image' style='max-height: 170px;' alt=''>
                                        <div class='product-label'>
                                            <span class='sale'>-30%</span>
                                            <span class='new'>NEW</span>
                                        </div>
                                    </div></a>
                                    <div class='product-body'>
                                        <p class='product-category'>$cat_name</p>
                                        <h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
                                        <h4 class='product-price header-cart-item-info'>$pro_price<del class='product-old-price'>$990.00</del></h4>
                                        <div class='product-rating'>
                                            <i class='fa fa-star'></i>
                                            <i class='fa fa-star'></i>
                                            <i class='fa fa-star'></i>
                                            <i class='fa fa-star'></i>
                                            <i class='fa fa-star'></i>
                                        </div>
                                        <div class='product-btns'>
                                            <button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
                                            <button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
                                            <button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
                                        </div>
                                    </div>
                                    <div class='add-to-cart'>
                                        <button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
                                    </div>
                                </div>
                                </div>
                            
                        
            ";
        }
    }
}
