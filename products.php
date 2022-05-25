<?php
    
    require('initialize.php');

    require_once('init.php');

    $site->addHeader();

    $product = new Product($db);

    $page = 'Products';

    $product_count = $product->count();

    $current_page = $_GET['page'] ?? 1;
    $per_page = 10;

    $subtotal = 0;
    
    $url = root_url('products');

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

    } else if (isset($_GET['filter'])) {

        $filter = preg_replace('/[^a-zA-Z0-9\']/', ' ', $_GET['filter']);

        $pagination = new Pagination($current_page, $per_page, $product_count);

        switch($filter){
            case 'highest':
                $stmt = $product->getByHighest($per_page, $pagination->offset());
            break;
            case 'lowest':
                $stmt = $product->getByLowest($per_page, $pagination->offset());
            break;
            case 'ascending':
                $stmt = $product->getByNameAsc($per_page, $pagination->offset());
            break;
            case 'descending':
                $stmt = $product->getByNameDesc($per_page, $pagination->offset());
            break;
        }
    } else if (isset($_GET['range'])) {

        $range = trim($_GET['range']);

        switch($range){
            case 'all':
                $stmt = $product->getRange($per_page, '', 0, 99999);

                $count = $stmt->rowCount();

                $pagination = new Pagination($current_page, $per_page, $count);
            break;
            
            case '0-50':
                $stmt = $product->getRange($per_page, '', 0, 50);

                $count = $stmt->rowCount();

                $pagination = new Pagination($current_page, $per_page, $count);
            break;

            case '50-150':
                $stmt = $product->getRange($per_page, '', 50, 150);

                $count = $stmt->rowCount();

                $pagination = new Pagination($current_page, $per_page, $count);
            break;

            case '150-500':
                $stmt = $product->getRange($per_page, '', 150, 500);

                $count = $stmt->rowCount();

                $pagination = new Pagination($current_page, $per_page, $count);

            break;

            case '500':
                $stmt = $product->getRange($per_page, '', 500, 99999);

                $count = $stmt->rowCount();

                $pagination = new Pagination($current_page, $per_page, $count);
            break;
        }
    } else {
        $_GET['category'] = null;
        $pagination = new Pagination($current_page, $per_page, $product_count);
        $stmt = $product->read($per_page, $pagination->offset());

    }
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
<main class="products">
<?php if (isset($_GET['category'])) : ?>
    <?= $site->addCategoryBar($category); ?>
<?php endif; ?>
<div id="products" class="container">
    <div class="row top-products">
        <div class="container-fluid">
            <div class="top-products-inner d-flex justify-content-between py-4">
                <div class="breadcrumbs d-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                    </svg>
                    <?php if (isset($_GET['category'])) : ?>
                        <?= $site->addProductsBreadcrumbs($page, $_GET['category']); ?>
                    <?php else : ?>
                        <?= $site->addProductsBreadcrumbs($page, ''); ?>
                    <?php endif; ?>
                </div>
                <div class="page-info d-flex">
                    <?php if (isset($_GET['category'])) : ?>
                        <div class="results-pagination d-flex">
                            <div class="results-container">
                                <h4>
                                    Results for <?= isset($_GET['category']) ? '"' . ucwords($_GET['category']) . '"' : $value; ?>
                                </h4>
                            </div>
                            <div class="pagination-container d-flex">
                                <div class="results pe-2">
                                    <?= $pagination->show_range(); ?>
                                </div>
                                <span>|</span> 
                                <div class="pagination-top">
                                    <?= $pagination->page_links($url, ''); ?>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="pagination-container d-flex">
                            <div class="results pe-2">
                                <?= $pagination->show_range(); ?>
                            </div>
                            | 
                            <div class="pagination-top">
                                <?= $pagination->page_links($url, ''); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="search-filter-container d-flex">
                        <div class="search"><div id="root"></div></div>
                        <div class="filter-container ms-4">
                            <p class="mb-0">
                                <a class="close-outer" data-toggle="collapse" href="#filterCollapse" role="button" aria-expanded="false" aria-controls="filterCollapse">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
                                        <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
                                    </svg>    
                                    Filter
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="toggle-filters px-2">
                <div class="collapse" id="filterCollapse">
                    <div class="card card-body d-flex">
                        <div class="title">
                            <h5>Filters</h5>
                            <a class="close-inner" data-toggle="collapse" href="#filterCollapse" role="button" aria-expanded="false" aria-controls="filterCollapse">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="sort">
                            <div class="sort-container" data-toggle="collapse" href="#sort-by" role="button" aria-expanded="false" aria-controls="sort-by">
                                <h5 class="sort-by">Sort By</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </div>
                            <ul id="sort-by" class="collapse">
                                <li><a href="<?= root_url('products?page=1&filter=lowest'); ?>">Price: Low to High</a></li>
                                <li><a href="<?= root_url('products?page=1&filter=highest'); ?>">Price: High to Low</a></li>
                                <li><a href="<?= root_url('products?page=1&filter=ascending'); ?>">Alphabetical A-Z</a></li>
                                <li><a href="<?= root_url('products?page=1&filter=descending'); ?>">Alphabetical Z-A</a></li>
                            </ul>
                        </div>
                        <div class="price">
                            <div class="price-container" data-toggle="collapse" href="#price-by" role="button" aria-expanded="false" aria-controls="price-by">
                                <h5 class="price-by">Price</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </div>
                            <ul id="price-by" class="collapse">
                                <li> <input type="checkbox" class="me-2" value="all"> All</li>
                                <li> <input type="checkbox" class="me-2" value="0-50"> $0.00 - $50.00</li>
                                <li> <input type="checkbox" class="me-2" value="50-150"> $50.00 - $150.00</li>
                                <li> <input type="checkbox" class="me-2" value="150-500"> $150.00 - $500.00</li>
                                <li> <input type="checkbox" class="me-2" value="500+"> $500.00 +</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cols-2 row-cols-lg-5 py-4">
            <?php
                            
                $loopExecuted = false;

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :

                    extract($row);

                      if (($row['category_id'] == $category_filter) || (!isset($_GET['category']))) :
                    ?>
                <div class="col mb-2 d-flex">
                    <div class="product-container">
                    <div class="img-container">
                        <div class='product-id'><?= "{$id}" ?></div>
                        <div class="image">
                            <img src="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" alt="<?= $row['name'] . ' Image'; ?>" class="img-fluid">
                        </div>
                    </div>
                    <div class="meta-container col-12 mt-2 d-flex">
                        <div class="item-meta">
                            <a href='product?id=<?= $id ?>' class='product-link title'>
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
                        </div>
                        <div class='mb-1 product-icons'>
                            <div data-id="<?= $id ?>" data-action="add-cart-products" class="add-cart-products d-flex">
                                <div class="btn btn-primary btn-black cart-icon d-flex me-2 py-0 rounded-0">
                                    Add to Cart
                                </div>
                                <div class="arrow-right"></div>
                                <div class="icon-container">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cart-plus p-1" viewBox="0 0 16 16">
                                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <a href="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" class="zoom" data-lightbox="photos">
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
                <div class="pagination justify-content-center my-4">
                    <?= $pagination->page_links($url, '', '', ''); ?>
                </div>
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