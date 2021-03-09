<?php
    
    require('initialize.php');

    $site->addHeader();

    $product = new Product($db);

    $chosen = $product->readOne($_GET['id']);

    $cart_item = new CartItem($db);

    if (isset($_SESSION['id'])) {
        $items = $cart_item->get_cart($_SESSION['id']);
        $cart_id = $cart_item->get_cart_id($_SESSION['id'], $items['id']);
    }

    // print_r($chosen);

    // $price = settype($chosen['price'], "integer");
?>
<header>
    <div class="container-fluid">
    <div id="cart_id" style="display: none;"><?= $items['id']; ?></div>
        <div class="row">
            <div id="<?= $_SESSION['id']; ?>" class="customer">
            <?php if (isset($_SESSION['account'])) : ?>
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
            <div id="product-info" data-id="<?= $chosen['id']; ?>" class='col-md-4 m-b-20px product-info'>
                <div id="name"><?= $chosen['name']; ?></div>
                <div id="description"><?= $chosen['description']; ?></div>
                <div id="price"><?= "$" . number_format($chosen['price'], 2, '.', ','); ?></div>
                <div class="count">
                Quantity
                    <select name="" id="quantity">
                        <?php for ($i = 0; $i < 11; $i++) : ?>
                            <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <div id="add-cart" data-id="<?= $chosen['id']; ?>" class='btn btn-primary w-100-pct add-cart'>Add to Cart</div>
            <div id="cart-message"></div>
        </div>
    </div>
</main>
<footer class="container">
    <div class="row">
        <?php $site->addFooter(); ?>
    </div>
</footer>