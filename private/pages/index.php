<?php
    
    require('../../initialize.php');

    // echo $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini'

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    if (!$session->is_logged_in()) {
        header( 'location: ../../login.php' );
    }

    
    $pages = $site::find_all_pages();
    // echo '<pre>';
    // print_r($pages);

    include('../includes/header.php');
?>



<header id="admin-header" class="container">
    <div class="row">
        <div id="admin-navigation">
            <ul>
                <li>
                    <a href="<?php echo root_url_private('index.php'); ?>" class="button">Dashboard</a>
                </li>
                <li>
                    <a href="<?php echo root_url_private('pages/new.php'); ?>" class="button">Create a New Page</a>
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
                        <a class="<?= $name; ?>" href="<?php echo root_url_private('/pages/index.php?id=' . $page_id); ?>">
                            <?= $name; ?>
                        </a>
                        <a class="edit-<?= $name; ?>" href="<?php echo root_url_private('/pages/edit.php?id=' . $page_id); ?>">
                            Edit
                        </a>
                        <div class="delete" data-id="<?= $page_id; ?>">Delete</div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>