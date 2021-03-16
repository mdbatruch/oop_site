<?php
    
    require('initialize.php');

    // $page = new Page("Welcome to my site!", $db);

    $pages = $site->find_all_pages();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id=1;
    }

    if ($_GET['id'] == 0 || $_GET['id'] == null) {
        header('Location: index.php?id=1');
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


    $page = new Page($title, $description, $db);
    $site->setPage($page);

    $gallery = $site->findSliderByPageId($id);

    if (!empty($_SESSION) && $_SESSION['account'] !== 'Administrator') {

        $cart_item = new CartItem($db);

        if (isset($_SESSION['id'])) {
            $items = $cart_item->get_cart($_SESSION['id']);
            $cart_id = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
        }

        $count = $cart_item->getCartCount($items['id'], $_SESSION['id']);

    } else {
        $count = 0;
        $items = null;
    }

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

    // $cart_item = new CartItem($db);
    // echo '<pre>';
    // print_r($_SESSION);
    // $count = $cart_item->getCartCount(2, $_SESSION['id']);

    // echo '<pre>';
    // print_r($count);

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $db); ?>
        </div>
    </div>
</header>
<main>
<div class="container-fluid">
        <div class="row">
        <?php if ($gallery) :?>
                <?= $site->addSlider(); ?>
        <?php endif; ?>
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