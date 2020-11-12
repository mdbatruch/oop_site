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
            <div id="navigation" style="width: 100%;">
                <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <?php $site->addNav(); ?>
                </div>
                <form id="search" class="form-inline my-2 my-lg-0" method="GET">
                    <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
                    <input class="search-term form-control mr-sm-2" type="search" name="q" value="<?php echo htmlspecialchars($q); ?>" placeholder="Search">
                    <button class="btn my-2 my-sm-0 btn-outline-secondary" type="submit">Search</button>
                </form>
                </nav>
            </div>
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