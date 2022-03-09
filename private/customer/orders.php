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
    <div class="row">
        <div id="customer-navigation">
            <?= $site->addPrivateCustomerNav(); ?>
        </div>
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
                    <table class="table w-auto">
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
                                        <td>
                                            Order #<?= $order['id']; ?>
                                        </td>
                                        <td>
                                            <?php $order_date = $order['created_at']; 
                                                $date = new DateTime($order_date);
                                                echo $date->format('l F j g:h a');
                                            ?>
                                        </td>
                                        <td>Products: 
                                            <?php foreach($order['products'] as $product) : ?>
                                                <span style="display: block;"><?= $product->item_name; ?> $<?= $product->item_price; ?> Quantity: <?= $product->item_quantity; ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                        <td></td>
                                        <td>
                                            <?php $contact = json_decode($order['contact_details']);
                                                $shipping = json_decode($order['shipping_address']);
                                                $card = json_decode($order['card_info']);
                                            ?>
                                            <span><?= $contact->name; ?></span>
                                            <span><?= $contact->phone; ?></span>
                                            <span><?= $contact->email; ?></span>
                                            <span><?= $shipping->street; ?></span>
                                            <span><?= $shipping->suite; ?></span>
                                            <span><?= $shipping->city; ?></span>
                                            <span><?= $shipping->province; ?></span>
                                            <span><?= $shipping->postal; ?></span>
                                        </td>
                                        <td>
                                            <span><?= $card->card_type; ?></span>
                                            <span>Ending with: <?= $card->card_hash; ?></span>
                                        </td>
                                        <td><?= $order['amount']; ?></td>
                                        <td>
                                            <a href="order.php?index=<?= $order['id']; ?>" target="_blank">View Order</a>
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
            <div class="container-fluid">
                <?= $pagination->page_extra_links($url, $current_page); ?>
            </div>
        </div>
    </div>
</main>
<footer class="pt-4 pb-4">
    <?php $site->addCustomerFooter(); ?>
</footer>