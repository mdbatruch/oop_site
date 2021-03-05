<?php
    
    require('../../initialize.php');

    // echo $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini'

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login.php' );
    }

    
    // $pages = $site->find_all_pages();

    // $pages = $site->find_nav_by_title('main-navigation');

    // $pages = json_decode($pages[0]['output']);

    // echo '<pre>';
    // print_r($pages);

    include('../includes/header.php');
?>

<style>

    body.dragging, body.dragging * {
        cursor: move !important;
    }

    .dragged {
        position: absolute;
        opacity: 0.5;
        z-index: 2000;
    }
    ol.navbar-nav {
        list-style-type: decimal; 
    }

    ol.example li.placeholder {
        position: relative;
        /** More li styles **/
    }
    ol.example li.placeholder:before {
        position: absolute;
        /** Define arrowhead **/
    }

</style>



<header id="admin-header" class="container">
    <div class="row">
        <div id="admin-navigation">
            <ul>
                <li>
                    <a href="<?php echo root_url_private('index.php'); ?>" class="button">Dashboard</a>
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
            <div class="min-12">
            <h1> Adjust Main Navigation </h1>
                <div id="form-message"></div>
            </div>
        </div>
        <div class="row nav-sort">
            <?php $site->addEditNav(); ?>
        </div>
        <div class="row">
            <button type="button" class="save-navigation" data-id="">Save Navigation</button>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>