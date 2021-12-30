<?php
    
    require('initialize.php');

    $site->addHeader();

    $search = new Search($db);

        try {
          
            if ($_GET['q'] === '') {
                $query = ['No Results!'];
            } else {
                $query = $search->search_term($_GET['q']);
            }

            // echo '<pre>';
            // print_r($query);


        } catch (PDOException $e) {

          echo $e->getMessage();

      }

      if (!empty($_SESSION)) {

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

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php $site->addCartHeader($site, $count, $items, $subtotal, $db); ?>
        </div>
    </div>
</header>
<main>
<div class="container-fluid">
        <div class="row">
            <p>
                <h1>Search results</h1>
                <div class="col-12">
                    <?php 
                        // if ($_GET['q'] === '') {
                            $search->render($query);
                        // } else {

                        // }
                    
                    ?>
                </div>
            </p> 
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>