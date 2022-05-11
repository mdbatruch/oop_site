<?php
    
    require('initialize.php');

    $pages = $site->find_all_pages();

    $title = 'Faq';
    $description = '';

    $page = new Page($title, $description, $db);
    $site->setPage($page);

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
<main class="pb-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-10 page-content">
                <p>
                    <?php $site->render(); ?>
                </p>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>