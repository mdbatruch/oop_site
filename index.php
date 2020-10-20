<?php
    
    require('initialize.php');

    // $page = new Page("Welcome to my site!", $db);

    $pages = $site::find_all_pages();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id=1;
    }
    

     //     //Process all pages in one pass
     foreach($pages as $row) {
        //Logic to match the requested page id
        // echo $row['id'];
        if($row['id'] == $id) {
            //Requested Page
            $page = $row['page'];
            $title = $row['title'];
            $subtitle = $row['subtitle'];
            $description = $row['description'];
            
            break;

        }
        // else {
        //     echo 'not working';
        // }

    }


    $page = new Page($title, $description);
    $site->setPage($page);

    //  $page->render_nav();
    // echo '<pre>';
    // print_r($page);

    // try {

    // $stmt = $db->prepare("SELECT id, page, title, subtitle FROM pages");
    // $stmt->execute();
    // $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo '<pre>';
    // print_r($pages);

    // $page_name = basename(__FILE__, '.php');

    // $page_id = '';

    // echo $page_id;

    
    // $nav = array();
        $site->addHeader();

    // } 
    
    // catch(PDOException $e) {
    //     echo "Error: " . $e->getMessage();
    // }

    //  $page->content = $description;

?>
<header class="container">
    <div class="row">
        <div id="navigation">
            <nav class="navbar navbar-expand-sm bg-light">
                <?php $site->addNav(); ?>
            </nav>
        </div>
    </div>
</header>
<main>
    <div class="container">
        <div class="row">
            <p>
                <?php $site->render(); ?>
            </p> 
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>