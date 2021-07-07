<?php
    
    require('../../initialize.php');

    // require_once('../../init.php');

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    $customer_count = Customer::fetchAllCustomersCount($db);

    $current_page = $_GET['page'] ?? 1;

    $page_count = 10;

    // echo $order_count;

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login.php' );
    }

    // start pagination limit
    $pagination_limit = $current_page * $page_count;

    if (!($pagination_limit - $customer_count <= $page_count)) {
        header( 'location: index.php' );
    } 

    // end pagination limit

    $title = 'Customers';

    $site->addPrivateHeader($title);

    $pagination = new Pagination($current_page, $page_count, $customer_count);

    $customers = Customer::fetchAllCustomers($db, $page_count, $pagination->offset());

    $url = root_url_private('customers/index.php');

    // echo '<pre>';
    // print_r($customers);

?>



<header id="admin-header" class="container-fluid">
    <div class="row">
        <?= $site->addPrivateAdminNav($title); ?>
    </div>
</header>
<main>
    <div class="container">
    <div class="row">
        <h2>Customer List</h2>
    </div>
        <div class="row">
        <table>
                <tbody>
                    <?php foreach($customers as $customer) : ?>
                        <tr>
                            <td>
                                <a href="customer.php?id=<?= $customer['id']; ?>">Customer Id: <?= $customer['id']; ?></a>
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