<?php
    
    require('initialize.php');

    // $page = new Page("Welcome to my site!", $db);

    $pages = $site->find_all_pages();

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


    $page = new Page($title, $description, $db);
    $site->setPage($page);

    $gallery = $site->findSliderByPageId($id);

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
<header>
    <div class="container-fluid">
        <div class="row">
            <div class="customer">
            <?php if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer') : ?>
                <a href="<?= root_url_private('customer/index.php'); ?>">
                    View Your Account,
                    <?= $_SESSION['username']; ?>
                </a>
            <?php else :?>
                <a href="customer.php">
                    Sign In/Register
                </a>
            <?php endif; ?>
            </div>
            <div class="cart <?= $page_title=="Cart" ? "class='active'" : ""; ?>">
                <a href="cart.php">
                    <!--later, we'll put a PHP code here that will count items in the cart -->
                    Cart <span class="badge" id="comparison-count">0</span>
                </a>
            </div>
            <div id="navigation" style="width: 100%;">
                <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <?php $site->addNav(); ?>
                </div>
                <form id="search" action="search.php" method="GET" class="form-inline my-2 my-lg-0">
                    <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
                    <input id="type-search" class="search-term form-control mr-sm-2" type="search" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search">
                    <button class="btn my-2 my-sm-0 btn-outline-secondary" type="submit">Search</button>
                </form>
                <div id="display"></div>
                </nav>
            </div>
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