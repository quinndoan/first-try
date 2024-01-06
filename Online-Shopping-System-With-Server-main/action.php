<?php
session_start();
$ip_add = getenv("REMOTE_ADDR");
include "db.php"; // file db.php chứa các kết nối vs database

if(isset($_POST["category"])){
	$category_query = "SELECT * FROM categories";

	$run_query = sqlsrv_query($con, $category_query);
	if ($run_query === false) {
		die(print_r(sqlsrv_errors(), true));
	}

	echo "
		<div class='aside'>
			<h3 class='aside-title'>Categories</h3>
			<div class='btn-group-vertical'>
	";
	
	if(sqlsrv_has_rows($run_query)){
		$i=1;
		while($row = sqlsrv_fetch_array($run_query, SQLSRV_FETCH_ASSOC)){
			$cid = $row["cat_id"];
			$cat_name = $row["cat_title"];
			$sql = "SELECT COUNT(*) AS count_items FROM products WHERE product_cat=$i";
			$query = sqlsrv_query($con, $sql);
			$row_count = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
			$count = $row_count["count_items"];
			$i++;

			echo "
				<div type='button' class='btn navbar-btn category' cid='$cid'>
					<a href='#'>
						<span></span>
						$cat_name
						<small class='qty'>($count)</small>
					</a>
				</div>
			";
		}

		echo "</div>";
	}
}
if(isset($_POST["brand"])){
    $brand_query = "SELECT * FROM brands";
    $run_query = sqlsrv_query($con, $brand_query);
    echo "
        <div class='aside'>
                            <h3 class='aside-title'>Brand</h3>
                            <div class='btn-group-vertical'>
    ";
    if(sqlsrv_has_rows($run_query)){
        $i = 1;
        while($row = sqlsrv_fetch_array($run_query, SQLSRV_FETCH_ASSOC)){
            
            $bid = $row["brand_id"];
            $brand_name = $row["brand_title"];
            $sql = "SELECT COUNT(*) AS count_items FROM products WHERE product_brand=$i";
            $query = sqlsrv_query($con, $sql);
            $row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
            $count = $row["count_items"];
            $i++;
            echo "				
                    
                    <div type='button' class='btn navbar-btn selectBrand' bid='$bid'>
									
									<a href='#'>
										<span ></span>
										$brand_name
										<small >($count)</small>
									</a>
								</div>
			";
		}
		echo "</div>";
	}
}
if(isset($_POST["page"])){
    $sql = "SELECT * FROM products";
    $run_query = sqlsrv_query($con, $sql);
    $count = sqlsrv_num_rows($run_query);
    $pageno = ceil($count/9);
    for($i=1; $i<=$pageno; $i++){
        echo "
            <li><a href='#product-row' page='$i' id='page' class='active'>$i</a></li>
        ";
    }
}

/*if(isset($_POST["getProduct"])){
	$limit = 9;
	if(isset($_POST["setPage"])){
		$pageno = $_POST["pageNumber"];
		$start = ($pageno * $limit) - $limit;
	}else{
		$start = 0;
	}*/
	if (isset($_POST["getProduct"])) {
		$limit = 9;
	
		try {
			if (isset($_POST["setPage"])) {
				$pageno = $_POST["pageNumber"];
				$start = ($pageno * $limit) - $limit;
			} else {
				$start = 0;
			}
	
			// Rest of your code for processing the limit and start values...
	
		} catch (Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	
	
	//$product_query = "SELECT * FROM products,categories WHERE product_cat=cat_id LIMIT $start,$limit";

				  $product_query = "SELECT TOP $limit * 
				                    FROM products 
									JOIN categories ON products.product_cat = categories.cat_id 
									WHERE products.product_id NOT IN (SELECT TOP $start product_id FROM products ORDER BY product_id) 
									ORDER BY products.product_id";


	$run_query = sqlsrv_query($con,$product_query);
	if ($run_query === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($run_query)) {
        while ($row = sqlsrv_fetch_array($run_query, SQLSRV_FETCH_ASSOC)) {
            $pro_id    = $row['product_id'];
            $pro_cat   = $row['product_cat'];
            $pro_brand = $row['product_brand'];
            $pro_title = $row['product_title'];
            $pro_price = $row['product_price'];
            $pro_image = $row['product_image'];

            $cat_name = $row["cat_title"];
            echo "
                <div class='col-md-4 col-xs-6' >
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
if (isset($_POST["get_seleted_Category"]) || isset($_POST["selectBrand"]) || isset($_POST["search"])) {
		if (isset($_POST["get_seleted_Category"])) {
			$id = $_POST["cat_id"];
			$sql = "SELECT * FROM products,categories WHERE product_cat = '$id' AND product_cat=cat_id";
		} elseif (isset($_POST["selectBrand"])) {
			$id = $_POST["brand_id"];
			$sql = "SELECT * FROM products,categories WHERE product_brand = '$id' AND product_cat=cat_id";
		} else {
			$keyword = $_POST["keyword"];
			header('Location: store.php');
			$sql = "SELECT * FROM products,categories WHERE product_cat=cat_id AND product_keywords LIKE '%$keyword%'";
		}
	
		$run_query = sqlsrv_query($con, $sql);
	
		if ($run_query === false) {
			die(print_r(sqlsrv_errors(), true));
		}
	
		while ($row = sqlsrv_fetch_array($run_query, SQLSRV_FETCH_ASSOC)) {
			$pro_id    = $row['product_id'];
			$pro_cat   = $row['product_cat'];
			$pro_brand = $row['product_brand'];
			$pro_title = $row['product_title'];
			$pro_price = $row['product_price'];
			$pro_image = $row['product_image'];
			$cat_name = $row["cat_title"];
	
			echo "
				<div class='col-md-4 col-xs-6'>
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
								<button class='add-to-wishlist' tabindex='0'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
								<button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
								<button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
							</div>
						</div>
						<div class='add-to-cart'>
							<button pid='$pro_id' id='product' href='#' tabindex='0' class='add-to-cart-btn'><i class='fa fa-shopping-cart'></i> add to cart</button>
						</div>
					</div>
				</div>
			";
		}
	}


	if (isset($_POST["addToCart"])) {
		$p_id = $_POST["proId"];
	
		if (isset($_SESSION["uid"])) {
			$user_id = $_SESSION["uid"];
			$sql = "SELECT * FROM cart WHERE p_id = '$p_id' AND user_id = '$user_id'";
			$run_query = sqlsrv_query($con, $sql);
	
			if ($run_query === false) {
				die(print_r(sqlsrv_errors(), true));
			}
	
			$count = sqlsrv_has_rows($run_query);
	
			if ($count > 0) {
				echo "
					<div class='alert alert-warning'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Product is already added into the cart. Continue Shopping..!</b>
					</div>";
			} else {
				$sql = "INSERT INTO cart (p_id, ip_add, user_id, qty) VALUES (?, ?, ?, ?)";
				$params = array($p_id, $ip_add, $user_id, 1);
				$insert_query = sqlsrv_query($con, $sql, $params);
	
				if ($insert_query === false) {
					die(print_r(sqlsrv_errors(), true));
				}
	
				echo "
					<div class='alert alert-success'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Product is Added..!</b>
					</div>
				";
			}
			//
		} else {
			$sql = "SELECT id FROM cart WHERE ip_add = ? AND p_id = ? AND user_id = -1";
			$params = array($ip_add, $p_id);
			$query = sqlsrv_query($con, $sql, $params);
	
			if ($query === false) {
				die(print_r(sqlsrv_errors(), true));
			}
	
			if (sqlsrv_has_rows($query) > 0) {
				echo "
					<div class='alert alert-warning'>
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						<b>Product is already added into the cart. Continue Shopping..!</b>
					</div>";
				exit();
			}
	
			$sql = "INSERT INTO cart (p_id, ip_add, user_id, qty) VALUES (?, ?, -1, 1)";
			$params = array($p_id, $ip_add);
			$insert_query = sqlsrv_query($con, $sql, $params);
	
			if ($insert_query === false) {
				die(print_r(sqlsrv_errors(), true));
			}
	
			echo "
				<div class='alert alert-success'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<b>Your product is Added Successfully..!</b>
				</div>
			";
			exit();
		}
	}
	
	// Count User cart item
	if (isset($_POST["count_item"])) {
		// When the user is logged in, then we will count the number of items in the cart using the user session id
		if (isset($_SESSION["uid"])) {
			$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE user_id = ?";
			$params = array($_SESSION["uid"]);
		} else {
			// When the user is not logged in, then we will count the number of items in the cart using the user's unique IP address
			$sql = "SELECT COUNT(*) AS count_item FROM cart WHERE ip_add = ? AND user_id < 0";
			$params = array($ip_add);
		}
	
		$query = sqlsrv_query($con, $sql, $params);
	
		if ($query === false) {
			die(print_r(sqlsrv_errors(), true));
		}
	
		$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
		echo $row["count_item"];
		exit();
	}
	
	// Get Cart Item From Database to Dropdown menu
	if (isset($_POST["Common"])) {
		if (isset($_SESSION["uid"])) {
			// When the user is logged in, this query will execute
			$sql = "SELECT a.product_id, a.product_title, a.product_price, a.product_image, b.id, b.qty FROM products a, cart b WHERE a.product_id = b.p_id AND b.user_id = ?";
			$params = array($_SESSION["uid"]);
		} else {
			// When the user is not logged in, this query will execute
			$sql = "SELECT a.product_id, a.product_title, a.product_price, a.product_image, b.id, b.qty FROM products a, cart b WHERE a.product_id = b.p_id AND b.ip_add = ? AND b.user_id < 0";
			$params = array($ip_add);
		}
	
		$query = sqlsrv_query($con, $sql, $params);
	
		if ($query === false) {
			die(print_r(sqlsrv_errors(), true));
		}
	
		if (isset($_POST["getCartItem"])) {
			// Display cart item in dropdown menu
			if (sqlsrv_has_rows($query) > 0) {
				$n = 0;
				$total_price = 0;
	
				while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
					$n++;
					$product_id = $row["product_id"];
					$product_title = $row["product_title"];
					$product_price = $row["product_price"];
					$product_image = $row["product_image"];
					$cart_item_id = $row["id"];
					$qty = $row["qty"];
					$total_price = $total_price + $product_price;
	
					echo '
						<div class="product-widget">
							<div class="product-img">
								<img src="product_images/' . $product_image . '" alt="">
							</div>
							<div class="product-body">
								<h3 class="product-name"><a href="#">' . $product_title . '</a></h3>
								<h4 class="product-price"><span class="qty">' . $n . '</span>$' . $product_price . '</h4>
							</div>
						</div>';
				}
	
				echo '<div class="cart-summary">
						<small class="qty">' . $n . ' Item(s) selected</small>
						<h5>$' . $total_price . '</h5>
					</div>';
				exit();
			}
		}
	}
    
    
    if (isset($_POST["checkOutDetails"])) {
		if (sqlsrv_has_rows($query) > 0) {
			// Display user cart item with "Ready to checkout" button if the user is not logged in
			echo '<div class="main ">
			<div class="table-responsive">
			<form method="post" action="login_form.php">
			
				   <table id="cart" class="table table-hover table-condensed" id="">
					<thead>
						<tr>
							<th style="width:50%">Product</th>
							<th style="width:10%">Price</th>
							<th style="width:8%">Quantity</th>
							<th style="width:7%" class="text-center">Subtotal</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>
					';
				$n = 0;
				while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
					$n++;
					$product_id = $row["product_id"];
					$product_title = $row["product_title"];
					$product_price = $row["product_price"];
					$product_image = $row["product_image"];
					$cart_item_id = $row["id"];
					$qty = $row["qty"];
	
					echo 
						'
							 
						<tr>
							<td data-th="Product" >
								<div class="row">
								
									<div class="col-sm-4 "><img src="product_images/'.$product_image.'" style="height: 70px;width:75px;"/>
									<h4 class="nomargin product-name header-cart-item-name"><a href="product.php?p='.$product_id.'">'.$product_title.'</a></h4>
									</div>
									<div class="col-sm-6">
										<div style="max-width=50px;">
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
										</div>
									</div>
									
									
								</div>
							</td>
							<input type="hidden" name="product_id[]" value="'.$product_id.'"/>
							<input type="hidden" name="" value="'.$cart_item_id.'"/>
							<td data-th="Price"><input type="text" class="form-control price" value="'.$product_price.'" readonly="readonly"></td>
							<td data-th="Quantity">
								<input type="text" class="form-control qty" value="'.$qty.'" >
							</td>
							<td data-th="Subtotal" class="text-center"><input type="text" class="form-control total" value="'.$product_price.'" readonly="readonly"></td>
							<td class="actions" data-th="">
							<div class="btn-group">
								<a href="#" class="btn btn-info btn-sm update" update_id="'.$product_id.'"><i class="fa fa-refresh"></i></a>
								
								<a href="#" class="btn btn-danger btn-sm remove" remove_id="'.$product_id.'"><i class="fa fa-trash-o"></i></a>        
							</div>                          
							</td>
						</tr>
					
							
							';
				}
				
				echo '</tbody>
				<tfoot>
					
					<tr>
						<td><a href="store.php" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
						<td colspan="2" class="hidden-xs"></td>
						<td class="hidden-xs text-center"><b class="net_total" ></b></td>
						<div id="issessionset"></div>
						<td>
							
							';
				if (!isset($_SESSION["uid"])) {
					echo '
					
							<a href="" data-toggle="modal" data-target="#Modal_register" class="btn btn-success">Ready to Checkout</a></td>
								</tr>
							</tfoot>
				
							</table></div></div>';
				} else if(isset($_SESSION["uid"])){
					// Paypal checkout form
					echo '
					</form>
					
						<form action="checkout.php" method="post">
							<input type="hidden" name="cmd" value="_cart">
							<input type="hidden" name="business" value="shoppingcart@puneeth.com">
							<input type="hidden" name="upload" value="1">';
							  
							$x=0;
							$sql = "SELECT a.product_id,a.product_title,a.product_price,a.product_image,b.id,b.qty FROM products a,cart b WHERE a.product_id=b.p_id AND b.user_id='$_SESSION[uid]'";
							$query = sqlsrv_query($con,$sql);
							while($row=sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
								$x++;
								echo  
			
									'<input type="hidden" name="total_count" value="'.$x.'">
									<input type="hidden" name="item_name_'.$x.'" value="'.$row["product_title"].'">
									  <input type="hidden" name="item_number_'.$x.'" value="'.$x.'">
									 <input type="hidden" name="amount_'.$x.'" value="'.$row["product_price"].'">
									 <input type="hidden" name="quantity_'.$x.'" value="'.$row["qty"].'">';
								}
							  
							echo   
								'<input type="hidden" name="return" value="http://localhost/myfiles/public_html/payment_success.php"/>
									<input type="hidden" name="notify_url" value="http://localhost/myfiles/public_html/payment_success.php">
									<input type="hidden" name="cancel_return" value="http://localhost/myfiles/public_html/cancel.php"/>
									<input type="hidden" name="currency_code" value="USD"/>
									<input type="hidden" name="custom" value="'.$_SESSION["uid"].'"/>
									<input type="submit" id="submit" name="login_user_with_product" name="submit" class="btn btn-success" value="Ready to Checkout">
									</form></td>
									
									</tr>
									
									</tfoot>
									
							</table></div></div>    
								';
				}
			}
		}
	
	
// Update Item From cart
if (isset($_POST["updateCartItem"])) {
    $update_id = $_POST["update_id"];
    $qty = $_POST["qty"];
    if (isset($_SESSION["uid"])) {
        $sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND user_id = '$_SESSION[uid]'";
    } else {
        $sql = "UPDATE cart SET qty='$qty' WHERE p_id = '$update_id' AND ip_add = '$ip_add'";
    }

    $params = array($qty, $update_id, $_SESSION["uid"]);
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($con, $sql, $params, $options);

    if ($stmt) {
        echo "<div class='alert alert-info'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <b>Product is updated</b>
                </div>";
        exit();
    }
}

?>







