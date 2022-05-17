<?php
    
    require('../../initialize.php');

    global $session;

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login.php?timedout=true' );
    }

    // echo '<pre>';
    // print_r($pages);

    $id = $_GET['id'];

    $page = $site->find_by_id($id);

    // echo '<pre>';
    // print_r($page);

    $title = 'Edit Page';

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
            <div class="col-12">
                <div class="edit-page">
                    <form id="edit-page" method="post">
                        <h2>Edit '<?= ucfirst($page['page']); ?>'</h2>
                        <dl>
                            <label>Page Name</label>
                            <dd>
                                <input type="text" id="page_name" name="page_name" value="<?= $page['page']; ?>" />
                                <div id="name-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label>Page Title</label>
                            <dd>
                                <input type="text" id="page_title" name="page_title" value="<?= $page['title']; ?>" />
                                <div id="title-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label>Page Subtitle</label>
                            <dd>
                                <input type="text" id="page_subtitle" name="page_subtitle" value="<?= $page['subtitle']; ?>"/>
                                <div id="subtitle-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label>Page Description</label>
                            <dd>
                                <textarea id="page_description" name="page_description" cols="30" rows="10" ><?= htmlentities($page['description']); ?></textarea>
                                <div id="description-warning"></div>
                            </dd>
                        </dl>
                        <input type="hidden" id="page_id" name="page_id" value="<?= $page['id']; ?>"/>
                        <div class="d-flex justify-content-between mb-4">
                            <input type="submit" value="Save Page">
                            <a href="<?= root_url('index.php?id=' .  $id . ''); ?>" class="btn btn-black">View Page</a>
                        </div>
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