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
<main>
    <div class="container">
        <div class="row">
            <table>
                <thead>
                    <tr>
                        Hello <?= ucfirst($_SESSION['username']); ?>, here are your Orders</thead>
                    </tr>
                    <tbody>
                        <?php foreach($orders as $order) : ?>
                        <tr>
                            <td>
                                <a href="order.php?index=<?= $order['id']; ?>" target="_blank">Order Id: <?= $order['id']; ?></a>
                            </td>
                            <td>
                                Shipping Details:
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
                            <td>Products: 
                                <?php foreach($order['products'] as $product) : ?>
                                    <span style="display: block;"><?= $product->item_name; ?> $<?= $product->item_price; ?> Quantity: <?= $product->item_quantity; ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td>Amount: <?= $order['amount']; ?></td>
                            <td>
                                Card Used:
                                <span><?= $card->card_type; ?></span>
                                <span>Ending with: <?= $card->card_hash; ?></span>
                            </td>
                            <td>Ordered: 
                                <?php $order_date = $order['created_at']; 
                                      $date = new DateTime($order_date);
                                      echo $date->format('l F j g:h a');
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <tbody>
            </table>
        </div>
        <div class="row">
            <div class="container-fluid">
                <?= $pagination->page_extra_links($url, $current_page); ?>
            </div>
        </div>
    </div>
</main>
<?php 

    $site->addPrivateFooter();

?>