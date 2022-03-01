<?php 
    $cart_item = new CartItem($db);

    $items = $cart_item->get_cart($_SESSION['id']);

    $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);

    // echo '<pre>';
    // print_r($products);
?>
<div class="cart-menu">
    <div class="header d-flex p-4">
        <h3>Shopping Cart</h3>
        <div class="close-button d-flex">
            Close
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    </div>
    <div class="cart-summary-slider m-4">
        <?php
            foreach ($products as $product) {
                $price = substr($product['price'], 1) * $product['quantity']; ?>

                <div class="cart-product my-2 d-flex" data-id="<?= $product['id']; ?>">
                    <div class="img-container">
                        <a href="<?= root_url('product.php?id=' . $product["id"]); ?>">
                            <img src="<?= root_url('images/' . $product['image']); ?>" alt="" class="img-fluid">
                        </a>
                    </div>
                    <div class="product-order-info px-4">
                        <h5>
                            <?= $product['name']; ?>
                        </h5>
                        <div class="quantity-container">
                            <span class='product-quantity'><?= $product['quantity'] ?></span> x <span class="price"><?= $product['price'] ?></span>
                        </div>
                        <div class='delete-product-cart'>
                            <button class='btn remove-item-full-cart' data-action='remove-item-full' data-id='<?= $product['id']; ?>'>
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div id="cart-message"></div>
        <?php   } ?>
    </div>
    <div class="order-total d-flex py-3 mx-4">
        <div class="subtotal-title">Subtotal</div>
        <div id="cart-sub-total"></div>
    </div>
    <div class="cta mx-4">
        <div class="link-container d-flex justify-content-evenly mt-4">
            <a href="<?= root_url('cart.php'); ?>" class="btn btn-black py-3">View Cart</a>
            <a href="<?= root_url('checkout.php'); ?>" class="btn btn-green py-3">Checkout</a>
        </div> 
    </div>
</div>