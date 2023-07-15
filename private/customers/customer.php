<?php
    
    require('../../initialize.php');

    global $session;

    $customer = Customer::view_customer_info($_GET['id'], $db);

    $current_page = $_GET['page'] ?? 1;

    $page_count = 10;

    $order_count = Order::fetchOrderCountById($_GET['id'], $db);

    $pagination = new Pagination($current_page, $page_count, $order_count);

    $orders = Order::fetchOrders($_GET['id'], $page_count, $pagination->offset(), $db);

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login' );
    }

    // start pagination limit
    $pagination_limit = $current_page * $page_count;

    if (!($pagination_limit - $order_count <= $page_count)) {
        header( 'location: customer?id=' .  $customer['id']);
    }

    $title = 'Customer Profile';

    $site->addPrivateHeader($title);

    $url = root_url_private('customers/customer?id=' . $customer['id']);

?>



<header id="admin-header" class="container-fluid">
    <div class="row">
        <?= $site->addPrivateAdminNav($title); ?>
    </div>
</header>
<main>
    <div class="container">
    <div class="row">
        <h2>Customer Profile for <?= $customer['username']; ?></h2>
    </div>
    <div class="row">
        <a href="<?= root_url_private('customers/index.php'); ?>"><< Back to Customer List</a>
    </div>
    <div class="row">
        <div class="col col-md-2">
            <img src="<?=  root_url('uploads/' . $customer['avatar']); ?>" alt="<?= $customer['first_name'] . " " . $customer['last_name']; ?>" class="img-fluid">
        </div>
    </div>
        <div class="row">
            <table>
                <tbody>
                    <tr>
                        <td>
                            Customer Id: <?= $customer['id']; ?>
                        </td>
                        <td>Username: <?= $customer['username']; ?></td>
                        <td>
                            Name: <?= $customer['first_name'] . " " . $customer['last_name']; ?>
                        </td>
                        <td>
                            Email: <?= $customer['email']; ?>
                        </td>
                        <td>
                            Address: <?= $customer['address']; ?>
                        </td>
                        <td>
                            Account Created: <?php 

                            $time = new DateTime($customer['created_at']);

                            $newtime = date_format($time, 'F j, Y');
                            
                            echo $newtime; ?>
                        </td>
                    </tr>
                <tbody>
            </table>
        </div>
        <div class="row">
            <h2>Orders by <?= $customer['username']; ?></h2>
            <table>
                <thead>
                    <tbody>
                        <?php foreach($orders as $order) : ?>
                        <tr>
                            <td>Order Id: <?= $order['id']; ?></td>
                            <td>Amount: <?= $order['amount']; ?></td>
                            <td>Ordered: 
                                <?php $order_date = $order['created_at']; 
                                      $date = new DateTime($order_date);
                                      echo $date->format('l F j g:h a');
                                ?>
                            </td>
                            <td>
                                <a href="order.php?index=<?= $order['id']; ?>" target="_blank">View Order</a>
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