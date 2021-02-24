<?php
    
    require('../../initialize.php');

    global $session;

    // print_r($_SESSION);

    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    } elseif ($_SESSION['id'] !== $_GET['id']) {
        header( 'location: index.php?id=' . $_SESSION['id']);
    }

    // include('includes/header.php');

?>

<header id="customer-header" class="container">
    <div class="row">
        <div id="customer-navigation">
            <ul>
                <li>
                    <a href="<?php echo root_url('index.php'); ?>" class="button">Back to Homepage</a>
                </li>
                <li>
                    <a href="<?php echo root_url_private('/customer/profile.php?id=' . $_SESSION['id']); ?>" class="button">Edit Profile</a>
                </li>
                <li>
                    <a href="<?php echo root_url_private('/customer/orders.php?id=' . $_SESSION['id']); ?>" class="button">View Orders</a>
                </li>
                <li>
                    <a href="<?php echo root_url('logout.php'); ?>" class="button">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <div class="row">
            <p>
                Customer Dashboard
            </p>
            <p>
                Welcome back, <?= $_SESSION['username']; ?>
            </p>
        </div>
    </div>
</main>
<?php 

// include('includes/footer.php'); 

?>