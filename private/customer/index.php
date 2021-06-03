<?php
    
    require('../../initialize.php');

    global $session;

    // echo '<pre>';
    // print_r($_SESSION);

    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    } elseif ($_SESSION['id'] !== $_GET['id']) {
        header( 'location: index.php?id=' . $_SESSION['id']);
    }

    $title = 'Customer Dashboard';

    $site->addPrivateHeader($title);

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
            <div class="col-12">
                <p>
                    Customer Dashboard
                </p>
            </div>
            <div class="col-12">
                <p>
                    Welcome back, <?= $_SESSION['username']; ?>
                </p>
            </div>
        </div>
    </div>
</main>
<?php 

    $site->addPrivateFooter();

?>