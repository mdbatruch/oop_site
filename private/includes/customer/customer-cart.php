<div class="row-first pt-2 pb-2">
    <div class="container">
        <div class="row">
            <div class="col-6 d-flex align-items-center">
                <a href="<?= root_url('terms'); ?>" class="shop-faq">
                    Terms of Service
                </a>    
            </div>
            <div id="cart_id" style="display: none;">
                <?= isset($_SESSION['account']) ? $items['id'] : null; ?>
            </div>
            <div class="col-6 <?= (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer') ? 'logged-in-customer col-md-4' : ''; ?> d-flex justify-content-end align-items-center customer" id="<?= isset($_SESSION['account']) ? $_SESSION['id'] : 'no-customer' ; ?>">
                <?php
                if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer') : ?>
                    <div class="account-name">
                        <img src="<?= root_url('uploads/' . $_SESSION['avatar'] ?? 'empty.png'); ?>" alt="<?= $_SESSION['username']; ?> Picture" class="img-fluid me-2">
                        <a href="<?= root_url_private('customer/index.php'); ?>"> 
                            <?= $_SESSION['username']; ?>
                        </a>
                    </div>
                <?php else :?>
                    <div class="col pr-0 sign-in">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        </svg> 
                        <a href="customer.php">
                        Login / Register
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (isset($_SESSION['account']) && $_SESSION['account'] == 'Customer') : ?>
                <div class="col-6 col-md-2 d-flex align-items-center justify-content-end logout">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
                        <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                        <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117zM11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5zM4 1.934V15h6V1.077l-6 .857z"/>
                    </svg>
                    <a href="<?php echo root_url('logout.php'); ?>" class="button ms-2">Logout</a>
                </div>
            <?php endif; ?>
            <div class="col-12">
                <?php $site->addCustomerItemRemoval(); ?>
            </div>
        </div>
    </div>
</div>
<div class="row-second bg-white">
    <div class="container d-flex">
        <div class="nav-container">
            <div id="navigation" class="d-flex h-100" style="width: 100%;">
                <nav class="navbar navbar-expand-lg navbar-light bg-white pl-0">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <div id="nav-icon2">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <div class="close-button justify-content-end">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <?php $site->addCustomerNav(); ?>
                    </div>
                </nav>
            </div>
        </div>
        <div class="pt-2 pb-2 logo-container d-flex justify-content-center">
            <img src="<?= root_url('images/CastleGames.png'); ?>" alt="Castle Games" class="img-fluid">
        </div>
        <div class="d-flex justify-content-end align-self-center cart">
            <div class="d-flex h-100">
                <a href="<?= root_url('cart.php'); ?>" class="cart-toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l1.25 5h8.22l1.25-5H3.14zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
                </svg> 
                <span class="cart-count"><?= $count; ?></span> <span class="text">/ $ </span><span class="cart-total"><?= isset($subtotal) ? $subtotal : '$0.00'; ?></span> <span class="text">CAD</span>
                </a>
            </div>
        </div>
        <div class="cart-menu-container">
            <?php $site->addCustomerCartMenu($db); ?>
        </div>
    </div>
</div>