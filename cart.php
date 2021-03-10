<?php
    
    require('initialize.php');

    $site->addHeader();

    $action = isset($_GET['action']) ? $_GET['action'] : "";
 
    echo "<div class='col-md-12'>";
        if($action=='removed'){
            echo "<div class='alert alert-info'>";
                echo "Product was removed from your cart!";
            echo "</div>";
        }
    
        else if($action=='quantity_updated'){
            echo "<div class='alert alert-info'>";
                echo "Product quantity was updated!";
            echo "</div>";
        }
    
        else if($action=='exists'){
            echo "<div class='alert alert-info'>";
                echo "Product already exists in your cart!";
            echo "</div>";
        }
    
        else if($action=='cart_emptied'){
            echo "<div class='alert alert-info'>";
                echo "Cart was emptied.";
            echo "</div>";
        }
    
        else if($action=='updated'){
            echo "<div class='alert alert-info'>";
                echo "Quantity was updated.";
            echo "</div>";
        }
    
        else if($action=='unable_to_update'){
            echo "<div class='alert alert-danger'>";
                echo "Unable to update quantity.";
            echo "</div>";
        }
    echo "</div>";

    $product = new Product($db);
    // $product_image = new ProductImage($db);
    $cart_item = new CartItem($db);

    if (isset($_SESSION['id'])) {
        $items = $cart_item->get_cart($_SESSION['id']);
        $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
    }

    // echo '<pre>';
    // print_r($products);

?>
<header>
    <div class="container-fluid">
        <div class="row">
        <div id="cart_id" style="display: none;"><?= $items['id']; ?></div>
            <div class="customer">
            <?php if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer') : ?>
                <div class="col">
                    <a href="<?= root_url_private('customer/index.php'); ?>">
                        View Your Account,
                        <?= $_SESSION['username']; ?>
                    </a>
                </div>
            <?php else :?>
                <div class="col">
                    <a href="customer.php">
                        Sign In/Register
                    </a>
                </div>
            <?php endif; ?>
            </div>
            <div class="col cart">
                <a href="cart.php">
                    Cart <span class="cart-count"></span>
                </a>
            </div>
            <div id="navigation" style="width: 100%;">
                <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <?php $site->addNav(); ?>
                </div>
                <form id="search" action="search.php" method="GET" class="form-inline my-2 my-lg-0">
                    <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
                    <input id="type-search" class="search-term form-control mr-sm-2" type="search" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search">
                    <button class="btn my-2 my-sm-0 btn-outline-secondary" type="submit">Search</button>
                </form>
                <div id="display"></div>
                </nav>
            </div>
        </div>
    </div>
</header>
<main id="cart">
<div class="container-fluid">
        <div class="row">
        <div id="form-message"></div>
            <?php 

            if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer' && empty($items)) {
                    // if ($cart_count < 1 ) {
                        echo "<div class='col-md-12'>";
                            echo "<div class='alert alert-danger'>";
                                echo "No products found in your cart!";
                            echo "</div>";
                        echo "</div>";
                    // }
            } else if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer' && !empty($items)) {
                
                foreach ($products as $product) {

                    $price = substr($product['price'], 1) * $product['quantity'];

                    echo "<div class='product-name col col-sm-12 my-2' data-id='" . $product['id'] . "'>";
                        echo "<div class='row'>";
                            echo "<div class='col col-md-10'>";
                                echo "<h4>" .  $product['name'] . "</h4>";
                                echo "<p>" .  $product['description'] . "</p>";
                                echo "<p>Quantity: <span class='product-quantity'>" .  $product['quantity'] . "</span></p>";
                                echo "<p>Price: $<span class='price'>" .  $price . "</span></p>";
                                echo "<button class='btn btn-success add-item' data-action='add-item' data-id='" . $product['id'] . "' data-quantity='" . $product['quantity'] . "'>Increase Quantity</button>";
                                echo "<button class='btn btn-danger remove-item' data-action='remove-item' data-id='" . $product['id'] . "' data-quantity='" . $product['quantity'] . "'>Reduce Quantity</button>";
                            echo "</div>";
                            echo "<div class='col col-md-2 my-5'>";
                            echo "<button class='btn btn-danger remove-item-full' data-action='remove-item-full' data-id='" . $product['id'] . "'>Remove Item from Cart</button>";
                            echo "</div>";      
                        echo "</div>";
                    echo "</div>";
                }
                
                //                 // update quantity
                //                 echo "<form class='update-quantity-form'>";
                //                     echo "<div class='product-id' style='display:none;'>{$id}</div>";
                //                     echo "<div class='input-group'>";
                //                         echo "<input type='number' name='quantity' value='{$quantity}' class='form-control cart-quantity' min='1' />";
                //                             echo "<span class='input-group-btn'>";
                //                                 echo "<button class='btn btn-default update-quantity' type='submit'>Update</button>";
                //                             echo "</span>";
                //                     echo "</div>";
                //                 echo "</form>";
                
                //                 // delete from cart
                //                 echo "<a href='remove_from_cart.php?id={$id}' class='btn btn-default'>";
                //                     echo "Delete";
                //                 echo "</a>";
                //             echo "</div>";
                
                //             echo "<div class='col-md-4'>";
                //                 echo "<h4>$" . number_format($price, 2, '.', ',') . "</h4>";
                //             echo "</div>";
                //         echo "</div>";
                
                //         $item_count += $quantity;
                //         $total+=$sub_total; -->
                // }
                
                    //  echo "<div class='col-md-8'></div>";
                //     echo "<div class='col-md-4'>";
                //         echo "<div class='cart-row'>";
                //             echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
                //             echo "<h4>$" . number_format($total, 2, '.', ',') . "</h4>";
                //             echo "<a href='checkout.php' class='btn btn-success m-b-10px'>";
                //                 echo "<span class='glyphicon glyphicon-shopping-cart'></span> Proceed to Checkout";
                //             echo "</a>";
                //         echo "</div>";
                //     echo "</div>";
                
                // }
                
                // else{
                //     echo "<div class='col-md-12'>";
                //         echo "<div class='alert alert-danger'>";
                //             echo "No products found in your cart!";
                //         echo "</div>";
                //     echo "</div>";
                // } -->
            } else {
                echo "<div class='col-md-12'>";
                    echo "<div class='alert alert-danger'>";
                        echo "Your Cart is empty, please sign in or register";
                    echo "</div>";
                echo "</div>";
            }
            ?>
        </div>
        <div class="row justify-content-end cart-totals">
            <div class="col col-md-8"></div>
            <div class="col col-sm col-md-2 quantity-total text-left">
                Quantity
                <span class="cart-count-bottom"></span>
            </div>
            <div class="col col-sm col-md-2 sub-total text-left">
                Sub Total
                <span id="sub-total"></span>
            </div>
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>

<script>
"use strict";
    (function ($) {
            evaluateCartCount();
            evaluateSubTotal();
    })(jQuery);
</script>