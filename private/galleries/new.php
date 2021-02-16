<?php
    
    require('../../initialize.php');

    // echo $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini'

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    if (!$session->is_logged_in()) {
        header( 'location: ../../login.php?timedout=true' );
    }

    $pages = $site->find_all_pages();

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
                    <a href="<?php echo root_url_private('pages/index.php'); ?>" class="button">Pages List</a>
                </li>
                <li>
                    <a href="<?php echo root_url_private('galleries/index.php'); ?>" class="button">Galleries List</a>
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
            <div class="col-12">
                <div class="new-gallery">
                    <form id="new-gallery" method="post">
                        <h2>Create a New Gallery</h2>
                        <dl>
                            <label>Gallery Title</label>
                            <dd>
                                <input type="text" id="gallery_title" name="gallery_title" value="" />
                                <div id="title-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label>Gallery Description</label>
                            <dd>
                                <textarea id="gallery_description" name="gallery_description" cols="30" rows="10"></textarea>
                            </dd>
                        </dl>
                        <dl>
                            <label>What Page to appear on?</label>
                            <dd>
                                <select name="pages" id="page-assoc">
                                <option value="999">None</option>
                                <?php foreach ($pages as $page) : ?>
                                        <option value="<?= ucwords($page['id']); ?>"><?= ucwords($page['page']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="assoc-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label for="files">Upload Images</label>
                                <input type="file" id="gallery_images" name="gallery_images[]" multiple><br><br>
                        </dl>
                        <dl>
                            <input type="checkbox" id="gallery_active" name="gallery_active" value="Boat" />
                            <label>Active</label>
                        </dl>
                        <input type="submit" value="Save Gallery">
                        <div id="form-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include('../includes/footer.php'); ?>