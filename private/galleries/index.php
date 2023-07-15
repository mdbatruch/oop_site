<?php
    
    require('../../initialize.php');

    global $session;

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login' );
    }

    $galleries = $site->find_all_galleries();

    $title = 'Gallery List';

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
                <?php 
                
                foreach($galleries as $gallery) : 
                    
                    $name = $gallery['title']; 
                    $gallery_id = $gallery['id'];
                    $slides = json_decode($gallery['slides']);

                    $page_assoc = $site->find_by_id($gallery['page_id']);

                    ?>
                    <li class="gallery">
                    <h3><?= $name; ?></h3>
                    <div class="page-assoc">
                        <?php if ($page_assoc) : ?>    
                            Featured On <?= $page_assoc['title']; ?>
                        <?php endif; ?>
                    </div>
                        <a class="edit-<?= $name; ?> btn btn-info" href="<?php echo root_url_private('/galleries/edit.php?id=' . $gallery_id); ?>">
                            Edit
                        </a>
                        <div class="delete-gallery btn btn-danger" data-id="<?= $gallery_id; ?>">Delete</div>
                        <div class="slides mt-2 mb-2">
                            <?php foreach($slides as $slide) : ?>
                                <img src="<?php echo root_url('uploads/' . $slide); ?>" height="50px" width="50px" />
                            <?php endforeach; ?>
                        </div>
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

<?php 

    $site->addPrivateFooter();

?>