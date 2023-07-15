<?php
    
    require('initialize.php');

    $site->addHeader();

    $action = isset($_GET['action']) ? $_GET['action'] : "";

    if (isset($_SESSION['account']) &&  ($_SESSION['account'] == 'Administrator')) {
        header('Location: index.php');
    }

    $product = new Product($db);

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

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

    $subtotal = '';

?>
<header>
    <?php $site->addCartHeader($site, $count, $items, $subtotal, $db); ?>
</header>
<main id="cart">
<div class="container-fluid">
    <div class="row cart-header justify-content-center">
        <div class="col-md-8 col-xxl-6 text-center">
            <h3>View Your Cart</h3>
            <div class="container-fluid link-container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <a href="<?= root_url('/'); ?>" class="btn btn-lightgrey py-3 my-2">Back to Homepage</a>
                    </div>
                    <div class="col-12 col-md-6">
                        <a href="<?= root_url('products'); ?>" class="btn btn-green py-3 my-2">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="container py-4">
    <div class="row">
        <div id="form-message"></div>
            <?php if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer' && !empty($products)) { ?>
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
                    <div class='product col col-12 col-md-12 my-2' data-id='<?= $product['id'] ?>' >
                        <div class='row'>
                            <div class='col col-12 col-md-4 p-3 d-flex product-title'>
                                <img src="<?= root_url('images/' . $product['image']); ?>" alt="<?= $product['name'] . ' Image'; ?>" class="img-fluid img-thumbnail">
                                <div class="title-container">
                                    <a href="<?= root_url('product?id=' . $product["id"]); ?>" class="product-title-link">
                                        <h5><?= $product['name']; ?></h5>
                                    </a>
                                    <div class="product-price mobile">
                                        <?= $product['price']; ?>
                                    </div>
                                    <div class="d-flex quantity-price mobile">
                                        <div class="adjust-quantity">
                                            <div class="adjust-container d-flex">
                                                <button class='btn remove-item' data-action='remove-item' data-id='<?= $product['id']; ?>' data-name='<?= $product['name']; ?>' data-price='<?= $product['price']; ?>' data-image='<?= $product['image']; ?>' data-quantity='<?= $product['quantity']; ?>'>-</button>
                                                    <p><span class='product-quantity'><?= $product['quantity']; ?></span></p>
                                                <button class='btn add-item' data-action='add-item' data-id='<?= $product['id']; ?>' data-name='<?= $product['name']; ?>' data-price='<?= $product['price']; ?>' data-image='<?= $product['image']; ?>' data-quantity='<?= $product['quantity']; ?>'>+</button>
                                            </div>
                                        </div>
                                        <p class="mb-0">$<span class='price'><?= $price; ?></span></p>
                                    </div>
                                </div>
                                <div class='col col-md-2 delete-product-cart mobile'>
                                    <button class='btn remove-item-full' data-action='remove-item-full' data-id='<?= $product['id']; ?>'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </button>
                                </div>   
                            </div>
                            <div class='col col-12 col-md-2 desktop'>
                                <?= $product['price']; ?>
                            </div>
                            <div class="col col-12 col-md-2 d-flex text-center adjust-quantity desktop">
                                <div class="adjust-container d-flex">
                                    <button class='btn remove-item' data-action='remove-item' data-id='<?= $product['id']; ?>' data-name='<?= $product['name']; ?>' data-price='<?= $product['price']; ?>' data-image='<?= $product['image']; ?>' data-quantity='<?= $product['quantity']; ?>'>-</button>
                                        <p><span class='product-quantity'><?= $product['quantity']; ?></span></p>
                                    <button class='btn add-item' data-action='add-item' data-id='<?= $product['id']; ?>' data-name='<?= $product['name']; ?>' data-price='<?= $product['price']; ?>' data-image='<?= $product['image']; ?>' data-quantity='<?= $product['quantity']; ?>'>+</button>
                                </div>
                            </div>
                            <div class='col col-12 col-md-2 desktop'>
                                <p>$<span class='price'><?= $price; ?></span></p>
                            </div>
                            <div class='col col-md-2 px-4 delete-product-cart desktop'>
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
                $site->addEmptyCart();
            } ?>
        </div>
        <?php if ($count >= 1 ) :?>
        <div class="row justify-content-end cart-totals">
            <div class="col col-sm col-md-2 quantity-total text-left d-none">
                Quantity
                <span class="cart-count-bottom"></span>
            </div>
            <div class="col col-12 col-md-4 sub-total text-left">
                <p>Cart Subtotal:</p>
                <span id="sub-total"></span>
                <p>Shipping calculated at checkout</p>
            </div>
            <div class="col col-12 col-md-8 checkout">
                <a href="<?= root_url('checkout'); ?>" class="btn btn-dark">Checkout</a>
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