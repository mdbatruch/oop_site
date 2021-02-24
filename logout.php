<?php
    require_once('initialize.php');

    $_SESSION['logout_message'] = 'You have successfully logged out.';

    if ($_SESSION['account'] == 'Customer') {
        $customer = true;
    }

    $session->logout();

    if ($customer) {
        header( 'location: ./customer.php' );
    } else {
        header( 'location: ./login.php' );
    }
?>
