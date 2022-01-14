<?php

  require('initialize.php');

  if (isset($_SESSION['account']) && $session->is_logged_in_as_customer($_SESSION['account'])) {
    header( 'location: private/customer/index.php' );
  }

  $subtotal = 0;

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);

            $subtotal = '';

            if ($products) {
                foreach ($products as $product_item) {
                    $product_item['price'] = substr($product_item['price'], 1);

                    $total = $product_item['price'] * $product_item['quantity'];
                    
                    $subtotal = intval($subtotal) + intval($total);
                }
            } else {
                $subtotal = 0;
            }
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

    } else {
        $count = 0;
        $items = null;
    }

  $site->addHeader();

?>
<header <?= !empty($_SESSION) && $_SESSION['account'] == 'Administrator' ? 'class="sticky-top"' : '';?>>
    <div class="header-container">
        <?php 
            if (!empty($_SESSION) && $_SESSION['account'] == 'Administrator') {
                $site->addAdminBar($site);
            } else {
                $site->addCartHeader($site, $count, $items, $subtotal, $db);
            } ?>
    </div>
</header>
<main class="login-registration">
    <div class="container">
        <div class="row">
            <div id="login-customer" class="customer-login-page col-12">
                <div class="row">
                <div class="col-12 col-md-6 pb-4 d-flex login-container">
                    <div class="login-option text-center">
                        <div>
                            <h3 class="mb-4 w-100">Login</h3>
                            <p class="mb-4">If you already have an account with us, click the button below to access your account to view your purchase history and manage your profile</p>
                            <a href="#" class="btn btn-black login-option-button">Login</a>
                        </div>
                    </div>
                    <?= $site->addCustomerLoginForm(); ?>
                </div>
                <div class="col-12 col-md-6 pb-4 d-flex register-container">
                    <div class="register-option text-center">
                        <div>
                            <h3 class="mb-4 w-100">Not a customer? <br/>Register an account now.</h3>
                            <p class="mb-4">
                                Register now to access your order status and history. Just fill in the fields, and we'll get a new account set up for you in no time.
                                We will only ask you for information necessary to make the purchase process faster and easier.
                            </p>
                            <a href="#" class="btn btn-black register-option-button">Register</a>
                        </div>
                    </div>
                    <?= $site->addCustomerRegistrationForm(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>