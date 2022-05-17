<?php
    
    require('../../initialize.php');

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login.php' );
    }

    $title = 'Edit Main Navigation';

    $site->addPrivateHeader($title);
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



<header id="admin-header" class="container-fluid">
    <div class="row">
        <?= $site->addPrivateAdminNav($title); ?>
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
            <div class="col col-md-6">
                <?php $site->addEditNav(); ?>
            </div>
        </div>
        <div class="row nav-save">
            <button type="button" id="save-navigation" class="save-navigation btn btn-secondary mt-2 mb-2" data-id="">Save Navigation</button>
        </div>
    </div>
</main>

<?php 

    $site->addPrivateFooter();

?>