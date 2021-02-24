<?php
    
    require('../../initialize.php');

    global $session;


    if (!$session->is_logged_in_as_customer($_SESSION['account'])) {
        header( 'location: ../../customer.php?timedout=true' );
    }

    $profile = Customer::view_customer_info($_SESSION['id'], $db);

    // echo '<pre>';
    // print_r($profile);

?>

<header id="customer-header" class="container">
    <div class="row">
        <div id="customer-navigation">
            <ul>
                <li>
                    <a href="<?php echo root_url_private('/customer/index.php?id=' . $_SESSION['id']); ?>" class="button">Back to Dashboard</a>
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
                Orders for <?= $_SESSION['username']; ?>
            </p>
            
        </div>
    </div>
</main>
<?php 

// include('includes/footer.php'); 

?>