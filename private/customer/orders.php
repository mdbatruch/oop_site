<?php
    
    require('../../initialize.php');

    global $session;


    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    }

    $profile = Customer::view_customer_info($_SESSION['id'], $db);

    // echo '<pre>';
    // print_r($profile);

    $title = 'Customer Orders';

    $site->addPrivateHeader($title);

    $orders = Order::fetchOrders($_SESSION['id'], $db);

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
                        Hello <?= ucfirst($_SESSION['username']); ?>, here is your Order history</thead>
                    </tr>
                    <tbody>
                        <?php foreach($orders as $order) : ?>
                        <tr>
                            <td>Order Id: <?= $order['id']; ?></td>
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
    </div>
</main>
<?php 

    $site->addPrivateFooter();

?>