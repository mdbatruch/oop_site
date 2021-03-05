<?php
    
    require('../../initialize.php');

    // echo $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini'

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login.php' );
    }

    
    $galleries = $site->find_all_galleries();

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
                    <a href="<?php echo root_url_private('galleries/new.php'); ?>" class="button">Create a New Gallery</a>
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
                <?php 
                
                // echo '<pre/>';
                // print_r($galleries);

                foreach($galleries as $gallery) : 
                    
                    $name = $gallery['title']; 
                    $gallery_id = $gallery['id'];
                    $slides = json_decode($gallery['slides']);

                    // print_r($slides);

                    $page_assoc = $site->find_by_id($gallery['page_id']);

                    ?>
                    <li class="gallery">
                    <h3><?= $name; ?></h3>
                    <div class="page-assoc">
                        <?php if ($page_assoc) : ?>    
                            Featured On <?= $page_assoc['title']; ?>
                        <?php endif; ?>
                    </div>
                        <a class="edit-<?= $name; ?>" href="<?php echo root_url_private('/galleries/edit.php?id=' . $gallery_id); ?>">
                            Edit
                        </a>
                        <?php foreach($slides as $slide) : ?>
                            <img src="<?php echo root_url('uploads/' . $slide); ?>" height="50px" width="50px" />
                        <?php endforeach; ?>
                        <div class="delete-gallery" data-id="<?= $gallery_id; ?>">Delete</div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="id01" class="modal">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <form class="modal-content" action="">
                <div class="container">
                <h3>Delete Gallery</h3>
                <p>Are you sure you want to delete this gallery?</p>

                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                    <button type="button" class="confirm-delete-gallery" data-id="">Delete</button>
                </div>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include('../includes/footer.php'); ?>