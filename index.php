<?php
    
    require('initialize.php');

    $pages = $site->find_all_pages();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id=1;
    }

    if ($_GET['id'] == 0 || $_GET['id'] == null) {
        header('Location: index.php?id=1');
    }
    

    // Process all pages in one pass
     foreach($pages as $row) {
        if($row['id'] == $id) {
            //Requested Page
            $page = $row['page'];
            $title = $row['title'];
            $subtitle = $row['subtitle'];
            $description = $row['description'];
            
            break;

        }

    }


    $page = new Page($title, $description, $db);

    if ($title == NULL && $description == NULL) {
        header('Location: index.php?id=1');
    }

    $site->setPage($page);

    $gallery = $site->findSliderByPageId($id);

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

    
    $site->addHeader($title);

?>
<?php if (isset($_SESSION['account']) && $_SESSION['account'] == 'Administrator') : ?>
    <div class="admin-bar col-12 sticky-top">
        <div class="container-fluid admin-bar-inner">
            <div class="row">
                <div class="col-md-10 admin">
                Hello, <?= $_SESSION['username']; ?>
                    <a href="<?= root_url_private('index.php'); ?>">
                        Return to Dashboard
                    </a>
                </div>
                <div class="col-md-2 logout">
                    <a href="<?= root_url('logout.php'); ?>" class="button">Logout</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<header>
    <div class="header-container">
        <?php 
            if (!empty($_SESSION) && $_SESSION['account'] == 'Administrator') {
                $site->addAdminBar($site);
            } else {
                $site->addCartHeader($site, $count, $items, $subtotal, $db);
            } ?>
    </div>
</header>
<main class="<?= $page->isHome() ? 'home': '';?> pb-4">

    <?php if ($page->isHome()) : ?>
        <div class="container-fluid">
            <?php 
                include 'components/homepage/pill-component.php';
            ?>
        </div>
    <?php endif; ?>

<div class="container-fluid">
        <div class="row">
        <?php if ($gallery) :?>
                <?= $site->addSlider(); ?>
        <?php endif; ?>
        </div>
        <div class="row justify-content-center">
            <div class="col-10 page-content">
                <p>
                    <?php $site->render(); ?>
                </p>
            </div>
        </div>
        <?php if ($page->isHome()) : ?>
            <?php 
    
            include 'components/homepage/set-component.php'; 
            include 'components/homepage/featured-component.php';
            include 'components/homepage/single-banner-component.php';
            include 'components/homepage/promos-component.php';
            include 'components/homepage/latest-component.php';

            ?>
        <?php endif; ?>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>