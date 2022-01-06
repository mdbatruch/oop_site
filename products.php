<?php
    
    require('initialize.php');

    require_once('init.php');

    $site->addHeader();

    $product = new Product($db);

    $product_count = $product->count();

    $current_page = $_GET['page'] ?? 1;
    $per_page = 10;
    
    $url = root_url('products.php');

    $categories = Category::getCategories($db);

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

    $category_filter = '';

    $categories = Category::getCategories($db);

    if (isset($_GET['category'])) {

        $filter_name = ucwords(preg_replace('/[^a-zA-Z0-9\']/', ' ', $_GET['category']));

        foreach ($categories as $category) {
            if ($category['name'] == $filter_name) {
                $category_filter = $category['id'];
            }
        }

        $cat_count = $product->categoryCount($category_filter);

        $pagination = new Pagination($current_page, $per_page, $cat_count);
        $stmt = $product->readByCategory($per_page, $pagination->offset(), $category_filter);

    } else {
        $_GET['category'] = null;
        $pagination = new Pagination($current_page, $per_page, $product_count);
        $stmt = $product->read($per_page, $pagination->offset());
    }

?>
<header <?= !empty($_SESSION) && $_SESSION['account'] == 'Administrator' ? 'class="sticky-top"' : '';?>>
    <div class="container-fluid p-0">
        <div class="row">
            <?php 
                if (!empty($_SESSION) && $_SESSION['account'] == 'Administrator') {
                    $site->addAdminBar($site);
                } else {
                    $site->addCartHeader($site, $count, $items, $subtotal, $db);
                } ?>
        </div>
    </div>
</header>
<main>
<div id="products" class="container">
    <div class="row d-none">
        <div class="col-10 mb-4 mt-4">
            <h3>Products Page</h3>
            <?php if (isset($_GET['category'])) : ?>
                <h5 class="filter-title">Filters</h5>
                <ul class="filters">
                    <li><?= $filter_name; ?></li>
                </ul>
                <button type="button" id="clear-category" class="btn btn-danger" data-dismiss="alert" aria-label="Close">Remove Category Filter</button>
            <?php endif; ?>
            <form>Sort By Category:
                <select id="categories">
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id']; ?>" <?= $_GET['category'] == $category['name'] ? 'selected="selected"' : '';?>><?= $category['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>  
    </div>  
    <div class="row row-cols-2 row-cols-lg-5 py-4">
            <?php
                            
                $loopExecuted = false;

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :

                    extract($row);

                      if (($row['category_id'] == $category_filter) || (!isset($_GET['category']))) :
                    ?>
                <div class='col mb-2 d-flex product-container'>
                    <div class="img-container">
                        <div class='product-id'><?= "{$id}" ?></div>
                        <div class="image">
                            <img src="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" alt="<?= $row['name'] . ' Image'; ?>" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <a href='product.php?id=<?= $id ?>' class='product-link title'>
                            <div class='name mb-1'>
                                <?= "{$name}"  ?>
                            </div>
                        </a>
                        <div class='mb-1 description d-none'>
                            <?= nl2br("{$description}"); ?>
                        </div>
                        <div class='mb-1 price' data-price="<?= $price; ?>">
                            <?= "$" . number_format($price, 2, '.', ','); ?>
                        </div>
                        <div class='mb-1'>
                            <div data-id="<?= $id ?>" data-action="add-cart-products" class="add-cart-products d-flex">
                                <div class="btn btn-primary btn-black cart-icon me-2 py-0 rounded-0">
                                    Add to Cart
                                </div>
                                <div class="arrow-right"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-plus p-1" viewBox="0 0 16 16">
                                    <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                </svg>
                            </div>
                            <a href="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" data-lightbox="photos">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-zoom-in p-1 <?= $id; ?>" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                                    <path d="M10.344 11.742c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1 6.538 6.538 0 0 1-1.398 1.4z"/>
                                    <path fill-rule="evenodd" d="M6.5 3a.5.5 0 0 1 .5.5V6h2.5a.5.5 0 0 1 0 1H7v2.5a.5.5 0 0 1-1 0V7H3.5a.5.5 0 0 1 0-1H6V3.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </a>
                            <div id="cart-message-<?= $id; ?>"></div>
                        </div>
                    </div>
                </div>
            <?php

            endif;

            $loopExecuted = true;

                endwhile;
            ?>
            <?php if (!$loopExecuted) : ?>
                <div class='col-md-4 mb-2'>
                    <div class="container-fluid">
                        <div class="row">
                            No Products Found!
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="container-fluid text-center">
                <div class="results">
                    <?= $pagination->show_range(); ?>
                </div>
                <?= $pagination->page_links($url, $_GET['category']); ?>
                <div class="back-to-top-container mb-4">
                    <div class="back-to-top d-inline-block">
                        Back to Top
                    </div>    
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>