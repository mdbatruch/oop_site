<?php
    
    require('../../initialize.php');

    global $session;


    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    }

    $current_page = $_GET['page'] ?? 1;

    $page_count = 10;

    $order_count = Order::fetchOrderCountById($_GET['id'], $db);

    $profile = Customer::view_customer_info($_SESSION['id'], $db);

    // echo '<pre>';
    // print_r($profile);

    $title = 'Customer Orders';

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

    $site->addPrivateHeader($title);

    $pagination = new Pagination($current_page, $page_count, $order_count);

    $orders = Order::fetchOrders($_GET['id'], $page_count, $pagination->offset(), $db);

    // start pagination limit
    $pagination_limit = $current_page * $page_count;

    if (!($pagination_limit - $order_count <= $page_count)) {
        header( 'location: orders.php?id=' . $_GET['id']);
    } 

    // end pagination limit

    $url = root_url_private('customer/orders.php?id=' . $_GET['id']);

    // echo '<pre>';
    // print_r($orders);

?>

<header id="customer-header" class="container-fluid">
    <div class="row" id="customer-navigation">
        <?php $site->addCustomerCart($site, $count, $items, $subtotal, $db); ?>
    </div>
</header>
<main class="customer-main">
    <div class="container-fluid">
        <?= $site->addCustomerDashboard(); ?>
        <?php if (!empty($orders)) : ?>
            <div class="container">
                <div class="row">
                    <table class="table orders-container">
                        <thead>
                            <tr>
                            <th>Order ID</th>
                            <th>Order Placed</th>
                            <th>Status</th>
                            <th>Shipping Type</th>
                            <th>Shipping Details</th>
                            <th>Billing Information</th>
                            <th>Total</th>
                            <th></th>
                            </tr>
                        </thead>
                            <tbody>
                                    <?php foreach($orders as $order) : ?>
                                    <tr>
                                        <td class="order-id">
                                            Order #<?= $order['id']; ?>
                                        </td>
                                        <td class="date-ordered">
                                            <?php $order_date = $order['created_at']; 
                                                $date = new DateTime($order_date);
                                                echo $date->format('F t, Y;<\b\\r> g:i A');
                                            ?>
                                        </td>
                                        <td class="order-status">
                                            <span class="mobile">Status:</span> Processing
                                        </td>
                                        <td class="shipping-option">
                                            <?php $shipping_option = json_decode($order['shipping_information']); ?>
                                            <?= $shipping_option->name ?? 'N/A'; ?>
                                        </td>
                                        <td class="address">
                                            <?php $contact = json_decode($order['contact_details']);
                                                $shipping = json_decode($order['shipping_address']);
                                            ?>
                                            <?= $contact->name; ?><br/>
                                            <?= $shipping->street; ?> <?= $shipping->suite; ?><br/>
                                            <?= $shipping->city; ?>, <?= $shipping->province; ?> <?= $shipping->postal; ?><br/>
                                            <?= $contact->email; ?> | <?= $contact->phone; ?>
                                        </td>
                                        <td class="billing-information">
                                            <div class="desktop">
                                                <?php $card = json_decode($order['card_info']); ?>
                                                <?= $card->card_name ?? ''; ?><br/>
                                                <?= $card->card_hash; ?><br/>
                                                Expiry <?= $card->card_expiry ?? ''; ?><br/>
                                                <?= $card->card_type; ?>
                                            </div>
                                            <div class="mobile">
                                                <a href="" class="billing-details billing-pop" data-id="<?= $order['id']; ?>" target="_blank">
                                                    View Billing Details
                                                </a>
                                            </div>
                                            <div class="order-billing p-4 d-none" data-id="<?= $order['id']; ?>">
                                                <div class="order-billing-container">
                                                    <div class="close-button mb-3">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="billing-header d-flex">
                                                        <h4>Billing &amp; Shipping Details</h4>
                                                        <div class="order-number">
                                                            Order #<?= $order['id']; ?>
                                                        </div>
                                                    </div>
                                                    <div class="shipping-details my-4">
                                                        <div class="shipping-address">
                                                            <h6>Shipping Details</h6>
                                                            <?php $contact = json_decode($order['contact_details']);
                                                                $shipping = json_decode($order['shipping_address']);
                                                            ?>
                                                            <?= $contact->name; ?><br/>
                                                            <?= $shipping->street; ?> <?= $shipping->suite; ?><br/>
                                                            <?= $shipping->city; ?>, <?= $shipping->province; ?> <?= $shipping->postal; ?><br/>
                                                            <?= $contact->email; ?> | <?= $contact->phone; ?>
                                                        </div>
                                                        <div class="shipping-option mt-4">
                                                            <h6>Shipping Option</h6>
                                                            <?= $shipping_option->name ?? 'N/A'; ?>
                                                        </div>
                                                    </div>
                                                    <div class="billing-details mt-4">
                                                        <h6>Billing Details</h6>
                                                        <?php $card = json_decode($order['card_info']); ?>
                                                        <?= $card->card_name ?? ''; ?><br/>
                                                        <?= $card->card_hash; ?><br/>
                                                        Expiry <?= $card->card_expiry ?? ''; ?><br/>
                                                        <?= $card->card_type; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="order-amount"><b><?= $order['amount']; ?></b></td>
                                        <td class="order-link">
                                            <a href="order.php?index=<?= $order['id']; ?>" class="order-pop" data-id="<?= $order['id']; ?>" target="_blank">
                                                <span class="view-desktop desktop">
                                                    View Products
                                                </span>
                                                <img src="<?= root_url('uploads/maximize.png'); ?>" alt="View Order" class="img-fluid mobile maximize" />
                                            </a>
                                            <div class="order-products p-4 d-none" data-id="<?= $order['id']; ?>">
                                                <div class="order-products-container">
                                                    <div class="close-button mb-3">
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    </div>
                                                    <div class="products-header d-flex">
                                                        <h4>View Products</h4>
                                                        <div class="order-placed">
                                                            Order placed
                                                            <?php $order_date = $order['created_at']; 
                                                                $date = new DateTime($order_date);
                                                                echo $date->format('F t, Y; g:i A');
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="products-main">
                                                        <?php foreach($order['products'] as $product) {
                                                            // echo '<pre>';
                                                            // print_r($product);
                                                            $image = Product::getProductImage($product->item_name, $db);
                                                            if (!isset($product->item_id)) {
                                                                $product->item_id = "";
                                                            }
                                                            ?>

                                                            <div class="cart-product my-2 d-flex" data-id="<?= $product->item_id; ?>">
                                                                <div class="img-container">
                                                                    <a href="<?= root_url('product.php?id=' . $product->item_id); ?>" target="_blank">
                                                                        <img src="<?= !empty($image['image']) ? root_url('images/' . $image['image']) : root_url('images/missing.jpg'); ?>" alt="<?= $product->item_name; ?>" class="img-fluid border">
                                                                    </a>
                                                                </div>
                                                                <div class="order-info d-flex">
                                                                    <div class="product-order-info px-4">
                                                                        <div class="name">
                                                                            <b>Item:</b> <?= $product->item_name; ?>
                                                                        </div>
                                                                        <div class="quantity-container">
                                                                            <b>Quantity:</b> <span class='product-quantity'><?= $product->item_quantity; ?></span>
                                                                        </div>
                                                                        <div class="price">
                                                                            <b>Price:</b> <span class='product-price'><?= $product->item_individual_price ?? 'N/A'; ?></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-total">
                                                                        $<span class="price"><?= $product->item_price; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php   } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            <tbody>
                    </table>
                </div>
            </div>
        <div class="row">
            <div class="container-fluid text-center">
                <div class="results">
                    <?= $pagination->show_range(); ?>
                </div>
                <div class="pagination justify-content-center my-4">
                    <?= $pagination->order_links($url); ?>
                </div>
                <div class="back-to-top-container mb-4">
                    <div class="back-to-top d-inline-block">
                        Back to Top
                    </div>    
                </div>
            </div>
        </div>
        <?php else: ?>
            <div class="row">
                <div class="col my-4 text-center no-orders">
                    <img src="<?= root_url('uploads/empty-bag.png'); ?>" alt="Not Found" class="img-fluid">
                    <h3 class="my-4">No Orders to Display</h3>
                    <p class="my-4">
                        No orders have been placed through this account.
                    </p>
                    <a href="<?= root_url('products.php'); ?>" class="btn btn-black">Start Shopping</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addCustomerFooter(); ?>
</footer>