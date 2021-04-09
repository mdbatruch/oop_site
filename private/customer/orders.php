<?php
    
    require('../../initialize.php');

    global $session;


    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    }

    $profile = Customer::view_customer_info($_SESSION['id'], $db);

    // echo '<pre>';
    // print_r($profile);

    $site->addPrivateHeader();

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
            <p>
                Orders for <?= $_SESSION['username']; ?>
            </p>
            
        </div>
    </div>
</main>
<?php 

    $site->addPrivateFooter();

?>