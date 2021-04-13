<?php
    
    require('../../initialize.php');

    // echo $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini'

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login.php' );
    }

    
    $pages = $site->find_all_pages();
    // echo '<pre>';
    // print_r($pages);

    $title = 'Pages';

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
            <div class="min-12">
                <div id="form-message"></div>
            </div>
        </div>
        <div class="row">
            <ul>
                <?php foreach($pages as $page) : 
                    
                    $name = $page['page']; 
                    $page_id = $page['id'];
                    ?>
                    <li class="page">
                        <h3>
                            <a class="<?= $name; ?>" href="<?php echo root_url_private('/pages/index.php?id=' . $page_id); ?>">
                                <?= $name; ?>
                            </a>
                        </h3>
                        <a class="edit-<?= $name; ?> btn btn-info" href="<?php echo root_url_private('/pages/edit.php?id=' . $page_id); ?>">
                            Edit
                        </a>
                        <div class="delete btn btn-danger" data-id="<?= $page_id; ?>">Delete</div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</main>

<?php 

    $site->addPrivateFooter();

?>