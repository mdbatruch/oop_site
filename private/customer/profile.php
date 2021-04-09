<?php
    
    require('../../initialize.php');

    global $session;


    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    }

    $profile = Customer::view_customer_info($_SESSION['id'], $db);

    // echo '<pre>';
    // print_r($profile);

//  include('../includes/header.php');

 $site->addPrivateHeader();

?>

<header id="customer-header" class="container-fluid">
    <div class="row">
        <div id="customer-navigation">
            <?= $site->addPrivateCustomerNav(); ?>
        </div>
    </div>
</header>
<main class="customer-container">
    <div class="container">
        <div class="row">
            <div class="col col-12">
                <p>
                    Profile Settings for <?= $_SESSION['username']; ?>
                </p>
            </div>
            <div class="col col-md-6">
                <div class="profile">
                    <div class="profile-picture">
                        <img src="<?= root_url('uploads/' . $profile['avatar']); ?>" alt="<?= $profile['username']; ?> Picture" class="img-fluid rounded">
                    </div>
                    <div class="username"><?= $profile['username']; ?></div>
                    <div class="name"><?= $profile['first_name'] . ' ' . $profile['last_name']; ?></div>
                    <div class="address">
                        <?= $profile['address'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php 

    $site->addPrivateFooter();

?>