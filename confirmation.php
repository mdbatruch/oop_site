<?php
    
    require('initialize.php');

    $order = Order::fetchOrderbyId($_GET['order'], $db);

    if (empty($_SESSION)) {
        header('Location: cart.php');
    }

    if ($_SESSION['account'] == 'Administrator') {
        header('Location: index.php');
    }

    // this needs more work to prevent users from revisiting success page

    if ($_SESSION['id'] == $order[0]['customer_id']) {

        if (isset($_SESSION['orders'])) {
            foreach ($_SESSION['orders'] as $key => $value) {
                //check if this is not the first time the page has been viewed
                if($_GET['order'] == $value) {
                
                    unset($_SESSION['order_success']);
                    header('location: index.php');

                    session_write_close();
                    exit();
                }
            }
        }
    } else {
        header('location: index.php');
        exit();
    }

    $site->addHeader();

    $action = isset($_GET['action']) ? $_GET['action'] : "";

    $name = Customer::view_customer_info($order[0]['customer_id'], $db);

    $customer = $order[0]['customer_id'];

    $time = new DateTime($order[0]['created_at']);

    $date = date_format($time, 'm/d/Y');

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

    // echo '<pre>';
    // print_r($order);

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $subtotal, $db); ?>
        </div>
    </div>
</header>
<main id="cart">
    <div class="container-fluid">
        <div class="d-flex justify-content-center row pb-4">
            <div class="confirmation-container my-4 col-md-8">
            <div class="progress-container">
                <ul id="progressbar">
                    <li class="active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg> 
                        <span>
                            Customer Info
                        </span>
                    </li>
                    <li class="active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        <span>
                            Shipping &amp; Billing
                        </span>
                    </li>
                    <li class="active">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        <span>
                            Review
                        </span>
                    </li>
                </ul>
            </div>
                <div class="message d-flex p-4">
                    <div class="icon-container">
                        <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>
                    <div class="inner-message">
                        <span class="text-success"> Thank you, we've received your order </span> <br/>
                        A confirmation of this order will be sent to <strong><?= json_decode($order[0]['contact_details'])->email; ?></strong>
                    </div>
                </div>
                <div class="time py-4">
                    <?= date('D M j Y h:i:s A'); ?>
                </div>
                <div>
                    <div class="order-container">
                        <h4>Order Confirmation #<?= $order[0]['id']; ?></h4>
                        <div class="order-inner-container d-flex justify-content-between py-4">
                            <div class="billing-details my-2">
                                <h6>Billing Details:</h6>
                                <?php
                                    // card variable also used on lines 200
                                    $card = json_decode($order[0]['card_info']);
                                    $customer_info = json_decode($order[0]['contact_details']);
                                    $billing_address = json_decode($order[0]['billing_address']); 
                                ?>
                                <div class="billing-address-details">
                                    <span class="d-block billing-name">
                                        <?= $card->card_name; ?>
                                    </span>
                                    <span class="address d-block">
                                    <?= $billing_address->street . '<br/>'; ?>
                                    <?= $billing_address->suite; ?>
                                    </span>
                                    <span class="city"><?= $billing_address->city; ?></span>
                                    <span class="province"><?= $billing_address->province; ?></span>
                                    <span class="postal"><?= $billing_address->postal; ?></span>
                                    <span class="country d-block">Canada</span>
                                    <span class="phone d-block"><?= $customer_info->phone; ?></span>
                                    <span class="email d-block"><?= $customer_info->email; ?></span>
                                </div>
                            </div>
                            <div class="shipping-method my-2">
                                <h6>Shipping Method:</h6>
                                <?php $shipping_information = json_decode($order[0]['shipping_information']); ?>
                                <span class="shipping-name d-block"><?= $shipping_information->name; ?></span>
                                <?= nl2br($shipping_information->option); ?>
                            </div>
                            <div class="notes my-2">
                                <h6>Order Notes:</h6>
                                <?= $shipping_information->order_info; ?>
                            </div>
                        </div>
                    </div>
                    <div class="order-summary pb-3">
                    <h4>Order Summary</h4>
                        <div class="col col-sm-12 item-list my-4">
                            <div class="row titles">
                                <div class='col col-md-6'>
                                    Your Items
                                </div>
                                <div class='col col-md-2'>
                                    Quantity
                                </div>
                                <div class='col col-md-2'>
                                    Price
                                </div>
                                <div class='col col-md-2'>
                                    Total
                                </div>
                            </div>
                        </div>
                        <?php foreach($order[0]['products'] as $product) :
                            $image = Product::getProductImage($product->item_name, $db);
                            ?>
                            <div class='product col col-12 col-md-12 my-2' data-id='<?= $product->item_id; ?>' >
                                <div class='row'>
                                    <div class='col col-12 col-md-6 product-title'>
                                    <div class="img-container">
                                        <img src="<?= !empty($image['image']) ? root_url('images/' . $image['image']) : root_url('images/missing.jpg'); ?>" alt="<?= $product->item_name; ?>" class="rounded img-fluid img-thumbnail">
                                    </div>
                                    <div class="product-info d-flex">
                                        <a href="<?= root_url('product.php?id=' . $product->item_id); ?>" class="product-title-link">
                                            <h5><?= $product->item_name; ?></h5>
                                        </a>
                                        <div class="quantity-mobile">
                                            <?= $product->item_quantity; ?>
                                        </div>
                                        <div class="ind-price-mobile">
                                            Price: <?= $product->item_individual_price; ?>
                                        </div>
                                        <div class="price-mobile">
                                            $<?= $product->item_price; ?>
                                        </div>
                                    </div>
                                    </div>
                                    <div class='col col-12 col-md-2 desktop'>
                                        <?= $product->item_quantity; ?>
                                    </div>
                                    <div class='col col-12 col-md-2 d-flex text-center desktop'>
                                        <?= $product->item_individual_price; ?>
                                    </div>
                                    <div class='col col-12 col-md-2 desktop'>
                                        <p>$<span class='price'><?= $product->item_price; ?></span></p>
                                    </div>
                                    <div class='col col-md-2 px-4 desktop'>

                                    </div>    
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="totals">
                        <div class="tax-subtotal container-fluid pb-3 px-0 my-4">
                            <?php $taxes_subtotals = json_decode($order[0]['taxes_subtotals']); ?>
                            <div class="row subtotal-sub my-2">
                                <div class="col-sm-6 col-md-8"></div>
                                <div class="col-6 col-sm-3 col-md-2 label">
                                    <h6>
                                        Subtotal
                                    </h6>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 value">
                                    <?= $taxes_subtotals->subtotal; ?>                          
                                </div>
                            </div>
                            <div class="row hst-sub my-2">
                                <div class="col-sm-6 col-md-8"></div>
                                <div class="col-6 col-sm-3 col-md-2 label">
                                    <h6>
                                        HST 13%
                                    </h6>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 value">
                                    <?= $taxes_subtotals->hst; ?>                          
                                </div>
                            </div>
                            <div class="row shipping-sub my-2">
                                <div class="col-sm-6 col-md-8"></div>
                                <div class="col-6 col-sm-3 col-md-2 label">
                                    <h6>
                                        <?= $shipping_information->name; ?>
                                    </h6>
                                </div>
                                <div class="col-6 col-sm-3 col-md-2 value">
                                    <?= $shipping_information->price; ?>                        
                                </div>
                            </div>
                        </div>
                        <div class="payment-info container-fluid px-0 mb-4">
                            <div class="row">
                                <div class="card-info col-sm-8">
                                    <div class="card-name">
                                        <?= $card->card_name; ?>
                                    </div>
                                    <div class="card-hash">
                                        <?= $card->card_hash; ?>
                                    </div>
                                    <div class="card-expiry">
                                        <?= $card->card_expiry; ?>
                                    </div>
                                    <div class="card-type">
                                        <?= $card->card_type; ?>
                                    </div>
                                </div>
                                <div class="order-amount col-sm-4 d-flex my-4 justify-content-between">
                                    <div class="title">
                                        Paid
                                    </div>
                                    <div class="paid">
                                        <?= $order[0]['amount']; ?> CAD
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="links d-flex justify-content-between">
                    <a href="<?php echo root_url('products.php'); ?>" class="btn btn-outline-dark w-100 py-3 my-2">Continue Shopping</a>
                    <a href="<?php echo root_url('index.php'); ?>" class="btn btn-outline-dark w-100 py-3 my-2">Back to Homepage</a>
                    <a href="<?php echo root_url_private('customer/orders.php?id=' . $customer); ?>" class="btn btn-outline-dark w-100 py-3 my-2">View your Orders</a>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addFooter(); ?>
</footer>