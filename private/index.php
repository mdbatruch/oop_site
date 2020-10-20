<?php
    
    require('../initialize.php');

    // echo $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini'

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    if (!$session->is_logged_in()) {
        header( 'location: ../login.php?timedout=true' );
    }

    // echo $session->username;

    include('includes/header.php');

?>

<header id="admin-header" class="container">
    <div class="row">
        <div id="admin-navigation">
            <ul>
                <li>
                    <a href="<?php echo root_url_private('pages/index.php'); ?>" class="button">Pages</a>
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
<?php include('includes/footer.php'); ?>