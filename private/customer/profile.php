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

 $title = 'Customer Profile';

 $site->addPrivateHeader($title);

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
<footer class="pt-4 pb-4">
    <?php $site->addCustomerFooter(); ?>
</footer>