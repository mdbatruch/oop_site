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

    $site->addPrivateHeader();

?>

<header id="admin-header" class="container">
    <div class="row">
        <div id="admin-navigation">
            <ul>
                <li>
                    <a href="<?php echo root_url_private('pages/index.php'); ?>" class="button">Pages</a>
                </li>
                <li>
                    <a href="<?php echo root_url_private('galleries/index.php'); ?>" class="button">Galleries</a>
                </li>
                <li>
                    <a href="<?php echo root_url_private('navigation/index.php'); ?>" class="button">Navigation</a>
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
                Admin Dashboard
            </p>
        </div>
    </div>
</main>
<?php 

    $site->addPrivateFooter();

?>