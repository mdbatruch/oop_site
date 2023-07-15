<?php
    
    require('../../initialize.php');

    global $session;

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login?timedout=true' );
    }

    $id = $_GET['id'];

    $gallery = $site->find_by_id($id);

    $title = 'Edit Gallery';

    $site->addPrivateHeader($title);

    $pages = $site->find_all_pages();

    $gallery = $site->findSliderById($_GET['id']);

    $slides = json_decode($gallery['slides']);
    
?>
<header id="admin-header" class="container-fluid">
    <div class="row">
        <?= $site->addPrivateAdminNav($title); ?>
    </div>
</header>
<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="edit-gallery">
                    <form id="edit-gallery" method="post">
                        <h2>Edit Gallery</h2>
                        <dl>
                            <label>Gallery Title</label>
                            <dd>
                                <input type="text" id="gallery_title" name="page_title" value="<?= $gallery['title']; ?>" />
                                <div id="title-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label>Gallery Description</label>
                            <dd>
                                <textarea id="gallery_description" name="gallery_description" cols="30" rows="10"><?= $gallery['description']; ?></textarea>
                            </dd>
                        </dl>
                        <dl>
                            <label>What Page to appear on?</label>
                            <dd>
                                <select name="pages" id="page-assoc">
                                <option value="999">None</option>
                                <?php foreach ($pages as $page) : ?>
                                        <option value="<?= ucwords($page['id']); ?>"  <?php if ($page['id'] == $gallery['page_id']) { echo 'selected'; } ?> ><?= ucwords($page['page']); ?></option>
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
                            <label for="images">Current Images</label>
                            <?php foreach($slides as $slide) : ?>
                                <div class="img-container" style="display: inline-block;">
                                    <img class="current-image" style="display: block;" src="<?php echo root_url('uploads/' . $slide); ?>" data-name="<?= $slide; ?>" height="50px" width="50px" />
                                    <button type="button" class="remove-slide">Delete</button>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                        <dl>
                            <input type="checkbox" id="gallery_active" name="gallery_active" <?php if ($gallery['active']) echo 'checked'; ?> />
                            <label>Active</label>
                        </dl>
                        <input type="hidden" id="gallery_id" name="gallery_id" value="<?= $_GET['id']; ?>"/>
                        <input type="submit" value="Save Page">
                        <div id="form-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php 

    $site->addPrivateFooter();

?>