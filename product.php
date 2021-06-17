<?php
    
    require('initialize.php');

    $site->addHeader();

    $product = new Product($db);

    // make sure product id exists and if not, return to products page
    $stmt = $product->getAllProducts();

    $product_exists = false;

    foreach($stmt as $id) {
        if ($_GET['id'] == $id) {
            $product_exists = true;
        }
    }

    if (!$product_exists) {
        header( 'location: products.php');
    }

    // end product id check

    // echo '<pre>';
    // print_r($stmt);

    $chosen = $product->getProduct($_GET['id']);

    $image = !empty($chosen['image']) ? $chosen['image'] : 'missing.jpg';

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

    foreach ($categories as $category) {
        if ($chosen['category_id'] == $category['id']) {
            // $category = $category['name'];

            if(!isset($chosen['category_name'])) {
                $chosen['category_name'] = '';
            }

            $chosen['category_name'] = $category['name'];
        }
    }

    $category_search = strtolower($chosen['category_name']);

    $category_search = preg_replace('/\s+/', '+', $category_search);

    // echo '<pre>';
    // print_r($chosen);

    // $price = settype($chosen['price'], "integer");
?>
<header <?= !empty($_SESSION) && $_SESSION['account'] == 'Administrator' ? 'class="sticky-top"' : '';?>>
    <div class="container-fluid p-0">
        <div class="row">
            <?php 
                if (!empty($_SESSION) && $_SESSION['account'] == 'Administrator') {
                    $site->addAdminBar($site);
                } else {
                    $site->addCartHeader($site, $count, $items, $db);
                } ?>
        </div>
    </div>
</header>
<main>
<div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-4 mt-4 ml-3">
                <h3>Products Page</h3>
            </div>
            <div id="product-info" data-id="<?= $chosen['id']; ?>" class='col-12 product-info'>
                <div class="container-fluid mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="image">
                                <img src="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" alt="<?= $chosen['name'] . ' Image'; ?>" id="product-image" class="rounded img-fluid">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h2 id="name"><?= $chosen['name']; ?></h2>
                            <div id="description"><?= $chosen['description']; ?></div>
                            <div class="categories">
                                <div>Categories:</div>
                                <h5>
                                    <a href="products.php?page=1&category=<?= $category_search; ?>"><?= $chosen['category_name']; ?></a>
                                </h5>
                            </div>
                            <div id="price" class="mb-2 mt-2"><?= "$" . number_format($chosen['price'], 2, '.', ','); ?></div>
                            <div class="count mb-2 mt-2">
                                Quantity
                                <select name="" id="quantity">
                                    <?php for ($i = 0; $i < 11; $i++) : ?>
                                        <option value="<?= $i; ?>"><?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div id="add-cart" data-id="<?= $chosen['id']; ?>" class='btn btn-primary w-100-pct add-cart'>Add to Cart</div>
                            <div id="cart-message"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>