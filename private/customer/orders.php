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
        <div class="row customer-header justify-content-center py-4">
            <div class="col-md-10 col-xl-9 text-center">
                <h3>Welcome back, <?= $_SESSION['username']; ?></h3>
                <div class="link-container d-flex justify-content-evenly">
                    <a href="<?php echo root_url_private('/customer/orders.php?id=' . $_SESSION['id']); ?>" class="btn btn-lightgrey py-3 my-2">View Past Orders</a>
                    <a href="<?php echo root_url_private('/customer/profile.php?id=' . $_SESSION['id']); ?>" class="btn btn-lightgrey py-3 my-2">Edit Profile</a>
                    <a href="<?= root_url('products.php'); ?>" class="btn btn-lightgrey py-3 my-2">Start Shopping</a>
                </div>
            </div>
        </div>
            <div class="container">
                <div class="row">
                    <table class="table w-auto orders-container">
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
                            <?php if (!empty($orders)) : ?>
                            <tbody>
                                    <?php foreach($orders as $order) : ?>
                                    <tr>
                                        <td class="order-id">
                                            Order #<?= $order['id']; ?>
                                        </td>
                                        <td class="date-ordered">
                                            <?php $order_date = $order['created_at']; 
                                                $date = new DateTime($order_date);
                                                echo $date->format('F t, Y; g:i A');
                                            ?>
                                        </td>
                                        <td class="order-status">
                                            Processing
                                            <div class="d-none">Products: 
                                                <?php foreach($order['products'] as $product) : ?>
                                                    <span style="display: block;"><?= $product->item_name; ?> $<?= $product->item_price; ?> Quantity: <?= $product->item_quantity; ?></span>
                                                <?php endforeach; ?>
                                            </div>
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
                                            <?php $card = json_decode($order['card_info']); ?>
                                            <?= $card->card_name ?? ''; ?><br/>
                                            <?= $card->card_hash; ?><br/>
                                            Expiry <?= $card->card_expiry ?? ''; ?><br/>
                                            <?= $card->card_type; ?>
                                        </td>
                                        <td><b><?= $order['amount']; ?></b></td>
                                        <td>
                                            <a href="order.php?index=<?= $order['id']; ?>" target="_blank">View Products</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                            <tbody>
                            <?php else: ?>
                                <tr>
                                    <td>
                                        <br/>Your order list is empty!
                                    </td>
                                </tr>
                            <?php endif; ?>
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
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addCustomerFooter(); ?>
</footer>