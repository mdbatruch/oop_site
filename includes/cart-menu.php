<div class="cart-menu">
    <div class="header d-flex p-4">
        <h3>Shopping Cart</h3>
        <div class="close-button d-flex">
            Close
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    </div>
    <div class="cta">
        <div class="link-container d-flex justify-content-evenly">
            <a href="<?= root_url('cart.php'); ?>" class="btn btn-black py-3 m-2">View Cart</a>
            <a href="<?= root_url('checkout.php'); ?>" class="btn btn-green py-3 m-2">Checkout</a>
        </div> 
    </div>
</div>