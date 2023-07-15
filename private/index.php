<?php
    
    require('../initialize.php');

    global $session;

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../login?timedout=true' );
    }

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