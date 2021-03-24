<?php
    
    require('initialize.php');

    $site->addHeader();

    $product = new Product($db);

    $chosen = $product->getProduct($_GET['id']);

    $image = !empty($chosen['image']) ? $chosen['image'] : 'missing.jpg';

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

    // echo '<pre>';
    // print_r($chosen);

    // $price = settype($chosen['price'], "integer");
?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $db); ?>
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