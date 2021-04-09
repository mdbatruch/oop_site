<?php
    
    require('initialize.php');

    $site->addHeader();

    $action = isset($_GET['action']) ? $_GET['action'] : "";

    $product = new Product($db);
    // $product_image = new ProductImage($db);
    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        // echo '<pre>';
        // print_r($_SESSION);

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

    } else {
        $count = 0;
        $items = null;
    }

    // echo '<pre>';
    // print_r($products);

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $db); ?>
        </div>
    </div>
</header>
<main id="cart">
<div class="container-fluid">
        <div class="row">
        <div id="form-message"></div>
            <?php 

            if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer' && empty($products)) {
                    // if ($cart_count < 1 ) {
                        echo "<div class='col-md-12'>";
                            echo "<div class='alert alert-danger'>";
                                echo "No products found in your cart!";
                            echo "</div>";
                        echo "</div>";
                    // }
            } else if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer' && !empty($products)) {
                ?>
                <?php
                foreach ($products as $product) {
                        $price = substr($product['price'], 1) * $product['quantity']; ?>
                    <div class='product-name col col-sm-12 my-2' data-id='<?= $product['id'] ?>' >
                        <div class='row'>
                            <div class='col col-md-2'>
                                    <img src="<?= root_url('images/' . $product['image']); ?>" alt="<?= $product['name'] . ' Image'; ?>" class="img-fluid img-thumbnail">
                            </div>
                            <div class='col col-md-8'>
                                <a href="<?= root_url('product.php?id=' . $product["id"]); ?>">
                                    <h4><?= $product['name']; ?></h4>
                                </a>
                                <p><?=  $product['description']; ?></p>
                                <p>Quantity: <span class='product-quantity'><?= $product['quantity'] ?></span></p>
                                <p>Price: $<span class='price'><?= $price; ?></span></p>
                                <button class='btn btn-success add-item' data-action='add-item' data-id='<?= $product['id']; ?>' data-quantity='<?= $product['quantity']; ?>'>Increase Quantity</button>
                                <button class='btn btn-danger remove-item' data-action='remove-item' data-id='<?= $product['id']; ?>' data-quantity='<?= $product['quantity']; ?>'>Reduce Quantity</button>
                            </div>
                            <div class='col col-md-2 my-5'>
                            <button class='btn btn-danger remove-item-full' data-action='remove-item-full' data-id='<?= $product['id']; ?>'>Remove Item from Cart</button>
                            </div>    
                        </div>
                    </div>
             <?php   } 
            } else {
                ?>
                <div class='col-md-12'>
                    <div class='alert alert-danger'>
                        Your Cart is empty, please sign in or register
                    </div>
                </div>
        <?php  } ?>
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