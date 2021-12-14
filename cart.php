<?php
    
    require('initialize.php');

    $site->addHeader();

    $action = isset($_GET['action']) ? $_GET['action'] : "";

    if (isset($_SESSION['account']) &&  ($_SESSION['account'] == 'Administrator')) {
        header('Location: index.php');
    }

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
    <div class="row d-flex cart-header justify-content-center">
        <div class="col-md-6 text-center">
            <h3>View Your Cart</h3>
            <a href="/" class="btn btn-lightgrey mx-2">Back to Homepage</a>
            <a href="/products" class="btn btn-green mx-2">Continue Shopping</a>
        </div>
    </div>
    </div>
    <div class="container py-4">
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
                <div class="col col-sm-12 subtotal-title my-4">
                    <div class="row">
                        <div class='col col-md-4'>
                            Product
                        </div>
                        <div class='col col-md-2'>
                            Price
                        </div>
                        <div class='col col-md-2'>
                            Quantity
                        </div>
                        <div class='col col-md-2'>
                            Subtotal
                        </div>
                    </div>
                </div>
                <?php
                foreach ($products as $product) {
                        $price = substr($product['price'], 1) * $product['quantity']; ?>
                    <div class='product col col-12 col-sm-6 col-md-12 my-2' data-id='<?= $product['id'] ?>' >
                        <div class='row'>
                            <div class='col col-12 col-md-4 product-title'>
                                    <img src="<?= root_url('images/' . $product['image']); ?>" alt="<?= $product['name'] . ' Image'; ?>" class="img-fluid img-thumbnail">
                                    <a href="<?= root_url('product.php?id=' . $product["id"]); ?>" class="product-title-link pt-3">
                                        <h5><?= $product['name']; ?></h5>
                                    </a>
                            </div>
                            <div class='col col-12 col-md-2'>
                                
                            </div>
                            <div class='col col-12 col-md-2 d-flex text-center adjust-quantity'>
                                <div class="adjust-container d-flex">
                                <button class='btn remove-item' data-action='remove-item' data-id='<?= $product['id']; ?>' data-quantity='<?= $product['quantity']; ?>'>-</button>
                                    <p><span class='product-quantity'><?= $product['quantity'] ?></span></p>
                                <button class='btn add-item' data-action='add-item' data-id='<?= $product['id']; ?>' data-quantity='<?= $product['quantity']; ?>'>+</button>
                                </div>
                            </div>
                            <div class='col col-12 col-md-2'>
                                <p>$<span class='price'><?= $price; ?></span></p>
                            </div>
                            <div class='col col-md-8 d-none'>
                                <a href="<?= root_url('product.php?id=' . $product["id"]); ?>">
                                    <h4><?= $product['name']; ?></h4>
                                </a>
                                <p><?=  $product['description']; ?></p>
                                <p>Price: $<span class='price'><?= $price; ?></span></p>
                                <button class='btn btn-success add-item' data-action='add-item' data-id='<?= $product['id']; ?>' data-quantity='<?= $product['quantity']; ?>'>+</button>
                                    <p><span class='product-quantity'><?= $product['quantity'] ?></span></p>
                                <button class='btn btn-danger remove-item' data-action='remove-item' data-id='<?= $product['id']; ?>' data-quantity='<?= $product['quantity']; ?>'>-</button>
                            </div>
                            <div class='col col-md-2 px-4 delete-product-cart'>
                                <button class='btn remove-item-full' data-action='remove-item-full' data-id='<?= $product['id']; ?>'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                    </svg>
                                </button>
                            </div>    
                        </div>
                    </div>
             <?php   } 
            } else {
                ?>
                <div class='col-md-12 py-5 empty-cart-container'>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-x" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6.146 8.146a.5.5 0 0 1 .708 0L8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 0 1 0-.708z"/>
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                        </svg>
                        <h4>Your Cart is currently <b>empty.</b></h4>
                        <p>Before proceeding to checkout you must add some products to your shopping cart.
                        You will find a lot of interesting products in our "Products" page.</p>
                    </div>
                    <div>
                        <a href="/" class="btn btn-dark">Return to Shop</a>
                    </div>
                </div>
        <?php  } ?>
        </div>
        <?php if ($count >= 1 ) :?>
        <div class="row justify-content-end cart-totals">
            <div class="col col-sm col-md-2 quantity-total text-left d-none">
                Quantity
                <span class="cart-count-bottom"></span>
            </div>
            <div class="col col-sm col-md-4 sub-total text-left">
                <p>Cart Subtotal:</p>
                <span id="sub-total"></span>
                <p>Shipping calculated at checkout</p>
            </div>
            <div class="col col-md-8 text-end">
                <a href="<?= root_url('checkout.php'); ?>" class="btn btn-dark">Checkout</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>

<script>
"use strict";
    (function ($) {
            evaluateCartCount();
            evaluateSubTotal();
    })(jQuery);
</script>