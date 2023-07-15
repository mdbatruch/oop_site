<?php
    
    require('../../initialize.php');

    global $session;

    $order_count = Order::fetchAllOrdersCount($db);

    $current_page = $_GET['page'] ?? 1;

    $page_count = 5;

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login' );
    }

    $title = 'Orders';

    $site->addPrivateHeader($title);

    $pagination = new Pagination($current_page, $page_count, $order_count);

    $orders = Order::fetchAllOrders($db, $page_count, $pagination->offset());

    $url = root_url_private('orders/index.php');

    // start pagination limit
    $pagination_limit = $current_page * $page_count;

    if (!($pagination_limit - $order_count <= $page_count)) {
        header( 'location: index.php' );
    }

?>



<header id="admin-header" class="container-fluid">
    <div class="row">
        <?= $site->addPrivateAdminNav($title); ?>
    </div>
</header>
<main>
    <div class="container">
    <div class="row">
        <h2>Complete Customer Order List</h2>
    </div>
        <div class="row">
        <table>
                <tbody>
                    <?php foreach($orders as $order) : ?>
                        <tr>
                            <td>
                                <a href="order.php?id=<?= $order['id']; ?>" target="_blank">Order Id: <?= $order['id']; ?></a>
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
                <?= $pagination->page_links($url, $current_page); ?>
            </div>
        </div>
    </div>
</main>

<?php 

    $site->addPrivateFooter();

?>