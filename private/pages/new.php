<?php
    
    require('../../initialize.php');

    // echo $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . '/.env/db.ini'

    global $session;
    // // echo '<pre>';
    // // print_r($session);

    if (!$session->is_logged_in_as_admin($_SESSION['account'])) {
        header( 'location: ../../login.php?timedout=true' );
    }

    // echo '<pre>';
    // print_r($pages);

    $title = 'Add New Page';

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
                <div class="new-page">
                    <form id="new-page" method="post">
                        <h2>Create a New Page</h2>
                        <dl>
                            <label>Page Name</label>
                            <dd>
                                <input type="text" id="page_name" name="page_name" value="" />
                                <div id="name-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label>Page Title</label>
                            <dd>
                                <input type="text" id="page_title" name="page_title" value="" />
                                <div id="title-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label>Page Subtitle</label>
                            <dd>
                                <input type="text" id="page_subtitle" name="page_subtitle" />
                                <div id="link-warning"></div>
                            </dd>
                        </dl>
                        <dl>
                            <label>Page Description</label>
                            <dd>
                                <textarea id="page_description" name="page_description" cols="30" rows="10"></textarea>
                                <div id="description-warning"></div>
                            </dd>
                        </dl>
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