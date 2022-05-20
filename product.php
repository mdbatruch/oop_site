<?php
    
    require('initialize.php');

    $site->addHeader();

    $product = new Product($db);

    $page = 'Products';

    $subtotal = 0;

    // make sure product id exists and if not, return to products page
    $stmt = $product->getAllProducts();

    $product_exists = false;

    foreach($stmt as $id) {
        if ($_GET['id'] == $id) {
            $product_exists = true;
        }
    }

    if (!$product_exists) {
        header( 'location: products');
    }

    // end product id check

    $chosen = $product->getProduct($_GET['id']);

    $galleries = json_decode($chosen['product_gallery']);

    $image = !empty($chosen['image']) ? $chosen['image'] : 'missing.jpg';

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

    foreach ($categories as $category) {
        if ($chosen['category_id'] == $category['id']) {

            if(!isset($chosen['category_name'])) {
                $chosen['category_name'] = '';
            }

            $chosen['category_name'] = $category['name'];
        }
    }

    $category_search = strtolower($chosen['category_name']);

    $category_search = preg_replace('/\s+/', '+', $category_search);

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
<main id="ind-product">
<div class="container">
        <div class="row">
            <div class="col-12 mb-4 mt-4 d-flex breadcrumbs">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
                    <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                </svg>
                <?= $site->addbreadcrumbs($page, $chosen); ?>
            </div>
            <div id="product-info" data-id="<?= $chosen['id']; ?>" class='col-12 product-info'>
                <div class="row">
                    <div class="col-md-6 d-flex image-main-container">
                        <?php if ($galleries) : ?>
                            <div class="image-gallery d-flex">
                                <?php 
                                    $count = 0;
                                    foreach ($galleries as $singleimage) : 
                                    $count++;
                                ?>
                                    <img class="d-block img-fluid border" src="<?= !empty($singleimage) ? root_url('images/' . $singleimage) : root_url('images/missing.jpg'); ?>" data-order=<?= $count; ?>>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="image">
                            <img src="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" alt="<?= $chosen['name'] . ' Image'; ?>" id="product-image" class="border img-fluid">
                        </div>
                        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <div id="product-gallery" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php 
                                            if ($galleries) :
                                                $count = 0;
                                                foreach ($galleries as $singleimage) : 
                                                $count++;
                                        ?>
                                            <div class="carousel-item <?= $count == 1 ? 'active' : ''; ?>" data-order=<?= $count; ?>>
                                                <img class="d-block w-100" src="<?= !empty($singleimage) ? root_url('images/' . $singleimage) : root_url('images/missing.jpg'); ?>">
                                            </div>
                                        <?php endforeach;
                                            else : ?>
                                            <div class="image">
                                                <img src="<?= !empty($image) ? root_url('images/' . $image) : root_url('images/missing.jpg'); ?>" alt="<?= $chosen['name'] . ' Image'; ?>" id="product-image" class="border img-fluid">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#product-gallery" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#product-gallery" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-6 info-container">
                        <div class="name-price">
                            <h2 id="name"><?= $chosen['name']; ?></h2>
                            <div id="price" class="" data-price="<?= $chosen['price']; ?>"><?= "$" . number_format($chosen['price'], 2, '.', ','); ?></div>
                        </div>
                        <div id="description" class="my-2"><?= nl2br($chosen['description']); ?></div>
                        <div class="add-cart-container d-flex my-2">
                            <div class="count">
                                Quantity:
                                <select name="" id="quantity">
                                    <?php for ($i = 0; $i < 11; $i++) : ?>
                                        <option value="<?= $i; ?>"><?= $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div id="add-cart" data-id="<?= $chosen['id']; ?>" class='btn btn-primary btn-black w-100-pct ms-4 add-cart'>Add to Cart</div>
                        </div>
                        <div class="categories d-flex">
                            <div>Category:</div>
                            <h5 class="ms-2">
                                <a href="<?= root_url('products?page=1&category=' . $category_search . ''); ?>"><?= $chosen['category_name']; ?></a>
                            </h5>
                        </div>
                        <div class="disclaimer">
                            12+. <span>Warning.</span> Not suitable for children under 36 months. Small parts. Essential pointed components.
                        </div>
                        <div id="cart-message"></div>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="container-fluid">
                    <div class="col-12 delivery-returns">
                        <div class="row">
                            <div class="col-12 ">
                                <h4 class="mb-4">Delivery and Returns</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 product-ind-meta">
                                <h5>
                                    <a class="btn btn-primary pickup-tab" data-toggle="collapse" href="#pickup" role="button" aria-expanded="false" aria-controls="pickup">
                                        Free In-Store Pickup
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </a>
                                </h5>
                                <div class="collapse" id="pickup">
                                    <p>ALL orders are FREE to collect from our local store.</p>
                                </div>
                                <h5>
                                    <a class="btn btn-primary delivery-tab" data-toggle="collapse" href="#delivery" role="button" aria-expanded="false" aria-controls="delivery">
                                        Delivery
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </a>
                                </h5>
                                <div class="collapse" id="delivery">
                                    <p>
                                        Delivery is FREE for orders of CAD $80 or over, and from CAD $15 for orders under CAD $80.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8 product-ind-meta">
                                <h5>
                                    <a class="btn btn-primary returns-tab" data-toggle="collapse" href="#returns" role="button" aria-expanded="false" aria-controls="returns">
                                        Returns
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </a>
                                </h5>
                                <div class="collapse" id="returns">
                                    <p class="returns-desc">
                                        If for any reason at all, you're not satisfied with your purchase, you can return it to us for a refund, or exchange it for something else. No quibbles and no funny handshakes required. All we ask is the product still be in its original packaging and you have your proof of purchase and we'll be happy to help.
                                        <br/><br/>
                                        Just call our Customer Service team on 416-555-8910 or email them at info@castlegames.comand we will take care of this for you as quickly and simply as possible.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 copyright-disclaimer">
                                <p class="copyright-disclaimer-desc">
                                    &copy; 2022 New Line Productions, Inc. All rights reserved. The Lord of the Rings: The Fellowship of the Ring, The Lord of the Rings: The Two Towers, The Lord of the Rings: The Return of the King and the names of the characters, items, events and places therein are trademarks of The Saul Zaentz Company d/b/a Middle-earth Enterprises under license to New Line Productions, Inc.
                                    <br/><br/>
                                    &copy; Warner Bros. Entertainment Inc. All rights reserved. THE HOBBIT: AN UNEXPECTED JOURNEY, THE HOBBIT: THE DESOLATION OF SMAUG, THE HOBBIT: THE BATTLE OF THE FIVE ARMIES and the names of the characters, items, events and places therein are trademarks of The Saul Zaentz Company d/b/a Middle-earth Enterprises under license to New Line Productions, Inc.
                                </p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>