<?php
    
    require('../initialize.php');

    // echo $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini'

    global $session;
    // echo '<pre>';
    // print_r($session);

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../login.php?timedout=true' );
    }

    // echo $session->username;

    $title = 'Dashboard';

    $site->addPrivateHeader($title);

?>

<header id="admin-header" class="container-fluid">
    <div class="row">
        <?= $site->addPrivateAdminNav($title); ?>
    </div>
</header>
<main>
    <div class="container">
        <div class="row">
            <p>
                Admin Dashboard
            </p>
        </div>
    </div>
</main>
<?php 

    $site->addPrivateFooter();

?>