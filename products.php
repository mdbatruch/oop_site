<?php
    
    require('initialize.php');

    $site->addHeader();

    $product = new Product($db);

    $count = $product->count();

    // print_r($count);
    $stmt = $product->read(0, $count);

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
    // print_r($products);

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
            </div>
            <?php 
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                    extract($row);
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
          // include_once "paging.php";
            endwhile;    ?>
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>