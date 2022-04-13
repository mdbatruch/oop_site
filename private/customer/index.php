<?php
    
    require('../../initialize.php');

    global $session;

    // echo '<pre>';
    // print_r($_SESSION);

    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    } elseif ($_SESSION['id'] !== $_GET['id']) {
        header( 'location: index.php?id=' . $_SESSION['id']);
    }

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


    $title = 'Customer Dashboard';

    $site->addPrivateHeader($title);

    // $site->addHeader();
    
?>
<header id="customer-header" class="container-fluid">
    <div class="row" id="customer-navigation">
        <?php $site->addCustomerCart($site, $count, $items, $subtotal, $db); ?>
    </div>
</header>
<main class="customer-main">
    <div class="container-fluid">
        <div class="row customer-top justify-content-center py-4">
            <div class="col-md-10 col-xl-9 text-center">
                <h3>Welcome back, <?= $_SESSION['username']; ?></h3>
                <div class="container-fluid link-container">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <a href="<?php echo root_url_private('/customer/orders.php?id=' . $_SESSION['id']); ?>" class="btn btn-lightgrey py-3 my-2">View Past Orders</a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="<?php echo root_url_private('/customer/profile.php?id=' . $_SESSION['id']); ?>" class="btn btn-lightgrey py-3 my-2">Edit Profile</a>
                        </div>
                        <div class="col-12 col-md-4">
                            <a href="<?= root_url('products.php'); ?>" class="btn btn-lightgrey py-3 my-2">Start Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-none">
            <div class="col-12">
                <p>
                    Customer Dashboard
                </p>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addCustomerFooter(); ?>
</footer>