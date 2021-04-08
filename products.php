<?php
    
    require('initialize.php');

    $site->addHeader();

    $product = new Product($db);

    $product_count = $product->count();

    $current_page = $_GET['page'] ?? 1;
    $per_page = 9;
    // $pagination = new Pagination($current_page, $per_page, $product_count);

    $url = root_url('products.php');



    // $stmt = $product->read($per_page, $pagination->offset());

    // echo '<pre>';
    // print_r($stmt);
    // $stmt = $product->read(0, $product_count);


    $categories = Category::getCategories($db);

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $cart_id = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

    } else {
        $count = 0;
        $items = null;
    }

    $category_filter = '';

    if (isset($_GET['category'])) {

        $filter_name = ucwords(preg_replace('/[^a-zA-Z0-9\']/', ' ', $_GET['category']));

        foreach ($categories as $category) {
            if ($category['name'] == $filter_name) {
                $category_filter = $category['id'];
            }
        }

        // echo $category_filter;

        $cat_count = $product->categoryCount($category_filter);

        $pagination = new Pagination($current_page, $per_page, $cat_count);
        $stmt = $product->readByCategory($per_page, $pagination->offset(), $category_filter);
        // $stmt = $product->readByCategory($per_page, '', $category_filter);

        // echo '<pre>';
        // print_r($stmt);

    } else {
        $_GET['category'] = null;
        $pagination = new Pagination($current_page, $per_page, $product_count);
        $stmt = $product->read($per_page, $pagination->offset());
    }

    // echo $category_filter;
    // echo '<pre>';
    // print_r($categories);

?>
<header>
    <div class="container-fluid">
        <div class="row">
         <?php $site->addCartHeader($site, $count, $items, $db); ?>
        </div>
    </div>
</header>
<main>
<div id="products" class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4 mt-4">
                <h3>Products Page</h3>
                <?php if (isset($_GET['category'])) : ?>
                    <h5 class="filter-title">Filters</h5>
                    <ul class="filters">
                        <li><?= $filter_name; ?></li>
                    </ul>
                <?php endif; ?>
            </div>
            <?php
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                    // echo '<pre>';
                    // print_r($row);
                    extract($row);
                        if (($row['category_id'] == $category_filter) || (!isset($_GET['category']))) :
                    ?>
                <div class='col-md-4 mb-2'>
                    <div class="container-fluid">
                        <div class="row">
                        <div class="col-10 img-container">
                            <div class='product-id'><?= "{$id}" ?></div>
                            <div class="image">
                                <img src="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" alt="<?= $row['name'] . ' Image'; ?>" class="rounded img-fluid img-thumbnail">
                            </div>
                        </div>
                        <div class="col-12">
                            <a href='product.php?id=<?= $id ?>' class='product-link'>
                        
                                <div class='name mb-1'>
                                    <?= "{$name}"  ?>
                                </div>
                            </a>
                    
                            <div class='mb-1 description'>
                                <?= "{$description}"; ?>
                            </div>

                            <div class='mb-1 price'>
                                <?= "$" . number_format($price, 2, '.', ','); ?>
                            </div>
                        
                            <div class='mb-1'>
                                <div data-id="<?= $id ?>" data-action="add-cart-products" class='btn btn-primary add-cart-products'>Add to Cart</div>
                                <div id="cart-message-<?= $id; ?>"></div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                endif;
                endwhile;
            ?>
        </div>
        <div class="row">
            <div class="container-fluid">
                <?= $pagination->page_links($url, $_GET['category']); ?>
            </div>
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>