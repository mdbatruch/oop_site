<?php
    
    require('initialize.php');

    require_once('init.php');

    $site->addHeader();

    $product = new Product($db);

    $product_count = $product->count();

    $current_page = $_GET['page'] ?? 1;
    $per_page = 9;
    
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
                    <div class="col-10 img-container">
                        <div class='product-id'><?= "{$id}" ?></div>
                        <div class="image">
                            <img src="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" alt="<?= $row['name'] . ' Image'; ?>" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-12">
                        <a href='product.php?id=<?= $id ?>' class='product-link'>
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
                            <div data-id="<?= $id ?>" data-action="add-cart-products" class='btn btn-primary add-cart-products'>Add to Cart</div>
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
            <div class="container-fluid">
                <?= $pagination->page_links($url, $_GET['category']); ?>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>