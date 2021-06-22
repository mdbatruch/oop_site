<?php
    
    require('../../initialize.php');

    global $session;

    $order = Order::fetchOrderbyId($_GET['index'], $db);

    // echo '<pre>';
    // print_r($order);

    // echo $order_count;

    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    } 
    
    // elseif ($_SESSION['id'] !== $_GET['id']) {
    //     header( 'location: index.php?id=' . $_SESSION['id']);
    // }

    $title = 'Individual Order Page';

    $site->addPrivateHeader($title);

?>



<header id="customer-header" class="container-fluid">
    <div class="row">
        <?= $site->addPrivateCustomerNav(); ?>
    </div>
</header>
<main>
    <div class="container">
    <div class="row">
        <h2>Order Description for <?= ucfirst($_SESSION['username']); ?></h2>
    </div>
    <div class="row">
        <a href="orders.php?id=<?= $_SESSION['id']; ?>"><< Back to your complete Order List</a>
    </div>
        <div class="row">
        <table>
                <tbody>
                        <tr>
                            <td>
                                Order Id: <?= $order[0]['id']; ?>
                            </td>
                            <td>
                                Shipping Details:
                                <?php $contact = json_decode($order[0]['contact_details']);
                                      $shipping = json_decode($order[0]['shipping_address']);
                                      $card = json_decode($order[0]['card_info']);
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
                                <?php foreach($order[0]['products'] as $product) : ?>
                                    <span style="display: block;"><?= $product->item_name; ?> $<?= $product->item_price; ?> Quantity: <?= $product->item_quantity; ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td>Amount: <?= $order[0]['amount']; ?></td>
                            <td>
                                Card Used:
                                <span><?= $card->card_type; ?></span>
                                <span>Ending with: <?= $card->card_hash; ?></span>
                            </td>
                            <td>Ordered: 
                                <?php $order_date = $order[0]['created_at']; 
                                      $date = new DateTime($order_date);
                                      echo $date->format('l F j g:h a');
                                ?>
                            </td>
                        </tr>
                <tbody>
            </table>
        </div>
    </div>
</main>

<?php 

    $site->addPrivateFooter();

?>