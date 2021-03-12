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

?>
<header>
    <div class="container-fluid">
        <div class="row">
            <?php
                include('components/header-cart.php'); 
            ?>
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