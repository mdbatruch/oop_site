<div id="cart_id" style="display: none;"><?= $items['id']; ?></div>
    <div class="customer col-md-3" id="<?= $_SESSION['id']; ?>">
    <?php if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer') : ?>
        <div class="account-name">
            <a href="<?= root_url_private('customer/index.php'); ?>">
                View Your Account,
                <?= $_SESSION['username']; ?>
            </a>
        </div>
    <?php else :?>
        <div class="col">
            <a href="customer.php">
                Sign In/Register
            </a>
        </div>
    <?php endif; ?>
    </div>
    <div class="col-md-8 cart">
        <a href="cart.php">
            Cart <span class="cart-count"><?= '(' . $count . ')' ?></span>
        </a>
    </div>
    <?php if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer') : ?>
    <div class="col-md-1 logout">
        <a href="<?php echo root_url('logout.php'); ?>" class="button">Logout</a>
    </div>
    <?php endif; ?>
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