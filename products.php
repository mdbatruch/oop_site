<?php
    
    require('initialize.php');

    $site->addHeader();

    $product = new Product($db);

    $count = $product->count();

    // print_r($count);
    $stmt = $product->read(0, $count);

    $cart_item = new CartItem($db);

    if (isset($_SESSION['id'])) {
        $items = $cart_item->get_cart($_SESSION['id']);
        $products = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
    }

    // $num = $stmt->rowCount();
 

    // echo '<pre>';
    // print_r($products);

?>
<header>
    <div class="container-fluid">
        <div class="row">
        <div id="cart_id" style="display: none;"><?= $items['id']; ?></div>
            <div id="<?= $_SESSION['id']; ?>" class="customer">
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
            <div class="cart">
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
            <div class="col-12">
                Products Page
            </div>
            <p>
            <?php 
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
                    extract($row);

                    ?>
                
                    <div class='col-md-4 m-b-20px'>
                
                        <!-- // product id for javascript access -->
                        <div class='product-id'><?= "{$id}" ?></div>
                
                        <a href='product.php?id=<?= $id ?>' class='product-link'>
                        <!-- //     // select and show first product image -->
                        <!-- //     // $product_image->product_id=$id;
                        //     // $stmt_product_image=$product_image->readFirst(); -->
                
                        <!-- //     while ($row_product_image = $stmt_product_image->fetch(PDO::FETCH_ASSOC)){
                        //         echo "<div class='m-b-10px'>";
                        //             echo "<img src='uploads/images/{$row_product_image['name']}' class='w-100-pct' />";
                        //         echo "</div> -->
                
                            <div class='product-name m-b-10px'>
                                <?= "{$name}"  ?>
                            </div>
                        </a>
                
                        <div class='m-b-10px description'>
                            <?= "{$description}"; ?>
                        </div>

                        <div class='m-b-10px'>
                           <?= "$" . number_format($price, 2, '.', ','); ?>
                        </div>
            
                    
                        <div class='m-b-10px'>
                            <!-- // cart item settings
                            // $cart_item->user_id=1; // we default to a user with ID "1" for now
                            // $cart_item->product_id=$id; -->
            
                            <!-- // if product was already added in the cart
                            // if($cart_item->exists()){ -->
                            <!-- <a href='cart.php' class='btn btn-success w-100-pct'> -->
                                    <!-- Update Cart -->
                            <!-- </a> -->
                            <div id="add-cart" data-id="<?= $id ?>" class='btn btn-primary w-100-pct add-cart'>Add to Cart</div>
                            <div id="cart-message-<?= $id; ?>"></div>
                        </div>
                    </div>
                
          <?php 
          // include_once "paging.php";
            endwhile;    ?>
            </p>
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>