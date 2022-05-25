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
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                        <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                        <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
                    </svg>
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