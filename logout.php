<?php
    require_once('initialize.php');

    $_SESSION['logout_message'] = 'You have successfully logged out.';

    $session->logout();

    header( 'location: ./login.php' );
?>
